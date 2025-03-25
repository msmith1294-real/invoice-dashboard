# Invoice Dashboard

A Laravel and Livewire dashboard for tracking and managing invoice statuses, aggregating data for overdue and pending invoices, and offering detailed insights into individual invoices.

## Features
- High-level aggregation of invoice data: overdue amounts, pending approval
- Breakdown of overdue invoices by time period (0-30 days, 31-60 days, etc.)
- Display of top three pending invoices by amount
- Interactive invoice listing with filtering based on selected aggregations
- Built with Laravel and Livewire for dynamic front-end interaction

## Technologies Used
- Laravel (PHP Framework)
- Livewire (Dynamic front-end)
- Nginx (Web Server)
- MySQL (Database)
- Laravel Herd (Local development environment)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/msmith1294-real/invoice-dashboard.git
   cd invoice-dashboard

2. Install dependencies:
   ```bash
   composer install

3. Set up your .env file:
   ```bash
   cp .env.example .env

4. Generate the application key:
   ```bash
   php artisan key:generate

5. Set up your database and run migrations:
   ```bash
   php artisan migrate

6. Seed your database:
   ```bash
   php artisan db:seed

7. Install frontend dependencies:
   ```bash
   npm install
   npm run dev

8. Run the local server using Laravel Herd:
   ```bash
   laravel herd start
   ```
   
   Or configure Nginx in your environment.
  
## Usage
- The dashboard will display high-level invoice data, and you can filter by time period or other aggregations.
- Click on any high-level category (overdue, pending approval) to filter the invoice listing below.
