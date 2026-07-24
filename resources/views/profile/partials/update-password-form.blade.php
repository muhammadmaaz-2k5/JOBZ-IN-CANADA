<section>
    <header class="mb-6">
        <h2 class="text-2xl font-black text-slate-900 dark:text-white">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-2 text-slate-500 dark:text-slate-400 font-medium">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="font-bold text-slate-700 dark:text-slate-300" />
            <input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full px-4 py-3 rounded-xl border-slate-300 dark:border-slate-600 bg-white/50 dark:bg-slate-800/50 focus:border-[#1650e1] focus:ring-[#1650e1] shadow-sm backdrop-blur-sm transition-colors" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-sm text-rose-500" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="font-bold text-slate-700 dark:text-slate-300" />
            <input id="update_password_password" name="password" type="password" class="mt-2 block w-full px-4 py-3 rounded-xl border-slate-300 dark:border-slate-600 bg-white/50 dark:bg-slate-800/50 focus:border-[#1650e1] focus:ring-[#1650e1] shadow-sm backdrop-blur-sm transition-colors" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-sm text-rose-500" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="font-bold text-slate-700 dark:text-slate-300" />
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full px-4 py-3 rounded-xl border-slate-300 dark:border-slate-600 bg-white/50 dark:bg-slate-800/50 focus:border-[#1650e1] focus:ring-[#1650e1] shadow-sm backdrop-blur-sm transition-colors" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-sm text-rose-500" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100 dark:border-slate-700/50">
            <button type="submit" class="px-8 py-3 bg-[#1650e1] hover:bg-blue-700 text-white font-black rounded-xl transition-colors shadow-lg shadow-blue-900/20">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-3 py-1.5 rounded-lg"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>