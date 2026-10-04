<?php
session_start();
?>
  <!-- Insertion de produit -->
<?php
 include ("Connexion.php");

 /* requete d'insertion de produit */

 if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmerAddNewProduit'])){
   $nomPro = $conn->real_escape_string($_POST['nameProduit']);
   $descriptionPro = $_POST['descriptionProduit'];
   $prixPro = $_POST['prixProduit'];
   $categoriePro = $conn->real_escape_string($_POST['categorieProduit']);
   $quantitePro = $_POST['quantiteProduit'];

   /* gestion image */
             if(empty($_FILES['imageProduit']['tmp_name'])){
                header("Location:Administrateur.php?message=erImage");
            }

             $file_basename = pathinfo($_FILES["imageProduit"]["name"], PATHINFO_FILENAME);
             $file_extension = pathinfo($_FILES["imageProduit"]["name"], PATHINFO_EXTENSION);
             $new_images_name = $file_basename .  '.' . $file_extension;
             $new_images_name = $conn ->real_escape_string($new_images_name);
             
             /* Charger dans le dossier */
             if($_FILES["imageProduit"]["error"] == UPLOAD_ERR_INI_SIZE){
                $message ="L'image doit etre inferieur à 2 MO";
                header("Location:Administrateur_page.php?page=add_product&uploadImageProduit=" . urlencode($message));
            }else{
        $dossier = "imageProduit/";
        $fichier = $dossier .$new_images_name;
        move_uploaded_file($_FILES['imageProduit']['tmp_name'],$fichier );
    
         $insertsql="INSERT INTO produit(categorie,nom,description,prix,quantite,libelleImage)
                      VALUES('$categoriePro','$nomPro','$descriptionPro','$prixPro','$quantitePro','$new_images_name')";
          if($conn ->query($insertsql) === TRUE){
              header("Location:Administrateur_page.php?message=yes");
              exit();
         }else{
              header("Location:Administrateur_page.php?message=no");
              exit();
         }
         }}
     $conn ->close();

?>
  <!-- Insertion de personnel -->
<?php
 include ("Connexion.php");

 /* requete d'insertion du personnel */

 if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmerAddNewPersonnel'])){
   $nomPer = $conn->real_escape_string($_POST['namePersonnel']);
   $prenomPer = $conn->real_escape_string($_POST['secondnamePersonnel']);
   $specialitePer = $conn->real_escape_string($_POST['specialite']);
   $numeroPer = $conn->real_escape_string($_POST['numeroPersonnel']);
   $emailPer = $conn->real_escape_string($_POST['emailPersonnel']);

   /* gestion image */
             if(empty($_FILES['imagePersonnel']['tmp_name'])){
                header("Location:Administrateur_page.php?message=erImage");
            }

             $file_basename = pathinfo($_FILES["imagePersonnel"]["name"], PATHINFO_FILENAME);
             $file_extension = pathinfo($_FILES["imagePersonnel"]["name"], PATHINFO_EXTENSION);
             $new_images_name = $file_basename .  '.' . $file_extension;
             $new_images_name = $conn ->real_escape_string($new_images_name);
        /* Charger dans le dossier */
        if($_FILES["imagePersonnel"]["error"] == UPLOAD_ERR_INI_SIZE){
            $message ="L'image doit etre inferieur à 2 MO";
            header("Location:Administrateur_page.php?page=add_personnel&uploadImagePersonnel=" . urlencode($message));
        }else{
        $dossier = "image_personnel/";
        $fichier = $dossier .basename($_FILES["imagePersonnel"]["name"]);
        move_uploaded_file($_FILES['imagePersonnel']['tmp_name'],$fichier );
    
         $insertsql="INSERT INTO employe(nom,prenom,specialite,numero,email,password,libelleImagePersonnel)
                      VALUES('$nomPer','$prenomPer','$specialitePer','$numeroPer','$emailPer',null,'$new_images_name')";
          if($conn ->query($insertsql) === TRUE){
              header("Location:Administrateur_page.php?page=statistique");
              exit();
         }else{
              header("Location:Administrateur_page.php?message=no");
              exit();
         }
         }}
     $conn ->close();

?>
   <!-- Supression de produit  -->
