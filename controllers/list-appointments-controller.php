<?php
require_once(dirname(__FILE__) . '/../config/init.php');
require_once(dirname(__FILE__) . '/../config/const.php');
require_once(dirname(__FILE__) . '/../models/Appointment.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newIdAppointment = intval(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
    $appointmentDelete = Appointment::deleteById($newIdAppointment);
}

$appointmentsList = Appointment::getAll();

include(dirname(__FILE__) . '/../views/templates/header.php');

include(dirname(__FILE__) . '/../views/list-appointments.php');

include(dirname(__FILE__) . '/../views/templates/footer.php');
