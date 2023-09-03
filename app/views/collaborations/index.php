<?php require APPROOT . '/views/inc/header.php'; ?>

<?php flash('collaboration_message'); ?>
<div class="row mb-3">
  <div class="col-md-6">
    <h1>Collaboration</h1>
  </div>
  <div class="col-md-6">
    <a href="<?php echo URLROOT; ?>/collaborations/add" class="btn btn-primary pull-right">
      <i class='fa fa-pencil'></i> Add Collaboration
    </a>
  </div>
</div>

<?php foreach ($data['collaborations'] as $collaborations) : ?>
  <div class="card card-body mb-3">
    <h4 class="card-title"><?php echo $collaborations->collaborationTitle; ?></h4>
    <div class="bg-light p-2 mb-3">
      <b>Add by</b> <?php echo $collaborations->name; ?> on <?php echo $collaborations->collaborationCreated; ?>
    </div>
    <div class="bg-light p-2 mb-3">
    <p><b>Le capteur</b> <?php echo $collaborations->capteur; ?> collabore avec<b> L'actionneur </b><?php echo $collaborations->actionneur; ?></p>
    </div>
    <a href="<?php echo URLROOT;?>/collaborations/show/<?php echo $collaborations->collaborationId;?>" class="btn btn-dark">Run collaboration</a>
  </div> 
<?php endforeach; ?>
</div>
<script src= "<?php echo URLROOT; ?>/public/js/lib.js" type="text/javascript"></script>
<script src="<?php echo URLROOT; ?>/public/js/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"></script>
<script src="<?php echo URLROOT; ?>/public/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"></script>
</body>
</html>
