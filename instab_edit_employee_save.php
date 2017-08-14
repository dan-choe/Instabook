<?
include ("./include.php");


if (isset($_POST[func])) {

  if (strcmp($_POST[func],'edit_save') == 0) {
    if($_POST[m_id] == ""){
      ?>
      <script>
      alert("Plese enter an ID for the employee.");
      history.back();
      </script>
      <?
      exit;
    }

    if($_POST[m_pass] == ""){
      ?>
      <script>
      alert("Plese enter password");
      history.back();
      </script>
      <?
      exit;
    }

    if($_POST[m_pass] != $_POST[m_pass2]){
      ?>
      <script>
      alert("Plese recheck the password");
      history.back();
      </script>
      <?
      exit;
    }

    $chk_sql = "SELECT * FROM Employee WHERE AccountNumber = $_POST[accNo]";
    $result = sql_query($chk_sql);
    $employee = mysqli_fetch_array($result);

    if($employee[EmployeeID] != $_POST[m_id]){
      $sql = "UPDATE Employee SET EmployeeID = '$_POST[m_id]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[FirstName] != $_POST[m_firstname]){
      $sql = "UPDATE Employee SET FirstName = '$_POST[m_firstname]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[LastName] != $_POST[m_lastname]){
      $sql = "UPDATE Employee SET LastName = '$_POST[m_lastname]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[SSN] != $_POST[m_ssn]){
      $sql = "UPDATE Employee SET SSN = '$_POST[m_ssn]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[Password] != $_POST[m_pass]){
      $sql = "UPDATE Employee SET Password = '$_POST[m_pass]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[Address] != $_POST[m_address]){
      $sql = "UPDATE Employee SET Address = '$_POST[m_address]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[City] != $_POST[m_city]){
      $sql = "UPDATE Employee SET City = '$_POST[m_city]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[State] != $_POST[m_state]){
      $sql = "UPDATE Employee SET State = '$_POST[m_State]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[ZipCode] != $_POST[m_zipcode]){
      $sql = "UPDATE Employee SET ZipCode = '$_POST[m_zipcode]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[Telephone] != $_POST[m_telephone]){
      $sql = "UPDATE Employee SET Telephone = '$_POST[m_telephone]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[Email] != $_POST[m_email]){
      $sql = "UPDATE Employee SET Email = '$_POST[m_email]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[HourlyRate] != $_POST[m_rate]){
      $sql = "UPDATE Employee SET HourlyRate = '$_POST[m_rate]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }
    if($employee[IsManager] != $_POST[is_manager]){
      $sql = "UPDATE Employee SET IsManager = '$_POST[is_manager]' WHERE AccountNumber = $employee[AccountNumber]";
      sql_query($sql);
    }

    ?>
    <script>
    alert("Completed Update!");
    location.replace("./manage_employees");
    </script>
    <?
  }
}
?>
