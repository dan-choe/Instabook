<?
include ("./include.php");

if (isset($_POST[func])) {

  if (strcmp($_POST[func],'del_save') == 0) {

    $query = "DELETE FROM Employee WHERE AccountNumber = $_POST[accNo]";
    $result = sql_query($query);

    ?>
    <script>
    alert("Completed Update!");
    location.replace("./manage_employees");
    </script>
    <?

  }
}

?>
