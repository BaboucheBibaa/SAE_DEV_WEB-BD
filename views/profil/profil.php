<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="card-title mb-4">Mon profil</h2>
                
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Email</div>
                            <div class="text-muted"><?= htmlspecialchars($user['mail']) ?></div>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Nom</div>
                            <div class="text-muted"><?= htmlspecialchars($user['Nom']) ?></div>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Prénom</div>
                            <div class="text-muted"><?= htmlspecialchars($user['Prenom']) ?></div>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Inscrit le</div>
                            <div class="text-muted"><?= htmlspecialchars($user['Date_Entree']) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>