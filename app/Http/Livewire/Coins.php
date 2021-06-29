<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Coins extends Component
{
    use WithPagination, WithFileUploads;

    public $type, $value, $search, $image,$selected_id,$pageTitle, $componentName;
    private $pagination = 5;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Denominaciones';
        $this->selected_id = 0;
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $denominations = Denomination::where('type', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        }else {
            $denominations = Denomination::orderBy('id', 'desc')->paginate($this->pagination);
        }
        return view('livewire.denominations.component', compact('denominations'))
                ->extends('layouts.theme.app')
                ->section('content');
    }
    public function Edit($id)
    {
        $coin = Denomination::find($id, ['id','type','value','image']);

        $this->type = $coin->type;
        $this->value = $coin->value;
        $this->selected_id = $coin->id;
        $this->image = null;

        $this->emit('modal-show', 'show modal');
    }

    public function Store()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => 'required|unique:denominations'
        ];

        $this->validate($rules);

        $coin = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $coin->image = $customFileName;
            $coin->save();
        }
        $this->resetUI();

        $this->emit('item-added', 'Denominación Registrada');

    }

    public function Update()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => "required|unique:denominations,value,{$this->selected_id}"
        ];


        $this->validate($rules);

        $coin = Denomination::find($this->selected_id);
        $coin->update([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $imageName = $coin->image;

            $coin->image = $customFileName;
            $coin->save();

            if ($imageName != null) {
                if (file_exists('storage/denominations' . $imageName)) {
                    unlink('storage/denominations/' . $imageName);
                }
            }
        }

        $this->resetUI();

        $this->emit('item-updated','Denominación actualizada');
    }

    public function resetUI()
    {
        $this->type = 'Elegir';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }

    public function Destroy(Denomination $coin)
    {
        $imageName = $coin->image;
        $coin->delete();
        if ($imageName != null) {
            if (file_exists('storage/denominations/' . $imageName)) {
                unlink('storage/denominations/' . $imageName);
            }
        }

        $this->resetUI();

        $this->emit('item-deleted', 'Denominación eliminada');
    }
}
