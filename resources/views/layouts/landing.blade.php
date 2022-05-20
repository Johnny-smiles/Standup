<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Standup</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<main
    class="py-4">
    <x-cards.card spacing="relative flex items-top min-h-screen sm:items-center py-4 sm:pt-0">
        @yield('content')
    </x-cards.card>
</main>
</body>
</html>