<?php
 include ("Connexion.php");

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["idProduit"])){
        $kk = $_GET["idProduit"];
    $delproduitsql ="DELETE FROM `produit` WHERE id='$kk'" ;
       if($conn ->query($delproduitsql) === TRUE){
         header("Location:Administrateur_page.php?messageDEL=yes");
         exit();
       }else{
         header("Location:Administrateur_page.php?messageDEL=non");
         exit();
       }
    }
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
     $conn ->close(); 
?>
    <!-- Modification de produit -->
<?php
    include 'Connexion.php';
    $message = '';
    $info_modif_product = null;

        if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["idProduitModify"])){
            $idProduit = $_GET["idProduitModify"];

    $sql_select = "SELECT * FROM produit WHERE id ='$idProduit'";
    $result_select = $conn->query($sql_select);
    if ($result_select->num_rows > 0) {
        $info_modif_product = $result_select->fetch_assoc();
    } else {
        $message = "Produit non trouvé.";
    }
    
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmerModifyProduit"])){
    
        $categorieProModify = $conn->real_escape_string($_POST['categorieProduitMdf']);
        $nomProModify = $conn->real_escape_string($_POST['nameProduitMdf']);
        $descriptionProModify = $conn->real_escape_string($_POST['descriptionProduitMdf']);
        $prixProModify = $conn->real_escape_string($_POST['prixProduitMdf']);
        $quantiteProModify = $conn->real_escape_string($_POST['quantiteProduitMdf']);

        /* gestion image */
             if(empty($_FILES['imageProduitMdf']['tmp_name'])){
                header("Location:Administrateur.php?message=erImage");
            }

             $file_basename = pathinfo($_FILES["imageProduitMdf"]["name"], PATHINFO_FILENAME);
             $file_extension = pathinfo($_FILES["imageProduitMdf"]["name"], PATHINFO_EXTENSION);
             $new_images_name = $file_basename .  '.' . $file_extension;
             $new_images_name = $conn ->real_escape_string($new_images_name);
        /* Charger dans le dossier */
        if($_FILES["imageProduitMdf"]["error"] == UPLOAD_ERR_INI_SIZE){
            $message ="L'image doit etre inferieur à 2 MO";
            header("Location:Administrateur_page.php?page=modify_product&uploadImageProduitMD=" . urlencode($message));
        }else{
        $dossier = "imageProduit/";
        $fichier = $dossier .$new_images_name;
        move_uploaded_file($_FILES['imageProduitMdf']['tmp_name'],$fichier );

        $sql_updateProMdf = "UPDATE produit SET categorie='$categorieProModify', nom='$nomProModify', description='$descriptionProModify', prix='$prixProModify', quantite='$quantiteProModify', libelleImage='$new_images_name' WHERE id='$idProduit'";
    
            if ($conn->query($sql_updateProMdf) === TRUE) {
                header("Location:Administrateur_page.php?page=all_menu");
                $message = "Informations du produit mises à jour avec succès.";
                $result_select = $conn->query($sql_select);
                $info_modif_product = $result_select->fetch_assoc();
            } else {
                $message = "Erreur de mise à jour: " . $conn->error;
            }
    }
}}
    $conn ->close(); 
?>
<!-- Session Employées -->
<?php
    include 'Connexion.php';

    // Fonction pour recuperer tous les administrateurs
    function getEmployees($conn) {
        $sql = "SELECT * FROM employe";
        $result = $conn->query($sql);
        $employes = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $employes[] = $row;
            }
        }
        return $employes;
    }

    $employes = getEmployees($conn);

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["idDElCompte"])){
        $idComDel = $_GET["idDElCompte"];
    $delproduitsql ="DELETE FROM `client` WHERE id='$idComDel' " ;
       if( $conn ->query($delproduitsql) === TRUE){
         header("Location:Administrateur_page.php?messageDELCompte=yes");
         exit();
       }else{
         header("Location:Administrateur_page.php?messageDELCompte=non");
         exit();
       }
    }
?>

<?php
  include ("Connexion.php");

    

