<div class="app-search">
    <form>
        <div class="input-group">
            <input id="code" wire:keydown.enter.prevent="$emit('scan-code',$('#code').val())" type="text" class="form-control" placeholder="Buscar...">
            <span class="mdi mdi-magnify"></span>
            
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){

        livewire.on('scan-code', action => {
            $('#code').val('');
        });
    });
</script>
