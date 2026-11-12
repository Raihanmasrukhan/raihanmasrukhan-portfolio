#!/bin/sh
set -eu
cd /opt/raihan.bantugrow.com
exec 9>/run/lock/raihan-deploy.lock
flock -n 9 || exit 0
branch=main
old=$(git rev-parse HEAD)
git fetch origin "$branch"
new=$(git rev-parse "origin/$branch")
[ "$old" = "$new" ] && exit 0
git reset --hard "$new"
docker build -t raihan-portfolio:latest .
docker compose -f docker-compose.prod.yml up -d --force-recreate
