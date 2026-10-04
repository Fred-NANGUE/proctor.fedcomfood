<?php
 require 'ADMINISTRATEUR\fpdf\fpdf.php';    

 function genererFacturePDF($numeroCommande, $nomClient, $dateactuelreservation, $produits, $tableReservee, $montantTotal) {
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
        $pdf->Cell(0, 10, "Date et Heure Reservation: $dateactuelreservation", 0, 1);
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

        // $pdf->Output('F', $fichier);

        return $fichier;

 }
?>

<?php
 include 'ADMINISTRATEUR/Connexion.php';

 // Gestion de l'inscription client
 if($_SERVER["REQUEST_METHOD"] =="POST" && isset($_POST["soumision_clientData"])){
    $nomcl = $conn->real_escape_string($_POST["username"]);
    $prenomcl = $conn->real_escape_string($_POST["secondname"]);
    $mailcl  = $conn->real_escape_string($_POST["email"]);
    $numbercl = $_POST["telnumber"];
    $passwordcl = $_POST["password"];
    $Hpasswordcl =  password_hash($passwordcl, PASSWORD_DEFAULT);
    
    if(empty($_FILES['imagecl']['tmp_name'])){
        header("Location:page_accueil.php?message=erImage");
        exit();
    }

    $file_basename = pathinfo($_FILES["imagecl"]["name"], PATHINFO_FILENAME);
    $file_extension = pathinfo($_FILES["imagecl"]["name"], PATHINFO_EXTENSION);
    $new_images_cl = $file_basename .  '.' . $file_extension;
    $new_images_cl = $conn ->real_escape_string($new_images_cl);

     /* Charger dans le dossier */
        $dossier = "image_utilisateur/";
        $fichier = $dossier .$new_images_cl;
        move_uploaded_file($_FILES['imagecl']['tmp_name'],$fichier );
    
    $newAdmin = "INSERT INTO client(nom,prenom,numero,email,password,libelleImageCL)
                 VALUES ('$nomcl','$prenomcl','$numbercl','$mailcl','$Hpasswordcl','$new_images_cl')";

    if( $conn ->query($newAdmin) === TRUE){
        $message =" Vous etes inscrit avec succes !";
        header("Location:page_accueil.php?messageADDComteAD=" . urlencode($message));
        exit();
    }else{
         header("Location:page_accueil.php?messageADDComteAD=no");
        exit();
    }
  }

  // Gestion des commentaires
  if($_SERVER["REQUEST_METHOD"] =="POST" && isset($_POST["submit_comment"])){
    $id_produit = intval($_POST['id_produit']);
    $nom_produit = $conn->real_escape_string($_POST['nom_produit']);
    $nom_client = $conn->real_escape_string($_POST['nom_client']);
    $email_client = $conn->real_escape_string($_POST['email_client']);
    $commentaire = $conn->real_escape_string($_POST['commentaire']);
    
    $sqlComm = "INSERT INTO commentaire (idproduit, nom_produit, nom_client, email, commentaire) 
                VALUES ($id_produit, '$nom_produit', '$nom_client', '$email_client', '$commentaire')";
    $conn->query($sqlComm);
    $message ="Produit Commentée avec succes !";
    header("Location:page_accueil.php?comment=". urlencode($message));
    exit();
  }

  // Gestion de la souscription
  if($_SERVER["REQUEST_METHOD"] =="POST" && isset($_POST["submit_subscription"])){
    $email = $conn->real_escape_string($_POST['sub_email']);
    $messagecom = $conn->real_escape_string($_POST['sub_message']);
    $sqlSub = "INSERT INTO subscription (email,date_souscription, message) VALUES ('$email','$date_systeme', '$messagecom')";
    $conn->query($sqlSub);
    $message ="Souscription effectué avec succes. Vous serez informé en temps réel des mises à jour avec succes !";
    header("Location:page_accueil.php?sub=". urlencode($message));
    exit();
  }

  // Gestion de la réservation finale
  if($_SERVER["REQUEST_METHOD"] =="POST" && isset($_POST["confirm_reservation_final"])){
    $nom = $conn->real_escape_string($_POST['res_nom']);
    $email = $conn->real_escape_string($_POST['res_email']);
    $tel = $conn->real_escape_string($_POST['res_tel']);
    $mode_paiement = $conn->real_escape_string($_POST['mode_paiement']);
    $prix_total = $conn->real_escape_string($_POST['prix_total']);
    $numTable = $conn->real_escape_string($_POST['numtable']);
    $date_actuelReservation = $_POST['date_heure_reservationActuel'];
    $date_presence = $_POST['date_presence'];
    $heure_presence = $_POST['heure_presence'];
    $panier_json = $_POST['panier_data'];
    
    $sqlRes = "INSERT INTO reservation (nom_client, email, telephone_client, mode_paiement, prix_total, numero_table, date_presence, heure_presence,heure_actuel_reservation, details_panier) 
               VALUES ('$nom', '$email', '$tel', '$mode_paiement','$prix_total','$numTable','$date_presence','$heure_presence','$date_actuelReservation', '$panier_json')";
     
         //Notification du administrateur
            $sqlMail =" SELECT MAX(id) as dernier_id FROM reservation  ";
            $resultMail = $conn->query($sqlMail);
                 if(mysqli_num_rows($resultMail) >0){
                    while($rowMail = mysqli_fetch_assoc($resultMail)){
                         $dernierId = $rowMail['dernier_id'] + 1;
                       $subject = "FEDCOM FOOD Nouvelle Commande En attente";
                       $corps = '
                                    <html>
                                    <body style="font-family: Arial, sans-serif; font-size:14px; color:#333;">

                                    <p>
                                    Bonjour FEDCOM FOOD vous informe que une nouvelle commande a été initié par <strong>'.$email.'</strong>,
                                    </p>

                                    <p>
                                    FEDCOM FOOD vous informe que une nouvelle commande a été initié à
                                    <strong>'.$date_actuelReservation.'</strong>.
                                    </p>

                                    <p>
                                    Merci de bien vouloir vous prononcer sur la reservation.
                                    </p>

                                    <p>
                                    Cordialement,<br>
                                    <strong>FEDCOM FOOD</strong>
                                    </p>

                                    </body>
                                    </html>
                        ';
                        
                        // Génération du PDF
                         $pdfFile = genererFacturePDF($dernierId, $nom, $date_actuelReservation, $panier_json, $numTable, $prix_total);
                       
                        // Boundary
                        $boundary = md5(time());

                        // HEADERS
                        $headers  = "From: FEDCOM FOOD <fredmiguelnanguefeulefack@gmail.com>\r\n";
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

                        if (mail("fredmiguelnanguefeulefack@gmail.com", $subject, $body, $headers)) {
    if($conn->query($sqlRes)){
         $RecupererQuantite = json_decode($panier_json, true) ;
          foreach ($RecupererQuantite as $produitQUANTITE) {
            $total_unitaire = $produit['prix'] * $produit['qte'] ;
            $pdf->Cell(90, 10, $produit['nom'], 1, 0, 'L');
            $pdf->Cell(30, 10, $produit['prix'], 1, 0, 'R');
            $pdf->Cell(35, 10, $produit['qte'], 1, 0, 'C');
            $pdf->Cell(40, 10, $total_unitaire, 1, 1, 'R');
            }
        $message= "Commande en attente de validation de FEDCOM FOOD ";
        header("Location:page_accueil.php?commande_attente=" . urlencode($message));
        //Vider le panier
       // viderPanier();
        exit();
    }
    }else{
    $message= "Veillez activé vos données mobile ! ";
    header("Location:page_accueil.php?commande_erreur=" . urlencode($message));
    }

  }}}
