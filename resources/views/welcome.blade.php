{{-- resources/views/pre.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Billiards Website</title>

  <!-- Tailwind (CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    crossorigin="anonymous" />

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <!-- Alpine -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="overflow-x-hidden bg-[url('images/table.png')] bg-cover bg-center bg-no-repeat">
  <div class="overflow-x-hidden bg-gradient-to-b from-slate-950/70 via-slate-800/70 to-slate-700/30">
    <div class="flex flex-col w-full">
      <nav
        class="relative bg-emerald-950 px-2 py-2 flex font-semibold items-center justify-between text-[10px] 2xl:text-xl 2xl:py-[2px] 2xl:px-12 shadow-lg shadow-emerald-800/50">
        <!-- Logo -->
        <img src="{{ asset('images/logo2real.png') }}" class="h-8 2xl:h-20" alt="Logo" />

        <!-- Nav Links -->
        <ul class="flex flex-wrap space-x-5 2xl:space-x-20 text-emerald-50 relative" x-data="{ open: false }">
          <!-- HOME -> dashboard.blade.php -->
          <li><a href="{{ route('dashboard') }}" class="hover:text-emerald-300">Home</a></li>
          <li><a href="{{ route('pre-match') }}" class="hover:text-emerald-300">Pre-Match</a></li>

          <li><a href="#" class="hover:text-emerald-300">About</a></li>
          <li><a href="{{ route('event') }}" class="hover:text-emerald-300">Event</a></li>

          <!-- Dropdown -->
          <li class="relative items-center">
            <button @click="open = !open" class="hover:text-emerald-300 inline-flex items-center text-center">
              Sports
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <ul x-show="open" @click.away="open = false" x-transition
              class="absolute left-0 mt-2 bg-emerald-900 text-white rounded-lg shadow-lg w-44 z-50">
              @auth
                @if (auth()->user()->role_id == 3)
                  <li>
                    <a href="teller-billiard" class="block px-4 py-2 hover:bg-emerald-700">
                      Billiards
                    </a>
                  </li>
                @else
                  <li>
                    <a href="billiard" class="block px-4 py-2 hover:bg-emerald-700">
                      Billiards
                    </a>
                  </li>
                @endif
              @endauth

              @guest
                <li>
                  <a href="billiard" class="block px-4 py-2 hover:bg-emerald-700">
                    Billiards
                  </a>
                </li>
              @endguest
              <li>
                <a href="horse" class="block px-4 py-2 hover:bg-emerald-700">Horse Racing</a>
              </li>
              <li>
                <a href="{{ route('drag.race') }}" class="block px-4 py-2 hover:bg-emerald-700">Motor Racing</a>
              </li>
            </ul>
          </li>
        </ul>


        @auth
          <div x-data="{ open: false }" class="flex space-x-1 relative -translate-x-8 items-center" @click="open = !open">
            <!-- Image (clickable trigger) -->
            <div class="flex cursor-pointer">
              <img src="{{ asset('images/icon.png') }}" class="h-3 2xl:h-13" alt="" />
            </div>

            <!-- Dropdown menu -->
            <div x-show="open" @click.outside="open = false" x-transition
              class="absolute left-10 top-2 mt-2 2xl:top-11 w-18 2xl:w-35 text-xs bg-white border border-gray-200 rounded-lg shadow-lg z-100">
              <ul class="text-gray-700 text-sm">
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                </li>
                <li>
                  <a href="/login" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                </li>
              </ul>
            </div>
            <span class="text-white cursor-pointer hover:text-emerald-300">{{Auth::user()->name}}</span>
          </div>
        @else
          <div>
            <a href="/login" class="text-white cursor-pointer hover:text-emerald-300 ">Login</a>
          </div>
        @endauth
      </nav>

      <div class="w-full flex">
        <div class="flex text-white my-8 2xl:my-13 bg-emerald-100/10 rounded-lg mx-3 lg:mx-18 2xl:mx-15 2xl:py-4">
          <div class="flex flex-col gap-2  md:my-auto mx-4 2xl:mx-10 w-full 2xl:w-1/2">
            <h1 class="text-[25px] font-semibold w-[150px] md:w-full md:text-4xl lg:text-7xl 2xl:text-8xl 2xl:w-full">
              Bet. Break. Win Big!
            </h1>
            <p class="break-words text-[10px] md:mr-40 md:text-sm lg:mr-4 lg:text-2xl 2xl:text-3xl 2xl:py-6">
              Dive into the ultimate billiard playing experience — where
              every shot counts and every match could make you a winner.
            </p>
            <div class="flex space-x-2 my-2 text-[10px] lg:my-4 2xl:text-xl 2xl:translate-y-2 font-semibold text-black">
              <div
                class="flex bg-emerald-400 px-3 py-1 2xl:py-4 2xl:px-5 items-center gap-1 2xl:gap-2 rounded-full hover:bg-emerald-500 transition-colors duration-200">
                <i class="fa-solid fa-star lg:text-2xl"></i>
                <a href="" class="text-[8px] md:text-sm lg:text-2xl 2xl:text-lg text-center">Join now</a>
              </div>
              <div
                class="flex bg-yellow-300 px-3 py-1 2xl:py-4 2xl:px-5 items-center gap-1 2xl:gap-2 rounded-full hover:bg-yellow-400 transition-colors duration-200">
                <i class="fa-solid fa-sack-dollar lg:text-2xl"></i>
                <a href="" class="text-[8px] md:text-sm lg:text-2xl 2xl:text-lg text-center">Start Playing</a>
              </div>
            </div>
          </div>
          <img src="{{ asset('images/peoples.png') }}"
            class="h-40 w-40 translate-y-2 -translate-x-2 lg:h-80 lg:w-110 2xl:h-140 2xl:w-180 2xl:translate-y-1" alt="" />
        </div>
      </div>

      <!-- Featured Sports -->
      <div data-aos="fade-down"
        class="flex flex-col text-white items-center justify-center mx-8 my-6 2xl:my-[150px] 2xl:mx-44 px-4"
        data-aos-once="true">
        <h1 class="text-lg font-bold md:text-2xl xl:text-sm 2xl:text-4xl text-center">
          Featured Sports
        </h1>
        <h1 class="text-[8px] text-center md:text-lg 2xl:text-3xl 2xl:mt-4">
          Choose your sport and start playing on your favorite events.
        </h1>
      </div>

      <div data-aos="fade-up">
        <!-- Cards Container -->
        <div class="flex flex-col mx-4 gap-4
           sm:flex-row sm:justify-center sm:items-stretch sm:gap-4
           md:flex-col md:items-center md:gap-3
           lg:flex-col lg:justify-center lg:items-stretch lg:gap-4 lg:scale-90
           xl:flex-row xl:justify-center xl:items-stretch xl:gap-4
           ">
          <!-- Card 1 -->
          <div class="relative rounded-xl bg-emerald-100
             w-full sm:w-1/3 md:w-full
             aspect-[16/6] md:aspect-[16/4]
             lg:aspect-[16/4] lg:w-full
             xl:h-160 xl:w-120
             bg-cover bg-center
             hover:scale-105 transform transition duration-300
             hover:shadow-[0_0_20px_3px_rgba(16,185,129,0.8)]"
            style="background-image: url('{{ asset('images/BilliardVisual.png') }}')">
            <div class="absolute inset-0 rounded-xl bg-black/75 hover:bg-black/60
               duration-300 transition-colors flex flex-col
               p-2 2xl:p-4 text-white">
              <div class="mx-1 mt-10 md:mt-24 lg:mt-24 2xl:mt-110">
                <h1 class="font-semibold text-base sm:text-sm md:text-xl lg:text-4xl 2xl:text-5xl">
                  Billiards
                </h1>
                <p class="mt-1 mr-20
                   text-[11px] sm:text-[9px] md:text-[11px]
                   lg:text-2xl 2xl:text-lg 2xl:pl-2">
                  Aim for precision and predict the winners in every cue match.
                </p>
              </div>

              <!-- Button block -->
              <div class="mb-40 pr-3 -top-4 flex justify-end 2xl:mb-10 2xl:pr-6">
                <a href="" class="absolute bottom-2 right-4 2xl:bottom-10 2xl:right-8
                   inline-block text-black font-bold bg-yellow-300
                   text-[12px] sm:text-[10px] md:text-[12px] lg:text-3xl 2xl:text-lg
                   rounded-full px-3 py-1 hover:bg-yellow-400">
                  Play Now
                </a>
              </div>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="relative rounded-xl bg-emerald-100
             w-full sm:w-1/3 md:w-full
             aspect-[16/6] md:aspect-[16/4]
             lg:aspect-[16/4] lg:w-full
             xl:h-160 xl:w-120
             bg-cover bg-center
             hover:scale-105 transform transition duration-300
             hover:shadow-[0_0_20px_3px_rgba(16,185,129,0.8)]"
            style="background-image: url('{{ asset('images/motorVisual.png') }}')">
            <div class="absolute inset-0 rounded-xl bg-black/75 hover:bg-black/60
               duration-300 transition-colors flex flex-col
               p-2 2xl:p-4 text-white">
              <!-- Text block -->
              <div class="mx-1 mt-10 md:mt-24 lg:mt-28 2xl:mt-110">
                <h1 class="font-semibold text-base sm:text-sm md:text-xl lg:text-4xl 2xl:text-5xl">
                  Motorcycle Racing
                </h1>
                <p class="mt-1 mr-20
                   text-[11px] sm:text-[9px] md:text-[11px]
                   lg:text-2xl 2xl:text-lg 2xl:pl-2">
                  Choose between the fastest machines and top drivers from leagues around
                  the world.
                </p>
              </div>

              <!-- Button block -->
              <div class="mb-40 pr-3 -top-4 flex justify-end 2xl:mb-10 2xl:pr-6">
                <a href="" class="absolute bottom-2 right-4 2xl:bottom-10 2xl:right-8
                   inline-block text-black font-bold bg-yellow-300
                   text-[12px] sm:text-[10px] md:text-[12px] lg:text-3xl 2xl:text-lg
                   rounded-full px-3 py-1 hover:bg-yellow-400">
                  Play Now
                </a>
              </div>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="relative rounded-xl bg-emerald-100
             w-full sm:w-1/3 md:w-full
             aspect-[16/6] md:aspect-[16/4]
             lg:aspect-[16/4] lg:w-full
             xl:h-160 xl:w-120
             bg-cover bg-center
             hover:scale-105 transform transition duration-300
             hover:shadow-[0_0_20px_3px_rgba(16,185,129,0.8)]"
            style="background-image: url('{{ asset('images/horseVisual.png') }}')">
            <div class="absolute inset-0 rounded-xl bg-black/75 hover:bg-black/60
               duration-300 transition-colors flex flex-col
               p-2 2xl:p-4 text-white">
              <!-- Text block -->
              <div class="mx-1 mt-10  md:mt-24 2xl:mt-110">
                <h1 class="font-semibold text-base sm:text-sm md:text-xl lg:text-4xl 2xl:text-5xl">
                  Horse Racing
                </h1>
                <p class="mt-1 mr-20
                   text-[11px] sm:text-[9px] md:text-[11px]
                   lg:text-2xl 2xl:text-lg 2xl:pl-2">
                  Experience the thrill of the tracks with live odds and instant
                  results
                </p>
              </div>

              <!-- Button block -->
              <a href="" class="absolute bottom-2 right-4 2xl:bottom-10 2xl:right-8
                 inline-block text-black font-bold bg-yellow-300
                 text-[12px] sm:text-[10px] md:text-[12px] lg:text-3xl 2xl:text-[20px]
                 rounded-full px-3 py-1 hover:bg-yellow-400">
               Play Now
              </a>
            </div>
          </div>
        </div>
      </div>



  

      <!-- Discover / How it works -->
      <div data-aos="fade-down"
        class="flex flex-col text-white items-center justify-center mx-8 mt-10 2xl:mt-[100px] 2xl:mx-44 px-4"
        data-aos-once="true">
        <h1 class="text-lg font-bold xl:text-sm  md:text-2xl 2xl:text-4xl text-center">
          Discover the Playing Experience
        </h1>
        <h1 class="text-[8px] text-center md:text-sm 2xl:text-3xl 2xl:mt-4">
          From playing your numbers to exploring jackpots and playing
          responsibly, here's everything you need to know.Learn how it works,
          see today's biggest prizes, and enjoy the excitement responsibly.
        </h1>
      </div>

      <div class="mt-5 2xl:-mt-[300px] 2xl:scale-[0.7] w-full overflow-x-hidden text-white items-center">
        <div data-aos="fade-right" class="flex justify-between gap-4 px-8 my-8 lg:my-28 2xl:my-80 2xl:mx-20 2xl:px-2">
          <div class="p-2 h-[100px] w-1/2 rounded-2xl 2xl:h-[500px]">
            <h1 class="text-xs font-bold md:text-2xl lg:text-4xl 2xl:text-6xl 2xl:mt-5 2xl:mb-4">
              How It Works
            </h1>
            <p class="text-[8px] md:text-sm lg:text-lg lg:my-2 2xl:text-3xl">
              Playing the lottery has never been simpler. Pick your favorite
              numbers, purchase your ticket online, and tune in for the draw.
              Winners are automatically notified, making your experience
              smooth and exciting.
            </p>
          </div>

          <div class="p-2 h-[100px] w-1/2 rounded-2xl md:h-[160px] lg:h-[250px] 2xl:h-[450px] overflow-hidden">
            <img src="{{ asset('images/week.png') }}" alt="" class="object-cover w-full h-full rounded-2xl shadow-xl" />
          </div>
        </div>

        <div data-aos="fade-right" class="flex justify-between gap-4 px-8 my-8 lg:my-28 2xl:my-80 2xl:mx-20 2xl:px-2">
          <div class="p-2 h-[100px] w-1/2 rounded-2xl md:h-[160px] lg:h-[250px] 2xl:h-[450px] overflow-hidden">
            <img src="{{ asset('images/motor.png') }}" alt=""
              class="object-cover w-full h-full rounded-2xl shadow-xl" />
          </div>

          <div class="p-2 h-[100px] w-1/2 rounded-2xl md:h-[160px] 2xl:h-[500px]">
            <h1 class="text-xs font-bold md:text-2xl lg:text-4xl 2xl:text-6xl 2xl:mt-5 2xl:mb-4">
              Current Jackpots
            </h1>
            <p class="text-[8px] md:text-sm lg:text-lg lg:my-2 2xl:text-3xl">
              Explore the latest jackpots and see which games are offering the
              biggest prizes today. From local draws to international
              lotteries, there's a chance for everyone to win big
            </p>
          </div>
        </div>

        <div data-aos="fade-right" class="flex justify-between gap-4 px-8 my-8 lg:my-28 2xl:mt-40 2xl:mx-20 2xl:px-2">
          <div class="p-2 h-[100px] w-1/2 rounded-2xl 2xl:h-[500px]">
            <h1 class="text-xs font-bold md:text-2xl lg:text-4xl 2xl:text-6xl 2xl:mt-5 2xl:mb-4">
              Responsible Gaming
            </h1>

            <p class="text-[8px] md:text-sm lg:text-lg lg:my-2 2xl:text-3xl">
              Your fun is important, but safety comes first. Set limits, play
              responsibly, and enjoy the excitement of the lottery without
              overextending yourself.
            </p>
          </div>

          <div class="p-2 h-[100px] w-1/2 rounded-2xl md:h-[160px] lg:h-[250px] 2xl:h-[450px] overflow-hidden">
            <img src="{{ asset('images/payout2.png') }}" alt=""
              class="object-cover w-full h-full rounded-2xl shadow-xl" />
          </div>
        </div>
      </div>

      <!-- News -->
      <div data-aos="fade-down"
        class="flex flex-col text-white items-center justify-center my-4 mx-8 mt-10 lg:my-12 2xl:mt-[100px] 2xl:mx-44 px-4"
        data-aos-once="true">
        <h1 class="text-lg font-bold xl:text-sm  md:text-2xl 2xl:text-4xl text-center">
          Sports News
        </h1>
        <h1 class="text-[8px] text-center md:text-sm lg:text-xl 2xl:text-3xl 2xl:mt-4">
          From race starts to final breaks—see what’s shaping the lines.
        </h1>
      </div>
      <div class="mx-auto" data-aos="fade-down" data-aos-once="true">
        <div class="flex flex-wrap justify-center gap-4 lg:gap-20 lg:mb-8">
          <div
            class="flex flex-col bg-slate-800 rounded-xl overflow-hidden w-25 h-35 text-xs md:w-52 md:h-40 lg:scale-120 2xl:w-1/4 2xl:h-90">
            <img src="{{ asset('images/news1.jpg') }}" class="w-full aspect-[16/9] object-cover block" alt="" />
            <h1 class="font-semibold text-[9px] px-1 text-white 2xl:text-xl text-center">
              What is the best way to play Billiards?
            </h1>
            <p class="line-clamp-3 text-[7px] mt-1 px-1 text-white 2xl:text-sm">
              The best way to play Super Ace is to start with small bets...
            </p>
            <a
              class="block w-full text-center mx-auto text-[9px] text-white 2xl:text-sm 2xl:my-2 hover:underline hover:underline-offset-2 hover:text-green-400">
              Read More
            </a>
          </div>

          <div
            class="flex flex-col bg-slate-800 rounded-xl w-25 overflow-hidden h-35 text-xs md:w-52 md:h-40 lg:scale-120 2xl:w-1/4 2xl:h-90">
            <img src="{{ asset('images/horsenews.jpg') }}" class="w-full aspect-[16/9] object-cover block" alt="" />
            <h1 class="font-semibold text-[9px] px-1 text-white 2xl:text-xl text-center">
              What is the best way to play Billiards?
            </h1>
            <p class="line-clamp-3 text-[7px] mt-1 px-1 text-white 2xl:text-sm">
              The best way to play Super Ace is to start with small bets...
            </p>
            <a
              class="block w-full text-center mx-auto text-[9px] text-white 2xl:text-sm 2xl:my-2 hover:underline hover:underline-offset-2 hover:text-green-400">
              Read More
            </a>
          </div>

          <div
            class="flex flex-col bg-slate-800 rounded-xl w-25 overflow-hidden h-35 text-xs md:w-52 md:h-40 lg:scale-120 2xl:w-1/4 2xl:h-90">
            <img src="{{ asset('images/motornews.jpg') }}" class="w-full aspect-[16/9] object-cover block" alt="" />
            <h1 class="font-semibold text-[9px] px-1 text-white 2xl:text-xl text-center">
              What is the best way to play Billiards?
            </h1>
            <p class="line-clamp-3 text-[7px] mt-1 px-1 text-white 2xl:text-sm">
              The best way to play Super Ace is to start with small bets...
            </p>
            <a
              class="block w-full text-center mx-auto text-[9px] text-white 2xl:text-sm 2xl:my-2 hover:underline hover:underline-offset-2 hover:text-green-400">
              Read More
            </a>
          </div>
        </div>

        <footer
          class="flex bg-white/80 text-slate-950 dark:bg-slate-900/80 dark:text-slate-50 mx-4 md:mx-4 xl:mx-20 my-4 p-4 gap-3 rounded-lg lg:h-70 lg:gap-5">
          <div class="flex flex-col gap-1 w-1/2 lg:gap-2">
            <h1 class="font-bold text-xs lg:text-xl">We make playing easy, try all our games and play now!</h1>
            <h1 class="text-xs lg:text-sm">For our latest news, sign up to our newsletter.</h1>
            <input type="text" class="p-1 border-b border-slate-900 dark:border-slate-200"
              placeholder="Email Address" />
            <div class="flex gap-2">
              <a href=""><i class="fa-brands fa-facebook hover:text-emerald"></i></a>
              <a href=""><i class="fa-brands fa-instagram hover:text-emerald"></i></a>
              <a href=""><i class="fa-brands fa-square-x-twitter hover:text-emerald"></i></a>
              <a href=""><i class="fa-brands fa-youtube hover:text-emerald"></i></a>
            </div>
            <h1 class="text-[10px]">BK2025. All rights reserved, 2025</h1>
          </div>
          <div class="flex flex-col w-1/3 text-[8px] gap-2 lg:gap-4 lg:mt-4 font-semibold  lg:text-[12px]">
            <a href="" class="hover:underline underline-offset-2">Get in touch</a>
            <a href="" class="hover:underline underline-offset-2">Join our team</a>
            <a href="" class="hover:underline underline-offset-2">About</a>
            <a href="" class="hover:underline underline-offset-2">FAQ</a>
            <a href="" class="hover:underline underline-offset-2">Terms of Use</a>
            <a href="" class="hover:underline underline-offset-2">Privacy</a>
          </div>
          <div class="flex flex-col w-1/3 text-[8px] gap-2 lg:gap-4 lg:mt-4 font-semibold  lg:text-[12px]">
            <a href="" class="hover:underline underline-offset-2">Billiard Club</a>
            <a href="" class="hover:underline underline-offset-2">Promotions</a>
            <a href="" class="hover:underline underline-offset-2">Playing</a>
            <a href="" class="hover:underline underline-offset-2">Terms of Service</a>
          </div>


        </footer>
        <footer class="flex justify-center items-center text-sm text-gray-300 py-4">
          <span class="flex items-center justify-center space-x-1">
            <span>&copy;</span>
            <span id="year"></span>
            <span>BK</span>
          </span>
        </footer>
      </div>
    </div>


  </div>



  <script>
    AOS.init();
    // Auto set current year
    document.getElementById("year").textContent = new Date().getFullYear();
  </script>
</body>

</html>