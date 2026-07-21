<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Categories Management') }}
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
                <!-- Left: Create/Edit Form -->
                <div>
                    <h3 id="formTitle">Create New Category</h3>
                    
                    <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <input type="hidden" id="methodField" name="_method" value="POST">

                        <div>
                            <x-input-label for="category_name" :value="__('Category Name')" />
                            <input type="text" name="name" id="category_name" required placeholder="e.g. Graphic Design" />
                        </div>

                        <div>
                            <x-input-label for="parent_select" :value="__('Parent Category (Optional)')" />
                            <select name="parent_id" id="parent_select">
                                <option value="">None (Make Parent)</option>
                                @foreach($parentCategories as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="category_icon" :value="__('Icon/Unicode')" />
                            <input type="text" name="icon" id="category_icon" placeholder="e.g. 🎨" />
                        </div>

                        <div>
                            <button type="button" id="resetBtn" onclick="resetForm()">Cancel Edit</button>
                            <button type="submit">Save Category</button>
                        </div>
                    </form>
                </div>

                <!-- Right: Categories List Table -->
                <div>
                    <div>
                        <h3>Active Categories Map</h3>
                    </div>

                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Icon</th>
                                    <th>Category Name</th>
                                    <th>Parent Category</th>
                                    <th>Slug</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $cat)
                                    <tr>
                                        <td>{{ $cat->icon ?? '📁' }}</td>
                                        <td>{{ $cat->name }}</td>
                                        <td>{{ $cat->parent ? $cat->parent->name : 'Parent Level' }}</td>
                                        <td>{{ $cat->slug }}</td>
                                        <td>
                                            <div>
                                                <button onclick="editCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->parent_id }}', '{{ $cat->icon }}')">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Deleting category will detach/remove child associations. Proceed?');">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No categories created.</td>
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
