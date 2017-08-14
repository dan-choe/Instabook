<?
include ("./include.php");

if($_SESSION[user_id] || $_SESSION[empl_id]){
    ?>
    <script>
        alert("You are already logged in");
        history.back();
    </script>
    <?
}

// check the argument
if(trim($_POST[e_id]) == ""){
    ?>
    <script>
        alert("Please enter ID");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[e_pass] == ""){
    ?>
    <script>
        alert("Please enter Password");
        history.back();
    </script>
    <?
    exit;
}

// Check the id is in the db or not
$chk_sql = "select * from `Employee` where `EmployeeID` = '".trim($_POST[e_id])."'";
//SELECT Id, FirstName FROM User WHERE AccountNumber='100' AND Password='qwer1234';

$chk_result = sql_query($chk_sql);
$chk_data = mysqli_fetch_array($chk_result);

// if there is id
if($chk_data[AccountNumber]){

    // check the password is same
    if($_POST[e_pass] == $chk_data[Password]){
        // if the password is same, allow login
        $_SESSION[empl_idx] = $chk_data[AccountNumber];
        $_SESSION[empl_id] = $chk_data[EmployeeID];
        $_SESSION[empl_name] = $chk_data[FirstName];
        $_SESSION[IsManager] = $chk_data[IsManager];

        // clear user login info just incase
        $_SESSION[user_idx] = "";
        $_SESSION[user_id] = "";
        $_SESSION[user_name] = "";


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
