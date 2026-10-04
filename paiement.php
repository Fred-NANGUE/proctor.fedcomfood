	<!-- Orange Money API	 -->
<?php	
// Configuration	
$apiKey = 'HxzpH8Qh4KVhweDsbfXAOEqA8fb6qcUJ'; // Remplace par ta clé API Orange	
$apiSecret = 'HYKrPIVEL3T1OdWurstFz0Ak1onSGJXa2ER1E7QZKTtn'; // Remplace par ton secret API Orange	
$baseUrl = 'https://api.orange.cm/orange-money-ussd/v1'; // API Orange Money	
	
// Fonction pour payer	
function payerOrange($amount, $phone, $reference) {	
    global $apiKey, $apiSecret, $baseUrl;	
    $url = $baseUrl . '/payment';	
    $headers = [	
    'Authorization: Basic ' . base64_encode($apiKey . ':' . $apiSecret),	
    'Content-Type: application/json'	
    ];	
    $data = [	
    'amount' => $amount,	
    'currency' => 'XAF',	
    'reference' => $reference,	
    'phone_number' => $phone,	
    'description' => 'Paiement de test'	
    ];	
    $ch = curl_init($url);	
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
    curl_setopt($ch, CURLOPT_POST, true);	
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));	
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);	
    $response = curl_exec($ch);	
    curl_close($ch);	
    return json_decode($response, true);	
}	
	
// Exemple	
$paiement = payerOrange(1000, '237672921799', 'REF123');	
print_r($paiement);	
?>


 <!-- Popup historique commande-->
    <div class="overlay-popup" id="popuphistorique">
        <div class="content-popup" style="max-width:1750px; display: block;">
            <h2 style="color:var(--primary-color); text-align:center; margin-bottom:2%;">HISTORIQUE RESERVATION</h2>
            <spand class="close-popup" onclick="document.getElementById('popuphistorique').style.display='none'">&times;</spand>
            <?php if (isset($_GET['order_message'])): ?>
                <p class="message-info"><?php echo htmlspecialchars($_GET['order_message']); ?></p>
            <?php endif; ?>
             <div class="vbox">
            <div class="profilAdministrateur">
                <?php
                    
                    include 'ADMINISTRATEUR/Connexion.php';
                    /*liste des produits*/
                    if(isset($_SESSION['userCL'])){
                        $id =$_SESSION['userCL']['id'];
                        $nom =$_SESSION['userCL']['nom'];
                    $sqlImageCl="SELECT * FROM client where id=$id ";
                    $results= $conn ->query($sqlImageCl);
                    if(mysqli_num_rows($results) >0){
                        /* afficher les blocus */
                        
                                
                ?>
                <?php
                    while($row = mysqli_fetch_assoc($results)){
            
                ?>
                <img src="image_utilisateur/<?=htmlspecialchars($row['libelleImageCL'])?>" alt="<?=htmlspecialchars($row['nom'])?>">
                <p style="font-height:bold; font-size:16px; font-family:Times New Roman; margin:1% 0% 8% 4%;padding-bottom: 2%; text-align:center;"> 
                    <?=htmlspecialchars($row['nom'])?>
            </p>
                <?php
                    }
                    }
                    else{
                        echo "<p class='alert_admin'> Image non Disponible !</p>";
                    }
                }
                    ?>
            </div>
            <nav>
            <ul>
            <li><a href="?page=statistique" target="_blank" id="dash" class="<?php echo ($page == 'statistique') ? 'active' : ''; ?>">
                <div class="icon-onglet"><i class="fa-solid fa-chart-line"></i></div> <div class="onglet-name">Statistique</div> 
            </a> </li>
            <li><a href="?page=histo_reservation" target="_self" class="<?php echo ($page == 'histo_reservation') ? 'active' : ''; ?>" id="ord">
                <div class="icon-onglet"><i class="fa-solid fa-clipboard-list"></i></div> <div class="onglet-name">Historique Reservation</div>
            </a></li>
            <li><a href="?page=Setting" target="_self" class="<?php echo ($page == 'Setting') ? 'active' : ''; ?>" id="set">
                <div class="icon-onglet"><i class="fa-solid fa-gear"></i></div> <div class="onglet-name">Parametre</div>
            </a></li>
            <li>
               <a href="page_accueil.php" onclick="return confirm('Voulez vous vraiment vous deconnecté')">DECONNEXION</a>
            </li></ul></nav>
        </div>
            <div id="corpusClient">
                    <?php
                        switch($page) {
                            case 'statistique':
                                ?>
        
                                <?php
                                break;
                            case 'histo_reservation':
                                ?>
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
                                                    <th>Date Reservation</th>
                                                    <th>Date Presence</th>
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
                                                        <tr class="<?php echo $order['statut']; ?>">
                                                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                                                            <td><?php echo htmlspecialchars($order['nom_client']); ?></td>
                                                            <td><?php echo htmlspecialchars($order['email']); ?></td>
                                                            <td><?php echo htmlspecialchars($order['telephone_client']); ?></td>
                                                            <td><?php echo htmlspecialchars($order['mode_paiement']); ?></td>
                                                            <td><?php echo number_format($order['prix_total'], 2, ',', ' ') . ' FCFA'; ?></td>
                                                            <td><?php echo htmlspecialchars($order['numero_table']); ?></td>
                                                            <td><?php echo htmlspecialchars($order['date_reservation']); ?></td>
                                                            <td><?php echo htmlspecialchars($order['date_presence']); ?></td>
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
                                                                    <a href="orders.php?action=cancel&id=<?php echo $order['id']; ?>" class="btn-cancel" onclick="return confirm('Annulez vous vraiment cette commande ?');">Annuler</a>
                                                                <?php elseif ($order['statut'] == 'annulee'): ?>
                                                                    <span class="text-danger">Annulée</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                </div>
                                <?php
                                break;
                        
                            case 'Setting':
                                ?>
                                <div id="settings-container">
                                    <h2>Paramètres de l'Administrateur</h2>
                                    <?php if ($message): ?>
                                        <p class="message-info"><?php echo $message; ?><span onclick="this.parentElement.style.display='none';" class="closebtn">&times;</span></p>
                                    <?php endif; ?>

                                    <!-- <?php if ($admin): ?> -->
                                        <form method="POST" action="commande.php?page=Setting">
                                            <div>
                                                <label for="nom">Nom :</label>
                                            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($admin['nom']); ?>" required>
                                            </div>
                                            <div>
                                                <label for="prenom">Prenom :</label>
                                            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($admin['prenom']); ?>" required>
                                            </div>
                                            <div>
                                                <label for="email">Email :</label>
                                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                                            </div>
                                            <div>
                                                <label for="password">Nouveau Mot de passe (laisser vide pour ne pas changer):</label>
                                            <input type="password" id="password" name="password">
                                            </div>
                                            <div>
                                                <button type="submit" class="btn-primary" name="mdfCL" onclick="return confirm('Etes vous sur de vouloir apporter des modifications ?')">Enregistrer les modifications</button>
                                            </div>
                                        
                                        </form>
                                    <!-- <?php else: ?>
                                        <p class="message-error">Impossible de charger les informations de l'administrateur.</p>
                                    <?php endif; ?> -->
                                </div>
                                <?php
                                break;
                        }
                    ?>
            </div>
     
        </div>
    </div>