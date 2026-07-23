import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthLayout from '../../Layouts/AuthLayout';
import { Mail, Lock, LogIn, CheckSquare, Square } from 'lucide-react';

export default function Login({ status, canResetPassword = true }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    email: '',
    password: '',
    remember: false,
  });

  const submit = (e) => {
    e.preventDefault();
    post('/login', {
      onFinish: () => reset('password'),
    });
  };

  return (
    <AuthLayout title="Sign In to Your Account" subtitle="Enter your credentials to access the POS terminal">
      <Head title="Sign In" />

      {status && (
        <div className="mb-4 text-xs font-semibold text-emerald-400 bg-emerald-500/10 p-3 rounded-xl border border-emerald-500/20">
          {status}
        </div>
      )}

      <form onSubmit={submit} className="space-y-4">
        {/* Email Field */}
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
              autoComplete="username"
              required
            />
          </div>
          {errors.email && <p className="mt-1.5 text-xs text-rose-400 font-medium">{errors.email}</p>}
        </div>

        {/* Password Field */}
        <div>
          <div className="flex items-center justify-between mb-1.5">
            <label className="block text-xs font-bold text-slate-300 uppercase tracking-wider">
              Password
            </label>
            {canResetPassword && (
              <Link
                href="/forgot-password"
                className="text-xs text-indigo-400 hover:text-indigo-300 transition-colors"
              >
                Forgot password?
              </Link>
            )}
          </div>
          <div className="relative">
            <Lock className="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-500" />
            <input
              id="password"
              type="password"
              value={data.password}
              onChange={(e) => setData('password', e.target.value)}
              className="w-full bg-slate-950 border border-slate-800 rounded-xl pl-9 pr-4 py-2 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"
              placeholder="••••••••"
              autoComplete="current-password"
              required
            />
          </div>
          {errors.password && <p className="mt-1.5 text-xs text-rose-400 font-medium">{errors.password}</p>}
        </div>

        {/* Remember Me */}
        <div className="flex items-center justify-between pt-1">
          <label className="flex items-center cursor-pointer space-x-2 text-xs text-slate-300 select-none">
            <input
              type="checkbox"
              checked={data.remember}
              onChange={(e) => setData('remember', e.target.checked)}
              className="sr-only"
            />
            {data.remember ? (
              <CheckSquare className="w-4 h-4 text-indigo-500" />
            ) : (
              <Square className="w-4 h-4 text-slate-600" />
            )}
            <span>Remember me on this device</span>
          </label>
        </div>

        {/* Submit Button */}
        <button
          type="submit"
          disabled={processing}
          className="w-full mt-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5 px-4 rounded-xl shadow-lg shadow-indigo-600/25 flex items-center justify-center space-x-2 text-sm transition-all disabled:opacity-50"
        >
          <LogIn className="w-4 h-4" />
          <span>{processing ? 'Signing in...' : 'Sign In'}</span>
        </button>

        {/* Register link */}
        <p className="text-center text-xs text-slate-400 pt-3">
          Don't have an account?{' '}
          <Link href="/register" className="text-indigo-400 hover:text-indigo-300 font-semibold transition-colors">
            Register here
          </Link>
        </p>
      </form>
    </AuthLayout>
  );
}
