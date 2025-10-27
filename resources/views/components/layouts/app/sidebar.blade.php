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

        {{ $slot }}

        @fluxScripts
    </body>
</html>
