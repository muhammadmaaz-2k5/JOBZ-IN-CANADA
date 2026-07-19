<x-app-layout>
    <x-slot name="header">
        Design System Showcase
    </x-slot>

    <div class="space-y-12 pb-16" x-data="{ modalOpen: false, toastOpen: false, toastType: 'success', toastMsg: 'This is a premium design system alert!' }">
        
        <!-- Intro Header Card -->
        <x-card class="relative overflow-hidden bg-gradient-to-r from-primary-600 to-indigo-700 text-white border-0 shadow-2xl">
            <div class="relative z-10 max-w-3xl">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white mb-4 backdrop-blur-sm">
                    Design Tokens & Guidelines
                </span>
                <h2 class="text-3xl font-extrabold tracking-tight">JOBZ IN CANADA Design System</h2>
                <p class="mt-2 text-lg text-primary-100">
                    A modern, highly performant, and fully responsive design system crafted with TailwindCSS v4 and Alpine.js. Includes clean interactions, premium shadows, and class-based dark mode.
                </p>
            </div>
            <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-10 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-white to-transparent pointer-events-none"></div>
        </x-card>

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
