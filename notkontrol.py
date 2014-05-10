#!/usr/bin/python

import sys
import os
import pynotify
import urllib2

def GiveNotification(mesaj):
   if os.name == "posix":
       if __name__ == "__main__":
            if not pynotify.init("icon-summary-body"):
                sys.exit(1)

            n = pynotify.Notification("Sinav Sonuc Kontrolu",mesaj,"notification-message-im")
            n.show()

s = urllib2.urlopen("http://cloud.guvenatbakan.com/esogu/not.php").read(1000)
if s == "true":
    GiveNotification("Bir sinav sonucu aciklanmis gibi duruyor!!11!1")
else:
    GiveNotification("Sinav sonuclarinda degisiklik yok")


