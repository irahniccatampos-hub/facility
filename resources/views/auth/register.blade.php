@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 text-center">
                <h2 class="text-2xl font-bold text-white">Create Account</h2>
                <p class="text-blue-100 text-sm mt-1">Join our facility reservation system</p>
            </div>
            
            <div class="p-6">
                <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                               class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Password</label>
                        <input type="password" name="password" required 
                               class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5">
                        <p class="mt-1 text-xs text-slate-500">Must be at least 8 characters long</p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" required 
                               class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5">
                    </div>
                    
                    <div class="flex items-center">
                        <input id="terms" type="checkbox" value="" required
                               class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                        <label for="terms" class="ml-2 text-sm text-slate-600">
                            I agree to the <a href="#" class="text-blue-600 hover:text-blue-700">Terms & Conditions</a>
                        </label>
                    </div>
                    
                    <input type="submit"
                           value="Create Account"
                           class="w-full text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3.5 text-center transition duration-200 shadow-lg">
                </form>
                
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <p class="text-center text-sm text-slate-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-700 ml-1">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
