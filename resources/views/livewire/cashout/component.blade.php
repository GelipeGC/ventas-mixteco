
<div class="row mt-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center"><b>Corte de Caja</b></b></h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Usuario</label>
                            <select wire:model="userId" class="form-control">
                                <option value="0" disabled>Elegir</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('userId')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Fecha incial</label>
                            <input wire:model.lazy="fromDate" type="date" class="form-control">
                            @error('fromDate')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Fecha final</label>
                            <input wire:model.lazy="toDate" type="date" class="form-control">
                            @error('toDate')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 align-self-center d-flex justify-content-around">
                        @if ($userId > 0 && $fromDate != null && $toDate != null)
                            <button wire:click.prevent="Consult" type="button" class="btn btn-dark">Consultar</button>
                        @endif
                        @if ($total > 0)
                            <button wire:click.prevent="Print()" type="button" class="btn btn-dark">Imprimir</button>
                        @endif

                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-sm-12 col-md-4 mbmobile">
                    <div class="connect-sorting bg-dark p-2">
                        <h5 class="text-white">Ventas Totales: ${{number_format($total,2)}}</h5>
                        <h5 class="text-white">Articulos: {{$items}} </h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white bg-dark">
                                <tr>
                                    <th class="table-th text-center text-white">FOLIO</th>
                                    <th class="table-th text-center text-white">TOTAL</th>
                                    <th class="table-th text-center text-white">ITEMS</th>
                                    <th class="table-th text-center text-white">FECHA</th>
                                    <th class="table-th text-center text-white"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($total <= 0)
                                    <tr>
                                        <td colspan="4"><h6 class="text-center">No hay ventas en la fecha seleccionada</h6></td>
                                    </tr>
                                @endif
                                @foreach ($sales as $row)
                                    <tr>
                                        <td class="text-center"><h6>{{ $row->id}}</h6></td>
                                        <td class="text-center"><h6>$ {{number_format($row->total, 2) }}</h6></td>
                                        <td class="text-center"><h6>{{ $row->items}}</h6></td>
                                        <td class="text-center"><h6>{{ $row->created_at}}</h6></td>
                                        <td class="text-center">
                                            <button wire:click.prevent="viewDetails({{$row}})" class="btn btn-dark btn-sm">
                                                <i class="uil-notes"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.cashout.modalDetails')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
       window.livewire.on('show-modal', msg => {
            $('#modal-datails').modal('show');
       });
    });
</script>
