<x-app-layout>
    <div class="text-gray-900 p-12">
        <div class="p-4 flex">
            <h1 class="text-3xl font-semibold">Daftar Pengguna</h1>
            <a href="{{ route('users.create') }}" class="ml-auto bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">
                Tambah Pengguna
            </a>
        </div>
        <div class="px-3 py-4 flex justify-center bg-white rounded-lg shadow-lg">
            <table class="w-full text-md bg-white shadow-md rounded mb-4">
                <thead class="bg-blue-500 text-white">
                    <tr class="border-b">
                        <th class="text-left p-3 px-5">Nama</th>
                        <th class="text-left p-3 px-5">Email</th>
                        <th class="text-left p-3 px-5">Role</th>
                        <th class="text-left p-3 px-5">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b hover:bg-gray-200 bg-gray-50">
                            <td class="p-3 px-5">{{ $user->name }}</td>
                            <td class="p-3 px-5">{{ $user->email }}</td>
                            <td class="p-3 px-5">{{ $user->role }}</td>
                            <td class="p-3 px-5 flex justify-start">

                                <!-- Edit Button -->
                                <a href="javascript:void(0);" onclick="openPopup({{ $user->id }})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white rounded-full p-2 mr-2 focus:outline-none focus:shadow-outline">
                                    <!-- SVG for Edit Icon -->
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </a>

                                <!-- Popup Form -->
                                <div id="popup-{{ $user->id }}" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
                                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                                        <button onclick="closePopup({{ $user->id }})" class="text-gray-500 float-right text-lg font-bold">&times;</button>
                                        <h2 class="text-xl font-semibold mb-4">Edit User</h2>
                                        <form id="editForm-{{ $user->id }}" action="{{ route('users.update', $user) }}" method="POST" onsubmit="return confirmEdit(event)">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-4">
                                                <label for="name" class="block text-gray-700">Nama:</label>
                                                <input type="text" name="name" id="name" value="{{ $user->name }}" required class="w-full p-2 border border-gray-300 rounded">
                                            </div>

                                            <div class="mb-4">
                                                <label for="email" class="block text-gray-700">Email:</label>
                                                <input type="email" name="email" id="email" value="{{ $user->email }}" required class="w-full p-2 border border-gray-300 rounded">
                                            </div>

                                            <div class="mb-4">
                                                <label for="password" class="block text-gray-700">Password (Opsional):</label>
                                                <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded">
                                                <small>Biarkan kosong jika tidak ingin mengubah password</small>
                                            </div>

                                            <div class="mb-4">
                                                <label for="role" class="block text-gray-700">Role:</label>
                                                <select name="role" id="role" required class="w-full p-2 border border-gray-300 rounded">
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                                Update
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Delete button -->
                                <form id="deleteForm-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirmDelete(event)" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white rounded-full p-2 focus:outline-none focus:shadow-outline">
                                        <!-- SVG for Delete Icon -->
                                        <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JavaScript for Popup and SweetAlert Confirmations -->
    <script>
        function openPopup(userId) {
            document.getElementById('popup-' + userId).classList.remove('hidden');
        }

        function closePopup(userId) {
            document.getElementById('popup-' + userId).classList.add('hidden');
        }

        // Confirmation for Delete
        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }

        // Confirmation for Edit
        function confirmEdit(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Update',
                text: "Apakah kamu yakin ingin mengubah data ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, update!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    </script>
</x-app-layout>
