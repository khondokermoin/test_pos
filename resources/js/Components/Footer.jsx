import React from 'react';

export default function Footer() {
  return (
    <footer className="footer">
      <div className="container-fluid">
        <div className="row">
          <div className="col-md-6">
            © {new Date().getFullYear()} Cloud POS & Inventory System. All rights reserved.
          </div>
          <div className="col-md-6">
            <div className="text-md-end footer-links d-none d-md-block">
              <a href="#">About</a>
              <a href="#">Support</a>
              <a href="#">Contact Us</a>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
}
