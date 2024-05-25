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
                    @method('put')
                    <x-post.form :post="$post" />
                </form>
                <!-- form - end -->
            </div>
        </div>
    </div>
</x-app-layout>
