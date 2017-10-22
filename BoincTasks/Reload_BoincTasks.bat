@echo off
title BOINCTasks load hosts
@echo on

REM boinc-deployer/BoincTasks: Reload_BoincTasks.bat: loads list of devices from boincReport,
REM                                                   saves it into BoincTasks and restarts BoincTasks
REM Copyright (C) 2017 Tugzrida (github.com/Tugzrida)
REM 
REM This program is free software: you can redistribute it and/or modify
REM it under the terms of the GNU Affero General Public License as published
REM by the Free Software Foundation, either version 3 of the License, or
REM (at your option) any later version.
REM 
REM This program is distributed in the hope that it will be useful,
REM but WITHOUT ANY WARRANTY; without even the implied warranty of
REM MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
REM GNU Affero General Public License for more details.
REM 
REM You should have received a copy of the GNU Affero General Public License
REM along with this program.  If not, see <http://www.gnu.org/licenses/>.

@echo off
taskkill /F /IM boinctasks64.exe
cd %APPDATA%\eFMer\BOINCTasks
powershell "Invoke-WebRequest -Uri http://BOINCREPORT_SERVER/btxml.php -Method POST -Body @{guipass='GUI_PASS'} -OutFile computers.xml"
rmdir /s /q %APPDATA%\eFMer\BoincTasks\crash
start "" "\Program Files\eFMer\BoincTasks\boinctasks64.exe"