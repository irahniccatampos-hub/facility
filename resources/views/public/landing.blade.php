@extends('layouts.app')

@section('content')
    <div class="grid md:grid-cols-2 gap-10 items-center">
        <div>
            <p class="text-sm uppercase tracking-wide text-blue-600 font-semibold">Facility Reservation</p>
            <h1 class="text-4xl font-bold text-slate-900 mt-2">Plan, approve, and track every room booking with clarity.</h1>
            <p class="mt-4 text-slate-600">Centralize reservations with live conflict detection, admin approvals, and analytics on usage and peak hours.</p>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Get Started</a>
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-slate-200 text-slate-800 hover:bg-slate-100">Login</a>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-slate-500 text-sm">Next booking</div>
                    <div class="text-2xl font-semibold text-slate-900">Conference Room A</div>
                </div>
                <span class="px-3 py-1 text-xs rounded-full bg-emerald-50 text-emerald-700">Live preview</span>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="text-sm text-slate-500">Pending approvals</div>
                    <div class="text-3xl font-semibold text-slate-900">12</div>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="text-sm text-slate-500">Utilization</div>
                    <div class="text-3xl font-semibold text-slate-900">78%</div>
                </div>
            </div>
            <div class="mt-6">
                <div class="text-sm text-slate-500 mb-2">Calendar glimpse</div>
                <div class="grid grid-cols-7 gap-2 text-center text-xs text-slate-500">
                    @for($i = 1; $i <= 14; $i++)
                        <div class="rounded-md border border-slate-100 py-3 @if($i % 3 === 0) bg-blue-50 text-blue-600 border-blue-100 @endif">{{ $i }}</div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
@endsection
