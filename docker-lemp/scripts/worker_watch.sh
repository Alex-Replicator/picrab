#!/bin/bash

while true; do
    # Запускаем worker.php и записываем его PID
    php /var/www/html/app/worker.php &
    WORKER_PID=$!

    # Ждем изменения файла worker.php
    inotifywait -e modify /var/www/html/app/worker.php

    # Убиваем воркер
    kill -SIGTERM $WORKER_PID

    # Ждем завершения процесса воркера
    wait $WORKER_PID
done