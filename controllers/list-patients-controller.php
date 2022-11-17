<?php
require_once(dirname(__FILE__) . '/../config/init.php');
require_once(dirname(__FILE__) . '/../config/const.php');
require_once(dirname(__FILE__) . '/../models/Patient.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newIdPatient = intval(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
    $appointmentDelete = Patient::deleteById($newIdPatient);
}

$search = trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS));
$patientsList = Patient::getAll($search);

include(dirname(__FILE__) . '/../views/templates/header.php');

include(dirname(__FILE__) . '/../views/list-patients.php');

include(dirname(__FILE__) . '/../views/templates/footer.php');
