<!-- Contact Section -->
<section id="contact" class="py-12 md:py-18 bg-gray-50 dark:bg-gray-800/50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-fade-in-up">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Get In Touch</h2>
            <div class="w-20 h-1.5 bg-blue-600 dark:bg-blue-400 mx-auto rounded-full"></div>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-6 max-w-2xl mx-auto">
                Interested in working together? Feel free to reach out using the form below.
            </p>
        </div>

        <div class="max-w-3xl mx-auto">
            <form class="animate-fade-in-up animate-delay-100">
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                    <div>
                        <label for="first-name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">First name</label>
                        <div class="mt-1">
                            <input type="text" name="first-name" id="first-name" autocomplete="given-name"
                                class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>
                    <div>
                        <label for="last-name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last name</label>
                        <div class="mt-1">
                            <input type="text" name="last-name" id="last-name" autocomplete="family-name"
                                class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email"
                                class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="subject"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                        <div class="mt-1">
                            <input type="text" name="subject" id="subject"
                                class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="message"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                        <div class="mt-1">
                            <textarea id="message" name="message" rows="4"
                                class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Send Message
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>