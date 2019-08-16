#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
apt-get install wget git zip libpng-dev -yqq

# Here you can install any other extension that you need
docker-php-ext-install gd
docker-php-ext-install calendar