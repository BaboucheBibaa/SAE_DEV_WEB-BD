<main class="flex-grow-1">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="h2 fw-bold mb-2">Modifier une réparation/entretien</h1>
            <p class="text-muted">Mettez à jour les informations de l'intervention</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?action=updateReparation&date_debut=<?= urlencode($reparation['DATE_DEBUT_REPARATION']) ?>&latitude=<?= $reparation['LATITUDE_ENCLOS'] ?>&longitude=<?= $reparation['LONGITUDE_ENCLOS'] ?>">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="dateDebut" class="form-label fw-bold">
                                        <i class="bi bi-calendar-event"></i> Date début réparation
                                    </label>
                                    <?php
                                    $dateObj = DateTime::createFromFormat('d/m/y', $reparation['DATE_DEBUT_REPARATION']);
                                    $nouvelleDate = $dateObj->format('Y-m-d');
                                    ?>
                                    <input
                                        type="date"
                                        class="form-control form-control-lg"
                                        id="dateDebut"
                                        disabled
                                        value="<?= htmlspecialchars($nouvelleDate) ?>">
                                    <input type="hidden" name="DATE_DEBUT_REPARATION" value="<?= htmlspecialchars($nouvelleDate) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="dateFin" class="form-label fw-bold">
                                        <i class="bi bi-calendar-check"></i> Date de fin *
                                    </label>
                                    <?php
                                    $dateObj = DateTime::createFromFormat('d/m/y', $reparation['DATE_FIN']);
                                    $nouvelleDate = $dateObj->format('Y-m-d');
                                    ?>
                                    <input
                                        type="date"
                                        class="form-control form-control-lg"
                                        id="dateFin"
                                        name="DATE_FIN"
                                        value="<?= htmlspecialchars($nouvelleDate ?? '') ?>"
                                        aria-label="Date de fin de reparation">
                                </div>

                                <div class="col-md-6">
                                    <label for="latitudeEnclos" class="form-label fw-bold">
                                        <i class="bi bi-geo-alt"></i> Latitude enclos
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control form-control-lg"
                                        id="latitudeEnclos"
                                        disabled
                                        value="<?= htmlspecialchars($reparation['LATITUDE_ENCLOS']) ?>">
                                    <input type="hidden" name="LATITUDE_ENCLOS" value="<?= htmlspecialchars($reparation['LATITUDE_ENCLOS']) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="longitudeEnclos" class="form-label fw-bold">
                                        <i class="bi bi-geo-alt-fill"></i> Longitude enclos
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control form-control-lg"
                                        id="longitudeEnclos"
                                        disabled
                                        value="<?= htmlspecialchars($reparation['LONGITUDE_ENCLOS']) ?>">
                                    <input type="hidden" name="LONGITUDE_ENCLOS" value="<?= htmlspecialchars($reparation['LONGITUDE_ENCLOS']) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="idPersonnel" class="form-label fw-bold">
                                        <i class="bi bi-person"></i> Personnel responsable
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control form-control-lg"
                                        id="idPersonnel"
                                        disabled
                                        value="<?= htmlspecialchars(($reparation['NOM'] ?? '') . ' ' . ($reparation['PRENOM'] ?? '')) ?>">
                                    <input type="hidden" name="ID_PERSONNEL" value="<?= htmlspecialchars($reparation['ID_PERSONNEL']) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="idPrestataire" class="form-label fw-bold">
                                        <i class="bi bi-person-badge"></i> Prestataire impliqué
                                    </label>
                                    <select
                                        class="form-control form-control-lg"
                                        id="idPrestataire"
                                        name="ID_PRESTATAIRE"
                                        aria-label="Sélectionner un prestataire">
                                        <option value="">-- Aucun prestataire --</option>
                                        <?php if (!empty($prestataires)): ?>
                                            <?php foreach ($prestataires as $prestataire): ?>
                                                <option value="<?= htmlspecialchars($prestataire['ID_PRESTATAIRE']) ?>"
                                                    <?= ($reparation['ID_PRESTATAIRE'] == $prestataire['ID_PRESTATAIRE']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($prestataire['NOM_PRESTATAIRE'] . ' ' . $prestataire['PRENOM_PRESTATAIRE']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="" disabled>Aucun prestataire disponible</option>
                                        <?php endif; ?>
                                    </select>
                                    <small class="form-text text-muted d-block mt-1">
                                        Sélectionnez un prestataire externe si impliqué dans l'intervention.
                                    </small>
                                </div>

                                <div class="col-12">
                                    <label for="natureReparation" class="form-label fw-bold">
                                        <i class="bi bi-tools"></i> Description/Nature de l'intervention *
                                    </label>
                                    <textarea
                                        class="form-control form-control-lg"
                                        id="natureReparation"
                                        name="NATURE_REPARATION"
                                        rows="3"
                                        placeholder="Décrivez la nature de la réparation ou de l'entretien..."
                                        required><?= htmlspecialchars($reparation['NATURE_REPARATION'] ?? '') ?></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="coutReparation" class="form-label fw-bold">
                                        <i class="bi bi-cash-stack"></i> Coût réparation (€)
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control form-control-lg"
                                        id="coutReparation"
                                        name="COUT_REPARATION"
                                        step="0.01"
                                        min="0"
                                        value="<?= htmlspecialchars($reparation['COUT_REPARATION'] ?? '') ?>"
                                        placeholder="Ex : 150.50"
                                        aria-label="Coût de la réparation">
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-2 pt-3">
                                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                            <i class="bi bi-check-circle"></i> Enregistrer les modifications
                                        </button>
                                        <a href="index.php?action=profilEnclos&latitude=<?= $reparation['LATITUDE_ENCLOS'] ?>&longitude=<?= $reparation['LONGITUDE_ENCLOS'] ?>" class="btn btn-secondary btn-lg">
                                            <i class="bi bi-arrow-left"></i> Annuler
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>