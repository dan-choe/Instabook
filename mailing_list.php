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

  if (strcmp($_POST[func],'mail') == 0) {

    $adv = $_POST[aId];

    $i_name = sql_query("SELECT ItemName From Advertisement WHERE Id=$adv");
    $i_name = mysqli_fetch_array($i_name);
    $i_name = $i_name[ItemName];

    $query = "SELECT DISTINCT ".
    "U.FirstName, U.LastName, U.Email ".
    "FROM ".
    "User U, ".
    "Advertisement A, ".
    "AdTransaction AdT ".
    "WHERE ".
    "U.AccountNumber = AdT.Customer ".
    "AND AdT.Advertisement = $adv ";

    $mail_list = sql_query($query);
    $out = "";
    while ($x = mysqli_fetch_array($mail_list)) {
      $out .= "<tr><td>$x[FirstName] $x[LastName]</td><td>$x[Email]</td></tr>";
    }

    // echo '<script type="text/javascript">alert("' . $out . '")</script>';

    echo "<h3>Mailing list for $i_name Advertisement</h3>";
    ?>
    <table class ='niceTable'>
      <tr>
        <th>Name</th>
        <th>Email</th>
      </tr>
    <?
    echo $out;
    echo "</table";

  }
}


?>
