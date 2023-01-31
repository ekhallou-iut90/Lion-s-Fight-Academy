<?php
if(isset($_POST["submit"])){
  $email = $_POST['user'];
  $pass = $_POST['password'];
  $db = new PDO('mysql:host=localhost;dbname=loginsystem', 'root', '');

  $sql = "SELECT * FROM user ";//requete pour verifier qui tout les utilisateurs
  $result = $db->prepare($sql);
  $result->execute();

  $sql_user = "SELECT * FROM user WHERE email='$email' "; //requete pour verifier qui juste l'utilisateur
  $result_user = $db->prepare($sql_user);
  $result_user->execute();

  if($result->rowCount() > 0){
    $data = $result_user->fetchAll();
    if(password_verify($pass, $data[0]["password"])){ //verifie si le mot de passe est correct
      echo "connexion effectuée";
    }

  }else{ //si un aucun utilisateur est crée alors on fait une insertion
    $pass = password_hash($pass, PASSWORD_DEFAULT); //cryptage
    $sql = "INSERT INTO user (email,password) VALUES ('$email','$pass')";
    $req = $db->prepare($sql);
    $req->execute();
    echo "enregistrement effectuée";
  }
}



?>
