<div class="col-lg-12">
    <div class="border p-3 mt-4 mt-lg-0 rounded">
        <h4 class="header-title mb-3">RESUMEN DE VENTA</h4>

        <div class="table-responsive">
            <table class="table mb-0">
                <tbody>
                    <tr>
                        <td><h2>TOTAL:</h2></td>
                        <td>
                            <h2>
                                ${{number_format($total, 2)}}
                                <input type="hidden" id="hiddenTotal" value="{{$total}}">
                            </h2>
                        </td>
                    </tr>
                    <tr>
                        <td><h4 class="mt-1">Artículos: </h4></td>
                        <td><h4 class="mt-1">{{$itemQuantity}}</h4></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- end table-responsive -->
    </div>
</div> <!-- end col -->
