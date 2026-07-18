<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Categories Management') }}
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
                <!-- Left: Create/Edit Form -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700/50 space-y-4">
                    <h3 id="formTitle" class="font-extrabold text-base text-gray-900 dark:text-white">Create New Category</h3>
                    
                    <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" id="methodField" name="_method" value="POST">

                        <div>
                            <x-input-label for="category_name" :value="__('Category Name')" />
                            <input type="text" name="name" id="category_name" required placeholder="e.g. Graphic Design" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-300 rounded-xl text-xs" />
                        </div>

                        <div>
                            <x-input-label for="parent_select" :value="__('Parent Category (Optional)')" />
                            <select name="parent_id" id="parent_select" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-305 rounded-xl text-xs">
                                <option value="">None (Make Parent)</option>
                                @foreach($parentCategories as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="category_icon" :value="__('Icon/Unicode')" />
                            <input type="text" name="icon" id="category_icon" placeholder="e.g. 🎨" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-303 rounded-xl text-xs" />
                        </div>

                        <div class="flex justify-end gap-2 pt-2 text-xs">
                            <button type="button" id="resetBtn" onclick="resetForm()" class="px-4 py-2 border border-gray-250 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl hidden">Cancel Edit</button>
                            <button type="submit" class="px-5 py-2 bg-indigo-650 hover:bg-indigo-755 text-white font-bold rounded-xl shadow-sm">Save Category</button>
                        </div>
                    </form>
                </div>

                <!-- Right: Categories List Table -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-750">
                        <h3 class="font-extrabold text-base text-gray-900 dark:text-white">Active Categories Map</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-750 text-3xs font-extrabold uppercase text-gray-400">
                                    <th class="p-4">Icon</th>
                                    <th class="p-4">Category Name</th>
                                    <th class="p-4">Parent Category</th>
                                    <th class="p-4">Slug</th>
                                    <th class="p-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-750 text-gray-650 dark:text-gray-300 font-semibold">
                                @forelse($categories as $cat)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-950/20 transition">
                                        <td class="p-4 text-sm">{{ $cat->icon ?? '📁' }}</td>
                                        <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $cat->name }}</td>
                                        <td class="p-4 text-gray-450">{{ $cat->parent ? $cat->parent->name : 'Parent Level' }}</td>
                                        <td class="p-4 text-gray-400 font-mono">{{ $cat->slug }}</td>
                                        <td class="p-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button onclick="editCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->parent_id }}', '{{ $cat->icon }}')" class="px-2.5 py-1 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 font-bold rounded-xl text-3xs transition">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Deleting category will detach/remove child associations. Proceed?');" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-650 font-bold rounded-xl text-3xs transition">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-gray-400 italic">No categories created.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function editCategory(id, name, parentId, icon) {
            document.getElementById('formTitle').innerText = 'Edit Category: ' + name;
            document.getElementById('categoryForm').action = '/admin/categories/' + id;
            document.getElementById('methodField').value = 'PUT';
            document.getElementById('category_name').value = name;
            document.getElementById('parent_select').value = parentId || '';
            document.getElementById('category_icon').value = icon || '';
            document.getElementById('resetBtn').classList.remove('hidden');
        }

        function resetForm() {
            document.getElementById('formTitle').innerText = 'Create New Category';
            document.getElementById('categoryForm').action = '{{ route("admin.categories.store") }}';
            document.getElementById('methodField').value = 'POST';
            document.getElementById('category_name').value = '';
            document.getElementById('parent_select').value = '';
            document.getElementById('category_icon').value = '';
            document.getElementById('resetBtn').classList.add('hidden');
        }
    </script>
</x-app-layout>
