<?php

require("dbConnect.php");

try {
    $requete = "SELECT post_title
                     , post_content
                     , post_date
                     , wp_users.display_name
                  from wp_posts, wp_users
                 where post_author = wp_users.ID
                   and wp_posts.ID = " . $_GET["id"];

    $req = $dbh->query($requete);
    $req->setFetchMode(PDO::FETCH_ASSOC);

    $tab = $req->fetchAll();
    $req->closeCursor();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Le titre</title>
    </head>

    <body>

        <h1>Affichage Article</h1>

        <h2><?= $tab[0]["post_title"] ?></h2>
        <p><?= $tab[0]["post_content"] ?></p>
        <p>Ecrit par : <?= $tab[0]["display_name"] ?> - Le : <?= $tab[0]["post_date"] ?></p>

    </body>

    </html>

<?php

    $dbh = null;
    // echo "<br>" . "Connection Terminée";
} catch (PDOException $e) {
    print "Erreur sur la requete : " . $e->getMessage() . "<br/>";
    die();
}
