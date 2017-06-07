@echo off

title BOINCTasks load hosts

taskkill /F /IM boinctasks64.exe

cd %APPDATA%\eFMer\BOINCTasks

powershell "Invoke-WebRequest -Uri http://BOINCREPORT_SERVER/btxml.php -Method POST -Body @{guipass='GUI_PASS'} -OutFile computers.xml"

rmdir /s /q %APPDATA%\eFMer\BoincTasks\crash
start "" "\Program Files\eFMer\BoincTasks\boinctasks64.exe"
