ZF2 Appraisal System
=======================

Introduction
------------
This is a simple, skeleton application using the ZF2 MVC layer and module
systems. This application is meant to be used as a starting place for those
looking to get their feet wet with ZF2.

Installation using Composer
---------------------------

### Installation using a tarball with a local Composer

Download composer into your project directory and install the dependencies:

    curl -s https://getcomposer.org/installer | php --
    cd my/project/dir
    git clone git://github.com/zendframework/ZendSkeletonApplication.git
    cd ZendSkeletonApplication
    php composer.phar self-update
    php composer.phar install

### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-app.localhost
        DocumentRoot /path/to/zf2-app/public
        <Directory /path/to/zf2-app/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
            <IfModule mod_authz_core.c>
            Require all granted
            </IfModule>
        </Directory>
    </VirtualHost>

    <VirtualHost appraisal.local>
        DocumentRoot "c:/xampp/htdocs/appraisal/public"
        ServerName appraisal.local
        <Directory "c:/xampp/htdocs/appraisal/public">
            Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

