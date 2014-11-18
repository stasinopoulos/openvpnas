<!DOCTYPE html>
<html><head><meta charset='UTF-8'>
<title>[OpenVPN] Server</title><link rel='stylesheet' type='text/css' href='sabai.css'>
<script type='text/javascript' src='jquery-1.11.1.min.js'></script>
<script type='text/javascript' src='jquery.validate.min.js'></script>
<script type='text/javascript' src='sabaivpn.js'></script>
<script type="text/javascript">
var hidden, hide, settingsForm, settingsWindow, oldip='',limit=10,info=null,ini=false;
init();

function Settingsresp(res){ 
	settingsWindow.innerHTML = res;
	eval(res); 
	msg(res.msg); 
	showUi(); 
	console.log('Hid the update message')
}

function openvpn(act){ 
	hideUi("Processing Request..."); 
	settingsForm.act.value=act; 
	que.drop("bin/openvpnreset.php",Settingsresp, $("#_fom").serialize() ); 
	setTimeout("window.location.reload()",60000);
}

function DNSupdate() {
	console.log('you clicked update')
	hideUi("Updating DNS..."); 
	que.drop("bin/dns.php",Settingsresp, $("#_fom").serialize() );

}

function DNSset() {
	<?php
  if ($dns = file('/var/www/stat/dns')) {
  echo "primary =  '";
  echo trim($dns[0]);
  echo "';\nsecondary = '" . trim($dns[1]) . "';\n";
	}
	?> 	

	typeof primary === 'undefined' || $('#primaryDNS').val(primary)		
	typeof secondary === 'undefined' || $('#secDNS').val(secondary)
}

function init(){ 
   $( function() {
   	<?php exec("sh /var/www/bin/ipaddr.sh"); 
   		$intipaddr = file_get_contents('/var/www/stat/intipaddr');  
   		$asipaddr = file_get_contents('/var/www/stat/asipaddr');  
   		$extipaddr = file_get_contents('/var/www/stat/extipaddr');
   		echo "$( '#intipaddr' ).text( '$intipaddr' ); \n  ";
   		echo "$( '#asipaddr' ).text( '$asipaddr' ); \n  ";
   		echo "$( '#extipaddr' ).text( '$extipaddr' ); \n  ";
   		echo "$( '#extipaddrtwo' ).text( '$extipaddr' ); \n  ";
   		echo "$('a#admin').prop('href', 'https://$intipaddr:943/admin') \n";
   		echo "$('a#user').prop('href', 'https://$intipaddr:943') \n";  ?>
	f = $('#_fom'); 
	hidden = E('hideme'); 
	hide = E('hiddentext'); 
	settingsForm = E('_fom');
	settingsWindow = E('response');
	$('.active').removeClass('active')
	$('#openvpn').addClass('active')
	DNSset();

     $.validator.addMethod('IP4Checker', function(value) {
       var ip = /^(25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[0-9]{2}|[0-9])(\.(25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[0-9]{2}|[0-9])){3}$/;
       if (value.match(ip)) {
	 E('updateDNS').disabled = false;
	 return true;
       }
       else {
	 E('updateDNS').disabled = true;
	 return false;
       }
     }, 'DNS server must be valid IP');

     $('#_fom').validate({
       rules: {
	 primaryDNS: {
	   required: true,
	   IP4Checker: true
	 },
	 secDNS: {
	   IP4Checker: true
	 }
       }
     });
});}

</script>

<body onload='init();' id='topmost'>
		<table id='container' cellspacing=0>
			<tr id='body'>    
				<td id='navi'>
          <script type='text/javascript'>navi()</script>
        </td>

        <td id='content'>
        	<div class="pageTitle">OpenVPN</div>
        	<form id='_fom' method='post'>
        	<input type='hidden' id='_act' name='act' value='reboot'>
					<div id='vpnstats'></div>
					<div id='dhcpLease' class=''>
						<div class='section-title'>Administration / Client</div>
						<div class='section'>
						<p>Recommended server Hostname is your Dynamic DNS address or this ip address:  <span id='extipaddr' class='highlight'></span>
						<p> The OpenVPN server can be setup here: <a href='https://192.168.199.2:943/admin' id='admin' target="_blank">Administration</a>
						<p> The OpenVPN client account is here: <a href='https://192.168.199.2:943' id='user' target="_blank">Client</a>
						</div>
					</div>
					<div class='section-title'>Instructions</div>
						<div class='section'>
						<p>To setup your server (only need to do once unless you've reset the server):
						<ol>
  							<li>Click Administration in this page (prior section).</li>
  							<li>Choose the Configuration / Server Network Settings Menu Link</li>
  							<li>Replace the Hostname with <span id='extipaddrtwo' class='highlight'></span> and save.</li>
  							<li>Choose the User Management / User Permissions Menu Link</li>
  							<li>Check "Allow Auto-Login" under the openvpn user and save settings.</li>
  							<li>Click the "Update Running Server" button</li>
						</ol>
						<p>That's it for the basic setup!
						</div>
					</div>
					<div id='onOff' class=''>
						<div class='section-title'>Reset</div>
						<div class='section'>
							<input type='button' name='reset' id='reset' value='Reset the Server Configuration' class='firstButton' onclick='openvpn("reset")'/>
						</div>
					</div>
					<br><b>
					<span id='messages'>&nbsp;</span></b>
					<pre class='noshow' id='response'></pre>
					</form>
				</td>
			</tr>
		</table>
	<div id='footer'> Copyright © 2014 Sabai Technology, LLC </div>
	<div id='hideme'>
		<div class='centercolumncontainer'>
			<div class='middlecontainer'>
				<div id='hiddentext'>Please wait...</div>
				<br>
				<center>
				<img src='images/menuHeader.gif'>
				</center>
			</div>
		</div>
	</div>
</body>
</html>
