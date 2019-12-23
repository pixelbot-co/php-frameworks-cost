# Set up your Server node

1. Log in to your Digital Ocean account

2. Create droplet > Marketplace > Docker > 5$ > SF > Create

3. Login to your droplet with your password or via ssh

4. Get Docker image for runnig server node
```
docker pull pixelbotco/pft_server
```

5. Run the image (it will run in background)
```
docker run --name server -v /var/log:/var/log -d pixelbotco/pft_server:latest
```

##Now it is time to [set up your Client node](../client/README.md)
