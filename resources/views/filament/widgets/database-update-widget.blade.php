<x-filament-widgets::widget>
    <x-filament::section>
        <form wire:submit.prevent="updateDatabase">
            <button type="submit"
                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                wire:loading.attr="disabled">
                <span wire:loading.remove>Adatbázis frissítése</span>
                <span wire:loading>Frissítés folyamatban...</span>
            </button>
            <div wire:loading class="flex justify-center mt-2">
                <svg class="w-5 h-5 text-indigo-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </div>
        </form>

    </x-filament::section>
</x-filament-widgets::widget>
