        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Note</h3>

        <?php includeFile('partials/note.php') ?>

        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 mt-8">Server Requirements</h3>

        <?php includeFile('partials/list.php', ['items' => $requirements]) ?>

        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 mt-8">Directory Permissions</h3>

        <?php includeFile('partials/list.php', ['items' => $permissions]); if (!$status) : ?>

        <a href="/" class="mt-4 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Recheck Requirements
        </a>

        <?php else : ?>

        <div x-data>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 mt-8">Purchase Verification</h3>

            <?php includeFile('partials/verification_form.php') ?>

            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 mt-8">Database Config</h3>

            <?php includeFile('partials/database_form.php') ?>

            <div x-show="$store.install.installation_started">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2 mt-8">
                    Installation Progress
                </h3>
                <p class="block text-sm mb-4 text-gray-600">it will take some time to install, so please don't close the browser.</p>

                <?php includeFile('partials/installation_process.php') ?>
            </div>

            <!-- <h3 class="text-lg leading-6 font-medium text-red-500 mb-4 mt-8" x-show="$store.install.output" x-cloak>Installation Failed!</h3> -->

            <!-- <div class="bg-white overflow-hidden sm:rounded-lg sm:shadow p-6" x-show="$store.install.output" x-cloak>
                <pre class="bg-gray-100 rounded-md p-4 text-sm" x-text="$store.install.output"></pre>
            </div> -->

            <div class="flex items-center mt-4">
                <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 focus:outline-none disabled:opacity-75"
                    :class="{ 'hover:bg-indigo-700': !$store.install.processing }"
                    :disabled="$store.install.processing"
                    @click="$store.install.install()"
                >
                    <span x-show="$store.install.installation_failed">Retry</span>
                    <span x-show="!$store.install.installation_failed">Install</span>
                    <span class="ml-2.5" x-show="$store.install.processing">
                        <svg class="animate-spin stroke-current text-white" viewBox="0 0 32 32" width="16" height="16">
                            <circle cx="16" cy="16" fill="none" r="14" stroke-width="4" style="opacity: 0.2;"></circle>
                            <circle cx="16" cy="16" fill="none" r="14" stroke-width="4" style="stroke-dasharray: 80; stroke-dashoffset: 60;"></circle>
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        <?php endif; ?>
