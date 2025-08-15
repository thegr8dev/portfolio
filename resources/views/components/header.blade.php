<!-- Navbar -->
<header
    class="fixed w-full z-50 backdrop-blur-sm bg-white/80 dark:bg-gray-900/80 border-b border-gray-200 dark:border-gray-800 transition-colors duration-300">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="#top" class="flex items-center">
                    <span
                        class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">&lt;AK/&gt;</span>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:ml-10 md:flex md:space-x-8">
                    <a href="#projects"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 text-base font-medium transition duration-150">Portfolio</a>
                    <a href="#about"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 text-base font-medium transition duration-150">About
                        Me</a>
                    <a href="#projects"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 text-base font-medium transition duration-150">Projects</a>
                    <a href="#contact"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 text-base font-medium transition duration-150">Contact</a>
                </nav>
            </div>

            <!-- Theme Toggle & Mobile Menu -->
            <div class="flex items-center space-x-2">
                <!-- Theme Toggle Button -->
                <button id="theme-toggle"
                    class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors duration-200"
                    aria-label="Toggle theme">
                    <!-- Sun Icon (Light Mode) -->
                    <svg id="sun-icon" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>

                    <!-- Moon Icon (Dark Mode) -->
                    <svg id="moon-icon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
                <!-- Mobile menu button -->
                <button id="mobile-menu-button"
                    class="md:hidden p-2 rounded-md text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors duration-200"
                    aria-expanded="false" aria-label="Toggle mobile menu">
                    <!-- Hamburger Icon (when menu is closed) -->
                    <svg id="hamburger-icon" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <!-- X Icon (when menu is open) -->
                    <svg id="close-icon" class="h-6 w-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Mobile menu dropdown -->
                <div id="mobile-menu"
                    class="absolute top-full left-0 right-0 md:hidden bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 z-50 shadow-lg overflow-hidden transition-all duration-300 ease-out max-h-0 opacity-0 pointer-events-none">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="/"
                            class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 block px-3 py-2 rounded-md text-lg font-medium transition duration-150">Home</a>
                        <a href="#projects"
                            class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 block px-3 py-2 rounded-md text-lg font-medium transition duration-150">Portfolio</a>
                        <a href="#about"
                            class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 block px-3 py-2 rounded-md text-lg font-medium transition duration-150">About
                            Me</a>
                        <a href="#projects"
                            class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 block px-3 py-2 rounded-md text-lg font-medium transition duration-150">Projects</a>
                        <a href="#contact"
                            class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 block px-3 py-2 rounded-md text-lg font-medium transition duration-150">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>