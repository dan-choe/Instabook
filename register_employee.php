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
<table style="width:100%; height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-size:15px;font-weight:bold;">Register a New Employee</td>
    </tr>
</table>
<br/>
<form name="emplRegistForm" method="post" action="./instab_register_employee_save.php" style="margin:0px;">
<table style="width:85%;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">Employee ID</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_id" style="width:100%;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">First Name</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_firstname" style="width:100%;"></td>
    </tr>
	<tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">Last Name</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_lastname" style="width:100%;"></td>
    </tr>
    <tr>
          <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">SSN</td>
          <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_ssn" style="width:100%;"></td>
      </tr>
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">Password</td>
        <td align="left" valign="middle" style="height:50px;"><input type="password" name="m_pass" style="width:100%;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">Re-enter Password</td>
        <td align="left" valign="middle" style="height:50px;"><input type="password" name="m_pass2" style="width:100%;"></td>
    </tr>

	<tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">Address</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_address" style="width:100%;"></td>
    </tr>
	<tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">City</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_city" style="width:100%;"></td>
    </tr>
	<tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">State</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_state" style="width:100%;"></td>
    </tr>
	<tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">ZipCode</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_zipcode" style="width:100%;"></td>
    </tr>

	<tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">Telephone</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_telephone" style="width:100%;"></td>
    </tr>
	<tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">Email</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_email" style="width:100%;"></td>
    </tr>
	<tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">Hourly Rate</td>
        <td align="left" valign="middle" style="height:50px;"><input type='number' min="0.01" step="any" name='m_rate' required style="width:100%;"></td>
    </tr>

    <td><input type="radio" name="is_manager" value="0" checked>Register as a Regular Employee<br/>
    <input type="radio" name="is_manager" value="1">Register as a site Manager</td>

    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Submit " onClick="employee_save();"></td>
    </tr>
</table>
</form>
<script>
function employee_save()
{
    var f = document.emplRegistForm;

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
</script>
