<x-app-layout>

    @section('content')
        <div class="text-gray-900 bg-gray-200 border p-12" x-data="{ openEdit: false, openCreate: false, selectedCategory: { id: '', name: '' } }">

            <div class="p-4 flex justify-between">
                <h1 class="text-3xl">Categories</h1>
                <!-- Create Category button opens the create modal -->
                <button @click="openCreate = true"
                    class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">Add New Category</button>
            </div>
            <div class="bg-white rounded-lg shadow-lg">
                <!-- SweetAlert Notifications -->
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: '{{ session('success') }}',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    </script>
                @endif

                @if (session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: '{{ session('error') }}',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    </script>
                @endif

                <div class="px-3 py-4 flex justify-center">
                    <table class="w-full text-md bg-white shadow-md rounded mb-4">
                        <thead class="bg-blue-500 text-white justify-between">
                            <tr class="border-b">
                                <th class="text-left p-3 px-5">ID</th>
                                <th class="text-left p-3 px-5">Name</th>
                                <th class="text-left p-3 px-5">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr class="border-b hover:bg-orange-100 bg-gray-100">
                                    <td class="p-3 px-5">{{ $category->id }}</td>
                                    <td class="p-3 px-5">{{ $category->name }}</td>
                                    <td class="p-3 px-5 flex justify-start">
                                        <!-- Edit Button opens the edit modal and loads category data -->
                                        <button
                                            @click="openEdit = true; selectedCategory = { id: {{ $category->id }}, name: '{{ $category->name }}' }"
                                            class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none">
                                            Edit
                                        </button>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none"
                                                onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center p-3 px-5">No categories available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Edit Category Modal -->
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" x-show="openEdit"
                    x-cloak>
                    <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Edit Category</h2>
                        <form :action="`/categories/${selectedCategory.id}`" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Category Name Input -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Category
                                    Name</label>
                                <input type="text" name="name" id="name" x-model="selectedCategory.name"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                            </div>

                            <!-- Update Button -->
                            <div class="flex justify-end">
                                <button type="button" @click="openEdit = false"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2 focus:outline-none">Cancel</button>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Create Category Modal -->
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" x-show="openCreate"
                    x-cloak>
                    <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Create Category</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf

                            <!-- Category Name Input -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Category
                                    Name</label>
                                <input type="text" name="name" id="name"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                            </div>

                            <!-- Create Button -->
                            <div class="flex justify-end">
                                <button type="button" @click="openCreate = false"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2 focus:outline-none">Cancel</button>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- SweetAlert CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    </x-app-layout>
