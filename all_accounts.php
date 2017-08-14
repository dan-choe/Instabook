<?php
include ("./include.php");
?>

<h2> Users </h2>

<?
$query = "SELECT UserId, Password FROM User";
$result = sql_query($query);

echo "<table class='niceTable' style='width:70%;'>";
echo "<tr><th>UserID</th><th>Password</th></tr>";
while ($row = mysqli_fetch_array($result)) {


	echo "<tr>" .
	"<td align='right'>$row[UserId]</td>" .
  "<td align='right'>$row[Password]</td>" .
	"</tr>";
}

echo "</table>";


?>

<h2> Employees </h2>

<?
$query = "SELECT EmployeeID, Password FROM Employee WHERE IsManager = 0";
$result = sql_query($query);

echo "<table class='niceTable' style='width:70%;'>";
echo "<tr><th>EmployeeID</th><th>Password</th></tr>";

while ($row = mysqli_fetch_array($result)) {


	echo "<tr>" .
	"<td align='right'>$row[EmployeeID]</td>" .
  "<td align='right'>$row[Password]</td>" .
	"</tr>";
}

echo "</table>";


?>

<h2> Managers </h2>

<?
$query = "SELECT EmployeeID, Password FROM Employee WHERE IsManager = 1";
$result = sql_query($query);

echo "<table class='niceTable' style='width:70%;'>";
echo "<tr><th>EmployeeID</th><th>Password</th></tr>";

while ($row = mysqli_fetch_array($result)) {


	echo "<tr>" .
	"<td align='right'>$row[EmployeeID]</td>" .
  "<td align='right'>$row[Password]</td>" .
	"</tr>";
}

echo "</table>";


?>
