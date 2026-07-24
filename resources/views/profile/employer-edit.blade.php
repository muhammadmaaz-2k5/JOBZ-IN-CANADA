<x-app-layout>
    <x-slot name="header">
        Employer & Company Profile
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8 relative z-10">
        
        <!-- Decorative blurred background elements -->
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-emerald-400/10 blur-[120px]"></div>
            <div class="absolute bottom-[10%] -left-[10%] w-[40%] h-[60%] rounded-full bg-blue-400/10 blur-[120px]"></div>
        </div>

        <!-- Top Action Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Company Branding</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">Manage your employer identity and company details</p>
            </div>
            <a href="{{ route('employer.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm hover:bg-gray-50 dark:hover:bg-slate-700/80 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        @if(session('warning'))
            <x-alert type="warning">
                {{ session('warning') }}
            </x-alert>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <!-- Left Column: Verification & Profile Card -->
            <div class="xl:col-span-1 space-y-8">
                <!-- Verification Status -->
                <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-8 relative overflow-hidden text-center flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mb-4 relative z-10 shadow-lg 
                        @if($company->verification_status === 'verified') bg-gradient-to-br from-emerald-400 to-emerald-600 text-white
                        @elseif($company->verification_status === 'rejected') bg-gradient-to-br from-red-400 to-red-600 text-white
                        @else bg-gradient-to-br from-amber-400 to-amber-600 text-white @endif">
                        @if($company->verification_status === 'verified')
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        @elseif($company->verification_status === 'rejected')
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        @else
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @endif
                    </div>

                    <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2 relative z-10">
                        @if($company->verification_status === 'verified') <span class="text-emerald-600 dark:text-emerald-400">Verified Employer</span>
                        @elseif($company->verification_status === 'rejected') <span class="text-red-600 dark:text-red-400">Verification Rejected</span>
                        @else <span class="text-amber-600 dark:text-amber-400">Pending Approval</span> @endif
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium relative z-10">
                        @if($company->verification_status === 'verified') Your company is officially verified and can post jobs.
                        @elseif($company->verification_status === 'rejected') Your company profile did not pass verification.
                        @else Only verified employers can post job openings to Jobz In Canada. @endif
                    </p>

                    @if($company->verification_status === 'verified')
                        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-emerald-400 opacity-10 rounded-full blur-xl pointer-events-none"></div>
                    @endif
                </div>

                <!-- Company Logo Overview -->
                <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-8 flex flex-col items-center justify-center">
                    <div class="w-32 h-32 rounded-3xl bg-gray-50 dark:bg-slate-800 border-4 border-white dark:border-slate-700 shadow-xl flex items-center justify-center overflow-hidden mb-6 relative group">
                        @if($company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="w-full h-full object-contain p-2" />
                        @else
                            <span class="text-4xl font-black text-gray-300 dark:text-slate-600">Logo</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white text-center">{{ $company->company_name ?? 'Your Company Name' }}</h3>
                    <p class="text-emerald-600 dark:text-emerald-400 text-sm font-semibold mt-1">{{ $employerProfile->designation ?? 'HR / Admin' }}</p>
                </div>
            </div>

            <!-- Right Column: Edit Forms -->
            <div class="xl:col-span-2">
                <div class="bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden">
                    
                    <form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Employer Personal Info -->
                        <div class="p-8 border-b border-gray-100 dark:border-slate-700/50 space-y-6">
                            <h4 class="font-black text-xl text-slate-900 dark:text-white flex items-center gap-2">
                                <span class="p-2 rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></span>
                                Personal Information
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">First Name</label>
                                    <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}" required class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Last Name</label>
                                    <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}" required class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="designation" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Job Title</label>
                                    <input id="designation" name="designation" type="text" value="{{ old('designation', $employerProfile->designation) }}" required placeholder="e.g. HR Manager" class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    <x-input-error :messages="$errors->get('designation')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="department" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Department</label>
                                    <input id="department" name="department" type="text" value="{{ old('department', $employerProfile->department) }}" placeholder="e.g. Talent Acquisition" class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Personal Phone</label>
                                    <input id="phone" name="phone" type="text" value="{{ old('phone', $employerProfile->phone) }}" class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                </div>
                            </div>
                        </div>

                        <!-- Company Profile Details -->
                        <div class="p-8 border-b border-gray-100 dark:border-slate-700/50 space-y-6">
                            <h4 class="font-black text-xl text-slate-900 dark:text-white flex items-center gap-2">
                                <span class="p-2 rounded-xl bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg></span>
                                Company Branding Details
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="company_name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Company Name</label>
                                    <input id="company_name" name="company_name" type="text" value="{{ old('company_name', $company->company_name) }}" required class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="website" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Website URL</label>
                                    <input id="website" name="website" type="url" value="{{ old('website', $company->website) }}" required class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    <x-input-error :messages="$errors->get('website')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="industry" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Industry</label>
                                    <input id="industry" name="industry" type="text" value="{{ old('industry', $company->industry) }}" required placeholder="e.g. Tech, Finance" class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                    <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="company_size" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Company Size</label>
                                    <select id="company_size" name="company_size" class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm font-medium">
                                        <option value="1-10" @selected(old('company_size', $company->company_size) == '1-10')>1-10 employees</option>
                                        <option value="11-50" @selected(old('company_size', $company->company_size) == '11-50')>11-50 employees</option>
                                        <option value="51-200" @selected(old('company_size', $company->company_size) == '51-200')>51-200 employees</option>
                                        <option value="201-500" @selected(old('company_size', $company->company_size) == '201-500')>201-500 employees</option>
                                        <option value="501+" @selected(old('company_size', $company->company_size) == '501+')>501+ employees</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="founded_year" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Founded Year</label>
                                    <input id="founded_year" name="founded_year" type="number" value="{{ old('founded_year', $company->founded_year) }}" class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="headquarters" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Headquarters City</label>
                                    <input id="headquarters" name="headquarters" type="text" value="{{ old('headquarters', $company->headquarters) }}" placeholder="e.g. Toronto, ON" class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                </div>
                                <div>
                                    <label for="company_email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Support Email</label>
                                    <input id="company_email" name="company_email" type="email" value="{{ old('company_email', $company->email) }}" class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                </div>
                                <div>
                                    <label for="company_phone" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Office Phone</label>
                                    <input id="company_phone" name="company_phone" type="text" value="{{ old('company_phone', $company->phone) }}" class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Company Description & Bio</label>
                                <textarea id="description" name="description" rows="5" placeholder="Write a short summary about your company culture, mission, and benefits..." class="w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-800 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm resize-none">{{ old('description', $company->description) }}</textarea>
                            </div>
                        </div>

                        <!-- Media Assets -->
                        <div class="p-8 border-b border-gray-100 dark:border-slate-700/50 space-y-6">
                            <h4 class="font-black text-xl text-slate-900 dark:text-white flex items-center gap-2">
                                <span class="p-2 rounded-xl bg-pink-100 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg></span>
                                Media Assets
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="bg-gray-50 dark:bg-slate-800/50 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 border-dashed">
                                    <label for="logo" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Company Logo</label>
                                    <input id="logo" name="logo" type="file" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 dark:file:bg-emerald-900/30 dark:file:text-emerald-400 transition-colors" />
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Square image recommended. Up to 2MB.</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-slate-800/50 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 border-dashed">
                                    <label for="cover_image" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Profile Cover Banner</label>
                                    <input id="cover_image" name="cover_image" type="file" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 dark:file:bg-emerald-900/30 dark:file:text-emerald-400 transition-colors" />
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Landscape image (1920x400). Up to 3MB.</p>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-slate-800/50 p-6 rounded-2xl border border-gray-100 dark:border-slate-700 border-dashed mt-6">
                                <label for="gallery_images" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Office & Culture Gallery</label>
                                <input id="gallery_images" name="gallery_images[]" type="file" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 dark:file:bg-emerald-900/30 dark:file:text-emerald-400 transition-colors" />
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Select multiple images to show off your workspace. Max 2MB each.</p>
                                <x-input-error :messages="$errors->get('gallery_images.*')" class="mt-2" />
                            </div>
                        </div>

                        <div class="p-8 bg-gray-50/50 dark:bg-slate-800/30 flex items-center justify-end">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-emerald-600/30 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                Save Branding Profile
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Existing Gallery Images Management -->
                @if(isset($company->culture_data['gallery']) && is_array($company->culture_data['gallery']) && count($company->culture_data['gallery']) > 0)
                    <div class="mt-8 bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl rounded-[2rem] border border-white/50 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none p-8">
                        <h4 class="text-xl font-black text-slate-900 dark:text-white mb-6">Manage Gallery Images</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($company->culture_data['gallery'] as $index => $image)
                                <div class="relative group rounded-2xl overflow-hidden aspect-[4/3] bg-gray-100 dark:bg-slate-800 shadow-sm border border-gray-200 dark:border-slate-700">
                                    <img src="{{ $image['url'] }}" alt="Gallery Image {{ $index + 1 }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                        <form action="{{ route('employer.profile.gallery.delete', $index) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this gallery image?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-2.5 px-4 rounded-xl flex items-center gap-2 shadow-lg transform transition-transform hover:scale-105">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
