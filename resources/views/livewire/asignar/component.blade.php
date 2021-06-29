<div class="row mt-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <h4 class="card-title">
                            <b>{{ $componentName}}</b>
                        </h4>
                    </div>

                </div>

            </div>

            <div class="card-body">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <select wire:model="role" class="form-control">
                            <option value="Elegir" selected>Selecciona el role</option>
                            @foreach ($roles as $item)
                                <option value="{{$item->id}}">{{ $item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button wire:click.prevent="SyncAll()" type="button" class="btn btn-dark mbmobile inblock mr-5">Sincronizar todos</button>
                    <button onclick="Revocar()" type="button" class="btn btn-dark mbmobile mr-5">Revocar todos</button>

                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">ID</th>
                                        <th class="table-th text-white text-center">PERMISO</th>
                                        <th class="table-th text-white text-center">ROLES CON EL PERMISO</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td><h6>{{$permission->id}}</h6></td>
                                            <td class="text-center">

                                                <div class="col-auto">
                                                    <div class="custom-control custom-checkbox mb-2">
                                                        <input type="checkbox"
                                                            wire:change="SyncPermission($('#p' + {{ $permission->id}}).is(':checked'), '{{ $permission->name }}')"
                                                            id="p{{ $permission->id }}"
                                                            value="{{ $permission->id }}"
                                                            class="custom-control-input"
                                                            {{ $permission->checked == 1 ? 'checked' : ''}}
                                                        >
                                                        <label class="custom-control-label" for="p{{ $permission->id }}">
                                                            {{ $permission->name}}
                                                        </label>
                                                    </div>
                                                </div>

                                            </td>
                                            <td class="text-center">
                                                <h6>{{ \App\Models\User::permission($permission->name)->count() }}</h6>
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
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('sync-error', msg => {
            noty(msg, 2)
        });
        window.livewire.on('permi', msg => {
            noty(msg)
        });
        window.livewire.on('sync-all', msg => {
            noty(msg)
        });
        window.livewire.on('remove-all', msg => {
            noty(msg)
        });
        window.livewire.on('permi-error', msg => {
            noty(msg, 2)
        });
    });

    function Revocar()
    {

        swal.fire({
            title: 'Confirmar',
            text: '¿Confirmas revocar todos los permisos?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: "#383F5C",
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('revokeAll')
                swal.close();
            }
        })
    }
</script>
