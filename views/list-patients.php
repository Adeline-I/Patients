<main>
    <div class="container-fluid">
        <section class="patientListSection">
            <div class="card mt-3">
                <div class="card-header">
                    <h2 class="card-title display-5 mb-0 h3 text-center">LISTE DES PATIENTS</h2>
                </div>
                <div class="card-body">
                    <div class="table">
                        <div class="dataTables_wrapper">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                                    <a href="/controllers/add-patient-controller.php" role="button" class="btn addBtn">Ajouter un patient</a>
                                </div>
                                <div>
                                    <form action="" method="get">
                                        <label for="site-search">Rechercher sur la page :</label>
                                        <input type="search" id="site-search" name="search" value="<?= $search ?? '' ?>">
                                        <button>Rechercher</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col table-responsive mb-5">
                                    <table class="table table-bordered table-striped dataTable"
                                            data-toggle="table"
                                            data-pagination="true"
                                            data-page-list="[10, 25, 50, 100, All]"
                                            data-pagination-pre-text="Précédent"
                                            data-pagination-next-text="Suivant"
                                            data-show-refresh="true"
                                            data-auto-refresh="true"
                                            data-search="false"
                                            data-search-accent-neutralise="false"
                                            data-show-columns="true"
                                            data-buttons-align="left"
                                            data-show-fullscreen="true"
                                            data-buttons-class="success">
                                        <caption>Liste des patients</caption>
                                        <thead class="table-dark">
                                            <tr>
                                                <th data-sortable="true" data-field="id" scope="col">
                                                    Identifiant patient
                                                </th>
                                                <th data-sortable="true" data-field="lastname" scope="col">
                                                    Nom
                                                </th>
                                                <th data-field="firstname" scope="col">
                                                    Prénom
                                                </th>
                                                <th data-field="birthdate" scope="col">
                                                    Date de naissance
                                                </th>
                                                <th data-field="phone" scope="col">
                                                    N° de téléphone
                                                </th>
                                                <th data-field="mail" scope="col">
                                                    Mail
                                                </th>
                                                <th data-field="profil" scope="col">
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($patientsList as $patientsListKey => $patientsListValue) { ?>
                                            <tr>
                                                <th scope="row"><?= $patientsListValue->id; ?></th>
                                                <td><?= $patientsListValue->lastname; ?></td>
                                                <td><?= $patientsListValue->firstname; ?></td>
                                                <td><?= date('d/m/Y', strtotime($patientsListValue->birthdate)); ?></td>
                                                <td><a class="changeColorLink" href="tel:<?= $patientsListValue->phone; ?>"><?= $patientsListValue->phone; ?></a></td>
                                                <td><a class="changeColorLink" href="mailto:<?= $patientsListValue->mail; ?>"><?= $patientsListValue->mail; ?></a></td>
                                                <td>
                                                    <a class="changeColorLink" href="/controllers/profil-patient-controller.php?id=<?= $patientsListValue->id; ?>">
                                                        <i class="bi bi-eye-fill" title="Voir profil"></i>
                                                    </a>
                                                    <a class="changeColorLink" 
                                                        role="button" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal" 
                                                        data-bs-whatever=
                                                                "Souhaitez-vous vraiment supprimer le patient <?= $patientsListValue->firstname; ?> <?= $patientsListValue->lastname; ?> 
                                                                ainsi que tous les rendez-vous qui lui sont liés ?" 
                                                        data-bs-whateverother=
                                                        "<?= htmlentities($id ?? $patientsListValue->id) ?? '' ?>"
                                                        href="/controllers/list-patients-controller.php?id=<?= $patientsListValue->id; ?>">
                                                        <i class="bi bi-trash3-fill" title="Supprimer"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Supprimer un patient</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn modalBtn" data-bs-dismiss="modal">Fermer</button>
                                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                                                <input id="id" name="id" type="hidden" value="">
                                                                <button type="submit" class="btn modalBtn">Confirmer</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>