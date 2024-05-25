<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-white py-6 sm:py-8 lg:py-12">
            <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
                <!-- form - start -->
                <form method="post" action="{{ route('posts.update', $post->id) }}" class="mx-auto grid max-w-screen-md gap-4 sm:grid-cols-2">
                    @csrf
                    @method('patch')
                    @if ($errors->any())
                    <div role="alert" class="sm:col-span-2 rounded border-s-4 border-red-500 bg-red-50 p-4">
                        <div class="flex items-center gap-2 text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                            </svg>
                            <strong class="block font-medium">Please check the below items :-</strong>
                        </div>

                        <ul class="mt-2 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="sm:col-span-2">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$post->title" autofocus />
                    </div>

                    <div class="sm:col-span-2">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <x-input-label for="body" :value="__('Body')" />
                        <textarea name="body" id="body" class="h-64 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $post->body }}</textarea>
                    </div>

                    <div class="flex items-center justify-between sm:col-span-2">
                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                        <a href=" {{ route('posts.index')}}">
                            <x-secondary-button>
                                {{ __('Back') }}
                            </x-secondary-button>
                        </a>
                    </div>
                </form>
                <!-- form - end -->
            </div>
        </div>
    </div>
</x-app-layout>
