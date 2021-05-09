
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
            // $value_1["dates"] = array_chunk($value_1["dates"],16,true);
            $value_1["dates"] = $value_1["dates"];


        		// header('Content-Type: application/json');
        		// echo json_encode($value_1["dates"], JSON_PRETTY_PRINT);
        		// exit;
            ?>
            <div id="menu<?php echo $key ?>-<?php echo $key_1 ?>" class="container tab-pane <?php echo $active ?>"><br>
              <div class="row">

                <?php //foreach ($value_1["dates"] as $key_2 => $value_2): ?>
                <?php //endforeach; ?>
                <!-- <div class="col-6"> -->
                <?php
                $first_index = $value_1["dates"];
                reset($first_index);
                $first_index = key($first_index);
                // $first_index;
                $filler_days = date_format(date_create($first_index),"N") - 1;
                $filler_days = array_fill(0,$filler_days,"");

                ?>

                <style media="screen">
                  .opacity-3 {
                    opacity:0.6!important;
                  }
                </style>
                <?php foreach ($filler_days as $key_3 => $value_3): ?>
                  <div style="flex: 0 0 14.285%;max-width: 14.285%;" class="bg-white">

                  </div>

                <?php endforeach; ?>
                <?php foreach ($value_1["dates"] as $key_3 => $value_3): ?>
                  <?php
                  if ($value_3 == "unavail") {
                    // $colors = "bg-success text-white opacity-3";
                    $colors = "bg-secondary text-white";
                    $booked = " (Booked)";
                  } else {
                    // $colors = "bg-success text-white";
                    $colors = "bg-light text-dark";
                    $booked = "";
                  }
                  ?>
                  <div style="flex: 0 0 14.285%;max-width: 14.285%;" class="<?php echo $colors ?> p-1">
                    <!-- <div class="card <?php echo $colors ?>" style="padding: 0 5px 0 5px; margin-bottom: 3px;"> -->
                    <?php
                    // $date_pretty = date_format(date_create($key_3),"d (D)")
                    $date_pretty = date_format(date_create($key_3),"d")
                    // date('N', strtotime('Monday'));
                    ?>
                    <?php echo $date_pretty ?>
                    <?php //echo $booked ?>
                    <!-- </div> -->
                  </div>

                <?php endforeach; ?>
                <!-- </div> -->
              </div>

            </div>
          <?php endforeach; ?>
        </div>

      </div>


    <?php endforeach; ?>
  </div>
</div>
