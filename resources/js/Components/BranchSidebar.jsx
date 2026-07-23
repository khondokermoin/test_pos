import React from "react";
import { Link, usePage } from "@inertiajs/react";

/**
 * BranchSidebar — matches templates/index.html side-nav structure exactly.
 * Icons: Tabler Icons (ti ti-*) — loaded via icons.min.css
 */
export default function BranchSidebar() {
    const { url } = usePage();

    const isActive = (href) =>
        url === href || (href !== "/" && url.startsWith(href));

    const navGroups = [
        {
            title: "POS Terminal",
            items: [
                {
                    name: "POS Terminal",
                    href: "/branch/pos",
                    icon: "ti ti-device-desktop",
                },
                {
                    name: "Branch Dashboard",
                    href: "/branch/dashboard",
                    icon: "ti ti-dashboard",
                },
            ],
        },
        {
            title: "Inventory",
            items: [
                {
                    name: "Receive & Sort",
                    href: "/branch/inventory/receive-sort",
                    icon: "ti ti-package",
                },
                {
                    name: "Sorting History",
                    href: "/branch/inventory/sorting-history",
                    icon: "ti ti-history",
                },
                {
                    name: "Stock Adjustment",
                    href: "/branch/inventory/stock-adjustment",
                    icon: "ti ti-adjustments",
                },
            ],
        },
        {
            title: "Sales",
            items: [
                {
                    name: "Sales History",
                    href: "/branch/sales",
                    icon: "ti ti-shopping-cart",
                },
                {
                    name: "Customers",
                    href: "/branch/customers",
                    icon: "ti ti-users",
                },
                {
                    name: "Reports",
                    href: "/branch/reports",
                    icon: "ti ti-chart-bar",
                },
            ],
        },
        {
            title: "Shift",
            items: [
                {
                    name: "Open / Close Shift",
                    href: "/branch/shift/open",
                    icon: "ti ti-clock",
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
