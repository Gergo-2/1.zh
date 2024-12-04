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


?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <link rel="stylesheet" href="./style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>homerseklet</title>
</head>

<body>
    <h1>Időjárás</h1>
    <p>Gyulai Gergely KVYLJN</p>
    <div>
        <table>
            <tr>
                <th>Név</th>
                <th>lakosság</th>
                <th>Átlaghőmérséklet</th>
            </tr>
            <?php $sql = "SELECT round(avg(bejegyzes.homerseklet),0) as atlag, varos.neve, varos.Lakossag, varos.ID FROM adatbazis.varos, bejegyzes where varos.ID=bejegyzes.varos_ID and varos.Lakossag > 1 group by varos.neve order by Lakossag desc;


";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            for ($i = 0; $i < count($result); $i++) {

                echo "<tr>
                <td><strong>" . $result[$i]["neve"] . "</strong></td> <!--ferde tag <em></em>-->
                <td>" . $result[$i]["Lakossag"] . " millió fő</td>
                <td>";
                if ($result[$i] != false) {
                    echo $result[$i]["atlag"];
                } else {
                    echo "0.00";
                }
                ;
                echo " °C</td>
            </tr>";
                $sql1 = "SELECT * FROM adatbazis.bejegyzes where varos_ID = " . $result[$i]["ID"] . ";";
                $result1 = $db->query($sql1);
                echo "<tr>
                <td colspan='3'>
                ";
                if ($result1 != false) {
                    echo "
                    <ul>";
                    foreach ($result1 as $row1) {

                        echo
                            "<li>" . $row1["datum"] . ": " . $row1["homerseklet"] . " °C</li>";

                    }
                    echo "</ul>";
                } else {
                    echo "
                        <p>nincs adat</p>";
                }
                ;
                echo "
                   
                </td>
            </tr>";
            } ?>


        </table>

        <form id="java" method="POST" action="log.php">
            <h2>Hőmérséklet naplózása</h2>
            <p><label>varos: <select name="varos" id="">
                        <?php
                        $sql3 = "SELECT varos.neve, varos.ID FROM adatbazis.varos ;";
                        $result3 = $db->query($sql3);
                        foreach ($result3 as $row3) {
                            echo ' <option value="'.$row3["ID"].'"> 
' . $row3["neve"] . '
</option>';
                        }
                        ?>
                    </select></label></p>
            <p> <label>Dátum: <input type="date" name="datum" id=""></label></p>
            <p><label>Hőmérséklet: <input type="text" name="homerseklet" id="hom" value=""></label></p>
            <input type="submit" value="küldés">
        </form>
    </div>
    <script src="java.js">

    </script>
</body>

</html>