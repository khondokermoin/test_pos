import React from "react";
import { Head, Link, useForm } from "@inertiajs/react";

/**
 * Login Page — 100% matches templates/auth-login.html
 *
 * Template structure:
 *   <div class="auth-bg d-flex min-vh-100 justify-content-center align-items-start">
 *     <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
 *       <div class="col-xl-4 col-lg-5 col-md-6">
 *         <div class="card overflow-hidden text-center p-xxl-4 p-3 mb-0">
 *           <a href="index.html" class="auth-brand mb-4">
 *             <img src="assets/images/logo-dark.png" ...>
 *             <img src="assets/images/logo.png" ...>
 *           </a>
 *           ...form...
 *         </div>
 *         <div class="text-center mt-3">...</div>
 *       </div>
 *     </div>
 *   </div>
 *
 * Asset paths: /frontend_assets/images/* (served from public/frontend_assets/)
 */
export default function Login({ status, canResetPassword = true }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post("/login", {
            onFinish: () => reset("password"),
        });
    };

    return (
        <>
            <Head title="Log In" />

            <div className="auth-bg d-flex min-vh-100 justify-content-center align-items-start">
                <div className="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
                    <div className="col-xl-4 col-lg-5 col-md-6">
                        <div className="card overflow-hidden text-center p-xxl-4 p-3 mb-0">
                            {/* Brand Logo — exact match to template */}
                            <a href="/" className="auth-brand mb-4">
                                <img
                                    src="/frontend_assets/images/logo-dark.png"
                                    alt="dark logo"
                                    height="26"
                                    className="logo-dark"
                                />
                                <img
                                    src="/frontend_assets/images/logo.png"
                                    alt="logo light"
                                    height="26"
                                    className="logo-light"
                                />
                            </a>

                            <h4 className="fw-semibold mb-2 fs-18">
                                Log In to your account
                            </h4>

                            <p className="text-muted mb-4">
                                Enter your email address and password to access
                                admin panel.
                            </p>

                            {/* Status message (e.g. password reset success) */}
                            {status && (
                                <div
                                    className="alert alert-success text-start mb-3"
                                    role="alert"
                                >
                                    {status}
                                </div>
                            )}

                            {/* Login Form — exact match to template */}
                            <form onSubmit={submit} className="text-start">
                                <div className="mb-3">
                                    <label
                                        className="form-label"
                                        htmlFor="example-email"
                                    >
                                        Email
                                    </label>
                                    <input
                                        type="email"
                                        id="example-email"
                                        name="email"
                                        className={`form-control${errors.email ? " is-invalid" : ""}`}
                                        placeholder="Enter your email"
                                        value={data.email}
                                        onChange={(e) =>
                                            setData("email", e.target.value)
                                        }
                                        autoComplete="username"
                                        required
                                    />
                                    {errors.email && (
                                        <div className="invalid-feedback">
                                            {errors.email}
                                        </div>
                                    )}
                                </div>

                                <div className="mb-3">
                                    <label
                                        className="form-label"
                                        htmlFor="example-password"
                                    >
                                        Password
                                    </label>
                                    <input
                                        type="password"
                                        id="example-password"
                                        className={`form-control${errors.password ? " is-invalid" : ""}`}
                                        placeholder="Enter your password"
                                        value={data.password}
                                        onChange={(e) =>
                                            setData("password", e.target.value)
                                        }
                                        autoComplete="current-password"
                                        required
                                    />
                                    {errors.password && (
                                        <div className="invalid-feedback">
                                            {errors.password}
                                        </div>
                                    )}
                                </div>

                                <div className="d-flex justify-content-between mb-3">
                                    <div className="form-check">
                                        <input
                                            type="checkbox"
                                            className="form-check-input"
                                            id="checkbox-signin"
                                            checked={data.remember}
                                            onChange={(e) =>
                                                setData(
                                                    "remember",
                                                    e.target.checked,
                                                )
                                            }
                                        />
                                        <label
                                            className="form-check-label"
                                            htmlFor="checkbox-signin"
                                        >
                                            Remember me
                                        </label>
                                    </div>

                                    {canResetPassword && (
                                        <Link
                                            href="/forgot-password"
                                            className="text-muted border-bottom border-dashed"
                                        >
                                            Forget Password
                                        </Link>
                                    )}
                                </div>

                                <div className="d-grid">
                                    <button
                                        className="btn btn-primary fw-semibold"
                                        type="submit"
                                        disabled={processing}
                                    >
                                        {processing ? (
                                            <>
                                                <span
                                                    className="spinner-border spinner-border-sm me-1"
                                                    role="status"
                                                    aria-hidden="true"
                                                ></span>
                                                Signing in...
                                            </>
                                        ) : (
                                            "Log In"
                                        )}
                                    </button>
                                </div>
                            </form>
                        </div>

                        {/* Below-card links — exact match to template */}
                        <div className="text-center mt-3">
                            <p className="fs-14 mb-4">
                                Don&apos;t have an account?{" "}
                                <Link
                                    href="/register"
                                    className="fw-semibold text-danger ms-1"
                                >
                                    Sign Up !
                                </Link>
                            </p>

                            <p className="mt-auto mb-0">
                                {new Date().getFullYear()} &copy; Zircos - By{" "}
                                <a
                                    href="https://coderthemes.com/"
                                    target="_blank"
                                    rel="noreferrer"
                                    className="fw-bold text-decoration-underline text-uppercase text-reset fs-12"
                                >
                                    Coderthemes
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
