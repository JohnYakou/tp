<?php require_once('inc/header.inc.php');

if($_POST){
    // Doit faire entre 3 et 20 caractères
    if(!isset($_POST['title']) || iconv_strlen($_POST['title']) <= 3 || iconv_strlen($_POST['title']) > 20){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format Titre ! Min. 3 (max. 20) caractères autorisés !</div>';
    }
    // Doit faire entre 3 et 250 caractères
    if(!isset($_POST['description']) || iconv_strlen($_POST['description']) <= 3 || iconv_strlen($_POST['description']) > 250){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format description ! Min. 2 (max. 250) caractères autorisés !</div>';
    }
    // Doit OBLIGATOIREMENT faire 5 caractères, tous des chiffres de 0 à 9
    if(!isset($_POST['postal_code']) || !preg_match("#^[0-9]{5}$#", $_POST['postal_code'])){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format code postal ! Le code postal doit faire OBLIGATOIREMENT 5 caractères / nombres !</div>';
    }
    // Doit faire entre 2 et 50 caractères
    if(!isset($_POST['city']) || iconv_strlen($_POST['city']) <= 2 || iconv_strlen($_POST['city']) > 50){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format ville ! La ville doit contenir entre 2 et 50 caractères !</div>';
    }
    // Je fais en sorte que l'utilisateur choisissent entre 'location' OU 'vente'
    if(!isset($_POST['type']) || $_POST['type' ] != 'location' && $_POST['type'] != 'vente'){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format type ! Choissisez entre location OU vente !</div>';
    }
    // L'utilisateur peut saisir max. 7 (min. 1) caractères, OBLIGATOIREMENT des nombres de 0 à 9
    if(!isset($_POST['price']) || !preg_match("#^[0-9]{1,7}$#", $_POST['price'])){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format tarif ! Le tarif doit faire entre 1 et 7 caractères !</div>';
    }

    if(empty($erreur)){
        $ajoutAppart = $pdo->prepare("INSERT INTO advert (title, description, postal_code, city, type, price) VALUES (:title, :description, :postal_code, :city, :type, :price)");
        $ajoutAppart->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
        $ajoutAppart->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $ajoutAppart->bindValue(':postal_code', $_POST['postal_code'], PDO::PARAM_INT);
        $ajoutAppart->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
        $ajoutAppart->bindValue(':type', $_POST['type'], PDO::PARAM_STR);
        $ajoutAppart->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
        $ajoutAppart->execute();

        $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
            <strong>Félicitations !</strong>Ajout du logement réussie !
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}

?>

<h1 class="text-center text-danger my-5">Ajouter une annonce</h1>

<?= $erreur ?>

<!-- Les differents champs pour ajouter l'annonce -->
<form class="col-md-6 mb-5" method="post" action="">

<p class="mb-2">* Champs obligatoires</p>

    <div class="form-group my-2">
        <label for="title">Titre *</label>
        <input id="title" name="title" type="text" class="form-control" placeholder="Ajouter un titre" required value="">
    </div>

    <div class="form-group my-2">
        <label for="description">Description *</label>
        <textarea id="description" name="description" id="" cols="30" rows="5" class="form-control" placeholder="Une description sincère du logement !" required></textarea>
    </div>

    <div class="form-group my-2">
        <label for="postal_code">Code postal *</label>
        <input id="postal_code" name="postal_code" type="text" class="form-control" placeholder="code postal (5 nombres)" value="" required>
    </div>

    <div class="form-group my-2">
        <label for="city">Ville *</label>
        <input id="city" name="city" type="text" class="form-control" placeholder="Ville" value="" required>
    </div>

    <div class="form-group my-2">
        <label for="type">Type *</label>
        <select name="type" id="type" class="form-control" required>
            <option value="location">Location</option>
            <option value="vente">Vente</option>
        </select>
    </div>

    <div class="form-group my-2">
        <label for="price">Tarif *</label>
        <div class="input-group">
            <input id="price" name="price" type="price" class="form-control" placeholder="prix à la location/mois ou prix de vente" required>
            <div class="input-group-append">
                <div class="input-group-text">€</div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-outline-primary mt-5">Créer une annonce</button>
</form>

<?php require_once('inc/footer.inc.php');