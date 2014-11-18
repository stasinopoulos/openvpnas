#!/bin/bash
sh /var/www/stat/clear.sh
ifconfig eth0 > /var/www/stat/ifconf
wget sabaitechnology.biz/sabai/donde.php?plz=kthx -O /var/www/stat/ip
extipaddr=$(cat /var/www/stat/ip | awk '{match($0,/[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/); ip = substr($0,RSTART,RLENGTH); print ip}')
asipaddr=$(cat /usr/local/openvpn_as/etc/config.json |grep host.name | awk '{match($0,/[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/); ip = substr($0,RSTART,RLENGTH); print ip}')
intipaddr=$(ip addr show eth0 | awk '$1 == "inet" {gsub(/\/.*$/, "", $2); print $2}')
echo -n $extipaddr > /var/www/stat/extipaddr
echo -n $asipaddr > /var/www/stat/asipaddr
echo -n $intipaddr > /var/www/stat/intipaddr
echo -n "yes" > /var/www/stat/ipaddrdone



