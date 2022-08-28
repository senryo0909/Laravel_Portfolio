# Operating System
This is for my internal member to improve our production.
Being created with Laravel, MySQL, Javascript(jQuery) based on Vagrant & Docker.

## Contents

- [Demo](#Demo) ** Currently in production
- [Design & Definition](#Design)
- [Purpose & Background](#Purpose)
- [Usage](#Usage)
- [Scope of functionalities](#Functionalities)
- [Technologies](#Technologies)

## Demo
Currently in developing to AWS. Please refer to some pictures as these belows for UI/UX examples.

## Purpose
As a Manager, had been struggling to improve operation cost. Then i started learning how to build the system to solve the issue from scratch by myself.
Since could not make it to launch until leaved from previous company, developing this system as learning how to coding Laravel is my first priority now...

## Functionalities
* Authentication both User & Admin
* Interactive API 
* PDF output (convert shift data to PDF and printout)
* update your shift and acquire "Approval" or "push back" or "application" status.
* REST API
* CI pipeline with CircleCI & Github

## Technologies
Project is created with:
* Laravel version:5.8 -> version:6
* jQuery: version:3.5.1
* Bootstrap version:4
* CSS version:3
* PHP 7.4
* PHPUnit 

## Usage
** Preferred to use Mac or Linux **

- Installed Virtual box
- Installed vagrant 

Firstly to create project directory.

```
$ cd ~
$ mkdir vagrant_web
$ cd vagrant_web
```
Install box of CentOS 7

```
$ vagrant box add centos7.1 https://github.com/CommanderK5/packer-centos-template/releases/download/0.7.1/vagrant-centos-7.1.box

$ vagrant init
```

** Revised Vagrantfile ** 
```
$ vim Vagrantfile
```

The follow is to be pasted to original Vagrantfile

```
VM_BOX = 'centos/7'
NW_LAN = false
NW_IP     = '192.168.1.100'
NW_BRIDGE = 'en0: Wi-Fi (Wireless)'

DIR_SYNC_WWW  = '/Users/ta9/vagrant_web/public_html'
DIR_SYNC_DATA = '/Users/ta9/vagrant_web/vmdata/laravel-data'

Dir.mkdir(DIR_SYNC_DATA) unless Dir.exist?(DIR_SYNC_DATA)
Dir.mkdir(DIR_SYNC_DATA + "/nginx") unless Dir.exist?(DIR_SYNC_DATA + "/nginx")
Dir.mkdir(DIR_SYNC_DATA + "/nginx/config") unless Dir.exist?(DIR_SYNC_DATA + "/nginx/config")
Dir.mkdir(DIR_SYNC_DATA + "/nginx/log") unless Dir.exist?(DIR_SYNC_DATA + "/nginx/log")
Dir.mkdir(DIR_SYNC_DATA + "/nginx/ssl") unless Dir.exist?(DIR_SYNC_DATA + "/nginx/ssl")
Dir.mkdir(DIR_SYNC_DATA + "/mysql") unless Dir.exist?(DIR_SYNC_DATA + "/mysql")
Dir.mkdir(DIR_SYNC_DATA + "/mysql/data") unless Dir.exist?(DIR_SYNC_DATA + "/mysql/data")

Vagrant.configure("2") do |config|
  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--audio", "none"]

host = RbConfig::CONFIG['host_os']

if host =~ /darwin/
    
    mem = 'sysctl -n hw.memsize'.to_i / 1024
elsif host =~ /linux/
    
    mem = `grep 'MemTotal' /proc/meminfo | sed -e 's/MemTotal://' -e 's/ kB//'`.to_i 
elsif host =~ /mswin|mingw|cygwin/
    
    mem = `wmic computersystem Get TotalPhysicalMemory`.split[1].to_i / 1024
end

    mem = mem / 1024 / 4
    vb.customize ["modifyvm", :id, "--memory", mem]
  end

  config.vm.box = VM_BOX
  if NW_LAN == true then
  	config.vm.network "public_network", ip: NW_IP, bridge: NW_BRIDGE
  else
  	config.vm.network "private_network", ip: "192.168.33.10"
  end

  config.vm.synced_folder DIR_SYNC_WWW, "/root/docker/www", mount_options: ['dmode=777','fmode=777']
  config.vm.synced_folder DIR_SYNC_DATA + "/nginx/config", "/root/docker/docker-compose.d/nginx/conf.d/", mount_options: ['dmode=777','fmode=755']
  config.vm.synced_folder DIR_SYNC_DATA + "/nginx/log", "/root/docker/docker-compose.d/nginx/log/", mount_options: ['dmode=777','fmode=755']
  config.vm.synced_folder DIR_SYNC_DATA + "/mysql/data", "/root/docker/docker-compose.d/mysql/data", mount_options: ['dmode=777','fmode=755']
    
  config.vm.provision "shell", inline: <<-SHELL
cd ~
yum -y update

yum install -y yum-utils device-mapper-persistent-data lvm2
yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
yum install -y docker-ce docker-ce-cli containerd.io
systemctl start docker
systemctl enable docker
docker -v

curl -L https://github.com/docker/compose/releases/download/1.25.0-rc2/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
mv /usr/local/bin/docker-compose /usr/bin/docker-compose
docker-compose -v

mkdir ~/docker
mkdir ~/docker/www
cd ~/docker

mkdir ./docker-compose.d
mkdir ./docker-compose.d/nginx
mkdir ./docker-compose.d/nginx/conf.d
mkdir ./docker-compose.d/nginx/log
mkdir ./docker-compose.d/php
mkdir ./docker-compose.d/redis

docker network create --driver bridge private_network

cat > ./docker-compose.d/php/Dockerfile << "EOF"
FROM php:7.4-fpm

COPY php.ini /usr/local/etc/php/

RUN apt-get update
RUN apt-get install -y libzip-dev libpq-dev
RUN docker-php-ext-install zip pdo_mysql pdo_pgsql

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo_mysql pdo_pgsql

ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
EOF　

cat > ./docker-compose.d/php/php.ini << "EOF"
date.timezone = "Asia/Tokyo"
EOF

  SHELL

  config.vm.provision "shell", run: "always", inline: <<-SHELL
cd ~/docker

docker-compose stop

docker system prune -a
yes | docker network create --driver bridge private_network

rm -rf docker-compose.yml
cat > docker-compose.yml << "EOF"
# docker-compose.ymlの設定

version: '3'
services:
    nginx:
        image:
            nginx:latest
        ports:
            - "80:80"
            - "443:443"
        volumes:
            - /root/docker/www:/var/www/html
            - ./docker-compose.d/nginx/log:/var/log/nginx
            - ./docker-compose.d/nginx/conf.d:/etc/nginx/conf.d
            - ./docker-compose.d/nginx/ssl:/etc/nginx/ssl
        restart:
            always
        tty:
            true
        stdin_open:
            true
        # privileged:
        #    true
        networks:
            - private_network
        depends_on:
            - php
            - redis
            - mysql

    php:
        build:
            ./docker-compose.d/php
        volumes:
            - /root/docker/www:/var/www/html
        networks:
            - private_network

    mysql:
        image:
            mysql:5.7
        ports:
            - "3306:3306"
        volumes:
            - ./docker-compose.d/db/init:/docker-entrypoint-initdb.d
            - ./docker-compose.d/db/data:/var/lib/mysql
        command:
            mysqld --character-set-server=utf8 --collation-server=utf8_unicode_ci --sql-mode=NO_ENGINE_SUBSTITUTION
        environment:
            MYSQL_ROOT_PASSWORD: パスワードの指定
            MYSQL_USER: ユーザーの指定
            MYSQL_PASSWORD: パスワードの指定
        tty:
            true
        stdin_open:
            true
        privileged:
            true
        networks:
            - private_network

    redis:
        image:
            redis
        ports:
            - "6379:6379"
        tty:
            true
        stdin_open:
            true
        networks:
            - private_network

networks:
    private_network:
        external: true

EOF

rm -rf ./docker-compose.d/nginx/conf.d/server.conf
cat > ./docker-compose.d/nginx/conf.d/server.conf << "EOF"
server {
  client_max_body_size 3M;

  listen      80;
  
  server_name localhost;

  access_log  /var/log/nginx/access.log;
  error_log /var/log/nginx/error.log;

  location / {
    root   /var/www/html/public;
    index  index.php index.html index.htm;
    try_files $uri $uri/ /index.php$is_args$args;
  }

  location ~ \.php$ {
    fastcgi_pass   php:9000;
    fastcgi_index  index.php;
    fastcgi_param  SCRIPT_FILENAME  /var/www/html/public/$fastcgi_script_name;
    include        fastcgi_params;
  }
}
EOF

cd ~/docker
docker-compose up -d
  SHELL

config.ssh.insert_key = false
end
```

Then, "git clone" from https://github.com/senryo0909/Laravel_Portfolio to public_html directroy

```
$ git clone https://github.com/senryo0909/Laravel_Portfolio
```

When you wanna order something to Laravel...

```
$ cd vagrant_web && vagrant ssh
$ sudo su
$ cd ~ && cd docker/wwww && docker ps
$ docker exec -it "Container ID" php artisan "whatover you want" 
```

## Requirement Definition & External Design
Definition

https://drive.google.com/file/d/12flL6yEtFbtHIyg6bvr1Dc06B0y7wBe5/view?usp=sharing

Outline design

https://docs.google.com/document/d/1gfGPot0drEq-h0KXQRw7eCgYTl0EjJHG0k7sPfLVst8/edit?usp=sharing

