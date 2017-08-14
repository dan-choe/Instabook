<?php
include ("./include.php");
?>

<h2>All Advertisements</h2>

<table class ='niceTable' style='width:90%;'>
  <tr>
    <th>Item Name</th>
    <th>Company</th>
    <th>Managed By</th>
    <th>Preference Category</th>
    <th>Description</th>
    <th>Price</th>
    <th>Units Available</th>
  </tr>

  <?
  $query = "SELECT * FROM Advertisement";
  $result = sql_query($query);

  while ($row = mysqli_fetch_array($result)) {

    $company = sql_query("SELECT Name FROM Company WHERE Id=$row[Company]");
    $company = mysqli_fetch_array($company);
    $company = $company[Name];

    $pref = sql_query("SELECT Name FROM Preference WHERE Id=$row[PreferenceType]");
    $pref = mysqli_fetch_array($pref);
    $pref = $pref[Name];

    $empl = sql_query("SELECT EmployeeID FROM Employee WHERE AccountNumber=$row[ManagingEmployee]");
    $empl = mysqli_fetch_array($empl);
    $empl = $empl[EmployeeID];

    echo "<tr>" .
    "<td>$row[ItemName]</td>" .
    "<td>$company</td>" .
    "<td>$empl</td>" .
    "<td>$pref</td>" .
    "<td>$row[Content]</td>" .
    "<td>$row[UnitPrice]</td>" .
    "<td>$row[NumAvailable]</td>" .
    "</tr>";
  }

  ?>
</table>
