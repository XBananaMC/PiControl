#!/bin/bash
echo "Custom script"
sudo mkdir /var/log/apache2
sudo service apache2 start
sudo /etc/init.d/transmission-daemon stop
