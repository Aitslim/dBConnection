<?php

if (!isset($_GET["id"])) {
    // die("Paramètre requis !!");
    header("Location: ListeArticlesBlog.php");
}

require("dbConnect.php");

try {
    $requete = "SELECT post_title
                     , post_content
                     , post_date
                     , wp_users.display_name
                  from wp_posts
                     , wp_users
                 where post_author = wp_users.ID
                   and wp_posts.ID = :s";

    // die($requete);
    $req = $dbh->prepare($requete);
    $req->bindValue(':s', $_GET["id"], PDO::PARAM_STR);
    $req->execute();

    $req->setFetchMode(PDO::FETCH_ASSOC);
    $row = $req->fetch();
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

        <h2><?= $row["post_title"] ?></h2>
        <p><?= $row["post_content"] ?></p>
        <p>Ecrit par : <?= $row["display_name"] ?> - Le : <?= $row["post_date"] ?></p>

    </body>

    </html>

<?php

    $dbh = null;
    // "Fin Connection";
} catch (PDOException $e) {
    print "Erreur sur la requete : " . $e->getMessage() . "<br/>";
    die();
}
