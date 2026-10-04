<?php
    session_start();
    include 'ADMINISTRATEUR/Connexion.php';
    $message = '';
    $admin = null;

    if(isset($_SESSION['userCL'])){
        $id =$_SESSION['userCL']['id'];
    $sql_select = "SELECT id , nom, prenom,numero, email FROM client WHERE id = '$id'";
    $result_select = $conn->query($sql_select);
    if ($result_select->num_rows > 0) {
        $admin = $result_select->fetch_assoc();
    } else {
        $message = "Client non trouvé.";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mdfCL"])) {
        $nom = $conn->real_escape_string($_POST['nom']);
        $prenom = $conn->real_escape_string($_POST['prenom']);
        $numero = $conn->real_escape_string($_POST['numero']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $sql_update = "UPDATE client SET nom='$nom', prenom='$prenom',numero='$numero', email='$email' ";
        
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql_update .= ", password='$password_hash'";
        }
        
        $sql_update .= " WHERE id='$id'";

        if ($conn->query($sql_update) === TRUE) {
            $message = "Informations de l'administration mises à jour avec succès.";
            $result_select = $conn->query($sql_select);
            $admin = $result_select->fetch_assoc();
        } else {
            $message = "Erreur de mise à jour: " . $conn->error;
        }
    }
    }
    $conn ->close(); 
?>

<?php

 include ("ADMINISTRATEUR/Connexion.php");
 function getOrders($conn) {
    if(isset($_SESSION['userCL'])){
        $email = $_SESSION['userCL']['email'];
        $sql = "SELECT *
                FROM reservation WHERE email= '$email'";
        $result = $conn->query($sql);
        $orders = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders;
} }
 $orders = getOrders($conn); 
 $page = isset($_GET['page']) ? $_GET['page'] : 'statistique';

 // Logique de confirmation/annulation de commande
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && isset($_GET['id'])) {
    $order_id = $conn->real_escape_string($_GET['id']);
    $action = $_GET['action'];
    $message = '';

    if ($action == 'cancel') {
        $sql_update = "UPDATE reservation SET statut = 'annulee' WHERE id = '$order_id'";
        if ($conn->query($sql_update) === TRUE) {
            $message = "Commande annulée avec succès.";
        } else {
            $message = "Erreur lors de l'annulation: " . $conn->error;
        }
    }
    
    // Redirection pour éviter la soumission multiple du formulaire
    header("Location: commande.php?page=histo_reservation&order_message=" . urlencode($message));
    exit();
}
?>

<!-- Total Commande -->
<!-- Total Montant de commandes confirmées -->
<?php
          include ("ADMINISTRATEUR/Connexion.php");
          $id =$_SESSION['userCL']['email'];
           $countArgentCommandeConfirme ="SELECT SUM(prix_total) AS sommeArgent FROM reservation WHERE statut='confirmee' AND email='$id'";
           $countArgentCommandeConfirme = $conn ->query($countArgentCommandeConfirme);
           if($countArgentCommandeConfirme){
             $countArgentCommandeConfirme = $countArgentCommandeConfirme ->fetch_assoc();
           }
           $conn ->close(); 
        ?>
<!-- Total Commande Confirmée -->
<?php
            include ("ADMINISTRATEUR/Connexion.php");
            $id =$_SESSION['userCL']['email'];
            $countReservationConfirme ="SELECT COUNT(*) AS totalConfirm FROM reservation WHERE statut ='confirmee' AND email='$id'";
            $resultCountReservationConfirme = $conn ->query($countReservationConfirme) ;
            if($resultCountReservationConfirme){
                $resultCountReservationConfirme = $resultCountReservationConfirme ->fetch_assoc();
            }
            $conn ->close(); 
            ?>
<!-- Total Commande annulée -->
<?php
            include ("ADMINISTRATEUR/Connexion.php");  
            $id =$_SESSION['userCL']['email'];
            $countReservationAnnule ="SELECT COUNT(*) AS totalClose FROM reservation WHERE statut ='annulee' AND email='$id'";
            $resultCountReservationAnnule = $conn ->query($countReservationAnnule) ;
            if($resultCountReservationAnnule){
                $resultCountReservationAnnule = $resultCountReservationAnnule ->fetch_assoc();
            }   
            $conn ->close();      
            ?>
<!-- Total Commande en attente -->
        <?php
            include ("ADMINISTRATEUR/Connexion.php");    
            $id =$_SESSION['userCL']['email'];     
            $countReservationAttente ="SELECT COUNT(*) AS totalWait FROM reservation WHERE statut ='en_attente' AND email='$id'";         
            $resultCountReservationAttente = $conn ->query($countReservationAttente) ;          
            if($resultCountReservationAttente){
                $resultCountReservationAttente = $resultCountReservationAttente ->fetch_assoc();
            }
            $conn ->close(); 
        ?>
