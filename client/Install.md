Install.md

Digital Ocean
Create droplet > Marketplace > Docker > 5$ > SF > Create
ssh root@206.189.173.120
git clone https://github.com/pixelbot-co/php-frameworks-cost.git pft
cd pft/client
docker build -t docker_client .
docker run --name docker_client_cont -it docker_client 
docker exec -it 24f19976d295 php /root/pft/client/test.php -u="http://157.245.220.205/slim/4.3.0/"
