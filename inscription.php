<?php
    // include "header.php";
    include "connexionPDO.php";

    // Formulaire d'inscription
    if(isset($_POST['inscription']))
    {
      $nom = Securise($_POST['subscribeName']);
      $societe = Securise($_POST['subscribeCompanyName']);
      $email = Securise($_POST['subscribeEmail']);
      $tel = Securise($_POST['subscribePhone']);
      $mdp1 = Securise($_POST['mdp1']);
      $mdp2 = Securise($_POST['mdp2']);
    }
    if (!empty($nom) AND !empty($societe) AND !empty($email) AND !empty($tel) AND !empty($mdp1) AND!empty($mdp2))
    {
      if (filter_var($email,FILTER_VALIDATE_EMAIL))
      {
        if ($mdp1 == $mdp2)
        {
            if (strlen($nom) <= 50)
            {
                $TestEmail = $db->query('SELECT nom FROM user WHERE email = "'.$email.'"');
                $row=$TestEmail->fetchArray(SQLITE3_ASSOC);
                if ($row != false) {
                  $return = "Votre adresse email est déjà utilisée !";
                } else {
                  $mdp1 = PasswordHash($mdp1);
                  $db->exec('INSERT INTO user(nom,societe,email,tel,mdp) VALUES("'.$nom.'","'.$societe.'","'.$email.'","'.$tel.'","'.$mdp1.'")');
                  $return = "Vous êtes bien inscris";
                }
            }else {
              $return  = "Votre nom dépasse 50 caractères !";
            }
        } else {
          $return = "Vos mots de passes ne correspondent pas !";
        }
      } else {
        $return = "L'email est invalide !";
      }
    } else {
      $return = "Un ou plusieurs champs sont manquant !";
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Business Card Manager</title>
</head>
<body>
  <header>
        <h1>Business Card Manager</h1>
    </header>
    <div class="form-login">
    <form action="#" method="POST">
    <p><?php if (isset($_POST['inscription']) AND isset($return)) echo $return; ?></p>
    
    <div class="mb-3">
    <label for="subscribeName" class="form-label">Votre nom :</label>
    <input type="text" class="form-control" id="subscribeName" name="subscribeName">
    </div>
   <div class="mb-3">
    <label for="subscribeCompanyName" class="form-label">Nom de la société :</label>
    <input type="text" class="form-control" id="subscribeCompanyName" name="subscribeCompanyName">
  </div>
  <div class="mb-3">
    <label for="subscribeEmail" class="form-label">Adresse email : </label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" for="subscribeEmail" name="subscribeEmail">
    <div id="emailHelp" class="form-text">Nous ne partagerons jamais votre email.</div>
  </div>
  <div class="mb-3">
    <label for="subscribePhone" class="form-label">Numéro de telephone : </label>
    <input type="text" class="form-control" id="subscribePhone" name="subscribePhone">
  </div>
  <div class="mb-3">
    <label for="subscribePassword1" class="form-label">Mot de passe : </label>
    <input type="password" class="form-control" name="mdp1">
  </div>
  <div class="mb-3">
    <label for="subscribePassword2" class="form-label">Confirmer votre mot de passe : </label>
    <input type="password" class="form-control" name="mdp2">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Se souvenir de moi</label>
  </div>

  <button type="submit" name="inscription" class="btn btn-primary">Souscrire</button>
</form>
  </div>

<a href="index.php">Se connecter</a>
</body>
</html>