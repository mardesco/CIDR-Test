<?php
//cidr_test.php
/*
This simple tool tests whether a given IPv4 address is within a specified CIDR network range.

@package cidr_test
@author Jesse Smith for Mardesco, with help!
@license Triple-licensed under MIT/GPL/"nobody cares"
@version 0.1.1
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

if(isset($_GET['submit'])){

	$options = array(
	'options' => array(
	'default' => 'Invalid input.'
	),
	'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH
	);
	
	if(isset($_GET['ip'])){
		$ipToTest = filter_var($_GET['ip'], FILTER_SANITIZE_STRING, $options);	
	}else{
		die("missing required input.");
	}
	

	if(isset($_GET['cidr'])){
		$cidrToTest = filter_var($_GET['cidr'], FILTER_SANITIZE_STRING, $options);	
	}else{
		die("missing required input.");
	}


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

}

?>

	<form action="" method="get">
	
	<p><label for="ip">Enter the IP address: <input type="text" name="ip" /></label></p>
	
	<p><label for="cidr">Enter the CIDR: <input type="text" name="cidr" /></label></p>	
	
	<p><input type="submit" name="submit" value="Submit" /></p>
	
	</form>

</body>
</html>
