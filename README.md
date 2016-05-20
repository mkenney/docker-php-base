# Source repository

* [mkenney/docker-php-base](https://github.com/mkenney/docker-php-base)

# Docker image

* [mkenney/php-base](https://hub.docker.com/r/mkenney/php-base/)

Based on [php Offical](https://hub.docker.com/_/php/) (debian:jessie). This is simply a php CLI binary built with various tools, most notably Oracle OCI libraries because they're such a pain to install.

The working directory is configured as /src and a default user is created and a wrapper script is provided that allows you to run entrypoint commands as the user and group that owns the mounted /src directory.

# Tagged Dockerfiles

* [latest](https://github.com/mkenney/docker-php-base/blob/master/Dockerfile), [php7](https://github.com/mkenney/docker-php-base/blob/master/Dockerfile)
* [php5](https://github.com/mkenney/docker-php-base/blob/php5/Dockerfile)

