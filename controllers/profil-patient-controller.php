<?php
require_once(dirname(__FILE__) . '/../config/init.php');
require_once(dirname(__FILE__) . '/../config/const.php');
require_once(dirname(__FILE__) . '/../models/Patient.php');
require_once(dirname(__FILE__) . '/../models/Appointment.php');

$idPatient = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
$patientProfil = Patient::getById($idPatient);
$appointmentProfil = Appointment::getByIdPatient($idPatient);

if ($patientProfil instanceof PDOException) {
    $errorProfil = $patientProfil->getMessage();
}

include(dirname(__FILE__) . '/../views/templates/header.php');

include(dirname(__FILE__) . '/../views/profil-patient.php');

include(dirname(__FILE__) . '/../views/templates/footer.php');
