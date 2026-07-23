import React from "react";
import { Link, usePage } from "@inertiajs/react";
import SuperAdminSidebar from "./SuperAdminSidebar";
import CompanySidebar from "./CompanySidebar";
import BranchSidebar from "./BranchSidebar";

/**
 * Sidebar — 100% matches templates/index.html <div class="sidenav-menu">
 *
 * Template logo structure:
 *   <a href="index.html" class="logo">
 *     <span class="logo-light">
 *       <span class="logo-lg"><img src="assets/images/logo.png" alt="logo"></span>
 *       <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
 *     </span>
 *     <span class="logo-dark">
 *       <span class="logo-lg"><img src="assets/images/logo-dark.png" alt="dark logo"></span>
 *       <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
 *     </span>
 *   </a>
 *
 * Asset paths: /frontend_assets/images/* (served from public/frontend_assets/)
 */
export default function Sidebar() {
    const { props } = usePage();
    const user = props.auth?.user;
    const roles = user?.roles ?? [];

    const isSuperAdmin =
        roles.includes("Super Admin") || roles.includes("super_admin");
    const isCompanyAdmin =
        roles.includes("Company Admin") || roles.includes("company_admin");

    return (
        <div className="sidenav-menu">
            {/* Brand Logo — exact match to templates/index.html */}
            <Link href="/" className="logo">
                <span className="logo-light">
                    <span className="logo-lg">
                        <img
                            src="/frontend_assets/images/logo.png"
                            alt="logo"
                        />
                    </span>
                    <span className="logo-sm">
                        <img
                            src="/frontend_assets/images/logo-sm.png"
                            alt="small logo"
                        />
                    </span>
                </span>
                <span className="logo-dark">
                    <span className="logo-lg">
                        <img
                            src="/frontend_assets/images/logo-dark.png"
                            alt="dark logo"
                        />
                    </span>
                    <span className="logo-sm">
                        <img
                            src="/frontend_assets/images/logo-sm.png"
                            alt="small logo"
                        />
                    </span>
                </span>
            </Link>

            {/* Sidebar Hover Menu Toggle Button */}
            <button className="button-sm-hover" type="button">
                <i className="ti ti-circle align-middle"></i>
            </button>

            {/* Full Sidebar Menu Close Button */}
            <button className="button-close-fullsidebar" type="button">
                <i className="ti ti-x align-middle"></i>
            </button>

            {/* Scrollable nav area */}
            <div data-simplebar="">
                {/* Role-based navigation */}
                {isSuperAdmin ? (
                    <SuperAdminSidebar />
                ) : isCompanyAdmin ? (
                    <CompanySidebar />
                ) : (
                    <BranchSidebar />
                )}

                <div className="clearfix"></div>
            </div>
        </div>
    );
}
