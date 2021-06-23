<!-- Start Content-->
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                            <div class="table-responsive">
                                @if ($total > 0)
                                    <table class="table table-borderless table-centered mb-0">
                                        <thead  class="bg-dark">
                                            <tr>
                                                <th width="10%"></th>
                                                <th class="table-th text-left text-white">DESCRIPCIÓN</th>
                                                <th class="table-th text-center text-white">PRECIO</th>
                                                <th width="13%" class="table-th text-center text-white">CANT.</th>
                                                <th class="table-th text-center text-white">IMPORTE</th>
                                                <th class="table-th text-center text-white">ACCIONES</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $item)
                                                <tr>
                                                    <td class="text-center table-th">
                                                        @if (count($item->attributes) > 0)
                                                            <span>
                                                                <img src="{{ asset('storage/products/'. $item->attributes[0])}}" alt="imagen de producto" height="90" width="90" class="rounded">
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td><h6>{{ $item->name}}</h6></td>
                                                    <td class="text-center">${{ number_format($item->price, 2)}}</td>
                                                    <td>
                                                        <input type="number" id="r{{$item->id}}"
                                                                wire:change="updateQty({{$item->id}}, $('#r' + {{$item->id}}).val() )"
                                                                style="font-size: 1rem!important"
                                                                class="form-control text-center"
                                                                value="{{$item->quantity}}"
                                                                >
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>
                                                            ${{number_format($item->price * $item->quantity, 2)}}
                                                        </h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <button onclick="Confirm('{{$item->id}}', 'removeItem', '¿Confirmas eliminar el registro?')" class="btn btn-dark mbmobile">
                                                            <i class="uil-trash-alt"></i>
                                                        </button>
                                                        <button wire:click.prevent="decreaseQty({{$item->id}})" class="btn btn-dark mbmobile">
                                                            <i class="uil-minus"></i>
                                                        </button>
                                                        <button wire:click.prevent="increaseQty({{$item->id}})" class="btn btn-dark mbmobile">
                                                            <i class="uil-plus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <h5 class="text-center text-muted">Agrega productos a la venta</h5>
                                @endif
                            </div> <!-- end table-responsive-->
                            <div wire:loading.inline wire:target="saveSale">
                                <h4 class="text-danger text-center">Guardando venta...</h4>
                            </div>
                    </div> <!-- end row -->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->

