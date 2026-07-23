import React from 'react';
import { usePage, Link } from '@inertiajs/react';

export default function Topbar({ onToggleSidebar }) {
  const { auth } = usePage().props;
  const user = auth?.user;

  return (
    <div className="navbar-custom">
      <ul className="list-unstyled topbar-menu float-end mb-0">
        {user ? (
          <li className="dropdown notification-list">
            <a
              className="nav-link dropdown-toggle nav-user arrow-none me-0"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-haspopup="false"
              aria-expanded="false"
            >
              <span className="account-user-avatar">
                <span className="avatar-title rounded-circle bg-primary font-12 fw-bold text-white">
                  {user.name ? user.name.charAt(0).toUpperCase() : 'U'}
                </span>
              </span>
              <span>
                <span className="account-user-name">{user.name}</span>
                <span className="account-position">
                  {user.roles && user.roles.length > 0 ? user.roles[0] : 'User'}
                </span>
              </span>
            </a>
            <div className="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
              <div className=" dropdown-header noti-title">
                <h6 className="text-overflow m-0">Welcome !</h6>
              </div>

              <Link href="/profile" className="dropdown-item notify-item">
                <i className="uil-user me-1"></i>
                <span>My Account</span>
              </Link>

              <Link
                href="/logout"
                method="post"
                as="button"
                className="dropdown-item notify-item w-100 text-start border-0 bg-transparent"
              >
                <i className="uil-sign-out-alt me-1"></i>
                <span>Logout</span>
              </Link>
            </div>
          </li>
        ) : (
          <li className="notification-list">
            <Link href="/login" className="nav-link">
              Sign In
            </Link>
          </li>
        )}
      </ul>

      <button className="button-menu-mobile open-left" onClick={onToggleSidebar}>
        <i className="mdi mdi-menu"></i>
      </button>

      <div className="app-search dropdown d-none d-lg-block">
        <form>
          <div className="input-group">
            <input
              type="text"
              className="form-control dropdown-toggle"
              placeholder="Search..."
              id="top-search"
            />
            <span className="mdi mdi-magnify search-icon"></span>
          </div>
        </form>
      </div>
    </div>
  );
}
