# BOINC Deployer
## What is BOINC?
BOINC is an open-source program created by The University of California Berkeley to enable computers around the world to use their idle time to contribute to research projects requiring large amounts of computing power.

## What is BOINC Deployer?
BOINC Deployer was built to enable BOINC to be easily installed across a large number of macOS computers using [Munki](https://github.com/munki/munki) (ie. at a school, university, etc)

There are 3 sections to BOINC Deployer:

- boincReport: lists local BOINC clients, with their associated BOINC Account Manager(BAM) ID's, munki manifest, hostname, etc...
- BoincTasks: a simple windows script to import host details from boincReport to the (third-party) BoincTasks local management interface.
- clientInstaller: creates a package to be run on machines to install and setup BOINC

## Glossary
- [BAM!](https://bam.boincstats.com): BOINC Account Manager(third-party website) - Used for choosing and assigning projects to hosts or groups of hosts and setting work preferences.
- GUI Password: Password used by BoincTasks or BOINCManager to access hosts over the LAN
- BoincTasks: Third-party windows program and webgui for controlling hosts in real time.
- BOINCManager: Management interface from BOINC's developers (Can only control one computer at a time)

## Setup
1. First create a [BAM!](https://bam.boincstats.com) account. The password used on this should not contain your username as some projects will not accept this. The password should also be not used on any other services as some project websites lack somewhat in security.
2. Under BAM! settings, set `Hosts connect to BAM every` to a low number of hours. (This ensures configuration changes are pushed out faster to the fleet)
3. Under `Sign-up for projects` click `Create account` next to the projects you'd like to run on the installation.
4. Install boincReport (and BoincTasks if desired) - See README's in respective subfolders
5. Deploy BOINC using clientInstaller - See README in subfolder
6. After machines have the chance to install the package, they should show up in boincReport and also the BAM Host list
7. If setup properly, boincReport should assign a group to each machine on BAM based on its Munki manifest name automatically. Alternatively, run the `Group hosts on BAM!` option at the bottom of boincReport after inputting the BAM password - see boincReport setup for configuration
8. On BAM Work preferences, create one or more work preferences to be applied to different hosts in the setup. 
9. In the BAM Group list, edit each group to assign a work preference to that group.