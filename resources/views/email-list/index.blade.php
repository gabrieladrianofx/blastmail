<x-layouts.app>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Email List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                   @forelse($emailLists as $list)
                    @empty
                        <div class="flex justify-center">
                            <x-link-button :href="route('email-list.create')">
                                {{__('Create your first email list')}}
                            </x-link-button>
                        </div>
                   @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
