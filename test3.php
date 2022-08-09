<?php
/*
 * Событие - при изменении элемента проверяем значение свойства и меняем свойство “HAS_PHOTO”
 * в зависимости от того имеется ли у элемента фотографии в полях PREVIEW_PICTURE или DETAIL_PICTURE
 * или MORE_PHOTO
 */

/*
* Регистрация событий:
* OnBeforeIBlockElementUpdate- перед изменением элемента
*/
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("EventChangeHasPhoto", "OnSetHasPhotoActive"));


class EventChangeActive
{

    /*
    * При наличии свойства PREVIEW_PICTURE,MORE_PHOTO,MORE_PHOTO, то HAS_PHOTO ='Y', и наоборот
    */
    function OnSetHasPhotoActive(&$arFields)
    {
        //флаг отображения
        $flag_view = false;
        $arSort = array();
        // Фильтр по-умолчанию
        $filter = array("IBLOCK_ID" => '41');
        $arNavParams = array("nPageSize" => '10');
        // Список выбираемых по-умолчанию полей
        $select = [
            "ID",
            "IBLOCK_ID",
            "PREVIEW_PICTURE",
            "DETAIL_PICTURE",
        ];

        foreach ($arParams["PROPERTY_CODE"] as $code) {
            $select[] = "PROPERTY_" . $code;
        }

        // Получаем список элементов
        $items = \CIBlockElement::GetList($arSort, $filter, false, $arNavParams, $select);
        // Перебираем результат списка элементов инфоблока
        while ($fetch = $items->GetNext()) {
            $propsDbres = \CIBlockElement::GetProperty(
                $fetch["IBLOCK_ID"],
                $fetch["ID"],
                "sort",
                "asc",
                array("CODE" => "MORE_PHOTO")
            );
            while ($arPhoto = $propsDbres->Fetch()) {
                if (!empty($arPhoto["VALUE"])) {
                    $flag_view = true;
                }
            }
            foreach ($arParams["PROPERTY_CODE"] as $code) {
                $fetch["PROPERTIES"][$code] = $fetch["PROPERTY_" . toUpper($code) . "_VALUE"];
            }


            // Если указана картинка-предпросмотр
            if (!empty($fetch["PREVIEW_PICTURE"])) {
                $flag_view = true;
            }
            // Если указана картинка-детальная
            if (!empty($fetch["DETAIL_PICTURE"])) {
                $flag_view = true;
            }
            foreach ($arFields['PROPERTY_VALUES'] as $propId => $prop) {
                if (self::getCodeValue($propId) === 'HAS_PHOTO') {
                    $propertyValue = self::getPropertyValue($propId, $prop[0]['VALUE']);

                    if ($flag_view && $propertyValue['VALUE'] == 'N') {
                        $arFields['HAS_PHOTO'] = 'Y';
                    }

                    break;
                }
            }
        }

        /*
        * Получение кода свойства
        */
        function getCodeValue($propId = '')
        {
            if ($propId === '') {
                return false;
            }

            $propInfoRes = CIBlockProperty::GetByID($propId);
            $propInfo = $propInfoRes->GetNext();

            return $propInfo['CODE'];
        }


        /*
        * получение значения свойства
        */
        function getPropertyValue($propId = '', $propIdValue = '')
        {
            if ($propId === '') {
                return false;
            }
            if ($propIdValue === '') {
                return false;
            }

            $db_enum_list = CIBlockProperty::GetPropertyEnum($propId, array(), array('ID' => $propIdValue));

            return $db_enum_list->GetNext();
        }
    }
}