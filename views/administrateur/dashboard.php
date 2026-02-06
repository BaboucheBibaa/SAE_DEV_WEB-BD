<div class="container mt-4">
    <h2>Liste des Employés</h2>

    <a href="index.php?action=create_employee" class="btn btn-sm btn-success">Ajouter un Employé</a>
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
                            <a href="index.php?action=edit_employee&id=<?= $employee['ID_Personnel'] ?>" class="btn btn-sm btn-primary">Modifier</a>
                            <a href="index.php?action=remove_employee&id=<?= $employee['ID_Personnel'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')">Supprimer</a>
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