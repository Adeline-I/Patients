<main>
    <div class="container-fluid">
        <section>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 mt-3 mb-4 px-lg-5">
                    <p class="text-center addSuccess">
                        <?= $addSuccess ?? '' ?>
                    </p>
                    <p class="text-center addError">
                        <?= $addError ?? '' ?> 
                    </p>
                    <h2 class="text-center display-5 mt-4 pageTitle">AJOUTER UN RENDEZ-VOUS</h2>
                </div>
            </div>
            <?php if (!empty($errorProfil)) {
                        echo $errorProfil;
                    } else { ?>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-6 mt-3 px-lg-5">
                            <input id="id" name="id" type="hidden" value="<?= htmlentities($id ?? $appointmentProfil->idAppointments) ?? '' ?>">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="patient" id="patient">
                                    <?php if (!$idAppointment) {
                                        foreach ($patientsList as $patientsListKey => $patientsListValue) { 
                                            $isSelected = ($patientsListValue->id == $patient) ? 'selected' : '';?>
                                        <option <?= $isSelected ?> value="<?= $patientsListValue->id; ?>"><?= $patientsListValue->lastname; ?> <?= $patientsListValue->firstname; ?></option>
                                        <?php }
                                    } else {
                                        $isSelected = ($appointmentProfil->id == $patient) ? 'selected' : '';?>
                                        <option <?= $isSelected ?> value="<?= $appointmentProfil->id; ?>"><?= $appointmentProfil->lastname; ?> <?= $appointmentProfil->firstname; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="patient">Identité du patient</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" name="date" id="date" min="<?= $todayDay; ?>" value="<?= htmlentities($date ?? date('Y-m-d', strtotime($appointmentProfil->dateHour)) ?? '') ?>" autocomplete="bday" pattern="<?= REGEX_DATE ?>" placeholder="Date du rendez-vous" required>
                                <label for="date">Date du rendez-vous</label>
                            </div>
                            <p class="error">
                                <?=  $error['date'] ?? '' ?>
                            </p>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control timepicker" name="time" id="time" min="<?= $startHour; ?>" max="<?= $endHour; ?>" 
                                    value="<?php if(!empty($appointmentProfil->dateHour)) {
                                    echo date('H:i', strtotime($appointmentProfil->dateHour));
                                } else if(!empty($time)) {
                                    echo $time;
                                } else {
                                    echo '--:--';
                                } ?>" 
                                    pattern="<?= REGEX_HOUR ?>" placeholder="Heure du rendez-vous" required>
                                <label for="time">Heure du rendez-vous</label>
                            </div>
                            <p class="error">
                                <?=  $error['time'] ?? '' ?>
                            </p>
                            <p class="error">
                                <?=  $error['dateHour'] ?? '' ?>
                            </p>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn saveBtn mt-2">ENREGISTRER</button>
                            </div>
                        </div>
                    </div>
                </form>
                    <?php } ?>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 mt-3 mb-4 px-lg-5">
                    <p class="text-center">
                        Le patient n'existe pas ? Cliquez ici : 
                        <a href="/controllers/add-patient-appointment-controller.php" rôle="button" class="btn newPatientBtn">Nouveau patient</a>
                    </p>
                </div>
            </div>
        </section>
    </div>
</main>