<script>
    document.addEventListener('DOMContentLoaded', function(){

        $('.tblscroll').niceScroll({
            cursorcolor:"#515365",
            cursorwidth:"24px",
            background:"rgba(20,20,20,0.3)",
            cursorborder:"0px",
            cursorborderradius:3
        });
    });
    function Confirm(id, eventName, text)
    {
        swal.fire({
            title: 'Confirmar',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: "#383F5C",
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit(eventName,id)
                swal.close();
            }
        })
    }
</script>
