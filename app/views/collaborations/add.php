<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT;?>/collaboration" class="btn btn-light"><i class="fa fa-backward"></i>Back</a>
<div class="card card-body bg-light mt-5">
  <h2>Add Collaboration</h2>
  <p>Add a collaboration with this form </p> 
  <form action="<?php echo URLROOT; ?>/collaborations/add" method="post">
      <div class="form-group"> 
            <label  for="title">collaboration title: </label>
            <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
            <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>
      <div class="form-group">
            <label for="capteur">Select capteur: </label>
            <select name="capteur" class="form-control form-control-lg <?php echo (!empty($data['capteur_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['capteur']; ?>">
            <option selected>Open this select menu</option>
            <option value="dht_temperature">dht_temperature</option>
            <option value="dht_humidity">dht_humidity</option>
            <option value="rip_motion">rip_motion</option>
            <option value="db_temperature">db_temperature</option>
            </select>
            <span class="invalid-feedback"><?php echo $data['capteur_err']; ?></span>
       </div>
       <div class="form-group"> 
            <label  for="title">Basehost capteur: </label>
            <input type="text" name="baseHost_capteur" class="form-control form-control-lg <?php echo (!empty($data['baseHost_capteur_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['baseHost_capteur']; ?>">
            <span class="invalid-feedback"><?php echo $data['baseHost_capteur_err']; ?></span>
      </div>
      <div class="form-group"> 
            <label  for="title">Basehost actionneur: </label>
            <input type="text" name="baseHost_actionneur" class="form-control form-control-lg <?php echo (!empty($data['baseHost_actionneur_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['baseHost_actionneur']; ?>">
            <span class="invalid-feedback"><?php echo $data['baseHost_actionneur_err']; ?></span>
      </div>
       <div class="form-group">
            <label for="actionneur">Select Actionneur: </label> 
            <select name="actionneur" class="form-control form-control-lg <?php echo (!empty($data['actionneur_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['actionneur']; ?>">
            <option selected>Open this select menu</option>
            <option value="Relay 1">Relay 1</option>
            <option value="Relay 2">Relay 2</option>
            <option value="Relay 3">Relay 3</option>
            <option value="Relay 4">Relay 4</option>
            </select>
            <span class="invalid-feedback"><?php echo $data['actionneur_err']; ?></span>
        </div>
        <div class="form-group">
            <label for="idRelay">Select Id Relay same as actionneur: </label> 
            <select name="idRelay" class="form-control form-control-lg <?php echo (!empty($data['idRelay_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['idRelay']; ?>">
            <option selected>Open this select menu</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            </select>
            <span class="invalid-feedback"><?php echo $data['idRelay_err']; ?></span>
        </div>
        <div class="form-group">
            <label for="condi">Select condition: </label>
            <select name="condi" class="form-control form-control-lg <?php echo (!empty($data['condi_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['condi']; ?>">
            <option selected>Open this select menu</option>
            <option value="1
            
            
            
            "><</option>
            <option value=">">></option>
            <option value="2"><=</option>
            <option value=">=">>=</option>
            <option value="==">==</option>
            </select>
            <span class="invalid-feedback"><?php echo $data['condi_err']; ?></span>
        </div>
        <div class="form-group"> 
            <label  for="valeur_capteur">value capteur: </label>
            <input type="number" name="valeur_capteur" class="form-control form-control-lg <?php echo (!empty($data['valeur_capteur_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['valeur_capteur']; ?>"   placeholder="value capteur">
            <span class="invalid-feedback"><?php echo $data['valeur_capteur_err']; ?></span>
         </div>
         <div class="form-group"> 
            <label for="valeur_actionneur">value Actionneur: </label>
            <select name="valeur_actionneur" class="form-control form-control-lg <?php echo (!empty($data['valeur_actionneur_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['valeur_actionneur']; ?>">
            <option selected>Open this select menu</option>
            <option value="true">OFF</option>
            <option value="false">ON</option>
            </select>
            <span class="invalid-feedback"><?php echo $data['valeur_actionneur_err']; ?></span>
          </div>    
          <input type="submit" class="btn btn-success" value="Submit">   
    </div>
 </from>  
<?php require APPROOT . '/views/inc/footer.php'; ?>