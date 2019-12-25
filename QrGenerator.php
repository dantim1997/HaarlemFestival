<?php
require_once("./phpqrcode/qrlib.php");

class QrGenerator{
	public function GenerateQRCode($id){
		QRcode::png($id, './qrscanner/QR_user='.$id.'.png');
		return './qrscanner/QR_user='.$id.'.png';
	}
}

?>