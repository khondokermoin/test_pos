import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import AdminMasterLayout from '../../Layouts/AdminMasterLayout';

export default function POS() {
  const [searchQuery, setSearchQuery] = useState('');
  const [cart, setCart] = useState([
    { id: 1, name: 'Wireless Barcode Scanner', price: 45.0, qty: 1 },
    { id: 2, name: 'Thermal Receipt Paper (Pack of 5)', price: 12.5, qty: 2 },
  ]);

  const addToCart = (product) => {
    setCart((prev) => {
      const existing = prev.find((item) => item.id === product.id);
      if (existing) {
        return prev.map((item) =>
          item.id === product.id ? { ...item, qty: item.qty + 1 } : item
        );
      }
      return [...prev, { ...product, qty: 1 }];
    });
  };

  const updateQty = (id, delta) => {
    setCart((prev) =>
      prev
        .map((item) => {
          if (item.id === id) {
            const newQty = item.qty + delta;
            return newQty > 0 ? { ...item, qty: newQty } : null;
          }
          return item;
        })
        .filter(Boolean)
    );
  };

  const subtotal = cart.reduce((acc, item) => acc + item.price * item.qty, 0);
  const tax = subtotal * 0.05;
  const total = subtotal + tax;

  const mockProducts = [
    { id: 1, name: 'Wireless Barcode Scanner', barcode: '10001', price: 45.0, stock: 15 },
    { id: 2, name: 'Thermal Receipt Paper (Pack of 5)', barcode: '10002', price: 12.5, stock: 80 },
    { id: 3, name: 'USB Cash Drawer', barcode: '10003', price: 85.0, stock: 8 },
    { id: 4, name: 'Bluetooth Label Printer', barcode: '10004', price: 120.0, stock: 5 },
  ];

  return (
    <AdminMasterLayout headerTitle="POS Terminal Register">
      <Head title="POS Terminal" />

      <div className="row">
        {/* Left: Product Search & Grid */}
        <div className="col-lg-7">
          <div className="card">
            <div className="card-body">
              <div className="mb-3">
                <label className="form-label fw-bold">Search Product or Scan Barcode</label>
                <div className="input-group">
                  <span className="input-group-text">
                    <i className="uil-search"></i>
                  </span>
                  <input
                    type="text"
                    className="form-control"
                    placeholder="Type product name, SKU or scan barcode..."
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                  />
                  <button className="btn btn-primary" type="button">
                    Search
                  </button>
                </div>
              </div>

              <h5 className="header-title my-3">Quick Select Catalog</h5>
              <div className="row g-2">
                {mockProducts
                  .filter((p) => p.name.toLowerCase().includes(searchQuery.toLowerCase()) || p.barcode.includes(searchQuery))
                  .map((product) => (
                    <div key={product.id} className="col-md-6 col-sm-6">
                      <div
                        className="card border mb-2 cursor-pointer hover:border-primary transition-all p-3"
                        onClick={() => addToCart(product)}
                        style={{ cursor: 'pointer' }}
                      >
                        <div className="d-flex justify-content-between align-items-center">
                          <div>
                            <h6 className="mb-1 text-primary">{product.name}</h6>
                            <span className="text-muted font-12">BC: {product.barcode} | Stock: {product.stock}</span>
                          </div>
                          <span className="fw-bold font-15 text-success">${product.price.toFixed(2)}</span>
                        </div>
                      </div>
                    </div>
                  ))}
              </div>
            </div>
          </div>
        </div>

        {/* Right: Cart & Checkout */}
        <div className="col-lg-5">
          <div className="card">
            <div className="card-body">
              <h4 className="header-title mb-3 d-flex justify-content-between">
                <span>Current Order</span>
                <span className="badge bg-primary-lighten text-primary">{cart.length} Items</span>
              </h4>

              <div className="table-responsive" style={{ maxHeight: '300px', overflowY: 'auto' }}>
                <table className="table table-centered mb-0">
                  <thead className="table-light">
                    <tr>
                      <th>Item</th>
                      <th className="text-center">Qty</th>
                      <th className="text-end">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    {cart.map((item) => (
                      <tr key={item.id}>
                        <td>
                          <span className="fw-semibold font-13">{item.name}</span>
                        </td>
                        <td className="text-center">
                          <div className="btn-group btn-group-sm">
                            <button
                              className="btn btn-light"
                              onClick={() => updateQty(item.id, -1)}
                            >
                              -
                            </button>
                            <span className="btn btn-light px-2 disabled">{item.qty}</span>
                            <button
                              className="btn btn-light"
                              onClick={() => updateQty(item.id, 1)}
                            >
                              +
                            </button>
                          </div>
                        </td>
                        <td className="text-end font-13 fw-bold">
                          ${(item.price * item.qty).toFixed(2)}
                        </td>
                      </tr>
                    ))}
                    {cart.length === 0 && (
                      <tr>
                        <td colSpan="3" className="text-center text-muted py-4">
                          No items in cart. Click or scan a product to add.
                        </td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>

              <hr className="my-3" />

              <div className="space-y-1 font-14">
                <div className="d-flex justify-content-between text-muted">
                  <span>Subtotal</span>
                  <span>${subtotal.toFixed(2)}</span>
                </div>
                <div className="d-flex justify-content-between text-muted">
                  <span>Tax (5%)</span>
                  <span>${tax.toFixed(2)}</span>
                </div>
                <div className="d-flex justify-content-between font-18 fw-bold text-dark pt-2 border-top">
                  <span>Total Payable</span>
                  <span className="text-primary">${total.toFixed(2)}</span>
                </div>
              </div>

              <div className="d-grid gap-2 mt-4">
                <button
                  className="btn btn-success btn-lg fw-bold"
                  disabled={cart.length === 0}
                  onClick={() => alert(`Checkout complete! Total charged: $${total.toFixed(2)}`)}
                >
                  <i className="uil-check-circle me-1"></i> Complete Checkout
                </button>
                <button
                  className="btn btn-outline-secondary btn-sm"
                  onClick={() => setCart([])}
                  disabled={cart.length === 0}
                >
                  Clear Cart
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AdminMasterLayout>
  );
}
