<?php require_once('inc/header.inc.php'); 

// J'utilise $_GET pour recevoir la valeur dans l'URL
if(!isset($_GET['id']) || !ctype_digit($_GET['id']) || $_GET['id'] < 1){
    header('location:list.php');
}

if($_POST){
    // Le message fera entre 3 et 200 caractères
    if(!isset($_POST['reservation_message']) || iconv_strlen($_POST['reservation_message']) < 3 || iconv_strlen($_POST['reservation_message']) > 200){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format message !</div>';

    }

    if(empty($erreur)){
        $ajoutMessage = $pdo->prepare("UPDATE advert SET id = :id, reservation_message = :reservation_message WHERE id = :id");
        $ajoutMessage->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $ajoutMessage->bindValue(':reservation_message', $_POST['reservation_message'], PDO::PARAM_STR);
        $ajoutMessage->execute();
    }
}

$afficheInformations = $pdo->query("SELECT * FROM advert WHERE id=$_GET[id]");

$information = $afficheInformations->fetch(PDO::FETCH_ASSOC);

?>

<h1 class="text-center text-danger my-5">Appart <?= $information['title']?> en <?= $information['type']?></h1>

<?= $erreur ?>

<a href="list.php"><button class="btn btn-outline-danger">Retour à la liste des biens</button></a>
<hr>
<div class="card col-md-6 my-5 border border-warning text-center">
    <div class="card-header">
    Le logement <?= $information['title']?> est disponible à <?= $information['city'] ?> (code postal : <?= $information['postal_code']?>)
    </div>

    <div class="card-body">
        <h5 class="card-title">Ce logement est proposé à la  <?= $information['type']?> au prix de 
        <?php if($information['type'] == 'vente'){
            echo $information['price'] .  " €";
        }else{
            echo $information['price'] . " €/j";
        }
         ?>

        </h5>
        <p class="card-text"></p>
    </div>

    <?php if(empty($information['reservation_message'])): ?>
    
        <p>
            <strong>
                Ce logement n'est pas réservé ! Soyez les premiers à laisser un message afin que le propriétaire vous recontacte.
            </strong>

            <form class="mx-5" action="" method="post">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <div class="form-group">
                    <label for="formReservationMessage">Message de réservation</label>
                    <textarea name="reservation_message" id="formReservationMessage" rows="5" class="form-control" placeholder="Donnez un maximum de détails pour que le propriétaire vous recontacte !"></textarea>
                </div>

                <button class="btn btn-outline-danger mt-3">Je réserve ce logement !</button>
            </form>
        </p>
    
        <?php else: ?>
        <div class="alert alert-warning">
            <p>
                Ce logement a été reservé, voici le message du futur conducteur :
                <hr>
                <em><?= $information['reservation_message'] ?></em>
            </p>
        </div>

        <?php endif; ?>
    
</div>

<?php require_once('inc/footer.inc.php');