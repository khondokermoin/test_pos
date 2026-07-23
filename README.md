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

# 📌 About The Project

The **Advanced Cloud POS & Inventory SaaS System** is a robust, enterprise-grade Multi-Tenant Point of Sale (POS) and Inventory Management web application built for modern retail businesses, chain stores, supermarkets, and wholesale distributors.

It features a high-performance backend powered by **Laravel 12** and a modern single-page application (SPA) frontend powered by **React.js** and **Inertia.js**, styled with **Tailwind CSS** and professional admin templates.

---

# ✨ Key Features & Modules

## 👑 1. Super Admin Panel

- SaaS Company Management
- Subscription & Package Management
- Tenant Approval & Suspension
- Global Revenue Analytics
- Platform Usage Statistics
- System Settings

## 🏢 2. Company Admin Panel

- Multi Branch Management
- Staff & Role Management (RBAC)
- Product Catalog Management
- Categories & Brands
- Product Variants
- Inventory Transfers
- Sales Reports
- Profit/Loss Reports
- Stock Audit Reports

## 📦 3. Branch & POS Terminal

- Lightning-Fast POS Interface
- Barcode Scanner Support
- Cart Management
- Discount & Tax Calculation
- Multi-Payment Support
- Due/Credit Sales
- Thermal Receipt Printing
- Invoice Printing
- Opening & Closing Shift
- Branch Inventory Tracking

---

# 🛠️ Tech Stack

| Layer | Technology |
|--------|------------|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | React 19, Inertia.js v3, Vite |
| UI | Tailwind CSS, Bootstrap Admin Templates |
| Database | MySQL / PostgreSQL |
| Authentication | Laravel Breeze / Fortify |
| Authorization | RBAC |
| Multi-Tenancy | Tenant Isolation Middleware |

---

# ⚙️ Installation

## 1. Clone Repository

```bash
git clone https://github.com/your-username/cloud-pos-inventory.git
cd cloud-pos-inventory
```

## 2. Install PHP Dependencies

```bash
composer install
```

## 3. Install JavaScript Dependencies

```bash
npm install
```

## 4. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with your database credentials.

## 5. Run Database Migration

```bash
php artisan migrate --seed
```

## 6. Start Development Server

### Terminal 1

```bash
php artisan serve
```

### Terminal 2

```bash
npm run dev
```

Open:

```
http://127.0.0.1:8000
```

---

# 🔒 Security & Multi-Tenancy

The application implements strict tenant isolation using middleware including:

- EnsureTenantAccess
- CheckSubscriptionActive

Each company's data is completely isolated, ensuring users can only access authorized company and branch resources.

---

# 📄 License

This project is licensed under the **MIT License**.
