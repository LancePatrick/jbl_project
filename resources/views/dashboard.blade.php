<x-layouts.app :title="__('Dashboard')">
    <div
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
              <!-- Left: Burger (visible on mobile + tablet; hidden on lg+) -->
              <div class="flex items-center gap-2">
                <button
                  class="inline-flex items-center justify-center rounded-md h-8 w-8 md:h-10 md:w-10 hover:bg-emerald-800/40 focus:outline-none focus:ring-2 focus:ring-emerald-400 lg:hidden"
                  @click="sidebarOpen = !sidebarOpen"
                  aria-label="Toggle sidebar"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"
                    />
                  </svg>
                </button>
                <img
                  src="images/Avatar.png"
                  class="w-8 lg:w-10 lg:mx-2"
                  alt=""
                />
                <div class="flex-col lg:space-y-1">
                  <h1 class="text-[9px] lg:text-lg">Player123321s</h1>
                  <div class="flex items-center space-x-1 lg:space-x-2">
                    <i
                      class="fa-solid fa-gem text-blue-400 dark:text-blue-200"
                    ></i>
                    <span
                      class="text-[8px] lg:text-sm text-yellow-500 dark:text-yellow-400"
                      >24 Points</span
                    >
                  </div>
                </div>
              </div>

              <!-- Primary Nav -->
              <ul
                class="flex items-center space-x-3 md:space-x-12 xl:space-x-16 relative"
              >
                <li><a href="#" class="hover:text-emerald-300">Home</a></li>
                <li>
                  <a href="preMatch.html" class="hover:text-emerald-300"
                    >Pre-Match</a
                  >
                </li>
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
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="ml-1 h-4 w-4"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                      />
                    </svg>
                  </button>

                  <ul
                    x-show="open"
                    x-transition
                    @click.outside="open=false"
                    class="absolute left-0 mt-2 w-48 rounded-lg dark:bg-emerald-900 bg-white text-emerald-950 shadow-lg z-50"
                  >
                    <li>
                      <a
                        href="sabong2.html"
                        class="block px-4 py-2 dark:hover:bg-emerald-500 dark:hover:bg-emerald-600 hover:bg-emerald-200"
                        >Billiards</a
                      >
                    </li>
                    <li>
                      <a
                        href="kabayo2.html"
                        class="block px-4 py-2 dark:hover:bg-emerald-500 dark:hover:bg-emerald-600 hover:bg-emerald-200"
                        >Horse Racing</a
                      >
                    </li>
                    <li>
                      <a
                        href="race.html"
                        class="block px-4 py-2 dark:hover:bg-emerald-500 dark:hover:bg-emerald-600 hover:bg-emerald-200 rounded-b-lg"
                        >Motor Racing</a
                      >
                    </li>
                  </ul>
                </li>
              </ul>
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
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            @keydown.escape.window="sidebarOpen=false"
          >
            <div class="flex h-full flex-col">
              <div class="mb-2 flex items-center justify-between md:text-sm">
                <span class="font-semibold lg:text-lg">Menu</span>
                <!-- Close (visible on mobile+tablet) -->
                <button
                  class="rounded-md px-2 py-1 hover:bg-emerald-300/40 dark:hover:bg-emerald-300/40 lg:hidden"
                  @click="sidebarOpen=false"
                >
                  Close
                </button>
              </div>

              <nav class="flex-1">
                <ul class="space-y-1 md:text-sm">
                  <li>
                    <a
                      href="#"
                      class="flex w-full items-center gap-2 rounded px-2 py-2 hover:bg-emerald-300/40 hover:text-emerald-600 border-b border-gray-200 dark:border-emerald-800 dark:hover:bg-emerald-300/40 dark:hover:text-emerald-300"
                    >
                      <i class="fa-solid fa-tv"></i>
                      <span>Live Betszx</span>
                    </a>
                  </li>

                  <li>
                    <a
                      href="#"
                      class="flex w-full items-center gap-2 rounded px-2 py-2 hover:bg-emerald-300/40 hover:text-emerald-600 border-b border-gray-200 dark:border-emerald-800 dark:hover:bg-emerald-300/40 dark:hover:text-emerald-300"
                    >
                      <i class="fa-solid fa-coins"></i>
                      <span>My Bets</span>
                    </a>
                  </li>

                  <li>
                    <a
                      href="#"
                      class="flex w-full items-center gap-2 rounded px-2 py-2 hover:bg-emerald-300/40 hover:text-emerald-600 border-b border-gray-200 dark:border-emerald-800 dark:hover:bg-emerald-300/40 dark:hover:text-emerald-300"
                    >
                      <i class="fa-solid fa-wallet"></i>
                      <span>My Wallet</span>
                    </a>
                  </li>

                  <li>
                    <a
                      href="#"
                      class="flex w-full items-center gap-2 rounded px-2 py-2 hover:bg-emerald-300/40 hover:text-emerald-600 border-b border-gray-200 dark:border-emerald-800 dark:hover:bg-emerald-300/40 dark:hover:text-emerald-300"
                    >
                      <i class="fa-solid fa-ranking-star"></i>
                      <span>Leaderboards</span>
                    </a>
                  </li>

                  <li>
                    <a
                      href="#"
                      class="flex w-full items-center gap-2 rounded px-2 py-2 hover:bg-emerald-300/40 hover:text-emerald-600 border-b border-gray-200 dark:border-emerald-800 dark:hover:bg-emerald-300/40 dark:hover:text-emerald-300"
                    >
                      <i class="fa-regular fa-clock"></i>
                      <span>Upcoming Matches</span>
                    </a>
                  </li>
                </ul>
              </nav>

              <!-- Night Mode Toggle -->
              <div
                class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-800"
              >
                <button
                  type="button"
                  class="w-full flex items-center justify-between gap-3 rounded-lg px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-emerald-900 dark:hover:bg-emerald-800"
                  @click="theme = (theme === 'dark' ? 'light' : 'dark')"
                  :aria-pressed="theme === 'dark'"
                >
                  <span class="flex items-center gap-2">
                    <span
                      class="relative inline-flex h-5 w-5 items-center justify-center"
                    >
                      <i
                        class="fa-solid fa-sun absolute transition-opacity duration-200"
                        :class="theme === 'dark' ? 'opacity-0' : 'opacity-100'"
                      ></i>
                      <i
                        class="fa-solid fa-moon absolute transition-opacity duration-200"
                        :class="theme === 'dark' ? 'opacity-100' : 'opacity-0'"
                      ></i>
                    </span>
                    <span class="text-sm">Night Mode</span>
                  </span>
                  <span
                    class="relative inline-flex h-5 w-10 items-center rounded-full bg-gray-300 dark:bg-gray-600 transition-colors duration-200"
                  >
                    <span
                      class="absolute h-4 w-4 rounded-full bg-white dark:bg-gray-200 transform transition-transform duration-200"
                      :class="theme === 'dark' ? 'translate-x-5' : 'translate-x-1'"
                    ></span>
                  </span>
                </button>
                <p
                  class="mt-1 text-[0.625rem] text-gray-500 dark:text-gray-400"
                >
                  Toggles the entire site theme.
                </p>
              </div>
            </div>
          </aside>

          <!-- ===== Main content (no shift on md when sidebar opens) ===== -->
          <main class="mt-0 lg:ml-5">
            <!-- Hero -->
            <section
              class="relative overflow-hidden rounded-lg p-5 bg-[url('images/snookerplayer.jpg')] bg-cover bg-center bg-no-repeat dark:text-emerald-50 lg:py-20"
            >
              <!-- Dark overlay -->
              <div
                class="absolute inset-0 dark:bg-black/60 bg-gray-800/50"
              ></div>
              <!-- If you want stronger on dark mode only, add: dark:bg-black/70 -->

              <!-- Content (stack above overlay) -->
              <div class="relative z-10 grid items-center gap-8 md:grid-cols-2">
                <div>
                  <h1
                    class="text-2xl font-semibold text-white sm:text-4xl lg:text-5xl md:text-6xl"
                  >
                    Bet. Break. Win Big!
                  </h1>
                  <p
                    class="mt-3 text-xs text-white/90 sm:text-base lg:text-lg md:text-2xl"
                  >
                    Dive into the ultimate billiards betting experience — where
                    every shot counts and every match could make you a winner.
                  </p>

                  <div
                    class="mt-5 flex flex-wrap gap-3 font-semibold text-black"
                  >
                    <a
                      href="#"
                      class="inline-flex items-center gap-2 rounded-full bg-emerald-400 px-4 py-2 text-[0.75rem] hover:bg-emerald-500 transition-colors duration-200 sm:text-sm lg:text-base md:px-6 md:py-3 md:text-lg"
                    >
                      <i class="fa-solid fa-star"></i> Join now
                    </a>
                    <a
                      href="#"
                      class="inline-flex items-center gap-2 rounded-full bg-yellow-300 px-4 py-2 text-[0.75rem] hover:bg-yellow-400 transition-colors duration-200 sm:text-sm lg:text-base md:px-6 md:py-3 md:text-lg"
                    >
                      <i class="fa-solid fa-sack-dollar"></i> Start Betting
                    </a>
                  </div>
                </div>
              </div>
            </section>

            <!-- ===== Live Streaming Section (place right after the Hero section) ===== -->

            <div data-aos="fade-down" data-aos-once="true">
              <!-- Cards Container -->
              <div
                class="flex justify-center items-center gap-4 scale-90 md:scale-100 my-12 md:my-40"
              >
                <!-- Card 1 -->
                <div
                  class="relative rounded-xl bg-emerald-100 w-1/3 h-[12.5rem] bg-cover bg-center md:h-[30rem] md:w-[25rem] hover:scale-105 transform transition duration-300 hover:shadow-[0_0_20px_3px_rgba(16,185,129,0.8)] dark:bg-gray-800"
                  style="background-image: url('images/BilliardVisual.png')"
                >
                  <div
                    class="absolute inset-0 bg-black/40 hover:bg-black/70 duration-300 transition-colors rounded-xl"
                  >
                    <div
                      class="relative text-white mt-24 p-2 2xl:mt-[18.75rem]"
                    >
                      <h1 class="font-semibold md:text-5xl">Billiards</h1>
                      <p class="text-[0.5rem] md:text-lg md:pl-2 py-2">
                        Aim for precision and predict the winners in every cue
                        match.
                      </p>
                    </div>
                    <a
                      href="sabong2.html"
                      class="absolute bg-yellow-300 text-[0.5rem] md:text-lg rounded-full p-1 font-semibold -translate-y-3 translate-x-[4.25rem] md:translate-x-[16.25rem] md:px-4 hover:bg-yellow-400 text-black"
                    >
                      Bet Now
                    </a>
                  </div>
                </div>

                <!-- Card 2 -->
                <div
                  class="relative rounded-xl bg-emerald-100 w-1/3 h-[12.5rem] bg-cover bg-center md:h-[30rem] md:w-[25rem] hover:scale-105 transform transition duration-300 hover:shadow-[0_0_20px_3px_rgba(16,185,129,0.8)] dark:bg-gray-800"
                  style="background-image: url('images/MotorVisual.png')"
                >
                  <div
                    class="absolute inset-0 bg-black/40 hover:bg-black/70 duration-300 transition-colors rounded-xl"
                  >
                    <div class="relative text-white mt-24 p-2 md:mt-[18.75rem]">
                      <h1
                        class="whitespace-nowrap shrink-0 font-semibold md:text-5xl"
                      >
                        Motor Racing
                      </h1>
                      <p class="text-[0.5rem] md:text-lg md:pl-2 py-2">
                        Bet on the fastest machines and top drivers from leagues
                        around the world.
                      </p>
                    </div>
                    <a
                      href="race.html"
                      class="absolute bg-yellow-300 text-[0.5rem] md:text-lg rounded-full p-1 font-semibold -translate-y-6 translate-x-[4.25rem] md:translate-x-[16.25rem] md:px-4 hover:bg-yellow-400 text-black"
                    >
                      Bet Now
                    </a>
                  </div>
                </div>

                <!-- Card 3 -->
                <div
                  class="relative rounded-xl bg-emerald-100 w-1/3 h-[12.5rem] bg-cover bg-center md:h-[30rem] md:w-[25rem] hover:scale-105 transform transition duration-300 hover:shadow-[0_0_20px_3px_rgba(16,185,129,0.8)] dark:bg-gray-800"
                  style="background-image: url('images/HorseVisual.png')"
                >
                  <div
                    class="absolute inset-0 bg-black/40 hover:bg-black/70 duration-300 transition-colors rounded-xl"
                  >
                    <div class="relative text-white mt-24 p-2 md:mt-[18.75rem]">
                      <h1
                        class="whitespace-nowrap shrink-0 font-semibold md:text-5xl"
                      >
                        Horse Racing
                      </h1>
                      <p class="text-[0.5rem] md:text-lg md:pl-2 py-2">
                        Experience the thrill of the tracks with live odds and
                        instant results.
                      </p>
                    </div>
                    <a
                      href="kabayo2.html"
                      class="absolute bg-yellow-300 text-[0.5rem] md:text-lg rounded-full p-1 font-semibold -translate-y-3 translate-x-[4.25rem] md:translate-x-[16.25rem] md:px-4 hover:bg-yellow-400 text-black"
                    >
                      Bet Now
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <section
              id="live"
              x-data="{ showChat: false }"
              class="mt-6 md:mt-10 w-full rounded-lg bg-white/80 dark:bg-emerald-950/60 backdrop-blur supports-[backdrop-filter]:bg-white/70 dark:supports-[backdrop-filter]:bg-emerald-950/50 shadow-md ring-1 ring-black/5 dark:ring-white/10"
            >
              <!-- Header -->
              <div class="flex items-center justify-between px-4 py-3 md:px-6">
                <h2
                  class="text-lg md:text-2xl font-semibold text-emerald-950 dark:text-emerald-50"
                >
                  Live Stream
                </h2>

                <!-- Mobile chat toggle -->
                <button
                  class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs md:hidden border-emerald-300/60 text-emerald-800 dark:border-emerald-700 dark:text-emerald-200"
                  @click="showChat = !showChat"
                >
                  <i class="fa-solid fa-comments"></i>
                  <span x-text="showChat ? 'Hide Chat' : 'Show Chat'"></span>
                </button>
              </div>

              <div
                class="grid gap-4 md:gap-6 md:grid-cols-3 px-4 pb-4 md:px-6 md:pb-6"
              >
                <!-- VIDEO + INFO (spans 2 cols on md+) -->
                <div class="md:col-span-2 space-y-4">
                  <!-- Player -->
                  <div
                    class="relative w-full aspect-[16/9] rounded-lg overflow-hidden bg-black"
                  >
                    <!-- Option A: YouTube (uncomment to use) -->

                    <iframe
                      class="absolute inset-0 w-full h-full"
                      src="https://www.youtube.com/embed/5qap5aO4i9A"
                      title="Live Stream"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowfullscreen
                    >
                    </iframe>

                    <!-- Option B: Placeholder poster if you don’t have a stream yet
                    <img
                      src="images/snookerplayer.jpg"
                      alt=""
                      class="absolute inset-0 h-full w-full object-cover opacity-60"
                    />
                    <div class="absolute inset-0 grid place-items-center">
                      <button
                        class="inline-flex items-center gap-2 rounded-full bg-emerald-500/90 hover:bg-emerald-500 px-5 py-2 text-white font-semibold transition"
                      >
                        <i class="fa-solid fa-play"></i> Watch Live
                      </button>
                    </div>
                     -->
                  </div>

                  <!-- Match / stream meta + controls -->
                  <div
                    class="flex flex-col md:flex-row md:items-center md:justify-between gap-3"
                  >
                    <div class="space-y-0.5">
                      <p
                        class="text-sm text-emerald-900/80 dark:text-emerald-100/80"
                      >
                        🔴 <span class="font-semibold">LIVE</span> · Billiards —
                        Quarterfinal
                      </p>
                      <p class="text-xs text-gray-600 dark:text-gray-300">
                        Table 2 · Best of 7 · Est. viewers: 2,341
                      </p>
                    </div>

                    <div class="flex items-center gap-2">
                      <button
                        class="rounded-full border px-3 py-1.5 text-xs border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100"
                      >
                        1080p
                      </button>
                      <button
                        class="rounded-full border px-3 py-1.5 text-xs border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100"
                      >
                        Mute
                      </button>
                      <button
                        class="rounded-full border px-3 py-1.5 text-xs border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100"
                      >
                        Fullscreen
                      </button>
                    </div>
                  </div>
                </div>

                <!-- CHAT (sticky height; collapses on mobile) -->
                <aside
                  class="md:block"
                  :class="{'hidden': !showChat, 'block': showChat }"
                >
                  <div
                    class="flex flex-col rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden h-[28rem]"
                  >
                    <div class="px-3 py-2 bg-gray-100 dark:bg-emerald-900/60">
                      <p
                        class="text-sm font-semibold text-emerald-900 dark:text-emerald-50"
                      >
                        Live Chat
                      </p>
                    </div>

                    <!-- Messages -->
                    <div
                      class="flex-1 overflow-y-auto p-3 space-y-3 bg-white/70 dark:bg-emerald-950/30"
                    >
                      <div class="text-xs">
                        <span
                          class="font-semibold text-emerald-800 dark:text-emerald-200"
                          >CueMaster42</span
                        >
                        <span class="text-gray-600 dark:text-gray-300"
                          >· insane safety 😮</span
                        >
                      </div>
                      <div class="text-xs">
                        <span
                          class="font-semibold text-emerald-800 dark:text-emerald-200"
                          >RackAttack</span
                        >
                        <span class="text-gray-600 dark:text-gray-300"
                          >· calling a 4–1 here</span
                        >
                      </div>
                      <div class="text-xs">
                        <span
                          class="font-semibold text-emerald-800 dark:text-emerald-200"
                          >SpinDoctor</span
                        >
                        <span class="text-gray-600 dark:text-gray-300"
                          >· that break was clean</span
                        >
                      </div>
                      <!-- ... -->
                    </div>

                    <!-- Composer -->
                    <form
                      class="p-2 bg-gray-50 dark:bg-emerald-900/50 border-t border-gray-200 dark:border-gray-700"
                      @submit.prevent
                    >
                      <div class="flex items-center gap-2">
                        <input
                          type="text"
                          placeholder="Send a message"
                          class="flex-1 rounded-md border border-gray-300 dark:border-gray-600 bg-white/90 dark:bg-emerald-950/60 px-3 py-2 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                        />
                        <button
                          type="submit"
                          class="rounded-md bg-emerald-500 hover:bg-emerald-600 text-white text-sm px-3 py-2"
                        >
                          Send
                        </button>
                      </div>
                    </form>
                  </div>
                </aside>
              </div>
            </section>

            <h1
              class="font-semibold text-emerald-100 my-2 ml-4 md:text-3xl md:ml-[8.75rem] md:mb-6"
              data-aos="fade-up"
              data-aos-once="true"
            >
              Sports News
            </h1>

            <div class="mx-auto" data-aos="fade-down" data-aos-once="true">
              <div class="flex space-x-3 justify-center lg:justify-center">
                <!-- News Card -->
                <div
                  class="flex-col bg-emerald-100 rounded-xl w-[7.25rem] overflow-hidden h-[7.90rem] text-xs md:w-1/4 lg:h-[18.9rem] dark:bg-gray-800"
                >
                  <img
                    src="images/news1.jpg"
                    class="w-full aspect-[16/9] object-cover block"
                    alt=""
                  />
                  <h1
                    class="font-semibold text-[0.5625rem] px-1 text-emerald-950 md:text-xl dark:text-emerald-50"
                  >
                    What is the best way to play Billiards?
                  </h1>
                  <p
                    class="line-clamp-3 text-[0.4375rem] mt-1 px-1 text-emerald-900 md:text-sm dark:text-gray-300"
                  >
                    The best way to play Super Ace is to start with small
                    bets...
                  </p>
                  <a
                    href="#"
                    class="block text-center text-[0.5625rem] text-emerald-700 md:text-sm md:my-2 dark:text-emerald-300"
                  >
                    Read More
                  </a>
                </div>

                <div
                  class="flex-col bg-emerald-100 rounded-xl w-[7.25rem] overflow-hidden h-[7.90rem] text-xs md:w-1/4 lg:h-[18.9rem] dark:bg-gray-800"
                >
                  <img
                    src="images/horsenews.jpg"
                    class="w-full aspect-[16/9] object-cover block"
                    alt=""
                  />
                  <h1
                    class="font-semibold text-[0.5625rem] px-1 text-emerald-950 md:text-xl dark:text-emerald-50"
                  >
                    What is the best way to play Billiards?
                  </h1>
                  <p
                    class="line-clamp-3 text-[0.4375rem] mt-1 px-1 text-emerald-900 md:text-sm dark:text-gray-300"
                  >
                    The best way to play Super Ace is to start with small
                    bets...
                  </p>
                  <a
                    href="#"
                    class="block text-center text-[0.5625rem] text-emerald-700 md:text-sm md:my-2 dark:text-emerald-300"
                  >
                    Read More
                  </a>
                </div>

                <div
                  class="flex-col bg-emerald-100 rounded-xl w-[7.25rem] overflow-hidden h-[7.90rem] text-xs md:w-1/4 lg:h-[18.9rem] dark:bg-gray-800"
                >
                  <img
                    src="images/motornews.jpg"
                    class="w-full aspect-[16/9] object-cover block"
                    alt=""
                  />
                  <h1
                    class="font-semibold text-[0.5625rem] px-1 text-emerald-950 md:text-xl dark:text-emerald-50"
                  >
                    What is the best way to play Billiards?
                  </h1>
                  <p
                    class="line-clamp-3 text-[0.4375rem] mt-1 px-1 text-emerald-900 md:text-sm dark:text-gray-300"
                  >
                    The best way to play Super Ace is to start with small
                    bets...
                  </p>
                  <a
                    href="#"
                    class="block text-center text-[0.5625rem] text-emerald-700 md:text-sm md:my-2 dark:text-emerald-300"
                  >
                    Read More
                  </a>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>

</x-layouts.app>
