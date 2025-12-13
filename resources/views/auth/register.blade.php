@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white border border-slate-200 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-slate-900 mb-4">Create an account</h2>
        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-slate-600 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-slate-200">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border-slate-200">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Password</label>
                <input type="password" name="password" required class="w-full rounded-lg border-slate-200">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full rounded-lg border-slate-200">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2">Register</button>
        </form>
    </div>
@endsection
