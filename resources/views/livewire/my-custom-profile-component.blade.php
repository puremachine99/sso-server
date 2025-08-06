<x-filament::section>
    <x-slot name="header">
        <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
            Profile Information
        </h3>
        <p class="fi-section-header-description text-sm text-gray-500 dark:text-gray-400">
            View your account profile name and email address.
        </p>
    </x-slot>

    <div class="fi-section-content-ctn rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:col-span-2">
        <div class="fi-section-content p-6">
            <div class="grid grid-cols-1 gap-6">
                <div class="fi-fo-field-wrp">
                    <div class="grid gap-y-2">
                        <div class="flex items-center gap-x-3 justify-between">
                            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Name</span>
                            </label>
                        </div>
                        <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 px-3 py-1.5">
                            <span class="text-base text-gray-950 dark:text-white">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>

                <div class="fi-fo-field-wrp">
                    <div class="grid gap-y-2">
                        <div class="flex items-center gap-x-3 justify-between">
                            <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Email</span>
                            </label>
                        </div>
                        <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 px-3 py-1.5">
                            <span class="text-base text-gray-950 dark:text-white">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament::section>
