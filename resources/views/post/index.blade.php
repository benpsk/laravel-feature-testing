<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @session('success')
            <div role="alert" class="rounded-xl border border-gray-100 bg-white p-4 mb-4">
                <div class="flex items-start gap-4">
                    <span class="text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>

                    <div class="flex-1">
                        <strong class="block font-medium text-gray-900"> Changes saved </strong>
                        <p class="mt-1 text-sm text-gray-700">{{ $value }}</p>
                    </div>
                </div>
            </div>
            @endsession

            @session('error')
            <div role="alert" class="rounded border-s-4 border-red-500 bg-red-50 p-4 mb-4">
                <strong class="block font-medium text-red-800"> Something went wrong </strong>

                <p class="mt-2 text-sm text-red-700">
                    {{ $value }}
                </p>
            </div>
            @endsession
            <main class="">
                <div class="bg-white py-6 sm:py-8 lg:py-12 rounded">
                    <div class="mx-auto max-w-screen-xl px-4 md:px-8">
                        <!-- text - start -->
                        <div class="mb-10">
                            <a href="{{ route('posts.create') }}" class="font-semibold text-indigo-500 transition duration-100 hover:text-indigo-600 active:text-indigo-700">Add New</a>
                        </div>
                        <!-- text - end -->

                        <div class="grid gap-8 sm:grid-cols-2 sm:gap-12 lg:grid-cols-2 xl:grid-cols-2 xl:gap-16 mb-4">

                            @foreach($posts as $post)
                            <!-- article - start -->
                            <div class="flex flex-col items-center gap-4 md:flex-row lg:gap-6">
                                <a href="#" class="group relative block h-56 w-full shrink-0 self-start overflow-hidden rounded-lg bg-gray-100 shadow-lg md:h-24 md:w-24 lg:h-40 lg:w-40">
                                    <img src="https://images.unsplash.com/photo-1593508512255-86ab42a8e620?auto=format&q=75&fit=crop&w=600" loading="lazy" alt="Photo by Minh Pham" class="absolute inset-0 h-full w-full object-cover object-center transition duration-200 group-hover:scale-110" />
                                </a>

                                <div class="flex flex-col gap-2 w-full">
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-400">{{ $post->created_at->format('F d, Y') }}</p>
                                        <p class="text-xs rounded-md px-2 py-1 text-gray-400 bg-gray-200">{{ $post->category->name }}</p>
                                    </div>

                                    <h2 class="text-xl font-bold text-gray-800">
                                        <a href="#" class="transition duration-100 hover:text-indigo-500 active:text-indigo-600">{{ $post->title }}</a>
                                    </h2>

                                    <p class="text-gray-500"> {{ Illuminate\Support\Str::limit($post->body, 90)}}</p>

                                    <div class="flex justify-end items-center">
                                        <a href="{{ route('posts.edit', $post->id)}}" class="font-semibold text-indigo-500 transition duration-100 hover:text-indigo-600 active:text-indigo-700">Edit</a>
                                    </div>
                                </div>
                            </div>
                            <!-- article - end -->
                            @endforeach
                        </div>
                        {{ $posts->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
