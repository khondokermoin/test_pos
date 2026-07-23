import React from "react";
import { Link, usePage } from "@inertiajs/react";

/**
 * CompanySidebar — matches templates/index.html side-nav structure exactly.
 * Icons: Tabler Icons (ti ti-*) — loaded via icons.min.css
 */
export default function CompanySidebar() {
    const { url } = usePage();

    const isActive = (href) =>
        url === href || (href !== "/" && url.startsWith(href));

    const navGroups = [
        {
            title: "Company Admin",
            items: [
                {
                    name: "Dashboard",
                    href: "/company/dashboard",
                    icon: "ti ti-dashboard",
                },
                {
                    name: "Branches",
                    href: "/company/branches",
                    icon: "ti ti-building-store",
                },
                {
                    name: "Products & Catalog",
                    href: "/company/products",
                    icon: "ti ti-box",
                },
                {
                    name: "Categories",
                    href: "/company/categories",
                    icon: "ti ti-list",
                },
            ],
        },
        {
            title: "Inventory",
            items: [
                {
                    name: "Low Stock Items",
                    href: "/company/inventory/low-stock",
                    icon: "ti ti-alert-triangle",
                },
                {
                    name: "Stock Adjustments",
                    href: "/company/inventory/stock-adjust",
                    icon: "ti ti-adjustments",
                },
                {
                    name: "Purchases",
                    href: "/company/purchases",
                    icon: "ti ti-shopping-bag",
                },
                {
                    name: "Sales Records",
                    href: "/company/sales",
                    icon: "ti ti-shopping-cart",
                },
            ],
        },
        {
            title: "Administration",
            items: [
                {
                    name: "Users & Staff",
                    href: "/company/users",
                    icon: "ti ti-users",
                },
                {
                    name: "Daily Sales Report",
                    href: "/company/reports/daily-sales",
                    icon: "ti ti-chart-bar",
                },
                {
                    name: "Stock Report",
                    href: "/company/reports/stock",
                    icon: "ti ti-chart-line",
                },
                {
                    name: "Subscription",
                    href: "/company/subscription",
                    icon: "ti ti-credit-card",
                },
                {
                    name: "Company Settings",
                    href: "/company/settings/profile",
                    icon: "ti ti-settings",
                },
            ],
        },
    ];

    return (
        <ul className="side-nav">
            {navGroups.map((group) => (
                <React.Fragment key={group.title}>
                    <li className="side-nav-title">{group.title}</li>
                    {group.items.map((item) => (
                        <li
                            key={item.href}
                            className={`side-nav-item${isActive(item.href) ? " menuitem-active" : ""}`}
                        >
                            <Link
                                href={item.href}
                                className={`side-nav-link${isActive(item.href) ? " active" : ""}`}
                            >
                                <span className="menu-icon">
                                    <i className={item.icon}></i>
                                </span>
                                <span className="menu-text">{item.name}</span>
                            </Link>
                        </li>
                    ))}
                </React.Fragment>
            ))}
        </ul>
    );
}
