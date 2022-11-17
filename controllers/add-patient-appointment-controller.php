<?php
require_once(dirname(__FILE__) . '/../config/init.php');
require_once(dirname(__FILE__) . '/../config/const.php');
require_once(dirname(__FILE__) . '/../utils/database.php');
require_once(dirname(__FILE__) . '/../models/Appointment.php');
require_once(dirname(__FILE__) . '/../models/Patient.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //===================== email : Nettoyage et validation =======================
    $mail = trim(filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL));

    if (!empty($mail)) {
        $testEmail = filter_var($mail, FILTER_VALIDATE_EMAIL);
        if ($testEmail === false) {
            $error["mail"] = "L'adresse mail n'est pas au bon format.";
        }
        if (Patient::isExist($mail)) {
            $error["mail"] = "L'adresse mail existe déjà.";
        }
    } else {
        $error["mail"] = "L'adresse mail est obligatoire.";
    }

    //===================== lastname : Nettoyage et validation =======================
    $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS));

    // On vérifie que ce n'est pas vide
    if (!empty($lastname)) {
        $testLastname = filter_var($lastname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEX_NO_NUMBER . '/')));
        // Avec une regex (constante déclarée plus haut), on vérifie si c'est le format attendu 
        if ($testLastname === false) {
            $error["lastname"] = "Le nom n'est pas au bon format.";
        } else {
            // Dans ce cas précis, on vérifie aussi la longueur de chaine (on aurait pu le faire aussi direct dans la regex)
            if (strlen($lastname) <= 1 || strlen($lastname) >= 70) {
                $error["lastname"] = "La longueur du nom n'est pas bon";
            }
        }
    } else { // Pour les champs obligatoires, on retourne une erreur
        $error["lastname"] = "Vous devez entrer un nom.";
    }

    //===================== firstname : Nettoyage et validation =======================
    $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS));

    // On vérifie que ce n'est pas vide
    if (!empty($firstname)) {
        $testFirstname = filter_var($firstname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEX_NO_NUMBER . '/')));
        // Avec une regex (constante déclarée plus haut), on vérifie si c'est le format attendu 
        if ($testFirstname === false) {
            $error["firstname"] = "Le prénom n'est pas au bon format.";
        } else {
            // Dans ce cas précis, on vérifie aussi la longueur de chaine (on aurait pu le faire aussi direct dans la regex)
            if (strlen($firstname) <= 1 || strlen($firstname) >= 70) {
                $error["firstname"] = "La longueur du prénom n'est pas bon";
            }
        }
    } else { // Pour les champs obligatoires, on retourne une erreur
        $error["firstname"] = "Vous devez entrer un prénom.";
    }

    //===================== birthdate : Nettoyage et validation =======================
    $birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_NUMBER_INT);

    if (!empty($birthdate)) {
        $birthdateObj = DateTime::createFromFormat('Y-m-d', $birthdate);
        $currentDateObj = new DateTime();
        if ($birthdateObj === false) {
            $error["birthdate"] = "La date entrée n'est pas valide.";
        } else {
            $diff = $birthdateObj->diff($currentDateObj);
            $age = $diff->days / 365;
            if (!$birthdateObj || $diff->invert == 1 || $birthdateObj->format('Y-m-d') !== $birthdate || $age == 0 || $age > 120) {
                $error["birthdate"] = "La date entrée n'est pas valide.";
            }
        }
    } else { // Pour les champs obligatoires, on retourne une erreur
        $error["birthdate"] = "Vous devez entrer une date de naissance.";
    }

    //===================== phoneNumber : Nettoyage et validation =======================
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));

    if (!empty($phone)) {
        $testPhone = filter_var($phone, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEX_PHONENUMBER . '/')));

        if ($testPhone === false) {
            $error["phone"] = "Vous devez entrer un numéro de téléphone valide.";
        }
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
            } else {
                $newDate = $dateObj->format('Y-m-d');
            }
        }
    } else { // Pour les champs obligatoires, on retourne une erreur
        $error["date"] = "Vous devez entrer une date de rendez-vous.";
    }

    //===================== time : Nettoyage et validation =======================
    $time = trim(filter_input(INPUT_POST, 'time', FILTER_SANITIZE_SPECIAL_CHARS));

    if (!empty($time)) {
        $timeObj = DateTime::createFromFormat('H:i', $time);
        if ($timeObj === false) {
            $error["time"] = "L'heure entrée n'est pas valide.";
        } else {
            if (!$timeObj || $timeObj->format('H:i') !== $time) {
                $error["time"] = "L'heure entrée n'est pas valide.";
            } else {
                $newHour = $timeObj->format('H:i:s');
            }
        }
    } else { // Pour les champs obligatoires, on retourne une erreur
        $error["time"] = "Vous devez entrer une heure de rendez-vous.";
    }

    $dateHour = $newDate . ' ' . $newHour;
    if (Appointment::isExist($dateHour)) {
        $error["dateHour"] = "Ce rendez-vous est déjà pris.";
    }

    if (empty($error)) {

        try {
            $pdo = Database::dbConnect();

            $pdo->beginTransaction();
            $patient = new Patient($lastname, $firstname, $birthdate, $phone, $mail);
            $addedPatient = $patient->add();
            if ($addedPatient != 0) {
                $appointment = new Appointment($dateHour, $addedPatient);
                $addedAppointment = $appointment->add();
                $pdo->commit();
            } else {
                $pdo->rollback();
            }
        } catch (PDOException $execption) {

            $addError = "Les données n'ont pas été envoyé.";
            exit();
        }

        // $patient = new Patient($lastname, $firstname, $birthdate, $phone, $mail);
        // $addedPatient = $patient->add();

        if ($addedPatient === false) {
            $addError = "Les données n'ont pas été envoyé.";
        } else {
            $addSuccess = "Les données ont été envoyé avec succès.";
        }

        if ($addedAppointment === false) {
            $addError = "Les données n'ont pas été envoyé.";
        } else {
            $addSuccess = "Les données ont été envoyé avec succès.";
        }
    }
}

include(dirname(__FILE__) . '/../views/templates/header.php');

include(dirname(__FILE__) . '/../views/add-patient-appointment.php');

include(dirname(__FILE__) . '/../views/templates/footer.php');
