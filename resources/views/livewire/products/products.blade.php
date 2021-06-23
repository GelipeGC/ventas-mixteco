<div class="row mt-3">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-12">
                            <h4 class="card-title">
                                <b>{{ $componentName }} | {{ $pageTitle }}</b>
                            </h4>
                        </div>
                        <div class="col-lg-6 col-md-4 col-xs-12 d-flex">
                            <div class="ml-auto">
                            <a href="javascript:void(0)" class="btn bg-dark text-white" data-toggle="modal" data-target="#theModal">Agregar</a>
                            </div>
                        </div>
                    </div>
                    @include('common.searchBox')
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white bg-dark">
                                <tr>
                                    <th class="table-th text-white">DESCRIPCIÓN</th>
                                    <th class="table-th text-white">BARDCODE</th>
                                    <th class="table-th text-white">CATEGORÍA</th>
                                    <th class="table-th text-white">PRECIO</th>
                                    <th class="table-th text-white">STOCK</th>
                                    <th class="table-th text-white">INV.MIN</th>
                                    <th class="table-th text-white">IMAGEN</th>
                                    <th class="table-th text-white">ACCIONES</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td><h6>{{ $product->name}}</h6></td>
                                        <td><h6>{{ $product->barcode}}</h6></td>
                                        <td><h6>{{ $product->category}}</h6></td>
                                        <td><h6>{{ $product->price}}</h6></td>
                                        <td><h6>{{ $product->stock}}</h6></td>
                                        <td><h6>{{ $product->alerts}}</h6></td>

                                        <td class="text-center">
                                            <span>
                                                <img src="{{ asset('storage/products/' . $product->image)}}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)"
                                                wire:click="Edit({{$product->id}})"
                                                class="btn btn-dark mtmobile" title="Edit">
                                                <i class="fa uil-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                onclick="Confirm('{{$product->id}}')"
                                                class="btn btn-dark" title="Delete">
                                                <i class="uil-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.products.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){

       window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide');
       });
       window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide');
       });
       window.livewire.on('product-deleted', msg => {
            //noty
       });
       window.livewire.on('modal-show', msg => {
        $('#theModal').modal('show');
       });
       window.livewire.on('modal-hide', msg => {
        $('#theModal').modal('hide');
       });
       window.livewire.on('hidden.bs.modal', msg => {
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
