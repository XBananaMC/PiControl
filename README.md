PiControl
=========

A web page to control XBMC and Transmission in Raspbmc.

Installation 
============

Lines folowed by # are console commands

1. Download the installer and install: http://www.raspbmc.com/download/

2. Install Apache by SSH:

        # sudo apt-get update
        # sudo apt-get install apache2 php5 libapache2-mod-php5
        
2. Change Apache permissions:

        # nano /etc/apache2/envvars
        Change:	export APACHE_RUN_USER=www-data	to: export APACHE_RUN_USER=pi
        	    export APACHE_RUN_GROUP=www-data    export APACHE_RUN_GROUP=pi
        ctrl+x then y to save
        # sudo service apache2 restart

4. Install Transmission
	
		# sudo apt-get install transmission-daemon
		# sudo /etc/init.d/transmission-daemon stop
		# sudo nano /etc/transmission-daemon/settings.json
		Change: 	"rpc-whitelist”: “127.0.0.1"		to:	“rpc-whitelist”: “*.*.*.*”,
				“rpc-password”: “password” 				“rpc-password”: “yourpassword“
				“rpc-username”: “username” 				“rpc-username”: “yourusername“
				“download-dir”:	"somefolder"			“download-dir”: "yourfolder"
		ctrl+x then y to save
		# sudo chmod g+rw yourfolder
		# sudo chgrp -R debian-transmission yourfolder
		# sudo /etc/init.d/transmission-daemon start
5. Add script to start up:  move mystartup.sh to /etc/init.d
		# chmod +x /etc/init.d/mystartup.sh
		# update-rc.d mystartup.sh defaults 100

Disclamer
=========

Step 2 make your RaspberryPi vulnerable, if you intent to use it in public create another more restricted user.
