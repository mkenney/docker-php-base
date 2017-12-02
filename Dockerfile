FROM php:7-cli

##############################################################################
# Setup
##############################################################################

ENV TERM=xterm \
    DEBIAN_FRONTEND=noninteractive

# Set up the application directory
VOLUME ["/src"]
WORKDIR /src

##############################################################################
# Configurations / dependencies
##############################################################################

ENV PATH=/root/bin:$PATH
ENV UTF8_LOCALE=en_US
ENV TIMEZONE='America/Denver'
ENV ORACLE_VERSION_LONG=11.2.0.3.0-2
ENV ORACLE_VERSION_SHORT=11.2
ENV ORACLE_HOME=/oracle/product/latest
ENV LD_LIBRARY_PATH=$ORACLE_HOME/lib
ENV TNS_ADMIN=$ORACLE_HOME/network/admin
ENV CFLAGS="-I/usr/include/oracle/${ORACLE_VERSION_SHORT}/client64/"
ENV NLS_LANG=American_America.AL32UTF8

# PHP ini directory
ENV PHP_INI_DIR /usr/local/etc/php/conf.d

# Locale environment variables
ENV LANG=C.UTF-8  \
    LANGUAGE=C.UTF-8 \
    LC_ALL=C.UTF-8

# Includes dotfiles and Oracle instantclient debs created using `alien`
COPY container /container

##############################################################################
# Upgrade
##############################################################################

RUN set -x \
    && mkdir -p /src \
    && apt-get -qq update \
    && apt-get install -qqy apt-utils \
    && apt-get -qq upgrade \
    && apt-get -qq dist-upgrade

##############################################################################
# UTF-8 Locale, timezone
##############################################################################

RUN set -x \
    && apt-get install -qqy locales \
    && locale-gen C.UTF-8 ${UTF8_LOCALE} \
    && dpkg-reconfigure locales \
    && /usr/sbin/update-locale LANG=C.UTF-8 LANGUAGE=C.UTF-8 LC_ALL=C.UTF-8 \
    && export LANG=C.UTF-8 \
    && export LANGUAGE=C.UTF-8 \
    && export LC_ALL=C.UTF-8 \
    && echo ${TIMEZONE} > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata

##############################################################################
# Packages
##############################################################################

RUN set -x \
    && apt-get install -qqy \
        curl \
        git \
        less \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libbz2-dev \
        rsync \
        sudo \
        unzip \
        wget

##############################################################################
# Oracle instantclient
##############################################################################

RUN set -x \
    && groupadd dba \
    && useradd oracle -s /bin/bash -m -g dba \
    && echo "oracle:password" | chpasswd \
    && cd /container \
    && dpkg -i oracle-instantclient${ORACLE_VERSION_SHORT}-basic_${ORACLE_VERSION_LONG}_amd64.deb \
    && dpkg -i oracle-instantclient${ORACLE_VERSION_SHORT}-devel_${ORACLE_VERSION_LONG}_amd64.deb \
    && dpkg -i oracle-instantclient${ORACLE_VERSION_SHORT}-sqlplus_${ORACLE_VERSION_LONG}_amd64.deb \
    && mkdir -p /oracle/product \
    && ln -s /usr/lib/oracle/${ORACLE_VERSION_SHORT}/client64 $ORACLE_HOME \
    && mkdir -p $ORACLE_HOME/network/admin

##############################################################################
# PHP
##############################################################################

    # Packages
    # - libaio1 is required for oci8
    # - libicu-dev is required for intl
    # - libmemcached-dev is required for memcached
    # - libvpx-dev is required for GD
    # - libwebp-dev is required for GD
    # - libxpm-dev is required for GD
    # - libxml2-dev is required for soap
    # - php-pear is just good stuff
RUN set -x \
    && apt-get install -qqy \
        libaio1 \
        libicu-dev \
        libvpx-dev \
        libwebp-dev \
        libxpm-dev \
        libxml2-dev \
        php-pear

    # Configure and install oci8
    # Don't poke it or it'll break
