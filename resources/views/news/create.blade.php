<x-app-layout>

    @section('content')
        <div class="bg-gray-200">
            <div class="container mx-auto px-12 py-6 bg-gray-200 shadow-md rounded-lg border" x-data="{ success: false, error: false }">
                <h1 class="text-2xl font-semibold mb-6">Create News Article</h1>

                <!-- SweetAlert Success Notification -->
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

                <!-- SweetAlert Error Notification -->
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

                <!-- Validation Errors -->
                @if ($errors->any())
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please correct the errors and try again.',
                            timer: 4000,
                            showConfirmButton: false
                        });
                    </script>
                @endif

                <!-- Create Article Form -->
                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6 mt-6 bg-white p-4 rounded-lg shadow-lg">
                    @csrf

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full bg-gray-100"
                            value="{{ old('title') }}" required />
                        @error('title')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Thumbnail -->
                    <div x-data="{ preview: null }">
                        <x-input-label for="thumbnail" :value="__('Thumbnail')" />

                        <!-- Image Preview -->
                        <div class="mt-2">
                            <template x-if="preview">
                                <img :src="preview" alt="Image Preview" class="w-64 h-auto rounded-lg shadow-md">
                            </template>
                        </div>

                        <!-- Custom File Input Button -->
                        <div class="mt-2">
                            <label
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg cursor-pointer hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ease-in-out duration-200">
                                <span>Pilih Gambar</span>
                                <input type="file" name="thumbnail" id="thumbnail" class="hidden" accept="image/*"
                                    required @change="fileChosen">
                            </label>
                        </div>

                        @error('thumbnail')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Alpine.js Script to Display Image Preview -->
                    <script>
                        function fileChosen(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.preview = URL.createObjectURL(file);
                            }
                        }
                    </script>


                    <!-- Additional Images Upload -->
                    <div class="w-full bg-white mt-4">
                        <x-input-label for="addImage" :value="__('Additional Images (Max 6)')" />
                        <div id="preview-container"
                            class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full"></div>
                        <div class="flex w-full mt-4">
                            <div id="multi-upload-button" onclick="document.getElementById('multi-upload-input').click()"
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-700 rouned-xl text-white rounded-l cursor-pointer">
                                Upload Image
                            </div>
                            <input type="file" id="multi-upload-input" name="addImage[]" accept="image/*" multiple
                                class="hidden" onchange="handleFileSelect(event)">
                        </div>
                    </div>

                    <!-- Additional Images JavaScript Preview Function -->
                    <script>
                        function handleFileSelect(event) {
                            const files = Array.from(event.target.files);
                            const previewContainer = document.getElementById('preview-container');
                            previewContainer.innerHTML = ''; // Clear existing previews

                            files.slice(0, 6).forEach((file) => {
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.className = "w-64 h-auto rounded-lg shadow-md";
                                    previewContainer.appendChild(img);
                                };
                                reader.readAsDataURL(file);
                            });
                        }
                    </script>

                    <!-- Content -->
                    <div>
                        <x-input-label for="content" :value="__('Content')" />
                        <textarea name="content" id="content" class="mt-1 block w-full bg-gray-100 rounded-lg" rows="5" required>{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id" class="mt-1 block w-full bg-gray-100 rounded-lg"
                            required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Images -->
                    {{-- <div class="w-full bg-white">
                        <div class="container mx-auto h-full flex flex-col">
                            <x-input-label for="addImage" :value="__('Additional Images (Max 6)')" />

                            <!-- Preview Container -->
                            <div id="preview-container"
                                class="mt-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full">
                            </div>

                            <!-- Upload Button Section -->
                            <div class="flex w-full mt-4">
                                <div id="multi-upload-button"
                                    onclick="document.getElementById('multi-upload-input').click()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-gray-600 rounded-l font-semibold cursor-pointer text-sm text-white tracking-widest hover:bg-gray-500 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                    Upload Image
                                </div>
                                <div
                                    class="w-4/12 lg:w-3/12 border border-gray-300 rounded-r-md flex items-center justify-between">
                                    <span id="multi-upload-text" class="p-2"></span>
                                    <button id="multi-upload-delete" class="hidden pr-2" onclick="removeMultiUpload()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-red-700 w-3 h-3"
                                            viewBox="0 0 320 512">
                                            <path
                                                d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Hidden File Input -->
                            <input type="file" id="multi-upload-input" class="hidden" accept="image/*" multiple
                                onchange="handleFileSelect(event)" />

                            <!-- Laravel Error Display -->
                            @error('addImage')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <script>
                        let previews = []; // Array to hold image previews

                        function handleFileSelect(event) {
                            const files = Array.from(event.target.files);

                            if (previews.length + files.length > 6) {
                                alert('You can only upload a maximum of 6 images.');
                                event.target.value = ''; // Clear the file input
                                return;
                            }

                            files.forEach(file => {
                                if (previews.length < 6) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        const imgElement = document.createElement('img');
                                        imgElement.src = e.target.result;
                                        imgElement.className = "w-64 h-auto rounded-lg shadow-md";

                                        document.getElementById('preview-container').appendChild(imgElement);
                                        previews.push(file); // Store file in previews array
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });

                            // Update text display
                            document.getElementById('multi-upload-text').textContent = `${previews.length} / 6 images selected`;
                            document.getElementById('multi-upload-delete').classList.remove('hidden');
                        }

                        function removeMultiUpload() {
                            document.getElementById('preview-container').innerHTML = ''; // Clear the preview container
                            previews = []; // Clear the previews array
                            document.getElementById('multi-upload-text').textContent = ''; // Clear the upload text
                            document.getElementById('multi-upload-input').value = ''; // Reset file input
                            document.getElementById('multi-upload-delete').classList.add('hidden');
                        }
                    </script> --}}




                    <!-- Status -->
                    <div>
                        <x-input-label for="status" :value="__('Status')" />
                        <select name="status_display" id="status" class="mt-1 block w-full bg-gray-100 rounded-lg"
                            required disabled>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>Draft</option>
                        </select>
                        <!-- Input tersembunyi untuk memastikan nilai default dikirimkan -->
                        <input type="hidden" name="status" value="0">

                        @error('status')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>




                    <!-- Submit Button -->
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none mt-4">Create
                        Article</button>
                </form>
            </div>

            <!-- SweetAlert CDN -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </div>

    </x-app-layout>
