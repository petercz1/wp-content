#!/bin/bash
# whether to use SHIFT+CTRL+R to force reload without cache
RELOAD_KEYS="CTRL+R"
#RELOAD_KEYS="SHIFT+CTRL+R"
# set to whatever's given as argument
BROWSER=$1
# if was empty, default set to name of browser, firefox/chrome/opera/etc..
if [ -z "${BROWSER}" ]; then
    BROWSER=firefox
fi
# get which window is active right now
MYWINDOW=$(xdotool getactivewindow)
# bring up the browser
xdotool search --desktop 0 --class ${BROWSER} windowactivate --sync
# send the page-reload keys (C-R) or (S-C-R)
xdotool search --desktop 0 --class ${BROWSER} key --clearmodifiers ${RELOAD_KEYS}
# sometimes the focus doesn't work, so follow up with activate
xdotool windowfocus --sync ${MYWINDOW}
xdotool windowactivate --sync ${MYWINDOW}
