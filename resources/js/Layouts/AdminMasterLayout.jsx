import React, { useState } from 'react';
import Sidebar from '../Components/Sidebar';
import Topbar from '../Components/Topbar';
import Footer from '../Components/Footer';
import Alerts from '../Components/Alerts';

export default function AdminMasterLayout({ children, headerTitle }) {
  const [sidebarOpen, setSidebarOpen] = useState(false);

  return (
    <div className={`wrapper ${sidebarOpen ? 'sidebar-enable' : ''}`}>
      <Sidebar />

      <div className="content-page">
        <div className="content">
          <Topbar onToggleSidebar={() => setSidebarOpen((prev) => !prev)} />

          <div className="container-fluid pt-2">
            {headerTitle && (
              <div className="row">
                <div className="col-12">
                  <div className="page-title-box">
                    <h4 className="page-title">{headerTitle}</h4>
                  </div>
                </div>
              </div>
            )}
            <Alerts />
            {children}
          </div>
        </div>

        <Footer />
      </div>
    </div>
  );
}
