<x-guest-layout>
    <div x-data="{ code: '', confirmed: false }">
        
        <div>
            <!-- Icon -->
            <div>
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2>Configure Two-Factor Auth</h2>
            <p>
                Add an extra layer of security to your account by scanning the QR code with your mobile authenticator app.
            </p>
        </div>

        <div>
            <!-- Setup steps -->
            <div>
                <!-- Step 1: QR Code Scan -->
                <div>
                    <!-- Fake QR Code mockup using css and simple divs -->
                    <div>
                        <div>
                            <!-- Custom grid dots to simulate QR code pattern -->
                            @for ($i = 0; $i < 36; $i++)
                                <div></div>
                            @endfor
                        </div>
                        <div>
                            Scan Me
                        </div>
                    </div>

                    <div>
                        <span>Step 1</span>
                        <p>
                            Scan this QR code using Google Authenticator or Microsoft Authenticator.
                        </p>
                        <p>
                            Key: <span>J3NZ C4NA D42A UT6Y</span>
                        </p>
                    </div>
                </div>

                <!-- Step 2: Confirm Verification Code -->
                <div>
                    <span>Step 2</span>
                    <label>Enter Verification Code</label>
                    <input type="text" x-model="code" placeholder="000 000" maxlength="6" />
                </div>
            </div>

            <!-- Backup codes -->
            <div>
                <div>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Emergency Recovery Codes</span>
                </div>
                <p>
                    Store these emergency recovery codes in a secure location. They allow access if you lose your phone.
                </p>
                <div>
                    <div>1. 28fa-67bc</div>
                    <div>2. df90-88ca</div>
                    <div>3. ac10-ff99</div>
                    <div>4. d2e3-6a7c</div>
                    <div>5. bd33-14df</div>
                    <div>6. cc90-bb78</div>
                </div>
            </div>

            <!-- Confirmation Action Buttons -->
            <div>
                <a href="{{ route('home') }}">
                    Cancel setup
                </a>
                <button @click="confirmed = true" :disabled="code.length !== 6">
                    Confirm & Enable 2FA
                </button>
            </div>
            
            <!-- Dynamic Success Toast/Modal -->
            <div x-show="confirmed" x-transition>
                <div>
                    <div>
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3>Two-Factor Auth Active</h3>
                    <p>
                        Your account is now protected with 2FA verification.
                    </p>
                    <a href="{{ route('home') }}">
                        Back to Home
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
