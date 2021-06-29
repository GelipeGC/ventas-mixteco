<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $phone, $status, $email,$image,$password, $selected_id, $fileLoaded, $profile, $componentName, $pageTitle, $search;
    private $pagination = 5;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'
    ];
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->status = 'Elegir';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $users = User::where('name', 'like', '%' . $this->search . '%')
                        ->orderBy('name')
                        ->paginate($this->pagination);
        } else {
            $users = User::orderBy('name')
                        ->paginate($this->pagination);
        }
        $roles = Role::orderBy('name')->get();

        return view('livewire.users.component', compact('users', 'roles'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->search = '';
        $this->image = '';
        $this->search = '';
        $this->status = 'Elegir';
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }
    public function Edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->status = $user->status;
        $this->image = null;
        $this->profile = $user->profile;
        $this->email = $user->email;
        $this->password = '';

        $this->emit('show-modal','open!');
    }
    public function Store()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:8'
        ];

        $this->validate($rules);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }
        $this->resetUI();

        $this->emit('user-added', 'Usuario Registrado con éxito');

    }
    public function Update()
    {
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'name' => 'required|min:3',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:8'
        ];

        $this->validate($rules);
        $user = User::find($this->selected_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)
        ]);
        if ($this->image) {
            $customFileName = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $imageName = $user->image;

            $user->image = $customFileName;
            $user->save();
            if ($imageName != null) {
                if (file_exists('storage/users' . $imageName)) {
                    unlink('storage/users/' . $imageName);
                }
            }
        }
        $this->resetUI();

        $this->emit('user-updated', 'Usuario actualizado con éxito');

    }

    public function destroy(User $user)
    {
        if ($user) {
            $sales = Sale::where('user_id', $user->id)->count();

            if ($sales > 0) {
                $this->emit('user-withsales', 'No es posible eliminar el usuario porque tiene ventas registradas');
            } else {
                $user->delete();
                $this->resetUI();
                $this->emit('user-deleted','Usuario eliminado con éxito');
            }
        }
    }
}
