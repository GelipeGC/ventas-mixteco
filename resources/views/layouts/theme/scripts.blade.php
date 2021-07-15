<!-- bundle -->
<script src="{{ asset('assets/js/vendor.min.js')}}"></script>
<script src="{{ asset('assets/js/app.min.js')}}"></script>

<!-- third party js -->
<script src="{{ asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/jquery.nicescroll.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr.js')}}"></script>


<!-- third party js ends -->
<script>
    function noty(msg, option=1) {
        if(option==2){
            $.NotificationApp.send('',msg,"top-right","","error")
        }else {
            $.NotificationApp.send('',msg,"top-right","","success")
        }
    }
</script>

@livewireScripts
