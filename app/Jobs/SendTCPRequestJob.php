<?php

namespace App\Jobs;

use App\Services\TCPClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTCPRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $host, $port, $data;

    public function __construct($host, $port, $data)
    {
        $this->host = $host;
        $this->port = $port;
        $this->data = $data;
    }

    public function handle()
    {
        Log::info("Queueing TCP request to {$this->host}:{$this->port}");
        TCPClient::sendTCPRequest($this->host, $this->port, $this->data);
    }
}
