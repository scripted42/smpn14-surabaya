<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
            <x-filament::button
                type="button"
                color="success"
                icon="heroicon-o-paper-airplane"
                wire:click="runTestWa"
                size="lg"
            >
                Tes Kirim WhatsApp
            </x-filament::button>

            <x-filament::button type="submit" size="lg">
                Simpan Pengaturan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
