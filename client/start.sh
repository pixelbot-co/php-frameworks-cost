#!/bin/bash
service php7.2-fpm start
php /root/pft/client/test.php -u="http://157.245.220.205/slim/4.3.0/"
