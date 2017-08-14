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

// check the argument
if(trim($_POST[m_id]) == ""){
    ?>
    <script>
        alert("Please enter ID");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[m_pass] == ""){
    ?>
    <script>
        alert("Please enter Password");
        history.back();
    </script>
    <?
    exit;
}

// Check the id is in the db or not
$chk_sql = "select * from `User` where `UserID` = '".trim($_POST[m_id])."'";
//SELECT Id, FirstName FROM User WHERE AccountNumber='100' AND Password='qwer1234';

$chk_result = sql_query($chk_sql);
$chk_data = mysqli_fetch_array($chk_result);

// if there is id
if($chk_data[AccountNumber]){

    // check the password is same
    if($_POST[m_pass] == $chk_data[Password]){
        // if the password is same, allow login
        $_SESSION[user_idx] = $chk_data[AccountNumber];
        $_SESSION[user_id] = $chk_data[UserID];
        $_SESSION[user_name] = $chk_data[FirstName];

        ?>
        <script>
        alert("Welcome to Instabook");
        location.replace("list.php");
        </script>
        <?
        exit;
    }else{
        // password is wrong
        ?>
        <script>
            alert("Password is wrong.");
            history.back();
        </script>
        <?
        exit;
    }
}else{
    // there is no id in db
    ?>
    <script>
        alert("We don't have this ID in instabook. Try again.");
        history.back();
    </script>
    <?
    exit;
}
?>
