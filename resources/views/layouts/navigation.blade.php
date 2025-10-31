<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-900 dark:text-white">
                    Nap ak Karangué
                </a>
            </div>
            <div class="flex items-center">
                <!-- Si tu veux un lien de login / logout, tu peux le mettre ici -->
                <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white px-3">Dashboard</a>
                <!-- Tu peux mettre des liens vers d'autres parties -->
            </div>
        </div>
    </div>
</nav>
