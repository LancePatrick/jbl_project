{{-- resources/views/dashboard.blade.php --}}
<x-layouts.app :title="__('Dashboard')">

  <!-- ===== Main content ===== -->
  <main class="mt-0 lg:ml-5">
    <!-- Hero -->
    <section
      class="relative overflow-hidden rounded-lg p-5 bg-cover bg-center bg-no-repeat dark:text-emerald-50 lg:py-20"
      style="background-image: url('{{ asset('images/snookerplayer.jpg') }}')">
      <div class="absolute inset-0 !dark:bg-black/60 !bg-gray-800/50"></div>
      <div class="relative z-10 grid items-center gap-8 md:grid-cols-2">
        <div>
          <h1 class="text-2xl font-semibold text-white sm:text-4xl lg:text-5xl md:text-6xl">
            Bet. Break. Win Big!
          </h1>
          <p class="mt-3 text-xs text-white/90 sm:text-base lg:text-lg md:text-2xl">
            Dive into the ultimate billiards betting experience — where every shot counts and every match could make you
            a winner.
          </p>
          <div class="mt-5 flex flex-wrap gap-3 font-semibold text-black">
            <a href="#"
              class="inline-flex items-center gap-2 rounded-full bg-emerald-400 px-4 py-2 text-[0.75rem] hover:bg-emerald-500 transition-colors duration-200 sm:text-sm lg:text-base md:px-6 md:py-3 md:text-lg">
              <i class="fa-solid fa-star"></i> Join now
            </a>
            <a href="#"
              class="inline-flex items-center gap-2 rounded-full bg-yellow-300 px-4 py-2 text-[0.75rem] hover:bg-yellow-400 transition-colors duration-200 sm:text-sm lg:text-base md:px-6 md:py-3 md:text-lg">
              <i class="fa-solid fa-sack-dollar"></i> Start Betting
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Cards -->
    <div>
      <div class="flex justify-center items-center gap-4 scale-90 md:scale-100 my-12 md:my-40">
        <!-- Card 1 -->
        <div
          class="relative rounded-xl bg-emerald-100 w-1/3 h-[12.5rem] bg-cover bg-center md:h-[30rem] md:w-[25rem] hover:scale-105 transform transition duration-300 hover:shadow-[0_0_20px_3px_rgba(16,185,129,0.8)] dark:bg-gray-800"
          style="background-image: url('images/BilliardVisual.png')">
          <div class="absolute inset-0 !bg-black/40 hover:bg-black/70 duration-300 transition-colors rounded-xl">
            <div class="relative text-white mt-24 p-2 2xl:mt-[18.75rem]">
              <h1 class="font-semibold md:text-5xl">Billiards</h1>
              <p class="text-[0.5rem] md:text-lg md:pl-2 py-2">Aim for precision and predict the winners in every cue
                match.</p>
            </div>
            <a href="{{ route('billiard') }}"
              class="absolute bg-yellow-300 text-[0.5rem] md:text-lg rounded-full p-1 font-semibold -translate-y-3 translate-x-[4.25rem] md:translate-x-[16.25rem] md:px-4 hover:bg-yellow-400 text-black">Bet
              Now</a>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="relative rounded-xl bg-emerald-100 w-1/3 h-[12.5rem] bg-cover bg-center md:h-[30rem] md:w-[25rem] hover:scale-105 transform transition duration-300 hover:shadow-[0_0_20px_3px_rgba(239,68,68,0.8)]
 dark:bg-gray-800" style="background-image: url('images/MotorVisual.png')">
          <div class="absolute inset-0 !bg-black/40 hover:!bg-black/70 duration-300 transition-colors rounded-xl">
            <div class="relative text-white mt-24 p-2 md:mt-[18.75rem]">
              <h1 class="whitespace-nowrap shrink-0 font-semibold md:text-5xl">Motor Racing</h1>
              <p class="text-[0.5rem] md:text-lg md:pl-2 py-2">Bet on the fastest machines and top drivers from leagues
                around the world.</p>
            </div>
            <a href="{{ route('drag.race') }}"
              class="absolute bg-yellow-300 text-[0.5rem] md:text-lg rounded-full p-1 font-semibold -translate-y-6 translate-x-[4.25rem] lg:-translate-y-2 md:translate-x-[16.25rem] md:px-4 hover:bg-yellow-400 text-black">Bet
              Now</a>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="relative rounded-xl bg-emerald-100 w-1/3 h-[12.5rem] bg-cover bg-center md:h-[30rem] md:w-[25rem] hover:scale-105 transform transition duration-300 hover:shadow-[0_0_20px_3px_rgba(234,179,8,0.8)]
 dark:bg-gray-800" style="background-image: url('images/HorseVisual.png')">
          <div class="absolute inset-0 !bg-black/40 hover:!bg-black/70 duration-300 transition-colors rounded-xl">
            <div class="relative text-white mt-24 p-2 md:mt-[18.75rem]">
              <h1 class="whitespace-nowrap shrink-0 font-semibold md:text-5xl">Horse Racing</h1>
              <p class="text-[0.5rem] md:text-lg md:pl-2 py-2">Experience the thrill of the tracks with live odds and
                instant results.</p>
            </div>
            <a href="{{ route('horse') }}"
              class="absolute bg-yellow-300 text-[0.5rem] md:text-lg rounded-full p-1 font-semibold -translate-y-3 translate-x-[4.25rem] md:translate-x-[16.25rem] md:px-4 hover:bg-yellow-400 text-black">Bet
              Now</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Live Stream + Chat -->
    <section id="live" x-data="{ showChat: false }"
      class="mt-6 md:mt-10 w-full rounded-lg bg-white/80 dark:bg-slate-950/60 backdrop-blur supports-[backdrop-filter]:bg-white/70 dark:supports-[backdrop-filter]:bg-slate-950/50 shadow-md ring-1 ring-black/5 dark:ring-white/10">
      <div class="flex items-center justify-between px-4 py-3 md:px-6">
        <h2 class="text-lg md:text-2xl font-semibold text-slate-950 dark:text-slate-50">Live Stream</h2>
        <button
          class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs md:hidden border-slate-300/60 text-slate-800 dark:border-slate-700 dark:text-slate-200"
          @click="showChat = !showChat">
          <i class="fa-solid fa-comments"></i>
          <span x-text="showChat ? 'Hide Chat' : 'Show Chat'"></span>
        </button>
      </div>

      <div class="grid gap-4 md:gap-6 md:grid-cols-3 px-4 pb-4 md:px-6 md:pb-6">
        <div class="md:col-span-2 space-y-4">
          <div class="relative w-full aspect-[16/9] rounded-lg overflow-hidden bg-black">
            <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/5qap5aO4i9A"
              title="Live Stream" frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen></iframe>
          </div>

          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div class="space-y-0.5">
              <p class="text-sm text-slate-900/80 dark:text-slate-100/80">🔴 <span class="font-semibold">LIVE</span>
                · Billiards — Quarterfinal</p>
              <p class="text-xs text-gray-600 dark:text-gray-300">Table 2 · Best of 7 · Est. viewers: 2,341</p>
            </div>
            <div class="flex items-center gap-2">
              <button
                class="rounded-full border px-3 py-1.5 text-xs border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100">1080p</button>
              <button
                class="rounded-full border px-3 py-1.5 text-xs border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100">Mute</button>
              <button
                class="rounded-full border px-3 py-1.5 text-xs border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100">Fullscreen</button>
            </div>
          </div>
        </div>

        <aside class="md:block" :class="{'hidden': !showChat, 'block': showChat }">
          <div class="flex flex-col rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden h-[28rem]">
            <div class="px-3 py-2 bg-gray-100 dark:bg-slate-900/60">
              <p class="text-sm font-semibold text-slate-900 dark:text-slate-50">Live Chat</p>
            </div>

            <div class="flex-1 overflow-y-auto p-3 space-y-3 bg-white/70 dark:bg-emerald-950/30">
              <div class="text-xs">
                <span class="font-semibold text-slate-800 dark:text-slate-200">CueMaster42</span>
                <span class="text-gray-600 dark:text-gray-300">· insane safety 😮</span>
              </div>
              <div class="text-xs">
                <span class="font-semibold text-slate-800 dark:text-slate-200">RackAttack</span>
                <span class="text-gray-600 dark:text-gray-300">· calling a 4–1 here</span>
              </div>
              <div class="text-xs">
                <span class="font-semibold text-slate-800 dark:text-slate-200">SpinDoctor</span>
                <span class="text-gray-600 dark:text-gray-300">· that break was clean</span>
              </div>
            </div>

            <form class="p-2 bg-gray-50 dark:bg-slate-900/50 border-t border-gray-200 dark:border-gray-700"
              @submit.prevent>
              <div class="flex items-center gap-2">
                <input type="text" placeholder="Send a message"
                  class="flex-1 rounded-md border border-gray-300 dark:border-gray-600 bg-white/90 dark:bg-slate-950/60 px-3 py-2 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-slate-400" />
                <button type="submit"
                  class="rounded-md bg-slate-500 hover:bg-slate-600 text-white text-sm px-3 py-2">Send</button>
              </div>
            </form>
          </div>
        </aside>
      </div>
    </section>



    <div class="mx-auto lg:my-24">
      <h1 class="font-semibold text-emerald-100 my-2 ml-4 lg:text-4xl  lg:mb-6">
        Sports News
      </h1>
      <div class="flex space-x-3 justify-center lg:justify-center">
        <!-- News Card -->
        <div
          class="flex-col bg-emerald-100 rounded-xl w-[7.25rem] overflow-hidden h-[7.90rem] text-xs lg:w-1/3 lg:h-[22.5rem] dark:bg-gray-800">
          <img src="images/news1.jpg" class="w-full aspect-[16/9] object-cover block" alt="" />

          <div class="p-2">
            <h1 class="font-semibold text-[0.5625rem] px-1 text-emerald-950 md:text-xl dark:text-emerald-50">
              What is the best way to play Billiards?
            </h1>
            <p class="line-clamp-3 text-[0.4375rem] mt-1 px-1 text-emerald-900 md:text-sm dark:text-gray-300">
              The best way to play Super Ace is to start with small bets...
            </p>
            <a href="#"
              class="block text-center text-[0.5625rem] text-emerald-700 lg:text-sm md:my-2 dark:text-emerald-300 hover:underline">
              Read More
            </a>
          </div>
        </div>

        <div
          class="flex-col bg-emerald-100 rounded-xl w-[7.25rem] overflow-hidden h-[7.90rem] text-xs lg:w-1/3 lg:h-[22.5rem] dark:bg-gray-800">
          <img src="images/horsenews.jpg" class="w-full aspect-[16/9] object-cover block" alt="" />
          <div class="p-2">
            <h1 class="font-semibold text-[0.5625rem] px-1 text-emerald-950 md:text-xl dark:text-emerald-50">
              What is the best way to play Billiards?
            </h1>
            <p class="line-clamp-3 text-[0.4375rem] mt-1 px-1 text-emerald-900 md:text-sm dark:text-gray-300">
              The best way to play Super Ace is to start with small bets...
            </p>
            <a href="#"
              class="block text-center text-[0.5625rem] text-emerald-700 lg:text-sm md:my-2 dark:text-emerald-300 hover:underline">
              Read More
            </a>
          </div>
        </div>

        <div
          class="flex-col bg-emerald-100 rounded-xl w-[7.25rem] overflow-hidden h-[7.90rem] text-xs lg:w-1/3 lg:h-[22.5rem] dark:bg-gray-800">
          <img src="images/motornews.jpg" class="w-full aspect-[16/9] object-cover block" alt="" />
          <div class="p-2">
            <h1 class="font-semibold text-[0.5625rem] px-1 text-emerald-950 md:text-xl dark:text-emerald-50">
              What is the best way to play Billiards?
            </h1>
            <p class="line-clamp-3 text-[0.4375rem] mt-1 px-1 text-emerald-900 md:text-sm dark:text-gray-300">
              The best way to play Super Ace is to start with small bets...
            </p>
            <a href="#"
              class="block text-center text-[0.5625rem] text-emerald-700 lg:text-sm md:my-2 dark:text-emerald-300 hover:underline">
              Read More
            </a>
          </div>
        </div>
      </div>
    </div>
    <!--Footer-->
    <footer
      class="flex bg-white/80 text-slate-950 dark:bg-slate-900/80 dark:text-slate-50 my-4 p-4 gap-3 rounded-lg lg:h-70 lg:gap-5">
      <div class="flex flex-col gap-1 w-1/2 lg:gap-2">
        <!--Left-->
        <h1 class="font-bold text-sm lg:text-xl">
          We make betting easy, try all our games and bet now!
        </h1>
        <h1 class="text-xs lg:text-sm">
          For our latest news, sign up to our newsletter.
        </h1>
        <input type="text" class="p-1 border-b border-slate-900 dark:border-slate-200" placeholder="Email Address" />
        <div class="flex gap-2">
          <a href=""><i class="fa-brands fa-facebook"></i></a>
          <a href=""><i class="fa-brands fa-instagram"></i></a>
          <a href=""><i class="fa-brands fa-square-x-twitter"></i></a>
          <a href=""><i class="fa-brands fa-youtube"></i></a>
        </div>
        <h1 class="text-[10px]">BK2025. All rights reserved, 2025</h1>
      </div>
      <div class="flex flex-col w-1/3 text-[12px] gap-2 lg:gap-4 lg:mt-4 font-semibold">
        <!--Right-->
        <a href="" class="hover:underline underline-offset-2">Get in touch</a>
        <a href="" class="hover:underline underline-offset-2">Join our team</a>
        <a href="" class="hover:underline underline-offset-2">About</a>
        <a href="" class="hover:underline underline-offset-2">FAQ</a>
        <a href="" class="hover:underline underline-offset-2">Terms of Use</a>
        <a href="" class="hover:underline underline-offset-2">Privacy</a>
      </div>
      <div class="flex flex-col w-1/3 text-[12px] gap-2 lg:gap-4 lg:mt-4 font-semibold">
        <!--Right-->
        <a href="" class="hover:underline underline-offset-2">Billiard Club</a>
        <a href="" class="hover:underline underline-offset-2">Promotions</a>
        <a href="" class="hover:underline underline-offset-2">Betting</a>
        <a href="" class="hover:underline underline-offset-2">Terms of Service</a>
      </div>
    </footer>
  </main>
</x-layouts.app>