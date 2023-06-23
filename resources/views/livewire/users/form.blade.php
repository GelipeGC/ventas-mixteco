@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Felipe Guzman">
            @error('name')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" wire:model.lazy="phone" class="form-control" placeholder="ej: 1010101" maxlength="10">
            @error('phone')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="ej: felipe@test.com">
            @error('email')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" wire:model.lazy="password" class="form-control" placeholder="ej: contraseñar">
            @error('password')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estatus</label>
            <select wire:model="status" class="form-control">
               <option value="Elegir" selected>Elegir</option>
               <option value="Active" >Activo</option>
               <option value="Locked">Bloqueado</option>

            </select>
            @error('status')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Asignar role</label>
            <select wire:model="profile" class="form-control">
                <option value="Eligir" selected>Elegir</option>
                @foreach ($roles as $role)
                    <option value="{{$role->name}}">{{ $role->name}}</option>
                @endforeach
            </select>
            @error('profile')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image" accept="image/png,image/gif,image/jpeg">
            <label class="custom-file-label">Imágen de perfil {{$image}}</label>
            @error('image')
                <span class="text-danger err">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
