#!/bin/sh

# path to installer folder, without trailing slash(folder containing Mac_SA_Secure.sh, etc)
boincinstallerpath="/usr/local/boinc_install"

# version of BOINC we'll be installing
install_vers="7.6.34"

####### OPTIONS #######
# auth for BAM (Weak Authenticator from "Main Account Page" of BAM)
bamauth="123ABC"

# local auth for BOINC Clients. (new random password can be generated at https://www.random.org/strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new)
gui_rpc_pwd="123ABC"

httpproxy="proxyaddr"    # If not needed, delete the <proxy_info> block onlines 53-64 of this file
httpproxyport="poxyport"
#######################

# check if installed
if [ -d "/Library/Application Support/BOINC Data/" ]; then
    # If installed, compare version
    curr_vers=$(sudo /Library/Application\ Support/BOINC\ Data/boinccmd --client_version | awk '{print $3}')
    sudo launchctl unload /Library/LaunchDaemons/edu.berkeley.boinc.plist
    if [ "$curr_vers" != "$install_vers" ]; then
        # If old version, remove then install new one
        echo "An older version of BOINC is already installed, upgrading..."
        sudo rm /Library/LaunchDaemons/edu.berkeley.boinc.plist
        cd /Library/Application\ Support/BOINC\ Data/
        sudo sh "$boincinstallerpath/Mac_SA_Insecure.sh" root admin
        sudo rm -r "/Library/Application Support/BOINC Data/"
        sudo cp -R "$boincinstallerpath/move_to_boinc_dir/" /Library/Application\ Support/BOINC\ Data/
        echo "BOINC installed."
    else
        echo "This version of BOINC is already installed, only settings will be updated."
    fi
else
    # If not already installed, create and fill /Library/Application Support/BOINC Data/ folder
    sudo cp -R "$boincinstallerpath/move_to_boinc_dir/" /Library/Application\ Support/BOINC\ Data/
    echo "BOINC installed."
fi


# setup remote management and proxy
echo "Setting GUI password..."
echo $gui_rpc_pwd > /Library/Application\ Support/BOINC\ Data/gui_rpc_auth.cfg

echo "Setting cc_config..."
cat > /Library/Application\ Support/BOINC\ Data/cc_config.xml << ENDOFFILE
<cc_config>
    <options>
        <allow_remote_gui_rpc>1</allow_remote_gui_rpc>
        <proxy_info>
            <use_http_proxy/>
            <socks_version>4</socks_version>
            <socks_server_name></socks_server_name>
            <socks_server_port>80</socks_server_port>
            <http_server_name>$httpproxy</http_server_name>
            <http_server_port>$httpproxyport</http_server_port>
            <socks5_user_name></socks5_user_name>
            <socks5_user_passwd></socks5_user_passwd>
            <http_user_name></http_user_name>
            <http_user_passwd></http_user_passwd>
        </proxy_info>
    </options>
</cc_config>
ENDOFFILE

# secure insatall
echo "Securing Install..."
cd /Library/Application\ Support/BOINC\ Data/
sudo sh "$boincinstallerpath/Mac_SA_Secure.sh"

# create BOINC service
echo "Creating service..."
source "$boincinstallerpath/Make_BOINC_Service.sh" /Library/Application\ Support/BOINC\ Data/

# start service
echo "Starting service..."
sudo launchctl load -w /Library/LaunchDaemons/edu.berkeley.boinc.plist

# wait for start
until pgrep boinc; do
    sleep 1
done
sleep 120

# connect BAM
echo "Connecting to BAM..."
sudo /Library/Application\ Support/BOINC\ Data/boinccmd --join_acct_mgr 'https://bam.boincstats.com/' $bamauth ""

# install reporter XXX
echo "Installing reporter script..."
sudo rm -f /usr/local/munki/postflight.d/BOINC_Reporter.sh
sudo cp "$boincinstallerpath/BOINC_Reporter.sh" "/usr/local/munki/postflight.d/"
sudo chown root:wheel /usr/local/munki/postflight.d/BOINC_Reporter.sh
sudo chmod 755 /usr/local/munki/postflight.d/BOINC_Reporter.sh
sudo /usr/local/munki/postflight.d/BOINC_Reporter.sh


# remove installer
echo "Tidying up..."
sudo rm -r "$boincinstallerpath/"
echo "Done!"
