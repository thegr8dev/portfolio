<div>
    <form wire:submit="submitForm" class="animate-fade-in-up animate-delay-100">
        @if ($success)
            <div class="mb-6 p-4 rounded-md bg-green-50 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                <p>Thank you for your message! We'll get back to you soon.</p>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">First
                    name <span class="text-red-500">*</span> </label>
                <div class="mt-1">
                    <input wire:model="first_name" type="text" id="first_name" autocomplete="given-name"
                        class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    @error('first_name')
                        <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last
                    name <span class="text-red-500">*</span></label>
                <div class="mt-1">
                    <input wire:model="last_name" type="text" id="last_name" autocomplete="family-name"
                        class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    @error('last_name')
                        <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email <span class="text-red-500">*</span></label>
                <div class="mt-1">
                    <input wire:model="email" id="email" type="email" autocomplete="email"
                        class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    @error('email')
                        <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject <span class="text-red-500">*</span></label>
                <div class="mt-1">
                    <input wire:model="subject" type="text" id="subject"
                        class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    @error('subject')
                        <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message <span class="text-red-500">*</span></label>
                <div class="mt-1">
                    <textarea wire:model="message" id="message" rows="4"
                        class="py-3 px-4 block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                    @error('message')
                        <span class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="sm:col-span-2">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Send Message</span>
                    <span wire:loading>
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
