<?php
    session_start();
    include 'Connexion.php';
    if($_SERVER["REQUEST_METHOD"] ==="POST" && isset($_POST["soumision_AdministrateurData"])){
        $emailCon=$_POST['emailCon'];
        $passwordCon=$_POST["passwordCon"];
    
        $stmt = $conn ->prepare("SELECT * FROM administrateur WHERE email= ?");
        $stmt ->bind_param("s", $emailCon);
        $stmt ->execute();
        $result = $stmt ->get_result();
        $user = $result ->fetch_assoc();
    if($user){
        if(password_verify($passwordCon, $user['password'])){
            $_SESSION['admin'] = [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
                'libelleImageAD' => $user['libelleImageAD']
            ];
            header("Location:Administrateur_page.php");
            exit;
        }else{echo "⚠ Mot de passe incorrect !";}
    }else{
        echo " ⚠ Adresse Email Incorrect. Veillez reessayer !";
    }
    $stmt ->close();
    $conn ->close(); 
    }
?>

<?php
    include 'Connexion.php';
    $message = '';
 if($_SERVER["REQUEST_METHOD"] ==="POST" && isset($_POST["inscription_AdministrateurData"])){
    $nomad = $_POST["username"];
    $prenomad = $_POST["second_name"];
    $mailad  = $_POST["email"];
    $numberad = $_POST["telnumber"];
    $passwordad =  $_POST["password"];
    $passwordConfirmad =$_POST["password_confirm"];
    /* Verification */
    if($passwordad !== $passwordConfirmad){
        die("Les mots de passe ne correspondent pas.");
    }
    if(!filter_var($mailad, FILTER_VALIDATE_EMAIL)){
        die("E-mail invalide.");
    }

    /* vérification de l'existance d'email */
    $stmt = $conn ->prepare("SELECT id FROM administrateur WHERE email =?");
    $stmt ->bind_param("s", $mailad);
    $stmt ->execute();
    $result = $stmt ->get_result();
    if($result ->num_rows >0){
        die("Cet e-mail est deja utilisé.");
    }

    /* gestion image */
             if(empty($_FILES['imageADM']['tmp_name'])){
                header("Location:Connexion_page.php?message=erImage");
            }

             $file_basenam = pathinfo($_FILES["imageADM"]["name"], PATHINFO_FILENAME);
             $file_extensio = pathinfo($_FILES["imageADM"]["name"], PATHINFO_EXTENSION);
             $new_images_ad = $file_basenam .  '.' . $file_extensio;
              $new_images_ad = $conn ->real_escape_string($new_images_ad);
              
    /* Haché le mot de passe */
    $hashedPassword = password_hash($passwordad, PASSWORD_DEFAULT);

    /* Charger dans le dossier */
    $dossier = "imageAdmin/";
    $fichier = $dossier .$new_images_ad;
    move_uploaded_file($_FILES['imageADM']['tmp_name'],$fichier );
    
    /*insertion a la base de donnees */
    $newAdmin = "INSERT INTO administrateur(nom,prenom,numero,email,password,libelleImageAD)
                 VALUES ('$nomad','$prenomad','$numberad','$mailad ','$hashedPassword','$new_images_ad')";

    if( $conn ->query($newAdmin) === TRUE){
        header("Location:accueil.php?messageADDComteAD=yes&page=connexion");
        $message ="Inscription reussi avec succes !";
        exit();
    }else{
         header("Location:accueil.php?messageADDComteAD=no&page=newCompte");
         $message ="Inscription echoué !";
        exit();
    }
 }
 $conn ->close();

 $page = isset($_GET['page']) ? $_GET['page'] : 'acccueil'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Systeme de reservation en ligne du restaurant FEDCOM</title>
    <link rel="stylesheet" href="style_Connexion.css">
</head>

