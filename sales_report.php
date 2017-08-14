<?php
include ("./include.php");

if(!$_SESSION[empl_id] || !$_SESSION[IsManager]){
  ?>
  <script>
  alert("Must be logged in as a manager!");
  history.back();
  </script>
  <?
}

if (isset($_POST[func])) {

  if (strcmp($_POST[func],'sales_report') == 0) {

    $monthName = "";

    switch ($_POST[month]) {
      case 1:
      $monthName = "January";
      break;
      case 2:
      $monthName = "February";
      break;
      case 3:
      $monthName = "March";
      break;
      case 4:
      $monthName = "April";
      break;
      case 5:
      $monthName = "May";
      break;
      case 6:
      $monthName = "June";
      break;
      case 7:
      $monthName = "July";
      break;
      case 8:
      $monthName = "August";
      break;
      case 9:
      $monthName = "September";
      break;
      case 10:
      $monthName = "October";
      break;
      case 11:
      $monthName = "November";
      break;
      case 12:
      $monthName = "December";
      break;
      default:
        $monthName = "December";
    }



    echo "<h2> $monthName Sales Report </h2>".
    "<table class ='niceTable'>".
    "<tr>".
    "<th>Company</th>".
    "<th>Item Name</th>".
    "<th>Units Purchased</th>".
    "<th>Units Price</th>".
    "<th>Total</th>".
    "</tr>";


    $query = "SELECT C.Name AS Company, A.ItemName, T.UnitsPurchased, A.UnitPrice, T.UnitsPurchased * A.UnitPrice AS Total FROM AdTransaction T, Advertisement A, Company C WHERE A.Id = T.Advertisement AND A.Company=C.Id AND T.DatePurchased LIKE '2016-$_POST[month]%'";
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {

      echo "<tr>" .
      "<td>$row[Company]</td>" .
      "<td>$row[ItemName]</td>" .
      "<td>$row[UnitsPurchased]</td>" .
      "<td>$row[UnitPrice]</td>" .
      "<td>$row[Total]</td>" .
      "</tr>";
    }

    ?>
  </table>
  <?

}
}

?>
