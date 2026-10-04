<?php
 require 'fpdf\fpdf.php';    

 function genererFacturePDF($numeroCommande, $nomClient, $periodereservation, $produits, $tableReservee, $montantTotal) {
        $pdf = new FPDF();
        $pdf->AddPage();

        // En-tête
        $pdf->Image('C:\xampp\htdocs\2025_projet\Reservation_Pour_Restaurant\ADMINISTRATEUR\image\file_0000000025e87243b46671be8e1a764d.png', 10, 10, 30, 30);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'FEDCOM FOOD', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Facture de commande', 0, 1, 'C');
        $pdf->Ln(20);

        // Informations client
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Informations client', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, "Client : $nomClient", 0, 1);
        $pdf->Cell(0, 10, "Table reservee : $tableReservee", 0, 1);
        $pdf->Cell(0, 10, "Date et Heure Reservation : $periodereservation", 0, 1);
        $pdf->Ln(10);

        // Liste des produits
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(90, 10, 'Produit', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Prix', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Quantite', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Total', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 12);

        // recuperer les infos des produits
        $go = json_decode($produits, true);
        foreach ($go as $produit) {
        $total_unitaire = $produit['prix'] * $produit['qte'] ;
        $pdf->Cell(90, 10, $produit['nom'], 1, 0, 'L');
        $pdf->Cell(30, 10, $produit['prix'], 1, 0, 'R');
        $pdf->Cell(35, 10, $produit['qte'], 1, 0, 'C');
        $pdf->Cell(40, 10, $total_unitaire, 1, 1, 'R');
        }

        // Total
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(155, 10, 'Total', 1, 0, 'C');
        $pdf->Cell(40, 10, $montantTotal, 1, 1, 'R');

        // Footer
        $pdf->Ln(20);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Merci pour votre confiance.', 0, 1, 'C');
        $pdf->Cell(0, 10, 'FEDCOM FOOD - Tous droits reserves', 0, 1, 'C');

        $fichier = "factures/facture_$numeroCommande.pdf";

        $pdf->Output('F', $fichier);

        return $fichier;

 }
?>

<?php
    include 'Connexion.php';

    // Fonction pour récupérer toutes les commandes avec les détails du produit
    function getOrders($conn) {
        $sql = "SELECT *
                FROM reservation";
        $result = $conn->query($sql);
        $orders = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders;
}

// Logique de confirmation/annulation de commande
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && isset($_GET['id'])) {
    $order_id = $conn->real_escape_string($_GET['id']);
    $action = $_GET['action'];
    $message = '';

    if ($action == 'confirm') {
        // Récupérer le prix total de la commande pour s'assurer qu'il est correct
        $sql_check = "SELECT prix_total FROM reservation WHERE id ='$order_id'";
        $result_check = $conn->query($sql_check);
        if ($result_check->num_rows > 0) {
            $row = $result_check->fetch_assoc();
            $prix_total_calcule = $row['prix_total'];

            //Notification du client
            $sqlMail =" SELECT * FROM reservation WHERE id=$order_id ";
            $resultMail = $conn->query($sqlMail);
                 if(mysqli_num_rows($resultMail) >0){
                    while($rowMail = mysqli_fetch_assoc($resultMail)){
                       $subject = "FEDCOM FOOD Confirmation Commande";
                       $corps = '
                                    <html>
                                    <body style="font-family: Arial, sans-serif; font-size:14px; color:#333;">

                                    <p>
                                    Bonjour <strong>'.$rowMail['nom_client'].'</strong>,
                                    </p>

                                    <p>
                                    FEDCOM FOOD vous informe que votre commande effectuée le
                                    <strong>'.$rowMail['periode_actuel_reservation'].'</strong> a été approuvée avec succès.
                                    </p>

                                    <p>
                                    Merci de bien vouloir passer au restaurant pour profiter de votre commande.
                                    </p>

                                    <p>
                                    Si vous préférez une livraison, veuillez cliquer ci-dessous :
                                    </p>

                                    <p>
                                    <a href="mailto:fredmiguelnanguefeulefack@gmail.com?subject=Livraison%20Commande&body=Je%20souhaite%20une%20livraison"
                                    style="display:inline-block;
                                            padding:12px 18px;
                                            background:#28a745;
                                            color:#ffffff;
                                            text-decoration:none;
                                            border-radius:4px;
                                            font-weight:bold;">
                                    Je souhaite une livraison
                                    </a>
                                    </p>

                                    <p>
                                    Cordialement,<br>
                                    <strong>FEDCOM FOOD</strong>
                                    </p>

                                    </body>
                                    </html>
                        ';
                        
                        // Génération du PDF
                         $pdfFile = genererFacturePDF($rowMail['id'], $rowMail['nom_client'], $rowMail['periode_actuel_reservation'], $rowMail['details_panier'], $rowMail['numero_table'], $rowMail['prix_total']);
                       
                        // Boundary
                        $boundary = md5(time());

                        // HEADERS
                        $headers  = "From: FEDCOM FOOD <fedcomfood@gmail.com>\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                        // BODY
                        $body  = "--$boundary\r\n";
                        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
                        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
                        $body .= $corps . "\r\n";

                        // ATTACHMENT
                        if (file_exists($pdfFile)) {
                            $fileContent = chunk_split(base64_encode(file_get_contents($pdfFile)));
                            $fileName = basename($pdfFile);

                            $body .= "--$boundary\r\n";
                            $body .= "Content-Type: application/pdf; name=\"$fileName\"\r\n";
                            $body .= "Content-Transfer-Encoding: base64\r\n";
                            $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n\r\n";
                            $body .= $fileContent . "\r\n";
                        }

                        $body .= "--$boundary--";

                        if (mail($rowMail['email'], $subject, $body, $headers)) {
                            $message= "Message envoyé avec succes à". $rowMail['email'];
                            // Mise à jour du statut et du prix total (au cas où il y aurait eu une erreur initiale)
                            $sql_update = "UPDATE reservation SET statut = 'confirmee', prix_total = '$prix_total_calcule' WHERE id = '$order_id'";
                            if ($conn->query($sql_update) === TRUE) {
                                $message = "Commande confirmée avec succès. Montant total mis à jour: " . $prix_total_calcule . " FCFA.";
                            } else {
                                $message = "Erreur lors de la confirmation: " . $conn->error;
                            }
                           
                        }else{
                            $message= "Erreur d'envoie.<br> Veillez s'il vous plait activer vos données ! ";
                        }
                    }
                 }else {
                             $message = "Email introuvable.";
                 }   
        } else {
            $message = "Commande introuvable.";
        }
    } elseif ($action == 'cancel') {
        $sql_update = "UPDATE reservation SET statut = 'annulee' WHERE id = '$order_id'";
        if ($conn->query($sql_update) === TRUE) {
            $message = "Commande annulée avec succès.";
        } else {
            $message = "Erreur lors de l'annulation: " . $conn->error;
        }
    }
    
    // Redirection pour éviter la soumission multiple du formulaire
    header("Location: Administrateur_page.php?page=orders&order_message=" . urlencode($message));
    exit();
}

