<main class="flex-grow-1">
	<div class="container py-5">
		<div class="text-center mb-5">
			<h1 class="h2 fw-bold mb-2"><i class="bi bi-hammer"></i> Statistiques Zones - Réparations</h1>
			<p class="text-muted">Coût moyen des réparations par zone</p>
		</div>

		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="card border-0 shadow-sm">
					<div class="card-body p-4">
						<?php if (!empty($zones)): ?>
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<thead class="table-info">
										<tr>
											<th><i class="bi bi-geo-alt"></i> Nom Zone</th>
											<th class="text-end">Coût Moyen Réparation</th>
											<th class="text-center">Nombre Réparations</th>
											<th class="text-end">Coût Total Estimé</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$totalCoutMoyen = 0;
											$totalReparations = 0;
											$totalCoutEstime = 0;
											foreach ($zones as $zone):
												$coutEstime = floatval($zone['COUT_TOTAL_REPARATIONS'] ?? 0);
												$totalCoutMoyen += floatval($zone['COUT_MOYEN_REPARATIONS'] ?? 0);
												$totalReparations += floatval($zone['NB_REPARATIONS'] ?? 0);
												$totalCoutEstime += $coutEstime;
										?>
											<tr>
												<td class="fw-bold"><?= htmlspecialchars($zone['NOM_ZONE']) ?></td>
												<td class="text-end"><?= $zone['COUT_MOYEN_REPARATIONS']?> €</td>
												<td class="text-center"><span class="badge bg-secondary"><?= $zone['NB_REPARATIONS'] ?? 0 ?></span></td>
												<td class="text-end text-warning fw-bold"><?= $coutEstime?> €</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
									<tfoot class="table-light fw-bold">
										<tr>
											<td>TOTAL / MOYENNE</td>
											<td class="text-end"><?= count($zones) > 0 ? $totalCoutMoyen / count($zones) : 0 ?> €</td>
											<td class="text-center"><?= $totalReparations ?></td>
											<td class="text-end text-warning"><?= $totalCoutEstime?> €</td>
										</tr>
									</tfoot>
								</table>
							</div>
						<?php else: ?>
							<div class="alert alert-info" role="alert">
								<i class="bi bi-info-circle"></i> Aucune zone trouvée
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="mt-4 text-center">
					<a href="index.php?action=comptableDashboard" class="btn btn-primary">
						<i class="bi bi-arrow-left"></i> Retour au Dashboard
					</a>
				</div>
			</div>
		</div>
	</div>
</main>
