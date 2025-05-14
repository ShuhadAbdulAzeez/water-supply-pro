# Water Supply ERP System

A comprehensive ERP system designed for water supply companies, built with Laravel. This system helps manage truck staff billing, empty bottle management, and inventory tracking.

## Features

### 1. Truck Staff Billing System
- On-the-spot bill generation using portable USB printers
- Multiple payment methods (Cash, Card, Credit)
- Real-time inventory updates
- Customer credit management

### 2. Empty Bottle Management
- Track bottle status (filled, empty, damaged)
- Monitor bottle movement between trucks and customers
- Record bottle return and collection
- Damage reporting system

### 3. Inventory Management
- Real-time inventory tracking per truck
- Daily inventory reports
- Bottle status monitoring
- Inventory alerts and notifications

## Requirements

- PHP >= 8.1
- MySQL >= 5.7
- Composer
- Node.js & NPM (for frontend assets)
- USB Thermal Printer (for on-the-spot billing)

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd water-supply-erp
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install frontend dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=water_erp
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations:
```bash
php artisan migrate
```

8. Start the development server:
```bash
php artisan serve
```

## Usage

### Truck Staff Billing
1. Log in to the system
2. Navigate to "Create Bill"
3. Select customer, staff member, and truck
4. Enter bottles delivered and empty bottles collected
5. Choose payment method
6. Generate and print bill

### Empty Bottle Management
1. Track bottle status in the bottles section
2. Record bottle returns in the billing system
3. Mark damaged bottles for replacement
4. Monitor bottle movement history

### Inventory Management
1. View real-time inventory per truck
2. Generate daily inventory reports
3. Track bottle status across the system
4. Monitor inventory levels and alerts

## Security

- All sensitive data is encrypted
- Role-based access control
- Secure payment processing
- Regular security updates

## Support

For support, please contact [support@example.com](mailto:support@example.com)

## License

This project is licensed under the MIT License - see the LICENSE file for details.
