<?php
/*deve solo fare il logout, distrugge la sessione*/
    session_destroy();
    $_SESSION=array();

    header("Location: index.php?logout=1");//torna alla home e tramite il GET invia la varabile logout a 1
?>
