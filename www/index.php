<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<?php include "../inc/dbinfo.inc"; ?>
<html>
<head>
<title>Database test page</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1 style="text-align:center">Database test page (users)</h1>

<hr class="solid">

<p style="text-align:center">Showing available meals:</p>


<!-- save a meal to the database on clicking add meal -->
<form action='' method='post'>
  <table border="0">
    <tr>
      <td>Meal Name</td>
      <td>Description</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="meal_name" maxlength="64" size="30" />
      </td>
      <td>
        <input type="text" name="meal_description" maxlength="256" size="60" />
      </td>
      <td>
        <input type="submit" value="Add Meal" name="submit" />
      </td>
    </tr>
  </table>
</form>
<?php
if(isset($_POST["submit"])){

    /* connect to the RDS server */
    $db_host = 'assignment-2-rds.cdryxhulhnxp.us-east-1.rds.amazonaws.com';
    $db_name = 'assignment2Db';
    $db_user = 'admin';
    $db_passwd = 'khrysoliver';

    $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

    $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);

    $m_name = $_POST["meal_name"];
    $m_desc = $_POST["meal_description"];

    /* post meal into RDS database */
    $q_m = $pdo->query("INSERT INTO meals(meal_name, meal_description) VALUES ('$m_name', '$m_desc')");

}
?>

<!-- table that displays all meals stored in the database and allows users to claim/delete
an individual meal. please note that users need to refresh the page to see the item disappear
table alsoextracts meal info, converts it into a json object and saves the json object to the s3 bucket -->
<form action='' method='post'>
<table class="center" border="1">
<tr><th>Meal Name</th><th>Meal Description</th></tr>

<?php

$db_host = 'assignment-2-rds.cdryxhulhnxp.us-east-1.rds.amazonaws.com';
$db_name = 'assignment2Db';
$db_user = 'admin';
$db_passwd = 'khrysoliver';

$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

$pdo = new PDO($pdo_dsn, $db_user, $db_passwd);

# meals query
$q_m = $pdo->query("SELECT * FROM meals");



while($row = $q_m->fetch()) {

  echo "<tr>";
  echo "<td>".$row["meal_name"]."</td>";
  echo "<td>".$row["meal_description"]."</td>";
  echo "<td><button type='submit' name='deleteItem' id='deleteItem' value='".$row["meal_name"]."'/> Delete </buttont></td>";
  echo "</tr>";

}

if(isset($_POST["deleteItem"])){

    $delete = $_POST['deleteItem'];

    $savedArray = array();

    $savedVar = $pdo->query("SELECT * FROM meals WHERE meal_name = '$delete'");
    /* extract the row and convert it to a Json object */
    $row = $savedVar->fetch();

    $savedArray[] = $row["meal_name"];

    $mealname = $row["meal_name"];

    $savedArray[] = $row["meal_description"];

    $archivedVar = fopen($row["meal_name"].'_archives.json', 'w');

    /* encode and save the json object */
    fwrite($archivedVar, json_encode($savedArray));

    /* move the Json object to the s3 bucket */
    shell_exec ('aws s3 mv ' . $mealname . '_archives.json s3://assignment2-archive-bucket');

    fclose($archivedVar);

    $q_d = $pdo->query("DELETE FROM meals WHERE meal_name = '$delete'");
}

?>
</table>
</form>
</body>
</html>
