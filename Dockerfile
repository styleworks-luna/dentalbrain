FROM php:7.2-fpm

# Debian 10(buster)는 EOL이라 기본 저장소가 닫혀 있음 → archive.debian.org 사용
RUN printf 'deb http://archive.debian.org/debian buster main\ndeb http://archive.debian.org/debian-security buster/updates main\n' > /etc/apt/sources.list \
    && echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        jpegoptim \
        optipng \
        pngquant \
        gifsicle \
        procps \
    && rm -rf /var/lib/apt/lists/*

# PHP 확장 설치
#  - pdo/pdo_mysql : 외부 MySQL(NCP) 접속
#  - zip           : maatwebsite/excel 필수
#  - bcmath        : Laravel 6 필수
#  - gd            : dompdf 이미지 처리
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include --with-jpeg-dir=/usr/include \
    && docker-php-ext-install -j"$(nproc)" pdo pdo_mysql zip bcmath gd

# opcache 활성화 (php:7.2 이미지에 opcache.so 는 포함되어 있으나 기본 비활성)
# 세부 설정은 php-config/php.ini 의 [opcache] 섹션에서 관리
RUN docker-php-ext-enable opcache

# 호스트 소스 소유자(uid/gid 1001)와 맞춰 storage/, bootstrap/cache 쓰기 권한 확보
RUN groupmod -g 1001 www-data && usermod -u 1001 -g 1001 www-data

# php-fpm 설정
#  - 리스닝 포트를 20000번대로 (베이스 이미지 기본값 9000 덮어씀)
#  - 동시 처리 상향 (기본 max_children=5 는 운영 트래픽에 부족)
#  - max_requests 로 장기 실행 프로세스의 메모리 누적 방지
RUN printf '%s\n' \
    '[global]' \
    'daemonize = no' \
    '' \
    '[www]' \
    'listen = 0.0.0.0:20009' \
    'clear_env = no' \
    'pm = dynamic' \
    'pm.max_children = 25' \
    'pm.start_servers = 5' \
    'pm.min_spare_servers = 3' \
    'pm.max_spare_servers = 10' \
    'pm.max_requests = 500' \
    'pm.status_path = /__fpm_status' \
    'request_terminate_timeout = 300s' \
    > /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html

EXPOSE 20009
