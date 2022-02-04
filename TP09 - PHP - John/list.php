<?php require_once('inc/header.inc.php'); 

$afficheAppart = $pdo->query("SELECT * FROM advert ORDER BY id DESC");

?>

<h1 class="text-center text-danger my-5">Consultez toutes nos annonces</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Annonce</th>
            <th>Lieu</th>
            <th>Prix et type</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <!-- Je fais une boucle WHILE pour recupérer mes valeurs -->
    <?php while($appart = $afficheAppart->fetch (PDO::FETCH_ASSOC)): ?>
            <tr>
                <td>
                    <strong>><?= strtoupper($appart['title'])?></strong>
                    <p>
                        <small>
                        <?= $appart['description']?>
                        </small>
                    </p>
                </td>
                <td>
                    <?= $appart['postal_code'] . " " . $appart['city'] ?>
                    
                    <?php if(!empty($appart['reservation_message'])): ?>
                    <span class="badge bg-success">Ce bien a déjà été réservé !</span>
                    <?php endif ?>
                    
                </td>
                <td>
                    <span class="badge bg-primary"><?= $appart ['type'] ?></span>
                    <span class="badge bg-secondary"><?= $appart ['price'] ?> €</span>
                </td>
                <td>
                    <a href="show.php?id=<?= $appart['id']?>" class="btn btn-warning">Voir l'annonce</a>
                </td>
            </tr>
            <?php endwhile ?>
    </tbody>
</table>

<?php require_once('inc/footer.inc.php');