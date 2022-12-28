# Simple-Password-Manager

Simple password manager written on PHP with Bootstrap and PDO database connection

#### Login

![Screenshot](web/theme/default/img/Screenshot_1.png?raw=true)

#### Domains

![Screenshot](web/theme/default/img/Screenshot_2.png?raw=true)

#### Records

![Screenshot](web/theme/default/img/Screenshot_3.png?raw=true)

## Requirements

* PHP > 7.3
* MySQL Server 8 OR MariaDB 10
* Apache > 2.4

## Install

### From the ZIP file and GUI interface

* Download .zip file from GitHub
* Unzip it at folder at your choice

### From a GIT repository

* open terminal and navigate to the folder where you want the script to be installed
* run command `git clone https://github.com/milenmk/Simple-Password-Manager.git`

### On the server

* Create vhost file for your installation and restart apache server
* The Directory in the vhost file must point to the script's `web` folder
* 
* <b>`docs` folder contains sensitive information and MUST NOT be accessible from browser, but only locally</b>
*
* Go to `docs` folder and rename `secret.key.example` to `secret.key` and fill the values for
  $decryption_iv/$encryption_iv and $decryption_key/$encryption_key
* <b>Carefully read the comments what those keys might contain and how long they must be!!!</b>

### From your browser:

* Open your browser and go to main folder URL
* Complete the installation steps

There is no need to create a database first. There is an option to specify root user credentials, or any other user that
can create databases, that will be used only during installation steps.

The script will create user with read/write access for this table only.

### Final steps

* If the installation is completed successfully, you will be redirected to the registration page.
* Create your account and start using the software

## LICENSE

This software is released under the terms of the GNU General Public License as published by the Free Software
Foundation; either version 3 of the License, or (at your option) any later version (GPL-3+).

See the [COPYING](https://github.com/milenmk/Simple-Password-Manager/blob/main/LICENSE) file for a full copy of the
license.

## DISCLAIMER

This software and it's code are provided AS IS. Do not use it if you don't know what you are doing.
The author(s) assumes no responsibility or liability for any errors or omissions.
It is NOT recommended to use it on a publicly accessible server!

ALL CONTENT IS “AS IS” AND “AS AVAILABLE” BASIS WITHOUT ANY REPRESENTATIONS OR WARRANTIES OF ANY KIND INCLUDING THE WARRANTIES OF MERCHANTABILITY, EXPRESS OR IMPLIED TO THE FULL EXTENT PERMISSIBLE BY LAW. WE, THE AUTHORS, MAKE NO WARRANTIES THAT THE SOFTWARE WILL PERFORM OR OPERATE TO MEET YOUR REQUIREMENTS OR THAT THE FEATURES PRESENTED WILL BE COMPLETE, CURRENT OR ERROR-FREE. WE, THE AUTHORS, DISCLAIMS ALL WARRANTIES, IMPLIED AND EXPRESS FOR ANY PURPOSE TO THE FULL EXTENT PERMITTED BY LAW.