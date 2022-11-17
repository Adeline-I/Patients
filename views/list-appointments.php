<main>
    <div class="container-fluid">
        <section class="appointmentListSection">
            <div class="card mt-3">
                <div class="card-header">
                    <h2 class="card-title display-5 mb-0 h3 text-center">LISTE DES RENDEZ-VOUS</h2>
                </div>
                <div class="card-body">
                    <div class="table">
                        <div class="dataTables_wrapper">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                                    <a href="/controllers/add-appointment-controller.php" role="button" class="btn addBtn">Ajouter un rendez-vous</a>
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
                                            data-search="true"
                                            data-search-accent-neutralise="true"
                                            data-show-columns="true"
                                            data-buttons-align="left"
                                            data-show-fullscreen="true"
                                            data-buttons-class="success">
                                        <caption>Liste des rendez-vous</caption>
                                        <thead class="table-dark">
                                            <tr>
                                                <th data-sortable="true" data-field="id" scope="col">
                                                    Identifiant rendez-vous
                                                </th>
                                                <th data-sortable="true" data-field="date" scope="col">
                                                    Date
                                                </th>
                                                <th data-sortable="true" data-field="hour" scope="col">
                                                    Heure
                                                </th>
                                                <th data-sortable="true" data-field="lastname" scope="col">
                                                    Nom
                                                </th>
                                                <th data-field="firstname" scope="col">
                                                    Prénom
                                                </th>
                                                <th data-field="profil" scope="col">
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($appointmentsList as $appointmentsListKey => $appointmentsListValue) { ?>
                                            <tr>
                                                <th scope="row"><?= $appointmentsListValue->idAppointments; ?></th>
                                                <td><?= date('d/m/Y', strtotime($appointmentsListValue->dateHour)); ?></td>
                                                <td><?= date('H:i', strtotime($appointmentsListValue->dateHour)); ?></td>
                                                <td><?= $appointmentsListValue->lastname; ?></td>
                                                <td><?= $appointmentsListValue->firstname; ?></td>
                                                <td>
                                                    <a class="changeColorLink" href="/controllers/profil-appointment-controller.php?id=<?= $appointmentsListValue->idAppointments; ?>">
                                                        <i class="bi bi-eye-fill" title="Voir plus"></i>
                                                    </a>
                                                    <a class="changeColorLink" 
                                                        role="button" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal" 
                                                        data-bs-whatever=
                                                                "Souhaitez-vous vraiment supprimer le rendez-vous du <?= date('d/m/Y', strtotime($appointmentsListValue->dateHour)); ?> 
                                                                à <?= date('H:i', strtotime($appointmentsListValue->dateHour)); ?> 
                                                                de <?= $appointmentsListValue->firstname; ?> <?= $appointmentsListValue->lastname; ?> ?" 
                                                        data-bs-whateverother=
                                                        "<?= htmlentities($id ?? $appointmentsListValue->idAppointments) ?? '' ?>"
                                                        href="/controllers/list-appointments-controller.php?id=<?= $appointmentsListValue->idAppointments; ?>">
                                                        <i class="bi bi-trash3-fill" title="Supprimer"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Supprimer un rendez-vous</h5>
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