import React from 'react';
import { Link } from '@inertiajs/react';

export default function AuthLayout({ children, title, subtitle }) {
  return (
    <div className="min-h-screen bg-slate-950 text-slate-100 flex flex-col justify-center items-center p-6 font-sans antialiased">
      <div className="w-full max-w-md space-y-6">
        {/* Brand Header */}
        <div className="text-center space-y-2">
          <Link href="/" className="inline-flex items-center space-x-3">
            <div className="w-10 h-10 rounded-2xl bg-indigo-600 flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-indigo-600/30">
              P
            </div>
            <span className="font-extrabold text-white text-2xl tracking-tight">Cloud POS</span>
          </Link>
          {title && <h1 className="text-xl font-bold text-white tracking-tight pt-2">{title}</h1>}
          {subtitle && <p className="text-xs text-slate-400">{subtitle}</p>}
        </div>

        {/* Card Container */}
        <div className="bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-2xl shadow-slate-950/50">
          {children}
        </div>

        {/* Footer info */}
        <p className="text-center text-xs text-slate-500">
          &copy; {new Date().getFullYear()} Cloud POS SaaS. All rights reserved.
        </p>
      </div>
    </div>
  );
}
