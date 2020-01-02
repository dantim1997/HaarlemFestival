<?php
require_once("./phpqrcode/qrlib.php");

class QrGenerator{
	public function GenerateQRCode($value,$id ){
		QRcode::png($value, './qrscanner/QR_user='.$id.'.png');
		return './qrscanner/QR_user='.$id.'.png';
	}
}

?>