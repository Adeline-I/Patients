<main>
    <div class="container-fluid">
        <section>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 mt-3 px-lg-5">
                    <?php if (!empty($errorProfil)) {
                        echo $errorProfil;
                    } else { ?>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h2 class="card-title display-5 mb-0 h3 text-center">FICHE PATIENT</h2>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-6 ps-5">
                                    <p class="changeColorProfile">Nom :</p>
                                    <p class="changeColorProfile">Prénom :</p>
                                    <p class="changeColorProfile">Date de naissance :</p>
                                    <p class="changeColorProfile">N° de téléphone :</p>
                                    <p class="changeColorProfile">Email :</p>
                                </div>
                                <div class="col-6">
                                    <p><?= $patientProfil->lastname ?></p>
                                    <p><?= $patientProfil->firstname ?></p>
                                    <p><?= date('d/m/Y', strtotime($patientProfil->birthdate)) ?></p>
                                    <p>
                                        <a class="changeColorLink" href="tel:<?= $patientProfil->phone; ?>">
                                        <?php if ($patientProfil->phone) {
                                            echo $patientProfil->phone;
                                        } else {
                                            echo '/-/';
                                        }?>
                                        </a>
                                    </p>
                                    <p><a class="changeColorLink" href="mailto:<?= $patientProfil->mail ?>"><?= $patientProfil->mail ?></a></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            <a href="/controllers/change-patient-controller.php?id=<?= $patientProfil->id; ?>" role="button" class="btn changeBtn">Modifier</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 mt-3 mb-5 table-responsive">
                    <table class="table table-bordered table-striped dataTable"
                            data-toggle="table">
                        <caption>Liste des rendez-vous</caption>
                        <thead class="table-dark">
                            <tr>
                                <th data-sortable="true" data-field="date" scope="col">
                                    Date
                                </th>
                                <th data-sortable="true" data-field="hour" scope="col">
                                    Heure
                                </th>
                                <th data-field="profil" scope="col">
                                    Voir plus
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointmentProfil as $appointmentProfilKey => $appointmentProfilValue) { ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($appointmentProfilValue->dateHour)); ?></td>
                                <td><?= date('H:i', strtotime($appointmentProfilValue->dateHour)); ?></td>
                                <td>
                                    <a class="changeColorLink" href="/controllers/profil-appointment-controller.php?id=<?= $appointmentProfilValue->id; ?>">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</main>