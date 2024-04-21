#!/bin/sh

docker-compose up -d

php_container_running=$(docker ps | grep '_php');

if [ ! -z "$php_container_running" ]; then
    /usr/bin/docker-compose run --rm php composer update >/dev/null;
fi

if [ $? -ne 0 ] ; then
    echo "Some error occured!"
else
    echo 'Ok';
fi

