#!/usr/bin/env bash
# Остановите все запущенные контейнеры
docker stop $(docker ps -aq)

# Удалите все остановленные контейнеры
docker rm $(docker ps -aq)

# Удалите все образы
docker rmi $(docker images -q)

# Удалите все неиспользуемые данные (включая тома и сети)
docker builder prune -a --force
docker volume rm $(docker volume ls -q)
docker system prune -a --volumes --force
docker network prune --force