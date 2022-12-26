    <div class="bg-white shadow overflow-hidden rounded-md">
        <div class="rounded-md bg-red-50 p-4 m-4" x-show="$store.install.installation_errors.length" x-cloak>
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: x-circle -->
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Oops!</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <template x-for="(error, index) in $store.install.installation_errors" :key="index">
                                <li x-text="error"></li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <template x-for="(item, index) in $store.install.installation_process">
            <div class="flex items-center py-4 px-6 border-b">
                <span class="text-gray-700 text-sm font-medium" x-text="item"></span>

                <span class="ml-auto">
                    <p class="text-gray-600 text-sm text-center w-5" x-show="$store.install.installation_step < index">—</p>

                    <svg class="animate-spin stroke-current text-gray-600 h-5 w-5" viewBox="0 0 32 32" x-show="$store.install.processing && $store.install.installation_step == index">
                        <circle cx="16" cy="16" fill="none" r="14" stroke-width="4" style="opacity: 0.2;"></circle>
                        <circle cx="16" cy="16" fill="none" r="14" stroke-width="4" style="stroke-dasharray: 80; stroke-dashoffset: 60;"></circle>
                    </svg>

                    <svg class="h-5 w-5 text-green-500" x-description="Heroicon name: check-circle" viewBox="0 0 20 20" fill="currentColor" x-show="$store.install.installation_step > index">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>

                    <svg class="h-5 w-5 text-red-400" x-description="Heroicon name: x-circle" viewBox="0 0 20 20" fill="currentColor" x-show="$store.install.installation_failed && $store.install.installation_step == index">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>
        </template>
    </div>
