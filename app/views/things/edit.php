<?php require APPROOT . '/views/inc/header.php'; ?> 
        <a href="<?php echo URLROOT;?>/things" class="btn btn-light"><i class="fa fa-backward"></i>Back</a>
      <div class="card card-body bg-light mt-5">    
        <h2>Edit Thing</h2>
        <p>Add a thing with this form</p>
        <form action="<?php echo URLROOT; ?>/things/edit/<?php echo $data['id'];?>" method="post">
          <div class="form-group">
            <label for="name">Name's thing: <sup>*</sup></label>
            <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="baseHost">baseHost's thing: <sup>*</sup></label>
            <input type="text" name="baseHost" class="form-control form-control-lg <?php echo (!empty($data['baseHost_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['baseHost']; ?>">
            <span class="invalid-feedback"><?php echo $data['baseHost_err']; ?></span>
          </div>  
          <div class="form-group">

            <label for="type">type: <sup>*</sup></label>
            <select name="type" class="form-control form-control-lg <?php echo (!empty($data['type_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['type']; ?>">
                <option value="actionneur">actionneur</option>
                <option value="capteur">capteur</option>
             </select>
            <span class="invalid-feedback"><?php echo $data['type_err']; ?></span>
          </div>  
        <input type="submit" class="btn btn-success" value="Submit">
    
        </form>
      </div>   
<?php require APPROOT . '/views/inc/footer.php'; ?>