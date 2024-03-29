<script>
    document.addEventListener('DOMContentLoaded', function(){
       window.livewire.on('scan-ok', msg => {
            noty(msg)
       });
       window.livewire.on('scan-notfound', msg => {
            noty(msg, 2);
       });
       window.livewire.on('no-stock', msg => {
            noty(msg, 2)
       });
       window.livewire.on('sale-ok', msg => {
            noty(msg);
            $(':focus').blur(); //Quitar focus en efectivo despues de guardar venta para seguir escaneandoachis
       });
       window.livewire.on('sale-error', msg => {
            noty(msg, 2)
       });
       window.livewire.on('print-ticket', saleId => {
            window.open("print://" + saleId, '_blank')
       });
    });

</script>
