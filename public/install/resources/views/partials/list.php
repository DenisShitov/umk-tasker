    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul>
            <?php foreach ($items as $item) : ?>
                <li class="border-t first:border-t-0 border-gray-200">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="text-sm leading-5 font-medium text-indigo-600 truncate">
                                <?php echo $item['name']; ?>
                                <span class="ml-2 font-normal text-gray-500"><?php echo $item['required']; ?></span>
                            </div>

                            <div class="ml-2 flex-shrink-0 flex items-center">
                                <span class="mr-2 text-sm leading-5 font-normal text-gray-500"><?php echo $item['current']; ?></span>

                                <?php if ($item['status']) : ?>
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" x-description="Heroicon name: check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                <?php else : ?>
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-red-400" x-description="Heroicon name: x-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
