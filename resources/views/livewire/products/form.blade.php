@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: tacos al pastor">
            @error('name')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Código</label>
            <input type="text" wire:model.lazy="barcode" class="form-control" placeholder="ej: 1010101">
            @error('barcode')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Costo</label>
            <input type="text" data-type="currency" wire:model.lazy="cost" class="form-control" placeholder="ej: 0.00">
            @error('cost')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Precio</label>
            <input type="text" data-type="currency" wire:model.lazy="price" class="form-control" placeholder="ej: 0.00">
            @error('price')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Stock</label>
            <input type="number" wire:model.lazy="stock" class="form-control" placeholder="ej: 100">
            @error('stock')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Alertas / Inv. Mínimo</label>
            <input type="number" wire:model.lazy="alerts" class="form-control" placeholder="ej:10">
            @error('alerts')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Categoría</label>
            <select wire:model="category_id" class="form-control">
                <option value="Eligir" disabled>Elegir</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{ $category->name}}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image" accept="image/png,image/gif,image/jpeg">
            <label class="custom-file-label">Imágen {{$image}}</label>
            @error('image')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
