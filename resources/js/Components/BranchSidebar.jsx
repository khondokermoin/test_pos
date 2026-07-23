import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function BranchSidebar() {
  const { url } = usePage();

  const menu = [
    {
      title: 'Branch Terminal',
      items: [
        { name: 'POS Terminal', href: '/branch/pos', icon: 'uil-calculator' },
        { name: 'Branch Dashboard', href: '/branch/dashboard', icon: 'uil-home-alt' },
        { name: 'Inventory Receive & Sort', href: '/branch/inventory/receive-sort', icon: 'uil-sort' },
        { name: 'Sorting History', href: '/branch/inventory/sorting-history', icon: 'uil-history' },
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
