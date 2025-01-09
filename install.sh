#/bin/bash

sudo apt update -y
sudo apt upgrade -y
sudo apt install apache2 -y
sudo apt install mysql-server -y
sudo apt install php libapache2-mod-php php-mysql -y
sudo apt install php-cli -y
cd ~
sudo curl -sS https://getcomposer.org/installer -o composer-setup.php
HASH="$(curl -sS https://composer.github.io/installer.sig)"
sudo php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
composer --version

sudo apt install phpmyadmin

sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo a2enconf phpmyadmin
sudo systemctl reload apache2
sudo systemctl start mysql


composer require phpoffice/phpspreadsheet
composer require phpoffice/phpword

