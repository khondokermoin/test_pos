import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminMasterLayout from '../../Layouts/AdminMasterLayout';

export default function Dashboard() {
  return (
    <AdminMasterLayout headerTitle="Branch Terminal Dashboard">
      <Head title="Branch Dashboard" />

      {/* POS Launch Banner */}
      <div className="row">
        <div className="col-12">
          <div className="card bg-primary text-white">
            <div className="card-body p-4">
              <div className="row align-items-center">
                <div className="col-md-8">
                  <h3 className="text-white fw-bold">Active Branch Sales Terminal</h3>
                  <p className="text-white-50 mb-3">
                    Fast, responsive Point of Sale register with real-time inventory checking and instant receipt printing.
                  </p>
                  <Link href="/branch/pos" className="btn btn-light text-primary fw-bold shadow-sm">
                    <i className="uil-calculator me-1"></i> Open POS Terminal
                  </Link>
                </div>
                <div className="col-md-4 text-center d-none d-md-block">
                  <i className="uil-shopping-cart-alt font-48 opacity-50"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Branch Stats */}
      <div className="row">
        <div className="col-md-4">
          <div className="card">
            <div className="card-body">
              <h5 className="text-muted fw-normal mt-0">Shift Sales</h5>
              <h3 className="mt-2 mb-2">$1,240.00</h3>
              <p className="mb-0 text-muted">Current Shift</p>
            </div>
          </div>
        </div>
        <div className="col-md-4">
          <div className="card">
            <div className="card-body">
              <h5 className="text-muted fw-normal mt-0">Items Sold</h5>
              <h3 className="mt-2 mb-2">64</h3>
              <p className="mb-0 text-muted">Transactions count: 18</p>
            </div>
          </div>
        </div>
        <div className="col-md-4">
          <div className="card">
            <div className="card-body">
              <h5 className="text-muted fw-normal mt-0">Pending Sorting</h5>
              <h3 className="mt-2 mb-2">3 Shipments</h3>
              <p className="mb-0 text-muted">
                <Link href="/branch/inventory/receive-sort" className="text-primary">
                  Process Now &rarr;
                </Link>
              </p>
            </div>
          </div>
        </div>
      </div>
    </AdminMasterLayout>
  );
}