$orders = getOrders($conn);
?>
<div class="ordersTable">
    <div style="display: flex;">
        <h2>Gestion des Commandes (Orders)</h2>
     <div class="search-container">
            <input type="text" id="searchInput" placeholder="Rechercher une commande (mode paiement ou date reservation)..." onkeyup="filterProducts()">
     </div>
    </div>
    
    <?php if (isset($_GET['order_message'])): ?>
        <p class="message-info"><?php echo htmlspecialchars($_GET['order_message']); ?></p>
    <?php endif; ?>
     <div class="tab">
        <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom Client</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Mode paiement</th>
                <th>Prix_total</th>
                <th>Numero table</th>
                <th>Date Presence</th>
                <th>Heure Presence</th>
                <th>Periode de Reservation</th>
                <th>Detail Panier</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="12">Aucune commande trouvée.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <tr class="<?php echo $order['statut']; ?> product-card" data-paiement="<?php echo htmlspecialchars($order['mode_paiement']); ?>" data-datecom="<?php echo htmlspecialchars($order['date_reservation']); ?>">
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars($order['nom_client']); ?></td>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['telephone_client']); ?></td>
                        <td><?php echo htmlspecialchars($order['mode_paiement']); ?></td>
                        <td><?php echo number_format($order['prix_total'], 2, ',', ' ') . ' FCFA'; ?></td>
                        <td><?php echo htmlspecialchars($order['numero_table']); ?></td>
                        <td><?php echo htmlspecialchars($order['date_presence']); ?></td>
                        <td><?php echo htmlspecialchars($order['heure_presence']); ?></td>
                        <td><?php echo htmlspecialchars($order['periode_actuel_reservation']); ?></td>
                        <td><?php $panier = $order['details_panier']; $go = json_decode($panier, true);
                             echo"  <table style='background-color:gray; display: flex; justify-content:space-between;'> ";  
                             echo "<tr><th>NOM</th><th>PRIX</th><th >QTE</th><th>TOTAL</th><tr>";
                        foreach($go as $detail): $total_unitaire = $detail['prix'] * $detail['qte'] ; ?>
                                     <tr>   
                                    <td><?php echo $detail["nom"]; ?></td>
                                    <td><?php echo $detail["prix"]; ?></td>
                                    <td ><?php echo $detail["qte"]; ?></td>
                                    <td ><?php echo $total_unitaire; ?></td>
                                    <tr>
                                    <?php endforeach; echo "</table>"?></td>
                        <td><span class="status-badge status-<?php echo $order['statut']; ?>"><?php echo ucfirst($order['statut']); ?></span></td>
                        <td class="actions">
                            <?php if ($order['statut'] == 'en_attente'): ?>
                                <a href="orders.php?action=confirm&id=<?php echo $order['id']; ?>" class="btn-confirm" onclick="return confirm('Confirmez vous vraiment cette commande ?');">Confirmer</a>
                                <a href="orders.php?action=cancel&id=<?php echo $order['id']; ?>" class="btn-cancel" onclick="return confirm('Annulez vous vraiment cette commande ?');">Annuler</a>
                            <?php elseif ($order['statut'] == 'confirmee'): ?>
                                <span class="text-success">Confirmée</span>
                            <?php else: ?>
                                <span class="text-danger">Annulée</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
     </div>
    
</div>
<?php 
$conn->close(); 
?>
<style>
    .ordersTable h2{
        margin: 2% 0% 0% 3%;
    }
     #searchInput { 
        width: 250%; 
        padding: 12px 20px; 
        border-radius: 30px;
         border: 1px solid #ddd;
         margin: 5% 0% 0% 15%;
          font-size: 1rem; 
          outline: none; 
          box-shadow: 0 2px 5px rgba(0,0,0,0.05);
         }
    
    table {
    width: 98%;
    border-collapse: collapse;
    margin:auto;
    margin-left:2%;
    margin-right:2%;
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
    .actions{
        display:flex;
        margin-top: 5%;
    }
    /* Messages */
    .message-success {
        color: #28a745;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .message-error {
        color: #dc3545;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .message-info {
        color: #004085;
        background-color: #cce5ff;
        border: 1px solid #b8daff;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
    }
</style>
<script>
    function filterProducts() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                const name = card.getAttribute('data-paiement');
                const desc = card.getAttribute('data-datecom');
                if(name.includes(query) || desc.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
</script>