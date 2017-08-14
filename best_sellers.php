<?php
include ("./include.php");
?>

<h2> Best Sellers </h2>

<?
$query = "SELECT "
  .  "A.ItemName AS IName, SUM(T.UnitsPurchased) AS Total "
."FROM "
  .  "AdTransaction T, "
  .  "Advertisement A "
."WHERE "
  .  "A.Id = T.Advertisement "
."GROUP BY A.ItemName "
."ORDER BY Total DESC "
."LIMIT 5;";
$result = sql_query($query);

echo "<table class='niceTable'>";
echo "<tr><td align='center' style='font-weight:bold;'>Item Name</td><td align='center' style='font-weight:bold;'>Units Sold</td></tr>";

while ($row = mysqli_fetch_array($result)) {


	echo "<tr>" .
	"<td align='right'>$row[IName]</td>" .
  "<td align='right'>$row[Total]</td>" .
	"</tr>";
}

echo "</table>";


?>
