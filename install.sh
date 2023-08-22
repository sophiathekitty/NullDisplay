#!/bin/bash

echo "Installing Null Display plugin..."

# Path to the settings.php file
settings_file="/var/www/html/settings.php"

# Check if the file exists
if [[ -f "$settings_file" ]]; then
    # Extract the device type from settings.php
    device_type=$(grep -oP "\['type'\]\s*=\s*'[^']*'" "$settings_file" | sed -E "s/\['type'\]\s*=\s*'([^']*)'/\1/")
    
    # Check the extracted device type
    if [[ $device_type == "display" ]]; then
        echo "Device type is 'display' setting up eInk display"
        # Install plugins and extensions for display type
        curl https://get.pimoroni.com/inkyphat | bash
        new_cron_job="* * * * * sh /var/www/html/python/eInk/refresh.sh"
        # Add the new cron job using crontab command
        (crontab -l ; echo "$new_cron_job") | crontab -
    elif [[ $device_type == "micro display" ]]; then
        echo "Device type is 'micro display' setting up pitft display"
        # Install plugins and extensions for micro display type
        sudo pip3 install adafruit-circuitpython-rgb-display
        sudo pip3 install --upgrade --force-reinstall spidev
        sudo apt-get install ttf-dejavu -y
        sudo apt-get install python3-pil -y
        sudo apt-get install python3-numpy -y
        sudo pip3 install colour
        # Add a new cron job to the user's crontab
        new_cron_job="@reboot sudo sh /var/www/html/python/pitft/screen.sh"
        # Add the new cron job using crontab command
        (crontab -l ; echo "$new_cron_job") | crontab -
    else
        echo "Device type is neither 'display' nor 'micro display' not setting up pi display stuff"
    fi
else
    echo "settings.php file not found"
fi
