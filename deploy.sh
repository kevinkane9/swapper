#!/bin/bash

if [ "$1" != "" ]; then
        git fetch origin $1
        git checkout -f origin/$1
        chmod 0777 vendor/bin/phinx
        chmod 0777 vendor/robmorgan/phinx/bin/phinx
        vendor/bin/phinx migrate
        date +%s > conf/assets_version
else
        echo "Please specify branch"
fi
