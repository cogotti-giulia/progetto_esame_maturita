<?php
	session_start();
	if(isset($_SESSION['cf']) &&  isset($_GET['logout']) && $_GET['logout']==1){
		session_destroy();
		$_SESSION=array();
	}
?>

<!doctype html>
<title>gestisci faq </title>
<!--il tag meta permette di aprire la pagina anche in dispositivi piu' piccoli-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="stylee.css">

<!--servono per lo stile dei messaggi di errore -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<style>
 
       
    ul.b {
        display: none;
        padding-left: 17px;
        list-style-type: square;
    }



    .cerca{
        background-image: url('icons/cerca1.png');
        background-position: 5px 9px;
        background-repeat: no-repeat;
    }

    .sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  text-align: center;
  padding-top: 60px;
}

.sidenav form{
    padding-top: 30px;
}
.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: #00f4f4;
  display: block;
}

.sidenav a:hover {
  color: #064579;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav form {size: 18px;}
  .sidenav a {font-size: 18px;}
}

</style>

<body>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <form action=<?php echo $_SERVER['PHP_SELF']; ?> method=get  >

                <input type=text class=cerca name=cerca placeholder=cerca... ><br><br>
            
               
                <input type=checkbox name=ckH value=hardware class="option-input checkbox" />
                <label for=ckH > hardware </label>

                <input type=checkbox name=ckS value=software class="option-input checkbox" />
                <label for=ckS > software </label>




             </form>
        </div>  
   



<div class=sticky> <!-- style="float:left;"-->
    <button class=fill id=btn onclick=goBack()>torna indietro</button><br>
    <span style="padding-left: 27px; text-align:center; color: #f6f6f6; font-family: comfortaa-regular; font-size:30px;cursor:pointer" onclick="openNav()">
        &#9776; cerca
    </span>

</div>

    <div style="position:fixed; right: 0px; margin: 20px; bottom:0; ">
    <span id=spanFAQ style="
            font-family: comfortaa-regular;
            color:#36ee08ea; 
            font-size: 120%;
            position: relative;
            top: 5px;
            margin-right: 2px;
            display: none;">nuova faq</span>

        <button class=nuovaFAQ id=nuovaFAQ style="  
            border: 1px solid #36ee08c4;
            background-color: rgba(27, 197, 50, 0.452);
            box-shadow: 0px 0px 15px #36ee08ea;
            padding: 25px;
            border-radius:100px;
            cursor: pointer;" >
        </button>
        
        </div>
        <div style="position:fixed; right: 0px; margin: 20px; bottom:70px; ">
        <span id=spanFAQ1 style="
            font-family: comfortaa-regular;
            color:#ff0303; 
            font-size: 120%;
            position: relative;
            top: 5px;
            margin-right: 2px;
            display: none;">elimina faq</span>

        <button class=eliminaFAQ id=eliminaFAQ style="  
            border: 1px solid rgba(241, 6, 6, 0.81);
            background-color: rgba(228, 18, 3, 0.452);
            box-shadow: 0px 0px 15px #ff0303;
            padding: 25px;
            border-radius:100px;
            cursor: pointer;" >
        </button>
    </div>
    
<div id=main>
<center>
<styTit>{Gestisci FAQ}</styTit>

