#!/bin/bash

service php7.2-fpm start
echo pwd
php test.php -u="http://157.245.220.205/slim/4.3.0/"