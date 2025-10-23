<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', config('app.name'))</title>
  @vite(['resources/css/app.css','resources/js/app.js']) <!-- if using Vite -->
</head>
<body class="bg-gray-50 text-gray-800">
  <nav class="p-4 bg-white shadow">
    <div class="container mx-auto flex justify-between">
      <a href="{{ route('home') }}" class="font-bold">My Laravel MVP</a>
      <div class="space-x-4">
        <a href="{{ route('blogs.index') }}">Blogs</a>
        <a href="{{ route('contact.show') }}">Contact</a>
        <a href="{{ route('admin.dashboard') }}">Admin</a>
      </div>
    </div>
  </nav>

  <main class="container mx-auto p-6">
    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-700">{{ session('success') }}</div>
    @endif

    @yield('content')
  </main>

  <footer class="text-center p-6 text-sm text-gray-500">© {{ date('Y') }}</footer>
</body>
</html>
