# Set up your Client node

1. Log in to your Digital Ocean account

2. Create droplet > Marketplace > Docker > 5$ > SF > Create

3. Login to your droplet with your password or via ssh

4. Clone this project
```
git clone https://github.com/pixelbot-co/php-frameworks-cost.git /root/code
```

5. Build Docker image (need to change to prebuild image on hub.docker)
```
docker build -t client_image /root/code/client
```

6. Run Docker image (it will run in background)
```
docker run --name client -v /root/data:/root/data -d client_image
```

7. Run a test
```
docker exec client php /root/code/client/test.php -u="http://157.245.220.205/slim/4.3.0/" -t=2
```

8. Check ```/root/data/``` for result logs


