<main>
    <div class="container-fluid">
        <section>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 mt-3 mb-4 px-lg-5">
                    <p class="text-center addSuccess">
                        <?=  $addSuccess ?? '' ?>
                    </p>
                    <p class="text-center addError">
                        <?=  $addError ?? '' ?>
                    </p>
                    <h2 class="text-center display-5 mt-4 pageTitle">AJOUTER UN RENDEZ-VOUS À UN NOUVEAU PATIENT</h2>
                </div>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-6 mt-3 mb-5 px-lg-5">
                        <input id="id" name="id" type="hidden" value="<?= htmlentities($patientProfil->id) ?>">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="lastname" id="lastname" autocomplete="family-name" value="<?= htmlentities($lastname ?? $patientProfil->lastname ?? '') ?>" minlength="2" maxlength="70" pattern="<?= REGEX_NO_NUMBER ?>" placeholder="Nom" required>
                            <label for="lastname">Nom</label>
                        </div>
                        <p class="error">
                            <?=  $error['lastname'] ?? '' ?>
                        </p>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="firstname" id="firstname" autocomplete="given-name" value="<?= htmlentities($firstname ?? $patientProfil->firstname ?? '') ?>" minlength="2" maxlength="70" pattern="<?= REGEX_NO_NUMBER ?>" placeholder="Prénom" required>
                            <label for="firstname">Prénom</label>
                        </div>
                        <p class="error">
                            <?=  $error['firstname'] ?? '' ?>
                        </p>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" name="birthdate" id="birthdate" min="<?=$startDay?>" max="<?= $todayDay; ?>" value="<?= htmlentities($birthdate ?? $patientProfil->birthdate ?? '') ?>" autocomplete="bday" pattern="<?= REGEX_DATE ?>" placeholder="Date de naissance" required>
                            <label for="birthdate">Date de naissance</label>
                        </div>
                        <p class="error">
                            <?=  $error['birthdate'] ?? '' ?>
                        </p>
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" name="phone" id="phone" value="<?= htmlentities($phone ?? $patientProfil->phone ?? '') ?>" pattern="<?= REGEX_PHONENUMBER ?>" placeholder="N° de téléphone" autocomplete="tel-national">
                            <label for="phone">N° de téléphone</label>
                        </div>
                        <p class="error">
                            <?=  $error['phone'] ?? '' ?>
                        </p>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="mail" id="mail" value="<?= htmlentities($mail ?? $patientProfil->mail ?? '') ?>" placeholder="Adresse mail" autocomplete="email" required>
                            <label for="mail">Adresse mail</label>
                        </div>
                        <p class="error">
                            <?=  $error['mail'] ?? '' ?>
                        </p>
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
                            <button type="submit" class="btn saveBtn mt-2 mb-5">ENREGISTRER</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>