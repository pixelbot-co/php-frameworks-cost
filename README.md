# Testing popular PHP frameworks on cheap cloud hosting

## How to run the tests

[Set up server node](server/README.md)

[Set up client node](client/README.md)

Login to your client node

Run a test
```
docker exec c1 php /root/pft/client/test.php -u="http://{serverDropletIp}/slim/4.3.0/"
```