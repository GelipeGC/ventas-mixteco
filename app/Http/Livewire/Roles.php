<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Roles extends Component
{
    use WithPagination;

    public $roleName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $roles = Role::where('name', 'like','%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $roles = Role::orderBy('name')->paginate($this->pagination);
        }

        return view('livewire.roles.component', compact('roles'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function CreateRole()
    {
        $rules = [
            'roleName' => 'required|unique:roles,name|min:2'
        ];

        $this->validate($rules);

        Role::create([
            'name' => $this->roleName
        ]);

        $this->emit('role-added', 'Se registró el role con éxito');
        $this->resetUI();
    }
    public function Edit(Role $role)
    {
        $this->selected_id = $role->id;
        $this->roleName = $role->name;

        $this->emit('show-modal', 'Show modal');
    }

    public function UpdateRole()
    {
        $rules = [
            'roleName' => "required|unique:roles,name,{$this->selected_id}|min:2"
        ];

        $this->validate($rules);

        $role = Role::find($this->selected_id);
        $role->name = $this->roleName;
        $role->save();

        $this->emit('role-updated', 'Se actualizó el role con éxito');
        $this->resetUI();
    }

    public function Destroy($id)
    {
        $permissionCount = Role::find($id)->permissions->count();

        if ($permissionCount > 0) {
            $this->emit('role-error', 'No se puede eliminar el role porque tiene permisos asociados');
            return;
        }

        Role::find($id)->delete();

        $this->emit('role-deleted', 'Se eliminó el role con éxito');
    }

    public function resetUI()
    {
        $this->roleName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }
}
