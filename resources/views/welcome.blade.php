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
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      crossorigin="anonymous"
    />

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Alpine -->
    <script
      src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
      defer
    ></script>
  </head>

  <body
    class="overflow-x-hidden bg-[url('images/table.png')] bg-cover bg-center bg-no-repeat"
  >
    <div
      class="overflow-x-hidden bg-gradient-to-b from-emerald-950/70 via-emerald-800/70 to-emerald-700/30"
    >
      <div class="flex flex-col w-full">
        <nav
          class="relative bg-emerald-950 px-2 py-2 flex font-semibold items-center justify-between text-[10px] 2xl:text-xl 2xl:py-[2px] 2xl:px-12 shadow-lg shadow-emerald-800/50"
        >
          <!-- Logo -->
          <img src="{{ asset('images/logo2real.png') }}" class="h-8 2xl:h-20" alt="Logo" />

          <!-- Nav Links -->
          <ul
            class="flex flex-wrap space-x-5 2xl:space-x-20 text-emerald-50 relative"
            x-data="{ open: false }"
          >
            <!-- HOME -> dashboard.blade.php -->
            <li><a href="{{ route('dashboard') }}" class="hover:text-emerald-300">Home</a></li>
            <li><a href="{{ route('pre-match') }}" class="hover:text-emerald-300">Pre-Match</a></li>

            <li><a href="#" class="hover:text-emerald-300">About</a></li>
            <li><a href="#" class="hover:text-emerald-300">Event</a></li>

            <!-- Dropdown -->
            <li class="relative items-center">
              <button
                @click="open = !open"
                class="hover:text-emerald-300 inline-flex items-center text-center"
              >
                Sports
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-4 h-4 ml-1"
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

              <!-- Dropdown Menu -->
              <ul
                x-show="open"
                @click.away="open = false"
                x-transition
                class="absolute left-0 mt-2 bg-emerald-900 text-white rounded-lg shadow-lg w-44 z-50"
              >
                <li>
                  <a
                    href="billiard"
                    class="block px-4 py-2 hover:bg-emerald-700"
                    >Billiards</a
                  >
                </li>
                <li>
                  <a href="horse" class="block px-4 py-2 hover:bg-emerald-700"
                    >Horse Racing</a
                  >
                </li>
                <li>
                  <a
                    href="{{ route('drag.race') }}"
                    class="block px-4 py-2 hover:bg-emerald-700"
                    >Motor Racing</a
                  >
                </li>
              </ul>
            </li>
          </ul>

         
          @auth
            <div
              x-data="{ open: false }"
              class="flex space-x-1 relative -translate-x-8 items-center"
              @click="open = !open"
            >
              <!-- Image (clickable trigger) -->
              <div class="flex cursor-pointer">
                <img src="{{ asset('images/icon.png') }}" class="h-3 2xl:h-13" alt="" />
              </div>

              <!-- Dropdown menu -->
              <div
                x-show="open"
                @click.outside="open = false"
                x-transition
                class="absolute left-10 top-2 mt-2 2xl:top-11 w-18 2xl:w-35 text-xs bg-white border border-gray-200 rounded-lg shadow-lg z-100"
              >
                <ul class="text-gray-700 text-sm">
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100"
                      >Profile</a
                    >
                  </li>
                  <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100"
                      >Settings</a
                    >
                  </li>
                  <li>
                    <a href="/login" class="block px-4 py-2 hover:bg-gray-100"
                      >Dashboard</a
                    >
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
          <div
            class="flex text-white my-8 2xl:my-13 bg-emerald-100/10 rounded-lg mx-3 2xl:mx-15 2xl:py-4"
          >
            <div class="flex flex-col mx-4 2xl:mx-10 w-full 2xl:w-1/2">
              <h1
                class="text-[25px] font-semibold w-[150px] 2xl:text-8xl 2xl:w-full"
              >
                Bet. Break. Win Big!
              </h1>
              <p class="break-words text-[10px] 2xl:text-3xl 2xl:py-6">
                Dive into the ultimate billiards betting experience — where
                every shot counts and every match could make you a winner.
              </p>
              <div
                class="flex space-x-2 my-2 text-[10px] 2xl:text-xl 2xl:translate-y-26 font-semibold text-black"
              >
                <div
                  class="flex bg-emerald-400 px-3 py-1 2xl:py-4 2xl:px-5 items-center gap-1 2xl:gap-2 rounded-full hover:bg-emerald-500 transition-colors duration-200"
                >
                  <i class="fa-solid fa-star"></i>
                  <a href="" class="text-[8px] 2xl:text-lg">Join now</a>
                </div>
                <div
                  class="flex bg-yellow-300 px-3 py-1 2xl:py-4 2xl:px-5 items-center gap-1 2xl:gap-2 rounded-full hover:bg-yellow-400 transition-colors duration-200"
                >
                  <i class="fa-solid fa-sack-dollar"></i>
                  <a href="" class="text-[8px] 2xl:text-lg">Start Betting</a>
                </div>
              </div>
            </div>
            <img
              src="{{ asset('images/peoples.png') }}"
              class="h-40 w-40 translate-y-2 -translate-x-2 2xl:h-140 2xl:w-180 2xl:translate-y-1"
              alt=""
            />
          </div>
        </div>

        <!-- Featured Sports -->
        <div
          data-aos="fade-down"
          class="flex flex-col text-white items-center justify-center mx-8 my-6 2xl:my-[150px] 2xl:mx-44 px-4"
          data-aos-once="true"
        >
          <h1 class="text-lg font-bold xl:text-sm 2xl:text-4xl text-center">
            Featured Sports
          </h1>
          <h1 class="text-[8px] text-center 2xl:text-3xl 2xl:mt-4">
            Choose your sport and start betting on your favorite events.
          </h1>
        </div>

        <div data-aos="fade-up">
          <!-- Cards Container -->
          <div
            class="flex justify-center items-center gap-4 scale-90 2xl:scale-100"
          >
            <!-- Card 1 -->
            <div
              class="relative rounded-xl bg-emerald-100 w-1/3 h-50 bg-cover bg-center 2xl:h-120 2xl:w-100 hover:scale-105 transform transition duration-300 hover:shadow-[0_0_20px_3px_rgba(16,185,129,0.8)]"
              style="background-image: url('{{ asset('images/BilliardVisual.png') }}')"
            >
              <div
                class="absolute inset-0 bg-black/40 hover:bg-black/70 duration-300 transition-colors rounded-xl"
              >
                <div class="relative text-white mt-24 p-2 2xl:mt-75">
                  <h1 class="font-semibold 2xl:text-5xl">Billiards</h1>
                  <p class="text-[8px] 2xl:text-lg 2xl:pl-2 py-2">
                    Aim for precision and predict the winners in every cue
                    match.
                  </p>
                </div>
                <a
                  href=""
                  class="absolute bg-yellow-300 text-[8px] 2xl:text-lg rounded-full p-1 font-semibold -translate-y-4 translate-x-18 2xl:translate-x-65 2xl:px-4 hover:bg-yellow-400"
                >
                  Bet Now
                </a>
              </div>
            </div>

            <!-- Card 2 -->
            <div
              class="relative rounded-xl bg-emerald-100 w-1/3 h-50 bg-cover bg-center 2xl:h-120 2xl:w-100 hover:scale-105 transform transition duration-300 hover:shadow-[0_0_20px_3px_rgba(16,185,129,0.8)]"
              style="background-image: url('{{ asset('images/MotorVisual.png') }}')"
            >
              <div
                class="absolute inset-0 bg-black/40 hover:bg-black/70 duration-300 transition-colors rounded-xl"
              >
                <div class="relative text-white mt-24 p-2 2xl:mt-75">
                  <h1 class="font-semibold 2xl:text-5xl">Motor Racing</h1>
                  <p class="text-[8px] 2xl:text-lg 2xl:pl-2 py-2">
                    Bet on the fastest machines and top drivers from leagues
                    around the world.
                  </p>
                </div>
                <a
                  href=""
                  class="absolute bg-yellow-300 text-[8px] 2xl:text-lg rounded-full p-1 font-semibold -translate-y-4 translate-x-18 2xl:translate-x-65 2xl:px-4 hover:bg-yellow-400"
                >
                  Bet Now
                </a>
              </div>
            </div>

            <!-- Card 3 -->
            <div
              class="relative rounded-xl bg-emerald-100 w-1/3 h-50 bg-cover bg-center 2xl:h-120 2xl:w-100 hover:scale-105 transform transition duration-300 hover:shadow-[0_0_20px_3px_rgba(16,185,129,0.8)]"
              style="background-image: url('{{ asset('images/HorseVisual.png') }}')"
            >
              <div
                class="absolute inset-0 bg-black/40 hover:bg-black/70 duration-300 transition-colors rounded-xl"
              >
                <div class="relative text-white mt-24 p-2 2xl:mt-75">
                  <h1 class="font-semibold 2xl:text-5xl">Horse Racing</h1>
                  <p class="text-[8px] 2xl:text-lg 2xl:pl-2 py-2">
                    Experience the thrill of the tracks with live odds and
                    instant results.
                  </p>
                </div>
                <a
                  href=""
                  class="absolute bg-yellow-300 text-[8px] 2xl:text-lg rounded-full p-1 font-semibold -translate-y-4 translate-x-18 2xl:translate-x-65 2xl:px-4 hover:bg-yellow-400"
                >
                  Bet Now
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Banner -->
        <div class="flex justify-center my-10">
          <div class="relative text-center">
            <img
              src="{{ asset('images/addbanner.png') }}"
              alt=""
              class="w-[320px] h-20 rounded-lg 2xl:w-[800px] 2xl:h-40 object-cover"
            />
            <div class="absolute inset-0 bg-black/40 rounded-lg"></div>

            <a
              href=""
              class="absolute top-3 left-3 text-gray-50 font-semibold py-1 px-2 rounded-full text-[14px] 2xl:text-3xl drop-shadow-lg"
            >
              Billiard League is back!
            </a>

            <a
              href=""
              class="absolute top-8 left-3 text-gray-50 font-semibold py-1 px-2 rounded-full text-[9px] 2xl:text-lg 2xl:translate-y-6 2xl:translate-x-1 drop-shadow-lg"
            >
              10% Cashback up to 1000!
            </a>

            <a
              href=""
              class="absolute top-14 left-3 bg-yellow-300 font-bold py-1 px-2 rounded-full text-[9px] 2xl:text-sm 2xl:translate-y-14 2xl:translate-x-4 shadow-md hover:bg-yellow-400 transition"
            >
              Deposit now
            </a>
          </div>
        </div>

        <!-- Discover / How it works -->
        <div
          data-aos="fade-down"
          class="flex flex-col text-white items-center justify-center mx-8 mt-10 2xl:mt-[100px] 2xl:mx-44 px-4"
          data-aos-once="true"
        >
          <h1 class="text-lg font-bold xl:text-sm 2xl:text-4xl text-center">
            Discover the Lottery Experience
          </h1>
          <h1 class="text-[8px] text-center 2xl:text-3xl 2xl:mt-4">
            From playing your numbers to exploring jackpots and playing
            responsibly, here's everything you need to know.Learn how it works,
            see today's biggest prizes, and enjoy the excitement responsibly.
          </h1>
        </div>

        <div
          class="mt-5 2xl:-mt-[300px] 2xl:scale-[0.7] w-full overflow-x-hidden text-white"
        >
          <div
            data-aos="fade-right"
            class="flex justify-between gap-4 px-8 my-8 2xl:my-80 2xl:mx-20 2xl:px-2"
          >
            <div class="p-2 h-[100px] w-1/2 rounded-2xl 2xl:h-[500px]">
              <h1 class="text-xs font-bold 2xl:text-6xl 2xl:mt-5 2xl:mb-4">
                How It Works
              </h1>
              <p class="text-[8px] 2xl:text-3xl">
                Playing the lottery has never been simpler. Pick your favorite
                numbers, purchase your ticket online, and tune in for the draw.
                Winners are automatically notified, making your experience
                smooth and exciting.
              </p>
            </div>

            <div
              class="p-2 h-[100px] w-1/2 rounded-2xl 2xl:h-[450px] overflow-hidden"
            >
              <img
                src="{{ asset('images/week.png') }}"
                alt=""
                class="object-cover w-full h-full rounded-2xl shadow-xl"
              />
            </div>
          </div>

          <div
            data-aos="fade-right"
            class="flex justify-between gap-4 px-8 my-8 2xl:my-80 2xl:mx-20 2xl:px-2"
          >
            <div
              class="p-2 h-[100px] w-1/2 rounded-2xl 2xl:h-[450px] overflow-hidden"
            >
              <img
                src="{{ asset('images/motor.png') }}"
                alt=""
                class="object-cover w-full h-full rounded-2xl shadow-xl"
              />
            </div>

            <div class="p-2 h-[100px] w-1/2 rounded-2xl 2xl:h-[500px]">
              <h1 class="text-xs font-bold 2xl:text-6xl 2xl:mt-5 2xl:mb-4">
                Current Jackpots
              </h1>
              <p class="text-[8px] 2xl:text-3xl">
                Explore the latest jackpots and see which games are offering the
                biggest prizes today. From local draws to international
                lotteries, there's a chance for everyone to win big
              </p>
            </div>
          </div>

          <div
            data-aos="fade-right"
            class="flex justify-between gap-4 px-8 my-8 2xl:mt-40 2xl:mx-20 2xl:px-2"
          >
            <div class="p-2 h-[100px] w-1/2 rounded-2xl 2xl:h-[500px]">
              <h1 class="text-xs font-bold 2xl:text-6xl 2xl:mt-5 2xl:mb-4">
                Responsible Gaming
              </h1>
              <p class="text-[8px] 2xl:text-3xl">
                Your fun is important, but safety comes first. Set limits, play
                responsibly, and enjoy the excitement of the lottery without
                overextending yourself.
              </p>
            </div>

            <div
              class="p-2 h-[100px] w-1/2 rounded-2xl 2xl:h-[450px] overflow-hidden"
            >
              <img
                src="{{ asset('images/payout2.png') }}"
                alt=""
                class="object-cover w-full h-full rounded-2xl shadow-xl"
              />
            </div>
          </div>
        </div>

        <!-- News -->
        <h1 class="font-semibold text-emerald-100 my-2 ml-4 2xl:text-3xl 2xl:ml-55 2xl:mb-6" data-aos="fade-up" data-aos-once="true">Sports News</h1>
        <div class="mx-auto" data-aos="fade-down" data-aos-once="true">
          <div class="flex space-x-3 2xl:justify-center">
            <div
              class="flex-col bg-emerald-100 rounded-xl w-25 overflow-hidden h-35 text-xs 2xl:w-1/4 2xl:h-90"
            >
              <img src="{{ asset('images/news1.jpg') }}" class="w-full aspect-[16/9] object-cover block" alt="" />
              <h1 class="font-semibold text-[9px] px-1 text-emerald-950 2xl:text-xl">
                What is the best way to play Billiards?
              </h1>
              <p class="line-clamp-3 text-[7px] mt-1 px-1 text-emerald-900 2xl:text-sm">
                The best way to play Super Ace is to start with small bets...
              </p>
              <p class="text-center text-[9px] text-emerald-700 2xl:text-sm 2xl:my-2">Read More</p>
            </div>

            <div
              class="flex-col bg-emerald-100 rounded-xl w-25 overflow-hidden h-35 text-xs 2xl:w-1/4 2xl:h-90 2xl:h-90"
            >
              <img src="{{ asset('images/horsenews.jpg') }}" class="w-full aspect-[16/9] object-cover block" alt="" />
              <h1 class="font-semibold text-[9px] px-1 text-emerald-950 2xl:text-xl">
                What is the best way to play Billiards?
              </h1>
              <p class="line-clamp-3 text-[7px] mt-1 px-1 text-emerald-900 2xl:text-sm">
                The best way to play Super Ace is to start with small bets...
              </p>
              <p class="text-center text-[9px] text-emerald-700 2xl:text-sm 2xl:my-2">Read More</p>
            </div>

            <div
              class="flex-col bg-emerald-100 rounded-xl w-25 overflow-hidden h-35 text-xs 2xl:w-1/4 2xl:h-90"
            >
              <img src="{{ asset('images/motornews.jpg') }}" class="w-full aspect-[16/9] object-cover block" alt="" />
              <h1 class="font-semibold text-[9px] px-1 text-emerald-950 2xl:text-xl">
                What is the best way to play Billiards?
              </h1>
              <p class="line-clamp-3 text-[7px] mt-1 px-1 text-emerald-900 2xl:text-sm">
                The best way to play Super Ace is to start with small bets...
              </p>
              <p class="text-center text-[9px] text-emerald-700 2xl:text-sm 2xl:my-2">Read More</p>
            </div>
          </div>
        </div>
      </div>

      <!--Footer-->
      <div class="flex-col">
        <div
          class="flex bg-emerald-950/60 space-x-4 mx-4 2xl:mx-24 rounded-xl p-3 text-white border border-emerald-500 my-8"
        >
          <div class="flex-col space-y-2 p-4">
            <h1 class="font-bold text-lg text-emerald-100 2xl:text-4xl">
              Let's Talk
            </h1>
            <p class="text-[8px] 2xl:text-xl 2xl:w-1/2">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer
              nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi.
              Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum.
              Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris
              massa.
            </p>
            <p
              class="bg-yellow-300 font-semibold text-black text-sm rounded-full px-2 w-12 text-center 2xl:text-xl 2xl:px-7 2xl:w-fit"
            >
              FAQs
            </p>
          </div>
          <div
            class="flex-col space-y-2 text-[10px] mt-7 2xl:text-x 2xl:mr-40 2xl:text-lg p-4"
          >
            <div class="flex space-x-2">
              <h1 class="font-bold text-emerald-500">Email:</h1>
              <h1>Hello@gmail.com</h1>
            </div>
            <div class="flex space-x-2">
              <h1 class="font-bold text-emerald-500">Phone:</h1>
              <h1>09123456789</h1>
            </div>
            <div class="flex space-x-2">
              <h1 class="font-bold text-emerald-500">Address:</h1>
              <div class="flex-col space-y-1">
                <h1>Visayas Ave.</h1>
                <h1>Espana, 1882</h1>
                <h1>Quezon City</h1>
              </div>
            </div>
          </div>
        </div>
        <footer
          class="flex justify-center items-center text-sm text-gray-300 py-4"
        >
          <span class="flex items-center justify-center space-x-1">
            <span>&copy;</span>
            <span id="year"></span>
            <span>GJL/JBL | BilarPH</span>
          </span>
        </footer>
      </div>
    </div>
h
    <script>
      AOS.init();
      // Auto set current year
      document.getElementById("year").textContent = new Date().getFullYear();
    </script>
  </body>
</html>
