<?php 
chdir(dirname(__FILE__));
include '../../../security.php';
chdir(dirname(__FILE__));?>
<!-- Barcode / QR Code scanner -->

<script src="https://unpkg.com/html5-qrcode"></script>

<div id="qr-reader" style="width: 600px"></div>
<script>
    function onScanSuccess(decodedText, decodedResult) {
     console.log(`Code scanned = ${decodedText}`, decodedResult);
}
var html5QrcodeScanner = new Html5QrcodeScanner(
  "qr-reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
</script>