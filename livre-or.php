<?php 
session_start();

$database_Host = 'localhost';
$database_User = 'root';
$database_Pass = '';
$database_Name = 'livreor';

$con = mysqli_connect($database_Host, $database_User, $database_Pass, $database_Name, 3307);
$request = $con->query('SELECT `login` , `date` , `commentaire` FROM utilisateurs INNER JOIN commentaires ON utilisateurs.id = commentaires.id_utilisateur');
$data = $request->fetch_All();

var_dump($data);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>livre d'or</title>
</head>
<body>
<?php include("header.php");?>
    <table>

    </table>
</body>
</html>