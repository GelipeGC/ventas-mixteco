<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Asignar extends Component
{
    use WithPagination;

    public $componentName, $role, $permissionsSelected = [], $old_permissions = [];
    private $pagination = 10;

    protected $paginationTheme = 'bootstrap';

    public $listeners = [
      'revokeAll' => 'removeAll'
    ];
    public function mount()
    {
        $this->role = 'Elegir';
        $this->componentName = 'Permisos';

    }
    public function render()
    {
        $permissions = Permission::select('name','id',DB::raw("0 as checked"))
                        ->orderBy('name')
                        ->paginate($this->pagination);
        if ($this->role != 'Elegir') {
            $list = Permission::join('role_has_permissions as rp','rp.permission_id','permissions.id')
                                ->where('role_id', $this->role)
                                ->pluck('permissions.id')
                                ->toArray();
            $this->old_permissions = $list;
        }

        if ($this->role != 'Elegir') {
            foreach ($permissions as $permission) {
                $role = Role::find($this->role);
                $hasPermission = $role->hasPermissionTo($permission->name);
                if ($hasPermission) {
                    $permission->checked = 1;
                }
            }
        }
        $roles = Role::orderBy('name')->get();
        return view('livewire.asignar.component',compact('roles','permissions'))
                ->extends('layouts.theme.app')
                ->section('content');
    }
    public function removeAll()
    {
       if ($this->role == 'Elegir') {
           $this->emit('sync-error', 'Selecciona un role válido');
           return;
       }

       $role = Role::find($this->role);
       $role->syncPermissions([0]);
       $this->emit('remove-all', "Se revocaron todos los permisos al role $role->name");


    }
    public function SyncAll()
    {
        if ($this->role == 'Elegir') {
            $this->emit('sync-error', 'Selecciona un role válido');
            return;
        }

        $role = Role::find($this->role);
        $permissions = Permission::pluck('id')->toArray();
        $role->syncPermissions($permissions);
        $this->emit('sync-all', "Se sincronizaron todos los permisos al role $role->name");

    }
    public function SyncPermission($state, $permissionName)
    {
        if ($this->role != 'Elegir') {
            $roleName = Role::find($this->role);
            if ($state) {
                $roleName->givePermissionTo($permissionName);
                $this->emit('permi', "Permiso asignado correctamente");

            }else {
                $roleName->revokePermissionTo($permissionName);
                $this->emit('permi', "Permiso eliminado correctamente");
            }
        } else {
            $this->emit('permi-error', "Elige un role válido");
        }

    }
}
