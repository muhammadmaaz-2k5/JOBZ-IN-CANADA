<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Skills Management') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-650 dark:text-indigo-400 hover:underline text-xs font-bold">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 p-4 rounded-xl shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Create/Edit Form & Merge Tools -->
                <div class="space-y-6">
                    <!-- Create/Edit Form -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-4">
                        <h3 id="formTitle" class="font-extrabold text-base text-gray-900 dark:text-white">Create New Skill</h3>
                        
                        <form id="skillForm" method="POST" action="{{ route('admin.skills.store') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" id="methodField" name="_method" value="POST">

                            <div>
                                <x-input-label for="skill_name" :value="__('Skill Name')" />
                                <input type="text" name="name" id="skill_name" required placeholder="e.g. Vue.js, Vuejs" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-303 rounded-xl text-xs" />
                            </div>

                            <div class="flex justify-end gap-2 pt-2 text-xs">
                                <button type="button" id="resetBtn" onclick="resetForm()" class="px-4 py-2 border border-gray-250 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl hidden">Cancel Edit</button>
                                <button type="submit" class="px-5 py-2 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl shadow-sm">Save Skill</button>
                            </div>
                        </form>
                    </div>

                    <!-- Merge duplicates tool -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Merge Duplicate Skills</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Combine two skills into one, remapping all jobs and candidates to the target skill, and removing the source skill.</p>

                        <form method="POST" action="{{ route('admin.skills.merge') }}" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="source_select" :value="__('Source Skill (Will be Deleted)')" />
                                <select name="source_skill_id" id="source_select" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs">
                                    <option value="">Select skill...</option>
                                    @foreach($allSkillsList as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="target_select" :value="__('Target Skill (Will be Retained)')" />
                                <select name="target_skill_id" id="target_select" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs">
                                    <option value="">Select skill...</option>
                                    @foreach($allSkillsList as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" onclick="return confirm('Proceed with merge? This operation cannot be undone.');" class="w-full py-2 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl text-xs transition shadow-sm">
                                Merge Skills
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Skills List Table -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-750 flex justify-between items-center flex-wrap gap-4">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Active Master Skills List</h3>
                        
                        <form method="GET" action="{{ route('admin.skills.index') }}" class="max-w-xs flex gap-2">
                            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="text-xs border-gray-300 rounded-xl px-2.5" />
                            <button type="submit" class="px-3.5 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-750 font-bold rounded-xl text-2xs transition">Search</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                    <th class="p-4">Skill Name</th>
                                    <th class="p-4">Slug</th>
                                    <th class="p-4">Created Date</th>
                                    <th class="p-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                                @forelse($skills as $skill)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                        <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $skill->name }}</td>
                                        <td class="p-4 font-mono text-gray-400">{{ $skill->slug }}</td>
                                        <td class="p-4 text-gray-500">{{ $skill->created_at->format('Y-m-d') }}</td>
                                        <td class="p-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button onclick="editSkill({{ $skill->id }}, '{{ addslashes($skill->name) }}')" class="px-2.5 py-1 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 font-bold rounded-xl text-3xs transition">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('admin.skills.destroy', $skill->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Delete this skill permanetly?');" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-650 font-bold rounded-xl text-3xs transition">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-6 text-center text-gray-400 italic">No skills defined.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 bg-gray-50 dark:bg-gray-900/30 border-t border-gray-100 dark:border-gray-750">
                        {{ $skills->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function editSkill(id, name) {
            document.getElementById('formTitle').innerText = 'Edit Skill: ' + name;
            document.getElementById('skillForm').action = '/admin/skills/' + id;
            document.getElementById('methodField').value = 'PUT';
            document.getElementById('skill_name').value = name;
            document.getElementById('resetBtn').classList.remove('hidden');
        }

        function resetForm() {
            document.getElementById('formTitle').innerText = 'Create New Skill';
            document.getElementById('skillForm').action = '{{ route("admin.skills.store") }}';
            document.getElementById('methodField').value = 'POST';
            document.getElementById('skill_name').value = '';
            document.getElementById('resetBtn').classList.add('hidden');
        }
    </script>
</x-app-layout>
