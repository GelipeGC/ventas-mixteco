<!-- Standard modal -->
<div wire:ignore.self id="theModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-dark">
                <h4 class="modal-title text-white" id="standard-modalLabel">
                    <b>{{ $componentName }}</b> | {{$selected_id > 0 ? 'EDITAR' : 'CREAR'}}
                </h4>
                <h6 class="text-center text-warning" wire:loading>Por favor espere...</h6>
            </div>
            <div class="modal-body">
