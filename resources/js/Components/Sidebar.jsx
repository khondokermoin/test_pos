import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import SuperAdminSidebar from './SuperAdminSidebar';
import CompanySidebar from './CompanySidebar';
import BranchSidebar from './BranchSidebar';

export default function Sidebar() {
  const { props } = usePage();
  const user = props.auth?.user;
  const roles = user?.roles || [];

  const isSuperAdmin = roles.includes('Super Admin') || roles.includes('super_admin');
  const isCompanyAdmin = roles.includes('Company Admin') || roles.includes('company_admin');

  return (
    <div className="leftside-menu">
      {/* LOGO */}
      <Link href="/" className="logo text-center logo-light">
        <span className="logo-lg">
          <span className="h4 text-white fw-bold">Cloud POS</span>
        </span>
        <span className="logo-sm">
          <span className="h4 text-white fw-bold">POS</span>
        </span>
      </Link>

      <div className="h-100" id="leftside-menu-container" data-simplebar="">
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
