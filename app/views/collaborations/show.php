<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT;?>/collaborations" class="btn btn-light"><i class="fa fa-backward"></i>Back</a>

    <?php if($data['collaboration']->user_id == $_SESSION['user_id']) : ?>
    <hr>
    <a href="<?php echo URLROOT;?>/collaborations/edit/<?php echo $data['collaboration']->id;?>" class="btn btn-dark">Edit</a>
    <form class="pull-right" action="<?php  echo URLROOT;?>/collaborations/delete/<?php echo $data['collaboration']->id;?>" method="post">
    <input type="submit" value="Delete" class="btn btn-danger">
    </form>
    <?php endif;?>

    <div class="box380 center">
    <h4>Condition de la collaboration</h4>
    <p>SI (<b><?php echo $data['collaboration']->capteur; ?></b> <?php echo $data['collaboration']->condi;?> <?php echo $data['collaboration']->valeur_capteur; ?>) ALORS <b><?php echo $data['collaboration']->actionneur;?></b> envoie <b><?php echo $data['collaboration']->valeur_actionneur;?> </b><p>
    </div>

   
    <div class="card center" style="width: 18rem;">
    <img class="card-img-top" src="<?php echo URLROOT;?>/public/img/good.png" alt="Card image cap">
    <div class="card-body">
    <p class="card-text">connection success</p>
    </div>
    </div>
    
<script>
const api_url_capteur = 
      "http://<?php echo $data['collaboration']->baseHost_capteur;?>/status_sensors";
      function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
          if ((new Date().getTime() - start) > milliseconds){
            break;
          }
        }
      }
// Defining async function
    async function getapi(api_url_capteur) {
    while(true){
    sleep(2000);
    // Storing response
    const respons_capteur = await fetch(api_url_capteur);
    // Storing data in form of JSON
    var data_capteur = await respons_capteur.json();
    console.log(data_capteur);

    if(!respons_capteur.ok){ 

    }else{

    //send websocet
    <?php
    switch ($data['collaboration']->condi) {
    case "1":
      $data['collaboration']->condi = "<";
        break;
    case "2":
      $data['collaboration']->condi = "<=";
        break; 
}
?>
    var ws = new WebSocket('ws://<?php echo $data['collaboration']->baseHost_actionneur;?>/ws');
    if (data_capteur.<?php echo $data['collaboration']->capteur;?> <?php echo $data['collaboration']->condi;?> <?php echo $data['collaboration']->valeur_capteur;?>){ 
        ws.onmessage = function(e) {
<?php
    switch ($data['collaboration']->actionneur) {
    case "Relay 1":
        $id = 1;
        break;
    case "Relay 2":
        $id = 2;
        break;
    case "Relay 3":
        $id = 3;
        break;
      case "Relay 4":
        $id = 4;
        break;
}
?>
         ws.send(JSON.stringify({type:10, id:<?php echo $data['collaboration']->idRelay;?>, name: "<?php echo $data['collaboration']->actionneur;?>",state: <?php echo $data['collaboration']->valeur_actionneur;?>}));          
        };
      } else {
      ws.onmessage = function(e) {
      bool = <?php echo $data['collaboration']->valeur_actionneur;?>;
      ws.send(JSON.stringify({type:10, id:<?php echo $data['collaboration']->idRelay;?>, name: "<?php echo $data['collaboration']->actionneur;?>",state: !bool}));
      ws.close();          
      };
     }
    }
  }
} 
    // Calling that async function
    getapi(api_url_capteur); 
</script>



<script src= "<?php echo URLROOT; ?>/public/js/lib.js" type="text/javascript"></script>
<script src="<?php echo URLROOT; ?>/public/js/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"></script>
<script src="<?php echo URLROOT; ?>/public/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"></script>
</body>
</html>

