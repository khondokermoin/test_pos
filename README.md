<p align="center">
  <h1 align="center">🚀 Advanced Cloud POS & Inventory SaaS System</h1>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/React.js-19.x-blue?style=for-the-badge&logo=react" alt="React">
  <img src="https://img.shields.io/badge/Inertia.js-v3-purple?style=for-the-badge&logo=inertia" alt="Inertia.js">
  <img src="https://img.shields.io/badge/TailwindCSS-UI-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

---

## 📌 About The Project

The **Advanced Cloud POS & Inventory SaaS System** is a robust, enterprise-grade Multi-Tenant Point of Sale and Inventory Management web application built for modern retail businesses, chains, and wholesale distributors. 

It features a high-performance backend powered by **Laravel 12** and a dynamic, single-page application (SPA) frontend powered by **React.js & Inertia.js**, styled meticulously using professional Bootstrap/Tailwind admin templates.

---

## ✨ Key Features & Modules

### 👑 1. Super Admin Panel
* **SaaS Company Management:** Register, approve, suspend, or manage tenant companies and their subscription plans.
* **Global Analytics:** System-wide revenue, active subscriptions, and platform usage statistics.
* **Global Settings:** System configurations, business types, and package management.

### 🏢 2. Company Admin Panel
* **Branch Management:** Create and manage multiple retail/warehouse branches under a single company.
* **Staff & Role Management:** Assign roles (Company Admin, Branch Manager, Salesman) with strict permission controls.
* **Centralized Inventory & Products:** Manage global product catalogs, categories, brands, variants, and bulk stock transfers.
* **Financial & Sales Reports:** Comprehensive profit/loss, daily sales, and stock audit reports.

### 📦 3. Branch & POS Terminal
* **Lightning-Fast POS Interface:** Optimized barcode scanning, cart management, instant discounts, and tax calculations.
* **Checkout & Multi-Payment:** Support for cash, card, mobile banking, and due/credit sales.
* **Professional Invoicing:** Instant thermal receipt and standard invoice printing.
* **Stock & Shift Management:** Daily opening/closing cash drawer balances and branch-level inventory tracking.

---

## 🛠️ Tech Stack

* **Backend:** PHP 8.2+, Laravel 12 Framework, Eloquent ORM
* **Frontend:** React.js 19, Inertia.js v3, Vite
* **UI/UX:** Bootstrap Admin Templates, Tailwind CSS, Lucide / Tabler Icons
* **Database:** MySQL / PostgreSQL
* **Authentication & Security:** Laravel Fortify/Breeze, Role-Based Access Control (RBAC), Tenant Isolation Middleware

---

## ⚙️ Getting Started (Installation Guide)

To get a local copy up and running, follow these simple steps:

### 1. Clone the Repository
```bash
git clone [https://github.com/your-username/cloud-pos-inventory.git](https://github.com/your-username/cloud-pos-inventory.git)
cd cloud-pos-inventory


2. Install PHP Dependencies
Bash
composer install
3. Install JavaScript Dependencies
Bash
npm install
4. Environment Setup
Copy the example environment file and configure your database credentials:

Bash
cp .env.example .env
php artisan key:generate
5. Run Database Migrations & Seeders
Bash
php artisan migrate --seed
6. Build Frontend Assets & Run Development Servers
Open two separate terminal tabs:

Tab 1 (Larael Server):

Bash
php artisan serve
Tab 2 (Vite Dev Server):

Bash
npm run dev
Now, open your browser and visit: http://127.0.0.1:8000

🔒 Security & Multi-Tenancy Architecture
This system implements strict middleware-based data isolation (EnsureTenantAccess and CheckSubscriptionActive) ensuring that users can only access data belonging to their authorized company and branch.

📄 License
This project is open-sourced software licensed under the MIT license.