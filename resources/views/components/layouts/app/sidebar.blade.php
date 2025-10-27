<!DOCTYPE html>
<html
  lang="en"
  x-data="{
    sidebarOpen:false,
    theme: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
  }"
  x-init="() => {
    $watch('theme', t => localStorage.setItem('theme', t));
    // Sidebar pinned by default on laptops/desktops (lg: ≥1024px)
    const mq = window.matchMedia('(min-width: 1024px)');
    sidebarOpen = mq.matches;
    mq.addEventListener('change', e => { sidebarOpen = e.matches });
  }"
  :class="theme === 'dark' ? 'dark' : ''"
>
    <head>
        @include('partials.head')
    </head>
    <body class="">
              <!-- ===== Fixed Top Navbar ===== -->
        <nav
          class="fixed inset-x-0 top-0 z-50 bg-white dark:bg-emerald-950 shadow-lg shadow-emerald-800/50"
        >
          <div class="mx-auto max-w-screen-2xl">
            <div class="flex h-14 md:h-16 items-center justify-between px-3 md:px-8 text-[0.625rem] font-semibold text-emerald-950 dark:text-emerald-50 md:text-lg">
              <!-- Left: Burger + Profile -->
              <div class="flex items-center gap-2">
                <button
                  class="inline-flex items-center justify-center rounded-md h-8 w-8 md:h-10 md:w-10 hover:bg-emerald-800/40 focus:outline-none focus:ring-2 focus:ring-emerald-400 lg:hidden"
                  @click="sidebarOpen = !sidebarOpen"
                  aria-label="Toggle sidebar"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                  </svg>
                </button>
                <img src="images/Avatar.png" class="w-8 lg:w-10 lg:mx-2" alt=""/>
                <div class="flex-col lg:space-y-1">
                  <h1 class="text-[9px] lg:text-lg">Player123321s</h1>
                  <div class="flex items-center space-x-1 lg:space-x-2">
                    <i class="fa-solid fa-gem text-blue-400 dark:text-blue-200"></i>
                    <span class="text-[8px] lg:text-sm text-yellow-500 dark:text-yellow-400">24 Points</span>
                  </div>
                </div>
              </div>

              <!-- Primary Nav -->
              <ul class="flex items-center space-x-3 md:space-x-12 xl:space-x-16 relative">
                <li><a href="#" class="hover:text-emerald-300">Home</a></li>
                <li><a href="preMatch.html" class="hover:text-emerald-300">Pre-Match</a></li>
                <li><a href="#" class="hover:text-emerald-300">Event</a></li>

                <!-- Sports dropdown -->
                <li class="relative" x-data="{ open:false }">
                  <button
                    @click="open = !open"
                    @keydown.escape.window="open=false"
                    class="inline-flex items-center hover:text-emerald-300"
                    aria-haspopup="true"
                    :aria-expanded="open"
                  >
                    Sports
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  </button>

                  <ul
                    x-show="open"
                    x-transition
                    @click.outside="open=false"
                    class="absolute left-0 mt-2 w-48 rounded-lg dark:bg-emerald-900 bg-white text-emerald-950 shadow-lg z-50 overflow-hidden"
                  >
                    <li>
                      <a href="sabong2.html" class="block px-4 py-2 hover:bg-emerald-200 dark:hover:bg-emerald-600">Billiards</a>
                    </li>
                    <li>
                      <a href="kabayo2.html" class="block px-4 py-2 hover:bg-emerald-200 dark:hover:bg-emerald-600">Horse Racing</a>
                    </li>
                    <li>
                      <a href="race.html" class="block px-4 py-2 hover:bg-emerald-200 dark:hover:bg-emerald-600">Motor Racing</a>
                    </li>
                  </ul>
                </li>
              </ul>

              <!-- Right: Logout -->
              <div class="flex items-center">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs md:text-sm bg-emerald-600 text-white hover:bg-emerald-700 transition"
                    aria-label="Logout"
                  >
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </nav>
        {{ $slot }}

        @fluxScripts
    </body>
</html>
