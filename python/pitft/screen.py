import digitalio
import board

import urllib.request
import json

from adafruit_rgb_display.rgb import color565
import adafruit_rgb_display.st7789 as st7789
from PIL import Image, ImageDraw, ImageFont

from Clock import Clock
from Weather import Weather
from Slideshow import Slideshow
from Stoner import Stoner
from Tasks import Tasks


# Configuration for CS and DC pins for Raspberry Pi
cs_pin = digitalio.DigitalInOut(board.CE0)
dc_pin = digitalio.DigitalInOut(board.D25)
reset_pin = None
BAUDRATE = 64000000  # The pi can be very fast!
# Create the ST7789 display:
display = st7789.ST7789(
    board.SPI(),
    cs=cs_pin,
    dc=dc_pin,
    rst=reset_pin,
    baudrate=BAUDRATE,
    width=135,
    height=240,
    x_offset=53,
    y_offset=40,
)
im = Image.open("/var/www/html/plugins/NullDisplay/img/pitft/null.jpg")
display.image(im,90)

# setup backlight
backlight = digitalio.DigitalInOut(board.D22)
backlight.switch_to_output()
backlight.value = True
buttonA = digitalio.DigitalInOut(board.D23)
buttonB = digitalio.DigitalInOut(board.D24)
buttonA.switch_to_input()
buttonB.switch_to_input()

display_index = 0
display_switch = 10

top_btn = False
bottom_btn = False
menu_btn = False

top_saved = False
bottom_saved = False

#font = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf", 24)
#font_weather = ImageFont.truetype("/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf", 82)

slides = Slideshow()
slides.LoadSlides()
stoner = Stoner()
tasks = Tasks()
reset_delay = 10
print(slides.running)
# Main loop:
while slides.running:
    #display the image on the screen
    if(stoner.StonerTime() > 0):
        display.image(stoner.Draw(),90)
        backlight.value = True  # turn on backlight
    elif(tasks.HasTasks() and not slides.Snoozed()):
        display.image(tasks.Draw(),90)
        backlight.value = True  # turn on backlight
    elif(slides.Snoozed()):
        slides.Load()
        if(backlight.value):
            slides.LoadSlides()
        backlight.value = False
    else:
        #print("Draw slide {} . {}".format(slides.index,slides.slide_index))
        display.image(slides.Draw(),90)
        backlight.value = True  # turn on backlight
    # handle button inputs
    top_btn = False
    bottom_btn = False
    if not buttonA.value and not buttonB.value:
        menu_btn = True
        reset_delay -= 1
        #print("both buttons pressed? {} | {}".format(buttonA.value,buttonB.value))
        if(reset_delay == 0):
            print("menu button reset")
            slides.running = False
    else:
        menu_btn = False
        reset_delay = 10
    if buttonB.value and not buttonA.value:  # just button A pressed
        slides.Wake()
        top_btn = True
        print ("top button pressed?")
    if buttonA.value and not buttonB.value:  # just button B pressed
        bottom_btn = True
        slides.Wake()
        print ("top button pressed?")

    if top_btn != top_saved:
        print("top button state change")
        # save top button state
        btn_val = "Up"
        if top_btn:
            btn_val = "Down"
        with urllib.request.urlopen("http://localhost/api/settings?name=TopButton&value={}".format(btn_val)) as json_url:
            buf = json_url.read()
            data = json.loads(buf.decode('utf-8'))
            top_saved = top_btn
        if not top_btn:
            slides.Next()
            print("button change slide {}.{}".format(slides.index,slides.slide_index))
    #print ("{} != {}".format(bottom_btn,bottom_saved))
    if bottom_btn != bottom_saved:
        print("bottom button state change")
        # save bottom button state
        btn_val = "Up"
        if bottom_btn:
            btn_val = "Down"
        with urllib.request.urlopen("http://localhost/api/settings?name=BottomButton&value={}".format(btn_val)) as json_url:
            buf = json_url.read()
            data = json.loads(buf.decode('utf-8'))
            bottom_saved = bottom_btn
        if not bottom_btn and slides.index < len(slides.slides):
            slides.slides[slides.index].Next()
            print("button change slide {}.{}".format(slides.index,slides.slides[slides.index].index))

im = Image.open("/var/www/html/plugins/NullDisplay/img/pitft/null.jpg")
display.image(im,90)
