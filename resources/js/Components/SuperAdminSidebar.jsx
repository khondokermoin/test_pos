import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function SuperAdminSidebar() {
  const { url } = usePage();

  const menu = [
    {
      title: 'Navigation',
      items: [
        { name: 'Dashboard', href: '/superadmin/dashboard', icon: 'uil-home-alt' },
        { name: 'Companies (Tenants)', href: '/superadmin/companies', icon: 'uil-building' },
        { name: 'Subscription Plans', href: '/superadmin/plans', icon: 'uil-credit-card' },
        { name: 'Subscriptions', href: '/superadmin/subscriptions', icon: 'uil-receipt' },
        { name: 'Addon Marketplace', href: '/superadmin/addons', icon: 'uil-store' },
        { name: 'Business Types', href: '/superadmin/business-types', icon: 'uil-apps' },
        { name: 'Users & Staff', href: '/superadmin/users', icon: 'uil-users-alt' },
        { name: 'Roles & Permissions', href: '/superadmin/roles', icon: 'uil-shield-check' },
        { name: 'Reports & Analytics', href: '/superadmin/reports', icon: 'uil-chart-line' },
        { name: 'System Logs', href: '/superadmin/system/logs', icon: 'uil-file-text' },
        { name: 'System Settings', href: '/superadmin/settings/general', icon: 'uil-cog' },
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
