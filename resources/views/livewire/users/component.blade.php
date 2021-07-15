<div class="row mt-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <h4 class="card-title">
                            <b>{{ $componentName}} | {{ $pageTitle }}</b>
                        </h4>
                    </div>
                    @can('User_Create')
                    <div class="col-lg-6 col-md-4 col-xs-12 d-flex">
                        <div class="ml-auto">
                        <a href="javascript:void(0)" class="btn btn-primary bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                        </div>
                    </div>
                    @endcan
                </div>
                @can('User_Search')
                @include('common.searchBox')
                @endcan
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">USUARIO</th>
                                <th class="table-th text-white text-center">TELÉFONO</th>
                                <th class="table-th text-white text-center">EMAIL</th>
                                <th class="table-th text-white text-center">PERFIL</th>
                                <th class="table-th text-white text-center">ESTATUS</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACCIONES</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td><h6>{{ $user->name }}</h6></td>
                                    <td class="text-center">
                                        {{ $user->phone}}
                                    </td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->profile}}</td>
                                    <td class="text-center">
                                        <span class="badge {{$user->status == 'Active' ? 'badge-success' : 'badge-danger'}} text-uppercase">{{$user->status}}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($user->image != null)
                                            <img src="{{asset('storage/users/'.$user->image)}}" alt="imagen de ejemplo" height="70" width="80" class="mr-2 rounded-circle">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @can('User_Update')
                                        <a wire:click="Edit({{$user->id}})" href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fa uil-edit"></i>
                                        </a>
                                        @endcan
                                        @can('User_Destroy')
                                        <a onclick="Confirm('{{$user->id}}')" href="javascript:void(0)" class="btn btn-dark" title="Delete">
                                            <i class="uil-trash-alt"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.users.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('user-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('user-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('user-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('user-withsales', msg => {
            noty(msg)
        });
    });

    function Confirm(id)
    {

        swal.fire({
            title: 'Confirmar',
            text: '¿Confirmas eliminar el registro?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: "#383F5C",
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow',id)
                swal.close();
            }
        })
    }
</script>
