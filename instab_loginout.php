<?
include ("./include.php");

// set empty session values
$_SESSION[user_idx] = "";
$_SESSION[user_id] = "";
$_SESSION[user_name] = "";

$_SESSION[empl_idx] = "";
$_SESSION[empl_id] = "";
$_SESSION[empl_name] = "";
$_SESSION[IsManager] = 0;


?>
<script>
alert("You are logged off");
location.replace("instab_login.php");
</script>