<div style="padding:20px;margin-top:20px;"> 
 
    
    

 <?php
 
 $styBtn=Array("offset", "slide", "up", "raise", "closee", "pulsee", "fill");
 

     /**se si è cercato qualcosa e la casella di testo non è vuota */
     if(isset($_GET['cerca']) && !empty($_GET['cerca'])){
        include 'connessione.php';

        $query="select f.*
        from Faq f
        where f.problema like '%".$_GET['cerca']."%' and  f.CFa='".$_SESSION['cf']."'
        order by f.codFaq; ";

        
        if(isset($_GET['ckH']) && isset($_GET['ckS'])){
            $query="select f.*
            from Faq f 
            where f.problema like '%".$_GET['cerca']."%' 
                and tipo='".$_GET['ckH']."' or tipo='".$_GET['ckS']."' and  f.CFa='".$_SESSION['cf']."'
            order by f.codFaq; ";

        }else if(isset($_GET['ckH'])){
            $query="select f.*
            from Faq f 
            where f.problema like '%".$_GET['cerca']."%' and tipo='".$_GET['ckH']."' and  f.CFa='".$_SESSION['cf']."'
            order by f.codFaq; ";


        }else if(isset($_GET['ckS'])){
            $query="select f.*
            from Faq f 
            where f.problema like '%".$_GET['cerca']."%' and tipo='".$_GET['ckS']."' and  f.CFa='".$_SESSION['cf']."'
            order by f.codFaq; ";


        }
      
  
  

        
        $ris=mysqli_query($con, $query);


        if(!$ris)
            echo "<p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >errore ".mysqli_error($con)."</p>";
        else if(mysqli_num_rows($ris)==0){
            ?>
            <p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >nessun risultato ottenuto</p>
            <button id=btn class=raise onclick=aggiorna()>AGGIORNA</button>
            <?php
        }else{
           
            $I=1;

           
            
            echo "<table  cellpadding=5 style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >";
            while($riga=mysqli_fetch_array($ris)){

                
               // if($riga['codFaq']==$I){
                
                    $rand=rand(0, count($styBtn)-1);/**stile random per i pulsanti */
                    echo "</ul></td></tr>";
                    echo "<tr><td>".$riga['codFaq']."</td>";
                    echo "<td align=center>".strtoupper($riga['problema'])."
                        <button style=' padding-top: 5px;
                        padding-bottom: 5px;
                        padding-left: 10px;
                        padding-right: 10px;' class=".$styBtn[$rand]." name=btnVedi id=btn onclick=show('$I')>mostra  &#x21AF;</button></td></tr>";
                
                  
                    echo "<tr><td colspan=2><ul class=b id=soluzioni$I>";
              
                    $I++;

                    
              
                //prende le soluzioni di quella FAQ
                    include 'connessione.php';

                $queryy="select s.*
                    from ((Faq f inner join ha on f.codFaq=ha.codFaq)
                        inner join Soluzioni s on ha.codSoluzione=s.codSoluzione)
                    where f.CFa='".$_SESSION['cf']."' and f.codFaq=".$riga['codFaq']."
                    order by f.codFaq; ";

                    $riss=mysqli_query($con, $queryy);

                    if(!$riss)
                        echo "err".mysqli_error($con);
                    else{
                        while($riga2=mysqli_fetch_array($riss))
                            echo "<li><div id=divS>".$riga2['soluzione']."</div></li>";
               
                    }
              //  }
            }
            


        

            


        }

        mysqli_close($con);

    }else{
        include 'connessione.php';

      
        $query="select f.*
            from Faq f 
                where f.CFa='".$_SESSION['cf']."'
            order by f.codFaq; ";

        $ris=mysqli_query($con, $query);

        if(!$ris)
        echo "<p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >errore ".mysqli_error($con)."</p>";
        else if(mysqli_num_rows($ris)==0){
            ?>
            <p style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >non è presente nessuna FAQ</p>
           
            <?php
        }else{
            $I=1;

           
            
            echo "<table  cellpadding=5 style='font-size: 120%; color:#f6f6f6; font-family: comfortaa-regular;' >";
            while($riga=mysqli_fetch_array($ris)){

                
               // if($riga['codFaq']==$I){
                
                    $rand=rand(0, count($styBtn)-1);/**stile random per i pulsanti */
                    echo "</ul></td></tr>";
                    echo "<tr><td>".$riga['codFaq']."</td>";
                    echo "<td align=center>".strtoupper($riga['problema'])."
                        <button style=' padding-top: 5px;
                        padding-bottom: 5px;
                        padding-left: 10px;
                        padding-right: 10px;' class=".$styBtn[$rand]." name=btnVedi id=btn onclick=show('$I')>mostra  &#x21AF;</button></td></tr>";
                
                  
                    echo "<tr><td colspan=2><ul class=b id=soluzioni$I>";
                  
                    $I++;

                    
              
                //prende le soluzioni di quella FAQ
                    include 'connessione.php';

                $queryy="select s.*
                    from ((Faq f inner join ha on f.codFaq=ha.codFaq)
                        inner join Soluzioni s on ha.codSoluzione=s.codSoluzione)
                    where f.CFa='".$_SESSION['cf']."' and f.codFaq=".$riga['codFaq']."
                    order by f.codFaq; ";

                    $riss=mysqli_query($con, $queryy);

                    if(!$riss)
                        echo "err".mysqli_error($con);
                    else{
                        while($riga2=mysqli_fetch_array($riss))
                            echo "<li><div id=divS>".$riga2['soluzione']."</div></li>";
               
                    }
              //  }
            }
            


        }

        mysqli_close($con);
    }


    ?>

</div>
    </div>



</body>


</html>
<script>
    $(".nuovaFAQ").mouseover(function(){
        $("#spanFAQ").fadeIn();
    });

    $(".nuovaFAQ").mouseout(function(){
        $("#spanFAQ").fadeToggle();
    });
    $(".eliminaFAQ").mouseover(function(){
        $("#spanFAQ1").fadeIn();
    });

    $(".eliminaFAQ").mouseout(function(){
        $("#spanFAQ1").fadeToggle();
    });
</script>
<script>

    document.getElementById("main").addEventListener("click", closeNav);

    function openNav() {
    document.getElementById("mySidenav").style.width = "300px";
    document.getElementById("main").style.marginLeft = "250px";
    /* document.body.style.backgroundColor = "rgba(0,0,0,0.4)";*/
    }

    function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    /* document.body.style.backgroundColor = "white";*/
    }
</script>
   

</script>
<script>
    document.getElementById("nuovaFAQ").onclick = function () {
        location.href = "nuovaFaq.php";
    };

    document.getElementById("eliminaFAQ").onclick = function () {
        location.href = "eliminaFaq.php";
    };
     function goBack(){ 
        window.location.href="areaAdmin.php";
    }

    function aggiorna(){ //aggiorna la pagina
        window.location.href='gestisciFaq.php';
    }
    /**visualizza  */
    function show(num){
     
        if(document.getElementById('soluzioni'+num).style.display=="none" || document.getElementById('soluzioni'+num).style.display==""){
            document.getElementById('soluzioni'+num).style.display= "block";
            document.getElementsByName('btnVedi')[num-1].innerHTML="nascondi &#8634;";

        }else{

            document.getElementById('soluzioni'+num).style.display="none";
            document.getElementsByName('btnVedi')[num-1].innerHTML="mostra  &#x21AF;";
            
        }
    }


</script>

