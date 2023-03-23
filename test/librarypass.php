<?php

include 'ui/common/header.html.php';
chdir(dirname(__FILE__));

include 'functions/checkAccount.php';
chdir(dirname(__FILE__));
requireSignin("/app.php");
requireStdVerification();

include 'functions/checkUserData.php';
chdir(dirname(__FILE__));

$serviceName = "librarypass";
include 'functions/analyzeLogs.php';
chdir(dirname(__FILE__));
include 'ui/menu/menu.tl.html.php';
chdir(dirname(__FILE__));
?>
<?php
//if there is no result on matrix_conn, create new synapse user with python script
$findMatrixCreationLog = "SELECT * FROM librarypass WHERE userID = '".$_SESSION["userID"]."' AND signMethod = '".$_SESSION["signMethod"]."'";
$findMatrixCreationLog_Result = $db->query($findMatrixCreationLog);
if ($findMatrixCreationLog_Result->rowCount() > 0){
    while($row = $findMatrixCreationLog_Result->fetch()){
        
    }
}
else{
    include 'ui/service/librarypass/scanner.php';
    chdir(dirname(__FILE__));
}
?>


<?php
include 'ui/common/footer.html.php';
?>
</body>
</html>