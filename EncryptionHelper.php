<?php

class EncryptionHelper
{
	function __construct(){}

	function Encrypt($value){
		return $value;
		//encrypt the unput using a key.
	   if(!$value){return false;}
	   $key = 'a#$(&*ASD!@#$!@#';
	   $text = $value;
	   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	   $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
	   return trim(base64_encode($crypttext)); //encode for cookie
	}

	function Decrypt($value){
		return $value;
		//Decrypt the unput using a key.
	   if(!$value){return false;}
	   $key = 'a#$(&*ASD!@#$!@#';
	   $crypttext = base64_decode($value); //decode cookie
	   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	   $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);
	   return trim($decrypttext);
	}
}

?>