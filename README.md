# pay by link

example pay by link using adyen HPP flow documented here:

https://docs.adyen.com/developers/features/hosted-payment-pages

what actually happens behing the scenes is that an HPP page link gets compiled and sent to a shopper as an email. The code of this can be found in the php file


================
example email:
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
