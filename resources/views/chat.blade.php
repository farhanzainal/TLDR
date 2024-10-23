<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-head />
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
     @livewire('pdfread.chat')
    </body>
</html>
