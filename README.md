# 🎫 Ticket Management System

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-blue.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-purple.svg)

A complete support ticketing system with role-based access control (Admin, Staff, User), ticket assignment, and email notifications.

## 🚀 Quick Start

```bash
# Clone repository
git clone https://github.com/Hamzaqureshi401/ticket-system
cd ticket-system

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database (edit .env)
nano .env

# Run migrations
php artisan migrate --seed

# Start server (http://localhost:8000)
php artisan serve

# Run queue worker (in new terminal)
php artisan queue:work