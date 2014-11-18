<?php
header('Content-Type: application/javascript');
exec("checkserv.sh");
 exec("/sbin/ifconfig eth0 | egrep -o \"HWaddr [A-Fa-f0-9:]*|inet addr:[0-9:.]*|UP BROADCAST RUNNING MULTICAST\"",$out);
$wan = " wan: {
  mac: '". strtoupper(str_replace("HWaddr ","", ( array_key_exists(0,$out)? "$out[0]" : "-" ) )) ."',
  ip: '". str_replace("inet addr:","", ( array_key_exists(1,$out)? "$out[1]" : "-" ) ) ."',
  status: '". ( array_key_exists(2,$out)? "Connected" : "-" ) ."' 
},\n";

unset($out);

if (file_exists ("/var/www/stat/server.connected")) {
  $vpn_status = rtrim (file_get_contents ("/var/www/stat/server.connected"));
} else {
  $vpn_status = "Server Stopped";
}

$proxy = " proxy: {
  status: '$proxy_status'
}";

$vpn_type = "OpenVPN-AS";
$vpn = ",\n vpn: {\n type: '". $vpn_type ."',
  status: '$vpn_status'\n },";

//if( (array_key_exists('do',$_REQUEST) && $_REQUEST['do']=='ip') || !file_exists("/var/www/stat/ip")){ exec("php get_remote_ip.php"); }

echo "info = {\n"
.$wan
.$proxy
.$vpn
."\n}";

?>
