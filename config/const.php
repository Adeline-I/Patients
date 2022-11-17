<?php

define('REGEX_NO_NUMBER', "^[A-Za-z-éèêëàâäïôöûüç'\- ]+$");
define('REGEX_PHONENUMBER', '^[0-9]{10}$');
define('REGEX_DATE', '^([0-9]{4})[\/\-]?([0-9]{2})[\/\-]?([0-9]{2})$');
define('REGEX_HOUR', '^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$');

define('ERROR_ARRAY', [
    '0' => 'erreur générique',
    '1' => 'Une erreur de liaison avec la base de données s\'est produite.',
    '2' => 'erreur n°2'
]);

$dateToday = new DateTime();
$todayDay = $dateToday->format('Y-m-d');
$actualYear = $dateToday->format('Y');
$startYear = $actualYear - 120;
$actualMonth = $dateToday->format('m');
$actualday = $dateToday->format('d');
$dateStart = new DateTime("$startYear-$actualMonth-$actualday");
$startDay = $dateStart->format('Y-m-d');

$startHour = '08:00';
$endHour = '20:00';
