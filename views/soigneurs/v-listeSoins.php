<main class="flex-grow-1">
    <div class="container py-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="h2 fw-bold mb-2">Historique des soins</h1>
            <p class="text-muted">Liste des soins que vous avez effectués</p>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="index.php?action=soigneursDashboard" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <a href="index.php?action=formAjoutSoin" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Ajouter un soin
            </a>
        </div>

        <!-- Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (isset($soins) && is_array($soins) && count($soins) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="bi bi-paw"></i> Animal</th>
                                    <th><i class="bi bi-calendar-event"></i> Date du soin</th>
                                    <th><i class="bi bi-file-text"></i> Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($soins as $soin): ?>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold"><a href="index.php?action=profilAnimal&id=<?= htmlspecialchars($soin['ID_ANIMAL'] ?? '') ?>"><?= htmlspecialchars($soin['NOM_ANIMAL'] ?? 'Inconnu') ?></a></span>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($soin['DATE_SOIN'] ?? '') ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($soin['DESCRIPTION_SOIN'] ?? '') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-clipboard-x" style="font-size: 3rem; color: #6c757d;"></i>
                        <p class="text-muted mt-3 mb-0">Aucun soin enregistré pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
