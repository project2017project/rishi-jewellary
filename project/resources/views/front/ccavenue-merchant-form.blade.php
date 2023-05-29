@extends('layouts.front')

@section('content')
<center><h1>Please do not refresh this page...</h1></center>
<?php

/*
* @param1 : Plain String
* @param2 : Working key provided by CCAvenue
* @return : Decrypted String
*/
function encrypt_e($plainText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	$encryptedText = bin2hex($openMode);
	return $encryptedText;
}

/*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
function decrypt_e($encryptedText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText = hextobin($encryptedText);
	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	return $decryptedText;
}

function hextobin($hexString) 
 { 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
	    
	    else 
	    {
			$binString.=$packedString;
	    } 
	    
	    $count+=2; 
	} 
        return $binString; 
  } 
?>

<?php
		
		error_reporting(0);
	
	    $merchant_data='';
	    $working_key='54E01AF1D7382A1CBD60680B56D6EA36';//Shared by CCAVENUES
	    $access_code='AVFL28KC63BA52LFAB';//Shared by CCAVENUES
	
		foreach($paramList as $name => $value) {
		    $merchant_data.=$name.'='.$value.'&';
		}
		$encrypted_data=encrypt_e($merchant_data,$working_key);
		?>   



<form method="post" action="{{ $paytm_txn_url }}" name="f1">
     @csrf
     
    <table border="1">
        <tbody>
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
        <?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
        </tbody>
    </table>
    
</form>





@endsection

@section('scripts')
<script type="text/javascript">
    document.f1.submit();
</script>
@endsection