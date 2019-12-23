# Set up your Client node

Log in to your Digital Ocean account

Create droplet > Marketplace > Docker > 5$ > SF > Create

Login to your droplet with your password or via ssh
```ssh root@{youDropletIp}```

Make directory for test data (need to automate this part)
```mkdir /root/test_data```

Clone this project
```git clone https://github.com/pixelbot-co/php-frameworks-cost.git /root/pft```

Build Docker image
```docker build -t client_image /root/pft/client```

Run Docker image (it will run in background)
```docker run --name c1 -v /root/test_data:/root/test_data -d client```

Run a test
```docker exec c1 php /root/pft/client/test.php -u="http://157.245.220.205/slim/4.3.0/"```

Check ```/root/test_data/``` for result logs
