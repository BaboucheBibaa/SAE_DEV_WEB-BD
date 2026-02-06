<div class="container mt-4">
    <h2>Liste des Employés</h2>
    
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($employees)): ?>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?= $employee['ID_Personnel'] ?? '' ?></td>
                        <td><?= $employee['Nom'] ?? '' ?></td>
                        <td><?= $employee['Prenom'] ?? '' ?></td>
                        <td><?= $employee['mail'] ?? '' ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary">Modifier</button>
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Aucun employé trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>