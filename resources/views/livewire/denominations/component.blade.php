
        <div class="row mt-3">

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-xs-12">

                                <h4 class="card-title">
                                    <b>{{ $componentName}} | {{$pageTitle }}</b>
                                </h4>
                            </div>
                            @can('Coin_Create')

                            <div class="col-lg-6 col-md-4 col-xs-12 d-flex">
                                <div class="ml-auto">
                                <a href="javascript:void(0)" class="btn text-white bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                                </div>
                            </div>
                            @endcan
                        </div>

                        @include('common.searchBox')
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1">
                                <thead class="text-white bg-dark">
                                    <tr>
                                        <th class="table-th text-white">TIPO</th>
                                        <th class="table-th text-white">VALOR</th>
                                        <th class="table-th text-white">IMAGEN</th>
                                        <th class="table-th text-white">ACCIONES</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($denominations as $coin)
                                        <tr>
                                            <td><h6>{{$coin->type}}</h6></td>
                                            <td><h6>$ {{number_format($coin->value, 2)}}</h6></td>
                                            <td class="text-center">
                                                <span>
                                                    <img src="{{ asset('storage/denominations/' . $coin->image) }}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @can('Coin_Update')

                                                <a href="javascript:void(0)"
                                                    wire:click="Edit({{$coin->id}})"
                                                    class="btn btn-dark mtmobile" title="Edit">
                                                    <i class="fa uil-edit"></i>
                                                </a>
                                                @endcan
                                                @can('Coin_Destroy')

                                                <a href="javascript:void(0)"
                                                    onclick="Confirm('{{$coin->id}}')"
                                                    class="btn btn-dark" title="Delete">
                                                    <i class="uil-trash-alt"></i>
                                                </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$denominations->links()}}
                        </div>
                    </div>
                </div>
            </div>
            @include('livewire.denominations.form')
        </div>
<script>
    document.addEventListener('DOMContentLoaded', function(){

       window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide');
       });
       window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide');
       });
       window.livewire.on('item-deleted', msg => {
            //noty
       });
       window.livewire.on('modal-show', msg => {
        $('#theModal').modal('show');
       });
       window.livewire.on('modal-hide', msg => {
        $('#theModal').modal('hide');
       });
       $('#theModal').on('hidden.bs.modal', function(e) {
            $('.er').css('display', 'none');
       });
    });

    function Confirm(id, products)
    {
        if (products > 0) {
            swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No se puede eliminar la categoría porque tiene productos relacionados'
            })
            return;
        }
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
