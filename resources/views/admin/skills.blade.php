<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Skills Management') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}">
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

            <div>
                <!-- Left: Create/Edit Form & Merge Tools -->
                <div>
                    <!-- Create/Edit Form -->
                    <div>
                        <h3 id="formTitle">Create New Skill</h3>
                        
                        <form id="skillForm" method="POST" action="{{ route('admin.skills.store') }}">
                            @csrf
                            <input type="hidden" id="methodField" name="_method" value="POST">

                            <div>
                                <x-input-label for="skill_name" :value="__('Skill Name')" />
                                <input type="text" name="name" id="skill_name" required placeholder="e.g. Vue.js, Vuejs" />
                            </div>

                            <div>
                                <button type="button" id="resetBtn" onclick="resetForm()">Cancel Edit</button>
                                <button type="submit">Save Skill</button>
                            </div>
                        </form>
                    </div>

                    <!-- Merge duplicates tool -->
                    <div>
                        <h3>Merge Duplicate Skills</h3>
                        <p>Combine two skills into one, remapping all jobs and candidates to the target skill, and removing the source skill.</p>

                        <form method="POST" action="{{ route('admin.skills.merge') }}">
                            @csrf
                            <div>
                                <x-input-label for="source_select" :value="__('Source Skill (Will be Deleted)')" />
                                <select name="source_skill_id" id="source_select" required>
                                    <option value="">Select skill...</option>
                                    @foreach($allSkillsList as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="target_select" :value="__('Target Skill (Will be Retained)')" />
                                <select name="target_skill_id" id="target_select" required>
                                    <option value="">Select skill...</option>
                                    @foreach($allSkillsList as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" onclick="return confirm('Proceed with merge? This operation cannot be undone.');">
                                Merge Skills
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Skills List Table -->
                <div>
                    <div>
                        <h3>Active Master Skills List</h3>
                        
                        <form method="GET" action="{{ route('admin.skills.index') }}">
                            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" />
                            <button type="submit">Search</button>
                        </form>
                    </div>

                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Skill Name</th>
                                    <th>Slug</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($skills as $skill)
                                    <tr>
                                        <td>{{ $skill->name }}</td>
                                        <td>{{ $skill->slug }}</td>
                                        <td>{{ $skill->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div>
                                                <button onclick="editSkill({{ $skill->id }}, '{{ addslashes($skill->name) }}')">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('admin.skills.destroy', $skill->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Delete this skill permanetly?');">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No skills defined.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div>
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
