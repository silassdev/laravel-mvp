@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="py-12 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl font-extrabold text-center mb-4">My Blog &amp; Portfolio</h1>
            <p class="text-xl text-center max-w-2xl mx-auto">Simple But Light Solution to showcase portfolio &amp; Blogs</p>
        </div>
    </section>

    @if ($recent->isNotEmpty())
        <section class="py-12 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold mb-8 text-center">Featured Post</h2>
                @php $featured = $recent->shift(); @endphp
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-2xl font-semibold mb-4">
                        <a href="{{ route('blogs.show', $featured->slug) }}" class="text-blue-600 hover:text-blue-800">{{ $featured->title }}</a>
                    </h3>
                    <p class="text-gray-600 mb-4">{{ $featured->excerpt }}</p>
                    <a href="{{ route('blogs.show', $featured->slug) }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Read More</a>
                </div>
            </div>
        </section>

        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold mb-8 text-center">Recent Posts</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recent as $post)
                        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
                            <h3 class="text-xl font-semibold mb-4">
                                <a href="{{ route('blogs.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800">{{ $post->title }}</a>
                            </h3>
                            <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                            <a href="{{ route('blogs.show', $post->slug) }}" class="text-blue-500 hover:text-blue-700">Read More →</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <section class="py-12 bg-white">
            <div class="container mx-auto px-4 text-center">
                <p class="text-xl text-gray-600">No blog posts yet — create one from the admin panel.</p>
            </div>
        </section>
    @endif

    <section class="py-12 bg-blue-100">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Subscribe to Our Newsletter</h2>
            <p class="text-lg mb-6">Stay updated with our latest posts and exclusive content.</p>
            <form class="max-w-md mx-auto">
                <input type="email" placeholder="Enter your email" class="w-full p-3 mb-4 rounded border border-gray-300">
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600 transition">Subscribe</button>
            </form>
        </div>
    </section>
@endsection