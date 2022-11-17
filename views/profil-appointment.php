<main>
    <div class="container-fluid">
        <section>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 mt-3 mb-4 px-lg-5">
                    <?php if (!empty($errorProfil)) {
                        echo $errorProfil;
                    } else { ?>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h2 class="card-title display-5 mb-0 h3 text-center">FICHE RENDEZ-VOUS</h2>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-6 ps-5">
                                    <p class="changeColorProfile">Date :</p>
                                    <p class="changeColorProfile">Heure :</p>
                                    <p class="changeColorProfile">Nom :</p>
                                    <p class="changeColorProfile">Prénom :</p>
                                </div>
                                <div class="col-6">
                                    <p><?= date('d/m/Y', strtotime($appointmentProfil->dateHour)) ?></p>
                                    <p><?= date('H:i', strtotime($appointmentProfil->dateHour)) ?></p>
                                    <p><?= $appointmentProfil->lastname ?></p>
                                    <p><?= $appointmentProfil->firstname ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            <a href="/controllers/change-appointment-controller.php?id=<?= $appointmentProfil->idAppointments; ?>" role="button" class="btn changeBtn">Modifier</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </div>
</main>