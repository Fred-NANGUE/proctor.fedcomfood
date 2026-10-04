<?php
    include 'Connexion.php';

    // Fonction pour recuperer tous les administrateurs
    function getAdministrateurs($conn) {
        $sql = "SELECT id, nom, numero, email FROM client";
        $result = $conn->query($sql);
        $administrateurs = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $administrateurs[] = $row;
            }
        }
        return $administrateurs;
    }

    $administrateurs = getAdministrateurs($conn);
?>

<?php
  include ("Connexion.php");

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


<div id="adminTable">
    <h2>Gestion des Clients</h2>

    <a href="/2025_projet/Reservation_Pour_Restaurant/page_accueil.php#contact_main" class="btn-add"
        onclick="return confirm('Etes vous sur de vouloir vous déconnecté ?')">Ajouter un Client</a>

    <?php if (isset($_GET['admin_message'])): ?>
    <p class="message-success">
        <?php echo htmlspecialchars($_GET['admin_message']); ?>
    </p>
    <?php endif; ?>
    <div class="tab">
        <table id="Administrateur_style" border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Numero</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($administrateurs)): ?>
                <tr>
                    <td colspan="5">Aucun administrateur trouvé.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($administrateurs as $admin): ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($admin['id']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($admin['nom']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($admin['numero']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($admin['email']); ?>
                    </td>
                    <td class="actions">
                        <!-- <a href="administrateur_edit.php?id=<?php echo $admin['id']; ?>" class="btn-edit">Modifier</a> -->
                        <a href="administrateur_page.php?idDElCompte=<?php echo $admin['id']; ?>" class="btn-delete"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
<?php $conn->close(); ?>
<style>
    #adminTable h2{
        margin: 2% 0% 0% 2%;
    }
    #adminTable a{
        margin: 2% 0% 0% 1%;
    }
    /* Tables */
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