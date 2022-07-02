<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
    }
    
    /**richieste degli utenti viste dagli admin */
?>

<!doctype html>
<html>
<title>	richieste utenti </title>
<!--il tag meta permette di aprire la pagina anche in dispositivi piu' piccoli-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="stylee.css">

<!--servono per lo stile dei messaggi di errore -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<style>

</style>



<div class=sticky>

<button id=btn class=fill onclick=goBack()>torna indietro</button>


</div>
<center>
    <styTit>{Richieste Utenti}</styTit>


    <div style="padding:20px;margin-top:20px;"> 
    


    <?php
    /**prende tutte le richieste */
        include 'connessione.php';

        $query="select a.*, u.*
            from ((Utenti u inner join Assistenza a on u.CFu=a.CFu)
                inner join Interventi i on a.codInte=i.codInte)

          ; ";
        
        $ris=mysqli_query($con, $query);

        if(!$ris){
            echo "erroe".mysqli_error($con);
        }else{
            ?>
            

            <table  style="font-family: comfortaa-regular; font-size: 110%; color: #f6f6f6; text-align: center;" cellpadding=7 cellspacing=0  >
            <tr style="border-bottom: 2px solid #03caca;">
                <td>CODICE FISCALE</td>
                <td>PROBLEMATICA</td>
                <td>TIPO</td>
                <td>LIVELLO URGENZA</td>
               
          
                
            
            </tr>
            <?php
            $I=0;
            while($riga=mysqli_fetch_array($ris)){
                
                $codProblema=$riga['codProblema'];
  

                
                echo "<tr>";
                echo "<td>".$riga['CFu']."</td>";
                echo "<td>&ldquo;".$riga['descri']."&rdquo;</td>";
                echo "<td>".$riga['tipo']."</td>";
               
                if($riga['lvlUrgenza']=="basso")
                    echo "<td rowspan=2><button id=basso disabled onmouseover=bShow($I) onmouseout=bHide($I) ></button><div id=bassoInfo$I style='display:none; color:#36ee08c4;' >basso</div></td>";

                 else if($riga['lvlUrgenza']=="medio")
                    echo "<td rowspan=2><button id=medio disabled onmouseover=mShow($I) onmouseout=mHide($I) ></button><div id=medioInfo$I style='display:none; color: #ff9203c9;' >medio</div></td>";
                else
                echo "<td rowspan=2><button id=alto disabled  onmouseover=aShow($I) onmouseout=aHide($I)></button><div id=altoInfo$I style='display:none; color:#c90707;' >alto</div></td>";
                
                echo"</tr><tr style='border-bottom: 1px dashed #078888;'>";

                if($riga['risolto']!=1){
                
                    if($riga['CFa']==""){
                        echo "<td colspan=4><button id=btn class=raise onclick=accetta($codProblema)>accetta</button>";
                        echo "<button id=btn class=offset onclick=rifiuta($codProblema)>rifiuta</button></td>";
                    }else{

                        
                        if($riga['rifiutato']!=1 ){
                            if($riga['CFa']==$_SESSION['cf']) //se è stata accettata dall'admin loggato dentro mette il pulsante per la chat
                                echo "<td colspan=4><button id=btn class=pulsee onclick=chat($codProblema)>vai alla chat</button>";
                            else{ //scrive da chi è stata accettata
                             ?>
                              <td colspan=4 align=center>
                                <p style=" font-family: comfortaa-regular;">la richiesta è stata già <span style="color: #fffb03;">accettata</span> dall'admin <span style='color: #03d0ff;'><?php echo $riga['CFa']; ?></span></p>
                            </td>
                            <?php
                            }
                        }else{ 
                           ?>
                           <td colspan=4 align=center>
                                <p style=" font-family: comfortaa-regular;">la richiesta è stata <span style="color: #ff0303;">rifiutata</span> dall'admin <span style='color: #03d0ff;'><?php echo $riga['CFa']; ?></span></p>
                            </td>
                           <?php
                           }
                    }
                    echo"</tr>";
                }else{
                    //se è stato risolto
                    ?>
                    <td colspan=4 align=center>
                         <p style=" font-family: comfortaa-regular;">problema <span style="color: #36ee08ea;">risolto</span> dall'admin <span style='color: #03d0ff;'><?php echo $riga['CFa']; ?></span></p>
                     </td>
                    <?php
                }
                $I++;
                
            }

            mysqli_close($con);
            
        }



    if(isset($_GET['op'])){
        if($_GET['op']==1){
            //se accetta la richiesta
            //diventa l'admin ad occuparsi di quel problema

            include 'connessione.php';

            $query="update Assistenza set CFa='".$_SESSION['cf']."'
                where codProblema=".$_GET['codP'].";";

            $ris=mysqli_query($con, $query);

            if(!$ris)
                echo "erroree ".mysqli_error($con);
            else{
                //chat
                include 'connessione.php';

                $query="select a.CFu, a.descri, u.nome
                    from Assistenza a inner join Utenti u on a.CFu=u.CFu
                    where  a.codProblema=".$_GET['codP']." and  a.CFa='".$_SESSION['cf']."';";

                $ris=mysqli_query($con, $query);

                if(!$ris){
                    echo "erroe".mysqli_error($con);
                }else{
                    $riga=mysqli_fetch_array($ris);
                    include 'connessione.php';
                  
                    
                    $query="insert into chat values
                    (".$_GET['codP'].", null , '".$riga['nome']."',  '".$riga['descri']."', '".date("H:i:s")."', '".date("Y-m-d")."');";
                   
                    $ris=mysqli_query($con, $query);

                    if(!$ris){
                        echo "erroe".mysqli_error($con);
                    }else{
                          //manda l'email!!
                include 'connessione.php';

                //email dell'utente per inviargli l'email come viene accettata la richiesta
                $query="select u.email
                    from Utenti u inner join Assistenza a
                    where  codProblema=".$_GET['codP'].";";
                
                $ris=mysqli_query($con, $query);

                if(!$ris){
                        echo "erroe".mysqli_error($con);
                }else{
                    $riga=mysqli_fetch_array($ris);

                    
                    //echo $riga['email'];
                    require 'PHPMailer/PHPMailerAutoload.php';

                    $mail = new PHPMailer;
        
                    $mail->isSMTP();                            // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                     // Enable SMTP authentication
                    $mail->Username = 'assis.onlinegiu@gmail.com';         // SMTP username del mittente
                    $mail->Password = 'qwerty1234#'; 			// SMTP password del mittente
                    $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                          // TCP port to connect to
        
                    $mail->setFrom('assis.onlinegiu@gmail.com', 'Real Life i-Tech Help');
                    $mail->addReplyTo('assis.onlinegiu@gmail.com', 'Real Life i-Tech Help');
                    $mail->addAddress($riga['email']);   // Add a recipient
                    //$mail->addAddress('assis.onlinegiu@gmail.com');   // Add a recipient
                    $mail->addCC('');
                    $mail->addBCC('');
        
                    $mail->isHTML(true);  // Set email format to HTML
        
                    $bodyContent = '<h1>Accettazione richiesta</h1>';
                    $bodyContent .= "<p> La tua richiesta di aiuto è stata accettata dall'admin ".$_SESSION['nome']."
                                    accedi alla tua area riservata per ricevere l'aiuto: <b>
                                    <a href=http://127.0.0.1:80/info/assis_online/index.php>
                                    http://127.0.0.1:80/info/assis_online/index.php</a></b></p>";
        
                    $mail->Subject = 'da Real Life I-Tech Help ;)';
                    $mail->Body    = $bodyContent;
        
                    if(!$mail->send()) {
                        ?>
                        <div id=error class=divMsg >
                        <div class="alert fade alert-simple alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
                        <button id=btnMsg type="button" class="close font__size-18" data-dismiss="alert">
                                                    <span aria-hidden="true">
                                                        <i class="fa fa-times danger "></i>
                                                    </span>
                                                    <span class="sr-only">Close</span>
                                                </button>
                        <i class="start-icon far fa-times-circle faa-pulse animated"></i>
                        <strong class="font__weight-semibold">Oh  no!</strong> l'email non può essere inviata...<br><?php echo $mail->ErrorInfo; ?>
                        </div>
                    </div>

                    <?php

                
                } else {
                    ?>
                    <script> window.location.href="chat.php"+"?cod="+<?php echo $_GET['codP'] ?>+""</script>
      <?php
                    }
                    }
                ?>
                
                <?php
            }} 
        }
       
        }else{
            /**se è ==2 allora vuol dire che la richiesta è stata rifiutata perchè si, può succedere */
            include 'connessione.php';
            //serve l'email dell'utente che ha fatto quellarichiesta!
            $query="select u.email 
                from Utenti u inner join Assistenza a on u.CFu=a.CFu
                where a.codProblema=".$_GET['codP'].";";
            //manda l'email del rifiuto!

            
            $ris=mysqli_query($con, $query);

             if(!$ris)
                echo "errore sacdsscdse ".mysqli_error($con);
            else{     

               $riga=mysqli_fetch_array($ris);   
            //echo $riga['email'];
            require 'PHPMailer/PHPMailerAutoload.php';

            $mail = new PHPMailer;

            $mail->isSMTP();                            // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                     // Enable SMTP authentication
            $mail->Username = 'assis.onlinegiu@gmail.com';         // SMTP username del mittente
            $mail->Password = 'qwerty1234#'; 			// SMTP password del mittente
            $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                          // TCP port to connect to

            $mail->setFrom('assis.onlinegiu@gmail.com', 'Real Life i-Tech Help');
            $mail->addReplyTo('assis.onlinegiu@gmail.com', 'Real Life i-Tech Help');
            $mail->addAddress($riga['email']);   // Add a recipient
            //$mail->addAddress('assis.onlinegiu@gmail.com');   // Add a recipient
            $mail->addCC('');
            $mail->addBCC('');

            $mail->isHTML(true);  // Set email format to HTML

            $bodyContent = '<h1>Rifiuto richiesta</h1>';
            $bodyContent .= "<p> La tua richiesta di aiuto con codice ".$_GET['codP']." è stata rifiutata dall'admin <strong>".$_SESSION['nome']."</strong>
                            per informazioni contatta pure l'admin all'indirizzo: <strong>".$_SESSION['email']."</strong>
                            <b>
                            <br><br><a href=http://127.0.0.1:80/info/assis_online/index.php>
                            home page</a></b></p>";

            $mail->Subject = 'da Real Life I-Tech Help ;)';
            $mail->Body    = $bodyContent;

            if(!$mail->send()) {
                ?>
                <div id=error class=divMsg >
                <div class="alert fade alert-simple alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
                <button id=btnMsg type="button" class="close font__size-18" data-dismiss="alert">
                                            <span aria-hidden="true">
                                                <i class="fa fa-times danger "></i>
                                            </span>
                                            <span class="sr-only">Close</span>
                                        </button>
                <i class="start-icon far fa-times-circle faa-pulse animated"></i>
                <strong class="font__weight-semibold">Oh  no!</strong> l'email non può essere inviata...<br><?php echo $mail->ErrorInfo; ?>
                </div>
            </div>

            <?php

        
        } else {
            
        }}
            //la contrassegna come rifiutata da quell'admin !

            
            include 'connessione.php';

            $query="update Assistenza 
                set CFa='".$_SESSION['cf']."', rifiutato=1
                where codProblema=".$_GET['codP'].";";

            $ris=mysqli_query($con, $query);

            if(!$ris)
                echo "erroree ".mysqli_error($con);
            else{?>
                <script> window.location.href="richiesteUsr.php"</script>
            <?php
            }

            mysqli_close($con);
        
        }

    }

    ?>



    </div>
