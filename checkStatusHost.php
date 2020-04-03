#!/usr/bin/php7.2
<?php

$toCheckURL = "https://domen.ru"; // Домен для проверки

// поработаем с CURL

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $toCheckURL);

curl_setopt($ch, CURLOPT_HEADER, true);

curl_setopt($ch, CURLOPT_NOBODY, true);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

curl_setopt($ch, CURLOPT_MAXREDIRS, 10); // разрешаем только 10 редиректов за раз во избежание бесконечного цикла

$data = curl_exec($ch);

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код

$new_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

curl_close($ch);

// Массив возможных HTTP статус кодовв

$codes = array(0 => 'Domain Not Found',

    100 => 'Continue',

    101 => 'Switching Protocols',

    200 => 'OK',

    201 => 'Created',

    202 => 'Accepted',

    203 => 'Non-Authoritative Information',

    204 => 'No Content',

    205 => 'Reset Content',

    206 => 'Partial Content',

    300 => 'Multiple Choices',

    301 => 'Moved Permanently',

    302 => 'Found',

    303 => 'See Other',

    304 => 'Not Modified',

    305 => 'Use Proxy',

    307 => 'Temporary Redirect',

    400 => 'Bad Request',

    401 => 'Unauthorized',

    402 => 'Payment Required',

    403 => 'Forbidden',

    404 => 'Not Found',

    405 => 'Method Not Allowed',

    406 => 'Not Acceptable',

    407 => 'Proxy Authentication Required',

    408 => 'Request Timeout',

    409 => 'Conflict',

    410 => 'Gone',

    411 => 'Length Required',

    412 => 'Precondition Failed',

    413 => 'Request Entity Too Large',

    414 => 'Request-URI Too Long',

    415 => 'Unsupported Media Type',

    416 => 'Requested Range Not Satisfiable',

    417 => 'Expectation Failed',

    500 => 'Internal Server Error',

    501 => 'Not Implemented',

    502 => 'Bad Gateway',

    503 => 'Service Unavailable',

    504 => 'Gateway Timeout',

    505 => 'HTTP Version Not Supported');

// Ищем совпадения с нашим списком

if (isset($codes[$http_code])) {

    if ($http_code != 200) {

        $erors = 'Сайт вернул ответ: ' . $http_code . ' - ' . $codes[$http_code] . '<br />';
        send_mail($erors);
        echo $erors;
    }
}

function send_mail($text)
{
    // отправка нескольким адресатам
    $to = 'pochta@gmail.com' . ', '; // кому отправляем
    $to .= 'pochta@mail.ru' . ', '; // Внимание! Так пишем второй и тд адреса
    // не забываем запятую. Даже в последнем контакте лишней не будет
    // Для начинающих! $to .= точка в этом случае для Дописывания в переменную

    $attach = array(
        'https://i.ibb.co/gTjRCN7/hqdefault.jpg',
    );
// содержание письма
    $subject = 'ошибка';
    $message = '
<html>
    <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Сайт не доступен</title>
    </head>
    <body>
        <p>Сервер сообщяет - сайт не доступен!!! Примите срочные меры</p>
        ' . $text . '
    </body>
</html>';

// устанавливаем тип сообщения Content-type, если хотим
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= "Content-type: text/html; charset=utf-8 \r\n";

// дополнительные данные
    $headers .= "From: Robot<noreply@robot.ru>\r\n"; // от кого
    $headers .= "Reply-To: noreply@robot.ru";

    mail($to, $subject, $message, $headers);
}

?>