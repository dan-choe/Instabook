<?
include ("./include.php");

if($_SESSION[user_id]){
    ?>
     <script>
        alert("You are already logged in");
        history.back();
    </script>
    <?
}
?>
<br/>
<table style="width:100%; height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-size:15px;font-weight:bold;">Register for Instabook</td>
    </tr>
</table>
<br/>
<form name="registForm" method="post" action="./instab_register_save.php" style="margin:0px;">
<table style="width:100%;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">User ID</td>
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
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">CCNumber</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_ccnumber" style="width:100%;"></td>
    </tr>

	<tr>
    <td>Rating</td>
    <td><select name="m_rating">
      <option value="1_opt1" selected="selected">1_opt1</option>
      <option value="2_opt2">2_opt2</option>
      <option value="3_opt3">3_opt3</option>
      <option value="4_opt4">4_opt4</option>
      <option value="5_opt5">5_opt5</option>
      <option value="6_opt6">6_opt6</option>
    </select></td>
  </tr>


    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" Submit " onClick="member_save();"></td>
    </tr>
</table>
</form>
<script>
function member_save()
{
    var f = document.registForm;

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
