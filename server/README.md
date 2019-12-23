# Set up your Server node

1. Log in to your Digital Ocean account

2. Create droplet > Marketplace > Docker > 5$ > SF > Create

3. Login to your droplet with your password or via ssh

4. Clone this project
```
git clone https://github.com/pixelbot-co/php-frameworks-cost.git /root/code
```

5. Build Docker image
```
docker build -t server /root/code/server
```

6. Run Docker image (it will run in background)
```
docker run --name s1 -d server
```

##Now it is time to [set up your Client node](../client/README.md)
