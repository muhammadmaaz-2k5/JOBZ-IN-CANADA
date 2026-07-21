<x-app-layout>
    <x-slot name="header">
        Design System Showcase
    </x-slot>

    <div x-data="{ modalOpen: false, toastOpen: false, toastType: 'success', toastMsg: 'This is a premium design system alert!' }">
        
        <!-- Intro Header Card — gradient variant -->
        <x-card variant="gradient" color="blue" padding="lg">
            <div>
                <span>
                    Design Tokens &amp; Guidelines
                </span>
                <h2>JOBZ IN CANADA Design System</h2>
                <p>
                    A modern, fully responsive design system with 6 card variants, global typography tokens, and class-based dark/light mode — crafted with TailwindCSS v4 and Alpine.js.
                </p>
            </div>
        </x-card>

        <!-- Advanced Card Variants Showcase -->
        <section>
            <h2>Advanced Card Variants</h2>
            <p>6 distinct card styles that automatically adapt to dark and light mode.</p>

            <!-- Stat Cards Row -->
            <div>
                <x-card variant="stat" label="Total Jobs Posted" value="1,284" change="+12% this month" :changeUp="true" color="blue">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/>
                        </svg>
                    </x-slot>
                </x-card>
                <x-card variant="stat" label="Active Applicants" value="8,540" change="+5.2% this week" :changeUp="true" color="green">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </x-slot>
                </x-card>
                <x-card variant="stat" label="Monthly Revenue" value="$24,890" change="-2.1% vs last month" :changeUp="false" color="purple">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </x-slot>
                </x-card>
                <x-card variant="stat" label="Verified Companies" value="342" change="+18 this week" :changeUp="true" color="amber">
                    <x-slot name="icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                        </svg>
                    </x-slot>
                </x-card>
            </div>

            <!-- Other card variants -->
            <div>
                <!-- Glass Card -->
                <x-card variant="glass" hover>
                    <x-slot name="header">Glass Card</x-slot>
                    <p>Frosted glassmorphism with blur and translucent background. Perfect for hero overlays and featured content.</p>
                    <x-slot name="footer">
                        <span>variant="glass"</span>
                    </x-slot>
                </x-card>

                <!-- Elevated Card -->
                <x-card variant="elevated" hover>
                    <x-slot name="header">Elevated Card</x-slot>
                    <p>Deep shadow elevation with a distinct header stripe. Great for primary dashboard widgets.</p>
                    <x-slot name="footer">
                        <span>variant="elevated"</span>
                    </x-slot>
                </x-card>

                <!-- Outlined Card -->
                <x-card variant="outlined">
                    <x-slot name="header">Outlined Card</x-slot>
                    <p>Transparent background with a visible 2px border that turns primary blue on hover. Clean and minimal.</p>
                    <x-slot name="footer">
                        <span>variant="outlined"</span>
                    </x-slot>
                </x-card>
            </div>

            <div>
                <!-- Flat Card -->
                <x-card variant="flat">
                    <x-slot name="header">Flat Card</x-slot>
                    <p>Subtle gray fill with no shadow or border — ideal for nested content areas inside elevated containers.</p>
                </x-card>

                <!-- Gradient Card -->
                <x-card variant="gradient" color="purple">
                    <x-slot name="header">Gradient Card</x-slot>
                    <p>Rich multi-stop gradient backgrounds with inset light effects. 6 color options: blue, green, purple, amber, rose, indigo.</p>
                    <x-slot name="footer">
                        <span>variant="gradient" color="purple"</span>
                    </x-slot>
                </x-card>
            </div>
        </section>

        <!-- 1. Color System & Typography -->
        <section>
            <h2>Color System and Typography</h2>
            <div>
                <!-- Color Palette -->
                <x-card>
                    <x-slot name="header">Primary & Accent Colors</x-slot>
                    <div>
                        <div>
                            <div></div>
                            <p>Primary 500</p>
                            <p>#2563EB (Blue)</p>
                        </div>
                        <div>
                            <div></div>
                            <p>Primary 600</p>
                            <p>#1D4ED8</p>
                        </div>
                        <div>
                            <div></div>
                            <p>Accent Gold</p>
                            <p>#D97706 (Amber)</p>
                        </div>
                        <div>
                            <div></div>
                            <p>Success</p>
                            <p>#10B981</p>
                        </div>
                        <div>
                            <div></div>
                            <p>Danger</p>
                            <p>#F43F5E</p>
                        </div>
                        <div>
                            <div></div>
                            <p>Dark 800</p>
                            <p>#0F172A</p>
                        </div>
                    </div>
                </x-card>

                <!-- Typography -->
                <x-card>
                    <x-slot name="header">Typography Hierarchy</x-slot>
                    <div>
                        <div>
                            <span>Header 1 (font-sans font-extrabold text-3xl)</span>
                            <h1>Premium Platform</h1>
                        </div>
                        <div>
                            <span>Header 2 (font-sans font-bold text-xl)</span>
                            <h2>Explore Opportunities</h2>
                        </div>
                        <div>
                            <span>Body text (font-sans text-sm text-gray-500)</span>
                            <p>
                                Find your matching jobs across Canada and grow your professional profile.
                            </p>
                        </div>
                    </div>
                </x-card>
            </div>
        </section>

        <!-- 2. Buttons & Badges -->
        <section>
            <h2>Buttons & Badges</h2>
            <div>
                <!-- Buttons Showcase -->
                <x-card>
                    <x-slot name="header">Button Variants</x-slot>
                    <div>
                        <button>
                            Solid Primary
                        </button>
                        <button>
                            Outline Button
                        </button>
                        <button>
                            Accent Gold
                        </button>
                        <button>
                            Danger Action
                        </button>
                        <button>
                            Glass Button
                        </button>
                    </div>
                </x-card>

                <!-- Badges Showcase -->
                <x-card>
                    <x-slot name="header">Badges & Tags</x-slot>
                    <div>
                        <span>
                            Remote Job
                        </span>
                        <span>
                            Verified Company
                        </span>
                        <span>
                            Urgent Role
                        </span>
                        <span>
                            Expired List
                        </span>
                    </div>
                </x-card>
            </div>
        </section>

        <!-- 3. Inputs & Forms Elements -->
        <section>
            <h2>Form Inputs & Controls</h2>
            <x-card>
                <div>
                    <div>
                        <label>Text Input</label>
                        <input type="text" placeholder="John Doe">
                    </div>
                    <div>
                        <label>Selection Menu</label>
                        <select>
                            <option>Software Engineering</option>
                            <option>Information Technology</option>
                            <option>Business Management</option>
                        </select>
                    </div>
                    <div>
                        <label>File Attachment Upload</label>
                        <input type="file">
                    </div>
                </div>
            </x-card>
        </section>

        <!-- 4. Interactive Dialog Modals & Toasts -->
        <section>
            <h2>Interactive Modals & Toast Alerts</h2>
            <div>
                <!-- Modals Control -->
                <x-card>
                    <x-slot name="header">Component Overlay Modal</x-slot>
                    <div>
                        <p>
                            Smooth, centered overlay modal with responsive backdrop blur and Alpine.js transitions.
                        </p>
                        <button @click="modalOpen = true">
                            Trigger Demo Modal
                        </button>
                    </div>
                </x-card>

                <!-- Toast Triggers -->
                <x-card>
                    <x-slot name="header">Toast Notifications</x-slot>
                    <div>
                        <p>
                            Floating toast banner triggers that support success, warning, and warning notifications.
                        </p>
                        <div>
                            <button @click="toastType = 'success'; toastMsg = 'Success! File uploaded correctly.'; toastOpen = true">
                                Success Toast
                            </button>
                            <button @click="toastType = 'warning'; toastMsg = 'Warning: Check configuration details.'; toastOpen = true">
                                Warning Toast
                            </button>
                            <button @click="toastType = 'danger'; toastMsg = 'Error: Connection lost.'; toastOpen = true">
                                Danger Toast
                            </button>
                        </div>
                    </div>
                </x-card>
            </div>
        </section>

        <!-- 5. Alerts & Skeletons -->
        <section>
            <h2>Static Alerts & Loading Placeholders</h2>
            <div>
                <!-- Alerts Block -->
                <x-card>
                    <x-slot name="header">Global Banner Alerts</x-slot>
                    <div>
                        <x-alert type="success">
                            Success! Your premium invoice has been generated correctly.
                        </x-alert>
                        <x-alert type="danger">
                            Error: Your checkout transaction was declined. Try again.
                        </x-alert>
                    </div>
                </x-card>

                <!-- Skeletons -->
                <x-card>
                    <x-slot name="header">Loading Skeletons</x-slot>
                    <div>
                        <x-skeleton type="list" :rows="2" />
                    </div>
                </x-card>
            </div>
        </section>

        <!-- 6. Empty States -->
        <section>
            <h2>Empty States</h2>
            <x-card>
                <x-empty-state 
                    title="No Job Applications Found" 
                    description="You haven't submitted any job applications yet. Begin exploring active listings to land your first interview!" 
                    actionText="Browse Active Listings" 
                    actionUrl="#"
                />
            </x-card>
        </section>

        <!-- Dynamic Slide-out Modal Code -->
        <div x-show="modalOpen">
            <div>
                <!-- Backdrop overlay -->
                <div x-show="modalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="modalOpen = false"
                ></div>

                <!-- Modal Panel -->
                <span>&#8203;</span>
                <div x-show="modalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div>
                        <div>
                            <div>
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3>Design System Interaction</h3>
                                <div>
                                    <p>
                                        This modal demonstrates centering, smooth custom vector iconography, theme adaptive colors, keyboard focus lock, and escape handler.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button @click="modalOpen = false">
                            Cancel
                        </button>
                        <button @click="modalOpen = false">
                            Confirm Action
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic Floating Toast Alert -->
        <div>
            <template x-if="toastOpen">
                <x-toast x-init="setTimeout(() => toastOpen = false, 4000)" :type="'success'">
                    <span x-text="toastMsg"></span>
                </x-toast>
            </template>
        </div>

    </div>
</x-app-layout>
