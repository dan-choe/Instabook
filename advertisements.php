<?php
include ("./include.php");

if(! $_SESSION[empl_id]){
  ?>
  <script>
  alert("Must be logged in as an employee!");
  history.back();
  </script>
  <?
}

if (isset($_POST[func])) {

  if (strcmp($_POST[func],'create') == 0) {
    $i_name = mysqli_real_escape_string($connect, $_POST[i_name]);
    $i_pref = $_POST[i_pref];
    $i_price = $_POST[i_price];
    $i_company = $_POST[i_company];
    $i_desc = $_POST[i_desc];
    $i_num_available = $_POST[i_num_available];
    $i_managing_empl = $_SESSION[empl_idx];
    $i_desc = mysqli_real_escape_string($connect, $_POST[i_desc]);

    sql_query("INSERT INTO Advertisement (ManagingEmployee, PreferenceType, Company, ItemName, Content, NumAvailable, UnitPrice) VALUES ('$i_managing_empl', '$i_pref', '$i_company', '$i_name', '$i_desc', '$i_num_available', '$i_price')");

  }else if (strcmp($_POST[func],'delete') == 0) {
    foreach ($_POST[adv] as $advID) {
      sql_query("DELETE FROM Advertisement WHERE Id=$advID LIMIT 1");
    }
  }
}



?>

<!-- New Advertisement.
-->
<h2>Create an Advertisement</h2>
<form action="advertisements.php" method="post">
  <table>
    <tr>

      <td>Item Name:</td>
      <td><input type='text' name='i_name' required>
      </td>

      <td>Preference Category:</td>
      <td> <select name="i_pref">
        <?
        $prefs = sql_query("SELECT Id, Name FROM Preference");
        while ($p = mysqli_fetch_array($prefs)) {
          echo "<option value='$p[Id]'>$p[Name]</option>";
        }
        ?>
      </select></td>

    </tr>
    <tr>

      <td>Price (USD):</td>
      <td><input type='number' min="0.01" step="any" name='i_price' required>
      </td>

      <td>Company:</td>
      <td> <select name="i_company" required>
        <?
        $companies = sql_query("SELECT Id, Name FROM Company");
        while ($c = mysqli_fetch_array($companies)) {
          echo "<option value='$c[Id]'>$c[Name]</option>";
        }
        ?>
      </select></td>

    </tr>
    <tr>

      <td colspan=4>
        Description:<br>
        <textarea rows='4' cols='80' name='i_desc' required></textarea>
      </td>

    </tr>
    <tr>

      <td>Number Available:</td>
      <td><input type='number' step = '1' name='i_num_available' required>
      </td>

    </tr>

  </table>
  <input type="hidden" name="func" value="create">
  <input type="submit" value="Create Advertisement">
</form>


<h2>Manage Advertisements</h2>

<form action="advertisements.php" method="post">
  <input type="hidden" name="func" value="delete">
  <table class ='niceTable'>
    <tr>
      <th>Select</th>
      <th>Item Name</th>
      <th>Company</th>
      <th>Preference Category</th>
      <th>Description</th>
      <th>Price</th>
      <th>Units Available</th>
    </tr>

    <?
    $query = "SELECT * FROM Advertisement WHERE ManagingEmployee=" . $_SESSION[empl_idx];
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {

      $company = sql_query("SELECT Name FROM Company WHERE Id=$row[Company]");
      $company = mysqli_fetch_array($company);
      $company = $company[Name];

      $pref = sql_query("SELECT Name FROM Preference WHERE Id=$row[PreferenceType]");
      $pref = mysqli_fetch_array($pref);
      $pref = $pref[Name];

      echo "<tr>" .
      "<td><input type='checkbox' name='adv[]' value='$row[Id]'></td>" .
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
  <input type="submit" value="Delete Selected Advertisement(s)">
</form>

<h2>Create Mailing Lists</h2>

<form action="mailing_list.php" method="post">
  <input type="hidden" name="func" value="mail">


  <select name="aId">

    <?
    $query = "SELECT * FROM Advertisement WHERE ManagingEmployee=" . $_SESSION[empl_idx];
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {

      $company = sql_query("SELECT Name FROM Company WHERE Id=$row[Company]");
      $company = mysqli_fetch_array($company);
      $company = $company[Name];

      echo "<option value='$row[Id]'>$row[ItemName], $company</option>";

    }
    ?>

  </select></td>

  <input type="submit" value="Create Mailing List for Item">
</form>

<h2>Retrieve a customer's current groups</h2>

<form action="customer_groups.php" method="post">
  <input type="hidden" name="func" value="groups">
  <select name="user">

    <?
    $query = "SELECT AccountNumber, UserID FROM User";
    $result = sql_query($query);

    while ($row = mysqli_fetch_array($result)) {
      echo "<option value='$row[AccountNumber]'>$row[UserID]</option>";
    }
    ?>

  </select></td>

  <input type="submit" value="Go">
</form>
