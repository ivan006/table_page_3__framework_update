<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Toastr -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css"/>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Toastr -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/js/all.min.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

    <!-- Sweet Alert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <title><?php echo $data["title"]; ?></title>

    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo asset_url(); ?>fav/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo asset_url(); ?>fav/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo asset_url(); ?>fav/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo asset_url(); ?>fav/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo asset_url(); ?>fav/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo asset_url(); ?>fav/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo asset_url(); ?>fav/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo asset_url(); ?>fav/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo asset_url(); ?>fav/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo asset_url(); ?>fav/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo asset_url(); ?>fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo asset_url(); ?>fav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo asset_url(); ?>fav/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


  </head>
  <body>
    <script type="text/javascript">
      var state = [];
    </script>
    <div class="container">
      <div class="row">
        <div class="col-md-4 mt-5">
          <a href="/database" class="btn btn-sm btn-outline-primary">
            Database
          </a>
        </div>
        <div class="col-md-4 mt-5">
          <h1 class="text-center">
            <?php echo $data["title"]; ?>
          </h1>
        </div>
        <div class="col-md-4 mt-5">

          <?php if ($type == "g_record_core_abilities"): ?>
            <?php if (isset($data["record_links"])): ?>
              <?php foreach ($data["record_links"] as $key => $value): ?>
                <?php
                $redirect = urlencode(
                  "/".ltrim(
                    $_SERVER['PHP_SELF'],
                    "/index.php"
                  )
                );
                ?>
                <a href="<?php echo $value.$data["g_core_abilities"]["g_identity"]["g_where_needle"] ?>?redirect=<?php echo $redirect ?>" class="btn btn-sm btn-outline-primary">
                  <?php echo $key ?>
                </a>
              <?php endforeach; ?>


            <?php endif; ?>
          <?php else: ?>
            <?php if (isset($data["table_links"])): ?>
              <?php foreach ($data["table_links"] as $key => $value): ?>
                <?php
                $redirect = urlencode(
                  "/".ltrim(
                    $_SERVER['PHP_SELF'],
                    "/index.php"
                  )
                );
                ?>
                <a href="<?php echo $value ?>?redirect=<?php echo $redirect ?>" class="btn btn-sm btn-outline-primary">
                  <?php echo $key ?>
                </a>
              <?php endforeach; ?>


            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <hr style="background-color: black; color: black; height: 1px;">
        </div>
      </div>
