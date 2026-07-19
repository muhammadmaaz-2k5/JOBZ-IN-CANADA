<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-4"
         x-data="{
            otp: ['', '', '', '', '', ''],
            timer: 59,
            canResend: false,
            handleInput(index, event) {
                let val = event.target.value;
                this.otp[index] = val.slice(-1);
                if (val && index < 5) {
                    this.$refs['otp' + (index + 1)].focus();
                }
            },
            handleKeyDown(index, event) {
                if (event.key === 'Backspace' && !this.otp[index] && index > 0) {
                    this.otp[index - 1] = '';
                    this.$refs['otp' + (index - 1)].focus();
                }
            },
            handlePaste(event) {
                event.preventDefault();
                let text = (event.clipboardData || window.clipboardData).getData('text').trim();
                if (/^\d{6}$/.test(text)) {
                    for (let i = 0; i < 6; i++) {
                        this.otp[i] = text[i];
                    }
                    this.$refs.otp5.focus();
                }
            },
            get code() {
                return this.otp.join('');
            },
            init() {
                let interval = setInterval(() => {
                    if (this.timer > 0) {
                        this.timer--;
                    } else {
                        this.canResend = true;
                        clearInterval(interval);
                    }
                }, 1000);
            }
         }"
    >
        <div class="mb-6 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-2xl bg-primary-50 dark:bg-primary-950/20 text-primary-500 mb-4 animate-pulse-slow">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">OTP Verification</h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                We've sent a 6-digit confirmation code to your device. Please check and input it below.
            </p>
        </div>

        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-6">
            @csrf

            <!-- Hidden input holding the full code -->
            <input type="hidden" name="otp" :value="code">

            <!-- 6 Digit Input Fields Container -->
            <div class="flex justify-between items-center gap-2 max-w-xs mx-auto" @paste="handlePaste">
                <template x-for="(digit, index) in 6" :key="index">
                    <input 
                        type="text" 
                        pattern="[0-9]*" 
                        inputmode="numeric" 
                        maxlength="1" 
                        :x-ref="'otp' + index"
                        :value="otp[index]"
                        @input="handleInput(index, $event)"
                        @keydown="handleKeyDown(index, $event)"
                        class="w-12 h-14 text-center text-xl font-bold rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors"
                        required
                        :autofocus="index === 0"
                    />
                </template>
            </div>

            <!-- Error message container -->
            <x-input-error :messages="$errors->get('otp')" class="text-center mt-2" />

            <div class="pt-2">
                <x-primary-button class="w-full justify-center py-3" ::disabled="code.length !== 6">
                    {{ __('Verify Code') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-6 text-center text-xs">
            <span class="text-gray-400">Didn't receive the code?</span>
            <button x-show="!canResend" class="text-gray-500 font-semibold cursor-not-allowed ml-1" disabled>
                Resend in <span x-text="'0:' + (timer < 10 ? '0' + timer : timer)"></span>
            </button>
            <button x-show="canResend" @click="timer = 59; canResend = false; init()" class="text-primary-500 font-semibold hover:underline ml-1 cursor-pointer">
                Resend Code
            </button>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-150 dark:border-gray-800 text-center text-xs text-gray-400">
            Preview Code: Use <span class="font-bold text-gray-600 dark:text-gray-200 font-mono bg-gray-100 dark:bg-dark-800 px-1 py-0.5 rounded">123456</span> to test success.
        </div>
    </div>
</x-guest-layout>
