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

  if (strcmp($_POST[func],'groups') == 0) {

    $accNo = $_POST[user];

    $i_name = sql_query("SELECT UserID From User WHERE AccountNumber=$accNo");
    $i_name = mysqli_fetch_array($i_name);
    $i_name = $i_name[UserID];


    echo "<h2> All Groups for $i_name </h2>".
      "<table class ='niceTable'>".
        "<tr>".
          "<th>Group Name</th>".
          "<th>Join Date</th>".
        "</tr>";


        $query = "SELECT GR.Name, GM.JoinDate FROM IBGroup GR, User U, GroupMembership GM WHERE U.AccountNumber = GM.User AND GR.Id = GM.IBGroup AND U.AccountNumber = $accNo";
        $result = sql_query($query);

        while ($row = mysqli_fetch_array($result)) {


          echo "<tr>" .
          "<td>$row[Name]</td>" .
          "<td>$row[JoinDate]</td>" .
          "</tr>";
        }

        ?>
      </table>
        <?
  }
}
  ?>
