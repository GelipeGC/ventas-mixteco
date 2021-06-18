@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <select wire:model="type" class="form-control">
                <option value="Elegir">Elegir</option>
                <option value="BILLETE">BILLETE</option>
                <option value="MONEDA">MONEDA</option>
                <option value="OTRO">OTRO</option>
            </select>
            @error('type')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12">
        <label>Valor</label>
        <div class="input-group">
            <div class="input-group-preprend">
                <span class="input-group-text">
                    <span class="mdi mdi-pencil-minus"></span>
                </span>
            </div>
            <input type="number" wire:model.lazy="value" class="form-control" placeholder="ej: 100">
        </div>
        @error('value')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-sm-12 mt-3">
        <div class="form-group custom-file">
            <input type="file" class="form-control custom-file-input" wire:model="image" accept="image/x-png,image/gif,image/jpeg">
            <label class="custom-file-label">Imágen {{$image}}</label>
            @error('image')
                <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
