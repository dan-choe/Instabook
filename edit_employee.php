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

  if (strcmp($_POST[func],'edit') == 0) {

    $query = "SELECT * FROM Employee WHERE AccountNumber = $_POST[EmployeeToEdit]";
    $employee = sql_query($query);
    $employee = mysqli_fetch_array($employee);


    ?>

    <table style="width:100%; height:50px;border:5px #CCCCCC solid;">
      <tr>
        <td align="center" valign="middle" style="font-size:15px;font-weight:bold;">Edit Employee <? echo $employee[EmployeeID]; ?></td>
      </tr>
    </table>
    <br/>
    <form name="emplEditForm" method="post" action="./instab_edit_employee_save.php" style="margin:0px;">
      <input type="hidden" name="func" value="edit_save">
      <input type="hidden" name="accNo" value=" <? echo $employee[AccountNumber]; ?> ">
      <table style="width:100%;height:50px;border:0px;">
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">EmployeeId</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_id" style="width:100%;" value="<? echo $employee[EmployeeID]; ?>"></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">First Name</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_firstname" style="width:100%;" value="<? echo $employee[FirstName]; ?>"></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">Last Name</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_lastname" style="width:100%;" value="<? echo $employee[LastName]; ?>"></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">SSN</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_ssn" style="width:100%;" value="<? echo $employee[SSN]; ?>"></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">Password</td>
          <td align="left" valign="middle" style="height:50px;"><input type="password" name="m_pass" style="width:100%;" value="<? echo $employee[Password]; ?>"></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">Re-enter Password</td>
          <td align="left" valign="middle" style="height:50px;"><input type="password" name="m_pass2" style="width:100%;" value="<? echo $employee[Password]; ?>"></td>
        </tr>

        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">Address</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_address" style="width:100%;" value="<? echo $employee[Address]; ?>"></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">City</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_city" style="width:100%;" value="<? echo $employee[City]; ?>"></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">State</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_state" style="width:100%;" value="<? echo $employee[State]; ?>"></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">ZipCode</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_zipcode" style="width:100%;" value="<? echo $employee[ZipCode]; ?>"></td>
        </tr>

        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">Telephone</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_telephone" style="width:100%;" value="<? echo $employee[Telephone]; ?>"></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">Email</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_email" style="width:100%;" value="<? echo $employee[Email]; ?>"></td>
        </tr>
        <tr>
          <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">Hourly Rate</td>
          <td align="left" valign="middle" style="height:50px;"><input type='number' min="0.01" step="any" name='m_rate' required style="width:100%;" value="<? echo $employee[HourlyRate]; ?>"></td>
        </tr>

        <?
        if($employee[IsManager])
        {
          echo '<td><input type="radio" name="is_manager" value="1" checked>Register as a site Manager<br/>' ;
          echo '<input type="radio" name="is_manager" value="0">Register as a Regular Employee</td>' ;
        }
        else {
          echo '<td><input type="radio" name="is_manager" value="0" checked>Register as a Regular Employee<br/>' ;
          echo '<input type="radio" name="is_manager" value="1">Register as a site Manager</td>' ;
        }
        ?>

        <tr>
          <td align="center" valign="middle" colspan="2"><input type="button" value=" Submit " onClick="employee_edit();"></td>
        </tr>
      </table>
    </form>

    <form name="emplDelForm" method="post" action="./instab_del_employee_save.php" style="margin:0px;">
      <input type="hidden" name="func" value="del_save">

      <input type="hidden" name="accNo" value=" <? echo $employee[AccountNumber]; ?> ">
    <input type="button" value=" Delete Employee " onClick="employee_delete();">
  </form>
    <script>
    function employee_edit()
    {
      var f = document.emplEditForm;

      if(f.m_id.value == ""){
        alert("Please enter ID");
        return false;
      }

      if(f.m_firstname.value == ""){
        alert("Please enter first name");
        return false;
      }

      if(f.m_lastname.value == ""){
        alert("Please enter last name");
        return false;
      }

      if(f.m_pass.value == ""){
        alert("Please enter Password");
        return false;
      }

      if(f.m_pass.value != f.m_pass2.value){
        alert("Re-entered Password is different");
        return false;
      }

      f.submit();

    }

    function employee_delete()
    {
      var f = document.emplDelForm;
      f.submit();
    }
    </script>

    <?


  }
}

?>
