#!/bin/sh
set -eu
cd /opt/raihan.bantugrow.com
exec 9>/run/lock/raihan-deploy.lock
flock -n 9 || exit 0
branch=main
g="git -c safe.directory=/opt/raihan.bantugrow.com"
old=$($g rev-parse HEAD)
$g fetch -q origin "$branch"
new=$($g rev-parse "origin/$branch")
[ "$old" = "$new" ] && exit 0
$g reset -q --hard "$new"
docker build -t raihan-portfolio:latest .
docker compose -f docker-compose.prod.yml up -d --force-recreate
