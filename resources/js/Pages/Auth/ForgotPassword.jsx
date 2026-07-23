import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthLayout from '../../Layouts/AuthLayout';
import { Mail, Send, ArrowLeft } from 'lucide-react';

export default function ForgotPassword({ status }) {
  const { data, setData, post, processing, errors } = useForm({
    email: '',
  });

  const submit = (e) => {
    e.preventDefault();
    post('/forgot-password');
  };

  return (
    <AuthLayout
      title="Reset Password"
      subtitle="Forgot your password? Enter your email address and we will send you a password reset link."
    >
      <Head title="Forgot Password" />

      {status && (
        <div className="mb-4 text-xs font-semibold text-emerald-400 bg-emerald-500/10 p-3 rounded-xl border border-emerald-500/20">
          {status}
        </div>
      )}

      <form onSubmit={submit} className="space-y-4">
        <div>
          <label className="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
            Email Address
          </label>
          <div className="relative">
            <Mail className="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-500" />
            <input
              id="email"
              type="email"
              value={data.email}
              onChange={(e) => setData('email', e.target.value)}
              className="w-full bg-slate-950 border border-slate-800 rounded-xl pl-9 pr-4 py-2 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"
              placeholder="user@example.com"
              required
              autoFocus
            />
          </div>
          {errors.email && <p className="mt-1.5 text-xs text-rose-400 font-medium">{errors.email}</p>}
        </div>

        <button
          type="submit"
          disabled={processing}
          className="w-full mt-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5 px-4 rounded-xl shadow-lg shadow-indigo-600/25 flex items-center justify-center space-x-2 text-sm transition-all disabled:opacity-50"
        >
          <Send className="w-4 h-4" />
          <span>{processing ? 'Sending Link...' : 'Email Password Reset Link'}</span>
        </button>

        <p className="text-center text-xs text-slate-400 pt-3">
          <Link href="/login" className="inline-flex items-center space-x-1.5 text-slate-400 hover:text-white transition-colors">
            <ArrowLeft className="w-3.5 h-3.5" />
            <span>Back to Sign In</span>
          </Link>
        </p>
      </form>
    </AuthLayout>
  );
}
