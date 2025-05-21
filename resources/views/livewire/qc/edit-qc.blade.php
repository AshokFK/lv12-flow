<div>
    <flux:modal name="edit-qc" variant="flyout">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Update QC</flux:heading>
                <flux:text class="mt-2">Isikan data yang diperlukan untuk update proses QC.</flux:text>
            </div>

            <flux:input wire:model="nama" label="Nama" placeholder="Nama proses QC" />
            <flux:switch label="Aktif" align="left" wire:model="is_active" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
