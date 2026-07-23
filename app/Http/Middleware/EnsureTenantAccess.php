<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantAccess
{
    /**
     * Handle an incoming request.
     *
     * This middleware enforces SaaS multi-tenant isolation.
     * It prevents a user from one company from accessing another company's data
     * by checking that any company_id present in the route or request body
     * matches the authenticated user's own company_id.
     *
     * Super Admins bypass this check entirely (they manage all tenants).
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        // If no user is authenticated, let the 'auth' middleware handle it.
        if (! $user) {
            return $next($request);
        }

        // Super Admins have global access — skip tenant check.
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // --- Tenant Isolation Check ---
        // Collect any company_id that appears in the route parameters or request body.
        $requestedCompanyId = $request->route('company_id')
            ?? $request->route('company')  // Route model binding (Company object)
            ?? $request->input('company_id');

        // If a route model binding resolved a Company object, extract its ID.
        if ($requestedCompanyId instanceof \App\Models\Company) {
            $requestedCompanyId = $requestedCompanyId->id;
        }

        // If a company_id was found in the request, verify it matches the user's tenant.
        if ($requestedCompanyId !== null) {
            if ((int) $requestedCompanyId !== (int) $user->company_id) {
                abort(403, 'Access denied: You do not have permission to access this company\'s data.');
            }
        }

        // --- Branch Isolation Check ---
        // For branch-level users (Manager, Salesman), also verify branch ownership.
        $requestedBranchId = $request->route('branch_id')
            ?? $request->route('branch')
            ?? $request->input('branch_id');

        if ($requestedBranchId instanceof \App\Models\Branch) {
            $requestedBranchId = $requestedBranchId->id;
        }

        // Only enforce branch check if the user has a branch_id assigned.
        if ($requestedBranchId !== null && $user->branch_id !== null) {
            if ((int) $requestedBranchId !== (int) $user->branch_id) {
                abort(403, 'Access denied: You do not have permission to access this branch\'s data.');
            }
        }

        return $next($request);
    }
}
