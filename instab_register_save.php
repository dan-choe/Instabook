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

if(trim($_POST[m_id]) == ""){
    ?>
    <script>
        alert("Plese enter id");
        history.back();
    </script>
    <?
    exit;
}

if(trim($_POST[m_firstname]) == ""){
    ?>
    <script>
        alert("Plese enter firstname");
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

echo $_POST[m_id];
$chk_sql = "SELECT * FROM `User` WHERE `UserID` = '".trim($_POST[m_id])."'";
$chk_result = sql_query($chk_sql);
$chk_data = mysqli_fetch_array($chk_result);

if($chk_data[m_idx]){
    ?>
    <script>
        alert("There is same id. <?echo $_POST[m_id]?>");
        history.back();
    </script>
    <?
    exit;
}else{
	?>
    <script>
        alert("There is no same id.");
    </script>
    <?
}

//$sql = "INSERT INTO `User` VALUES ('".trim($_POST[m_id])."', '".trim($_POST[m_firstname])."', '".trim($_POST[m_lastname])."', '".trim($_POST[m_address])."', '".trim($_POST[m_city])."', '".trim($_POST[m_state])."', '".trim($_POST[m_zipcode])."', '".trim($_POST[m_telephone])."', '".trim($_POST[m_email])."', GETDATE(), '".trim($_POST[m_ccnumber])."', '".$_POST[m_pass]."', '".trim($_POST[m_rating])."')";

$sql = "INSERT INTO `User`(`UserID`, `FirstName`, `LastName`, `Address`, `City`, `State`, `ZipCode`, `Telephone`, `Email`, `CreationDate`, `CCNumber`, `Password`, `Rating`) VALUES ('".trim($_POST[m_id])."', '".trim($_POST[m_firstname])."', '".trim($_POST[m_lastname])."', '".trim($_POST[m_address])."', '".trim($_POST[m_city])."', '".trim($_POST[m_state])."', '".trim($_POST[m_zipcode])."', '".trim($_POST[m_telephone])."', '".trim($_POST[m_email])."', NOW(), '".trim($_POST[m_ccnumber])."', '".$_POST[m_pass]."', '".trim($_POST[m_rating])."')";

sql_query($sql);

?>
<script>
alert("Completed register");
//location.replace("instab_login.php");
</script>