?>

    <!-- Zone Statistique -->
       <!-- Total Montant de commandes confirmées -->
        <?php
          include ("Connexion.php");
           $countArgentCommandeConfirme ="SELECT SUM(prix_total) AS sommeArgent FROM reservation WHERE statut='confirmee' ";
           $countArgentCommandeConfirme = $conn ->query($countArgentCommandeConfirme);
           if($countArgentCommandeConfirme){
             $countArgentCommandeConfirme = $countArgentCommandeConfirme ->fetch_assoc();
           }
           $conn ->close(); 
        ?>
       <!-- Total Produit -->
        <?php
          include ("Connexion.php");
           $countProduit ="SELECT COUNT(*) AS total FROM produit";
           $resultCountProduit = $conn ->query($countProduit);
           if($resultCountProduit){
             $resultCountProduit = $resultCountProduit ->fetch_assoc();
           }
           $conn ->close(); 
        ?>
       <!-- Total Utilisateur -->
        <?php
          include ("Connexion.php");
           $countUser ="SELECT COUNT(*) AS total FROM client";
           $resultCountUser = $conn ->query($countUser);
           if($resultCountUser){
                $resultCountUser = $resultCountUser ->fetch_assoc();
           }
           $conn ->close(); 
        ?>
       <!-- Total Employées -->
        <?php
          include ("Connexion.php");
           $countEmpl ="SELECT COUNT(*) AS total FROM employe";
           $resultCountEmpl = $conn ->query($countEmpl);
           if($resultCountEmpl){
                $resultCountEmpl = $resultCountEmpl ->fetch_assoc();
           }
           $conn ->close(); 
        ?>
       <!-- Total Commande -->
        <!-- Total Commande Confirmée -->
            <?php
            include ("Connexion.php");
            $countReservationConfirme ="SELECT COUNT(*) AS totalConfirm FROM reservation WHERE statut ='confirmee' ";
            $resultCountReservationConfirme = $conn ->query($countReservationConfirme) ;
            if($resultCountReservationConfirme){
                $resultCountReservationConfirme = $resultCountReservationConfirme ->fetch_assoc();
            }
            $conn ->close(); 
            ?>
        <!-- Total Commande annulée -->
            <?php
            include ("Connexion.php");  
            $countReservationAnnule ="SELECT COUNT(*) AS totalClose FROM reservation WHERE statut ='annulee'";
            $resultCountReservationAnnule = $conn ->query($countReservationAnnule) ;
            if($resultCountReservationAnnule){
                $resultCountReservationAnnule = $resultCountReservationAnnule ->fetch_assoc();
            }   
            $conn ->close();      
            ?>
        <!-- Total Commande en attente --> 
            <?php
            include ("Connexion.php");         
            $countReservationAttente ="SELECT COUNT(*) AS totalWait FROM reservation WHERE statut ='en_attente' ";         
            $resultCountReservationAttente = $conn ->query($countReservationAttente) ;          
            if($resultCountReservationAttente){
                $resultCountReservationAttente = $resultCountReservationAttente ->fetch_assoc();
            }
            $conn ->close(); 
            ?>
       <!-- Total Abonnés -->
            <?php
            include ("Connexion.php");
            $countAbonne ="SELECT COUNT(*) AS total FROM subscription";
            $resultCountSubscription = $conn ->query($countAbonne) ;
            if($resultCountSubscription){
                $resultCountSubscription = $resultCountSubscription ->fetch_assoc();
            }
            $conn ->close(); 
            ?>
       <!-- Total Commentaire -->
            <?php
            include ("Connexion.php");
            $countComm ="SELECT COUNT(*) AS total FROM commentaire";
            $resultCountCommentaire = $conn ->query($countComm) ;
            if($resultCountCommentaire){
                $resultCountCommentaire = $resultCountCommentaire ->fetch_assoc();
            }
            $conn ->close(); 
            ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Systeme de reservation en ligne du restaurant FEDCOM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="style_Administrateur.css">
    <link rel="stylesheet" href="responsiveAdministratur.css">
</head>

