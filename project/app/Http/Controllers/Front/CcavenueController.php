<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Currency;
use App\Models\OrderTrack;
use App\Models\VendorOrder;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\UserNotification;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Models\Pagesetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use PDF;
use Config;

class CcavenueController extends Controller
{
    
    public function __construct()
    {

        $rdata = Generalsetting::findOrFail(1);
        

        if($rdata->header_email == 'smtp') {
            $mail_driver = 'smtp';
        }
        else{
            if($rdata->header_email == 'sendmail') {
                $mail_driver = 'sendmail';
            }
            else {
                $mail_driver = 'smtp';
            }
        }
        Config::set('mail.driver', $mail_driver);
        Config::set('mail.host', $rdata->smtp_host);
        Config::set('mail.port', $rdata->smtp_port);
        Config::set('mail.encryption', $rdata->email_encryption);
        Config::set('mail.username', $rdata->smtp_user);
        Config::set('mail.password', $rdata->smtp_pass);
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
        //
     }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->pass_check) {
            $users = User::where('email','=',$request->personal_email)->get();
            if(count($users) == 0) {
                if ($request->personal_pass == $request->personal_confirm){
                    $user = new User;
                    $user->name = $request->personal_name;
                    $user->email = $request->personal_email;
                    $user->password = bcrypt($request->personal_pass);
                    $token = md5(time().$request->personal_name.$request->personal_email);
                    $user->verification_link = $token;
                    $user->affilate_code = md5($request->name.$request->email);
                    $user->email_verified = 'Yes';
                    $user->save();
                    Auth::guard('web')->login($user);
                }else{
                    return redirect()->back()->with('unsuccess',"Confirm Password Doesn't Match.");
                }
            }
            else {
                return redirect()->back()->with('unsuccess',"This Email Already Exist.");
            }
        }

        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        if (Session::has('currency'))
        {
          $curr = Currency::find(Session::get('currency'));
      }
      else
      {
        $curr = Currency::where('is_default','=',1)->first();
    }
    if($curr->name != "INR")

    {
        return redirect()->back()->with('unsuccess','Please Select INR Currency For CC Avenue.');
    }
    $settings = Generalsetting::findOrFail(1);
    $order = new Order;
    $success_url = action('Front\PaymentController@payreturn');
    $item_name = $settings->title." Order";
        //$item_number = str_random(4).time();
    $order_data = Order::orderBy('id','desc')->get();
        //$ord_no = 'order'.Auth()->id();
    $ord_no = 'REV000';
    $ord_gen =@$order_data[0]->id+1;
    $item_number =$ord_no.$ord_gen;
    $item_amount = $request->total;

    foreach($cart->items as $key => $prod)
    {
        $vendor_list[] = $prod['item']['user_id'];
        $product_name_qty[]= $prod['item']['name'] .' x '. $prod['qty'];
        $product_id_qty[]= $prod['item']['name'];
        $product_item_qty[]= $prod['item']['qty'];
        if(!empty($prod['item']['license']) && !empty($prod['item']['license_qty']))
        {
            foreach($prod['item']['license_qty']as $ttl => $dtl)
            {
                if($dtl != 0)
                {
                    $dtl--;
                    $produc = Product::findOrFail($prod['item']['id']);
                    $temp = $produc->license_qty;
                    $temp[$ttl] = $dtl;
                    $final = implode(',', $temp);
                    $produc->license_qty = $final;
                    $produc->update();
                    $temp =  $produc->license;
                    $license = $temp[$ttl];
                    $oldCart = Session::has('cart') ? Session::get('cart') : null;
                    $cart = new Cart($oldCart);
                    $cart->updateLicense($prod['item']['id'],$license);
                    Session::put('cart',$cart);
                    break;
                }
            }
        }
    }
    $order['user_id'] = $request->user_id;
    $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
    $order['totalQty'] = $request->totalQty;
    $order['pay_amount'] = round($item_amount / $curr->value, 2);
    $order['method'] = "CCavenue";
    $order['customer_email'] = $request->email;
    $order['customer_name'] = $request->name;
    $order['customer_phone'] = $request->phone;
    $order['order_number'] = $item_number;
    $order['shipping'] = $request->shipping;
    $order['pickup_location'] = $request->pickup_location;
    $order['customer_address'] = $request->address;
    $order['customer_country'] = $request->customer_country;
    $order['customer_city'] = $request->city;
    $order['customer_zip'] = $request->zip;
    $order['shipping_email'] = $request->shipping_email;
    $order['shipping_name'] = $request->shipping_name;
    $order['shipping_phone'] = $request->shipping_phone;
    $order['shipping_address'] = $request->shipping_address;
    $order['shipping_country'] = $request->shipping_country;
    $order['shipping_city'] = $request->shipping_city;
    $order['shipping_zip'] = $request->shipping_zip;
    $order['order_note'] = $request->order_notes;
    $order['coupon_code'] = $request->coupon_code;
    $order['coupon_discount'] = $request->coupon_discount;
    $order['payment_status'] = "Pending";
    $order['currency_sign'] = $curr->sign;
    $order['currency_value'] = $curr->value;
    $order['shipping_cost'] = $request->shipping_cost;
    $order['packing_cost'] = $request->packing_cost;
    $order['tax'] = $request->tax;
    $order['dp'] = $request->dp;
    $order['vendor_shipping_id'] = $request->vendor_shipping_id;
    $order['vendor_packing_id'] = $request->vendor_packing_id;



    if($order['dp'] == 1)
    {
        $order['status'] = 'completed';
    }

    if (Session::has('affilate'))
    {
        $val = $request->total / 100;
        $sub = $val * $settings->affilate_charge;
        $user = User::findOrFail(Session::get('affilate'));
        $user->affilate_income += $sub;
        $user->update();
        $order['affilate_user'] = $user->name;
        $order['affilate_charge'] = $sub;
    }
    $order->save();

    if($order->dp == 1){
        $track = new OrderTrack;
        $track->title = 'Completed';
        $track->text = 'Your order has completed successfully.';
        $track->order_id = $order->id;
        $track->save();
    }
    else {
        $track = new OrderTrack;
        $track->title = 'Pending';
        $track->text = 'You have successfully placed your order.';
        $track->order_id = $order->id;
        $track->save();
    }


    $notification = new Notification;
    $notification->order_id = $order->id;
    $notification->save();
    if($request->coupon_id != "")
    {
     $coupon = Coupon::findOrFail($request->coupon_id);
     $coupon->used++;
     if($coupon->times != null)
     {
        $i = (int)$coupon->times;
        $i--;
        $coupon->times = (string)$i;
    }
    $coupon->update();

}

