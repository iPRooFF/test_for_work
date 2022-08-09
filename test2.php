<?php

$array = [
    "FRUIT" => ["ID" => 12, "NAME" => "Фрукт", "XML_ID" => "bx_fruit_1"],
    "DRINK" => ["ID" => 42, "NAME" => "Напиток", "XML_ID" => "bx_drink_1"],
    ["ID" => 11, "NAME" => "Лодка", "XML_ID" => "bx_boat"],
    "NINJA" => ["ID" => 12, "NAME" => "Кузя", "XML_ID" => "bx_ninja"],
    42 => ["ID" => 121, "NAME" => "Этаж"],
    ["NAME" => "Сайт", "XML_ID" => "bx_site_s1"],
];

$result_one = [];

foreach ($array as $item):
    foreach ($item as $key => $value):
        if (!empty($item['XML_ID']) & !empty($item['ID'])):
            $result_one[$item['XML_ID']] = $item['ID'];
        endif;

    endforeach;
endforeach;

var_dump($result_one);

$result_two = [];


foreach ($array as $item):
    foreach ($item as $key => $value):
        if (!empty($item['XML_ID']) & !empty($item['ID'])):
            $result_two [$item['ID']] = $item;
        endif;

    endforeach;
endforeach;

var_dump($result_two);

?>