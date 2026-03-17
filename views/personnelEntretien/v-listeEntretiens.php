<main class="flex-grow-1">
	<div class="container py-5">
		<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
			<div>
				<h1 class="h2 fw-bold mb-1">Mes entretiens</h1>
				<p class="text-muted mb-0">Historique des reparations enregistrees par vos soins</p>
			</div>
			<div class="d-flex gap-2">
				<a href="index.php?action=formAjoutEntretien" class="btn btn-success">
					<i class="bi bi-plus-circle"></i> Nouvel entretien
				</a>
				<a href="index.php?action=personnelEntretienDashboard" class="btn btn-outline-secondary">
					<i class="bi bi-arrow-left"></i> Retour dashboard
				</a>
			</div>
		</div>

		<?php if (empty($reparations)): ?>
			<div class="alert alert-info mb-0">
				<i class="bi bi-info-circle"></i>
				Aucun entretien enregistre pour le moment.
			</div>
		<?php else: ?>
			<div class="card border-0 shadow-sm">
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-hover align-middle mb-0">
							<thead class="table-light">
								<tr>
									<th>Date debut</th>
									<th>Date fin</th>
									<th>Enclos</th>
									<th>Type enclos</th>
									<th>Zone</th>
									<th>Prestataire</th>
									<th>Nature</th>
									<th>Cout</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($reparations as $reparation): ?>
									<tr>
										<td>
											<?= htmlspecialchars(!empty($reparation['DATE_DEBUT_REPARATION']) ? date('d/m/Y', strtotime($reparation['DATE_DEBUT_REPARATION'])) : '-') ?>
										</td>
										<td>
											<?= htmlspecialchars(!empty($reparation['DATE_FIN']) ? date('d/m/Y', strtotime($reparation['DATE_FIN'])) : 'En cours') ?>
										</td>
										<td>
											<span class="small text-muted d-block">Lat: <?= htmlspecialchars($reparation['LATITUDE_ENCLOS'] ?? '-') ?></span>
											<span class="small text-muted d-block">Lng: <?= htmlspecialchars($reparation['LONGITUDE_ENCLOS'] ?? '-') ?></span>
										</td>
										<td><?= htmlspecialchars($reparation['TYPE_ENCLOS'] ?? '-') ?></td>
										<td><?= htmlspecialchars($reparation['ID_ZONE'] ?? '-') ?></td>
										<td><?= htmlspecialchars($reparation['ID_PRESTATAIRE'] ?? 'Interne') ?></td>
										<td style="min-width: 240px;"><?= htmlspecialchars($reparation['NATURE_REPARATION'] ?? '-') ?></td>
										<td>
											<?= htmlspecialchars(isset($reparation['COUT_REPARATION']) ? number_format((float) $reparation['COUT_REPARATION'], 2, ',', ' ') . ' EUR' : '-') ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</main>
