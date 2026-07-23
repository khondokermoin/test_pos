import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function CompanySidebar() {
  const { url } = usePage();

  const menu = [
    {
      title: 'Company Admin',
      items: [
        { name: 'Dashboard', href: '/company/dashboard', icon: 'uil-home-alt' },
        { name: 'Branches', href: '/company/branches', icon: 'uil-code-branch' },
        { name: 'Products & Catalog', href: '/company/products', icon: 'uil-box' },
        { name: 'Product Categories', href: '/company/categories', icon: 'uil-list-ui-alt' },
        { name: 'Low Stock Items', href: '/company/inventory/low-stock', icon: 'uil-exclamation-triangle' },
        { name: 'Stock Adjustments', href: '/company/inventory/stock_adjust', icon: 'uil-archive' },
        { name: 'Purchases', href: '/company/purchases', icon: 'uil-shopping-bag' },
        { name: 'Sales Records', href: '/company/sales', icon: 'uil-shopping-cart' },
        { name: 'Users & Staff', href: '/company/users', icon: 'uil-users-alt' },
        { name: 'Daily Sales Report', href: '/company/reports/daily-sales', icon: 'uil-chart' },
        { name: 'Stock Report', href: '/company/reports/stock', icon: 'uil-analytics' },
        { name: 'Subscription', href: '/company/subscription', icon: 'uil-credit-card' },
        { name: 'Company Settings', href: '/company/settings/profile', icon: 'uil-cog' },
      ],
    },
  ];

  return (
    <ul className="side-nav">
      {menu.map((group, gIdx) => (
        <React.Fragment key={gIdx}>
          <li className="side-nav-title side-nav-item">{group.title}</li>
          {group.items.map((item) => {
            const isActive = url === item.href || (item.href !== '/' && url.startsWith(item.href));
            return (
              <li key={item.name} className={`side-nav-item ${isActive ? 'menuitem-active' : ''}`}>
                <Link
                  href={item.href}
                  className={`side-nav-link ${isActive ? 'active' : ''}`}
                >
                  <i className={`${item.icon} me-2`}></i>
                  <span> {item.name} </span>
                </Link>
              </li>
            );
          })}
        </React.Fragment>
      ))}
    </ul>
  );
}
