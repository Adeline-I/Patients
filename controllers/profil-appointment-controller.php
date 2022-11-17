<?php
require_once(dirname(__FILE__) . '/../config/init.php');
require_once(dirname(__FILE__) . '/../config/const.php');
require_once(dirname(__FILE__) . '/../models/Appointment.php');

$idAppointment = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
$appointmentProfil = Appointment::getById($idAppointment);

if ($appointmentProfil instanceof PDOException) {
    $errorProfil = $appointmentProfil->getMessage();
}

include(dirname(__FILE__) . '/../views/templates/header.php');

include(dirname(__FILE__) . '/../views/profil-appointment.php');

include(dirname(__FILE__) . '/../views/templates/footer.php');