<!-- Total Commentaire -->
        <?php
            include ("ADMINISTRATEUR/Connexion.php");
            $id =$_SESSION['userCL']['email'];
            $countComm ="SELECT COUNT(*) AS total FROM commentaire WHERE email='$id'";
            $resultCountCommentaire = $conn ->query($countComm) ;
            if($resultCountCommentaire){
                $resultCountCommentaire = $resultCountCommentaire ->fetch_assoc();
            }
            $conn ->close(); 
        ?>
<div id="html">
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
            <img src="image_utilisateur/<?=htmlspecialchars($row['libelleImageCL'])?>"
                alt="<?=htmlspecialchars($row['nom'])?>">
            <p
                style="font-height:bold; font-size:16px; font-family:Times New Roman; margin:1% 0% 8% 4%;padding-bottom: 2%; text-align:center;">
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
        <a href="?page=statistique" id="dash" class="<?php echo ($page == 'statistique') ? 'active' : ''; ?>"
            style="margin-top:2%;">
            <div class="icon-onglet"><i class="fa-solid fa-chart-line"></i></div>
            <div class="onglet-name">Statistique</div>
        </a>
        <a href="?page=histo_reservation" class="<?php echo ($page == 'histo_reservation') ? 'active' : ''; ?>"
            id="ord">
            <div class="icon-onglet"><i class="fa-solid fa-clipboard-list"></i></div>
            <div class="onglet-name">Historique Reservation</div>
        </a>
        <a href="?page=Setting" class="<?php echo ($page == 'Setting') ? 'active' : ''; ?>" id="set">
            <div class="icon-onglet"><i class="fa-solid fa-gear"></i></div>
            <div class="onglet-name">Parametre</div>
        </a>
        <div style="float:bottom; margin-top:50%;">
            <a href="page_accueil.php"
                >RETOUR</a>
        </div>
        <div style="float:bottom; margin-top:0%;">
            <a href="logout.php"
                onclick="return confirm('Voulez vous vraiment vous deconnecté')">DECONNEXION</a>
        </div>
    </div>

    <div id="corpusClient">
        <?php
                switch($page) {
                    case 'statistique':
                        ?>
                        <div id="dashborad">
                            <div style="display:flex; flex-direction:row;">
                                <div style="width:380px;">
                                    <h1>Bienvenue </h1>
                                    <h1 style="display:flex; color:green;">
                                        <?php echo $_SESSION['userCL']['prenom'] .' '. $_SESSION['userCL']['nom'];?>
                                    </h1>
                                </div>
                                <div id="chiffreAffaire">
                                    <?php echo $countArgentCommandeConfirme['sommeArgent'] . ' XAF DEPENSES'; ?>
                                </div>
                            </div>
                            <div class="zone-statistique">
                                <div class="statTotalCommande">
                                    <h2 class="countStat">
                                        <?php echo $resultCountReservationConfirme['totalConfirm']; ?>
                                    </h2>
                                    <p>Total Commande Confirmée </p>
                                </div>
                                <div class="statTotalCommande">
                                    <h2 class="countStat">
                                        <?php echo $resultCountReservationAttente['totalWait']; ?>
                                    </h2>
                                    <p>Total Commande en Attente </p>
                                </div>
                                <div class="statTotalCommande">
                                    <h2 class="countStat">
                                        <?php echo $resultCountReservationAnnule['totalClose']; ?>
                                    </h2>
                                    <p>Total Commande Annulée </p>
                                </div>
                                <div class="statTotalCommentaire">
                                    <h2 class="countStat">
                                        <?php echo $resultCountCommentaire['total']; ?>
                                    </h2>
                                    <p>Total Commentaire</p>
                                </div>
                            </div>

                            <div class="viewCommentaire">
                                <h2>Commentaire Ajouter</h2>
                                <?php
                                                    include 'ADMINISTRATEUR/Connexion.php';
                                                    /*liste des produits*/
                                                    $id =$_SESSION['userCL']['email'];
                                                    $sqlProduitView="SELECT * FROM commentaire WHERE email='$id'";
                                                    $resultset= $conn ->query($sqlProduitView);
                                                    if(mysqli_num_rows($resultset) >0){
                                                        /* afficher les blocus */
                                                                
                                                ?>
                                <?php
                                                    while($row = mysqli_fetch_assoc($resultset)){
                                                ?>
                                <div class="receptacleCommentaire">
                                    <p>
                                        <?=htmlspecialchars($row['email'])?>
                                    </p>
                                    <p>
                                        <?=htmlspecialchars($row['nom_produit'])?>
                                    </p>
                                    <p>
                                        <?=htmlspecialchars($row['commentaire'])?>
                                    </p>
                                </div>
                                <?php
                                                }
                                                }
                                                else{
                                                    echo "<p class='alert_commentaire'> 0 Commentaire enregistrer !</p>";
                                                }
                                                ?>
                            </div>
                        </div>
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
                                        <th>Date Presence</th>
                                        <th>Heure Presence</th>
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
                                        <td>
                                            <?php echo htmlspecialchars($order['id']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($order['nom_client']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($order['email']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($order['telephone_client']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($order['mode_paiement']); ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($order['prix_total'], 2, ',', ' ') . ' FCFA'; ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($order['numero_table']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($order['date_presence']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($order['heure_presence']); ?>
                                        </td>
                                        <td>
                                            <?php $panier = $order['details_panier']; $go = json_decode($panier, true);
                                                                                echo"  <table style='background-color:gray; display: flex; justify-content:space-between;'> ";  
                                                                                echo "<tr><th>NOM</th><th>PRIX</th><th >QTE</th><th>TOTAL</th><tr>";
                                                                            foreach($go as $detail): $total_unitaire = $detail['prix'] * $detail['qte'] ; ?>
                                    <tr>
                                        <td>
                                            <?php echo $detail["nom"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $detail["prix"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $detail["qte"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $total_unitaire; ?>
                                        </td>
                                    <tr>
                                        <?php endforeach; echo "</table>"?>
                                        </td>
                                        <td><span class="status-badge status-<?php echo $order['statut']; ?>">
                                                <?php echo ucfirst($order['statut']); ?>
                                            </span></td>
                                        <td class="actions">
                                            <?php if ($order['statut'] == 'confirmee'): ?>
                                            <span class="text-success">Confirmée</span>
                                            <?php elseif ($order['statut'] == 'en_attente'): ?>
                                            <a href="commande.php?action=cancel&id=<?php echo $order['id']; ?>" class="btn-cancel"
                                                onclick="return confirm('Annulez vous vraiment cette commande ?');">Annuler</a>
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
                            <p class="message-info">
                                <?php echo $message; ?><span onclick="this.parentElement.style.display='none';"
                                    class="closebtn">&times;</span>
                            </p>
                            <?php endif; ?>

                            <!-- <?php if ($admin): ?> -->
                            <form method="POST" action="commande.php?page=Setting">
                                <div>
                                    <label for="nom">Nom :</label>
                                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($admin['nom']); ?>"
                                        required>
                                </div>
                                <div>
                                    <label for="prenom">Prenom :</label>
                                    <input type="text" id="prenom" name="prenom"
                                        value="<?php echo htmlspecialchars($admin['prenom']); ?>" required>
                                </div>
                                <div>
                                    <label for="numero">Numero :</label>
                                    <input type="text" id="numero" name="numero" value="<?php echo htmlspecialchars($admin['numero']); ?>"
                                        required>
                                </div>
                                <div>
                                    <label for="email">Email :</label>
                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>"
                                        required>
                                </div>
                                <div>
                                    <label for="password">Nouveau Mot de passe (laisser vide pour ne pas changer):</label>
                                    <input type="password" id="password" name="password">
                                </div>
                                <div>
                                    <button type="submit" class="btn-primary" name="mdfCL"
                                        onclick="return confirm('Etes vous sur de vouloir apporter des modifications ?')">Enregistrer
                                        les modifications</button>
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

<style>
    :root {
        --primary-color: #4CAF50;
        /* Vert pour l'accentuation */
        --secondary-color: #333;
        --background-color: #f4f7f6;
        --sidebar-color: #ffffff;
        --text-color: #333;
        --border-color: #ddd;
        --shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Reinitialisation de base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: var(--background-color);
        color: var(--text-color);
        line-height: 1.6;
    }

    #html {
        display: flex;
        min-height: calc(100vh - 50px);
    }

    .vbox a {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin-right: -8%;
        margin-bottom: 8px;
        text-decoration: none;
    }

    .vbox {
        width: 280px;
        background-color: var(--sidebar-color);
        padding: 20px;
        box-shadow: var(--shadow);
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
    }

    .profilAdministrateur {
        padding: 3%;
        text-align: center;
        width: 160px;
        height: 170px;
        object-fit: cover;
        margin: 2% 0% -10% 10%;
    }

    .profilAdministrateur img {
        border-radius: 2rem;
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .alert_admin {
        margin: auto;
        margin-top: 7%;
        margin-left: 7%;
        justify-content: center;
        color: #e74c3c;
        font-size: 18px;

    }

    #corpusClient {

        background-color: #000;
        color: #fff;
        flex-grow: 1;
        padding: 20px;
        overflow: auto;
    }

    .zone-statistique {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        margin: auto;
        margin-left: 5%;
    }

    #chiffreAffaire {
        border: 1px solid white;
        background-color: transparent;
        border-radius: 1rem;
        float: right;
        margin-left: 30%;
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        padding: 2%;
        color: #fff;
        width: 300px;
        height: 80px;
    }

    .zone-statistique p {
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        margin-top: 15%;
        color: white;
    }

    .zone-statistique h2 {
        font-size: 22px;
        font-weight: bold;
        margin-left: 40%;
        margin-top: 10%;
        color: whit;
    }

    .statTotalProduit,
    .statTotalEmploye,
    .statTotalUtilisateur,
    .statTotalCommande,
    .statTotalSubscription,
    .statTotalCommentaire {
        border: 1px solid #fff;
        background-color: transparent;
        box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 5% 3% 0% 0%;
        color: #000;
        width: 200px;
        height: 160px;
        border-radius: 1rem;
    }
    .countStat {
    background: #e74c3c;
    color: white;
    font-size: 12px;
    padding: 3px 8px;
    width: 40px;
    height: 40px;
    text-align: center;
    border-radius: 50%;
    top: -8px;
    right: -8px;
    border: 2px solid white;
    }
    .statTotalProduit,
    .statTotalEmploye,
    .statTotalUtilisateur,
    .statTotalCommande,
    .statTotalSubscription,
    .statTotalCommentaire {
        display: inline-block;
        color: white;
        animation: statJoys 10s ease-in-out infinite;
    }
    .viewCommentaire {
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background-color: transparent;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .viewCommentaire h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
    }

    .receptacleCommentaire {
    background-color: #fff;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #eee;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
    }

    .receptacleCommentaire p {
    margin-bottom: 10px;
    }

    .receptacleCommentaire p:first-child {
    font-weight: bold;
    color: #007bff;
    }

    .receptacleCommentaire p:nth-child(2) {
    font-style: italic;
    color: #666;
    }

    .receptacleCommentaire p:last-child {
    font-size: 16px;
    line-height: 1.5;
    color: #333;
    }

    .alert_commentaire {
    text-align: center;
    color: #666;
    font-style: italic;
    }

    table {
        width: 98%;
        border-collapse: collapse;
        margin: auto;
        margin-top: 15px;
    }

    table th,
    table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    table td {
        color : #fff;
    }

    table th {
        background-color: #e9ecef;
        font-weight: bold;
        color: var(--secondary-color);
    }

    .message-info {
        color: black;
        background: rgb(77, 184, 77);
        border: 1px solid #b8daff;
        padding: 1px;
        border-radius: 4px;
        margin-top: -1%;
        width: 100%;
    }

    .closebtn {
        display: block;
        font-weight: bold;
        color: green;
        float: right;
        margin-right: 1.7%;
        font-size: 25px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }

    /* setting place */
    #settings-container h2 {
        margin: 2% 0% 2% 5%;
    }

    #settings-container form {
        background-color: rgba(128, 128, 128, 0.185);
        border-radius: 2rem;
        width: 90%;
        padding: 2% 2% 2% 2%;
        margin: auto;
        margin-top: 1%;
        line-height: 3;
    }

    #settings-container form div {
        display: flex;
        flex-direction: column;
        width: 55%;
    }

    #settings-container form button {
        margin-top: 5%;
        margin-left: 15%;
        font-size: 18px;
        padding: 2%;
        width: 70%;
        border: none;
        border-radius: 2rem;
        background-color: green;
    }

    #settings-container form button:hover {
        color: #fff;
        transform: scale(1.1);
        padding: 2%;
    }

    input,
    select {
        border: none;
        padding: 2%;
        color: #fff;
        background-color: rgba(85, 81, 81, 0.185);
        border-radius: 2rem;
    }

    .message-info {
        color: #004085;
        background-color: #cce5ff;
        border: 1px solid #b8daff;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
        width: 80%;
        margin-left: 5%;
    }

    .btn-cancel {
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-right: 5px;
        font-size: 0.9em;
        background-color: #dc3545;
        color: white;
    }

    .status-confirmee {
        color: green;
        padding: 10px;
        border-radius: 4px;
    }

    .status-en_attente {
        color: yellow;
        padding: 10px;
        border-radius: 4px;
    }

    .status-annulee {
        color: red;
        padding: 10px;
        border-radius: 4px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
const commentaires = document.querySelectorAll('.receptacleCommentaire');
commentaires.forEach((com, index) => {
com.style.opacity = 0;
com.style.transform = 'translateY(20px)';
setTimeout(() => {
com.style.transition = 'all 0.5s ease';
com.style.opacity = 1;
com.style.transform = 'translateY(0)';
}, index * 200);
});
});
</script>