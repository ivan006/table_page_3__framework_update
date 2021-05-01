<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<br>

<div class="container">
  <?php


  // echo json_encode($data, JSON_PRETTY_PRINT);

  ?>

  <ul class="nav nav-tabs" role="tablist">
    <?php foreach ($data as $key => $value): ?>


      <?php
      if ($key == 0) {
        $active = "active";
      } else {
        $active = "";
      }
      ?>

      <li class="nav-item">
        <a class="nav-link <?php echo $active ?>" data-toggle="tab" href="#menu<?php echo $key ?>">
          <?php echo $value["name"] ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>

  <div class="tab-content">

    <?php foreach ($data as $key => $value): ?>
      <?php
      if ($key == 0) {
        $active = "active";
      } else {
        $active = "";
      }
      ?>
      <div id="menu<?php echo $key ?>" class="container tab-pane <?php echo $active ?>"><br>


        <br>
        <ul class="nav nav-tabs" role="tablist">
          <?php foreach ($value["months"] as $key_1 => $value_1): ?>
            <?php
            if ($key_1 == 0) {
              $active = "active";
            } else {
              $active = "";
            }
            ?>

            <li class="nav-item">
              <a class="nav-link <?php echo $active ?>" data-toggle="tab" href="#menu<?php echo $key ?>-<?php echo $key_1 ?>">
                <?php echo $value_1["title"] ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <?php foreach ($value["months"] as $key_1 => $value_1): ?>
            <?php
            if ($key_1 == 0) {
              $active = "active";
            } else {
              $active = "";
            }
            $value_1["dates"] = array_chunk($value_1["dates"],16);
            ?>
            <div id="menu<?php echo $key ?>-<?php echo $key_1 ?>" class="container tab-pane <?php echo $active ?>"><br>
              <div class="row">

                <?php foreach ($value_1["dates"] as $key_2 => $value_2): ?>
                  <div class="col-6">

                    <?php foreach ($value_2 as $key_3 => $value_3): ?>
                      <div class="card" style="padding: 0 5px 0 5px; margin-bottom: 3px;"><?php echo $value_3 ?></div>

                    <?php endforeach; ?>
                  </div>
                <?php endforeach; ?>
              </div>

            </div>
          <?php endforeach; ?>
        </div>

      </div>


    <?php endforeach; ?>
  </div>
</div>

</body>
</html>