<body>
    <header>
        <div class="header1">
            <div class="mail">
                <p style="color:#fff; font-size:20px; font-family:bodimi-mt; cursor:pointer;">FEDCOM</p>
            </div>
            <div class="mail">
                <p>fredmiguelnanguefeulefack@gmail.com</p>
            </div>
            <div class="number">
                <p><span>📞</span> +237 672 92 17 99</p>
            </div>
            <a href="logout.php" class="logout" onclick="return confirm('Voulez vous vraiment vous deconnecté')">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> DECONNEXION
            </a>
        </div>
    </header>

    <?php if (isset($_SESSION['admin'])): ?>
     
        <div class="vbox">
            <div class="profilAdministrateur">
                <?php
                    include 'Connexion.php';
                    /*liste des produits*/
                    
                    if(isset($_SESSION['admin'])){
                        $id =$_SESSION['admin']['id'];
                        $nom =$_SESSION['admin']['nom'];
                    $sqlImageAd="SELECT * FROM administrateur where id=$id ";
                    $results= $conn ->query($sqlImageAd);
                    if(mysqli_num_rows($results) >0){
                        /* afficher les blocus */
                                
                ?>
                <?php
                    while($row = mysqli_fetch_assoc($results)){
            
                ?>
                <img src="imageAdmin/<?=htmlspecialchars($row['libelleImageAD'])?>" alt="<?=htmlspecialchars($row['nom'])?>">
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
            <a href="?page=statistique" id="dash" class="<?php echo ($page == 'statistique') ? 'active' : ''; ?>"
                style="margin-top:15%;">
                <div class="icon-onglet"><i class="fas fa-fw fa-chart-area"></i></div> <div class="onglet-name">Statistique</div> 
            </a>
            <a href="?page=all_menu" class="<?php echo ($page == 'all_menu') ? 'active' : ''; ?>" id="al">
                <div class="icon-onglet"><i class="fa-solid fa-utensils"></i></div> <div class="onglet-name">Menu</div>
            </a>
            <a href="?page=orders" class="<?php echo ($page == 'orders') ? 'active' : ''; ?>" id="ord">
                <div class="icon-onglet"><i class="fa-solid fa-clipboard-list"></i></div> <div class="onglet-name">Commandes</div>
            </a>
            <a href="?page=client" class="<?php echo ($page == 'client') ? 'active' : ''; ?>" id="adm">
                <div><i class="fa-solid fa-user-tie"></i></div> <div class="onglet-name" style="margin-left:-2%;">Client</div>
            </a>
            <a href="?page=subscription" class="<?php echo ($page == 'subscription') ? 'active' : ''; ?>" id="sub">
                <div class="icon-onglet"><i class="fa-solid fa-envelope-open-text"></i></div> <div class="onglet-name">Subscription</div>
            </a>
            <a href="?page=messagerie" class="<?php echo ($page == 'messagerie') ? 'active' : ''; ?>" id="sub">
                <div class="icon-onglet"><i class="fas fa-envelope"></i></div> <div class="onglet-name">Messagerie</div>
            </a>
            <a href="?page=settings" class="<?php echo ($page == 'settings') ? 'active' : ''; ?>" id="set">
                <div class="icon-onglet"><i class="fa-solid fa-gear"></i></div> <div class="onglet-name">Parametre</div>
            </a>
        </div>  
    
        <div id="corpus" style="overflow: auto !important;">
            <?php 
            /* Pour la suppression de compte */
                if(isset($_GET["messageDELCompte"])  && $_GET["messageDELCompte"] =="yes"){
                    echo"    <div class='alert succes'>
                    <span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                    <strong>Succes !</strong> Compte Supprimé avec succès.
                    </div> ";       
                }elseif(isset($_GET["messageDELCompte"])  && $_GET["messageDELCompte"] =="no"){
                    echo"   <div class='alert error'>
                    <span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                    <strong>Erreur !</strong> Erreur lors de la suppression du Compte                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   .
                    </div> ";         
                }
            /* Pour la suppression de produit */
                if(isset($_GET["messageDEL"])  && $_GET["messageDEL"] =="yes"){
                    echo"    <div class='alert succes'>
                    <span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                    <strong>Succes !</strong> Produit Supprimé avec succès.
                    </div> ";       
                }elseif(isset($_GET["messageDEL"])  && $_GET["messageDEL"] =="no"){
                        echo"   <div class='alert error'>
                        <span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                        <strong>Erreur !</strong> Erreur lors de la suppression du produit.
                        </div> ";         
                }
            /* Pour l'ajout de produti */
                if(isset($_GET["message"])  && $_GET["message"] =="yes"){
                        echo "  <div class='alert succes'>
                        <span class='closebtn' onclick='this.parentElement.style.display=none;'>&times;</span>
                        <strong>Succes !</strong> Produit Enregistré avec succès.
                        </div> ";
                }elseif(isset($_GET["message"])  && $_GET["message"] =="no"){
                        echo "  <div class='alert error'>
                        <span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>
                        <strong>Erreur !</strong> Erreur lors de enregistrement du produit.
                        </div> ";
                }

                switch ($page){
                    case 'statistique':
                        ?>
                        <div id="dashborad">
                            <div style="display:flex; flex-direction:row;">
                                <div style="width:380px;">
                                    <h1>Welcome to the</h1>
                                    <h1 style="display:flex;">restaurant<span>FED</span>COM</h1>
                                </div>
                                <div id="chiffreAffaire">
                                    <?php echo $countArgentCommandeConfirme['sommeArgent'] . ' XAF'; ?> 
                                </div>
                            </div>
                            <div class="categorie">
                                <div class="d" onclick="btnRapide()">
                                    <div class="model">🍟</div>
                                    <div class="model-name">Fries</div>
                                </div>
                                <div class="d" onclick="btnRapide()">
                                    <div class="model">🧃</div>
                                    <div class="model-name">Juices</div>
                                </div>
                                <div class="d" onclick="btnRapide()">
                                    <div class="model">🍕</div>
                                    <div class="model-name">Pizza</div>
                                </div>
                                <div class="d" onclick="btnRapide()">
                                    <div class="model">🍔</div>
                                    <div class="model-name">Burger</div>
                                </div>
                                <div class="d" onclick="btnRapide()">
                                    <div class="model">🥛</div>
                                    <div class="model-name">Drinks</div>
                                </div>
                            </div>
                            <div class="zone-statistique">
                                <div class="statTotalProduit">
                                    <h2 class="countStat"><?php echo $resultCountProduit['total']; ?></h2>
                                    <p>Total Produits </p>
                                </div>
                                <div class="statTotalUtilisateur">
                                    <h2 class="countStat"><?php echo $resultCountUser['total']; ?></h2>
                                    <p> Total Utilisateurs </p>
                                </div>
                                <div class="statTotalEmploye">
                                <h2 class="countStat"><?php echo $resultCountEmpl['total']; ?></h2>
                                    <p>Total Employées </p>
                                </div>
                                <div class="statTotalCommande">
                                <h2 class="countStat"><?php echo $resultCountReservationConfirme['totalConfirm']; ?></h2>
                                    <p>Total Commande Confirmée </p>
                                </div>
                                <div class="statTotalCommande">
                                <h2 class="countStat"><?php echo $resultCountReservationAttente['totalWait']; ?></h2>
                                    <p>Total Commande en Attente </p>
                                </div>
                                <div class="statTotalCommande">
                                <h2 class="countStat"><?php echo $resultCountReservationAnnule['totalClose']; ?></h2>
                                    <p>Total Commande Annulée </p>
                                </div>
                                <div class="statTotalSubscription">
                                    <h2 class="countStat"><?php echo $resultCountSubscription['total']; ?></h2>
                                    <p>Total Abonnés </p>
                                </div>
                                <div class="statTotalCommentaire">
                                    <h2 class="countStat"><?php echo $resultCountCommentaire['total']; ?></h2>
                                    <p>Total Commentaire</p>
                                </div>
                            </div>
                            <div class="addEmployees">
                                <div style="display:flex; justify-content:space-between;">
                                    <h2>Liste Employées</h2>
                                <button class="add_product" id="addProduct"><a href="?page=add_personnel">+</a></button>
                                </div>
                                <table id="Employees_style" border="1">     
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Specialite</th>
                                            <th>Numero</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($employes)): ?>
                                        <tr>
                                            <td colspan="7">Aucun Employées trouvé.</td>
                                        </tr>
                                        <?php else: ?>
                                        <?php foreach ($employes as $employe): ?>
                                        <tr>
                                            <td>
                                                <?php echo htmlspecialchars($employe['id']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($employe['nom']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($employe['prenom']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($employe['specialite']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($employe['numero']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($employe['email']); ?>
                                            </td>
                                            <td class="actions">
                                                <!-- <a href="administrateur_edit.php?id=<?php echo $employe['id']; ?>" class="btn-edit">Modifier</a> -->
                                                <a href="administrateur_list.php?idDElCompte=<?php echo $employe['id']; ?>" class="btn-delete"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet Employé ?');">Supprimer</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <h2 class="titreCommentaire">Commentaire</h2>
                            <div class="viewCommentaire">      
                                            <?php
                                        include 'Connexion.php';
                                        /*liste des produits*/
                                        $sqlProduitView="SELECT * FROM commentaire ORDER BY id DESC LIMIT 10";
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
                        </div>
                        <?php
                        break;
                    case 'all_menu':
                        ?>
                        <div id="All_Menu">
                            <h1>All Menus</h1>
                            <div style="position:sticky;">
                                <h3>Nourritures selon les differentes categories</h3>
                                <button class="add_product" id="addProduct"><a href="?page=add_product">+</a></button>
                            </div>
                            <div id="scrollage">
                                <?php
                            include 'Connexion.php';
                            /*liste des produits*/
                            $sqlProduitView="SELECT * FROM produit";
                            $resultset= $conn ->query($sqlProduitView);
                            if(mysqli_num_rows($resultset) >0){
                                /* afficher les blocus */
                                        
                        ?>
                                <?php
                            while($row = mysqli_fetch_assoc($resultset)){
                        ?>
                                <div class="receptacle_produitAdministrateur">

                                    <img src="imageProduit/<?= $row['libelleImage']?>" alt="<?= htmlspecialchars($row['nom']) ?>"
                                        class="produit-image">
                                    <div class="produit-contenu">
                                        <div class="produit-preentete">
                                            <div class="produit-id">ID :
                                                <?=htmlspecialchars($row['id'])?>
                                            </div>
                                            <div class="produit-categorie">
                                                <?=htmlspecialchars($row['categorie'])?>
                                            </div>
                                        </div>
                                        <div class="produit-head">
                                            <div>
                                                <?=htmlspecialchars($row['nom'])?>
                                            </div>
                                            <div class="produit-headQte">
                                                <?=htmlspecialchars($row['quantite'])?> Qté
                                            </div>
                                        </div>
                                        <div class="produit-description">
                                            <?=htmlspecialchars($row['description'])?>
                                        </div>
                                    </div>
                                    <div class="produit-footer">
                                        <div class="produit-prix">
                                            <?=htmlspecialchars($row['prix'])?> FCFA
                                        </div>
                                        <div method="POST">
                                            <button class="produit-icon conProdModify" class="modifierProduit"
                                                name="modifierProduit" id="modifierProduit"><a
                                                    href="?page=modify_product&idProduitModify=<?=$row['id']?>" onclick="return confirm('Voulez Vous Vraiment Modifier Ce Produit ?')">🖌</a></button>
                                            <div class="produit-icon conProdDelete" id="deleteProduit" 
                                            name="deleteProduit"><a
                                                    href="?page=all_menu&idProduit=<?=$row['id']?>" onclick="return confirm('Voulez Vous Vraiment Supprimer Ce Produit ?')">🗑</a></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            }
                            else{
                                echo "<p class='alert_produit'> 0 produit enregistrer !</p>";
                            }
                            ?>

                            </div>
                        </div>
                        <?php
                        break;
                    case 'add_product':
                        ?>
                         <?php if (isset($_GET['uploadImageProduit'])): ?>
                        <p class="message-info"><?php echo htmlspecialchars($_GET['uploadImageProduit']); ?><span class='closebtn' onclick="this.parentElement.style.display='none';">&times;</span></p>
                        <?php endif; ?>
                        <div id="All_Menu_AddProduct">
                            <h1>Nouveau Produit</h1>
                            <h3>Ajouter Un Nouveau Produit</h3>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="elementGroupe">
                                    <div class="element">
                                        <div>
                                            <label for="nameProduit">Nom Produit</label>
                                            <input type="text" name="nameProduit" id="nameProduit"
                                                placeholder="Entrez le nom du produit" autocomplete="off" required>
                                        </div>
                                        <div>
                                            <label for="descriptionProduit">Description</label>
                                            <textarea name="descriptionProduit" id="descriptionProduit" rows="6" cols="50"
                                                placeholder="Entrer la description" autocomplete="off" required></textarea>
                                        </div>
                                        <div>
                                            <label for="prixProduit">Prix</label>
                                            <input type="text" name="prixProduit" id="prixProduit" placeholder="Entrez le prix"
                                            autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="element">
                                        <div>
                                            <label for="imageProduit">Image</label>
                                            <input type="file" accept="image/*" name="imageProduit" id="imageProduit" required>
                                        </div>
                                        <div>
                                            <label for="categorieProduit">Categorie</label>
                                            <select name="categorieProduit" id="categorieProduit" required>
                                                <option value="">-- Sélectionner une catégorie --</option>
                                                <option value="Premier_repas">Petit Dejeuner</option>
                                                <option value="Dejeuner">Déjeuner</option>
                                                <option value="Diner">Dîner</option>
                                                
                                            </select>
                                        </div>
                                        <div>
                                            <label for="quantiteProduit">Quantité</label>
                                            <input type="number" min="0" name="quantiteProduit" id="quantiteProduit" autocomplete="off" required>
                                        </div>
                                        <div>
                                            <button type="submit" name="confirmerAddNewProduit"
                                                name="confirmerAddNewProduitMEssage_error"
                                                id="confirmerAddNewProduit">Confirmer</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                        break;
                    case 'add_personnel':
                        ?>
                         <?php if (isset($_GET['uploadImagePersonnel'])): ?>
                        <p class="message-info"><?php echo htmlspecialchars($_GET['uploadImagePersonnel']); ?><span class='closebtn' onclick="this.parentElement.style.display='none';">&times;</span></p>
                        <?php endif; ?>
                        <div id="personne">
                            <h1>Nouveau Personel</h1>
                            <h3>Ajouter Un Nouveau Personnel</h3>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="elementGroupe">
                                    <div class="element">
                                        <div>
                                            <label for="namePersonnel">Nom </label>
                                            <input type="text" name="namePersonnel" id="namePersonnel"
                                                placeholder="Entrez le nom du personnel" autocomplete="off" required>
                                        </div>
                                        <div>
                                            <label for="secondnamePersonnel">Prenom</label>
                                            <input type="text" name="secondnamePersonnel" id="secondnamePersonnel"
                                                placeholder="Entrez le prenom du personnel" autocomplete="off" required>
                                        </div>
                                        <div>
                                            <label for="specialite">Specialite</label>
                                            <input type="text" name="specialite" id="specialite" placeholder="Entrez la specialite"
                                            autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="element">
                                        <div>
                                            <label for="numeroPersonnel">Numero</label>
                                            <input type="tel" name="numeroPersonnel" id="numeroPersonnel" placeholder="Entrez le numero"
                                            autocomplete="off" required>
                                        </div>
                                        <div>
                                            <label for="emailPersonnel">Email</label>
                                            <input type="mail" name="emailPersonnel" id="emailPersonnel" placeholder="Entrez email@gmail.com"
                                            autocomplete="off" required>
                                        </div>
                                        <div>
                                            <label for="imagePersonnel">Image</label>
                                            <input type="file" accept="image/*" name="imagePersonnel" id="imagePersonnel" required>
                                        </div>
                                        <div>
                                            <button type="submit" name="confirmerAddNewPersonnel"
                                                id="confirmerAddNewProduit">Confirmer</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                        break;
                    case 'modify_product':
                        ?>
                        <?php if (isset($_GET['uploadImageProduitMD'])): ?>
                        <p class="message-info"><?php echo htmlspecialchars($_GET['uploadImageProduitMD']); ?><span class='closebtn' onclick="this.parentElement.style.display='none';">&times;</span></p>
                        <?php endif; ?>
                        <div id="All_Menu_AddProduct">
                            <h1>Modifier Produit</h1>
                            <h3>Modifier Un Produit</h3>
                            <!-- <?php if ($info_modif_product): ?> -->
                            <form action="" method="post" enctype="multipart/form-data"  name="confirmerModifyProduit">
                                <div class="elementGroupe">
                                    <div class="element">
                                        <div>
                                            <label for="nameProduit">Nom Produit</label>
                                            <input type="text" name="nameProduitMdf" id="nameProduitMdf"
                                            value="<?php echo htmlspecialchars($info_modif_product['nom']); ?>" autocomplete="off">
                                        </div>
                                        <div>
                                            <label for="descriptionProduit">Description</label>
                                            <textarea name="descriptionProduitMdf" id="descriptionProduitMdf" rows="6" cols="50"><?php echo htmlspecialchars($info_modif_product['description']); ?></textarea>
                                        </div>
                                        <div>
                                            <label for="prixProduit">Prix</label>
                                            <input type="text" name="prixProduitMdf" id="prixProduitMdf" value="<?php echo htmlspecialchars($info_modif_product['prix']); ?>"
                                            autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="element">
                                        <div>
                                            <label for="imageProduit">Image</label>
                                            <input type="file" accept="image/*" name="imageProduitMdf" id="imageProduitMdf" value="<?php echo htmlspecialchars($info_modif_product['libelleImage']); ?>">
                                        </div>
                                        <div>
                                            <label for="categorieProduit">Categorie</label>
                                            <select name="categorieProduitMdf" id="categorieProduitMdf" value="<?php echo htmlspecialchars($info_modif_product['categorie']); ?>" required>
                                                <option value="<?php echo htmlspecialchars($info_modif_product['categorie']); ?>" disabled="disabled"><?php echo htmlspecialchars($info_modif_product['categorie']); ?></option>
                                                <option value="Premier_repas">Petit Dejeuner</option>
                                                <option value="Dejeuner">Déjeuner</option>
                                                <option value="Diner">Dîner</option>
                                            </select> 
                                        </div>
                                        <div>
                                            <label for="quantiteProduit">Quantité</label>
                                            <input type="number" min="0" name="quantiteProduitMdf" id="quantiteProduitMdf" value="<?php echo htmlspecialchars($info_modif_product['quantite']); ?>" autocomplete="off">
                                        </div>
                                        <div>
                                            <button type="submit"
                                                id="confirmerModifyProduit">Modifier</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- <?php else: ?>
                            <p class="message-error">Impossible de charger les informations du produit.</p>
                            <?php endif; ?> -->
                        </div>
                        <?php
                        break;
                    case 'orders':
                        include 'orders.php';
                        break;
                    case 'client':
                        include 'client_list.php';
                        break;
                    case 'subscription':
                        include 'subscription.php';
                        break;
                    case 'messagerie':
                        include 'messageriefedcom.php';
                        break;
                    case 'settings':
                        include 'settings.php';
                        break;
                    default:
                        ?>
                        <div id="dashborad">
                            <div style="display:flex; flex-direction:row;">
                                <div style="width:380px;">
                                    <h1>Welcome to the</h1>
                                    <h1 style="display:flex;">restaurant<span>FED</span>COM</h1>
                                </div>
                                <div id="chiffreAffaire">
                                    <?php echo $countArgentCommandeConfirme['sommeArgent'] . ' XAF'; ?> 
                                </div>
                            </div>
                            <div class="categorie">
                                <div class="d" onclick="btnRapide()">
                                    <div class="model">🍟</div>
                                    <div class="model-name">Fries</div>
                                </div>
                                <div class="d" onclick="btnRapide()">
                                    <div class="model">🧃</div>
                                    <div class="model-name">Juices</div>
                                </div>
                                <div class="d" onclick="btnRapide()">
                                    <div class="model">🍕</div>
                                    <div class="model-name">Pizza</div>
                                </div>
                                <div class="d" onclick="btnRapide()">
                                    <div class="model">🍔</div>
                                    <div class="model-name">Burger</div>
                                </div>
                                <div class="d" onclick="btnRapide()">
                                    <div class="model">🥛</div>
                                    <div class="model-name">Drinks</div>
                                </div>
                            </div>
                            <div class="zone-statistique">
                                <div class="statTotalProduit">
                                    <h2 class="countStat"><?php echo $resultCountProduit['total']; ?></h2>
                                    <p>Total Produits </p>
                                </div>
                                <div class="statTotalUtilisateur">
                                    <h2 class="countStat"><?php echo $resultCountUser['total']; ?></h2>
                                    <p> Total Utilisateurs </p>
                                </div>
                                <div class="statTotalCommande">
                                <h2 class="countStat"><?php echo $resultCountReservationConfirme['totalConfirm']; ?></h2>
                                    <p>Total Commande Confirmée </p>
                                </div>
                                <div class="statTotalCommande">
                                <h2 class="countStat"><?php echo $resultCountReservationAttente['totalWait']; ?></h2>
                                    <p>Total Commande en Attente </p>
                                </div>
                                <div class="statTotalCommande">
                                <h2 class="countStat"><?php echo $resultCountReservationAnnule['totalClose']; ?></h2>
                                    <p>Total Commande Annulée </p>
                                </div>
                                <div class="statTotalSubscription">
                                    <h2 class="countStat"><?php echo $resultCountSubscription['total']; ?></h2>
                                    <p>Total Abonnés </p>
                                </div>
                            </div>
                        </div>
                        <?php
                        break;
                }
        
            ?>
        </div>  
                
    <?php else: 
        echo '<a href="accueil.php?page=connexion" style="margin:auto; padding: 4%; font-size: 20px; border-radius:2rem; margin-top:20%; text-decoration: none; color: white; background-color: rgb(77, 161, 77);">Se connecter</a>';
        ?> 
    <?php endif; ?>
</body>
</html> 
