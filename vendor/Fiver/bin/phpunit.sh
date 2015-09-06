#!/usr/bin/env sh

cd `dirname $0`/../

PHPUNIT="../../../vendor/phpunit/phpunit.php"

${PHPUNIT} --configuration phpunit.xml $*
