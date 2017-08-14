<?php
include ("./include.php");
?>

<h2> All Transactions </h2>
  <table class ='niceTable' style='width:90%;'>
    <tr>
      <th>User</th>
      <th>Item</th>
      <th>Units Purchased</th>
      <th>Date Purchased</th>
    </tr>

    <?
    $query = "SELECT C.UserId, A.ItemName, T.UnitsPurchased, T.DatePurchased ".
    	"FROM AdTransaction T, User C, Advertisement A ".
    	"WHERE T.Customer=C.AccountNumber AND T.Advertisement=A.Id";
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {


      echo "<tr>" .
      "<td>$row[UserId]</td>" .
      "<td>$row[ItemName]</td>" .
      "<td>$row[UnitsPurchased]</td>" .
      "<td>$row[DatePurchased]</td>" .
      "</tr>";
    }

    ?>
  </table>
