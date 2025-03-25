<head>
    @stack('styles')
    @livewireStyles
    <title>Invoice Dashboard</title>
</head>
<body>
    <flux:main>
        {{ $slot }}
    </flux:main>
    @livewireScripts
</body>
