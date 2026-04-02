<main class="flex-grow-1">
	<div class="container py-5">
		<div class="text-center mb-5">
			<h1 class="h2 fw-bold mb-2"><i class="bi bi-calculator"></i> Dashboard Comptable</h1>
			<p class="text-muted">Vue d'ensemble des statistiques financières du Zoo'land</p>
		</div>

		<div class="row g-4">
			<!-- Section Boutiques -->
			<div class="col-lg-4">
				<div class="card border-0 shadow-sm h-100">
					<div class="card-header bg-primary text-white">
						<h5 class="card-title mb-0">
							<i class="bi bi-shop"></i> Boutiques - CA
						</h5>
					</div>
					<div class="card-body">
						<?php if (!empty($boutiques)): ?>
							<div class="table-responsive">
								<table class="table table-sm table-hover">
									<thead class="table-light">
										<tr>
											<th>Boutique</th>
											<th>CA Moyen Mensuel</th>
											<th>CA Annuel Estimé</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($boutiques as $boutique): ?>
											<tr>
												<td class="fw-bold"><?= htmlspecialchars($boutique['NOM_BOUTIQUE']) ?></td>
												<td><?= $boutique['CA_MOYEN_MENSUEL']?> €</td>
												<td class="text-success"><?=$boutique['CA_ANNUEL_ESTIME']?> €</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<div class="mt-3">
								<a href="index.php?action=statsBoutiques" class="btn btn-sm btn-primary">
									<i class="bi bi-arrow-right"></i> Voir détails
								</a>
							</div>
						<?php else: ?>
							<p class="text-muted mb-0">Aucune donnée disponible</p>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- Section Zones (Réparations) -->
			<div class="col-lg-4">
				<div class="card border-0 shadow-sm h-100">
					<div class="card-header bg-info text-white">
						<h5 class="card-title mb-0">
							<i class="bi bi-hammer"></i> Zones - Réparations
						</h5>
					</div>
					<div class="card-body">
						<?php if (!empty($zones)): ?>
							<div class="table-responsive">
								<table class="table table-sm table-hover">
									<thead class="table-light">
										<tr>
											<th>Zone</th>
											<th>Coût Moyen</th>
											<th>Nb Réparations</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($zones as $zone): ?>
											<tr>
												<td class="fw-bold"><?= htmlspecialchars($zone['NOM_ZONE']) ?></td>
												<td><?= $zone['COUT_MOYEN_REPARATIONS']?> €</td>
												<td><span class="badge bg-secondary"><?= $zone['NB_REPARATIONS'] ?? 0 ?></span></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<div class="mt-3">
								<a href="index.php?action=statsZones" class="btn btn-sm btn-info">
									<i class="bi bi-arrow-right"></i> Voir détails
								</a>
							</div>
						<?php else: ?>
							<p class="text-muted mb-0">Aucune donnée disponible</p>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- Section Masse Salariale -->
			<div class="col-lg-4">
				<div class="card border-0 shadow-sm h-100">
					<div class="card-header bg-success text-white">
						<h5 class="card-title mb-0">
							<i class="bi bi-person-check"></i> Masse Salariale
						</h5>
					</div>
					<div class="card-body">
						<?php if ($employes): ?>
							<div class="stats-summary">
								<div class="mb-3">
									<p class="text-muted mb-1">Salaire Total</p>
									<h4 class="text-success">
										<?= $employes['SALAIRE_TOTAL']?> €
									</h4>
								</div>
								<hr>
								<div class="row text-center">
									<div class="col-6">
										<p class="text-muted mb-1">Nombre d'employés</p>
										<h5><?= $employes['NB_EMPLOYES'] ?? 0 ?></h5>
									</div>
									<div class="col-6">
										<p class="text-muted mb-1">Salaire Moyen</p>
										<h5><?= $employes['SALAIRE_MOYEN']?> €</h5>
									</div>
								</div>
							</div>
							<div class="mt-3">
								<a href="index.php?action=statsMasseSalariale" class="btn btn-sm btn-success">
									<i class="bi bi-arrow-right"></i> Voir détails
								</a>
							</div>
						<?php else: ?>
							<p class="text-muted mb-0">Aucune donnée disponible</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Résumé Global -->
		<div class="row mt-5">
			<div class="col-12">
				<div class="card border-0 shadow-sm">
					<div class="card-header bg-dark text-white">
						<h5 class="card-title mb-0">
							<i class="bi bi-bar-chart"></i> Résumé Global
						</h5>
					</div>
					<div class="card-body">
						<div class="row text-center">
							<div class="col-md-4">
								<h6 class="text-muted">CA Total Annuel Estimé</h6>
								<?php
									$totalCA = 0;
									if (!empty($boutiques)) {
										foreach ($boutiques as $b) {
											$totalCA += floatval($b['CA_ANNUEL_ESTIME'] ?? 0);
										}
									}
								?>
								<h3 class="text-primary"><?= $totalCA?> €</h3>
							</div>
							<div class="col-md-4">
								<h6 class="text-muted">Dépenses Réparations (Total)</h6>
								<?php
									$totalReparations = 0;
									if (!empty($zones)) {
										foreach ($zones as $z) {
											$totalReparations += (floatval($z['COUT_MOYEN_REPARATIONS'] ?? 0) * floatval($z['NB_REPARATIONS'] ?? 0));
										}
									}
								?>
								<h3 class="text-info"><?= $totalReparations?> €</h3>
							</div>
							<div class="col-md-4">
								<h6 class="text-muted">Masse Salariale</h6>
								<h3 class="text-success"><?= $employes['SALAIRE_TOTAL']?> €</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</main>
