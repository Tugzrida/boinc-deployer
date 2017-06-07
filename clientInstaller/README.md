# clientInstaller Setup

1. In `scripts/postflight.sh` edit the BAM weak authenticator, GUI password and proxy details.
2. In `boinc_install/BOINC_Reporter.sh` fill in the address of the boincReport server.
3. `postflight.sh` puts `BOINC_Reporter.sh` into `/usr/local/munki/postflight.d/` on each client so that it is run somewhat regularly. This folder is not a part of Munki and scripts in it are run by a few lines in `/usr/local/munki/postflight`, which is also not setup by default. If you are using MunkiReport, this should have been setup already, otherwise `BOINC_Reporter.sh` could be put somewhere else where it is run semi-regularly with root permissions.
4. The package can then be built using the PackageMaker file and deployed from Munki.