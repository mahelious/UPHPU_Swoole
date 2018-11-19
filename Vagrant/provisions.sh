#!/usr/bin/env bash

# Let the games begin!
cd

# Handle !I/O/ERR
exec 3>&1 4>&2 1>/dev/null 2>&1

showmsg() {
  exec 1>&3; echo "$1"; exec 1>/dev/null;
  #echo "$1";
}

showmsg "Preparing swoole.dev development environment"

sudo apt-get update
sudo DEBIAN_FRONTEND=noninteractive apt-get -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" upgrade -y
sudo apt-get install vim-nox curl apt-transport-https -y

showmsg "-- Installing PHP7.0"
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg 
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee --append /etc/apt/sources.list.d/php.list
sudo apt-get update
sudo apt-get install php7.2 php7.2-dev php-pear -y
showmsg "--- php 5.4+ requires date.timezone to be set in php.ini"
sudo sed -i "s/;date.timezone =/date.timezone = America\/Denver/" /etc/php/7.2/cli/php.ini
showmsg "--- update pecl channels"
sudo pecl channel-update pecl.php.net

### showmsg "-- Installing Composer"
#curl -sS https://getcomposer.org/installer | php > /dev/null 2>&1
#sudo mv composer.phar /usr/local/bin/composer

showmsg "-- Install Swoole from pecl"
sudo pecl install swoole <<< ''
# Note: this will not work :(
#echo "extension=swoole.so" | sudo tee /etc/php/7.2/mods-available/swoole.ini
echo "extension=swoole.so" | sudo tee --append /etc/php/7.2/cli/php.ini

showmsg "-- Setup daemon, use \"sudo service php-swoole start\""
sudo cp /vagrant/init.d/php-swoole /etc/init.d/php-swoole
sudo chmod +x /etc/init.d/php-swoole
