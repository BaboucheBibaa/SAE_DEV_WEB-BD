<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="card-title mb-4">PROFIL UTILISATEUR</h2>

                <?php if (isset($_SESSION['message_success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($_SESSION['message_success']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['message_success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['message_error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($_SESSION['message_error']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['message_error']); ?>
                <?php endif; ?>

                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Email</div>
                            <div class="text-muted"><?= htmlspecialchars($user['MAIL'] ?? '') ?></div>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Nom</div>
                            <div class="text-muted"><?= htmlspecialchars($user['NOM'] ?? '') ?></div>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Prénom</div>
                            <div class="text-muted"><?= htmlspecialchars($user['PRENOM'] ?? '') ?></div>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Inscrit le</div>
                            <div class="text-muted"><?= htmlspecialchars($user['DATE_ENTREE'] ?? '') ?></div>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Fonction actuelle au sein du zoo</div>
                            <div class="text-muted"><?= htmlspecialchars($user['NOM_FONCTION'] ?? '') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modif du mdp -->
        <?php if ($_SESSION['user']['ID_PERSONNEL'] == $_GET['id']): ?>
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4">Modifier mon mot de passe</h3>

                    <form action="index.php?action=update_password" method="POST">
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Mot de passe actuel <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nouveau mot de passe <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                            <small class="text-muted">Minimum 6 caractères</small>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-shield-lock"></i> Modifier le mot de passe
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>