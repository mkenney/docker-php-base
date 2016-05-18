FROM php:5-cli

MAINTAINER Michael Kenney <mkenney@webbedlam.com>

##############################################################################
# Setup
##############################################################################

ENV DEBIAN_FRONTEND noninteractive
ENV TERM xterm
USER root
RUN mkdir -p /root/src \
    && apt-get -qq update \
    && apt-get install -qqy apt-utils \
    && apt-get -qq upgrade \
    && apt-get -qq dist-upgrade

##############################################################################
# Configurations
##############################################################################

ENV PATH /root/bin:$PATH

ENV UTF8_LOCALE en_US
ENV TIMEZONE 'America/Denver'

ENV ORACLE_VERSION_LONG 11.2.0.3.0-2
ENV ORACLE_VERSION_SHORT 11.2
ENV ORACLE_HOME /usr/lib/oracle/${ORACLE_VERSION_SHORT}/client64
ENV LD_LIBRARY_PATH ${ORACLE_HOME}/lib
ENV TNS_ADMIN /home/dev/.oracle/network/admin
ENV CFLAGS "-I/usr/include/oracle/${ORACLE_VERSION_SHORT}/client64/"
ENV NLS_LANG American_America.AL32UTF8

##############################################################################
# UTF-8 Locale, timezone
##############################################################################

RUN apt-get install -qqy locales \
    && locale-gen C.UTF-8 ${UTF8_LOCALE} \
    && dpkg-reconfigure locales \
    && /usr/sbin/update-locale LANG=C.UTF-8 LANGUAGE=C.UTF-8 LC_ALL=C.UTF-8 \
    && export LANG=C.UTF-8 \
    && export LANGUAGE=C.UTF-8 \
    && export LC_ALL=C.UTF-8 \
    && echo ${TIMEZONE} > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata

ENV LANG C.UTF-8
ENV LANGUAGE C.UTF-8
ENV LC_ALL C.UTF-8

##############################################################################
# Packages
##############################################################################

RUN apt-get install -q -y \
    less \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev \
    libbz2-dev \
    php-pear \
    curl \
    git \
    subversion \
    unzip \
    wget

##############################################################################
# Dependencies
##############################################################################

COPY container /container

# https://sourceforge.net/projects/cloc/
# Oracle instantclient debs created using `alien`
RUN cp /container/oracle-instantclient${ORACLE_VERSION_SHORT}-basic_${ORACLE_VERSION_LONG}_amd64.deb /root/src/ \
    && cp /container/oracle-instantclient${ORACLE_VERSION_SHORT}-devel_${ORACLE_VERSION_LONG}_amd64.deb /root/src/ \
    && cp /container/oracle-instantclient${ORACLE_VERSION_SHORT}-sqlplus_${ORACLE_VERSION_LONG}_amd64.deb /root/src/

##############################################################################
# Oracle instantclient
##############################################################################

RUN groupadd dba \
    && useradd oracle -s /bin/bash -m -g dba \
    && echo "oracle:password" | chpasswd \
    && cd /root/src \
    && dpkg -i oracle-instantclient${ORACLE_VERSION_SHORT}-basic_${ORACLE_VERSION_LONG}_amd64.deb \
    && dpkg -i oracle-instantclient${ORACLE_VERSION_SHORT}-devel_${ORACLE_VERSION_LONG}_amd64.deb \
    && dpkg -i oracle-instantclient${ORACLE_VERSION_SHORT}-sqlplus_${ORACLE_VERSION_LONG}_amd64.deb \
    && mkdir -p /oracle/product \
    && ln -s $ORACLE_HOME /oracle/product/latest \
    && mkdir -p /oracle/product/latest/network/admin \
    && rm -f /root/src/oracle-instantclient${ORACLE_VERSION_SHORT}-basic_${ORACLE_VERSION_LONG}_amd64.deb \
    && rm -f /root/src/oracle-instantclient${ORACLE_VERSION_SHORT}-devel_${ORACLE_VERSION_LONG}_amd64.deb \
    && rm -f /root/src/oracle-instantclient${ORACLE_VERSION_SHORT}-sqlplus_${ORACLE_VERSION_LONG}_amd64.deb

##############################################################################
# PHP
##############################################################################

# INI directory
ENV PHP_INI_DIR '/usr/local/etc/php/conf.d'

# server_env
ENV server_env dev

# Extensions and ini settings
RUN curl -L http://pecl.php.net/get/xdebug-2.4.0RC2.tgz > /usr/src/php/ext/xdebug.tgz \
    && tar -xf /usr/src/php/ext/xdebug.tgz -C /usr/src/php/ext/ \
    && rm /usr/src/php/ext/xdebug.tgz \
    && docker-php-ext-configure oci8 --with-oci8=instantclient,/usr/lib/oracle/${ORACLE_VERSION_SHORT}/client64/lib \
    && docker-php-ext-install \
        oci8 \
        xdebug-2.4.0RC2 \
        pcntl \
        zip \
        bz2 \
        mbstring \
        mcrypt \
    && echo "memory_limit=-1"               > $PHP_INI_DIR/memory_limit.ini \
    && echo "date.timezone=${TIMEZONE}"     > $PHP_INI_DIR/date_timezone.ini \
    && echo "error_reporting=E_ALL"         > $PHP_INI_DIR/error_reporting.ini \
    && echo "display_errors=On"             > $PHP_INI_DIR/display_errors.ini \
    && echo "log_errors=On"                 > $PHP_INI_DIR/log_errors.ini \
    && echo "report_memleaks=On"            > $PHP_INI_DIR/report_memleaks.ini \
    && echo "error_log=syslog"              > $PHP_INI_DIR/error_log.ini \
    && php -m

RUN apt-get clean && rm -r /var/lib/apt/lists/*

# Set up the application directory
VOLUME ["/src"]
WORKDIR /src

ENTRYPOINT ["php"]
