    <div class="bg-white shadow overflow-hidden sm:rounded-md px-6">
        <div class="rounded-md bg-red-50 p-4 my-4" x-show="$store.install.verification_errors.length" x-cloak>
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: x-circle -->
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Oops!</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <template x-for="(error, index) in $store.install.verification_errors" :key="index">
                                <li x-text="error"></li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:py-5">
            <label for="purchase_code" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                Purchase Code
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" id="purchase_code" x-model="$store.install.form.purchase_code" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" placeholder="Purchase Code">
                <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" class="block mt-2 text-xs text-gray-500 hover:underline">Where Is My Purchase Code?</a>
            </div>
        </div>
    </div>
