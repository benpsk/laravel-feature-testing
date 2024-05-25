<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-success-alert />
            <x-error-alert />
            <main class="">
                <div class="bg-white py-6 sm:py-8 lg:py-12 rounded">
                    <div class="mx-auto max-w-screen-xl px-4 md:px-8">
                        <!-- text - start -->
                        <div class="mb-10">
                            <a href="{{ route('posts.create') }}" class="font-semibold text-indigo-500 transition duration-100 hover:text-indigo-600 active:text-indigo-700">Add New</a>
                        </div>
                        <!-- text - end -->

                        <div class="grid gap-8 sm:grid-cols-2 sm:gap-12 lg:grid-cols-2 xl:grid-cols-2 xl:gap-16 mb-16">
                            @foreach($posts as $post)
                            <x-post.card :post="$post">
                                <div class="flex justify-end items-center">
                                    <a href="{{ route('posts.edit', $post->id)}}" class="font-semibold text-indigo-500 transition duration-100 hover:text-indigo-600 active:text-indigo-700">Edit</a>
                                </div>
                            </x-post.card>
                            @endforeach
                        </div>
                        {{ $posts->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
