import React from 'react';
import { Head } from '@inertiajs/react';
import AdminMasterLayout from '../Layouts/AdminMasterLayout';

export default function Welcome() {
  return (
    <AdminMasterLayout headerTitle="Dashboard Overview">
      <Head title="Welcome" />
      <div className="row">
        <div className="col-12">
          <div className="card">
            <div className="card-body">
              <h4 className="header-title mb-3">Welcome to Cloud POS SaaS Application</h4>
              <p className="text-muted font-14">
                The layout system has been converted to React Inertia components matching the original Blade templates with exact HTML structure, Bootstrap styles, and navigation hierarchy.
              </p>

              <div className="row mt-4">
                <div className="col-md-4">
                  <div className="card border p-3">
                    <h5 className="text-primary fw-bold">Laravel 12 Backend</h5>
                    <p className="text-muted font-13 mb-0">Robust REST / Inertia Controller architecture</p>
                  </div>
                </div>
                <div className="col-md-4">
                  <div className="card border p-3">
                    <h5 className="text-success fw-bold">Inertia.js v2 Adapter</h5>
                    <p className="text-muted font-13 mb-0">Seamless single-page application experience</p>
                  </div>
                </div>
                <div className="col-md-4">
                  <div className="card border p-3">
                    <h5 className="text-info fw-bold">Bootstrap Template UI</h5>
                    <p className="text-muted font-13 mb-0">Original theme CSS, icons and responsive layouts</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AdminMasterLayout>
  );
}
