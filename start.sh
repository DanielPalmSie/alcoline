#!/bin/bash

if [ ! -f .env ]; then
  echo "Creating .env from .env.example..."
  cp .env.example .env
else
  echo ".env already exists."
fi

echo "Launching containers..."
docker-compose up -d
docker-compose logs -f &

echo "Installing Composer Dependencies..."
docker exec -it $(docker ps -qf "name=myapp_php") sh -c "composer install"

echo -e "\033[0;32mThe project went up successfully!\033[0m"