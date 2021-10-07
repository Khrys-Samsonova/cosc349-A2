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


<!-- save a meal to the database -->
<form>
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
        <input type="submit" value="Add Meal" />
      </td>
    </tr>
  </table>
</form>

<table class="center" border="1">
<tr><th>Meal Name</th><th>Meal Description</th></tr>

<?php

$db_host = 'assignment-2-rds.cdryxhulhnxp.us-east-1.rds.amazonaws.com';
$db_name = 'assignment2Db';
$db_user = 'admin';
$db_passwd = 'khrysoliver';

$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

$pdo = new PDO($pdo_dsn, $db_user, $db_passwd);

#meals query
$q_m = $pdo->query("SELECT * FROM meals");


while($row = $q_m->fetch()) {
  echo "<tr><td>".$row["meal_name"]."</td><td>".$row["meal_description"]."</td></tr>";
}
?>
</table>
</body>
</html>

