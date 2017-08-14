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
?>

<h2>Obtain a sales report for a particular month</h2>
Month: <form action="sales_report.php" method="post">
  <input type="hidden" name="func" value="sales_report">

  <select name="month">
    <option value="01">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">May</option>
    <option value="06">June</option>
    <option value="07">July</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
</select>

  <input type="submit" value="Go">
</form>



<h2>View All Transactions Involving</h2>

Item: <form action="show_transactions.php" method="post">
  <input type="hidden" name="func" value="all_item_transactions">


  <select name="aId">

    <?
    $query = "SELECT * FROM Advertisement";
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {

      $company = sql_query("SELECT Name FROM Company WHERE Id=$row[Company]");
      $company = mysqli_fetch_array($company);
      $company = $company[Name];

      echo "<option value='$row[Id]'>$row[ItemName], $company</option>";

    }
    ?>

  </select></td>

  <input type="submit" value="Go">
</form>

User: <form action="show_transactions.php" method="post">
  <input type="hidden" name="func" value="all_user_transactions">


  <select name="uId">

    <?
    $query = "SELECT * FROM User";
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {

      echo "<option value='$row[AccountNumber]'>$row[UserID]</option>";

    }
    ?>

  </select></td>

  <input type="submit" value="Go">
</form>











<h2>Calculate Revenue Generated From</h2>

Item: <form action="show_transactions.php" method="post">
  <input type="hidden" name="func" value="all_item_revenue">


  <select name="aId">

    <?
    $query = "SELECT * FROM Advertisement";
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {

      $company = sql_query("SELECT Name FROM Company WHERE Id=$row[Company]");
      $company = mysqli_fetch_array($company);
      $company = $company[Name];

      echo "<option value='$row[Id]'>$row[ItemName], $company</option>";

    }
    ?>

  </select></td>

  <input type="submit" value="Go">
</form>

User: <form action="show_transactions.php" method="post">
  <input type="hidden" name="func" value="all_user_revenue">


  <select name="uId">

    <?
    $query = "SELECT * FROM User";
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {

      echo "<option value='$row[AccountNumber]'>$row[UserID]</option>";

    }
    ?>

  </select></td>

  <input type="submit" value="Go">
</form>
Item Type: <form action="show_transactions.php" method="post">
  <input type="hidden" name="func" value="all_pref_revenue">


  <select name="pId">

    <?
    $query = "SELECT * FROM Preference";
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {

      echo "<option value='$row[Id]'>$row[Name]</option>";

    }
    ?>

  </select></td>

  <input type="submit" value="Go">
</form>






<h2>Customer that Generated Most Revenue</h2>
<?
echo "<table class ='niceTable' style = 'width:60%;'>".
"<tr>".
"<th>User</th>".
"<th>Total Revenue</th>".
"</tr>";

$query = "SELECT t.UID As UserID, SUM(t.Sale) AS Total FROM (SELECT T.UnitsPurchased * A.UnitPrice AS Sale, U.UserID as UID FROM AdTransaction T, Advertisement A, User U WHERE T.Advertisement=A.Id AND T.Customer=U.AccountNumber) t GROUP BY t.UID ORDER BY total DESC LIMIT 1";
$result = sql_query($query);

while ($row = mysqli_fetch_array($result)) {

  echo "<tr>" .
  "<td>$row[UserID]</td>" .
  "<td>$ $row[Total]</td>" .
  "</tr>";
}

echo "</table>";
?>



<h2>Employee that Generated Most Revenue</h2>
<?
echo "<table class ='niceTable' style = 'width:60%;'>".
"<tr>".
"<th>Employee</th>".
"<th>Total Revenue</th>".
"</tr>";

$query = "SELECT t.EID, SUM(t.Sale) AS total FROM (SELECT T.UnitsPurchased * A.UnitPrice AS Sale, E.EmployeeID AS EId FROM AdTransaction T, Advertisement A, Employee E WHERE T.Advertisement=A.Id AND A.ManagingEmployee=E.AccountNumber) t GROUP BY t.EID ORDER BY total DESC LIMIT 1";
$result = sql_query($query);

while ($row = mysqli_fetch_array($result)) {

  echo "<tr>" .
  "<td>$row[EID]</td>" .
  "<td>$ $row[total]</td>" .
  "</tr>";
}

echo "</table>";
?>



<h2> Most Active Items </h2>

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

echo "<table class='niceTable' style = 'width:60%;'>";
echo "<tr><th>Item Name</th><th>Units Sold</th></tr>";

while ($row = mysqli_fetch_array($result)) {


	echo "<tr>" .
	"<td>$row[IName]</td>" .
  "<td>$row[Total]</td>" .
	"</tr>";
}

echo "</table>";


?>





<h2>Produce a list of all customers who have purchased a particular item</h2>
Item: <form action="show_transactions.php" method="post">
  <input type="hidden" name="func" value="all_users_bought_item">


  <select name="aId">

    <?
    $query = "SELECT * FROM Advertisement";
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {

      $company = sql_query("SELECT Name FROM Company WHERE Id=$row[Company]");
      $company = mysqli_fetch_array($company);
      $company = $company[Name];

      echo "<option value='$row[Id]'>$row[ItemName], $company</option>";

    }
    ?>

  </select></td>

  <input type="submit" value="Go">
</form>





<h2>Produce a list of all items for a given company</h2>
Company: <form action="show_transactions.php" method="post">
  <input type="hidden" name="func" value="company_items">


  <select name="cId">

    <?
    $result = sql_query("SELECT * FROM Company");
    while ($row = mysqli_fetch_array($result)) {


      echo "<option value='$row[Id]'>$row[Name]</option>";

    }
    ?>

  </select></td>

  <input type="submit" value="Go">
</form>
