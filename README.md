Скрипт для crontab - проверка доступности сайта <br>
Укажите ваш домен $toCheckURL = "https://domen.ru"; // Домен для проверки <br>
Укажите кому отправлять  $to = 'pochta@gmail.com' // Почта для отправки <br>

В терминале запускаем crontab -e <br>
И добавляем */5 * * * * /usr/bin/php7.4 /home/heckStatusHost.php //Проверка статуса сайта - раз в 5 минут
