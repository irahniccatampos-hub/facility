@extends('layouts.user')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-100">Profile Settings</h1>
        <p class="text-slate-400">Update your personal information and credentials.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="bg-slate-900 border border-slate-800 rounded-lg p-5">
            <h2 class="text-lg font-semibold text-slate-100 mb-4">Personal Information</h2>
            <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full rounded-lg border-slate-700 bg-slate-800 text-slate-100" required>
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full rounded-lg border-slate-700 bg-slate-800 text-slate-100" required>
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Avatar URL</label>
                    <input type="url" name="avatar_url" value="{{ old('avatar_url', auth()->user()->avatar_url) }}" class="w-full rounded-lg border-slate-700 bg-slate-800 text-slate-100" placeholder="images/avatars/your-avatar.jpg">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2">Save changes</button>
            </form>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-lg p-5">
            <h2 class="text-lg font-semibold text-slate-100 mb-4">Change Password</h2>
            <form method="POST" action="{{ route('user.profile.password') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Current password</label>
                    <input type="password" name="current_password" class="w-full rounded-lg border-slate-700 bg-slate-800 text-slate-100" required>
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">New password</label>
                    <input type="password" name="password" class="w-full rounded-lg border-slate-700 bg-slate-800 text-slate-100" required>
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-1">Confirm new password</label>
                    <input type="password" name="password_confirmation" class="w-full rounded-lg border-slate-700 bg-slate-800 text-slate-100" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-2">Update password</button>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="mt-4 rounded-lg bg-amber-900/50 border border-amber-800 text-amber-200 text-sm p-4">
            <div class="font-semibold mb-1">There were some issues:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="mt-4 rounded-lg bg-emerald-900/50 border border-emerald-800 text-emerald-200 text-sm p-4">
            {{ session('status') }}
        </div>
    @endif
@endsection
