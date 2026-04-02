<main class="flex-grow-1">
    <div class="container my-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?action=home">Accueil</a></li>
                <li class="breadcrumb-item"><a href="index.php?action=respBoutiqueDashboard">Dashboard Responsable de Boutique</a></li>
                <li class="breadcrumb-item active" aria-current="page">Statistiques de la boutique</li>
            </ol>
        </nav>

        <div class="row align-items-center mb-4">
            <div class="col-lg-8">
                <h1 class="display-5 text-primary mb-2">
                    <i class="bi bi-graph-up-arrow me-2"></i>Statistiques de la boutique
                </h1>
                <p class="lead text-muted mb-0">
                    Statistiques détaillées de la boutique
                    <strong><?= htmlspecialchars($boutique['NOM_BOUTIQUE'] ?? 'votre boutique') ?></strong>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="index.php?action=respBoutiqueDashboard" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Retour au dashboard
                </a>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">CA du jour</h6>
                                <h3 class="mb-0"><?= empty($caJournalier['TOTAL_CA'])    ? 'Non posté' : htmlspecialchars($caJournalier['TOTAL_CA']) ?> EUR</h3>
                            </div>
                        </div>
                        <small class="text-muted">Aujourd'hui</small>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">CA mensuel</h6>
                                <h3 class="mb-0"><?= empty($caMensuel['TOTAL_CA'])    ? '0' : htmlspecialchars($caMensuel['TOTAL_CA']) ?> EUR</h3>
                            </div>
                        </div>
                        <small class="text-muted">Mois en cours</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">CA annuel</h6>
                                <h3 class="mb-0"><?= empty($caAnnuel['TOTAL_CA'])    ? '0' : htmlspecialchars($caAnnuel['TOTAL_CA']) ?> EUR</h3>
                            </div>
                        </div>
                        <small class="text-muted">Année en cours</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">CA Moyen Annuel</h6>
                                <h3 class="mb-0"><?= empty($caMoyenAnnuel['MOYENNE_CA'])    ? '0' : htmlspecialchars($caMoyenAnnuel['MOYENNE_CA']) ?> EUR</h3>
                            </div>
                        </div>
                        <small class="text-muted">Moyenne sur l'année en cours</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="mb-0">Evolution du chiffre d'affaires</h5>
                    <p class="text-muted mb-0">Simulation des tendances hebdomadaires</p>
                </div>
                <div class="card-body">
                    <div class="bg-light rounded p-4" style="min-height: 260px;">
                        <div class="h-100 d-flex flex-column justify-content-center align-items-center text-center text-muted">
                            <div class="bg-light rounded p-4" style="min-height: 260px;">
                                <img
                                    src="index.php?action=renderGraphiqueCA"
                                    alt="Graphique du chiffre d'affaires"
                                    class="img-fluid d-block mx-auto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <a href="index.php?action=respBoutiqueDashboard" class="btn btn-outline-primary">
                    <i class="bi bi-grid"></i> Retour au dashboard
                </a>
            </div>
        </div>
    </div>
</main>