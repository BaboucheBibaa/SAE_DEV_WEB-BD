<main class="flex-grow-1">
	<div class="container py-5">
		<div class="text-center mb-5">
			<h1 class="h2 fw-bold mb-2">Prendre en compte l'entretien d'un enclos</h1>
			<p class="text-muted">Enregistrez une intervention</p>
		</div>

		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card border-0 shadow-sm">
					<div class="card-body p-4">
						<form method="POST" action="index.php?action=ajoutEntretien">
							<div class="row g-3">
								<div class="col-md-6">
									<label for="dateDebut" class="form-label fw-bold">
										<i class="bi bi-calendar-event"></i> Date début réparation *
									</label>
									<input
										type="date"
										class="form-control form-control-lg"
										id="dateDebut"
										name="DATE_DEBUT_REPARATION"
										required
										value="<?= date('Y-m-d') ?>"
										aria-label="Date de debut de reparation">
								</div>

								<div class="col-md-6">
									<label for="dateFin" class="form-label fw-bold">
										<i class="bi bi-calendar-check"></i> Date de fin
									</label>
									<input
										type="date"
										class="form-control form-control-lg"
										id="dateFin"
										name="DATE_FIN"
										aria-label="Date de fin de reparation">
								</div>

								<div class="col-md-6">
									<label for="latitudeEnclos" class="form-label fw-bold">
										<i class="bi bi-geo-alt"></i> Latitude enclos *
									</label>
									<input
										type="number"
										class="form-control form-control-lg"
										id="latitudeEnclos"
										name="LATITUDE_ENCLOS"
										required
										placeholder="Ex : 45"
										aria-label="Latitude de l enclos">
								</div>

								<div class="col-md-6">
									<label for="longitudeEnclos" class="form-label fw-bold">
										<i class="bi bi-geo-alt-fill"></i> Longitude enclos *
									</label>
									<input
										type="number"
										class="form-control form-control-lg"
										id="longitudeEnclos"
										name="LONGITUDE_ENCLOS"
										required
										placeholder="Ex : 2"
										aria-label="Longitude de l enclos">
								</div>

								<div class="col-md-6">
									<label for="idPrestataire" class="form-label fw-bold">
										<i class="bi bi-person-badge"></i> ID du prestataire si impliqué
									</label>
									<input
										type="number"
										class="form-control form-control-lg"
										id="idPrestataire"
										name="ID_PRESTATAIRE"
										min="1"
										placeholder="Ex : 3"
										aria-label="Identifiant du prestataire">
									<small class="form-text text-muted d-block mt-1">
										Laissez vide si aucun prestataire externe n'est impliqué.
									</small>
								</div>

								<div class="col-md-6">
									<label for="coutReparation" class="form-label fw-bold">
										<i class="bi bi-cash-stack"></i> Coût réparation
									</label>
									<input
										type="number"
										class="form-control form-control-lg"
										id="coutReparation"
										name="COUT_REPARATION"
										min="0"
										max="99999999.99"
										step="0.01"
										placeholder="Ex : 1200.50"
										aria-label="Coût de la réparation">
								</div>

								<div class="col-12">
									<label for="natureReparation" class="form-label fw-bold">
										<i class="bi bi-file-text"></i> Nature de la réparation
									</label>
									<textarea
										class="form-control form-control-lg"
										id="natureReparation"
										name="NATURE_REPARATION"
										rows="4"
										maxlength="200"
										placeholder="Décrivez la nature de l'intervention..."
										aria-label="Nature de la réparation"></textarea>
									<small class="form-text text-muted d-block mt-1">
										Maximum 200 caractères.
									</small>
								</div>
							</div>

							<div class="d-flex gap-2 mt-4">
								<button type="submit" class="btn btn-lg btn-success flex-grow-1">
									<i class="bi bi-check-circle"></i> Enregistrer l'entretien
								</button>
								<a href="index.php?action=personnelEntretienDashboard" class="btn btn-lg btn-secondary">
									<i class="bi bi-x-circle"></i> Annuler
								</a>
							</div>

							<div class="alert alert-light border-start border-primary mt-4 mb-0">
								<small class="text-muted">
									<strong>*</strong> Champ obligatoire.
								</small>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