</body>



</html>
<script>
	/*jquery !!! */

	/**toglie il messaggio */
	$("#error").click(function(){ //quando si clicca sull'oggetto con id error 
		$("#error").fadeToggle(); //lo fa sparire con un'animazione
		window.location.href="richiesteUsr.php"; /**ricarica cosi quando si preme il tasto refersh sul browser non appare di nuovo */
	
    });
</script>
    
<script>

    function bShow(x){ document.getElementById("bassoInfo"+x).style.display="block";}
    function bHide(x){ document.getElementById("bassoInfo"+x).style.display="none";}

    function mShow(x){ document.getElementById("medioInfo"+x).style.display="block";}
    function mHide(x){ document.getElementById("medioInfo"+x).style.display="none";}

    function aShow(x){ document.getElementById("altoInfo"+x).style.display="block";}
    function aHide(x){ document.getElementById("altoInfo"+x).style.display="none";}


     function goBack(){ 
        window.location.href="areaAdmin.php";
    }

    function accetta(num){
        window.location.href="richiesteUsr.php"+"?"+"op=1"+"&"+"codP="+num;
    }

    function rifiuta(num){
        window.location.href="richiesteUsr.php"+"?"+"op=2"+"&"+"codP="+num;
    }

    function chat(num){
        window.location.href="chat.php?cod="+num;
    }

</script>

