
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
                                        <th class="table-th text-white">DESCRIPCIÓN</th>
                                        <th class="table-th text-white">IMAGEN</th>
                                        <th class="table-th text-white">ACCIONES</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td><h6>{{$category->name}}</h6></td>
                                            <td class="text-center">
                                                <span>
                                                    <img src="{{ asset('storage/categories/' . $category->image) }}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)"
                                                    wire:click="Edit({{$category->id}})"
                                                    class="btn btn-dark mtmobile" title="Edit">
                                                    <i class="fa uil-edit"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    onclick="Confirm('{{$category->id}}', '{{$category->products->count()}}')"
                                                    class="btn btn-dark" title="Delete">
                                                    <i class="uil-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$categories->links()}}
                        </div>
                    </div>
                </div>
            </div>
            @include('livewire.category.form')
        </div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
       window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
       });
       window.livewire.on('category-added', msg => {
            $('#theModal').modal('hide');
       });
       window.livewire.on('category-updated', msg => {
            $('#theModal').modal('hide');
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
