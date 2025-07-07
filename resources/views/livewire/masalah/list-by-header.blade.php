<div>
    <flux:modal name="list-by-header" variant="flyout" class="max-w-[25rem]">
        <div>
            <flux:heading size="lg">List masalah</flux:heading>
            <flux:text class="mt-2">Masalah yang ada pada proses sesuai header terpilih.</flux:text>
        </div>
        <div class="space-y-1">
            @foreach($listMasalah as $key => $masalah)
            <div class="p-1 border rounded-md">
                <div class="border-b">
                    <span title="mastercode proses" class='font-bold text-xs text-gray-500'>{{ $masalah['mastercode'] }}</span>
                    <span title="nama proses yang bermasalah" class='font-bold text-sm'>{{ $masalah['proses'] }}</span>
                </div>
                <div>
                    <flux:badge size="sm" @class([ 'text-violet-700! dark:text-violet-200! bg-violet-400/20! dark:bg-violet-400/40!'=> $masalah['type'] === 'mesin',
                        'text-blue-800! dark:text-blue-200! bg-blue-400/20! dark:bg-blue-400/40!' => $masalah['type'] === 'material',
                        'text-sky-800! dark:text-sky-200! bg-sky-400/20! dark:bg-sky-400/40!' => $masalah['type'] === 'orang'
                        ])
                        title="penyebab masalah"
                        >{{ $masalah['type'] }}</flux:badge>
                    <span class='text-normal'>{{ $masalah['deskripsi'] }}</span>
                </div>
                <div class="my-1">
                    @if($masalah['done_at'])
                    <flux:badge icon="shield-check" size="sm" color="green" title="masalah sudah ditandai selesai {{ Illuminate\Support\Carbon::parse($masalah['done_at'])->diffForHumans() }}">{{ $masalah['done_at'] }}</flux:badge>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </flux:modal>
</div>