?>

<!-- Connexion -->
 <?php
    session_start();
    include 'ADMINISTRATEUR/Connexion.php';
    //fuseau Cameroun
    date_default_timezone_set('Africa/Douala');
     $userCL = null;// variable globale
     $message = "";
     global $userCL;
    if($_SERVER["REQUEST_METHOD"] ==="POST" && isset($_POST["soumission_clientCon"])){
        $email= $conn->real_escape_string($_POST['email']);
        $password=$_POST["password"];

        $stmt = "SELECT * FROM client WHERE email='$email' ";
        $esul = $conn ->query($stmt) ;
             if(mysqli_num_rows($esul) > 0){
               $userCL = mysqli_fetch_assoc($esul);

        //Verification du mot de passe
         if(password_verify($password, $userCL['password'])){
    
            $_SESSION['userCL'] = [
                'id' => $userCL['id'],
                'nom' => $userCL['nom'],
                'prenom' => $userCL['prenom'],
                'numero' => $userCL['numero'],
                'email' => $userCL['email'],
                'libelleImageCL' => $userCL['libelleImageCL']
            ];
            $message="Connecté avec succes.";
             header('Location:page_accueil.php?connexion='. urlencode($message));
             exit;
         }else{$message="Mot de passe incorrect.";}
    }else{$message="Email incorrect.";}

    }

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation de place dans un restaurant</title>
    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="accueil.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="reservation.css">
     <style>
        :root {
            --primary-color: #27ae60;
            --secondary-color: #000000;
            --accent-color: #e67e22;
            --text-dark: #333;
            --white: #ffffff;
        }
        /* Barre de recherche */
        .search-container { padding: 20px 5%; text-align: center; background: #f9f9f9;  }

        .search-container select { padding: 12px 20px; border-radius: 30px;text-align: center; background: #f9f9f9; outline: none; margin-right: 5%;}
        #searchInput { width: 60%; padding: 12px 20px; border-radius: 30px; border: 1px solid #ddd; font-size: 1rem; outline: none; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }

        /* Menu Section Chic - Cartes plus larges */
         .scrollage {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 40px;
            padding: 40px 5%;
        }
        .receptacle_produitAdministrateur:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        .produit-footer { display: flex; gap: 12px; }
        .btn-action { flex: 1; padding: 12px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; text-align: center; text-decoration: none; font-size: 0.85rem; transition: 0.2s; }
        .btn-add { background: var(--primary-color); color: white; }
        .btn-view { background: #f0f0f0; color: var(--secondary-color); }
        .btn-comment { background: var(--accent-color); color: white; }
        .btn-action:hover { opacity: 0.9; } 
    </style> 
</head>

<body>
    <header>
        <marquee behavior="" direction="left">
        <div class="header1">
            <div class="mail">
                <p>📧 fredmiguelnanguefeulefack@gmail.com</p>
            </div>
            <div>
                <p>Bienvenue chez <spand style="color: green; font-weight:bold;">FEDCOM FOOD</spand></p>
            </div>
            <div class="number">
                 <p><spand>📞</spand> +237 672 92 17 99 | Ouvert du Lundi au Samedi : 07h30 - 21h00</p>
            </div>
            </marquee>
            <div class="boutAdministrateur"><a href="ADMINISTRATEUR/accueil.php">👨🏾‍🍳</a></div>
        </div>
        <hr id="Line">
        <div class="header2">
            <div id="logo_accueil"><img src="image_accueil/file_0000000025e87243b46671be8e1a764d.png" alt="Logo"></div>
            <nav>
                <ul>
                    <li><a href="#accueil_main">ACCUEIL</a></li>
                    <li><a href="#menu_main">MENU</a></li>
                    <li><a href="#personnel">PERSONNEL</a></li>
                    <li><a href="#blog">BLOG</a></li>
                    <li><a href="#contact_main">INSCRIPTION</a></li>
                </ul>
            </nav>
            <div class="hoursHead">
                <h4>Heures D'ouverture</h4>
                <p>Lun - Sam: 7h30 - 21h00</p>
            </div>
            <button class="btn_panier_header" onclick="togglePanier()">
                <i class="fas fa-shopping-cart"></i> PANIER
                <span id="nombreArticlesBadge" class="hidden">0</span>
            </button>
        </div>   
    </header>
        <!-- menu responsive -->
         <div style="display: flex; justify-content: space-between;">
            <div id="logo_hamburger"><img src="image_accueil/file_0000000025e87243b46671be8e1a764d.png" alt="Logo"></div>
            <button class="btn_panier_hamburger" onclick="togglePanier()">
                <i class="fas fa-shopping-cart"></i> PANIER
                <span id="nombreArticlesBadge_hamburger" class="hidden">0</span>
            </button>
            <div class="menu-toogle"></div>
         </div>
        <ul class="menu-hamburger">
            <marquee behavior="" direction="left" style="color: #fff;">
                    <div class="mail">
                        <p>📧 fredmiguelnanguefeulefack@gmail.com</p>
                    </div>
                    <div>
                        <p>Bienvenue chez <spand style="color: green; font-weight:bold;">FEDCOM FOOD</spand></p>
                    </div>
                    <div class="number">
                         <p><spand>📞</spand> +237 672 92 17 99 | Ouvert du Lundi au Samedi : 07h30 - 21h00</p>
                    </div>
            </marquee>
            <li><a href="#accueil_main">ACCUEIL</a></li>
            <li><a href="#menu_main">MENU</a></li>
            <li><a href="#personnel">PERSONNEL</a></li>
            <li><a href="#blog">BLOG</a></li>
            <li><a href="#contact_main">INSCRIPTION</a></li>
            <div class="boutAdministrateur"><a href="ADMINISTRATEUR/accueil.php">👨🏾‍🍳</a></div>
        </ul>
    <!-- Panier Slider -->
    <div id="slidePanier">
           <?php if (isset($_GET['messageADDComteAD'])): ?>
           <p class="message-info"><?php echo htmlspecialchars($_GET['messageADDComteAD']); ?><span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span></p>
           <?php endif; ?>
           <?php if (isset($_GET['comment'])): ?>
           <p class="message-info"><?php echo htmlspecialchars($_GET['comment']); ?><span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span></p>
           <?php endif; ?>
           <?php if (isset($_GET['sub'])): ?>
           <p class="message-info"><?php echo htmlspecialchars($_GET['sub']); ?><span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span></p>
           <?php endif; ?>
           <?php if (isset($_GET['connexion'])): ?>
           <p class="message-info"><?php echo htmlspecialchars($_GET['connexion']); ?><span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span></p>
           <?php endif; ?>
           <?php if (isset($_GET['commande_attente'])): ?>
           <p class="message-info"><?php echo htmlspecialchars($_GET['commande_attente']); ?><span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span></p>
           <?php elseif (isset($_GET['commande_erreur'])): ?>
           <p class="message-info"><?php echo htmlspecialchars($_GET['commande_erreur']); ?><span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span></p>
           <?php endif; ?>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin:0;">Mon Panier</h3>
            <i class="fas fa-times" onclick="togglePanier()" style="cursor:pointer; font-size:1.5rem; color:#999;"></i>
        </div>
        <div id="listeArticles"></div>
        <div style="margin-top:30px;">
            <button onclick="viderPanier()" style="background:#f0f0f0; border:none; padding:12px; width:100%; cursor:pointer; margin-bottom:12px; border-radius:8px; font-weight:600;">Vider le panier</button>
            <?php if (isset($_SESSION['userCL'])):
              echo ' <button onclick="ouvrirValidationFinale()" style="background:var(--primary-color); color:white; margin-bottom:15%; border:none; padding:18px; width:100%; cursor:pointer; font-weight:bold; border-radius:8px; font-size:1rem;">VALIDER LA RÉSERVATION</button>';
              echo ' <a href="commande.php" style="background:var(--primary-color); text-decoration:none; color:white; border:none; padding:18px; width:100%; cursor:pointer; margin-left:13%; font-weight:bold; border-radius:8px; font-size:1rem;">HISTORIQUE RESERVATION</a>';
                ?>
            <?php else:
                echo 'Pour Reserver <a href="#" onclick="Inscription()" style="margin:2% 0% 0% 5%; text-decoration: none; color: var(--primary-color)">Se connecter</a>';
                ?>
            <?php endif; ?>
        </div>
    </div>

    <main id="accueil_main" class="accueil_main">
        <div class="def" style="padding: 80px 5%; background: linear-gradient(135deg, #fff 0%, #f9f9f9 100%); display: flex; align-items: center; min-height: 500px;">
            
            <div class="right_accueil" style="flex: 0.8; text-align: center;">
                <img src="image_accueil/image_defillement/1.png" alt="Burger" style="max-width: 100%; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.2));">
            </div>
            <div class="left_accueil" style="flex: 1.2;">
                <h1 style="font-size: 4rem; color: var(--secondary-color); line-height: 1.1; margin: 0;">Cameroun <br><span style="color:var(--primary-color)">Burger Kings</span></h1>
                <p style="font-size: 1.3rem; margin: 30px 0; color: #555;">Découvrez l'authenticité des saveurs Camerounaise préparées avec passion et des ingrédients frais de qualité supérieure.</p>
                <a href="#menu_main" style="background: var(--primary-color); color: white; padding: 18px 40px; text-decoration: none; border-radius: 40px; font-weight: bold; font-size: 1.1rem; box-shadow: 0 10px 20px rgba(39, 174, 96, 0.3);">CONSULTER LE MENU</a>
            </div>
        </div>
    </main>

    <main id="menu_main">
        <div style="text-align: center; padding: 60px 0 20px;">
            <h2 style="color: var(--primary-color); text-transform: uppercase; letter-spacing: 3px; font-size: 1rem;">Gastronomie</h2>
            <h3 style="font-size: 2.5rem; margin-top: 10px;">Notre Menu Spécial</h3>
            <div class="search-container">
                <label for="filtrer_categorieProduit">Trier Par Categorie :</label>
                <select name="filtrer_categorieProduit" id="filtrer_categorieProduit" onclick="filterProductsCategorie()">
                    <option value="">--Selectionner--</option>
                    <option value="Premier_repas">Petit Dejeuner</option>
                    <option value="Dejeuner">Dejeuner</option>
                    <option value="Diner">Dîner</option>
                </select>
                <input type="text" id="searchInput" placeholder="Rechercher un plat (nom ou description)..." onkeyup="filterProducts()">
            </div>
        </div>
        <div class="scrollage" id="productGrid">
            <?php
                  include 'ADMINISTRATEUR/Connexion.php';
                  global $valueClient;
                  $valueClient = '';
                  $sqlProduitView="SELECT * FROM produit";
                  $resultset= $conn ->query($sqlProduitView);
                  // information client pour commentaire
                    if(isset($_SESSION['userCL'])){
                    $id =$_SESSION['userCL']['id'];
                    $sqlProduitViewClient="SELECT * FROM client WHERE id='$id'";
                    $resultsetClientInfo= $conn ->query($sqlProduitViewClient);
                    if(mysqli_num_rows($resultsetClientInfo) > 0){
                        $valueClient = mysqli_fetch_assoc($resultsetClientInfo);
                    }
                    }
                    //fin
                  $resultset= $conn ->query($sqlProduitView);
                  if(mysqli_num_rows($resultset) > 0){
                    while($row = mysqli_fetch_assoc($resultset)){
               ?>
                   <div class="receptacle_produitAdministrateur product-card" data-name="<?= strtolower(htmlspecialchars($row['nom'])) ?>" data-desc="<?= strtolower(htmlspecialchars($row['description'])) ?>" data-cat="<?= strtolower(htmlspecialchars($row['categorie'])) ?>">
                        <img src="ADMINISTRATEUR/imageProduit/<?= $row['libelleImage']?>" alt="<?= htmlspecialchars($row['nom']) ?>" class="produit-image">
                        <div class="produit-info">
                            <div class="produit-line">
                                <div class="produit-nom"><?=htmlspecialchars($row['nom'])?></div>
                                <div class="produit-prix"><?=htmlspecialchars($row['prix'])?> FCFA</div>
                            </div>
                            <div class="produit-description"><?=htmlspecialchars($row['description'])?></div>
                            <div class="produit-footer">
                                <button class="btn-action btn-add" onclick="checkStockAndAdd(<?= $row['id'] ?>, '<?= addslashes($row['nom']) ?>', <?= $row['prix'] ?>, <?= $row['quantite'] ?>)">AJOUTER</button>
                                <button class="btn-action btn-view" onclick="ouvrirDetails(<?= $row['id'] ?>, '<?= addslashes($row['nom']) ?>', '<?= addslashes($row['description']) ?>','<?= addslashes($row['categorie']) ?>', <?= $row['prix'] ?>, <?= $row['quantite'] ?>, '<?= $row['libelleImage'] ?>')">VOIR</button>
                                <?php if (isset($_SESSION['userCL'])):
                ?><button class='btn-action btn-comment' onclick="ouvrirPopupCommentaire('<?= $row['id'] ?>','<?= addslashes($row['nom']) ?>')">AVIS</button>
            <?php else:
                echo '<a href="#" onclick="Inscription()" style="margin:2% 0% 0% 5%; text-decoration: none; color: var(--primary-color)">Se connecter</a>';
                ?>
            <?php endif; ?>
                                
                            </div>
                        </div>
                    </div>
            <?php
                    }
                  }
            ?>
        </div>
    </main>

    <main id="personnel">
        <h2 style="color: var(--primary-color);">NOTRE ÉQUIPE</h2>
        <h3>Les Artisans de votre Goût</h3>
        <div class="personnel-grid">
             <?php
                  include 'ADMINISTRATEUR/Connexion.php';
                  /*liste des produits*/
                  $sqlSessionProducteur="SELECT * FROM employe";
                  $resultsetProducteur= $conn ->query($sqlSessionProducteur);
                  if(mysqli_num_rows($resultsetProducteur) >0){
                    /* afficher les blocus */
                              
               ?>
           <div class="content">
             <?php
                  while($rowProducteur = mysqli_fetch_assoc($resultsetProducteur)){
               ?>
                <!-- box1' -->
                 <div class="box">
                     <img src="ADMINISTRATEUR/image_personnel/<?=htmlspecialchars($rowProducteur['libelleImagePersonnel'])?>" alt="">
                     <div class="content">
                        <div>
                            <h4><?= htmlspecialchars($rowProducteur['specialite'])?></h4>
                            <p><?= htmlspecialchars($rowProducteur['nom']) ?></p><br><br>
                            <a href="tel:<?=htmlspecialchars($rowProducteur['numero'])?>">Contacter </a>
                        </div>
                     </div>
                 </div>
                 
                  <?php
                  }
                }
                else{
                    echo "<p class='alert_produit'> 0 EMPLOYER ENREGISTRER !</p>";
                }
                ?>
            </div>
        </div>
    </main>

    <main id="blog">
        <h2 style="text-align:center; color: var(--primary-color);">NOTRE BLOG</h2>
        <h3 style="text-align:center;">Actualités & Recettes</h3>
        <div class="blog-grid">
            <div class="blog-card">
                <img src="image_accueil/image_defillement/2.png" alt="Blog 1">
                <div class="blog-content">
                    <h4>Le secret de nos épices</h4>
                    <p>Découvrez comment nous sélectionnons nos piments directement au Mexique...</p>
                    <a href="#" style="color:var(--primary-color); font-weight:bold;">Lire la suite</a>
                </div>
            </div>
            <div class="blog-card">
                <img src="image_accueil/image_defillement/3.png" alt="Blog 2">
                <div class="blog-content">
                    <h4>Nouveau Burger du Mois</h4>
                    <p>Ce mois-ci, place au "Azteca Gold" avec sa sauce avocat fumée...</p>
                    <a href="#" style="color:var(--primary-color); font-weight:bold;">Lire la suite</a>
                </div>
            </div>
        </div>
        <h2 class="titreCommentaire">Commentaire Recent</h2>
        <div class="viewCommentaire">
            
                                        <?php
                                    include 'ADMINISTRATEUR/Connexion.php';
                                    /*liste des produits*/
                                    $sqlProduitView="SELECT * FROM commentaire ORDER BY id DESC LIMIT 5";
                                    $resultset= $conn ->query($sqlProduitView);
                                    if(mysqli_num_rows($resultset) >0){
                                        /* afficher les blocus */
                                                
                                ?>
                                        <?php
                                    while($row = mysqli_fetch_assoc($resultset)){
                                ?>
                                <div class="receptacleCommentaire">
                                     <p><?=htmlspecialchars($row['email'])?> </p>
                                     <p><?=htmlspecialchars($row['nom_produit'])?></p>
                                     <p><?=htmlspecialchars($row['commentaire'])?></p> 
                                </div>
                                   <?php
                                }
                                }
                                else{
                                    echo "<p class='alert_produit'> 0 Commentaire enregistrer !</p>";
                                }
                                ?>
        </div>
    </main>

    <main id="contact_main">
        <div class="form-inscription">
            <h2 style="text-align:center; color:var(--primary-color);">REJOIGNEZ-NOUS</h2>
            <p style="text-align:center; margin-bottom:30px;">Créez votre compte pour des offres exclusives</p>
            <form action="page_accueil.php" method="POST" enctype="multipart/form-data">
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                    <input type="text" name="username" placeholder="Nom" required>
                    <input type="text" name="secondname" placeholder="Prénom" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="number" name="telnumber" placeholder="Téléphone" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <input type="file" name="imagecl" accept="image/*" required>
                </div>
                 <div style="display:flex; flex-direction:row;">
                    <p style="margin:2% % 2% 3%;">Si vous avez un compte</p><a href="#" onclick="Inscription()" style="margin:0% 0% 2% 2%; text-decoration: none; color: var(--primary-color);">Se connecter</a>
                </div>
                <button type="submit" name="soumision_clientData" style="background:var(--primary-color); color:white; border:none; padding:15px; width:100%; border-radius:10px; cursor:pointer; font-weight:bold; font-size:1.1rem;">S'INSCRIRE MAINTENANT</button>
            </form>
        </div>
    </main>

    <!-- Popup Détails Produit -->
    <div class="overlay-popup" id="popupDetails">
        <div class="content-popup">
            <spand class="close-popup" onclick="document.getElementById('popupDetails').style.display='none'">&times;</spand>
            <div id="detailsContent" style="text-align:center;">
                <!-- Injecté par JS -->
            </div>
        </div>
    </div>

    <!-- Popup Commentaire -->
    <div class="overlay-popup" id="popupCommentaire">
        <div class="content-popup">
            <spand class="close-popup" onclick="document.getElementById('popupCommentaire').style.display='none'">&times;</spand>
            <h2 style="color:var(--accent-color); text-align:center;">Votre Avis nous intéresse</h2>
            <form action="page_accueil.php" method="POST" style="margin-top:25px;">
                <input type="hidden" name="id_produit" id="comm_id_prod">
                <input type="hidden" name="nom_produit" id="comm_nom_prod">
                <input type="hidden" name="nom_client" value="<?= $_SESSION['userCL']['nom']?>" placeholder="Votre Nom" required>
                <input type="hidden" name="email_client" value="<?= $_SESSION['userCL']['email']?>" placeholder="Votre Email" required>
                <textarea name="commentaire" placeholder="Votre message..." required style="width:100%; padding:12px; border-radius:8px; border:1px solid #ddd; height:120px; margin-bottom:20px;"></textarea>
                <button type="submit" name="submit_comment" style="background:var(--accent-color); color:white; border:none; padding:15px; width:100%; border-radius:8px; cursor:pointer; font-weight:bold;">ENVOYER MON AVIS</button>
            </form>
        </div>
    </div>

    <!-- Popup Validation Finale -->
    <div class="overlay-popup" id="popupValidationFinale">
        <div class="content-popup" style="max-width:750px;">
            <spand class="close-popup" onclick="document.getElementById('popupValidationFinale').style.display='none'">&times;</spand>
            <h2 style="color:var(--primary-color); text-align:center;">Finaliser ma réservation</h2>
            <div id="recapTableFinal" style="margin:25px 0;"></div>
             <form action="page_accueil.php" method="POST">
                <input type="hidden" name="panier_data" id="final_panier_json">
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                    <input type="text" name="res_nom" value="<?= $_SESSION['userCL']['nom']?> <?= $_SESSION['userCL']['prenom']?>" placeholder="Nom Complet" readonly required>
                    <input type="email" name="res_email" value="<?= $_SESSION['userCL']['email']?>" placeholder="Email" readonly required>
                    <input type="tel" name="res_tel" value="<?= $_SESSION['userCL']['numero']?>" placeholder="Téléphone" readonly required>
                    <input type="hidden" name="prix_total" id="prix_total">
                    <select name="mode_paiement" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;">
                        <option disabled="disabled" value="Orange_Money">Orange Money</option>
                        <option value="Especes">Espèces sur place</option>
                    </select>
                    <div>
                        <label style="font-size:0.8rem; color:#666;">Numero Table :</label>
                        <select name="numtable" id="" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:8px;">
                             <option value="Table1">Table 1</option>
                             <option value="Table2">Table 2</option>
                             <option value="Table3">Table 3</option>
                             <option value="Table4">Table 4</option>
                             <option value="Table5">Table 5</option>
                             <option value="Table6">Table 6</option>
                             <option value="Table7">Table 7</option>
                             <option value="Table8">Table 8</option>
                             <option value="Table8">Table 9</option>
                             <option value="Table10">Table 10</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.8rem; color:#666;">Heure de Présence :</label>
                        <input type="time" name="heure_presence" required>
                    </div>
                    <div>
                        <label style="font-size:0.8rem; color:#666;">Periode Réservation Actuelle :</label>
                        <input type="datetime-local" name="date_heure_reservationActuel" style="background:#f0f0f0;">
                    </div>
                    <div>
                        <label style="font-size:0.8rem; color:#666;">Date Presence :</label>
                        <input type="date"  name="date_presence" style="background:#f0f0f0;">
                    </div>
                </div>
                <button type="submit" name="confirm_reservation_final"id="confirm_reservation_final" onclick="return confirm('Voulez-vous vraiment confirmer cette commande ?')" style="background:var(--primary-color); color:white; border:none; padding:18px; width:100%; border-radius:8px; cursor:pointer; font-weight:bold; margin-top:25px; font-size:1.1rem;">CONFIRMER LA RESERVATION ET PAIEMENT</button>
             </form>
        </div>
    </div>
    
    <!-- Popup connexion -->
    <div class="overlay-popup" id="client-connexion">
        <div class="content-popup" style="max-width:750px;">
            <spand class="close-popup" onclick="document.getElementById('client-connexion').style.display='none'">&times;</spand>
            <h2 style="color:var(--primary-color); text-align:center;">INSCRIPTION</h2>
            <form action="" method="POST">
                <?php if ($message): ?>
                <p class="message-info"><?php echo $message; ?><span onclick="this.parentElement.style.display='none';" class="closebtn">&times;</span></p>
                <?php endif; ?>
                <div>
                    <label for="email">E-mail :</label>
                    <input type="email" name="email" id="email" placeholder="email@gamail.com" required>
                </div>
                <div>
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" id="password" placeholder="Entrez votre ......" required >
                    <!-- <span id="togglePassword">👁️</span> -->
                </div>
                <div style="display:flex; flex-direction:row;">
                    <input type="submit" value="Se connecter" name="soumission_clientCon">
                    <p style="margin:2% 0% 0% 5%;">Si vous n'avez pas de compte</p><a href="page_accueil.php?#contact_main" style="margin:2% 0% 2% 2%; text-decoration: none; color: var(--primary-color)">S'inscrire</a>
                </div>
            </form>
        </div>
    </div>

    <footer style="background: #111; color: white; padding: 70px 5% 30px; margin-top: 50px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 50px;">
            <div>
                <h4 style="color: var(--primary-color); margin-bottom: 25px; font-size: 1.5rem;">FEDCOM FOOD</h4>
                <p style="color: #888; line-height: 1.8;">L'excellence culinaire Camerounaise à votre portée. Qualité, fraîcheur et service irréprochable.</p>
                <div style="margin-top: 25px; font-size: 1.5rem;">
                    <h4 style="color: var(--primary-color); margin-bottom: 25px; font-size: 1.5rem;">Nous Suivre :</h4>
                    <a href="https://www.facebook.com/profile.php?id=61584750822674" style="color:white; margin-right:20px;"><i style="color:white; margin-right:20px;" class="fab fa-facebook"></i></a>
                    <a href="https://instagram.com" style="color:white; margin-right:20px;"><i class="fab fa-instagram"></i></a>
                    <a href="https://twitter.com" style="color:white;"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div>
                <h4 style="color: var(--primary-color); margin-bottom: 25px; font-size: 1.2rem;">Liens Utiles</h4>
                <ul style="list-style:none; padding:0; color:#888; line-height:2.5;">
                    <li><a href="#accueil_main" style="color:#888; text-decoration:none;">Accueil</a></li>
                    <li><a href="#menu_main" style="color:#888; text-decoration:none;">Notre Menu</a></li>
                    <li><a href="#personnel" style="color:#888; text-decoration:none;">L'Équipe</a></li>
                    <li><a href="#contact_main" style="color:#888; text-decoration:none;">Inscription</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color: var(--primary-color); margin-bottom: 25px; font-size: 1.2rem;">Souscription</h4>
                <form action="page_accueil.php" method="POST">
                    <input type="email" name="sub_email" placeholder="Votre Email" required style="width:100%; padding:12px; background:#222; border:1px solid #333; color:white; border-radius:5px; margin-bottom:15px;">
                    <textarea name="sub_message" placeholder="Message" rows="2" style="width:100%; padding:12px; background:#222; border:1px solid #333; color:white; border-radius:5px; margin-bottom:15px;"></textarea>
                    <button type="submit" name="submit_subscription" style="background:var(--primary-color); color:white; border:none; padding:12px 25px; border-radius:5px; cursor:pointer; font-weight:bold;">S'ABONNER</button>
                </form>
            </div>
        </div>
        <div style="text-align: center; margin-top: 60px; padding-top: 30px; border-top: 1px solid #222; color: #555; font-size: 0.9rem;">
            &copy; <?= date('Y') ?> FEDCOM FOOD. Tous droits réservés. Design by Fred Nangue.
        </div>
    </footer>
    <script>
        // menu responsive
        var menu_toogle = document.querySelector('.menu-toogle');
        var menu = document.querySelector('.menu-hamburger');
        menu_toogle.onclick = function(){
            menu_toogle.classList.toggle('active');
            menu.classList.toggle('responsive');
        }
        let panier = JSON.parse(localStorage.getItem('panier')) || [];

        document.addEventListener('DOMContentLoaded', () => {
            renderPanier();
        });

        function togglePanier() {
            document.getElementById('slidePanier').classList.toggle('open');
        }

        function filterProducts() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const desc = card.getAttribute('data-desc');
                if(name.includes(query) || desc.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        function filterProductsCategorie() {
            const query = document.getElementById('filtrer_categorieProduit').value.toLowerCase();
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                const cat = card.getAttribute('data-cat');
                if(cat.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function checkStockAndAdd(id, nom, prix, stockMax) {
            // Vérifier combien il y en a déjà dans le panier
            let countInPanier = 0;
            panier.forEach(item => {
                if(item.nom === nom) countInPanier += item.qte;
            });

            if(countInPanier + 1 > stockMax) {
                alert(`Erreur : Stock insuffisant ! Il ne reste que ${stockMax} unité(s) de ce produit.`);
                return;
            }

            panier.push({ nom, prix, qte: 1 });
            localStorage.setItem('panier', JSON.stringify(panier));
            renderPanier();
            alert("Produit ajouté au panier !");
        }

        function ouvrirDetails(id, nom, desc,cat, prix, stock, img) {
            const content = document.getElementById('detailsContent');
            content.innerHTML = `
                <h1 style="color:var(--secondary-color);  margin-bottom:20px;">${cat}</h1>
                <img src="ADMINISTRATEUR/imageProduit/${img}" style="width:250px; border-radius:15px; margin-bottom:20px; ">
                <h2 style="color:var(--secondary-color);">${nom}</h2>
                <p style="color:#666; font-size:1.1rem; margin:15px 0;">${desc}</p>
                <p style="font-weight:bold; font-size:1.5rem; color:var(--primary-color);">${prix} FCFA</p>
                <p style="color:${stock > 0 ? 'green' : 'red'}; font-weight:bold;">Stock disponible : ${stock}</p>
                <div style="margin-top:25px; display:flex; gap:15px; justify-content:center;">
                    <input type="number" id="qteDetail" value="1" min="1" max="${stock}" style="width:60px; padding:10px; border-radius:8px; border:1px solid #ddd;">
                    <button onclick="ajouterDepuisDetails('${nom}', ${prix}, ${stock})" style="background:var(--primary-color); color:white; border:none; padding:12px 30px; border-radius:30px; cursor:pointer; font-weight:bold;">AJOUTER AU PANIER</button>
                </div>
            `;
            document.getElementById('popupDetails').style.display = 'flex';
        }
        function Inscription() {
            document.getElementById('client-connexion').style.display = 'flex';
        }

        function ajouterDepuisDetails(nom, prix, stockMax) {
            const qte = parseInt(document.getElementById('qteDetail').value);
            let countInPanier = 0;
            panier.forEach(item => {
                if(item.nom === nom) countInPanier += item.qte;
            });

            if(countInPanier + qte > stockMax) {
                alert(`Erreur : Stock insuffisant ! Vous ne pouvez pas ajouter plus de ${stockMax} unités au total.`);
                document.getElementById('qteDetail').value = stockMax - countInPanier;
                return;
            }

            panier.push({ nom, prix, qte });
            localStorage.setItem('panier', JSON.stringify(panier));
            renderPanier();
            document.getElementById('popupDetails').style.display = 'none';
            togglePanier();
        }

        function renderPanier() {
            const container = document.getElementById('listeArticles');
            const badge = document.getElementById('nombreArticlesBadge');
            const badge_hamburger = document.getElementById('nombreArticlesBadge_hamburger');
            
            if(panier.length === 0) {
                container.innerHTML = "<p style='text-align:center; margin-top:40px; color:#999;'>Votre panier est vide.</p>";
                badge.classList.add('hidden');
                badge_hamburger.classList.add('hidden');
                return;
            }

            badge.innerText = panier.length;
            badge.classList.remove('hidden');
            badge_hamburger.innerText = panier.length;
            badge_hamburger.classList.remove('hidden');

            let totalG = 0;
            let html = `<table class="panier-table">
                <thead><tr><th>Produit</th><th>Qté</th><th>Total</th><th></th></tr></thead>
                <tbody>`;
            
            panier.forEach((item, index) => {
                const total = item.prix * item.qte;
                totalG += total;
                html += `<tr>
                    <td style="font-weight:600;">${item.nom}</td>
                    <td>${item.qte}</td>
                    <td>${total} FCFA</td>
                    <td><button class="btn-remove" onclick="supprimerArticle(${index})"><i style="color: #e74c3c;" class="fas fa-trash-alt"></i></button></td>
                </tr>`;
            });

            html += `</tbody></table>
            <div style="margin-top:30px; text-align:right; font-weight:bold; font-size:1.4rem; color:var(--primary-color);">
                TOTAL : ${totalG} FCFA
            </div>`;
            
            container.innerHTML = html;
        }

        function supprimerArticle(index) {
            panier.splice(index, 1);
            localStorage.setItem('panier', JSON.stringify(panier));
            renderPanier();
        }

        function viderPanier() {
            if(confirm("Voulez-vous vider tout votre panier ?")) {
                panier = [];
                localStorage.setItem('panier', JSON.stringify(panier));
                renderPanier();
            }
        }
        
        document.getElementById('confirm_reservation_final').addEventListener('submit', function(){
            panier = [];
                localStorage.setItem('panier', JSON.stringify(panier));
                renderPanier();
        });
        function ouvrirPopupCommentaire(id, nom) {
            document.getElementById('comm_id_prod').value = id;
            document.getElementById('comm_nom_prod').value = nom;
            document.getElementById('popupCommentaire').style.display = 'flex';
        }

        function ouvrirValidationFinale() {
            if(panier.length === 0) {
                alert("Votre panier est vide !");
                return;
            }
            
            const recap = document.getElementById('recapTableFinal');
            let totalG = 0;
            let html = `<table class="panier-table" style="border:1px solid #eee;">
                <thead style="background:#f9f9f9;"><tr><th>Produit</th><th>Qté</th><th>Prix</th><th>Total</th></tr></thead><tbody>`;
            
            panier.forEach(item => {
                const total = item.prix * item.qte;
                totalG += total;
                html += `<tr><td>${item.nom}</td><td>${item.qte}</td><td>${item.prix}</td><td>${total} FCFA</td></tr>`;
            });
            html += `</tbody></table><h3 style="text-align:right; margin-top:20px; color:var(--primary-color);">Total à régler : ${totalG} FCFA</h3>`;
            
            recap.innerHTML = html;
            document.getElementById('prix_total').value  = totalG ;
            document.getElementById('final_panier_json').value = JSON.stringify(panier);
            document.getElementById('popupValidationFinale').style.display = 'flex';
        }
        
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', () => {
            const accueil_main = document.querySelectorAll('.accueil_main');
            accueil_main.forEach((com, index) => {
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
</body>
</html>
