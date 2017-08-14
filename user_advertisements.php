<?php
include ("./include.php");

if(! $_SESSION[user_id]){
  ?>
  <script>
  alert("Must be logged in as a user!");
  history.back();
  </script>
  <?
}

if (isset($_POST[func])) {

  if (strcmp($_POST[func],'purchase') == 0) {
    $adID = $_POST[advID];
    $amount = $_POST[amount];
    $customer = $_SESSION[user_idx];

    $result = sql_query("SELECT NumAvailable FROM Advertisement WHERE Id = $adID");
    $num_remaining = mysqli_fetch_array($result);
    $num_remaining = $num_remaining[NumAvailable];

    if($amount == 0)
    {
      ?>
      <script>
      alert("Enter a non-zero value in amount to purchase field.");
      </script>
      <?
    }
    else if($num_remaining < $amount)
    {
      ?>
      <script>
      alert("Not enough units in stock to make purchase.");
      </script>
      <?
    }
    else{
      sql_query("UPDATE Advertisement SET NumAvailable = NumAvailable - $amount WHERE id = $adID");
      sql_query("INSERT INTO AdTransaction(Customer, Advertisement, UnitsPurchased) VALUES('$customer','$adID','$amount')");
      ?>
      <script>
      alert("Transaction Success!");
      </script>
      <?
    }

  }
}

?>




<h2>Personalized item suggestion list</h2>
<?

$query = "SELECT DISTINCT ".
    "P.Name as Pref ".
"FROM ".
    "UserPreferences UP, ".
    "Preference P ".
"WHERE ".
        "UP.User = $_SESSION[user_idx] ".
        "AND P.Id = UP.Preference";

$prefs = array();
$a = sql_query($query);
while ($c = mysqli_fetch_array($a)) {
  array_push($prefs, $c[Pref]);
}

$out = implode(", ", $prefs);
echo "Based on your personal preferences of " . $out . ": <br/>";

?>

<table class ='niceTable'>
  <tr>
    <th>Item Name</th>
    <th>Company</th>
    <th>Preference Category</th>
    <th>Description</th>
    <th>Price</th>
    <th>Units Available</th>
  </tr>

  <?
  $query = "SELECT DISTINCT ".
      "A.ItemName, A.Company, A.Content, A.NumAvailable, A.UnitPrice, A.PreferenceType ".
  "FROM ".
      "Advertisement A, ".
      "UserPreferences UP, ".
      "Preference P ".
  "WHERE ".
      "A.PreferenceType = UP.Preference ".
          "AND UP.User = $_SESSION[user_idx] ".
          "AND P.Id = UP.Preference ";
  $result = sql_query($query);
  while ($row = mysqli_fetch_array($result)) {

    $company = sql_query("SELECT Name FROM Company WHERE Id=$row[Company]");
    $company = mysqli_fetch_array($company);
    $company = $company[Name];

    $pref = sql_query("SELECT Name FROM Preference WHERE Id=$row[PreferenceType]");
    $pref = mysqli_fetch_array($pref);
    $pref = $pref[Name];

    echo "<tr>" .
    "<td>$row[ItemName]</td>" .
    "<td>$company</td>" .
    "<td>$pref</td>" .
    "<td>$row[Content]</td>" .
    "<td>$row[UnitPrice]</td>" .
    "<td>$row[NumAvailable]</td>" .
    "</tr>";
  }

  ?>
</table>






<h2>Suggestion List based on past transactions</h2>
<table class ='niceTable'>
  <tr>
    <th>Item Name</th>
    <th>Company</th>
    <th>Preference Category</th>
    <th>Description</th>
    <th>Price</th>
    <th>Units Available</th>
  </tr>

  <?
  $query = "SELECT DISTINCT " .
      "A2.ItemName, A2.Company, A2.Content, A2.NumAvailable, A2.UnitPrice, A2.PreferenceType ".
  "FROM ".
      "User U, ".
      "Advertisement A2, ".
      "AdTransaction AdT ".
  "WHERE ".
      "U.AccountNumber = $_SESSION[user_idx] ".
          "AND U.AccountNumber = AdT.Customer ".
          "AND AdT.Advertisement = A2.Id ";
  $result = sql_query($query);
  while ($row = mysqli_fetch_array($result)) {


    $company = sql_query("SELECT Name FROM Company WHERE Id=$row[Company]");
    $company = mysqli_fetch_array($company);
    $company = $company[Name];

    $pref = sql_query("SELECT Name FROM Preference WHERE Id=$row[PreferenceType]");
    $pref = mysqli_fetch_array($pref);
    $pref = $pref[Name];

    echo "<tr>" .
    "<td>$row[ItemName]</td>" .
    "<td>$company</td>" .
    "<td>$pref</td>" .
    "<td>$row[Content]</td>" .
    "<td>$row[UnitPrice]</td>" .
    "<td>$row[NumAvailable]</td>" .
    "</tr>";
  }

  ?>
</table>







<h2>Record a Transaction</h2>
<form action="user_advertisements.php" method="post">
  <table>
    <tr>

      <td>Item:</td>
      <td> <select name="advID">
        <?
        $a = sql_query("SELECT Id, ItemName FROM Advertisement");
        while ($c = mysqli_fetch_array($a)) {
          echo "<option value='$c[Id]'>$c[ItemName]</option>";
        }
        ?>
      </select></td>

    </tr>
    <tr>
      <td>Amount to Purchase:</td>
      <td><input type='number' step = '1' name='amount' required>
      </td>
    </tr>

  </table>
  <input type="hidden" name="func" value="purchase">
  <input type="submit" value="Purchase Item(s)">
</form>





<h2>Your past Transaction history</h2>
<table class ='niceTable'>
  <tr>
    <th>Item Name</th>
    <th>Price</th>
    <th>Units Purchased</th>
    <th>Date Purchased</th>
  </tr>

  <?
  $query = "SELECT ".
    "A.ItemName, A.UnitPrice, AdT.UnitsPurchased, AdT.DatePurchased ".
"FROM ".
    "User U, ".
    "Advertisement A, ".
    "AdTransaction AdT ".
"WHERE ".
    "U.AccountNumber = AdT.Customer ".
        "AND AdT.Advertisement = A.Id ".
        "AND U.AccountNumber = $_SESSION[user_idx]";

  $result = sql_query($query);
  while ($row = mysqli_fetch_array($result)) {

    echo "<tr>" .
    "<td>$row[ItemName]</td>" .
    "<td>$row[UnitPrice]</td>" .
    "<td>$row[UnitsPurchased]</td>" .
    "<td>$row[DatePurchased]</td>" .
    "</tr>";
  }

  ?>
</table>
