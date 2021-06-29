<script>
    try {
        onScan.attachTo(document, {
            suffixKeyCodes: [13],
            onScan: function(barcode) { // Alternative to document.addEventListener('scan')
                console.log('Scanned: ' + barcode);
                window.livewire.emit('scan-code', barcode);
            },
            onScanError: function(e){ // output all potentially relevant key events - great for debugging!
                console.log('error: ' + e);
            }
        })

        console.log('Scanner ready')
    } catch (error) {
        console.log('Error de lectura: ',error)
    }
</script>
