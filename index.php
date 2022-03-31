<?php

require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Friends</title>
    </head>
    <body>
        <ul>
            <?php foreach ($friends as $friend) { ?>
            <li>
                <p><?= $friend["firstname"] . " " . $friend["lastname"]; } ?>
                </p>
            </li>
        </ul>

        <form action="" method="post">
          <div>
            <label for="firstname">Firstname :</label>
            <input type="text" id="firstname" name="firstname">
          </div>
          <div>
            <label for="lastname">Lastname :</label>
            <input type="text" id="lastname" name="lastname">
          </div>
          <button type="submit">Submit</button>
        </form>
    </body>
</html>

<?php



if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  if (strlen($firstname) > 45 || strlen($lastname) > 45) {
    echo "moins long le nom stp";
  } else {
    if (!empty($firstname) && !empty($lastname)){
      $statement = $pdo->prepare("INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)");
      $statement->bindValue(':firstname', $firstname, PDO::PARAM_STR);
      $statement->bindValue(':lastname', $lastname, PDO::PARAM_STR);
      $statement->execute();
      header('Location: /index.php');
    } else {
      echo "Tous les champs sont requis";
    }
  }
}