@extends('layouts.app')

@section('content')
    <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">
                🚀 Facility Reservation System
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 leading-tight">
                Smart Facility Management
                <span class="text-blue-600">Made Simple</span>
            </h1>
            <p class="text-lg text-slate-600 leading-relaxed">
                Centralize reservations with live conflict detection, automated admin approvals, 
                and comprehensive analytics on usage and peak hours. Everything you need in one platform.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-base font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-300 transition duration-200 shadow-lg">
                    Get Started Free
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-base font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:ring-4 focus:ring-blue-100 transition duration-200 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Sign In
                </a>
            </div>
            <div class="pt-6">
                <div class="flex items-center gap-4 text-sm text-slate-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Live Conflict Detection</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>AI Assistant</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Real-time Analytics</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="relative">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6 transform hover:scale-[1.02] transition duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <div class="text-slate-500 text-sm font-medium">Live Dashboard Preview</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">Conference Room A</div>
                    </div>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Active Now
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-4 border border-blue-100">
                        <div class="text-sm text-blue-600 font-medium">Pending Approvals</div>
                        <div class="text-3xl font-bold text-slate-900 mt-2">12</div>
                        <div class="text-xs text-slate-500 mt-1">Awaiting review</div>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl p-4 border border-emerald-100">
                        <div class="text-sm text-emerald-600 font-medium">Utilization Rate</div>
                        <div class="text-3xl font-bold text-slate-900 mt-2">78%</div>
                        <div class="text-xs text-slate-500 mt-1">This week</div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="text-sm font-medium text-slate-700 mb-3">Calendar Overview</div>
                    <div class="grid grid-cols-7 gap-2 text-center">
                        @for($i = 1; $i <= 14; $i++)
                            <div class="rounded-lg border border-slate-100 py-3 text-sm font-medium
                                @if($i % 3 === 0) bg-gradient-to-br from-blue-50 to-white text-blue-600 border-blue-200 @else text-slate-700 @endif">
                                {{ $i }}
                            </div>
                        @endfor
                    </div>
                </div>
                
                <div class="text-xs text-slate-500 text-center pt-4 border-t border-slate-100">
                    Live data updates every 5 minutes
                </div>
            </div>
            
            <!-- Floating elements for visual appeal -->
            <div class="absolute -top-4 -right-4 w-24 h-24 bg-blue-100 rounded-full blur-xl opacity-30"></div>
            <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-emerald-100 rounded-full blur-xl opacity-20"></div>
        </div>
    </div>
@endsection