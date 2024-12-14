#!/usr/bin/env bash
# Получаем путь к директории, если не передан аргумент, используем текущую директорию
PERM_DIRECTORY=${1:-.}

# Преобразуем путь в абсолютный
PERM_DIRECTORY=$(realpath "$PERM_DIRECTORY")

echo "$PERM_DIRECTORY"

# Добавляем текущего пользователя в группу www-data
sudo usermod -aG www-data "$(whoami)"

# Изменяем владельца указанных директорий на текущего пользователя и группу www-data
sudo chown -R "$(whoami)":www-data "$PERM_DIRECTORY"

# Меняем права доступа для директорий (ставим 2755) и файлов (ставим 644)
sudo find "$PERM_DIRECTORY" -type d -exec chmod 2755 {} +
sudo find "$PERM_DIRECTORY" -type f -exec chmod 0644 {} +

# Меняем текущую группу на www-data для всех последующих команд
exec sg www-data -c "$SHELL"