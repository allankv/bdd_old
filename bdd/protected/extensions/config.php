<?php
function showIcon($title, $type, $show) {
    if ($show) {
        echo "<ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='$title'><span class='ui-icon $type'></span></li></ul>";
    }
    else {
        echo "<ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='$title'><span class='ui-icon $type'></span></li></ul>";
    }
}
function getGoogleAPIKey($email, $passwd) {
	$ch = curl_init("https://www.google.com/accounts/ClientLogin");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);	  
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	curl_setopt($ch, CURLOPT_POST, true);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	curl_setopt($ch, CURLOPT_POSTFIELDS, array('accountType' => 'GOOGLE','Email' => $email,'Passwd' => $passwd));  
	  
	$cookies = curl_exec($ch);
	
	curl_close($ch);  
	
	$ch = curl_init("http://code.google.com/apis/maps/signup/createkey?referer=http://".$_SERVER['HTTP_HOST']);   
	curl_setopt($ch, CURLOPT_COOKIE, $cookies);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  
	$key = curl_exec($ch);  
	
	curl_close($ch);
	
	$obj = json_decode($key);
	
	return $obj->{"generated_key"};
}
function getCurrentURL() {
	$url = $_SERVER['REQUEST_URI'];
	
	$url = split('index', $url);
	
	return $url[0];
}
?>
