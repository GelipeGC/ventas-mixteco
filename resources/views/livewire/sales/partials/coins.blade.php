<div class="col-lg-12 mt-3">
    <div class="border p-3 mt-4 mt-lg-0 rounded">
        <h4 class="header-title mb-3">DENOMINACIONES</h4>
            <div class="row">
                @foreach ($denominations as $coin)
                    <div class="col-sm mt-2">
                        <button wire:click.prevent="ACash({{$coin->value}})" class="btn btn-dark btn-block den">
                            {{ $coin->value > 0 ? '$' . number_format($coin->value, 2, '.', '') : 'Exacto'}}
                        </button>
                    </div>
                @endforeach
            </div>
            <div class="input-group mt-3">
                <div class="input-group-preprend">
                    <span class="input-group-text btn-dark">
                        Efectivo F8
                    </span>
                </div>
                <input type="number"
                        id="cash"
                        wire:model="cash"
                        wire:keydown.enter="saveSale"
                        class="form-control form-control-light"
                        value="{{$cash}}">
                <div class="input-group-append">
                    <span wire:click="$set('cash', 0)" class="input-group-text btn-dark">
                        <i class="uil-backspace" width="18px" height="18px"></i>
                    </span>
                </div>
            </div>
            <h4 class="text-muted mt-2">Cambio: ${{number_format($change, 2)}}</h4>
            <div class="row justify-content-between mt-5">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    @if ($total > 0)
                        <button onclick="Confirm('','clearCart','¿Seguro de eliminar el carrito?')"
                            class="btn btn-dark mtmobile">
                            CANCELAR F4
                        </button>
                    @endif
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    @if ($cash >= $total && $total > 0)
                        <button wire:click.prevent="saveSale"
                            class="btn btn-dark btn-md btn-block">
                            GUARDAR F9
                        </button>
                    @endif
                </div>
            </div>
    </div>
</div> <!-- end col -->
