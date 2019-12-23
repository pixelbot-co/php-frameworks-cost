# Testing popular PHP frameworks on cheap cloud hosting

## How to run the tests

1. [Set up a Server node](server/README.md)

2. [Set up a Client node](client/README.md)

3. Login to your Client node

4. Run a test
```
docker exec c1 php /root/code/client/test.php -u="http://{serverDropletIp}/{framework}/{version}/"
```

## List of frameworks available for testing 

|Framework | Version |Url                   |
|:---------|--------:|:---------------------|
|slim      |    4.3.0|http://ip/slim/4.3.0/ |
