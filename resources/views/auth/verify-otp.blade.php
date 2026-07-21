<x-guest-layout>
    <div
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
        <div>
            <!-- Icon -->
            <div>
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h2>OTP Verification</h2>
            <p>
                We've sent a 6-digit confirmation code to your device. Please check and input it below.
            </p>
        </div>

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf

            <!-- Hidden input holding the full code -->
            <input type="hidden" name="otp" :value="code">

            <!-- 6 Digit Input Fields Container -->
            <div @paste="handlePaste">
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
                        required
                        :autofocus="index === 0"
                    />
                </template>
            </div>

            <!-- Error message container -->
            <x-input-error :messages="$errors->get('otp')" />

            <div>
                <x-primary-button ::disabled="code.length !== 6">
                    {{ __('Verify Code') }}
                </x-primary-button>
            </div>
        </form>

        <div>
            <span>Didn't receive the code?</span>
            <button x-show="!canResend" disabled>
                Resend in <span x-text="'0:' + (timer < 10 ? '0' + timer : timer)"></span>
            </button>
            <button x-show="canResend" @click="timer = 59; canResend = false; init()">
                Resend Code
            </button>
        </div>

        <div>
            Preview Code: Use <span>123456</span> to test success.
        </div>
    </div>
</x-guest-layout>