RUN set -x \
    && mkdir -p $ORACLE_HOME \
    && cp /usr/include/oracle/${ORACLE_VERSION_SHORT}/client64/* $ORACLE_HOME \
    && cd $ORACLE_HOME \
    && ln -s lib/libnnz11.so       libnnz.so \
    && ln -s lib/libnnz11.so       libnnz11.so \
    && ln -s lib/libclntsh.so.11.1 libclntsh.so \
    && ln -s lib/libclntsh.so.11.1 libclntsh.so.11.1 \
    && echo "instantclient,$ORACLE_HOME" | pecl install oci8-2.1.1.tgz \
    && echo "extension=oci8.so" > $PHP_INI_DIR/oci8.ini

    # Extensions
RUN set -x \
    && docker-php-source extract \

    #&& curl -L http://pecl.php.net/get/xdebug-2.5.5.tgz > /usr/src/php/ext/xdebug.tgz \
    #&& tar -xf /usr/src/php/ext/xdebug.tgz -C /usr/src/php/ext/ \
    #&& echo xdebug-2.5.5 >> /usr/src/php-available-exts \
    #&& rm /usr/src/php/ext/xdebug.tgz \

    # php 7.2 requires xdebug master at the moment.
    && echo xdebug-dev >> /usr/src/php-available-exts \
    && git clone https://github.com/xdebug/xdebug.git \
    && mv xdebug /usr/src/php/ext/xdebug-dev \
    && cd /usr/src/php/ext/xdebug-dev/ \
    && sh ./rebuild.sh \
    && cd - \

    && docker-php-ext-configure gd \
        --enable-gd-jis-conv \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        --with-vpx-dir=/usr/include/ \
        --with-webp-dir=/usr/include/ \
        --with-xpm-dir=/usr/include/ \
    && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
    && docker-php-ext-install -j$NPROC \
        gd \
        iconv \
        intl \
        mbstring \
        mysqli \
        pdo_mysql \
        pcntl \
        soap \
        sockets \
        #xdebug-2.5.5 \
        xdebug-dev \
        zip

    # INI settings
RUN set -x \
    && echo "memory_limit=-1"           > $PHP_INI_DIR/memory_limit.ini \
    && echo "date.timezone=${TIMEZONE}" > $PHP_INI_DIR/date_timezone.ini \
    && echo "error_reporting=E_ALL"     > $PHP_INI_DIR/error_reporting.ini \
    && echo "display_errors=On"         > $PHP_INI_DIR/display_errors.ini \
    && echo "log_errors=On"             > $PHP_INI_DIR/log_errors.ini \
    && echo "report_memleaks=On"        > $PHP_INI_DIR/report_memleaks.ini \
    && echo "error_log=syslog"          > $PHP_INI_DIR/error_log.ini

##############################################################################
# users
##############################################################################

    # Configure root account
RUN set -x \
    && rsync -ac /container/dotfiles/ /root/ \
    && echo "export ORACLE_HOME=$(echo $ORACLE_HOME)"          >> /root/.bash_profile \
    && echo "export LD_LIBRARY_PATH=$(echo $LD_LIBRARY_PATH)"  >> /root/.bash_profile \
    && echo "export TNS_ADMIN=$(echo $TNS_ADMIN)"              >> /root/.bash_profile \
    && echo "export CFLAGS=$(echo $CFLAGS)"                    >> /root/.bash_profile \
    && echo "export NLS_LANG=$(echo $NLS_LANG)"                >> /root/.bash_profile \
    && echo "export LANG=$(echo $LANG)"                        >> /root/.bash_profile \
    && echo "export LANGUAGE=$(echo $LANGUAGE)"                >> /root/.bash_profile \
    && echo "export LC_ALL=$(echo $LC_ALL)"                    >> /root/.bash_profile \
    && echo "export TERM=xterm"                                >> /root/.bash_profile \
    && echo "export PATH=$(echo $PATH)"                        >> /root/.bash_profile \

    # Add a dev user and configure all user accounts
    && groupadd dev \
    && useradd dev -s /bin/bash -m -g dev \
    && echo "dev:password" | chpasswd \
    && echo "dev ALL=(ALL:ALL) NOPASSWD: ALL" >> /etc/sudoers \
    && rsync -a /root/ /home/dev/ \
    && rsync -a /root/ /home/oracle/ \
    && chown -R dev:dev /home/dev/ \
    && chmod 0777 /home/dev


##############################################################################
# ~ fin ~
##############################################################################

RUN set -x \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /usr/src/php \
    && rm -rf /container

ENTRYPOINT ["php"]
