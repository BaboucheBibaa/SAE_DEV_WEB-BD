<main class="flex-grow-1">
	<div class="container py-5">
		<div class="text-center mb-5">
			<h1 class="h2 fw-bold mb-2"><i class="bi bi-person-check"></i> Masse Salariale</h1>
			<p class="text-muted">Résumé de la masse salariale totale</p>
		</div>

		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<?php if ($employes): ?>
					<!-- Card Principal -->
					<div class="card border-0 shadow-lg mb-4">
						<div class="card-body p-5">
							<div class="row text-center">
								<div class="col-md-6 border-end border-light">
									<p class="text-muted h6 mb-3">Salaire Total Mensuel</p>
									<h2 class="text-success fw-bold">
										<?= $employes['SALAIRE_TOTAL']?> €
									</h2>
								</div>
								<div class="col-md-6">
									<p class="text-muted h6 mb-3">Nombre d'employés</p>
									<h2 class="text-primary fw-bold">
										<?= $employes['NB_EMPLOYES'] ?? 0 ?>
									</h2>
								</div>
							</div>
						</div>
					</div>

					<!-- Card Moyenne -->
					<div class="card border-0 shadow">
						<div class="card-body p-4">
							<div class="row align-items-center">
								<div class="col-md-8">
									<h5 class="mb-0">Salaire Moyen par Employé</h5>
									<p class="text-muted small mb-0">Calculé sur la base du nombre d'employés actifs</p>
								</div>
								<div class="col-md-4 text-end">
									<h3 class="text-info fw-bold">
										<?= $employes['SALAIRE_MOYEN']?> €
									</h3>
								</div>
							</div>
						</div>
					</div>

					<!-- Détails supplémentaires -->
					<div class="alert alert-light border-start border-4 border-success mt-4" role="alert">
						<h6 class="alert-heading">
							<i class="bi bi-info-circle"></i> Informations
						</h6>
						<small>
							<p class="mb-1"><strong>Salaire Total mensuel :</strong> <?= $employes['SALAIRE_TOTAL']?> €</p>
							<p class="mb-1"><strong>Effectif :</strong> <?= $employes['NB_EMPLOYES'] ?? 0 ?> employé(s)</p>
							<p class="mb-0"><strong>Coût moyen par employé :</strong> <?= $employes['SALAIRE_MOYEN']?> € / mois</p>
						</small>
					</div>

				<?php else: ?>
					<div class="alert alert-warning" role="alert">
						<i class="bi bi-exclamation-triangle"></i> Aucune donnée de masse salariale disponible
					</div>
				<?php endif; ?>

				<div class="mt-5 text-center">
					<a href="index.php?action=comptableDashboard" class="btn btn-primary">
						<i class="bi bi-arrow-left"></i> Retour au Dashboard
					</a>
				</div>
			</div>
		</div>
	</div>
</main>
