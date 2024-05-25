@props(['post'])
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
        {{$slot}}
    </div>
</div>
<!-- article - end -->
