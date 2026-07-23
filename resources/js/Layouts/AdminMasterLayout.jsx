import React from "react";
import Sidebar from "../Components/Sidebar";
import Topbar from "../Components/Topbar";
import Footer from "../Components/Footer";
import Alerts from "../Components/Alerts";

/**
 * AdminMasterLayout — matches templates/index.html DOM structure exactly.
 *
 * Template structure:
 *   <div class="wrapper">
 *     <div class="sidenav-menu">...</div>   <- Sidebar
 *     <header class="app-topbar">...</header> <- Topbar
 *     <div class="page-content">
 *       <div class="page-container">
 *         <div class="page-title-head">...</div>
 *         {children}
 *       </div>
 *     </div>
 *     <footer class="footer">...</footer>
 *   </div>
 */
export default function AdminMasterLayout({ children, headerTitle }) {
    return (
        <div className="wrapper">
            {/* Sidebar — renders sidenav-menu with role-based nav */}
            <Sidebar />

            {/* Topbar — renders app-topbar header */}
            <Topbar />

            {/* Page Content — matches template's .page-content > .page-container */}
            <div className="page-content">
                <div className="page-container">
                    {/* Page Title Head — matches template's .page-title-head */}
                    {headerTitle && (
                        <div className="page-title-head d-flex align-items-center gap-2 mb-3">
                            <div className="flex-grow-1">
                                <h4 className="fs-17 mb-0">{headerTitle}</h4>
                            </div>
                        </div>
                    )}

                    {/* Flash Alerts */}
                    <Alerts />

                    {/* Page-specific content */}
                    {children}
                </div>
            </div>

            {/* Footer */}
            <Footer />
        </div>
    );
}
