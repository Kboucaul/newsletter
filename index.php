<?php
function process()
{
    //Connexion bdd
    $connect = mysqli_connect("127.0.0.1", "root", "", "newsletter");
    if(!$connect)
        exit();

    //recuperer liste des noms, emails
    $requete = "SELECT * FROM client";
    $result = mysqli_query($connect, $requete);
    if (!$result)
    {
        exit();
    }
    //Tableaux stockant la liste des noms et emails (au cas ou)
    $noms = [];
    $emails = [];
    while($ligne = mysqli_fetch_assoc($result))
    {
        //On affiche les resultats de notre requete
        echo "Nom : " . $ligne['nom'] . ", ";
        echo "Email : " . $ligne['email'] . ", ";
        echo "<br/>";

        //On stock nos valeurs dans des tableaux
        array_push($noms, $ligne['nom']);
        array_push($emails, $ligne['email']);
        
        //Message
        $message = "Bonjour Mr/Mme " . $ligne['nom'] . "<br/>";
        $message = "Email : " . $ligne['email'] . "<br/>";
        $message = $message.'Le message de la newsletter est : ';
        $message = $message.'<strong>A bientôt !<br/></strong>';

        //header mail
        $from = "From: Jean Dupont <newsletter@jog.fr>\n";
        $from = $from."Mime-Versions: 1.0\nContent-Type: text\html;charset=UTF-8\n";
        $to   = "To : " . $ligne['email'] . "<br/>";
        
        //Envoie du mail
        //mail($ligne['email'], 'Newsletter', $message, $from);

        //Mise a jour de la date d'envoie
        $requeteMaj = "Update client set Date_Envoie=Now() WHERE id=" . $ligne['id'];
        $resultMaj  = mysqli_query($connect, $requeteMaj);
        echo "Header du mail : <br/>" . $from . "<br/>" . $to;
        echo "Contenu du mail : <br/>" . $message ."<br/><br/>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter</title>
    <!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center">Newsletter</h1>
    <?php
        process();
    ?>
    <!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>