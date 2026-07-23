<x-guest-layout>
    <div class="text-center">
        
        <div class="mb-8">
            <!-- Mail Icon -->
            <div class="mx-auto w-16 h-16 bg-[#1650e1]/10 text-[#1650e1] rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-gray-900 mb-3">Verify Your Email</h2>
            <p class="text-gray-500 font-medium leading-relaxed max-w-sm mx-auto">
                Thanks for joining us! We've sent a 6-digit verification code to your email. Please enter it below to activate your account.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-start gap-3 text-sm font-medium text-left">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>A new verification code has been sent to the email address you provided. Please check your spam folder if you can't find it.</span>
            </div>
        @endif

        <div class="space-y-4">
            <!-- OTP Verification Form -->
            <form method="POST" action="{{ route('verification.verify') }}">
                @csrf
                <div class="mb-6">
                    <label for="code" class="block text-left text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">6-Digit Code</label>
                    <input id="code" type="text" name="code" required autofocus autocomplete="one-time-code" maxlength="6"
                        class="w-full text-center text-2xl tracking-[0.5em] font-black py-4 px-4 border-2 border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800 rounded-xl focus:ring-[#1650e1] focus:border-[#1650e1] transition-all" 
                        placeholder="••••••">
                    <x-input-error :messages="$errors->get('code')" class="mt-2 text-left" />
                </div>
                
                <button type="submit" class="w-full bg-[#1650e1] hover:bg-[#0f3ea6] text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-[#1650e1]/30 transition-all active:scale-95 flex items-center justify-center gap-2">
                    {{ __('Verify Code') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                </button>
            </form>

            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="text-sm font-bold text-[#1650e1] hover:underline">
                        {{ __('Resend Code') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-gray-500 hover:text-gray-900">
                        {{ __('Sign Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