$notf = null;

foreach($cart->items as $prod)
{
    if($prod['item']['user_id'] != 0)
    {
        $vorder =  new VendorOrder;
        $vorder->order_id = $order->id;
        $vorder->user_id = $prod['item']['user_id'];
        $notf[] = $prod['item']['user_id'];
        $vorder->qty = $prod['qty'];
        $vorder->price = $prod['price'];
        $vorder->order_number = $order->order_number;
        $vorder->save();
    }

}

if(!empty($notf))
{
    $users = array_unique($notf);
    foreach ($users as $user) {
        $notification = new UserNotification;
        $notification->user_id = $user;
        $notification->order_number = $order->order_number;
        $notification->save();
    }
}

                    /*$gs = Generalsetting::find(1);

                    //Sending Email To Buyer

                    if($gs->is_smtp == 1)
                    {
                    $data = [
                        'to' => $request->email,
                        'type' => "new_order",
                        'cname' => $request->name,
                        'oamount' => "",
                        'aname' => "",
                        'aemail' => "",
                        'wtitle' => "",
                        'onumber' => $order->order_number,
                    ];

                    $mailer = new GeniusMailer();
                    $mailer->sendAutoOrderMail($data,$order->id);
                    }
                    else
                    {
                    $to = $request->email;
                    $subject = "Your Order Placed!!";
                    $msg = "Hello ".$request->name."!\nYou have placed a new order.\nYour order number is ".$order->order_number.".Please wait for your delivery. \nThank you.";
                        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                    mail($to,$subject,$msg,$headers);
                    }
                    //Sending Email To Admin
                    if($gs->is_smtp == 1)
                    {
                        $data = [
                            'to' => Pagesetting::find(1)->contact_email,
                            'subject' => "New Order Recieved!!",
                            'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
                        ];

                        $mailer = new GeniusMailer();
                        $mailer->sendCustomMail($data);
                    }
                    else
                    {
                    $to = Pagesetting::find(1)->contact_email;
                    $subject = "New Order Recieved!!";
                    $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$order->order_number.".Please login to your panel to check. \nThank you.";
                        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                    mail($to,$subject,$msg,$headers);
                }*/



                Session::put('temporder',$order);
                Session::put('tempcart',$cart);

                Session::forget('cart');

                Session::forget('already');
                Session::forget('coupon');
                Session::forget('coupon_total');
                Session::forget('coupon_total1');
                Session::forget('coupon_percentage');

                  //  return redirect($success_url);

                $data_for_request = $this->handlePaytmRequest( $item_number, $item_amount );
                $paytm_txn_url = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
       //$paytm_txn_url = 'https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
                $paramList = $data_for_request['paramList'];
                $checkSum = $data_for_request['checkSum'];
                return view( 'front.ccavenue-merchant-form', compact( 'paytm_txn_url', 'paramList', 'checkSum' ) );
            }

            public function handlePaytmRequest( $order_id, $amount ) {
                $gs = Generalsetting::first();
                $od = Order::where( 'order_number', $order_id )->first();
        // Load all functions of encdec_paytm.php and config-paytm.php
                $this->getAllEncdecFunc();
        // $this->getConfigPaytmSettings();
                $checkSum = "";
                $paramList = array();
        // Create an array having all required parameters for creating checksum.
                $paramList["tid"] = '';
                $paramList["merchant_id"] = $gs->ccavenue_merchant;
                $paramList["order_id"] = $order_id;
                $paramList["billing_name"] = $od->customer_name;
                $paramList['billing_email'] = $od->customer_email;
                $paramList['billing_tel'] = $od->customer_phone;
                $paramList['billing_address'] = $od->customer_address;
                $paramList['billing_country'] = $od->customer_country;
                $paramList['billing_state'] = $od->customer_state;
                $paramList['billing_city'] = $od->customer_city;
                $paramList['billing_zip'] = $od->customer_zip;
                $paramList["currency"] = 'INR';
                $paramList["amount"] = $amount;
                $paramList["redirect_url"] = route('ccavenue.notify');
                $paramList["cancel_url"] = route('ccavenue.notify');
                $paramList["language"] = 'EN';
                $ccavenue_merchant_key = $gs->ccavenue_secret;
        //Here checksum string will return by getChecksumFromArray() function.
                $checkSum = getChecksumFromArray( $paramList, $ccavenue_merchant_key );
                return array(
                 'checkSum' => $checkSum,
                 'paramList' => $paramList
             );
            }


            function getAllEncdecFunc() {

               function encrypt_e($input, $ky) {
                 $key   = hextobin(md5($ky));;
                 $iv = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
                 $openMode = openssl_encrypt ( $input , "AES-128-CBC" , $key, OPENSSL_RAW_DATA, $iv );
                 $data = bin2hex($openMode);
                 return $data;
             }
             function decrypt_e($crypt, $ky) {
                 $key   = hextobin(md5($ky));
                 $iv = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
                 $encryptedText = hextobin($data);
                 $data = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                 return $data;
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

         function pkcs5_pad_e($text, $blocksize) {
             $pad = $blocksize - (strlen($text) % $blocksize);
             return $text . str_repeat(chr($pad), $pad);
         }
         function pkcs5_unpad_e($text) {
             $pad = ord($text(strlen($text) - 1));
             if ($pad > strlen($text))
                return false;
            return substr($text, 0, -1 * $pad);
        }
        function generateSalt_e($length) {
         $random = "";
         srand((double) microtime() * 1000000);
         $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
         $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
         $data .= "0FGH45OP89";
         for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $random;
    }
    function checkString_e($value) {
     if ($value == 'null')
        $value = '';
    return $value;
}
function getChecksumFromArray($arrayList, $key, $sort=1) {
 if ($sort != 0) {
    ksort($arrayList);
}
$str = getArray2Str($arrayList);
$salt = generateSalt_e(4);
$finalString = $str . "|" . $salt;
$hash = hash("sha256", $finalString);
$hashString = $hash . $salt;
$checksum = encrypt_e($hashString, $key);
return $checksum;
}
function getChecksumFromString($str, $key) {
 $salt = generateSalt_e(4);
 $finalString = $str . "|" . $salt;
 $hash = hash("sha256", $finalString);
 $hashString = $hash . $salt;
 $checksum = encrypt_e($hashString, $key);
 return $checksum;
}
function verifychecksum_e($arrayList, $key, $checksumvalue) {
 $arrayList = removeCheckSumParam($arrayList);
 ksort($arrayList);
 $str = getArray2StrForVerify($arrayList);
 $paytm_hash = decrypt_e($checksumvalue, $key);
 $salt = substr($paytm_hash, -4);
 $finalString = $str . "|" . $salt;
 $website_hash = hash("sha256", $finalString);
 $website_hash .= $salt;
 $validFlag = "FALSE";
 if ($website_hash == $paytm_hash) {
    $validFlag = "TRUE";
} else {
    $validFlag = "FALSE";
}
return $validFlag;
}
function verifychecksum_eFromStr($str, $key, $checksumvalue) {
 $paytm_hash = decrypt_e($checksumvalue, $key);
 $salt = substr($paytm_hash, -4);
 $finalString = $str . "|" . $salt;
 $website_hash = hash("sha256", $finalString);
 $website_hash .= $salt;
 $validFlag = "FALSE";
 if ($website_hash == $paytm_hash) {
    $validFlag = "TRUE";
} else {
    $validFlag = "FALSE";
}
return $validFlag;
}
function getArray2Str($arrayList) {
 $findme   = 'REFUND';
 $findmepipe = '|';
 $paramStr = "";
 $flag = 1;
 foreach ($arrayList as $key => $value) {
    $pos = strpos($value, $findme);
    $pospipe = strpos($value, $findmepipe);
    if ($pos !== false || $pospipe !== false)
    {
       continue;
   }
   if ($flag) {
       $paramStr .= checkString_e($value);
       $flag = 0;
   } else {
       $paramStr .= "|" . checkString_e($value);
   }
}
return $paramStr;
}
function getArray2StrForVerify($arrayList) {
 $paramStr = "";
 $flag = 1;
 foreach ($arrayList as $key => $value) {
    if ($flag) {
       $paramStr .= checkString_e($value);
       $flag = 0;
   } else {
       $paramStr .= "|" . checkString_e($value);
   }
}
return $paramStr;
}
function redirect2PG($paramList, $key) {
 $hashString = getchecksumFromArray($paramList, $key);
 $checksum = encrypt_e($hashString, $key);
}
function removeCheckSumParam($arrayList) {
 if (isset($arrayList["CHECKSUMHASH"])) {
    unset($arrayList["CHECKSUMHASH"]);
}
return $arrayList;
}
function getTxnStatus($requestParamList) {
 return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
}
function getTxnStatusNew($requestParamList) {
 return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
}
function initiateTxnRefund($requestParamList) {
 $CHECKSUM = getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
 $requestParamList["CHECKSUM"] = $CHECKSUM;
 return callAPI(PAYTM_REFUND_URL, $requestParamList);
}
function callAPI($apiURL, $requestParamList) {
 $jsonResponse = "";
 $responseParamList = array();
 $JsonData =json_encode($requestParamList);
 $postData = 'JsonData='.urlencode($JsonData);
 $ch = curl_init($apiURL);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   'Content-Type: application/json',
   'Content-Length: ' . strlen($postData))
);
 $jsonResponse = curl_exec($ch);
 $responseParamList = json_decode($jsonResponse,true);
 return $responseParamList;
}
function callNewAPI($apiURL, $requestParamList) {
 $jsonResponse = "";
 $responseParamList = array();
 $JsonData =json_encode($requestParamList);
 $postData = 'JsonData='.urlencode($JsonData);
 $ch = curl_init($apiURL);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   'Content-Type: application/json',
   'Content-Length: ' . strlen($postData))
);
 $jsonResponse = curl_exec($ch);
 $responseParamList = json_decode($jsonResponse,true);
 return $responseParamList;
}
function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
 if ($sort != 0) {
    ksort($arrayList);
}
$str = getRefundArray2Str($arrayList);
$salt = generateSalt_e(4);
$finalString = $str . "|" . $salt;
$hash = hash("sha256", $finalString);
$hashString = $hash . $salt;
$checksum = encrypt_e($hashString, $key);
return $checksum;
}
function getRefundArray2Str($arrayList) {
 $findmepipe = '|';
 $paramStr = "";
 $flag = 1;
 foreach ($arrayList as $key => $value) {
    $pospipe = strpos($value, $findmepipe);
    if ($pospipe !== false)
    {
       continue;
   }
   if ($flag) {
       $paramStr .= checkString_e($value);
       $flag = 0;
   } else {
       $paramStr .= "|" . checkString_e($value);
   }
}
return $paramStr;
}
function callRefundAPI($refundApiURL, $requestParamList) {
 $jsonResponse = "";
 $responseParamList = array();
 $JsonData =json_encode($requestParamList);
 $postData = 'JsonData='.urlencode($JsonData);
 $ch = curl_init($apiURL);
 curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($ch, CURLOPT_URL, $refundApiURL);
 curl_setopt($ch, CURLOPT_POST, true);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $headers = array();
 $headers[] = 'Content-Type: application/json';
 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 $jsonResponse = curl_exec($ch);
 $responseParamList = json_decode($jsonResponse,true);
 return $responseParamList;
}
}
    /**
     * Config Paytm Settings from config_paytm.php file of paytm kit
     */
    function getConfigPaytmSettings() {
        $gs = Generalsetting::first();

        if ($gs->paytm_mode == 'sandbox') {
          define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
      } elseif ($gs->paytm_mode == 'live') {
          define('PAYTM_ENVIRONMENT', 'PROD'); // PROD
      }

        define('PAYTM_MERCHANT_KEY', $gs->paytm_secret); //Change this constant's value with Merchant key downloaded from portal
        define('PAYTM_MERCHANT_MID', $gs->paytm_merchant); //Change this constant's value with MID (Merchant ID) received from Paytm
        define('PAYTM_MERCHANT_WEBSITE', $gs->paytm_website); //Change this constant's value with Website name received from Paytm
        $PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
        $PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
        if (PAYTM_ENVIRONMENT == 'PROD') {
            $PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
            $PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
        }
        define('PAYTM_REFUND_URL', '');
        define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
        define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
        define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
    }

    public function ccavenueCallback( Request $request ) {


       function ccencrypt($plainText,$key)
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
function ccdecrypt($encryptedText,$key)
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

          $workingKey='54E01AF1D7382A1CBD60680B56D6EA36';       //Working Key should be provided here.
          $encResponse=$_POST["encResp"];           //This is the response sent by the CCAvenue Server
            $rcvdString=ccdecrypt($encResponse,$workingKey);        //Crypto Decryption used as per the specified working key.
            $order_status="";
            $decryptValues=explode('&', $rcvdString);
            $dataSize=sizeof($decryptValues);

   



            for($i = 0; $i < $dataSize; $i++) 
            {
              $information=explode('=',$decryptValues[$i]);
              if($i==3) $order_status=$information[1];
          }


          for($i = 0; $i < $dataSize; $i++) 
          {
              $information=explode('=',$decryptValues[$i]);
              if($i==0) $orderid=$information[1];
          }

          for($i = 0; $i < $dataSize; $i++) 
          {
              $information=explode('=',$decryptValues[$i]);
              if($i==1) $txnid=$information[1];
          }

          for($i = 0; $i < $dataSize; $i++) 
          {
              $information=explode('=',$decryptValues[$i]);
              if($i==5) $paymode=$information[1];
          }

          for($i = 0; $i < $dataSize; $i++) 
          {
              $information=explode('=',$decryptValues[$i]);
              if($i==6) $cardname=$information[1];
          }



          if ($order_status==="Success") {

              $gs = Generalsetting::find(1);
              $transaction_id = $txnid;

              $order_id = $orderid;

              $paymodes = $paymode;
              $cardnames = $cardname;



              $order = Order::where( 'order_number', $order_id )->first();
if (isset($order)) {
                $data['txnid'] = $transaction_id;
                $data['payment_status'] = 'Completed';
                if($order->dp == 1)
                {
                    $data['status'] = 'completed';
                }else{
                   $data['status'] = 'processing';
               }
               $order->update($data);
               $Cart_data = Session::get('cart');
               $cart = new Cart($Cart_data);

         
$notification = new Notification;
$notification->order_id = $order->id;
$notification->save();

Session::put('temporder_id',$order);
//Session::forget('cart');

}

 $cartitems = unserialize(bzdecompress(utf8_decode($order['cart'])));

foreach($cartitems->items as $key => $prod) {
    $name = $prod['item']['name'];
    $sku = $prod['item']['sku'];
    $qty = $prod['qty'];
    $price = $prod['price'];
} 

if ($order->shipping_name == ""){
  $shippingname = $order->customer_name;
  $shippingaddress = $order->customer_address;
  $shippingemail = $order->customer_email;
} else{
  $shippingname = $order->shipping_name;
  $shippingaddress = $order->shipping_address;
  $shippingemail = $order->shipping_email;
}



$items = array (
    "name"=> $name,
    "sku"=> $sku,
    "units"=> $qty,
    "selling_price"=> $price,
    "discount"=> "",
    "tax"=> "",
    "hsn"=> 10029000
);

$data = array(
                "order_id"=> 'REV0030'.$order->id,
                "order_date"=> $order->created_at,
                "pickup_location"=> "Primary",
                "channel_id"=> "",
                "comment"=> $order->order_note,
                "billing_customer_name"=> $order->customer_name,
                "billing_last_name"=> "",
                "billing_address"=> $order->customer_address,
                "billing_address_2"=> "",
                "billing_city"=> $order->customer_city,
                "billing_pincode"=> $order->customer_zip,
                "billing_state"=> $order->customer_city,
                "billing_country"=> $order->customer_country,
                "billing_email"=> $order->customer_email,
                "billing_phone"=> $order->customer_phone,
                "shipping_customer_name"=> $shippingname,
                "shipping_last_name"=> "",
                "shipping_address"=> $shippingaddress,
                "shipping_address_2"=> "",
                "shipping_city"=> $order->shipping_city,
                "shipping_pincode"=> $order->shipping_zip,
                "shipping_country"=> $order->shipping_country,
                "shipping_state"=> "",
                "shipping_email"=> $shippingemail,
                "shipping_phone"=> $order->shipping_phone,
                "order_items"=> [$items],
                "payment_method"=> "Prepaid",
                "shipping_charges"=> $order->shipping_cost,
                "giftwrap_charges"=> $order->packing_cost,
                "transaction_charges"=> 0,
                "total_discount"=> 0,
                "sub_total"=> $order->pay_amount,
                "length"=> 10,
                "breadth"=> 15,
                "height"=> 20,
                "weight"=> 2.5
);
if ($order->shipping_name == ""){
      $data['shipping_is_billing'] = true;
} else{
  $data['shipping_is_billing'] = false;
}

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/orders/create/adhoc',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjM0MzU3NTksImlzcyI6Imh0dHBzOi8vYXBpdjIuc2hpcHJvY2tldC5pbi92MS9leHRlcm5hbC9hdXRoL2xvZ2luIiwiaWF0IjoxNjgwNDEyNzUwLCJleHAiOjE2ODEyNzY3NTAsIm5iZiI6MTY4MDQxMjc1MCwianRpIjoiekd2UDhERUR1TDRWZmpzMiJ9.iSGvLA5QH4RtiyaNXXTX6X3V7zWoTCLjUB8JBRnyodQ'
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            echo $response;die;
return redirect()->route('payment.return');

} else if( 'Failure' === $request['STATUS'] ){
            //return view( 'payment-failed' );

    return redirect(route('payment.cancle'));
}
}
}