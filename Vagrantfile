# UserEnv Set Here :
VM_BOX = 'centos/7'

# LAN接続させるかどうかの設定
# LAN接続じゃない場合のアクセス先は 192.168.33.10 となります。
# 
# LANでつなぐ：true
# ネット接続なしでも使う：false
NW_LAN = false

# LAN接続させる場合に割り当てたいLAN内のIPアドレスを指定
NW_IP     = '192.168.1.100'
# LAN接続させる場合に接続対象のイーサネットを指定
NW_BRIDGE = 'en0: Wi-Fi (Wireless)'

# Webプロジェクトを保存しているローカルPCをのパスを指定（Laravelインストール先のフォルダを指定）
DIR_SYNC_WWW  = '/Users/ta9/vagrant_web/public_html'


# データ保管に使用するローカルPCをのパスを指定（サーバーデータ置き場を指定）
# 配下にmysql/data, nginx/config, nginx/log, , nginx/ssl を作成します。
#     --> mysql/data はデータ永続用
#     --> nginx/configフォルダにとりあえずの server.conf を作成するので適当に変更する。
#     --> nginx/logフォルダにWebサーバーであるnginxのログがたまる
#     --> nginx/sslフォルダはSSL証明書を使うよう（今回は不使用）
DIR_SYNC_DATA = '/Users/ta9/vagrant_web/vmdata/laravel-data'

# rubyのdir.mkdir組込クラス。下部のunlessでディレクトリがなければ作成。
# Don't touch follow :
Dir.mkdir(DIR_SYNC_DATA) unless Dir.exist?(DIR_SYNC_DATA)
Dir.mkdir(DIR_SYNC_DATA + "/nginx") unless Dir.exist?(DIR_SYNC_DATA + "/nginx")
Dir.mkdir(DIR_SYNC_DATA + "/nginx/config") unless Dir.exist?(DIR_SYNC_DATA + "/nginx/config")
Dir.mkdir(DIR_SYNC_DATA + "/nginx/log") unless Dir.exist?(DIR_SYNC_DATA + "/nginx/log")
Dir.mkdir(DIR_SYNC_DATA + "/nginx/ssl") unless Dir.exist?(DIR_SYNC_DATA + "/nginx/ssl")
Dir.mkdir(DIR_SYNC_DATA + "/mysql") unless Dir.exist?(DIR_SYNC_DATA + "/mysql")
Dir.mkdir(DIR_SYNC_DATA + "/mysql/data") unless Dir.exist?(DIR_SYNC_DATA + "/mysql/data")

# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
# vb.customize ["modifyvm", :id, "--audio", "none"] = virtual box音声機能を設定します。noneを設定すれば無効になります。
# Mac osの場合、Linuxの場合、Unixの場合でメモリサイズを変更。
Vagrant.configure("2") do |config|
  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--audio", "none"]

    host = RbConfig::CONFIG['host_os']
    # Give VM 1/4 system memory 
    if host =~ /darwin/
      # sysctl returns Bytes and we need to convert to MB
      mem = `sysctl -n hw.memsize`.to_i / 1024
    elsif host =~ /linux/
      # meminfo shows KB and we need to convert to MB
      mem = `grep 'MemTotal' /proc/meminfo | sed -e 's/MemTotal://' -e 's/ kB//'`.to_i 
    elsif host =~ /mswin|mingw|cygwin/
      # Windows code via https://github.com/rdsubhas/vagrant-faster
      mem = `wmic computersystem Get TotalPhysicalMemory`.split[1].to_i / 1024
    end

    mem = mem / 1024 / 4
    vb.customize ["modifyvm", :id, "--memory", mem]
  end
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = VM_BOX

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  # config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"
  # ネットが繋がっているか、そうでないかでipの振り分け（初回はdockerhubへの接続が必要なため、wifi環境が必要です。 
  if NW_LAN == true then
  	config.vm.network "public_network", ip: NW_IP, bridge: NW_BRIDGE
  else
  	config.vm.network "private_network", ip: "192.168.33.10"
  end

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder "../data", "/vagrant_data"
  # Vagrant.configure("2") do |config|

  config.vm.synced_folder DIR_SYNC_WWW, "/root/docker/www", mount_options: ['dmode=777','fmode=777']
  config.vm.synced_folder DIR_SYNC_DATA + "/nginx/config", "/root/docker/docker-compose.d/nginx/conf.d/", mount_options: ['dmode=777','fmode=755']
  config.vm.synced_folder DIR_SYNC_DATA + "/nginx/log", "/root/docker/docker-compose.d/nginx/log/", mount_options: ['dmode=777','fmode=755']
  config.vm.synced_folder DIR_SYNC_DATA + "/mysql/data", "/root/docker/docker-compose.d/mysql/data", mount_options: ['dmode=777','fmode=755']
  # end

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  # config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
  #   vb.memory = "1024"
  # end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  # config.vm.provision "shell", inline: <<-SHELL
  #   apt-get update
  #   apt-get install -y apache2
  # SHELL
    
  config.vm.provision "shell", inline: <<-SHELL
cd ~
yum -y update

yum install -y yum-utils device-mapper-persistent-data lvm2
yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
yum install -y docker-ce docker-ce-cli containerd.io
systemctl start docker
systemctl enable docker
docker -v
  #docker-composeのインストール。その後はhome直下にDockerディレクトリを作成し、各アプリのフォルダを作成、さらにdocker networkをdocker bridgeで構築。ipはprivate_network（オプション無しで指定可能)

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
  # nginxのサーバーの設定
server {
  client_max_body_size 3M;

  listen      80;
  # listen      443 ssl;
  
  server_name localhost;

  # ssl_certificate     /etc/nginx/ssl/server.crt; # SSL証明書
  # ssl_certificate_key /etc/nginx/ssl/server.key; # 秘密鍵

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
