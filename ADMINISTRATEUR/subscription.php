<?php
    include 'Connexion.php';

    // Fonction pour récupérer tous les abonnements
    function getSubscriptions($conn) {
        $sql = "SELECT * FROM subscription ORDER BY date_souscription DESC";
        $result = $conn->query($sql);
        $subscriptions = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $subscriptions[] = $row;
            }
        }
        return $subscriptions;
    }

    $subscriptions = getSubscriptions($conn);
?>
<div class="subscriptionTable">
    <h2>Liste des Abonnements (Subscriptions)</h2>
    <div class="tab">
         <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Date de Souscription</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($subscriptions)): ?>
                <tr>
                    <td colspan="3">Aucun abonné pour l'instant 🤧.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($subscriptions as $sub): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sub['id']); ?></td>
                        <td><?php echo htmlspecialchars($sub['email']); ?></td>
                        <td><?php echo htmlspecialchars($sub['date_souscription']); ?></td>
                        <td><?php echo htmlspecialchars($sub['message']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
   
</div>
<?php $conn->close(); ?>
<style>
    .subscriptionTable h2{
        margin:2% 0% 0% 2%;
    }
    table {
        width: 98%;
        border-collapse: collapse;
        margin:auto;
        margin-top: 15px;
    }

    table th,
    table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    table th {
        background-color: #e9ecef;
        font-weight: bold;
        color: var(--secondary-color);
    }
</style>