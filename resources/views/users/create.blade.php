<x-app-layout>
    <div class="text-gray-900 p-12">
        <div class="p-4 flex">
            <h1 class="text-3xl font-semibold">Buat Akun</h1>
        </div>
        
        <div class="">
            <form action="{{ route('users.store') }}" method="POST" class="p-8 bg-white shadow-lg rounded-lg">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nama:</label>
                    <input type="text" name="name" id="name" required
                           class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
                    <input type="email" name="email" id="email" required
                           class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password:</label>
                    <input type="password" name="password" id="password" required
                           class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-6">
                    <label for="role" class="block text-gray-700 font-semibold mb-2">Role:</label>
                    <select name="role" id="role" required
                            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="admin">Admin</option>
                        <option value="author" selected>Author</option>
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-semibold py-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                    Simpan
                </button>
            </form>
        </div>
    </div>

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Display success message
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        // Display error message
        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif

        // Display validation errors
        @if ($errors->any())
            Swal.fire({
                title: 'Gagal!',
                html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
</x-app-layout>
