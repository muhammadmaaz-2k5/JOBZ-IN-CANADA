<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Employer & Company Profile') }}
            </h2>
            <a href="{{ route('dashboard') }}">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div>
        <div>

            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div>
                    {{ session('warning') }}
                </div>
            @endif

            <!-- Company Verification Status Banner -->
            <div>
                <div>
                    <h3>
                        Company Verification Status:
                        @if($company->verification_status === 'verified')
                            <span>Verified</span>
                        @elseif($company->verification_status === 'rejected')
                            <span>Rejected</span>
                        @else
                            <span>Pending Approval</span>
                        @endif
                    </h3>
                    <p>
                        Only verified employers can post job openings to Jobz In Canada.
                    </p>
                </div>
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" />
                @endif
            </div>

            <!-- Profile update form -->
            <div>
                <form method="POST" action="{{ route('employer.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- User Employer details -->
                    <div>
                        <h4>Employer Information</h4>
                        <div>
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" name="first_name" type="text" :value="old('first_name', $user->first_name)" required />
                                <x-input-error :messages="$errors->get('first_name')" />
                            </div>
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" name="last_name" type="text" :value="old('last_name', $user->last_name)" required />
                                <x-input-error :messages="$errors->get('last_name')" />
                            </div>
                        </div>

                        <div>
                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" name="phone" type="text" :value="old('phone', $employerProfile->phone)" />
                            </div>
                            <div>
                                <x-input-label for="designation" :value="__('Designation / Job Title')" />
                                <x-text-input id="designation" name="designation" type="text" :value="old('designation', $employerProfile->designation)" required placeholder="e.g. HR Manager" />
                                <x-input-error :messages="$errors->get('designation')" />
                            </div>
                            <div>
                                <x-input-label for="department" :value="__('Department')" />
                                <x-text-input id="department" name="department" type="text" :value="old('department', $employerProfile->department)" placeholder="e.g. Talent Acquisition" />
                            </div>
                        </div>
                    </div>

                    <!-- Company details -->
                    <div>
                        <h4>Company Information</h4>
                        <div>
                            <div>
                                <x-input-label for="company_name" :value="__('Company Name')" />
                                <x-text-input id="company_name" name="company_name" type="text" :value="old('company_name', $company->company_name)" required />
                                <x-input-error :messages="$errors->get('company_name')" />
                            </div>
                            <div>
                                <x-input-label for="website" :value="__('Company Website URL')" />
                                <x-text-input id="website" name="website" type="url" :value="old('website', $company->website)" required />
                                <x-input-error :messages="$errors->get('website')" />
                            </div>
                        </div>

                        <div>
                            <div>
                                <x-input-label for="industry" :value="__('Industry')" />
                                <x-text-input id="industry" name="industry" type="text" :value="old('industry', $company->industry)" required placeholder="e.g. Tech, Finance" />
                                <x-input-error :messages="$errors->get('industry')" />
                            </div>
                            <div>
                                <x-input-label for="company_size" :value="__('Company Size')" />
                                <select id="company_size" name="company_size">
                                    <option value="1-10" @selected(old('company_size', $company->company_size) == '1-10')>1-10 employees</option>
                                    <option value="11-50" @selected(old('company_size', $company->company_size) == '11-50')>11-50 employees</option>
                                    <option value="51-200" @selected(old('company_size', $company->company_size) == '51-200')>51-200 employees</option>
                                    <option value="201-500" @selected(old('company_size', $company->company_size) == '201-500')>201-500 employees</option>
                                    <option value="501+" @selected(old('company_size', $company->company_size) == '501+')>501+ employees</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="founded_year" :value="__('Founded Year')" />
                                <x-text-input id="founded_year" name="founded_year" type="number" :value="old('founded_year', $company->founded_year)" />
                            </div>
                        </div>

                        <div>
                            <div>
                                <x-input-label for="headquarters" :value="__('Headquarters City')" />
                                <x-text-input id="headquarters" name="headquarters" type="text" :value="old('headquarters', $company->headquarters)" placeholder="e.g. Toronto, ON" />
                            </div>
                            <div>
                                <x-input-label for="company_email" :value="__('Contact Email')" />
                                <x-text-input id="company_email" name="company_email" type="email" :value="old('company_email', $company->email)" />
                            </div>
                            <div>
                                <x-input-label for="company_phone" :value="__('Contact Phone')" />
                                <x-text-input id="company_phone" name="company_phone" type="text" :value="old('company_phone', $company->phone)" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Company Description / Bio')" />
                            <textarea id="description" name="description" rows="5" placeholder="Write a short summary about your company culture, mission, and benefits...">{{ old('description', $company->description) }}</textarea>
                        </div>

                        <div>
                            <div>
                                <x-input-label for="logo" :value="__('Company Logo')" />
                                <input id="logo" name="logo" type="file" />
                                <p>Image up to 2MB.</p>
                            </div>
                            <div>
                                <x-input-label for="cover_image" :value="__('Company Profile Cover Image')" />
                                <input id="cover_image" name="cover_image" type="file" />
                                <p>Image up to 3MB.</p>
                            </div>
                        </div>
                        <div class="mt-8">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">Office & Team Gallery</h4>
                            <div class="mb-4">
                                <x-input-label for="gallery_images" :value="__('Add Gallery Images')" />
                                <input id="gallery_images" name="gallery_images[]" type="file" multiple accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#1650e1]/10 file:text-[#1650e1] hover:file:bg-[#1650e1]/20" />
                                <p class="mt-1 text-sm text-gray-500">You can select multiple images (JPEG, PNG, WEBP). Max 2MB each.</p>
                                <x-input-error :messages="$errors->get('gallery_images.*')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end">
                        <button type="submit" class="bg-[#1650e1] hover:bg-[#0f3ea6] text-white font-bold py-2.5 px-6 rounded-lg transition-colors">
                            Save Branding Profile
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Gallery Images Management -->
            @if(isset($company->culture_data['gallery']) && is_array($company->culture_data['gallery']) && count($company->culture_data['gallery']) > 0)
                <div class="mt-8 p-6 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h4 class="text-lg font-bold text-gray-900 mb-6">Manage Gallery</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($company->culture_data['gallery'] as $index => $image)
                            <div class="relative group rounded-xl overflow-hidden aspect-[4/3] bg-gray-100 shadow-sm">
                                <img src="{{ $image['url'] }}" alt="Gallery Image {{ $index + 1 }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <form action="{{ route('employer.profile.gallery.delete', $index) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this gallery image?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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
</x-app-layout>
