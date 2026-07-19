<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-2" x-data="{ code: '', confirmed: false }">
        
        <div class="mb-6 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-2xl bg-primary-50 dark:bg-primary-950/20 text-primary-500 mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Configure Two-Factor Auth</h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-450 leading-relaxed">
                Add an extra layer of security to your account by scanning the QR code with your mobile authenticator app.
            </p>
        </div>

        <div class="space-y-6">
            <!-- Setup steps -->
            <div class="space-y-4">
                <!-- Step 1: QR Code Scan -->
                <div class="flex flex-col sm:flex-row items-center gap-4 bg-gray-50 dark:bg-dark-850 p-4 rounded-2xl border border-gray-150 dark:border-gray-800">
                    <!-- Fake QR Code mockup using css and simple divs -->
                    <div class="w-28 h-28 bg-white p-2 rounded-xl shadow-sm border border-gray-200 shrink-0 flex items-center justify-center relative group">
                        <div class="w-24 h-24 bg-dark-900 grid grid-cols-6 gap-0.5 p-1 rounded">
                            <!-- Custom grid dots to simulate QR code pattern -->
                            @for ($i = 0; $i < 36; $i++)
                                <div class="rounded-sm {{ ($i % 3 == 0 || $i % 7 == 0 || $i < 7 || $i > 29) ? 'bg-dark-900' : 'bg-white' }} {{ ($i == 0 || $i == 1 || $i == 6 || $i == 7 || $i == 30 || $i == 35) ? 'bg-black' : '' }}"></div>
                            @endfor
                        </div>
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-xl flex items-center justify-center text-[10px] text-white font-bold">
                            Scan Me
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <span class="text-[10px] font-extrabold uppercase bg-primary-100 dark:bg-primary-950/30 text-primary-600 dark:text-primary-400 px-2 py-0.5 rounded-full">Step 1</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-normal">
                            Scan this QR code using Google Authenticator or Microsoft Authenticator.
                        </p>
                        <p class="text-[11px] font-semibold text-gray-400">
                            Key: <span class="font-mono text-gray-700 dark:text-gray-300">J3NZ C4NA D42A UT6Y</span>
                        </p>
                    </div>
                </div>

                <!-- Step 2: Confirm Verification Code -->
                <div class="space-y-2">
                    <span class="text-[10px] font-extrabold uppercase bg-primary-100 dark:bg-primary-950/30 text-primary-600 dark:text-primary-400 px-2 py-0.5 rounded-full">Step 2</span>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mt-2">Enter Verification Code</label>
                    <input type="text" x-model="code" placeholder="000 000" maxlength="6" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors text-sm font-mono tracking-widest text-center" />
                </div>
            </div>

            <!-- Backup codes -->
            <div class="bg-amber-500/5 p-4 rounded-2xl border border-amber-500/20 space-y-3">
                <div class="flex items-center text-amber-500 font-bold text-xs gap-1.5">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Emergency Recovery Codes</span>
                </div>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-normal">
                    Store these emergency recovery codes in a secure location. They allow access if you lose your phone.
                </p>
                <div class="grid grid-cols-2 gap-2 text-xs font-mono text-gray-700 dark:text-gray-300 bg-white dark:bg-dark-900/50 p-2.5 rounded-xl border border-gray-150 dark:border-gray-800">
                    <div>1. 28fa-67bc</div>
                    <div>2. df90-88ca</div>
                    <div>3. ac10-ff99</div>
                    <div>4. d2e3-6a7c</div>
                    <div>5. bd33-14df</div>
                    <div>6. cc90-bb78</div>
                </div>
            </div>

            <!-- Confirmation Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-150 dark:border-gray-800">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 hover:underline transition-colors cursor-pointer">
                    Cancel setup
                </a>
                <button @click="confirmed = true" :disabled="code.length !== 6" class="inline-flex items-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 transition-colors cursor-pointer disabled:opacity-50">
                    Confirm & Enable 2FA
                </button>
            </div>
            
            <!-- Dynamic Success Toast/Modal -->
            <div x-show="confirmed" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
                <div class="bg-white dark:bg-dark-800 p-6 rounded-2xl border border-gray-150 dark:border-gray-800 max-w-sm w-full text-center space-y-4">
                    <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-950/20 text-emerald-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Two-Factor Auth Active</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-normal">
                        Your account is now protected with 2FA verification.
                    </p>
                    <a href="{{ route('home') }}" class="block w-full px-4 py-2 rounded-xl text-white bg-primary-500 hover:bg-primary-600 font-semibold text-sm transition-colors text-center">
                        Back to Home
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
