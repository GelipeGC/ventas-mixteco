<div class="row mt-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <h4 class="card-title">
                            <b>{{ $componentName}} | {{$pageTitle}}</b>
                        </h4>
                    </div>
                    <div class="col-lg-6 col-md-4 col-xs-12 d-flex">
                        <div class="ml-auto">
                        <a href="javascript:void(0)" class="btn btn-primary bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                        </div>
                    </div>
                </div>
                @include('common.searchBox')
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white text-center">DESCRIPTION</th>
                                <th class="table-th text-white text-center">ACCIONES</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td><h6>{{ $permission->id}}</h6></td>
                                    <td class="text-center">
                                        <h6>{{ $permission->name}}</h6>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{$permission->id}})" class="btn btn-dark mtmobile" title="Editar registro">
                                            <i class="fa uil-edit"></i>

                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{$permission->id}}')" class="btn btn-dark" title="Eliminar registro">
                                            <i class="uil-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $permissions->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.permissions.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('permission-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
       });
       window.livewire.on('permission-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
       });
       window.livewire.on('permission-deleted', msg => {
            noty(msg)
       });
       window.livewire.on('permission-exists', msg => {
            noty(msg)
       });
       window.livewire.on('permission-error', msg => {
            noty(msg, 2)
       });
       window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
       });
       window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
       });
    });

    function Confirm(id, products)
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
