@props(['post' => null])

<x-validation-error />

<div class="sm:col-span-2">
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$post->title ?? old('title')" autofocus />
</div>

<div class="sm:col-span-2">
    <x-input-label for="category_id" :value="__('Category')" />
    <select name="category_id" id="category_id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ ($post->category_id ?? '') == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div class="sm:col-span-2">
    <x-input-label for="body" :value="__('Body')" />
    <textarea name="body" id="body" class="h-64 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
    {{ $post->body ?? ''}}
    </textarea>
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
