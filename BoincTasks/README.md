# BoincTasks Installation

1. Install [BoincTasks](http://efmer.com/b/boinctasks_download_release)
2. Download and save `Reload_BoincTasks.bat` to somewhere on the windows computer
3. Edit the URL to the boincReport server and GUI password in `Reload_BoincTasks.bat`
4. Download and save `Reload_BoincTasks.xml` and open Task Scheduler
5. Import the XML file using the options on the right hand side
6. Set the path to `Reload_BoincTasks.bat` under Properties > Actions > Start a Program and the local admin user under Properties > General > Change User or Group...

The webgui of BoincTasks can also be enabled under Extra > BoincTasks Settings > Mobile. I'd reccomend setting a password for this as the gui has full control of all BOINC Hosts, and once again, using HTTPS would be ideal.