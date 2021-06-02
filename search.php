<?php

if (!isset($_GET["s"])) {
    // die("Paramètre requis !!");
    header("Location: ListeArticlesBlog.php");
}

require("dbConnect.php");

// requête préparée
try {
    $requete = 'SELECT wp_posts.id as id
                     , post_title
                     , post_content
                     , post_date
                     , wp_users.display_name
                  from wp_posts
                  INNER JOIN wp_users ON post_author = wp_users.id
                   AND post_type = "post"
                   AND post_status = "publish"
                   AND (post_title LIKE :s
                    OR post_content LIKE :s)
                   ORDER BY post_date DESC';
    // die($requete);

    // $req = $dbh->query($requete);
    // $req->setFetchMode(PDO::FETCH_ASSOC);
    // $tab = $req->fetchAll();
    // $req->closeCursor();

    $req = $dbh->prepare($requete);
    $req->bindValue(':s', '%' . $_GET["s"] . '%', PDO::PARAM_STR);
    $req->execute();

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

        <h1>Resultat de la recherche : <?= $_GET["s"] ?> </h1>

        <?php foreach ($tab as $row) { ?>
            <h2><a href="Article.php?id=<?= $row["id"] ?>"> <?= $row["post_title"] ?></a></h2>
            <p><?= $row["post_content"] ?></p>
            <p>Ecrit par : <?= $row["display_name"] ?> - Le : <?= $row["post_date"] ?></p>
        <?php } ?>

    </body>

    </html>

<?php

    $dbh = null;
    // echo "<br>" . "Connection Terminée";
} catch (PDOException $e) {
    print "Erreur sur la requete : " . $e->getMessage() . "<br/>";
    die();
}
