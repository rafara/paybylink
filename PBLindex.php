<?php

	/*$screenname = $_GET['screenname'];
	$realname = $_GET['custname'];
	$destination = $_GET['dest'];
	$start = $_GET['startdate'];
	$startdash = str_replace("/", "-", $start);
	$end = $_GET['enddate'];
	$num = $_GET['price'];
	$cost = number_format($num, 2, '.', '');
	$price = $cost*100;

	$names = explode(" ",$realname);
	$len = sizeof($names);
	$lastname = $names[$len-1];*/
	error_reporting(E_ERROR | E_PARSE);

	$shopperEmail      	= "email@email.com";
	$shopperName 		= "Shopper Name";

	$skinCode 	   		= "SKIN CODE";
	$merchantAccount   	= "MERCHANT ACCOUNT";
	$hmacKey         	= "HMAC KEY";

	$merchantReference  = "Pay by Link - Test Order";

	$paymentAmount      = 1000;
	$currencyCode       = "USD"; 

	$countryCode	    = "US";
	$shopperLocale      = "en_GB"; 
	$shipBeforeDate     = date("Y-m-d"  , mktime(date("H"), date("i"), date("s"), date("m"), date("j"), date("Y")+1)); 
	$sessionValidity    = date(DATE_ATOM, mktime(date("H"), date("i"), date("s"), date("m"), date("j"), date("Y")+1));
	$shopperReference   = ""; 
	$recurringContract  = "ONECLICK";
	$installmentsvalue  = "4";


    
    $params = array(
                    "merchantReference" =>  $merchantReference,
                    "merchantAccount"   =>  $merchantAccount,
                    "currencyCode"      =>  $currencyCode,
                    "paymentAmount"     =>  $paymentAmount,
                    "recurringContract" =>  $recurringContract,
                    "sessionValidity"   =>  $sessionValidity ,
                    "shipBeforeDate"    =>  $shipBeforeDate,
                    "shopperLocale"     =>  $shopperLocale ,
                    "skinCode"          =>  $skinCode,
                    "shopperEmail"      =>  $shopperEmail,
                    "shopperReference"  =>  $shopperReference,
                    "countryCode"		=>  $countryCode,
                    "installments.value" =>  $installmentsvalue
  
    );


    // The character escape function
    $escapeval = function($val) {
        return str_replace(':','\\:',str_replace('\\','\\\\',$val));
    };
    
    // Sort the array by key using SORT_STRING order
    ksort($params, SORT_STRING);
    
    // Generate the signing data string
    $signData = implode(":",array_map($escapeval,array_merge(array_keys($params), array_values($params))));
    
    // base64-encode the binary result of the HMAC computation
    $merchantSig = base64_encode(hash_hmac('sha256',$signData,pack("H*" , $hmacKey),true));

    
    $fields = array(
		'skinCode',
		'merchantAccount',
		'merchantReference',
		'paymentAmount',
		'currencyCode',
		'countryCode',
		'shipBeforeDate',
		'shopperLocale',
		'sessionValidity',
		'shopperEmail',
		'shopperReference',
		'recurringContract',
		'merchantSig'
	);
    
    $querystring = array();
	foreach ($fields as $field) $querystring[] = $field . '=' . urlencode(utf8_encode($$field));



	$hpp_url = 'https://test.adyen.com/hpp/pay.shtml?' . implode ('&', $querystring)  . '&installments.value='.$installmentsvalue ;

 	function get_bitly_short_url($url,$login,$appkey,$format='txt') 
 	{
		$connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
		return curl_get_result($connectURL);
	}
    function curl_get_result($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return trim($data);
    }
        


    $short_url = get_bitly_short_url($hpp_url, 'o_3a6o9opcfd', 'R_790f5fa7e22c48d982d49dec4458aa67');

 
  	// <b>As a courtesy reminder, you have an open invoice with us. Please follow the link below to easily pay your invoice online. For your convenience, we accept [Visa, MasterCard, AMEX, Discover, UnionPay, and PayPal.]</b>
	//		<br><br>
	//<p> Hi ".$shopperName."</p>
    
    $amount = $paymentAmount/100;

    // SEND MAIL
	$subject = "Your dress from our Store";

	$message = "<html>
					<head>
						<title>Your dress from our Store</title>
					</head>
					<body>

						<p>Thanks for being a loyal customer.</p>
						<table>
							<tr>
								<td>
									<img src='http://i1.adis.ws/i/theory/TH_F0001602_RES_S0.jpg'   height='300' />
								</td>
								<td><br> Total amount $".$amount.".00</td>
							</tr>
						</table>
						<p>Here’s a link to that item you love - and a direct link to pay for it." . $short_url . " </p>
						<p>Hope you enjoy it!</p>
					</body>
				</html>
			";

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: Merchant <support@merchant.com>' . "\r\n";

	mail($shopperEmail,$subject,$message,$headers);

    echo "Check your email!  >> ".$shopperEmail; 
  
?>
