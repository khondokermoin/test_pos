import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AuthLayout from '../../Layouts/AuthLayout';
import { MailCheck, LogOut, RefreshCw } from 'lucide-react';

export default function VerifyEmail({ status }) {
  const { post, processing } = useForm({});

  const submit = (e) => {
    e.preventDefault();
    post('/email/verification-notification');
  };

  return (
    <AuthLayout
      title="Verify Your Email Address"
      subtitle="Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you."
    >
      <Head title="Email Verification" />

      {status === 'verification-link-sent' && (
        <div className="mb-4 text-xs font-semibold text-emerald-400 bg-emerald-500/10 p-3 rounded-xl border border-emerald-500/20">
          A new verification link has been sent to the email address you provided during registration.
        </div>
      )}

      <form onSubmit={submit} className="space-y-4">
        <button
          type="submit"
          disabled={processing}
          className="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5 px-4 rounded-xl shadow-lg shadow-indigo-600/25 flex items-center justify-center space-x-2 text-sm transition-all disabled:opacity-50"
        >
          <RefreshCw className={`w-4 h-4 ${processing ? 'animate-spin' : ''}`} />
          <span>{processing ? 'Sending...' : 'Resend Verification Email'}</span>
        </button>

        <div className="flex items-center justify-between pt-2">
          <Link
            href="/logout"
            method="post"
            as="button"
            className="w-full text-center text-xs text-slate-400 hover:text-rose-400 font-semibold transition-colors flex items-center justify-center space-x-1.5 py-1"
          >
            <LogOut className="w-3.5 h-3.5" />
            <span>Log Out</span>
          </Link>
        </div>
      </form>
    </AuthLayout>
  );
}
