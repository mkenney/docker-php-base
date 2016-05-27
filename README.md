![MIT License](https://img.shields.io/github/license/mkenney/docker-php-base.svg) ![Docker pulls](https://img.shields.io/docker/pulls/mkenney/php-base.svg) ![Docker stars](https://img.shields.io/docker/stars/mkenney/php-base.svg) ![Github issues](https://img.shields.io/github/issues-raw/mkenney/docker-php-base.svg)

![PHP v7](https://img.shields.io/badge/PHP-v7.0.6-8892bf.svg)

# Portable PHP cli

The [source repo](https://github.com/mkenney/docker-php-base) contains a `php` script that wraps executing a docker container to execute [php](https://php.net/). The current directory is mounted into `/src` in the container and a wrapper script executes php as a user who's `uid` and `gid` matches those properties on that directory. This way PHP runs as the directory owner/group instead of root or a random user.

Because this runs out of a Docker container, all files and directories required by your `php` command must be available within the current directory. Accessing files or directories elsewhere on the system will not work. The simplest solution is to use [Composer](https://hub.docker.com/r/mkenney/composer/) to install any dependencies in your working directory.

# Source repository

* [mkenney/docker-php-base](https://github.com/mkenney/docker-php-base)

# Docker image

* [mkenney/php-base](https://hub.docker.com/r/mkenney/php-base/)

Based on [PHP Offical](https://hub.docker.com/_/php/) (debian:jessie). This is simply a php CLI binary built with various tools, most notably Oracle OCI libraries because they're such a pain to install. It's also used as a base image for several other tools.

The working directory is configured as `/src` and a default user is created and a wrapper script is provided that allows you to run entrypoint commands as the user and group that owns the mounted `/src` directory.

# Tagged Dockerfiles

* [latest](https://github.com/mkenney/docker-php-base/blob/master/Dockerfile), [php7](https://github.com/mkenney/docker-php-base/blob/master/Dockerfile)
* [php5](https://github.com/mkenney/docker-php-base/blob/php5/Dockerfile)
