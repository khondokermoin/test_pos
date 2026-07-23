import React from "react";
import { usePage, Link } from "@inertiajs/react";

/**
 * Topbar — matches templates/index.html <header class="app-topbar"> exactly.
 *
 * Key template classes used:
 *   app-topbar, page-container, topbar-menu, sidenav-toggle-button,
 *   topbar-item, topbar-link, nav-user, ti ti-* (Tabler icons)
 */
export default function Topbar() {
    const { auth } = usePage().props;
    const user = auth?.user;
    const userName = user?.name ?? "User";
    const userInitial = userName.charAt(0).toUpperCase();
    const userRole =
        user?.roles && user.roles.length > 0 ? user.roles[0] : "User";

    return (
        <header className="app-topbar">
            <div className="page-container topbar-menu">
                <div className="d-flex align-items-center gap-2">
                    {/* Brand Logo (shown in topbar on mobile) */}
                    <a href="/" className="logo">
                        <span className="logo-light">
                            <span className="logo-lg">
                                <span className="fw-bold fs-18 text-primary">
                                    Cloud POS
                                </span>
                            </span>
                            <span className="logo-sm">
                                <span className="fw-bold text-primary">P</span>
                            </span>
                        </span>
                        <span className="logo-dark">
                            <span className="logo-lg">
                                <span className="fw-bold fs-18">Cloud POS</span>
                            </span>
                            <span className="logo-sm">
                                <span className="fw-bold">P</span>
                            </span>
                        </span>
                    </a>

                    {/* Sidebar Toggle Button */}
                    <button className="sidenav-toggle-button btn-icon rounded-circle btn btn-light">
                        <i className="ti ti-menu-2 fs-22"></i>
                    </button>
                </div>

                <div className="d-flex align-items-center gap-2">
                    {/* Notifications */}
                    <div className="topbar-item">
                        <div className="dropdown">
                            <button
                                className="topbar-link dropdown-toggle drop-arrow-none"
                                data-bs-toggle="dropdown"
                                data-bs-offset="0,23"
                                type="button"
                                aria-haspopup="false"
                                aria-expanded="false"
                            >
                                <i className="ti ti-bell-z fs-24"></i>
                            </button>
                            <div className="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg fs-13">
                                <div className="py-2 px-3 border-bottom border-dashed">
                                    <h6 className="m-0 fs-16 fw-semibold">
                                        Notifications
                                    </h6>
                                </div>
                                <div className="p-3 text-center text-muted fs-13">
                                    No new notifications
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* User Dropdown */}
                    <div className="topbar-item nav-user">
                        <div className="dropdown">
                            <a
                                className="topbar-link dropdown-toggle drop-arrow-none px-2"
                                data-bs-toggle="dropdown"
                                data-bs-offset="0,19"
                                href="#"
                                role="button"
                                aria-haspopup="false"
                                aria-expanded="false"
                            >
                                {/* Avatar circle with user initial */}
                                <span
                                    className="avatar-title rounded-circle bg-primary text-white fw-bold me-lg-2 d-flex align-items-center justify-content-center"
                                    style={{
                                        width: 32,
                                        height: 32,
                                        fontSize: 14,
                                    }}
                                >
                                    {userInitial}
                                </span>
                                <span className="d-lg-flex flex-column gap-1 d-none">
                                    <h5 className="my-0 fs-13 fw-semibold">
                                        {userName}
                                    </h5>
                                    <span className="fs-11 text-muted">
                                        {userRole}
                                    </span>
                                </span>
                                <i className="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                            </a>

                            <div className="dropdown-menu dropdown-menu-end">
                                <div className="dropdown-header noti-title">
                                    <h6 className="text-overflow m-0">
                                        Welcome!
                                    </h6>
                                </div>

                                <Link href="/profile" className="dropdown-item">
                                    <i className="ti ti-user-hexagon me-1 fs-17 align-middle"></i>
                                    <span className="align-middle">
                                        My Account
                                    </span>
                                </Link>

                                <div className="dropdown-divider"></div>

                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    className="dropdown-item active fw-semibold text-danger w-100 text-start border-0 bg-transparent"
                                >
                                    <i className="ti ti-logout me-1 fs-17 align-middle"></i>
                                    <span className="align-middle">
                                        Sign Out
                                    </span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    );
}
