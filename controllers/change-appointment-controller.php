<?php
require_once(dirname(__FILE__) . '/../config/init.php');
require_once(dirname(__FILE__) . '/../config/const.php');
require_once(dirname(__FILE__) . '/../models/Appointment.php');
require_once(dirname(__FILE__) . '/../models/Patient.php');

$idAppointment = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
$appointmentProfil = Appointment::getById($idAppointment);

if ($appointmentProfil instanceof PDOException) {
    $errorProfil = $appointmentProfil->getMessage();
}

$patientsList = Patient::getAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newIdAppointment = intval(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));


    //===================== patient : Nettoyage et validation =======================
    $patient = trim(filter_input(INPUT_POST, 'patient', FILTER_SANITIZE_SPECIAL_CHARS));

    // On vérifie que ce n'est pas vide
    if (!empty($patient)) {
        $testpatient = filter_var($patient, FILTER_VALIDATE_INT);
        // Avec une regex (constante déclarée plus haut), on vérifie si c'est le format attendu 
        if ($testpatient === false) {
            $error["patient"] = "L'identité du patient n'est pas au bon format.";
        }
    } else { // Pour les champs obligatoires, on retourne une erreur
        $error["patient"] = "Vous devez choisir un patient.";
    }

    //===================== date : Nettoyage et validation =======================
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS));

    if (!empty($date)) {
        $dateObj = DateTime::createFromFormat('Y-m-d', $date);
        if ($dateObj === false) {
            $error["date"] = "La date entrée n'est pas valide.";
        } else {
            if (!$dateObj  || $dateObj->format('Y-m-d') !== $date) {
                $error["date"] = "La date entrée n'est pas valide.";
            }
        }
    } else { // Pour les champs obligatoires, on retourne une erreur
        $error["date"] = "Vous devez entrer une date de rendez-vous.";
    }

    //===================== time : Nettoyage et validation =======================
    $time = trim(filter_input(INPUT_POST, 'time', FILTER_SANITIZE_SPECIAL_CHARS));

    if (!empty($time)) {
        $timeObj = DateTime::createFromFormat('G:i', $time);
        if ($timeObj === false) {
            $error["time"] = "L'heure entrée n'est pas valide.";
        } else {
            if (!$timeObj || $timeObj->format('G:i') !== $time) {
                $error["time"] = "L'heure entrée n'est pas valide.";
            }
        }
    } else { // Pour les champs obligatoires, on retourne une erreur
        $error["time"] = "Vous devez entrer une heure de rendez-vous.";
    }

    if (empty($error)) {
        $newDate = $dateObj->format('Y-m-d');
        $newHour = $timeObj->format('H:i:s');
        $newDateHour = $newDate . ' ' . $newHour;
        $newDateHourObj = DateTime::createFromFormat('Y-m-d H:i:s', $newDateHour);
        $dateHour = $newDateHourObj->format('Y-m-d H:i:s');

        if ($appointment->dateHour != $dateHour && Appointment::isExist($dateHour)) {
            $error["dateHour"] = "Ce rendez-vous est déjà pris.";
        } else {
            $appointment = new Appointment($dateHour, $patient);
            if (!empty($newIdAppointment)) {
                $changedAppointment = $appointment->changeById($newIdAppointment);
                if ($changedAppointment === false) {
                    $addError = "Les données n'ont pas été envoyé.";
                } else {
                    $addSuccess = "Les données ont été envoyé avec succès.";
                }
            }
        }
    }
}


include(dirname(__FILE__) . '/../views/templates/header.php');

include(dirname(__FILE__) . '/../views/add-appointment.php');

include(dirname(__FILE__) . '/../views/templates/footer.php');