<body>
    <header>
        <h1>🍽FEDCOM RESTAURANT</h1>
        <ul class="menu">
            <li><a href="?page=accueil" id="menu1" class="<?php echo ($page == 'accueil') ? 'active' : ''; ?>">Accueil</a></li>
            <li><a href="?page=connexion" id="menu2" class="<?php echo ($page == 'connexion') ? 'active' : ''; ?>">Connexion</a></li>
            <li><a href="?page=newCompte" id="menu3" class="<?php echo ($page == 'newCompte') ? 'active' : ''; ?>">Creer Compte</a></li>
            <li><a href="/2025_projet/Reservation_Pour_Restaurant/page_accueil.php">CLient Page</a></li>

        </ul>
    </header>
    <?php
    
    switch($page) {
        case 'accueil':
            ?>
            <main style="display:flex; flex-direction:row;">     
                <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; flex-wrap: wrap;">
                    <div style="flex: 1; margin: 15% 50% 0% -90%;width:300px;">
                        <h4 style="color: green; font-size: 20px;">À Propos</h4>
                        <p style="font-size: 24px;">Votre restaurant préféré. Nous vous offrons une expérience culinaire inoubliable avec des produits frais et de qualité.</p>
                    </div>
                <div class="boxGroup">
                    <div class="box">
                    <div class="box2">
                    </div>
                </div>
                </div>
           </main>
          <?php
            break;
        case 'connexion':
            ?>
            <main>
                <form action="" method="POST" id="client">
                    <div>CONNEXION ADMINISTRATEUR</div><hr>
                    <div>
                        <label for="email">E-mail :</label>
                        <input type="email" name="emailCon" id="usernameCon" placeholder="Entrez votre nom utilisateur" required>
                    </div>
                    <div class="password-container">
                        <label for="password">Mot de passe :</label>
                        <input type="password" name="passwordCon" id="passwordCon" placeholder="Entrez votre mot de passe" required >
                        <span id="togglePassword">👁️</span>
                    </div>
                    <div>
                        <input type="submit" value="Se connecter" name="soumision_AdministrateurData">
                    </div>
                </form>
            </main>
            <?php
            break;
        case 'newCompte':
            ?>
            <main>
                <form action="" method="post" enctype="multipart/form-data" id="client">
                    <caption>CREER UN NOUVEAU COMPTE</caption><hr>
                    <?php if ($message): ?>
                    <p class="message-info"><?php echo $message; ?></p>
                <?php endif; ?>
                    <div>
                        <label for="username">Nom :</label>
                        <input type="text" name="username" id="username" placeholder="Entrez votre nom utilisateur" required>
                    </div>
                    <div>
                        <label for="second_name">Prénom :</label>
                        <input type="text" name="second_name" id="secondname" placeholder="Entrez votre nom utilisateur" required>
                    </div>
                    <div>
                        <label for="email">E-mail :</label>
                        <input type="email" name="email" id="email" placeholder="Entrez votre adresse email" required>
                    </div>
                    <div>
                        <label for="telnumber">Numero de Telephone:</label>
                        <input type="number" name="telnumber" id="telnumber" min="0" placeholder="Entrez votre numero de telephone" required>
                    </div>
                    <div>
                        <label for="password">Mot de passe :</label>
                        <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required>
                        <span id="togglePasswo">👁️</span>
                    </div>
                    <div>
                        <label for="password_confirm">Confirmer le mot de passe :</label>
                        <input type="password" name="password_confirm" id="password_confirm" placeholder="Entrez votre mot de passe" required>
                        <span id="togglePasswor">👁️</span>
                    </div>
                    <div>
                        <label for="imageADM">Photo de profil :</label>
                        <input type="file" accept="image/*" name="imageADM" id="imageADM" placeholder="Entrez votre mot de passe à nouveau" required>
                    </div>
                    <div>
                        <input type="submit" value="S'inscrire" name="inscription_AdministrateurData">
                    </div>
                </form>
            </main>
            <?php
            break;
        default :
            ?>
            <main style="display:flex; flex-direction:row;">     
                    <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <div style="flex: 1; margin: 15% 50% 0% -90%;width:300px;">
                            <h4 style="color: green; font-size: 20px;">À Propos</h4>
                            <p style="font-size: 24px;">Votre restaurant préféré. Nous vous offrons une expérience culinaire inoubliable avec des produits frais et de qualité.</p>
                        </div>
                    <div class="boxGroup">
                        <div class="box">
                        <div class="box2">
                        </div>
                    </div>
                    </div>
            </main>
            <?php
            break;
        } 
    ?>
</body>
<!-- <script src="script_connexion.js"></script> -->
</html> 