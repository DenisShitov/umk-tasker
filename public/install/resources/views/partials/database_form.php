    <div class="bg-white shadow overflow-hidden sm:rounded-md px-6">
        <div class="rounded-md bg-red-50 p-4 my-4" x-show="$store.install.database_errors.length" x-cloak>
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
                            <template x-for="(error, index) in $store.install.database_errors" :key="index">
                                <li x-text="error"></li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:py-5">
            <label for="host" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                Host
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" id="host" x-model="$store.install.form.host" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" placeholder="Database Host">
            </div>
        </div>

        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
            <label for="port" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                Port
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" id="port" x-model="$store.install.form.port" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" placeholder="Database Port">
            </div>
        </div>

        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
            <label for="database" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                Database
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" id="database" x-model="$store.install.form.database" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" placeholder="Database Name">
            </div>
        </div>

        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
            <label for="username" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                Username
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" id="username" x-model="$store.install.form.username" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" placeholder="Database Username">
            </div>
        </div>

        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
            <label for="password" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                Password
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" id="password" x-model="$store.install.form.password" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md" placeholder="Database Password">
            </div>
        </div>
    </div>
