<x-app-layout>
    <x-slot name="header">
        Design System Showcase
    </x-slot>

    <div class="space-y-12 pb-16" x-data="{ modalOpen: false, toastOpen: false, toastType: 'success', toastMsg: 'This is a premium design system alert!' }">
        
        <!-- Intro Header Card — gradient variant -->
        <x-card variant="gradient" color="blue" padding="lg" class="relative overflow-hidden">
            <div class="max-w-3xl">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white mb-4 backdrop-blur-sm">
                    Design Tokens &amp; Guidelines
                </span>
                <h2 class="text-3xl font-extrabold tracking-tight text-white">JOBZ IN CANADA Design System</h2>
                <p class="mt-2 text-lg text-blue-100">
                    A modern, fully responsive design system with 6 card variants, global typography tokens, and class-based dark/light mode — crafted with TailwindCSS v4 and Alpine.js.
                </p>
            </div>
        </x-card>

        <!-- Advanced Card Variants Showcase -->
        <section class="space-y-6">
            <h2 class="section-title">Advanced Card Variants</h2>
            <p class="page-description">6 distinct card styles that automatically adapt to dark and light mode.</p>

            <!-- Stat Cards Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                <x-card variant="stat" label="Total Jobs Posted" value="1,284" change="+12% this month" :changeUp="true" color="blue">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/>
                        </svg>
                    </x-slot>
                </x-card>
                <x-card variant="stat" label="Active Applicants" value="8,540" change="+5.2% this week" :changeUp="true" color="green">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </x-slot>
                </x-card>
                <x-card variant="stat" label="Monthly Revenue" value="$24,890" change="-2.1% vs last month" :changeUp="false" color="purple">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </x-slot>
                </x-card>
                <x-card variant="stat" label="Verified Companies" value="342" change="+18 this week" :changeUp="true" color="amber">
                    <x-slot name="icon">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                        </svg>
                    </x-slot>
                </x-card>
            </div>

            <!-- Other card variants -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Glass Card -->
                <x-card variant="glass" hover>
                    <x-slot name="header">Glass Card</x-slot>
                    <p>Frosted glassmorphism with blur and translucent background. Perfect for hero overlays and featured content.</p>
                    <x-slot name="footer">
                        <span class="text-xs font-semibold text-primary-500">variant="glass"</span>
                    </x-slot>
                </x-card>

                <!-- Elevated Card -->
                <x-card variant="elevated" hover>
                    <x-slot name="header">Elevated Card</x-slot>
                    <p>Deep shadow elevation with a distinct header stripe. Great for primary dashboard widgets.</p>
                    <x-slot name="footer">
                        <span class="text-xs font-semibold text-primary-500">variant="elevated"</span>
                    </x-slot>
                </x-card>

                <!-- Outlined Card -->
                <x-card variant="outlined">
                    <x-slot name="header">Outlined Card</x-slot>
                    <p>Transparent background with a visible 2px border that turns primary blue on hover. Clean and minimal.</p>
                    <x-slot name="footer">
                        <span class="text-xs font-semibold text-primary-500">variant="outlined"</span>
                    </x-slot>
                </x-card>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Flat Card -->
                <x-card variant="flat">
                    <x-slot name="header">Flat Card</x-slot>
                    <p>Subtle gray fill with no shadow or border — ideal for nested content areas inside elevated containers.</p>
                </x-card>

                <!-- Gradient Card -->
                <x-card variant="gradient" color="purple">
                    <x-slot name="header">Gradient Card</x-slot>
                    <p class="text-white/80">Rich multi-stop gradient backgrounds with inset light effects. 6 color options: blue, green, purple, amber, rose, indigo.</p>
                    <x-slot name="footer">
                        <span class="text-xs font-semibold text-white/60">variant="gradient" color="purple"</span>
                    </x-slot>
                </x-card>
            </div>
        </section>

        <!-- 1. Color System & Typography -->
        <section class="space-y-6">
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3">Color System and Typography</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Color Palette -->
                <x-card>
                    <x-slot name="header">Primary & Accent Colors</x-slot>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div class="space-y-2">
                            <div class="h-16 w-full rounded-xl bg-primary-500 shadow-md"></div>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">Primary 500</p>
                            <p class="text-[10px] text-gray-450">#2563EB (Blue)</p>
                        </div>
                        <div class="space-y-2">
                            <div class="h-16 w-full rounded-xl bg-primary-600 shadow-md"></div>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">Primary 600</p>
                            <p class="text-[10px] text-gray-450">#1D4ED8</p>
                        </div>
                        <div class="space-y-2">
                            <div class="h-16 w-full rounded-xl bg-accent-500 shadow-md"></div>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">Accent Gold</p>
                            <p class="text-[10px] text-gray-450">#D97706 (Amber)</p>
                        </div>
                        <div class="space-y-2">
                            <div class="h-16 w-full rounded-xl bg-emerald-500 shadow-md"></div>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">Success</p>
                            <p class="text-[10px] text-gray-455">#10B981</p>
                        </div>
                        <div class="space-y-2">
                            <div class="h-16 w-full rounded-xl bg-rose-500 shadow-md"></div>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">Danger</p>
                            <p class="text-[10px] text-gray-455">#F43F5E</p>
                        </div>
                        <div class="space-y-2">
                            <div class="h-16 w-full rounded-xl bg-dark-800 shadow-md"></div>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">Dark 800</p>
                            <p class="text-[10px] text-gray-455">#0F172A</p>
                        </div>
                    </div>
                </x-card>

                <!-- Typography -->
                <x-card>
                    <x-slot name="header">Typography Hierarchy</x-slot>
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs text-gray-450">Header 1 (font-sans font-extrabold text-3xl)</span>
                            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">Premium Platform</h1>
                        </div>
                        <div>
                            <span class="text-xs text-gray-450">Header 2 (font-sans font-bold text-xl)</span>
                            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mt-1">Explore Opportunities</h2>
                        </div>
                        <div>
                            <span class="text-xs text-gray-455">Body text (font-sans text-sm text-gray-500)</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Find your matching jobs across Canada and grow your professional profile.
                            </p>
                        </div>
                    </div>
                </x-card>
            </div>
        </section>

        <!-- 2. Buttons & Badges -->
        <section class="space-y-6">
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3">Buttons & Badges</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Buttons Showcase -->
                <x-card>
                    <x-slot name="header">Button Variants</x-slot>
                    <div class="flex flex-wrap gap-4 items-center">
                        <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 transition-colors cursor-pointer">
                            Solid Primary
                        </button>
                        <button class="inline-flex items-center px-4 py-2 border border-gray-200 dark:border-gray-700 shadow-sm text-sm font-semibold rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-dark-800 hover:bg-gray-50 dark:hover:bg-dark-700/50 transition-colors cursor-pointer">
                            Outline Button
                        </button>
                        <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-semibold rounded-xl text-white bg-accent-500 hover:bg-accent-600 transition-colors cursor-pointer">
                            Accent Gold
                        </button>
                        <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-semibold rounded-xl text-white bg-rose-500 hover:bg-rose-600 transition-colors cursor-pointer">
                            Danger Action
                        </button>
                        <button class="glass inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl text-primary-500 hover:bg-primary-50/50 dark:hover:bg-primary-950/20 transition-all duration-300 cursor-pointer">
                            Glass Button
                        </button>
                    </div>
                </x-card>

                <!-- Badges Showcase -->
                <x-card>
                    <x-slot name="header">Badges & Tags</x-slot>
                    <div class="flex flex-wrap gap-4 items-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                            Remote Job
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                            Verified Company
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                            Urgent Role
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400">
                            Expired List
                        </span>
                    </div>
                </x-card>
            </div>
        </section>

        <!-- 3. Inputs & Forms Elements -->
        <section class="space-y-6">
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3">Form Inputs & Controls</h2>
            <x-card>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Text Input</label>
                        <input type="text" placeholder="John Doe" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Selection Menu</label>
                        <select class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-dark-800 text-gray-900 dark:text-gray-100 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors">
                            <option>Software Engineering</option>
                            <option>Information Technology</option>
                            <option>Business Management</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">File Attachment Upload</label>
                        <input type="file" class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 dark:file:bg-primary-950/20 dark:file:text-primary-400 hover:file:bg-primary-100 transition-colors">
                    </div>
                </div>
            </x-card>
        </section>

        <!-- 4. Interactive Dialog Modals & Toasts -->
        <section class="space-y-6">
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3">Interactive Modals & Toast Alerts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Modals Control -->
                <x-card>
                    <x-slot name="header">Component Overlay Modal</x-slot>
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Smooth, centered overlay modal with responsive backdrop blur and Alpine.js transitions.
                        </p>
                        <button @click="modalOpen = true" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 transition-colors cursor-pointer">
                            Trigger Demo Modal
                        </button>
                    </div>
                </x-card>

                <!-- Toast Triggers -->
                <x-card>
                    <x-slot name="header">Toast Notifications</x-slot>
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Floating toast banner triggers that support success, warning, and warning notifications.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <button @click="toastType = 'success'; toastMsg = 'Success! File uploaded correctly.'; toastOpen = true" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500 text-white hover:bg-emerald-600 transition-colors cursor-pointer">
                                Success Toast
                            </button>
                            <button @click="toastType = 'warning'; toastMsg = 'Warning: Check configuration details.'; toastOpen = true" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-amber-500 text-white hover:bg-amber-600 transition-colors cursor-pointer">
                                Warning Toast
                            </button>
                            <button @click="toastType = 'danger'; toastMsg = 'Error: Connection lost.'; toastOpen = true" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-rose-500 text-white hover:bg-rose-600 transition-colors cursor-pointer">
                                Danger Toast
                            </button>
                        </div>
                    </div>
                </x-card>
            </div>
        </section>

        <!-- 5. Alerts & Skeletons -->
        <section class="space-y-6">
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3">Static Alerts & Loading Placeholders</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Alerts Block -->
                <x-card>
                    <x-slot name="header">Global Banner Alerts</x-slot>
                    <div class="space-y-4">
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
                    <div class="space-y-6">
                        <x-skeleton type="list" :rows="2" />
                    </div>
                </x-card>
            </div>
        </section>

        <!-- 6. Empty States -->
        <section class="space-y-6">
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white border-l-4 border-primary-500 pl-3">Empty States</h2>
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
        <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop overlay -->
                <div x-show="modalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="modalOpen = false" 
                     class="fixed inset-0 bg-gray-500/75 dark:bg-black/80 backdrop-blur-sm transition-opacity"
                ></div>

                <!-- Modal Panel -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="modalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative inline-block align-bottom bg-white dark:bg-dark-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100 dark:border-gray-800"
                >
                    <div class="p-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 dark:bg-primary-950/20 text-primary-500 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Design System Interaction</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        This modal demonstrates centering, smooth custom vector iconography, theme adaptive colors, keyboard focus lock, and escape handler.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 dark:bg-dark-900/50 border-t border-gray-150 dark:border-gray-800/80 flex justify-end space-x-3">
                        <button @click="modalOpen = false" class="px-4 py-2 text-sm font-semibold rounded-xl border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-100 transition-colors cursor-pointer">
                            Cancel
                        </button>
                        <button @click="modalOpen = false" class="px-4 py-2 text-sm font-semibold rounded-xl text-white bg-primary-500 hover:bg-primary-600 transition-colors cursor-pointer">
                            Confirm Action
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic Floating Toast Alert -->
        <div class="fixed bottom-0 right-0 p-6 z-50 w-full max-w-sm space-y-4 pointer-events-none" style="position: fixed;">
            <template x-if="toastOpen">
                <x-toast x-init="setTimeout(() => toastOpen = false, 4000)" :type="'success'">
                    <span x-text="toastMsg"></span>
                </x-toast>
            </template>
        </div>

    </div>
</x-app-layout>
