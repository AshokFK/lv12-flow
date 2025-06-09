<?php

namespace App\Livewire\Flow;

use App\Helpers\OperatorHelper;
use Flux\Flux;
use App\Models\Mesin;
use Livewire\Component;
use App\Models\FlowItem;
use App\Models\Operator;
use App\Models\FlowHeader;
use Livewire\Attributes\Validate;

class CreateItem extends Component
{
    #[Validate('required', message: 'Pilih item terlebih dahulu')]
    #[Validate('in:proses,komponen,qc', message: 'Item type tidak valid')]
    public $itemable_type = 'komponen';

    #[Validate('required', message: 'Item harus dipilih')]
    public $itemable_id;
    #[Validate('array', message: 'Proses selanjutnya harus berupa array')]
    #[Validate('nullable')]
    public $next_to;

    #[Validate('requiredIf:itemable_type,proses', message: 'Proses type harus dipilih')]
    #[Validate('exclude_unless:itemable_type,proses', message: 'Proses type harus dipilih')]
    #[Validate('in:standar,custom', message: 'Proses type tidak valid')]
    public $proses_type = 'standar';

    #[Validate('exclude_if:itemable_type,komponen', message: 'Operator harus dipilih')]
    public $operator = [];

    #[Validate('exclude_unless:itemable_type,proses', message: 'Mesin harus dipilih')]
    public $mesin = [];

    public FlowHeader $header;

    public function updatedItemableType($value)
    {
        $this->itemable_id = null; // Reset itemable_id when itemable_type changes
        $this->dispatch('item-type-selected', type: $value);
    }

    public function fetchItems($query = '')
    {
        $columns = match ($this->itemable_type) {
            'proses' => ['mastercode', 'nama'],
            'komponen' => ['nama', 'type'],
            'qc' => ['nama'],
        };

        $model = app('App\Models\\' . ucfirst($this->itemable_type));
        $data = match ($this->itemable_type) {
            // Fetch proses items yg sesuai dengan lokasi header
            'proses' => $model->where('lokasi_id', $this->header->lokasi_id)
                ->search($columns, $query)
                ->get(['id', 'mastercode', 'nama']),
            'komponen' => $model->search($columns, $query)->get(['id', 'nama', 'type']),
            'qc' => $model->search($columns, $query)->get(['id', 'nama']),
        };

        return $data;
    }

    public function fetchOperator($query = '')
    {
        return OperatorHelper::search($query);
    }

    public function fetchNextItems($query = '')
    {
        return FlowItem::with('itemable')
            ->where('header_id', $this->header->id)
            ->when($query, function ($q) use ($query) {
                $q->whereHasMorph('itemable', '*', function ($q) use ($query) {
                    $q->where('nama', 'like', '%' . $query . '%');
                });
            })
            ->get();
    }
    
    public function fetchMesin($query = '')
    {
        return Mesin::search(['nama', 'kode', 'deskripsi'], $query)->get(['id', 'nama', 'kode', 'deskripsi']);
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

        $validated = array_merge($validated, [
            'header_id' => $this->header->id,
        ]);
        
        try {
            FlowItem::create($validated);
            Flux::modal('create-item')->close();
            session()->flash('success', 'Item berhasil ditambahkan.');
            // Redirect to the list item page after successful creation
            $this->redirect(route('list.item', $this->header), navigate: true);
            $this->reset();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.flow.create-item');
    }
}
