<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Employer & Company Profile') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-amber-50 dark:bg-amber-950/30 border border-amber-500/30 text-amber-800 dark:text-amber-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('warning') }}
                </div>
            @endif

            <!-- Company Verification Status Banner -->
            <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        Company Verification Status:
                        @if($company->verification_status === 'verified')
                            <span class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full">Verified</span>
                        @elseif($company->verification_status === 'rejected')
                            <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">Rejected</span>
                        @else
                            <span class="px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-full">Pending Approval</span>
                        @endif
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Only verified employers can post job openings to Jobz In Canada.
                    </p>
                </div>
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="w-16 h-16 rounded-xl object-contain border border-gray-100 dark:border-gray-700" />
                @endif
            </div>

            <!-- Profile update form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 p-6">
                <form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- User Employer details -->
                    <div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3 mb-6">Employer Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $employerProfile->phone)" />
                            </div>
                            <div>
                                <x-input-label for="designation" :value="__('Designation / Job Title')" />
                                <x-text-input id="designation" name="designation" type="text" class="mt-1 block w-full" :value="old('designation', $employerProfile->designation)" required placeholder="e.g. HR Manager" />
                                <x-input-error :messages="$errors->get('designation')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="department" :value="__('Department')" />
                                <x-text-input id="department" name="department" type="text" class="mt-1 block w-full" :value="old('department', $employerProfile->department)" placeholder="e.g. Talent Acquisition" />
                            </div>
                        </div>
                    </div>

                    <!-- Company details -->
                    <div>
                        <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3 mb-6">Company Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="company_name" :value="__('Company Name')" />
                                <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name', $company->company_name)" required />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="website" :value="__('Company Website URL')" />
                                <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', $company->website)" required />
                                <x-input-error :messages="$errors->get('website')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                            <div>
                                <x-input-label for="industry" :value="__('Industry')" />
                                <x-text-input id="industry" name="industry" type="text" class="mt-1 block w-full" :value="old('industry', $company->industry)" required placeholder="e.g. Tech, Finance" />
                                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="company_size" :value="__('Company Size')" />
                                <select id="company_size" name="company_size" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm">
                                    <option value="1-10" @selected(old('company_size', $company->company_size) == '1-10')>1-10 employees</option>
                                    <option value="11-50" @selected(old('company_size', $company->company_size) == '11-50')>11-50 employees</option>
                                    <option value="51-200" @selected(old('company_size', $company->company_size) == '51-200')>51-200 employees</option>
                                    <option value="201-500" @selected(old('company_size', $company->company_size) == '201-500')>201-500 employees</option>
                                    <option value="501+" @selected(old('company_size', $company->company_size) == '501+')>501+ employees</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="founded_year" :value="__('Founded Year')" />
                                <x-text-input id="founded_year" name="founded_year" type="number" class="mt-1 block w-full" :value="old('founded_year', $company->founded_year)" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                            <div>
                                <x-input-label for="headquarters" :value="__('Headquarters City')" />
                                <x-text-input id="headquarters" name="headquarters" type="text" class="mt-1 block w-full" :value="old('headquarters', $company->headquarters)" placeholder="e.g. Toronto, ON" />
                            </div>
                            <div>
                                <x-input-label for="company_email" :value="__('Contact Email')" />
                                <x-text-input id="company_email" name="company_email" type="email" class="mt-1 block w-full" :value="old('company_email', $company->email)" />
                            </div>
                            <div>
                                <x-input-label for="company_phone" :value="__('Contact Phone')" />
                                <x-text-input id="company_phone" name="company_phone" type="text" class="mt-1 block w-full" :value="old('company_phone', $company->phone)" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-input-label for="description" :value="__('Company Description / Bio')" />
                            <textarea id="description" name="description" rows="5" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" placeholder="Write a short summary about your company culture, mission, and benefits...">{{ old('description', $company->description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 border-t border-gray-100 dark:border-gray-700/50 pt-6">
                            <div>
                                <x-input-label for="logo" :value="__('Company Logo')" />
                                <input id="logo" name="logo" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-950 dark:file:text-indigo-400 hover:file:bg-indigo-100" />
                                <p class="text-2xs text-gray-400 mt-1">Image up to 2MB.</p>
                            </div>
                            <div>
                                <x-input-label for="cover_image" :value="__('Company Profile Cover Image')" />
                                <input id="cover_image" name="cover_image" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-950 dark:file:text-indigo-400 hover:file:bg-indigo-100" />
                                <p class="text-2xs text-gray-400 mt-1">Image up to 3MB.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition duration-150 shadow-md">
                            Save Branding Profile
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
