# clientInstaller Setup

1. Download the latest macOS command line distribution of BOINC from [https://boinc.berkeley.edu/download_all.php](https://boinc.berkeley.edu/download_all.php) and copy the contents of its `move_to_boinc_dir` directory to the `boinc_install/move_to_boinc_dir` directory of this repo.
2. In `scripts/postflight.sh` set `install_vers` to the version of BOINC you downloaded above, then edit the BAM weak authenticator, GUI password and proxy details.
3. In `boinc_install/BOINC_Reporter.sh` fill in the address of the boincReport server.
4. `postflight.sh` puts `BOINC_Reporter.sh` into `/usr/local/munki/postflight.d/` on each client so that it is run somewhat regularly. This folder is not a part of Munki and scripts in it are run by a few lines in `/usr/local/munki/postflight`, which is also not setup by default. If you are using MunkiReport, this should have been setup already, otherwise `BOINC_Reporter.sh` could be put somewhere else where it is run semi-regularly with root permissions.
5. The package can then be built using the PackageMaker file and deployed from Munki.