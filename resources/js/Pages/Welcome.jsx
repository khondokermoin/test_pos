import React from "react";
import { Head, Link } from "@inertiajs/react";

/**
 * Welcome — Public landing page (no auth required).
 *
 * IMPORTANT: This page must NOT use AdminMasterLayout, CompanySidebar,
 * BranchSidebar, or any authenticated layout component. Those layouts
 * depend on auth.user props that are null for unauthenticated visitors,
 * which causes the Sidebar/Topbar to bleed into guest pages like /login.
 *
 * This is a standalone page with its own minimal layout.
 */
export default function Welcome() {
    return (
        <>
            <Head title="Welcome to Cloud POS" />

            <div className="min-h-screen bg-slate-950 text-slate-100 flex flex-col">
                {/* ── Navbar ── */}
                <nav className="border-b border-slate-800 px-6 py-4 flex items-center justify-between">
                    <Link href="/" className="flex items-center space-x-3">
                        <div className="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-extrabold text-lg shadow-lg shadow-indigo-600/30">
                            P
                        </div>
                        <span className="font-extrabold text-white text-xl tracking-tight">
                            Cloud POS
                        </span>
                    </Link>

                    <div className="flex items-center space-x-3">
                        <Link
                            href="/login"
                            className="text-sm text-slate-300 hover:text-white font-medium transition-colors px-4 py-2 rounded-lg hover:bg-slate-800"
                        >
                            Sign In
                        </Link>
                        <Link
                            href="/register"
                            className="text-sm bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-4 py-2 rounded-lg transition-colors shadow-lg shadow-indigo-600/25"
                        >
                            Get Started
                        </Link>
                    </div>
                </nav>

                {/* ── Hero Section ── */}
                <main className="flex-1 flex flex-col items-center justify-center text-center px-6 py-20">
                    <div className="max-w-3xl space-y-6">
                        <div className="inline-flex items-center space-x-2 bg-indigo-600/10 border border-indigo-500/20 rounded-full px-4 py-1.5 text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                            <span>SaaS Point of Sale System</span>
                        </div>

                        <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight tracking-tight">
                            Manage Your Business
                            <span className="text-indigo-400"> Smarter</span>
                        </h1>

                        <p className="text-slate-400 text-lg max-w-xl mx-auto leading-relaxed">
                            A powerful multi-tenant Cloud POS and Inventory
                            Management system built for retail businesses of all
                            sizes.
                        </p>

                        <div className="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                            <Link
                                href="/login"
                                className="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-3 rounded-xl shadow-xl shadow-indigo-600/30 transition-all text-sm"
                            >
                                Sign In to Dashboard
                            </Link>
                            <Link
                                href="/register"
                                className="w-full sm:w-auto bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold px-8 py-3 rounded-xl border border-slate-700 transition-all text-sm"
                            >
                                Create Free Account
                            </Link>
                        </div>
                    </div>
                </main>

                {/* ── Feature Cards ── */}
                <section className="px-6 pb-20">
                    <div className="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
                        {[
                            {
                                title: "Laravel 12 Backend",
                                desc: "Robust REST / Inertia controller architecture with Spatie RBAC.",
                                color: "text-indigo-400",
                                bg: "bg-indigo-600/10 border-indigo-500/20",
                            },
                            {
                                title: "React + Inertia.js",
                                desc: "Seamless SPA experience without a separate API layer.",
                                color: "text-emerald-400",
                                bg: "bg-emerald-600/10 border-emerald-500/20",
                            },
                            {
                                title: "Multi-Tenant SaaS",
                                desc: "Super Admin, Company Admin, Manager, and Salesman roles.",
                                color: "text-sky-400",
                                bg: "bg-sky-600/10 border-sky-500/20",
                            },
                        ].map((card) => (
                            <div
                                key={card.title}
                                className={`rounded-2xl border p-6 ${card.bg} space-y-2`}
                            >
                                <h3
                                    className={`font-bold text-sm ${card.color}`}
                                >
                                    {card.title}
                                </h3>
                                <p className="text-slate-400 text-xs leading-relaxed">
                                    {card.desc}
                                </p>
                            </div>
                        ))}
                    </div>
                </section>

                {/* ── Footer ── */}
                <footer className="border-t border-slate-800 px-6 py-4 text-center text-xs text-slate-500">
                    &copy; {new Date().getFullYear()} Cloud POS SaaS. All rights
                    reserved.
                </footer>
            </div>
        </>
    );
}
