@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white border border-slate-200 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-slate-900 mb-4">Login</h2>
        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-slate-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border-slate-200">
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Password</label>
                <input type="password" name="password" required class="w-full rounded-lg border-slate-200">
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded">
                    Remember me
                </label>
                <a href="{{ route('register') }}" class="text-sm text-blue-600">Register</a>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2">Login</button>
        </form>
    </div>
@endsection
