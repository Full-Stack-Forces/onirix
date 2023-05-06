<?php

function reload()
{
    header('Location: ' . CURRENT_LINK);
    exit;
}

function redirect($link)
{
    header('Location: ' . $link);
    
    exit;
}

function generateRandomString($length = 10)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}

function emptyToNull($value, $strict = true)
{
    return ($strict && $value === '') || (!$strict && $value == '') ? null : $value;
}

function stringToDate($value)
{
    if ($value == '0000-00-00 00:00:00' || $value == '' || $value == null) {
        $date = new DateTime();
        $date->setTimestamp(0);
    } else {
        $date = new DateTime($value);
    }

    return $date;
}

function sqlDate($value, $time = true, $withSecond = false)
{
    return $value != '' ? (new DateTime($value))->format('Y-m-d' . ($time ? ' H:i' : '') . ($withSecond ? ':s' : '')) : null;
}

function fieldFormatDate($date, $time = true, $withSecond = false)
{
    return $date instanceof DateTime ? ($date->getTimestamp() > 0 ? $date->format('d-m-Y' . ($time ? ' H:i' : '') . ($withSecond ? ':s' : '')) : '') : '';
}

function reverseFieldFormatDate($date, $time = true, $withSecond = false)
{
    return $date instanceof DateTime ? ($date->getTimestamp() > 0 ? $date->format('Y-m-d' . ($time ? ' H:i' : '') . ($withSecond ? ':s' : '')) : '') : '';
}

function formatNumber($value, $count = 2, $partSeparation = '.', $thousandSeparation = '')
{
    return $value === '' || $value === null ? '' : rtrim(rtrim(number_format($value, $count, $partSeparation, $thousandSeparation), '0'), $partSeparation);
}

function frenchMonths($isShort = false)
{
    return $isShort ? array(1 => 'Jan', 2 => 'Fév', 3 => 'Mar', 4 => 'Avr', 5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Aoû', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Déc') : array(1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre');
}

function snakeToPascal($input)
{
    return str_replace(' ', '', ucwords(str_replace('_', ' ', $input)));
}
