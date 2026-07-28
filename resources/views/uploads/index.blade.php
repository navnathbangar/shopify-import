<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            CSV Product Import
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('uploads.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="mb-4">

                        <label class="block mb-2 font-medium">
                            Upload CSV File
                        </label>

                        <input type="file"
                               name="file"
                               accept=".csv"
                               class="border rounded w-full p-2">

                        @error('file')
                            <p class="text-red-500 mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">

                        Upload

                    </button>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>