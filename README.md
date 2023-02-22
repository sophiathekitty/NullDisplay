# Null Display

 a micro display using a raspberry pi zero and mini PiTFT hat. testing out pulling this to the pi so maybe i can have them do automatic pulls...

## Hardware

* all in one package for hardware: [Mini Color PiTFT Ad Blocking Pi-Hole Kit - No Soldering!](https://www.adafruit.com/product/4475)
* raspberry pi zero wh: [Raspberry Pi Zero WH (Zero W with Headers)](https://www.adafruit.com/product/3708)
* micro display: [Adafruit Mini PiTFT - 135x240 Color TFT Add-on for Raspberry Pi](https://www.adafruit.com/product/4393)

### Setup Mini PiTFT all in one mega command of doom

this is going to be very slow and scary. just let it do its thing. the adafruit-circuitpython-rgb-dislay is the scariest and just kinda hangs. but it's ok. it's installing

```bash
sudo apt-get install python3-pip -y && sudo pip3 install adafruit-circuitpython-rgb-display && sudo pip3 install --upgrade --force-reinstall spidev && sudo apt-get install ttf-dejavu -y && sudo apt-get install python3-pil -y && sudo apt-get install python3-numpy -y
```

### Setup Mini PiTFT individual steps

the adafruit-circuitpython-rgb-dislay is the scariest and just kinda hangs. but it's ok. it's installing. also make sure to turn on the spi interface in the raspi-config

```bash
sudo apt-get install python3-pip -y
```

```bash
sudo pip3 install adafruit-circuitpython-rgb-display
```

```bash
sudo pip3 install --upgrade --force-reinstall spidev 
```

```bash
sudo apt-get install ttf-dejavu -y
```

```bash
sudo apt-get install python3-pil -y
```

```bash
sudo apt-get install python3-numpy -y
```

```bash
sudo pip3 install colour
```

see [adafruit](https://learn.adafruit.com/adafruit-mini-pitft-135x240-color-tft-add-on-for-raspberry-pi/python-setup) for examples and documentation of mini pitft

### Setup for eInk display

```bash
curl https://get.pimoroni.com/inkyphat | bash
```

see [inky-phat](https://github.com/pimoroni/inky-phat) for examples and documentation of inky phat

## Cron Jobs

```bash
sudo crontab -e
```

```Apache config
2 * * * * sh /var/www/html/plugins/NullDisplay/gitpull.sh
```

### mini pitft cron job

```bash
crontab -e
```

```Apache config
@reboot sudo sh /var/www/html/python/pitft/screen.sh
```

### eInk python cron job

```bash
crontab -e
```

```Apache config
* * * * * sh /var/www/html/python/eInk/refresh.sh
```

## Plugins

* required for weather data: [NullWeather](https://github.com/sophiathekitty/NullWeather)
* required for room temperature data: [NullSensors](https://github.com/sophiathekitty/NullSensors)

## Extensions

* required for eInk display: [MealPlanner](https://github.com/sophiathekitty/MealPlanner)

## Tools

* [favicon generator](https://www.favicon-generator.org/)
* icons made with [open source icons](https://game-icons.net/)
