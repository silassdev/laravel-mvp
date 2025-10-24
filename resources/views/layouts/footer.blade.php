{{-- resources/views/layouts/footer.blade.php --}}
<footer class="bg-slate-900 text-slate-200 mt-16">
  <div class="container mx-auto px-6 py-12">
    <div class="grid md:grid-cols-3 gap-8">

      <!-- Useful Links -->
      <div>
        <h3 class="text-white text-lg font-semibold mb-4">Useful Links</h3>
        <ul class="space-y-2 text-sm">
          <li>
            <a href="{{ route('home') }}"
               @class([
                 'inline-block px-1 py-1 rounded',
                 'text-white' => request()->routeIs('home'),
                 'text-slate-300 hover:text-white' => ! request()->routeIs('home')
               ])>
              Home
            </a>
          </li>

          <li>
            <a href="{{ route('blogs.index') }}"
               @class([
                 'inline-block px-1 py-1 rounded',
                 'text-white' => request()->routeIs('blogs.*'),
                 'text-slate-300 hover:text-white' => ! request()->routeIs('blogs.*')
               ])>
              Blog
            </a>
          </li>

          <li>
            <a href="{{ route('contact.show') }}"
               @class([
                 'inline-block px-1 py-1 rounded',
                 'text-white' => request()->routeIs('contact.*'),
                 'text-slate-300 hover:text-white' => ! request()->routeIs('contact.*')
               ])>
              Contact
            </a>
          </li>

          <li>
            <a href="#pricing" class="text-slate-300 hover:text-white inline-block px-1 py-1">Pricing</a>
          </li>

          <li>
            <a href="#docs" class="text-slate-300 hover:text-white inline-block px-1 py-1">Docs</a>
          </li>
        </ul>

        <!-- Admin icon & small label (unchanged behavior) -->
        <div class="mt-6">
          <button
            @click="adminOpen = true"
            class="inline-flex items-center gap-2 px-3 py-2 bg-slate-800 hover:bg-slate-700 rounded focus:outline-none focus:ring focus:ring-offset-2 focus:ring-slate-600"
            aria-haspopup="dialog"
            x-data
          >
            <svg class="w-5 h-5 text-slate-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20a8 8 0 0116 0" />
            </svg>
            <span class="text-sm">Admin</span>
          </button>
          <p class="text-xs text-slate-400 mt-2">Click to sign in</p>
        </div>
      </div>

      <!-- Socials -->
      <div>
        <h3 class="text-white text-lg font-semibold mb-4">Follow</h3>
        <p class="text-sm text-slate-300 mb-4">Connect on social media</p>

        <div class="flex items-center gap-3">
          {{-- GitHub --}}
          <a href="https://github.com/yourusername" target="_blank" rel="noopener noreferrer"
             class="p-2 rounded bg-slate-800 hover:bg-slate-700 transform transition-transform duration-200 ease-out motion-safe:hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-600"
             aria-label="GitHub">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="..."/></svg>
          </a>

          {{-- LinkedIn --}}
          <a href="https://www.linkedin.com/in/yourusername" target="_blank" rel="noopener noreferrer"
             class="p-2 rounded bg-slate-800 hover:bg-slate-700 transform transition-transform duration-200 ease-out motion-safe:hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-600"
             aria-label="LinkedIn">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="..."/></svg>
          </a>

          {{-- X --}}
          <a href="https://x.com/yourusername" target="_blank" rel="noopener noreferrer"
             class="p-2 rounded bg-slate-800 hover:bg-slate-700 transform transition-transform duration-200 ease-out motion-safe:hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-600"
             aria-label="X">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="..."/></svg>
          </a>

          {{-- Facebook --}}
          <a href="https://facebook.com/yourusername" target="_blank" rel="noopener noreferrer"
             class="p-2 rounded bg-slate-800 hover:bg-slate-700 transform transition-transform duration-200 ease-out motion-safe:hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-600"
             aria-label="Facebook">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="..."/></svg>
          </a>

          {{-- YouTube --}}
          <a href="https://youtube.com/yourusername" target="_blank" rel="noopener noreferrer"
             class="p-2 rounded bg-slate-800 hover:bg-slate-700 transform transition-transform duration-200 ease-out motion-safe:hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-600"
             aria-label="YouTube">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="..."/></svg>
          </a>
        </div>
      </div>

      <!-- Short about / copyright -->
      <div class="md:text-right">
        <h3 class="text-white text-lg font-semibold mb-4">About</h3>
        <p class="text-sm text-slate-300 mb-4">Building clean, fast Laravel apps & custom APIs — available for hire.</p>
        <div class="text-xs text-slate-500">© {{ date('Y') }} All Pilar</div>
      </div>
    </div>
  </div>

  <!-- Admin Login Modal (Alpine controlled) -->
  <div x-data="{ adminOpen: false }" x-init="$watch('adminOpen', value => { if(value) $nextTick(()=> { $refs.adminEmail.focus() }) })" x-cloak>
    <!-- Overlay -->
    <div x-show="adminOpen" x-transition.opacity class="fixed inset-0 bg-black/50 z-40" @click="adminOpen = false"></div>

    <!-- Modal -->
    <div x-show="adminOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="w-full max-w-md bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4">
          <div class="flex items-center justify-between">
            <h4 class="text-lg font-semibold">Admin Login</h4>
            <button @click="adminOpen = false" class="text-slate-400 hover:text-slate-600 focus:outline-none">✕</button>
          </div>

          <form method="POST" action="{{ route('admin.login') }}" class="mt-4 space-y-4">
            @csrf

            @if(session('admin_error'))
              <div class="text-sm text-red-600">{{ session('admin_error') }}</div>
            @endif

            <div>
              <label class="block text-sm text-slate-700">Email</label>
              <input x-ref="adminEmail" name="email" type="email" required class="w-full mt-1 border rounded px-3 py-2 focus:outline-none focus:ring" placeholder="admin@example.com" />
            </div>

            <div>
              <label class="block text-sm text-slate-700">Password</label>
              <input name="password" type="password" required class="w-full mt-1 border rounded px-3 py-2 focus:outline-none focus:ring" placeholder="••••••••" />
            </div>

            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4"/>
                <label for="remember" class="text-sm text-slate-600">Remember</label>
              </div>
              <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot?</a>
            </div>

            <div class="pt-2">
              <button type="submit" class="w-full py-2 rounded bg-slate-900 text-white hover:bg-slate-800">Sign in</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</footer>
