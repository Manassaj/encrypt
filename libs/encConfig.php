<?php
 
class EncLibs 
{
	 
	public $cipher     = "AES-128-CBC";	
	public $sha2len     = 32;
	function __construct()
	{
		 
	}

	public function Encrypt($text=false , $privateKey=false)
	{
		$iVn        = openssl_cipher_iv_length($this->cipher);
		$ivx        = openssl_random_pseudo_bytes($iVn);
		$cipher_raw = openssl_encrypt($text, $this->cipher, $privateKey, OPENSSL_RAW_DATA, $ivx);
		$hash       = hash_hmac('sha256', $cipher_raw, $privateKey, $as_binary=true);
		return base64_encode( $ivx.$hash.$cipher_raw );
	}

	public function Decrypt($text=false , $privateKey=false)
	{	
		
		$x = base64_decode($text);
		$iVn   = openssl_cipher_iv_length($this->cipher);
		$ivx   = substr($x, 0, $iVn);
		$hash  = substr($x, $iVn, $this->sha2len);
		$cipher_raw = substr($x, $iVn+$this->sha2len);
		$plaintext = openssl_decrypt($cipher_raw, $this->cipher, $privateKey, $options=OPENSSL_RAW_DATA, $ivx);
	 
		$calcmac = hash_hmac('sha256', $text, $privateKey, $as_binary=true);
		return !empty($plaintext) ? $plaintext : false;
		 

	}
}


 
 
?>
