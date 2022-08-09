<?php

$IBLOCK_TYPE = "blog_news";
$ELEMENT_COUNT = 10;
$arFilter = array("IBLOCK_ID" => 12);

$arSelect = array(
    "ID",
    "NAME",
    "XML_ID",
    "PREVIEW_PICTURE",
    "PREVIEW_TEXT",
    "PROPERTY_SIZE",
    "PROPERTY_BRAND",
    "PROPERTY_CATEGORY",
);

if ($rsElements = GetIBlockElementListEx(
    $IBLOCK_TYPE,
    false,
    false,
    array($ELEMENT_SORT_FIELD => $ELEMENT_SORT_ORDER),
    array("nPageSize" => $ELEMENT_COUNT),
    $arFilter,
    $arSelect
)) {
    $rsElements->NavStart($ELEMENT_COUNT);
    if ($obElement = $rsElements->GetNextElement()) {
        do {
            $arElement = $obElement->GetFields();
            echo $arElement; // вывод элемента
            //если нужно работать со значениями полей
            echo $arElement["ID"], "";
            echo $arElement["NAME"], "";
            echo $arElement["XML_ID"], "";
            echo $arElement["PREVIEW_PICTURE"], "";
            echo $arElement["PREVIEW_TEXT"], "";
            // если нужно работать со значениями свойств
            echo $arElement["PROPERTY_SIZE"], "";
            echo $arElement["PROPERTY_BRAND"], "";
            echo $arElement["PROPERTY_CATEGORY"], "";
        } while ($obElement = $rsElements->GetNextElement())
    }
}