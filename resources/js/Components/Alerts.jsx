import React from 'react';
import { usePage } from '@inertiajs/react';

export default function Alerts() {
  const { flash } = usePage().props;
  const [dismissed, setDismissed] = React.useState({
    success: false,
    error: false,
    message: false,
    status: false,
  });

  if (!flash) return null;

  const handleDismiss = (type) => {
    setDismissed((prev) => ({ ...prev, [type]: true }));
  };

  return (
    <div className="mb-3">
      {flash.success && !dismissed.success && (
        <div className="alert alert-success alert-dismissible fade show" role="alert">
          <i className="uil-check-circle me-1"></i> {flash.success}
          <button
            type="button"
            className="btn-close"
            onClick={() => handleDismiss('success')}
            aria-label="Close"
          ></button>
        </div>
      )}

      {flash.error && !dismissed.error && (
        <div className="alert alert-danger alert-dismissible fade show" role="alert">
          <i className="uil-exclamation-octagon me-1"></i> {flash.error}
          <button
            type="button"
            className="btn-close"
            onClick={() => handleDismiss('error')}
            aria-label="Close"
          ></button>
        </div>
      )}

      {(flash.message || flash.status) && !dismissed.message && (
        <div className="alert alert-info alert-dismissible fade show" role="alert">
          <i className="uil-info-circle me-1"></i> {flash.message || flash.status}
          <button
            type="button"
            className="btn-close"
            onClick={() => handleDismiss('message')}
            aria-label="Close"
          ></button>
        </div>
      )}
    </div>
  );
}
