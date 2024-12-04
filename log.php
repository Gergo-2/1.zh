<?php
function getDb($hostname = "localhost", $username = "root", $password = "", $dbname = "adatbazis"): PDO
{
    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        echo 'Sikertelen kapcsolódás: ' . $e->getMessage();
        exit;
    }
}
$db = getDb();
if (!empty($_POST)) {
    $varos =addslashes( $_POST["varos"]) ;
    $datum = addslashes($_POST["datum"]);
    $homerseklet =addslashes( $_POST["homerseklet"]);
    if( $datum !="" && $homerseklet!="") {


        $statement = $db->prepare("set foreign_key_checks=0; insert into bejegyzes (varos_ID, datum,homerseklet) values 
(:ID, :Datum, :fok);set foreign_key_checks=1;");
        $statement->bindParam(":ID", $varos, PDO::PARAM_STR);
        $statement->bindParam(":Datum", $datum, PDO::PARAM_STR);
        $statement->bindParam(":fok", $homerseklet, PDO::PARAM_STR);
        $statement->execute();
        header("Location:index.php");
    } else {
        echo "$datum $homerseklet";

    }
} else {
    header("Location:index.php");
}
?>