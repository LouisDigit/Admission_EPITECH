<?php
session_start();
// include "connexionPDO.php";
if(!isset($_SESSION['login']))
{
    header('Location:index.php');
}
include "connexionPDO.php";
// Variable du user
$userData = $db->query('SELECT * FROM user WHERE id = "'.$_SESSION['login'].'"');
$data = $userData->fetchArray(SQLITE3_ASSOC);
$name = $data['nom'];

// Formulaire de carte
    if(isset($_POST['card']))
    {
      $nom = $_POST['cardName'];
      $societe = $_POST['cardCompanyName'];
      $email = $_POST['cardEmail'];
      $tel = $_POST['cardPhone'];
    }
    if (!empty($email))
    {
        $TestEmail = $db->query('SELECT nom FROM card WHERE (email = "'.$email.'") AND (id = "'.$_SESSION['login'].'")');
        $row=$TestEmail->fetchArray(SQLITE3_ASSOC);
        if ($row != false) {
            $return = "Votre adresse email est déjà utilisée !";
        } else {
            $db->exec('INSERT INTO card(id,nom,societe,email,tel) VALUES("'.$_SESSION['login'].'","'.$nom.'","'.$societe.'","'.$email.'","'.$tel.'")');
            $return = "Votre carte est bien enregistrée";
        }
    } else {
        $return = "Champ email obligatoire";
    }




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Vos Business Card</title>
</head>
<body>
    <header>
        <h1>Cartes de visites de Monsieur/Madame <?php echo $name?></h1>
    </header>
    <div class="content">
    <div class="form-card">
    <form action="#" method="POST">
    <h3>Ajouter une carte de visite :</h3>
    <p><?php if (isset($_POST['card']) AND isset($return)) echo $return; ?></p>
    <div class="mb-3">
    <label for="cardName" class="form-label">Nom :*</label>
    <input type="text" class="form-control" id="cardName" name="cardName">
    </div>
   <div class="mb-3">
    <label for="cardCompanyName" class="form-label">Nom de la société :*</label>
    <input type="text" class="form-control" id="cardCompanyName" name="cardCompanyName">
  </div>
  <div class="mb-3">
    <label for="cardEmail" class="form-label">Adresse email : </label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" for="cardEmail" name="cardEmail">
  </div>
  <div class="mb-3">
    <label for="cardPhone" class="form-label">Numéro de telephone : *</label>
    <input type="text" class="form-control" id="subscribePhone" name="cardPhone">
  </div>
  <button type="submit" name="card" class="btn btn-primary">Ajouter</button>
</form>
</div>

<div class="card-content">
    <h2>Voici vos cartes de visites :</h2>
    <?php 
    $result = $db->query('SELECT * FROM card WHERE id="'.$_SESSION['login'].'"');
    $row = array();
    $i = 0;
    ?>
    <table class="table table-dark table-striped">
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Société</th>
            <th scope="col">Email</th>
             <th scope="col">Téléphone</th>
        </tr>
    <?php
        while($res = $result->fetchArray(SQLITE3_ASSOC)){
        if($res['id'] != $_SESSION['login']) continue;
        $row[$i]['nom'] = $res['nom'];
        $row[$i]['societe'] = $res['societe'];
        $row[$i]['email'] = $res['email'];
        $row[$i]['tel'] = $res['tel'];
        echo '<tr>';
        echo '<td>"'.$res['nom'].'"</td>';
        echo '<td>"'.$res['societe'].'"</td>';
        echo '<td>"'.$res['email'].'"</td>';
        echo '<td>"'.$res['tel'].'"</td>';
        echo '</tr>';
        $i++;
        }
    ?>   
    </table>
</div>
</div>
<a href="logout.php">Se deconnecter</a>
</body>
</html>