# Central Admin Laravel Application

## Overview
The **Central Admin Laravel Application** is the core system that manages multiple supermarkets in a hypermarket network. It is responsible for:
- Managing supermarkets, locations, suppliers, products, and categories.
- Receiving **income reports** from supermarkets.
- Handling **stock alerts** and triggering a **supply process**.
- Finding the **nearest supermarket** before ordering from a supplier.
- Sending and receiving **TCP messages** for supermarket communication.
- Implementing **error handling and retry logic** for failed TCP requests.

---

## Features
### 🛠️ **Core Functionalities**
- **Admin Authentication**: Only one admin user can manage the system.
- **Supermarket Management**: Create, update, and delete supermarkets.
- **Supplier Management**: Track suppliers and their products.
- **Stock Transfer System**: Finds the nearest supermarket to fulfill stock shortages.
- **Supplier Ordering**: If no supermarket has stock, orders are placed automatically.
- **Real-time TCP Communication**: Receives stock alerts and income reports.
- **Automatic Retries**: Retries failed TCP requests with exponential backoff.

### 📡 **TCP Communication**
The Central Admin App communicates with supermarkets via TCP:
- **Receives Income Reports** from supermarkets.
- **Receives Stock Alerts** when a product is running low.
- **Finds the nearest supermarket** and sends a stock transfer request.
- **Handles Supplier Orders** if no supermarket has stock.
- **Retries TCP Requests** if they fail.

---

## Installation
### 1️⃣ **Clone the Repository**
```sh
git clone https://github.com/your-repo/central-admin.git
cd central-admin
```

### 2️⃣ **Install Dependencies**
```sh
composer install
npm install
```

### 3️⃣ **Configure Environment**
Create a `.env` file and set up the database and server details:
```sh
cp .env.example .env
php artisan key:generate
```

Update the database settings in `.env`:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=central_admin
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### 4️⃣ **Run Migrations & Seeders**
```sh
php artisan migrate --seed
```
This will create tables for **supermarkets, suppliers, products, locations, stock alerts, and income reports**.

### 5️⃣ **Start the TCP Server**
```sh
php artisan tcp:listen
```
This will start the TCP server that listens for income reports and stock alerts from supermarkets.

### 6️⃣ **Run the Laravel Queue Worker**
```sh
php artisan queue:work
```
This ensures background jobs (e.g., TCP retries) are processed.

---

## API Endpoints
| Method | Endpoint | Description |
|--------|----------|-------------|
| `POST` | `/api/admin/login` | Logs in the admin and returns a token |
| `GET`  | `/api/supermarkets` | Retrieves all supermarkets |
| `POST` | `/api/supermarkets` | Creates a new supermarket |
| `GET`  | `/api/locations` | Retrieves all locations |
| `POST` | `/api/products` | Adds a new product |
| `POST` | `/api/suppliers` | Adds a new supplier |

---

## TCP Communication Flow
1. **Supermarket Sends an Income Report**
   - Central Admin receives the report and stores it.
2. **Supermarket Sends a Stock Alert**
   - Central Admin finds the nearest supermarket with stock.
   - Sends a **Stock Transfer Request** to the nearest supermarket.
3. **Sender Supermarket Responds**
   - If accepted, stock is transferred.
   - If no stock is available, an order is placed with the supplier.
4. **Retries on Failure**
   - If the TCP request fails, it is retried **up to 3 times** with exponential backoff.

---

## Error Handling & Logging
- **TCP Errors**: Failed requests are logged in `storage/logs/laravel.log`.
- **Retries**: If a TCP request fails, the system retries with increasing delays.
- **Queue System**: All critical TCP requests run in the background to prevent crashes.



