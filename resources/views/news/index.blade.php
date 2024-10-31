<x-app-layout>


    @section('content')

        <div class="text-gray-900 bg-gray-200 p-12">
            <div class="p-4 flex justify-between">
                <h1 class="text-3xl">News Articles</h1>
                <a href="{{ route('news.create') }}"
                    class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">Create New Article</a>
            </div>

            <div class="bg-white rounded-lg shadow-lg">


                @if (session('success'))
                    <div class="alert alert-success px-4 py-2 mt-3 rounded bg-green-100 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="px-3 py-4 flex justify-center">
                    <table class="w-full text-md bg-white shadow-md rounded mb-4">
                        <thead class="bg-blue-500 text-white">
                            <tr class="border-b">
                                <th class="text-left p-3 px-5">Gambar</th>
                                <th class="text-left p-3 px-5">Judul</th>
                                <th class="text-left p-3 px-5">isi konten</th>
                                <th class="text-left p-3 px-5">Status</th>
                                <th class="text-left p-3 px-5">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($news as $article)
                                <tr class="border-b hover:bg-orange-100 bg-gray-100">
                                    <!-- Thumbnail -->
                                    <td class="p-3 px-5">
                                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail"
                                            class="w-64 h-auto rounded-lg shadow-md">
                                    </td>

                                    <!-- Title -->
                                    <td class="p-3 px-5">{{ $article->title }}</td>

                                    <td class="p-3 px-5">{!! Str::limit($article->content, 50) !!}</td>

                                        <!-- Status -->
                                    <td class="p-3 px-5">
                                        {{ $article->status ? 'Published' : 'Draft' }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="p-3 px-5 h-full space-x-2 justify-start">
                                        <div class="item-center">
                                            <a href="{{ route('news.edit', $article->id) }}"
                                                class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Edit</a>
                                            <a href="{{ route('news.show', $article->id) }}"
                                                class="text-sm bg-yellow-500 hover:bg-yellow-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Review</a>
                                            <form action="{{ route('news.destroy', $article->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this article?')"
                                                    class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                <!-- Pagination Links -->
                <div class="d-flex justify-content-center">
                    {{ $news->links() }}
                </div>
            </div>

    </x-app-layout>
