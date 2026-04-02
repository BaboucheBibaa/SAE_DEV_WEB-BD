<main class="flex-grow-1">
	<div class="container py-5">
		<div class="text-center mb-5">
			<h1 class="h2 fw-bold mb-2"><i class="bi bi-shop"></i> Statistiques Boutiques</h1>
			<p class="text-muted">Chiffre d'affaires moyen (mensuel et annuel)</p>
		</div>

		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="card border-0 shadow-sm">
					<div class="card-body p-4">
						<?php if (!empty($boutiques)): ?>
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<thead class="table-primary">
										<tr>
											<th><i class="bi bi-shop"></i> Nom Boutique</th>
											<th class="text-end">CA Moyen Mensuel</th>
											<th class="text-end">CA Annuel Estimé</th>
											<th class="text-center">Nb Opérations</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$totalMensuel = 0;
											$totalAnnuel = 0;
											foreach ($boutiques as $boutique):
												$totalMensuel += floatval($boutique['CA_MOYEN_MENSUEL'] ?? 0);
												$totalAnnuel += floatval($boutique['CA_ANNUEL_ESTIME'] ?? 0);
										?>
											<tr>
												<td class="fw-bold"><?= htmlspecialchars($boutique['NOM_BOUTIQUE']) ?></td>
												<td class="text-end"><?= $boutique['CA_MOYEN_MENSUEL']?> €</td>
												<td class="text-end text-success fw-bold"><?= $boutique['CA_ANNUEL_ESTIME']?> €</td>
												<td class="text-center"><span class="badge bg-secondary"><?= $boutique['NB_OPERATIONS'] ?? 0 ?></span></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
									<tfoot class="table-light fw-bold">
										<tr>
											<td>TOTAL</td>
											<td class="text-end"><?= $totalMensuel?> €</td>
											<td class="text-end text-success"><?= $totalAnnuel?> €</td>
											<td class="text-center">-</td>
										</tr>
									</tfoot>
								</table>
							</div>
						<?php else: ?>
							<div class="alert alert-info" role="alert">
								<i class="bi bi-info-circle"></i> Aucune boutique trouvée
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
