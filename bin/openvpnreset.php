<?php

exec("sh /var/www/bin/openvpnreset.sh",$out);

echo implode("\n Your server has been reset to default"); 


?>