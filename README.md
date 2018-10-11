    git clone https://github.com/TheWotan/edge.git
    cd edge

Update your vendor packages

    docker-compose run --rm php composer update --prefer-dist
    
Run the installation triggers (creating cookie validation code)

    docker-compose run --rm php composer install    
    
Start the container

    docker-compose up -d

**NOTES:** 
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches


Init data by migrations

    docker-compose run --rm php yii migrate   
    
Adding Fake data

    docker-compose run --rm php yii generator/faker    
    

Aggregate Send Log

    docker-compose run --rm php yii aggregate/send-log
    

    
You can then access the web view through the following URL:

    http://127.0.0.1:8000    