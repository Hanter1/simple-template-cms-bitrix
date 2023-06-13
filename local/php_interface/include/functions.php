<?php
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Loader;

/**
 * Возвращает ID инфоблока по его коду
 *
 * @param string $code - код ИБ
 *
 * @return int - ID найденного ИБ
 * @throws Exception
 */
function getIblockIdByCode(string $code): int
{
    Loader::includeModule('iblock');

    $iblock = IblockTable::getList([
        'filter' => [
            'CODE' => $code,
        ],
        'select' => [
            'ID',
            'CODE',
        ],
    ])->fetch();

    if (!isset($iblock['ID'])) {
        throw new Exception("Не найден инфоблок с кодом {$code}");
    }

    return (int) $iblock['ID'];
}

function pr($o, $die = false, $all = false)
{
    global $USER, $APPLICATION;
    if ($USER->isAdmin() || $all) {
        if ($die) $APPLICATION->RestartBuffer();
        $bt = debug_backtrace();
        $bt = $bt[0];
        $dRoot = $_SERVER["DOCUMENT_ROOT"];
        $dRoot = str_replace("/", "\\", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        $dRoot = str_replace("\\", "/", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        ?>
        <div style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;'>
            <div style='padding:3px 5px; background:#99CCFF; font-weight:bold;'>File: <?= $bt["file"] ?>
                [<?= $bt["line"] ?>]
            </div>
            <pre style='padding:10px;'><?
                print_r($o) ?></pre>
        </div>
        <div class='clear'></div>
        <?
        if ($die) die();
    }
}