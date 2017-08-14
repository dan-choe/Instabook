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

<h2> Employees </h2>

<form action="edit_employee.php" method="post">
<input type="hidden" name="func" value="edit">
<?
$query = "SELECT * FROM Employee";
$result = sql_query($query);

echo "<table class='niceTable' style='width:100%;'>";
echo "<tr><th>Edit</th><th>EmployeeID</th><th>First Name</th><th>Password</th><th>Address</th><th>Email</th><th>Hourly Rate</th><th>Is A Site Manager</th></tr>";

while ($row = mysqli_fetch_array($result)) {
	echo "<tr>" .
  "<td><input type='radio' name='EmployeeToEdit' value='$row[AccountNumber]' checked/></td>" .
	"<td>$row[EmployeeID]</td>" .
  "<td>$row[FirstName]</td>" .
  "<td>$row[Password]</td>" .
  "<td>$row[Address]</td>" .
  "<td>$row[Email]</td>" .
  "<td>$row[HourlyRate]</td>" ;

  if($row[IsManager])
  {
    echo "<td>Yes</td>" ;
  }
  else {
    echo "<td>No</td>" ;
  }

	echo "</tr>";
}
?>

</table>
<input type="submit" value="Edit Selected Employee">
</form>
