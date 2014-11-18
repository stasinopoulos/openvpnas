#!/bin/bash
sudo /usr/local/openvpn_as/bin/ovpn-init < /var/www/bin/ovpn_settings
sudo passwd openvpn < /var/www/bin/ovpn_pass
echo "The server has been reset to original setup" > /tmp/reset
date >> /tmp/reset


