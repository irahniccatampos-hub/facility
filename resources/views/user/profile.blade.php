@extends('layouts.user')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Profile Settings</h1>
        <p class="text-slate-600 mt-1">Update your personal information and credentials</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Personal Information Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 rounded-xl bg-blue-50">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Personal Information</h2>
                    <p class="text-sm text-slate-500">Update your name and contact details</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Email Address *</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Profile Avatar URL</label>
                    <input type="url" name="avatar_url" value="{{ old('avatar_url', auth()->user()->avatar_url) }}"
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                           placeholder="https://example.com/avatar.jpg">
                    <p class="mt-1 text-xs text-slate-500">Link to your profile image (optional)</p>
                </div>
                <input type="submit"
                        value="Save Changes"
                        class="w-full text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3.5 text-center transition duration-200 cursor-pointer">
            </form>
        </div>

        <!-- Password Change Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 rounded-xl bg-emerald-50">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Change Password</h2>
                    <p class="text-sm text-slate-500">Update your security credentials</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('user.profile.password') }}" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Current Password *</label>
                    <input type="password" name="current_password" required
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">New Password *</label>
                    <input type="password" name="password" required
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                    <p class="mt-1 text-xs text-slate-500">At least 8 characters with letters and numbers</p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Confirm New Password *</label>
                    <input type="password" name="password_confirmation" required
                           class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                </div>
                <input type="submit"
                        value="Update Password"
                        class="w-full text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3.5 text-center transition duration-200 cursor-pointer">
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="mt-6 rounded-xl bg-amber-50 border border-amber-200 p-5">
            <div class="flex items-center mb-3">
                <svg class="w-5 h-5 text-amber-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <h3 class="text-sm font-semibold text-amber-800">Please fix the following issues:</h3>
            </div>
            <ul class="text-sm text-amber-700 list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="mt-6 rounded-xl bg-emerald-50 border border-emerald-200 p-5">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-emerald-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-medium text-emerald-800">{{ session('status') }}</p>
            </div>
        </div>
    @endif
@endsection
