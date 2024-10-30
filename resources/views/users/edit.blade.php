<x-app-layout>

<!-- resources/views/users/edit.blade.php -->
<h1>Edit Pengguna</h1>

<form action="{{ route('users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div>
        <label for="name">Nama:</label>
        <input type="text" name="name" id="name" value="{{ $user->name }}" required>
    </div>
    
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $user->email }}" required>
    </div>

    <div>
        <label for="password">Password (Opsional):</label>
        <input type="password" name="password" id="password">
        <small>Biarkan kosong jika tidak ingin mengubah password</small>
    </div>

    <div>
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
        </select>
    </div>

    <button type="submit">Update</button>
</form>
<a href="{{ route('users.index') }}">Kembali ke Daftar Pengguna</a>

</x-app-layout>