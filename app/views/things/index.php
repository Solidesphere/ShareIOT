<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('thing_message'); ?>
<div class="row mb-3">
  <div class="col-md-6">
    <h1>Things</h1>
  </div>
  <div class="col-md-6">
    <a href="<?php echo URLROOT; ?>/things/add" class="btn btn-primary pull-right">
      <i class='fa fa-pencil'></i> Add Thing
    </a>
  </div>
</div>

<?php foreach ($data['things'] as $things) : ?>
  <div class="card card-body mb-3">
    <h4 class="card-title"><?php echo $things->thingName; ?></h4>
    <div class="bg-light p-2 mb-3">
      <b>Add by</b> <?php echo $things->name; ?> on <?php echo $things->thingCreated; ?>
    </div>
    <div class="bg-light p-2 mb-3">
      <b>thing's name:</b> <?php echo $things->thingName; ?> 
    </div>
    <div class="bg-light p-2 mb-3">
      <b>thing's IP address:</b> <?php echo $things->baseHost; ?> 
    </div>
    <div class="bg-light p-2 mb-3">
      <b>thing's Type:</b> <?php echo $things->type; ?> 
    </div>
    <a href="<?php echo URLROOT;?>/things/show/<?php echo $things->thingId;?>" class="btn btn-dark">Monitoring And Control</a>
  </div>
<?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
