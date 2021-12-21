<?php
session_start();
    // include "header.php";
    include "connexionPDO.php";

    // Connexion
    if (isset($_POST['login']))
    {
      $email = Securise($_POST['email']);
      $mdp = Securise($_POST['mdp']);
    } if (!empty($email) AND !empty($mdp))
    {
      $mdp = PasswordHash($mdp);
      $verifUser = $db->query('SELECT * FROM user WHERE email = "'.$email.'" AND mdp = "'.$mdp.'"');
      $data = $verifUser->fetchArray(SQLITE3_ASSOC);
      if ($data != false)
      {
        $_SESSION['login'] = $data['id'];
        header('Location:businessCard.php');
      } else {
        $return = "Les identifiants sont invalides !";
      }
    } else $return ="Un ou plusieurs champs est manquant ! ";

?>

<!DOCTYPE html>
<html lang="en">
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
      <p><?php if (isset($_POST['login']) AND isset($return)) echo $return; ?></p>
      
  <div class="mb-3">
    <label for="email" class="form-label">Adresse email : </label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
    <div id="emailHelp" class="form-text">Nous ne partagerons jamais votre email.</div>
  </div>
  <div class="mb-3">
    <label for="mdp" class="form-label">Mot de passe :</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="mdp">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1" >
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary" name="login">Se connecter</button>
</form>
</div>
<a href="inscription.php">Pas encore inscris ?</a>
</body>
</html>