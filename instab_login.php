<?
include ("./include.php");
// return back if the user is already logged in
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
<table style="width:100%;height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">User Login</td>
    </tr>
</table>
<br/>
<form name="loginForm" method="post" action="./login_chk.php" style="margin:0px;">
<table style="width:100%;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">UserID</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="m_id" style="width:100%;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">Password</td>
        <td align="left" valign="middle" style="height:50px;"><input type="password" name="m_pass" style="width:100%;"></td>
    </tr>
    <!-- call login_chk function-->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value="Login" onClick="login_chk();"></td>
    </tr>
</table>
</form>

<script>

function login_chk()
{
    var f = document.loginForm;

    if(f.m_id.value == ""){
        alert("Plese enter id");
        return false;
    }

    if(f.m_pass.value == ""){
        alert("Please enter password");
        return false;
    }

    f.submit();
}
</script>
