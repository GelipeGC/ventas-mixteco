@include('common.modalHead')

<div class="row">
    <div class="col-sm-12">
        <div class="input-group">
            <div class="input-group-preprend">
                <span class="input-group-text">
                    <span class="mdi mdi-pencil-minus"></span>
                </span>
            </div>
            <input type="text" wire:model.lazy="roleName" class="form-control" placeholder="ej: Admin" maxlength="255">
        </div>
        @error('roleName')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>

</div>

</div>
<div class="modal-footer">
    <button type="button" wire:click.prevent="resetUI()" class="btn btn-light" data-dismiss="modal">Cerrar</button>
    @if ($selected_id < 1)

        <button type="button" wire:click.prevent="CreateRole()" class="btn btn-dark">Guardar</button>
        @else
        <button type="button" wire:click.prevent="UpdateRole()" class="btn btn-dark">Actualizar</button>

    @endif
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

