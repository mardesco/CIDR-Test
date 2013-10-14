<?php
//cidr_test.php
/*
This simple tool tests whether a given IPv4 address is within a specified CIDR network range.

@package cidr_test
@author Jesse Smith for Mardesco, with help!
@license Triple-licensed under MIT/GPL/"nobody cares"
@version 0.0.2
@TODO Add an input form, so the user won't have to edit the source code every time they want to use the tool.
@TODO Make the function IPv6 compatible.
*/
?>
<!doctype html>
<html>
<head>
	<title>CIDR Test</title>
</head>
<body>
<h1>CIDR Test</h1>
<?php

// enter the IP you are checking:
$ipToTest = '127.0.0.1';
// enter the CIDR you are testing it against:
$cidrToTest = '127.0.0.0/8';


// the crucial logic is courtesy of user "claudiu at cnix dot com"
// who posted it to the comments in the PHP manual for network functions:
// http://php.net/manual/en/ref.network.php

  function ipCIDRCheck ($IP, $CIDR) {
    list ($net, $mask) = explode ("/", $CIDR);
    
    $ip_net = ip2long ($net);
    $ip_mask = ~((1 << (32 - $mask)) - 1);

    $ip_ip = ip2long ($IP);

    $ip_ip_net = $ip_ip & $ip_mask;

    return ($ip_ip_net == $ip_net);
  }


echo "<p>Is $ipToTest in $cidrToTest?</p>";

$found = ipCIDRCheck ($ipToTest, $cidrToTest); 

echo $found ?  '<p>Yes, it is.</p>' : '<p>No, it&#039;s not.</p>';

?>
</body>
</html>
