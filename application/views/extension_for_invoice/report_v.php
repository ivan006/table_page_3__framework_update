<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body style="background:whitesmoke;">


  <div class="container card mt-5">
    <div class="row">
      <div class="col-md-4 mt-5">
        <a href="<?php echo $back ?>" class="btn btn-sm btn-outline-primary">
          Back
        </a>
      </div>
      <div class="col-md-4 mt-5">
        <h1 class="text-center">
          <?php echo $title; ?>
        </h1>
      </div>
      <div class="col-md-4 mt-5">

      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <hr style="background-color: black; color: black; height: 1px;">
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 mt-5">
        <h2 class="text-center">
          overview
        </h2>
        <hr style="background-color: black; color: black; height: 1px;">
      </div>
    </div>
    <table class="table">
      <tr>
        <?php if (isset($invoice[0])): ?>
          <?php foreach ($invoice[0] as $key => $value): ?>
            <th>
              <?php echo $key ?>
            </th>
          <?php endforeach; ?>
        <?php endif; ?>
      </tr>
      <?php foreach ($invoice as $key => $value): ?>
        <tr>
          <?php foreach ($value as $key2 => $value2): ?>
            <td>
              <?php echo $value2 ?>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </table>

    <div class="row">
      <div class="col-md-12 mt-5">
        <h2 class="text-center">
          invoiced transaction
        </h2>
        <hr style="background-color: black; color: black; height: 1px;">
      </div>
    </div>

    <table class="table">
      <tr>
        <?php if (isset($invoiced_transactions[0])): ?>
          <?php foreach ($invoiced_transactions[0] as $key => $value): ?>
            <th>
              <?php echo $key ?>
            </th>
          <?php endforeach; ?>
        <?php endif; ?>
      </tr>
      <?php foreach ($invoiced_transactions as $key => $value): ?>
        <tr>
          <?php foreach ($value as $key2 => $value2): ?>
            <td>
              <?php echo $value2 ?>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </table>

    </div>

  </body>
  </html>
