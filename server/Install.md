# Set up your Server node

Log in to your Digital Ocean account

Create droplet > Marketplace > Docker > 5$ > SF > Create

Login to your droplet with your password or via ssh
```ssh root@{youDropletIp}```

Clone this project
```git clone https://github.com/pixelbot-co/php-frameworks-cost.git /root/pft```

Build Docker image
```docker build -t server /root/pft/server```

Run Docker image (it will run in background)
```docker run --name s1 -d server ```

##Now it is time to [set up your Client node](../client/Install.md
