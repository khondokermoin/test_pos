import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import AuthLayout from '../../Layouts/AuthLayout';
import { Lock, ShieldCheck } from 'lucide-react';

export default function ConfirmPassword() {
  const { data, setData, post, processing, errors, reset } = useForm({
    password: '',
  });

  const submit = (e) => {
    e.preventDefault();
    post('/confirm-password', {
      onFinish: () => reset('password'),
    });
  };

  return (
    <AuthLayout
      title="Security Confirmation"
      subtitle="This is a secure area of the application. Please confirm your password before continuing."
    >
      <Head title="Confirm Password" />

      <form onSubmit={submit} className="space-y-4">
        <div>
          <label className="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
            Password
          </label>
          <div className="relative">
            <Lock className="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-500" />
            <input
              id="password"
              type="password"
              value={data.password}
              onChange={(e) => setData('password', e.target.value)}
              className="w-full bg-slate-950 border border-slate-800 rounded-xl pl-9 pr-4 py-2 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"
              placeholder="••••••••"
              required
              autoFocus
            />
          </div>
          {errors.password && <p className="mt-1.5 text-xs text-rose-400 font-medium">{errors.password}</p>}
        </div>

        <button
          type="submit"
          disabled={processing}
          className="w-full mt-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5 px-4 rounded-xl shadow-lg shadow-indigo-600/25 flex items-center justify-center space-x-2 text-sm transition-all disabled:opacity-50"
        >
          <ShieldCheck className="w-4 h-4" />
          <span>{processing ? 'Confirming...' : 'Confirm Password'}</span>
        </button>
      </form>
    </AuthLayout>
  );
}
