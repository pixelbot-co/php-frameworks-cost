# Set up your Client node

1. Log in to your Digital Ocean account

2. Create droplet > Marketplace > Docker > 5$ > SF > Create

3. Login to your droplet with your password or via ssh
```
ssh root@{youDropletIp}
```

4. Make directory for test data (need to automate this part)
```
mkdir /root/test_data
```

5. Clone this project
```
git clone https://github.com/pixelbot-co/php-frameworks-cost.git /root/pft
```

6. Build Docker image (need to change to prebuild image on hub.docker)
```
docker build -t client_image /root/pft/client
```

7. Run Docker image (it will run in background)
```
docker run --name c1 -v /root/test_data:/root/test_data -d client
```

8. Run a test
```
docker exec c1 php /root/pft/client/test.php -u="http://157.245.220.205/slim/4.3.0/"
```

9. Check ```/root/test_data/``` for result logs
