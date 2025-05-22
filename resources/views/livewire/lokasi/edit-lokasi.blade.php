<div>
    <flux:modal name="edit-lokasi" variant="flyout">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Update lokasi</flux:heading>
                <flux:text class="mt-2">Isikan data yang diperlukan untuk update lokasi.</flux:text>
            </div>

            <flux:input wire:model="nama" label="Nama" placeholder="Nama lokasi" minlength="3" maxlength="3" />

            <flux:field>
                <flux:label>Sub lokasi</flux:label>
                <flux:select wire:model="sub" placeholder="Pilih Sub lokasi...">
                <flux:select.option value=""></flux:select.option>
                    @foreach($this->listSubLokasi() as $key => $value)
                    <flux:select.option value="{{ $value->nama }}">
                        {{ $value->deskripsi }}
                    </flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="sub" />
            </flux:field>
            <flux:textarea wire:model="deskripsi" label="Deskripsi" placeholder="Deskripsi lokasi" rows="2" />
            <flux:switch label="Aktif" align="left" wire:model="is_active" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
