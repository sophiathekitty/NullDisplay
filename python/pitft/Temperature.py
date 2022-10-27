from PIL import Image, ImageDraw, ImageFont

from ColorLerp import ColorLerp
from TextShadow import TextShadow

import urllib.request
import json

class Temperature:
    def __init__(self):
        self.Load()
        self.text = TextShadow()
        self.color_lerp = ColorLerp()
    def Load(self):
        with urllib.request.urlopen("http://localhost/plugins/NullSensors/api/temperature/room/") as json_url:
            buf = json_url.read()
            data = json.loads(buf.decode('utf-8'))
            if(data['room']['temp'] and data['room']['temp'] != ""):
                self.temp = float(data['room']['temp'])
                self.temp_max = float(data['room']['temp_max'])
                self.temp_min = float(data['room']['temp_min'])
                self.hum = float(data['room']['hum'])
                self.hum_max = float(data['room']['hum_max'])
                self.hum_min = float(data['room']['hum_min'])
        self.buttons = False
        with urllib.request.urlopen("http://localhost/api/settings?name=TopButton&default=Up") as json_url:
            buf = json_url.read()
            data = json.loads(buf.decode('utf-8'))
            if(data == "Down"):
                self.buttons = True
        with urllib.request.urlopen("http://localhost/api/settings?name=BottomButton&default=Up") as json_url:
            buf = json_url.read()
            data = json.loads(buf.decode('utf-8'))
            if(data == "Down"):
                self.buttons = True
    # draw functions
    def Draw(self):
        return self.DrawTemperature()
    def Draw2(self):
        return self.DrawHumidity()
    def Draw3(self):
        return self.DrawTemperature()
    def Draw4(self):
        return self.DrawHumidity()
    def Draw5(self):
        return self.DrawTemperature()
    # temperature display
    def DrawTemperature(self):
        self.Load()
        im_temp = self.TemperatureImage()
        draw_temp = ImageDraw.Draw(im_temp)
        x = 90
        if(self.temp >= 100):
            x = 30
        self.text.DrawBigText(draw_temp,str(round(self.temp))+"°",self.color_lerp.TempColor(self.temp),x,30)
        return im_temp
    # humidity display
    def DrawHumidity(self):
        self.Load()
        im_temp = self.TemperatureImage()
        draw_temp = ImageDraw.Draw(im_temp)
        x = 40
        self.text.DrawBigText(draw_temp,str(round(self.hum))+"%",self.color_lerp.HumColor(self.hum),x,30)
        return im_temp
    # weather icon background image
    def TemperatureImage(self):
        buttons = ""
        if(self.buttons):
            buttons = "_buttons"
        icon_path = "/var/www/html/plugins/NullDisplay/img/pitft/temperature.jpg"
        return Image.open(icon_path)
