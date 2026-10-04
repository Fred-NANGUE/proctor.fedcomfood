<?php
include 'Connexion.php';
$message = '';
$admin = null;

if(isset($_SESSION['admin'])){
    $id =$_SESSION['admin']['id'];

$sql_select = "SELECT id , nom, prenom, email FROM administrateur WHERE id = '$id'";
$result_select = $conn->query($sql_select);
if ($result_select->num_rows > 0) {
    $admin = $result_select->fetch_assoc();
} else {
    $message = "Administrateur non trouvé.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mdfAD"])) {
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenomn = $conn->real_escape_string($_POST['prenom']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql_update = "UPDATE administrateur SET nom='$nom', prenom='$prenomn', email='$email' ";
    
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
<div id="settings-container">
    <h2>Paramètres de l'Administrateur</h2>
    <?php if ($message): ?>
        <p class="message-info"><?php echo $message; ?><span onclick="this.parentElement.style.display='none';" class="closebtn">&times;</span></p>
    <?php endif; ?>

    <!-- <?php if ($admin): ?> -->
        <form method="POST" action="Administrateur_page.php?page=settings">
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
                  <button type="submit" class="btn-primary" name="mdfAD" onclick="return confirm('Etes vous sur de vouloir apporter des modifications ?')">Enregistrer les modifications</button>
             </div>
           
        </form>
    <!-- <?php else: ?>
        <p class="message-error">Impossible de charger les informations de l'administrateur.</p>
    <?php endif; ?> -->
</div>

