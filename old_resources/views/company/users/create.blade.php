@extends('layouts.admin_master')

@section('title', 'Add New Staff/User')

@section('content')
<div class="mb-2 row">
    <div class="col-sm-6">
        <h4 class="page-title">Add New Staff / User</h4>
    </div>
    <div class="col-sm-6 text-sm-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end mb-0">
                <li class="breadcrumb-item"><a href="{{ route('company.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('company.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">Add User</li>
            </ol>
        </nav>
    </div>
</div>

<form action="{{ route('company.users.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="Company Admin">Company Admin</option>
                        <option value="Branch Manager">Branch Manager</option>
                        <option value="Cashier">Cashier</option>
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- ✅ এখানেই মূল সমাধান: ব্রাঞ্চ অ্যাসাইনমেন্ট --}}
                <div class="mb-3 col-md-6">
                    <label for="branch_id" class="form-label">Assign to Branch <span class="text-danger">*</span></label>
                    <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id" required>
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Company Admin-এর জন্য এটি খালি রাখা যাবে, কিন্তু Branch Manager/Cashier-এর জন্য অবশ্যই সিলেক্ট করতে হবে।</small>
                    @error('branch_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary">Save User</button>
                <a href="{{ route('company.users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection