#!/bin/bash

if [ $(ifconfig | grep as0t0 | awk '{print $1}') != "" ]; then
		echo -n "Server Running" > /var/www/stat/server.connected;
	else
		rm /var/www/stat/server.connected;
	fi
