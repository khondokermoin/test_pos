import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminMasterLayout from '../../Layouts/AdminMasterLayout';

export default function Dashboard({ stats = {} }) {
  const statCards = [
    {
      title: 'Total Sales Today',
      value: '$3,840.00',
      change: '+12.5%',
      icon: 'uil-shopping-cart',
      color: 'bg-primary',
    },
    {
      title: 'Active Branches',
      value: stats.total_branches || 4,
      change: 'Stable',
      icon: 'uil-code-branch',
      color: 'bg-success',
    },
    {
      title: 'Total Products',
      value: stats.total_products || 320,
      change: '+24 new',
      icon: 'uil-box',
      color: 'bg-info',
    },
    {
      title: 'Low Stock Items',
      value: '8 Items',
      change: 'Needs order',
      icon: 'uil-exclamation-triangle',
      color: 'bg-danger',
    },
  ];

  return (
    <AdminMasterLayout headerTitle="Company Dashboard">
      <Head title="Company Dashboard" />

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
                </p>
              </div>
            </div>
          </div>
        ))}
      </div>

      {/* Quick Actions & Recent Sales */}
      <div className="row mt-2">
        <div className="col-lg-8">
          <div className="card">
            <div className="card-body">
              <div className="d-flex justify-content-between align-items-center mb-3">
                <h4 className="header-title">Recent Transactions</h4>
                <Link href="/company/sales" className="btn btn-sm btn-link">
                  View All Sales
                </Link>
              </div>
              <div className="table-responsive">
                <table className="table table-centered table-nowrap mb-0">
                  <thead className="table-light">
                    <tr>
                      <th>Invoice ID</th>
                      <th>Branch</th>
                      <th>Total</th>
                      <th>Payment Method</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>#INV-10024</td>
                      <td>Downtown Outlet</td>
                      <td>$145.50</td>
                      <td>Credit Card</td>
                      <td><span className="badge bg-success">Completed</span></td>
                    </tr>
                    <tr>
                      <td>#INV-10023</td>
                      <td>Westside Store</td>
                      <td>$89.00</td>
                      <td>Cash</td>
                      <td><span className="badge bg-success">Completed</span></td>
                    </tr>
                    <tr>
                      <td>#INV-10022</td>
                      <td>Downtown Outlet</td>
                      <td>$230.10</td>
                      <td>bKash/Mobile</td>
                      <td><span className="badge bg-success">Completed</span></td>
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
              <h4 className="header-title mb-3">Company Shortcuts</h4>
              <div className="d-grid gap-2">
                <Link href="/company/products" className="btn btn-outline-primary text-start">
                  <i className="uil-box me-2"></i> Manage Products
                </Link>
                <Link href="/company/branches" className="btn btn-outline-success text-start">
                  <i className="uil-code-branch me-2"></i> Manage Branches
                </Link>
                <Link href="/company/inventory/low-stock" className="btn btn-outline-danger text-start">
                  <i className="uil-exclamation-triangle me-2"></i> Check Low Stock
                </Link>
                <Link href="/company/reports/daily-sales" className="btn btn-outline-info text-start">
                  <i className="uil-chart me-2"></i> Daily Sales Report
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AdminMasterLayout>
  );
}
