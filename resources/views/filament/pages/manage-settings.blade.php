<x-filament-panels::page>
    <div
        x-data="{ isWaTabActive: false }"
        x-init="
            const checkWaTab = () => {
                const targetInput = document.querySelector('[id*=\'fonnte_target_phones\']') || document.querySelector('[wire\\:model*=\'fonnte_target_phones\']');
                isWaTabActive = Boolean(targetInput && targetInput.offsetParent !== null);
            };

            setTimeout(checkWaTab, 60);

            document.addEventListener('click', () => setTimeout(checkWaTab, 50));

            const observer = new MutationObserver(checkWaTab);
            observer.observe($el, { childList: true, subtree: true, attributes: true, attributeFilter: ['style', 'class'] });
        "
    >
        <form wire:submit="save">
            {{ $this->form }}

            <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                <div x-show="isWaTabActive" style="display: none;" wire:ignore.self>
                    <x-filament::button
                        type="button"
                        color="success"
                        icon="heroicon-o-paper-airplane"
                        wire:click="runTestWa"
                        size="lg"
                    >
                        Tes Kirim WhatsApp
                    </x-filament::button>
                </div>

                <x-filament::button type="submit" size="lg">
                    Simpan Pengaturan
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
