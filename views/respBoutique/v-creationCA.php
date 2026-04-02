<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0"><i class="bi bi-currency-euro"></i> Ajouter le chiffre d'affaires du jour</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($boutique['ID_BOUTIQUE'])): ?>
                        <div class="alert alert-warning mb-0">Aucune boutique n'est associée à votre compte.</div>
                    <?php else: ?>
                        <form action="index.php?action=ajoutCA" method="POST">
                            <div class="mb-3">
                                <label for="id_boutique" class="form-label">Boutique</label>
                                <label class="form-control" id="id_boutique">
                                    <?= htmlspecialchars($boutique['NOM_BOUTIQUE']) ?>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label for="date_ca" class="form-label">Date du CA journalier <span class="text-danger">*</span></label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="date_ca"
                                    name="date_ca"
                                    value="<?= htmlspecialchars($_POST['date_ca'] ?? date('Y-m-d')) ?>"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="montant_ca" class="form-label">Montant (€) <span class="text-danger">*</span></label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="montant_ca"
                                    name="montant_ca"
                                    min="0"
                                    placeholder="Ex: 1245.90"
                                    required>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save"></i> Enregistrer le CA
                                </button>
                                <a href="index.php?action=respBoutiqueDashboard" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Retour
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>