# pay by link

example pay by link using adyen HPP flow documented here:

> HPP documentation: https://docs.adyen.com/developers/features/hosted-payment-pages

> Notifications: https://docs.adyen.com/developers/payment-notifications

what actually happens behing the scenes is that an HPP page link gets compiled and sent to a shopper as an email. 
The code of can be found in the php file (PBLindex.php)

*What you need:*
1. Merchant account
2. skin created (check Adyen documentation above)
3. HMAC key (check Adyen documentation above)
4. make sure the customer email/ amount / currency / merchant reference is dynamic and build some logic around it
5. you can setup notifications end point(check Adyen documentation above)to wait for the above payment to be completed and trigger a flow

6. you can also tokenzie the card details if needed by passing a shopperReference and a recurring contract



 **please don't complete the payment in the link below as this is for demo purposes**
 *the link expires after first use.*
 
================

*example email:*
```
---------- Forwarded message ----------
From: Adyen Test <adyen_test@test.com>
To: raymond.afara@adyen.com
Cc: 
Bcc: 
Date: Thu, 26 Oct 2017 13:37:49 -0400 (EDT)
Subject: Your dress from Ray Store
Thanks for being a loyal customer.
<img>
	
Total amount $10.00
Here’s a link to that item you love - and a direct link to pay for it.http://bit.ly/2zSLG3J   

Hope you enjoy it!
```
