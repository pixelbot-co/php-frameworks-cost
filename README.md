# Testing popular PHP frameworks on cheap cloud hosting

## How to run the tests

1. [Set up a Server node](server/README.md)

2. [Set up a Client node](client/README.md)

3. Login to your Client node

4. Run a test
```
docker exec c1 php /root/pft/client/test.php -u="http://{serverDropletIp}/slim/4.3.0/"
```