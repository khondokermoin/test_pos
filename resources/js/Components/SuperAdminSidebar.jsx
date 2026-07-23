import React from "react";
import { Link, usePage } from "@inertiajs/react";

/**
 * SuperAdminSidebar — matches templates/index.html side-nav structure exactly.
 *
 * Template pattern for each item:
 *   <li class="side-nav-item">
 *     <a href="..." class="side-nav-link">
 *       <span class="menu-icon"><i class="ti ti-*"></i></span>
 *       <span class="menu-text"> Label </span>
 *     </a>
 *   </li>
 *
 * Icons: Tabler Icons (ti ti-*) — loaded via icons.min.css
 */
export default function SuperAdminSidebar() {
    const { url } = usePage();

    const isActive = (href) =>
        url === href || (href !== "/" && url.startsWith(href));

    const navGroups = [
        {
            title: "Navigation",
            items: [
                {
                    name: "Dashboard",
                    href: "/superadmin/dashboard",
                    icon: "ti ti-dashboard",
                },
                {
                    name: "Companies",
                    href: "/superadmin/companies",
                    icon: "ti ti-building",
                },
                {
                    name: "Subscription Plans",
                    href: "/superadmin/plans",
                    icon: "ti ti-credit-card",
                },
                {
                    name: "Subscriptions",
                    href: "/superadmin/subscriptions",
                    icon: "ti ti-receipt",
                },
                {
                    name: "Addon Marketplace",
                    href: "/superadmin/addons",
                    icon: "ti ti-apps",
                },
                {
                    name: "Business Types",
                    href: "/superadmin/business-types",
                    icon: "ti ti-category",
                },
            ],
        },
        {
            title: "Management",
            items: [
                {
                    name: "Users & Staff",
                    href: "/superadmin/users",
                    icon: "ti ti-users",
                },
                {
                    name: "Roles & Permissions",
                    href: "/superadmin/roles",
                    icon: "ti ti-shield-check",
                },
                {
                    name: "Reports & Analytics",
                    href: "/superadmin/reports",
                    icon: "ti ti-chart-bar",
                },
                {
                    name: "System Logs",
                    href: "/superadmin/system/logs",
                    icon: "ti ti-file-text",
                },
                {
                    name: "System Settings",
                    href: "/superadmin/settings/general",
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
