<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;

    public $permissionName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $permissions = Permission::where('name', 'like','%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $permissions = Permission::orderBy('name')->paginate($this->pagination);
        }

        return view('livewire.permissions.component', compact('permissions'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function CreatePermission()
    {
        $rules = [
            'permissionName' => 'required|unique:permissions,name|min:2'
        ];

        $this->validate($rules);

        Permission::create([
            'name' => $this->permissionName
        ]);

        $this->emit('permission-added', 'Se registró el permiso con éxito');
        $this->resetUI();
    }
    public function Edit(Permission $permission)
    {
        $this->selected_id = $permission->id;
        $this->permissionName = $permission->name;

        $this->emit('show-modal', 'Show modal');
    }

    public function UpdatePermission()
    {
        $rules = [
            'permissionName' => "required|unique:roles,name,{$this->selected_id}|min:2"
        ];

        $this->validate($rules);

        $permission = Permission::find($this->selected_id);
        $permission->name = $this->permissionName;
        $permission->save();

        $this->emit('permission-updated', 'Se actualizó el permiso con éxito');
        $this->resetUI();
    }

    public function Destroy($id)
    {
        $rolesCount = Permission::find($id)->getRoleNames()->count();

        if ($rolesCount > 0) {
            $this->emit('permission-error', 'No se puede eliminar el permiso porque tiene roles asociados');
            return;
        }

        Permission::find($id)->delete();

        $this->emit('permission-deleted', 'Se eliminó el permiso con éxito');
    }

    public function resetUI()
    {
        $this->permissionName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
