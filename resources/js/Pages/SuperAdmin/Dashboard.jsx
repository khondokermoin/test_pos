import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminMasterLayout from '../../Layouts/AdminMasterLayout';

export default function Dashboard({ stats = {} }) {
  const statCards = [
    {
      title: 'Total Companies',
      value: stats.total_companies || 12,
      change: '+15%',
      icon: 'uil-building',
      color: 'bg-primary',
    },
    {
      title: 'Active Subscriptions',
      value: stats.total_subscriptions || 28,
      change: '+8%',
      icon: 'uil-receipt',
      color: 'bg-success',
    },
    {
      title: 'Total Revenue',
      value: '$14,250',
      change: '+22%',
      icon: 'uil-dollar-sign-alt',
      color: 'bg-info',
    },
    {
      title: 'System Users',
      value: stats.total_users || 145,
      change: '+5%',
      icon: 'uil-users-alt',
      color: 'bg-warning',
    },
  ];

  return (
    <AdminMasterLayout headerTitle="Super Admin Dashboard">
      <Head title="Super Admin Dashboard" />

      {/* Stat Cards */}
      <div className="row">
        {statCards.map((card, index) => (
          <div key={index} className="col-xl-3 col-lg-6">
            <div className="card widget-flat">
              <div className="card-body">
                <div className="float-end">
                  <div className={`avatar-sm rounded-circle ${card.color} text-white flex items-center justify-center`}>
                    <i className={`${card.icon} font-20`}></i>
                  </div>
                </div>
                <h5 className="text-muted fw-normal mt-0" title={card.title}>
                  {card.title}
                </h5>
                <h3 className="mt-3 mb-3">{card.value}</h3>
                <p className="mb-0 text-muted">
                  <span className="text-success me-2">
                    <i className="mdi mdi-arrow-up-bold"></i> {card.change}
                  </span>
                  <span className="text-nowrap font-12">Since last month</span>
                </p>
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* Quick Actions & Recent Tenants */}
      <div className="row mt-2">
        <div className="col-lg-8">
          <div className="card">
            <div className="card-body">
              <div className="d-flex justify-content-between align-items-center mb-3">
                <h4 className="header-title">Recent Registered Companies</h4>
                <Link href="/superadmin/companies" className="btn btn-sm btn-link">
                  View All
                </Link>
              </div>
              <div className="table-responsive">
                <table className="table table-centered table-nowrap mb-0">
                  <thead className="table-light">
                    <tr>
                      <th>Company Name</th>
                      <th>Owner</th>
                      <th>Plan</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <span className="fw-bold">Apex Retail Ltd</span>
                      </td>
                      <td>John Manager</td>
                      <td>
                        <span className="badge bg-primary-lighten text-primary">Enterprise</span>
                      </td>
                      <td>
                        <span className="badge bg-success">Active</span>
                      </td>
                      <td>
                        <Link href="/superadmin/companies" className="btn btn-xs btn-light">
                          Manage
                        </Link>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span className="fw-bold">Metro Supermarket</span>
                      </td>
                      <td>Sarah Jenkins</td>
                      <td>
                        <span className="badge bg-info-lighten text-info">Pro Plan</span>
                      </td>
                      <td>
                        <span className="badge bg-success">Active</span>
                      </td>
                      <td>
                        <Link href="/superadmin/companies" className="btn btn-xs btn-light">
                          Manage
                        </Link>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span className="fw-bold">Boutique Corner</span>
                      </td>
                      <td>David Miller</td>
                      <td>
                        <span className="badge bg-warning-lighten text-warning">Starter</span>
                      </td>
                      <td>
                        <span className="badge bg-warning">Trial</span>
                      </td>
                      <td>
                        <Link href="/superadmin/companies" className="btn btn-xs btn-light">
                          Manage
                        </Link>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div className="col-lg-4">
          <div className="card">
            <div className="card-body">
              <h4 className="header-title mb-3">Quick Navigation</h4>
              <div className="d-grid gap-2">
                <Link href="/superadmin/companies" className="btn btn-outline-primary text-start">
                  <i className="uil-building me-2"></i> Manage Companies
                </Link>
                <Link href="/superadmin/plans" className="btn btn-outline-success text-start">
                  <i className="uil-credit-card me-2"></i> Subscription Plans
                </Link>
                <Link href="/superadmin/users" className="btn btn-outline-info text-start">
                  <i className="uil-users-alt me-2"></i> Users & Staff
                </Link>
                <Link href="/superadmin/settings/general" className="btn btn-outline-secondary text-start">
                  <i className="uil-cog me-2"></i> System Settings
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AdminMasterLayout>
  );
}
