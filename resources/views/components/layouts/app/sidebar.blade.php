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
    <body class="bg-gray-50 text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100">

            <div
      x-data="{ sidebarOpen: false, theme: (document.documentElement.classList.contains('dark') ? 'dark' : 'light') }"
      :class="theme === 'dark' ? 'dark' : ''"
      class="overflow-x-hidden bg-[url('images/table.png')] bg-cover bg-center bg-no-repeat"
    >
      <div
        class="overflow-x-hidden bg-gradient-to-b dark:from-emerald-950/70 dark:via-emerald-800/70 dark:to-emerald-700/30 from-emerald-200/50 via-emerald-300/70 to-emerald-400/30 dark:from-emerald-950/80 dark:via-emerald-900/70 dark:to-emerald-800/40"
      >
        <!-- ===== Fixed Top Navbar ===== -->
        <nav
          class="fixed inset-x-0 top-0 z-50 bg-white dark:bg-emerald-950 shadow-lg shadow-emerald-800/50"
        >
          <div class="mx-auto max-w-screen-2xl">
            <div
              class="flex h-14 md:h-16 items-center justify-between px-3 md:px-8 text-[0.625rem] font-semibold text-emerald-950 dark:text-emerald-50 md:text-lg"
            >
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
                  <h1 class="text-[9px] lg:text-lg">{{ Auth::user()->name  }}</h1>
                  <div class="flex items-center space-x-1 lg:space-x-2">
                    <i class="fa-solid fa-gem text-blue-400 dark:text-blue-200"></i>
                    <span class="text-[8px] lg:text-sm text-yellow-500 dark:text-yellow-400">24 Points</span>
                  </div>
                </div>
              </div>

              <!-- Primary Nav -->
              <ul class="flex items-center space-x-3 md:space-x-12 xl:space-x-16 relative">
                <li><a href="dashboard" class="hover:text-emerald-300">Home</a></li>
                <li><a href="/pre" class="hover:text-emerald-300">Pre-Match</a></li>
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
                      <a href="/billiard" class="block px-4 py-2 hover:bg-emerald-200 dark:hover:bg-emerald-600">Billiards</a>
                    </li>
                    <li>
                      <a href="/horse" class="block px-4 py-2 hover:bg-emerald-200 dark:hover:bg-emerald-600">Horse Racing</a>
                    </li>
                    <li>
                      <a href="/drag-race" class="block px-4 py-2 hover:bg-emerald-200 dark:hover:bg-emerald-600">Motor Racing</a>
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

        <!-- Spacer equal to navbar height -->
        <div class="pt-10 lg:pt-15"></div>

        <!-- ===== Page Container ===== -->
        <div
          class="mx-auto max-w-screen-2xl min-h-dvh relative px-3 lg:px-6 transition-[padding] duration-300"
          :class="sidebarOpen ? 'md:pl-0 lg:pl-64 xl:pl-72' : 'md:pl-0 lg:pl-6 xl:pl-6'"
        >
          <!-- Overlay (mobile+tablet only; hidden on lg+) -->
          <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 z-40 bg-black/40 lg:hidden"
            @click="sidebarOpen=false"
            aria-hidden="true"
          ></div>

          <!-- ===== Sidebar ===== -->
          <aside
            class="fixed left-0 top-14 md:top-[4rem] z-50 h-[calc(100dvh-3.5rem)] md:h-[calc(105dvh-6rem)] w-60 lg:w-64 xl:w-72 md:w-80 transform bg-white dark:bg-emerald-950 p-3 text-[0.625rem] text-emerald-950 shadow-md transition-transform duration-300 overflow-y-auto dark:text-gray-100 shadow-lg shadow-emerald-500/50 border-r border-gray-200/70 dark:border-emerald-800 lg:border-t lg:border-emerald-100"
            {{-- :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            @keydown.escape.window="sidebarOpen=false" --}}
          >
            <div class="flex h-full flex-col">
              <div class="mb-2 flex items-center justify-between md:text-sm">
                <span class="font-semibold lg:text-lg">Menu</span>
                <button
                  class="rounded-md px-2 py-1 hover:bg-emerald-300/40 dark:hover:bg-emerald-300/40 lg:hidden"
                  @click="sidebarOpen=false"
                >Close</button>
              </div>

              <nav class="flex-1">
                <ul class="space-y-1 md:text-sm">
                  <li>
                    <a href="#" class="flex w-full items-center gap-2 rounded px-2 py-2 hover:bg-emerald-300/40 hover:text-emerald-600 border-b border-gray-200 dark:border-emerald-800 dark:hover:bg-emerald-300/40 dark:hover:text-emerald-300">
                      <i class="fa-solid fa-tv"></i>
                      <span>Live Bets</span>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="flex w-full items-center gap-2 rounded px-2 py-2 hover:bg-emerald-300/40 hover:text-emerald-600 border-b border-gray-200 dark:border-emerald-800 dark:hover:bg-emerald-300/40 dark:hover:text-emerald-300">
                      <i class="fa-solid fa-coins"></i>
                      <span>My Bets</span>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="flex w-full items-center gap-2 rounded px-2 py-2 hover:bg-emerald-300/40 hover:text-emerald-600 border-b border-gray-200 dark:border-emerald-800 dark:hover:bg-emerald-300/40 dark:hover:text-emerald-300">
                      <i class="fa-solid fa-wallet"></i>
                      <span>My Wallet</span>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="flex w-full items-center gap-2 rounded px-2 py-2 hover:bg-emerald-300/40 hover:text-emerald-600 border-b border-gray-200 dark:border-emerald-800 dark:hover:bg-emerald-300/40 dark:hover:text-emerald-300">
                      <i class="fa-solid fa-ranking-star"></i>
                      <span>Leaderboards</span>
                    </a>
                  </li>
                  <li>
                    <a href="#" class="flex w-full items-center gap-2 rounded px-2 py-2 hover:bg-emerald-300/40 hover:text-emerald-600 border-b border-gray-200 dark:border-emerald-800 dark:hover:bg-emerald-300/40 dark:hover:text-emerald-300">
                      <i class="fa-regular fa-clock"></i>
                      <span>Upcoming Matches</span>
                    </a>
                  </li>
                </ul>
              </nav>

              <!-- Night Mode Toggle -->
              <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-800">
                <button
                  type="button"
                  class="w-full flex items-center justify-between gap-3 rounded-lg px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-emerald-900 dark:hover:bg-emerald-800"
                  @click="theme = (theme === 'dark' ? 'light' : 'dark')"
                  :aria-pressed="theme === 'dark'"
                >
                  <span class="flex items-center gap-2">
                    <span class="relative inline-flex h-5 w-5 items-center justify-center">
                      <i class="fa-solid fa-sun absolute transition-opacity duration-200" :class="theme === 'dark' ? 'opacity-0' : 'opacity-100'"></i>
                      <i class="fa-solid fa-moon absolute transition-opacity duration-200" :class="theme === 'dark' ? 'opacity-100' : 'opacity-0'"></i>
                    </span>
                    <span class="text-sm">Night Mode</span>
                  </span>
                  <span class="relative inline-flex h-5 w-10 items-center rounded-full bg-gray-300 dark:bg-gray-600 transition-colors duration-200">
                    <span class="absolute h-4 w-4 rounded-full bg-white dark:bg-gray-200 transform transition-transform duration-200" :class="theme === 'dark' ? 'translate-x-5' : 'translate-x-1'"></span>
                  </span>
                </button>
                <p class="mt-1 text-[0.625rem] text-gray-500 dark:text-gray-400">
                  Toggles the entire site theme.
                </p>
              </div>
            </div>
          </aside>

          <!-- ===== Main content ===== -->
          {{ $slot }}
        </div>
      </div>
    </div>
        

        @fluxScripts
    </body>
</html>
