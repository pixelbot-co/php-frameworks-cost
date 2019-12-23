# Set up your Client node

1. Log in to your Digital Ocean account

2. Create droplet > choose Marketplace > choose Docker > 5$ > SF > Create

3. Login to your droplet with your password or via ssh

4. Get Docker image for runnig client node
```
docker pull pixelbotco/pft_client
```

5. Run the image (it will run in background)
```
docker run --name client -v /root/data:/root/data -d pixelbotco/pft_client:latest
```

6. Run a test
```
docker exec client php /root/code/client/test.php -u="http://157.245.220.205/slim/4.3.0/" -t=2
```

7. Check ```/root/data/``` for result logs
