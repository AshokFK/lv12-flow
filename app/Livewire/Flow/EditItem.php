<?php

namespace App\Livewire\Flow;

use Flux\Flux;
use App\Models\Mesin;
use Livewire\Component;
use App\Models\FlowItem;
use App\Models\Operator;
use App\Models\FlowHeader;
use Livewire\Attributes\On;
use App\Helpers\OperatorHelper;
use Livewire\Attributes\Validate;

class EditItem extends Component
{
    public $flowItemId;
    public FlowHeader $header;

    #[Validate('required', message: 'Pilih item terlebih dahulu')]
    #[Validate('in:proses,komponen,qc', message: 'Item type tidak valid')]
    public $itemable_type = 'komponen';

    #[Validate('required', message: 'Item harus dipilih')]
    public $itemable_id;
    #[Validate('array', message: 'Proses selanjutnya harus berupa array')]
    #[Validate('nullable')]
    public $next_to;

    #[Validate('required', message: 'Proses type harus dipilih')]
    #[Validate('exclude_if:itemable_type,qc', message: 'Proses type harus dipilih')]
    #[Validate('in:standar,custom', message: 'Proses type tidak valid')]
    public $proses_type;

    #[Validate('exclude_if:itemable_type,komponen', message: 'Operator harus dipilih')]
    public $operator;

    #[Validate('exclude_unless:itemable_type,proses', message: 'Mesin harus dipilih')]
    public $mesin = [];

    #[On('edit-item')]
    public function edit($id)
    {
        $item = FlowItem::findOrFail($id);
        $this->flowItemId = $item->id;
        $this->itemable_type = $item->itemable_type;
        $this->proses_type = $item->proses_type;
        $this->mesin = $item->mesin;

        $this->operator = $item->operator ?? [];

        $next = FlowItem::where('id', $item->next_to)->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'itemable_type' => $item->itemable_type,
                    'nama' => $item->itemable->nama,
                    'komponen_type' => $item->itemable->type,
                    'mastercode' => $item->itemable->mastercode,
                ];
            });

        if ($item->itemable_type === 'proses') {
            $operatorData = Operator::whereIn('nik', $this->operator)->active()->get();
            $mesinData = Mesin::whereIn('id', $item->mesin)->get();
        }

        Flux::modal('edit-item')->show();
        $this->dispatch(
            'item-selected',
            item_selected: $item->itemable,
            next_to_selected: $next,
            next_to_id: $item->next_to,
            operator_selected: $this->operator,
            operator_data: $operatorData ?? [],
            mesin_selected: $this->mesin,
            mesin_data: $mesinData ?? [],
        );
    }

    public function fetchOperator($query = '')
    {
        return OperatorHelper::search($query);
    }

    public function fetchMesin($query = '')
    {
        return Mesin::search(['nama', 'kode', 'deskripsi'], $query)->get(['id', 'nama', 'kode', 'deskripsi']);
    }

    public function fetchNextItems($query = '')
    {
        // Ambil semua item yang ada di header ini
        // filter berdasarkan nama itemable
        return FlowItem::with('itemable')
            ->where('header_id', $this->header->id)
            ->when($query, function ($q) use ($query) {
                $q->whereHasMorph('itemable', '*', function ($q) use ($query) {
                    $q->where('nama', 'like', '%' . $query . '%');
                });
            })
            ->get();
        
    }

    public function simpanOperator($nik, $nama)
    {
        try {
            OperatorHelper::saveFromApi($nik, $nama);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function save()
    {
        $validated = $this->validate();
        $flowItem = FlowItem::findOrFail($this->flowItemId);
        
        try {
            $flowItem->update($validated);
            // reset properti, kecuali header
            $this->reset(['flowItemId', 'itemable_type', 'itemable_id', 'next_to', 'proses_type', 'operator', 'mesin']);
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Item berhasil diperbarui.');
            $this->dispatch('refresh-list-item');
        } catch (\Throwable $th) {
            // throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Item gagal diperbarui.');
        }
        Flux::modal('edit-item')->close();
    }

    public function render()
    {
        return view('livewire.flow.edit-item');
    }
}
