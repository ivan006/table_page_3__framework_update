<?php


// echo json_encode($data["services"], JSON_PRETTY_PRINT);
// if (!empty($_POST)) {
//   // code...
//   header('Content-Type: application/json');
//   echo json_encode($_POST, JSON_PRETTY_PRINT);
//   exit;
// }

function ifpost($var){
  $post = $_POST;
  foreach ($var as $key => $value) {
    if (isset($post[$value])) {
      $post = $post[$value];
    }
  }
  if (is_string($post)) {
    return $post;
  } else {
    return false;
  }
}
?>

<br>

<div class="container">

  <?php if (!$data["submit_success"]): ?>

    <form action="" method="post" id="bhpackages_add_form">


      <div class="form-group">
        <label for="">customer name</label>
        <input type="text" name="name" class="form-control" value="<?php echo ifpost(array("name")); ?>">
      </div>
      <div class="form-group">
        <label for="">email</label>
        <input type="text" name="email" class="form-control" value="<?php echo ifpost(array("email")); ?>">
      </div>
      <div class="form-group">
        <label for="">date</label>
        <input type="date" name="date" class="form-control" value="<?php echo ifpost(array("date")); ?>">
      </div>
      <h5 style="">Services</h5>
      <?php foreach ($data["services"] as $key => $value): ?>
        <div class="card p-2 mb-2">
          <?php if (ifpost(array("services", $value['id'], "validation"))): ?>
            <?php if (ifpost(array("services", $value['id'], "validation")) == "yes"): ?>
              <div class="bg-success text-white card p-1 mb-2">
                These dates are available.
              </div>
            <?php else: ?>
              <div class="bg-danger text-white card p-1 mb-2">
                These dates are not available.
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <div class="row">
            <div class="col-md-4 ">
              <b>
                <?php echo $value["name"] ?>
              </b>
            </div>
            <div class="col-md-4">
              <div class="form-group m-0">
                <label for="">start date</label>
                <input type="date" name="services[<?php echo $value['id'] ?>][date]" class="form-control" value="<?php echo ifpost(array("services", $value['id'], "date")); ?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group m-0">
                <label for="">quantity (days)</label>
                <input type="number" name="services[<?php echo $value['id'] ?>][quantity]" class="form-control" value="<?php echo ifpost(array("services", $value['id'], "quantity")); ?>">
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <input type="submit" name="" value="Submit" class="btn btn-primary">
    </form>
  <?php else: ?>
    <div class="bg-success text-white card p-1 mb-2">
      Booking submitted!
    </div>

  <?php endif; ?>
</div>
