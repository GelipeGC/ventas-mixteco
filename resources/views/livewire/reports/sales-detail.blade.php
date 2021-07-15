<!-- Standard modal -->
<div wire:ignore.self id="modalDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-dark">
                <h4 class="modal-title text-white" id="standard-modalLabel">
                    <b>Detalle de venta # {{ $saleId}}</b>
                </h4>
                <h6 class="text-center text-warning" wire:loading>Por favor espere...</h6>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white bg-dark">
                            <tr>
                                <th class="table-th text-center text-white">FOLIO</th>
                                <th class="table-th text-center text-white">PRODUCTO</th>
                                <th class="table-th text-center text-white">PRECIO</th>
                                <th class="table-th text-center text-white">CANT.</th>
                                <th class="table-th text-center text-white">IMPORTE</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($details as $row)
                                <tr>
                                    <td class="text-center"><h6>{{ $row->id}}</h6></td>
                                    <td class="text-center"><h6>{{ $row->product}}</h6></td>
                                    <td class="text-center"><h6>$ {{number_format($row->price, 2) }}</h6></td>
                                    <td class="text-center"><h6>{{ $row->quantity}}</h6></td>
                                    <td class="text-center"><h6>$ {{ number_format($row->quantity * $row->price, 2)}}</h6></td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="3" class="text-right">
                                <h6 class="text-info font-weight-bold">
                                    TOTALES:
                                </h6>
                            </td>
                            <td class="text-center">
                                @if ($details)
                                    <h6 class="text-info">{{ $countDetails }}</h6>
                                @endif
                            </td>
                            <td class="text-center">
                                ${{number_format($sumDetails, 2)}}
                            </td>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
