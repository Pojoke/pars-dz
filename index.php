<?php
header("Content-Type: text/htnl; charset=utf-8");
require 'simplehtmldom/simple_html_dom.php';
// Парсим страницу с сайта
$allo = file_get_html("https://allo.ua/ru/kofemashiny/smart_upravlenie-est/");

$links = [];
$names = [];

// Проверяем, что элемент найден и считаем количество
$card_titles = count($allo->find('.product-card__content .product-card__title'));

if ($card_titles > 0) {
    foreach ($allo->find('.product-card__content .product-card__title') as $a) {
        // Проверяем, что у элемента есть атрибут href
        if (isset($a->href)) {
            $links[] = $a->href;
        }
        $names[] = $a->innertext;
    }
}

// Создаем список ссылок
$ul = [];
$ul[] = "<ul>";
for ($i = 0; $i < count($names); $i++) {
    // Убедитесь, что $links[$i] существует
    if (isset($links[$i])) {
        $ul[] = "<li><strong>Назва: </strong><a href='https://allo.ua/ru/kofemashiny/smart_upravlenie-est/{$links[$i]}'>{$names[$i]}</a></li>";
    }
}
$ul[] = "</ul>";
$content = implode("\n", $ul);

// Генерируем HTML-документ
$str_b = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foxtrot</title>
</head>
<body>';

$str_e = '</body>
</html>';

// Открываем файл для записи
$h = fopen($path . "/allo.html", "w");

// Записываем контент в файл
fwrite($h, $str_b . "\n");
fwrite($h, $content . "\n");
fwrite($h, $str_e);
fclose($h);
?>
