<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\TCPClient;
use App\Models\Supermarket;
use App\Models\Product;
use App\Models\SupplierOrder;

class TCPServer extends Command
{
    protected $signature = 'tcp:listen';
    protected $description = 'Start a TCP server to receive income reports and stock alerts';

    public function handle()
    {
        $host = "0.0.0.0";
        $port = 9000;

        $server = stream_socket_server("tcp://$host:$port", $errno, $errstr);
        if (!$server) {
            $this->error("TCP Server Error: $errstr ($errno)");
            return;
        }

        $this->info("TCP Server is running on port $port...");

        while ($client = stream_socket_accept($server)) {
            $data = fread($client, 1024);
            $request = json_decode($data, true);

            if (!$request || !isset($request['action'])) {
                fwrite($client, json_encode(['error' => 'Invalid request']));
                fclose($client);
                continue;
            }

            if ($request['action'] === 'send_income_report') {
                $this->handleIncomeReport($request);
                $response = ['status' => 'Income report received'];
            } elseif ($request['action'] === 'send_stock_alert') {
                $this->handleStockAlert($request);
                $response = ['status' => 'Stock alert processed'];
            } else {
                $response = ['error' => 'Unknown action'];
            }

            fwrite($client, json_encode($response));
            fclose($client);
        }

        fclose($server);
    }

    private function handleIncomeReport($request)
    {
        DB::table('income_reports')->insert([
            'supermarket_id' => $request['supermarket_id'],
            'date' => $request['date'],
            'total_income' => $request['total_income'],
            'created_at' => now(),
        ]);

        Log::info("Income report received from Supermarket ID: {$request['supermarket_id']} | Date: {$request['date']} | Total Income: {$request['total_income']}");
    }

    private function handleStockAlert($request)
    {
        $supermarket_id = $request['supermarket_id'];
        $product_id = $request['product_id'];
        $current_stock = $request['current_stock'];
        $threshold = $request['threshold'];

        Log::warning("Stock alert from Supermarket ID: $supermarket_id | Product ID: $product_id | Current Stock: $current_stock | Threshold: $threshold");

        $nearest = $this->findNearestSupermarketOrSupplier($product_id, $supermarket_id);

        if ($nearest && $nearest['type'] === 'supermarket') {
            Log::info("Requesting stock transfer from Supermarket ID: {$nearest['id']} to Supermarket ID: $supermarket_id");
            TCPClient::sendTCPRequest($nearest['ip_address'], 9000, [
                'action' => 'stock_transfer_request',
                'receiver_supermarket_id' => $supermarket_id,
                'product_id' => $product_id,
                'quantity' => 10
            ]);
        } else {
            Log::info("No supermarket found. Ordering from supplier...");
            SupplierOrder::create([
                'product_id' => $product_id,
                'supermarket_id' => $supermarket_id,
                'quantity' => ($threshold * 2),
                'status' => 'pending',
            ]);
        }
    }
}
