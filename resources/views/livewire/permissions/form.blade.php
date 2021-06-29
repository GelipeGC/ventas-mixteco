@include('common.modalHead')

<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-preprend">
                <span class="input-group-text">
                    <span class="mdi mdi-pencil-minus"></span>
                </span>
            </div>
            <input type="text" wire:model.lazy="permissionName" class="form-control" placeholder="ej: editar usuario" maxlength="255">
        </div>
        @error('permissionName')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>

</div>

</div>
<div class="modal-footer">
    <button type="button" wire:click.prevent="resetUI()" class="btn btn-light" data-dismiss="modal">Cerrar</button>
    @if ($selected_id < 1)

        <button type="button" wire:click.prevent="CreatePermission()" class="btn btn-dark">Guardar</button>
        @else
        <button type="button" wire:click.prevent="UpdatePermission()" class="btn btn-dark">Actualizar</button>

    @endif
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

