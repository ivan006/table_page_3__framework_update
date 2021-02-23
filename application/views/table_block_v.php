<?php

if(!function_exists('makeSafeForCSS')){
    function makeSafeForCSS($string) {
      //Lower case everything
      $string = strtolower($string);
      //Make alphanumeric (removes all other characters)
      $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
      //Clean up multiple dashes or whitespaces
      $string = preg_replace("/[\s-]+/", " ", $string);
      //Convert whitespaces and underscore to dash
      // $string = preg_replace("/[\s_]/", "-", $string);
      $string = preg_replace("/[\s_]/", "_", $string);
      return $string;
    }
}

$editable_rows = $data["tab_d"]["cols"]["editable"];
$readable_rows = $data["tab_d"]["cols"]["visible"];


$view_link_table = $data["g_identity"]["table"];
$view_link_id_key = "id";

$hide_toggle = "";
if ($owner_group_options["assumed"] == "yes") {
  $hide_toggle = "display:none;";
}


// if (!isset($join)) {
//   $editable_rows = $data["tab_d"]["cols"]["editable"];
//   $readable_rows = $data["tab_d"]["cols"]["visible"];
//
//
//   $view_link_table = $data["g_identity"]["table"];
//   $view_link_id_key = "id";
// } else {
//
//
//   $editable_rows = $data["tab_d"]["cols"]["editable"];
//   $readable_rows = $join["rows"]["editable"];
//   $data["g_identity"]["data_endpoint"] = $join["data_endpoint"];
//
//   $lookup_table_names = $join["lookup"]["table_overview"];
//   $view_link_table = $join["table_overview"]["table"];
//   $view_link_id_key = $join["table_overview"]["foreign_key"];
// }
?>

<?php
if (isset($data["g_identity"]["type"])) {

  ?>
    <div class="row">
      <div class="col-md-12 mt-5">
        <?php
        if ($data["g_identity"]["type"] == "sub_items") {
          ?>
          <h3 class="text-center">
            <?php echo $data["g_identity"]["rel_name"] ?>
          </h3>
          <hr style="background-color: black; color: black; height: 1px;">
          <?php
        }
        elseif ($data["g_identity"]["type"] == "overview") {
          ?>
          <h2 class="text-center">
            <?php echo $data["g_identity"]["rel_name"] ?>
          </h2>
          <hr style="background-color: black; color: black; height: 1px;">
          <?php
        }
        // elseif ($data["g_identity"]["type"] == "table") {
        //
        // }
        ?>
      </div>
    </div>
  <?php
}
?>

<div class="row">
  <div class="col-md-12 mt-2">
    <!-- Add Records Modal -->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_exampleModal">
      Add Records
    </button>

    <!-- Modal -->
    <div class="modal fade" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Records</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Add Records Form -->
            <form action="" method="post" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_form">

              <?php
              $action_type = "add";
              ?>

              <h5 style="<?php echo $hide_toggle ?>">Variables</h5>
              <?php
              foreach ($editable_rows as $key => $value) {
                if ($key !== "id") {
                  if (isset($value["assumable"])) {

                    ?>
                    <div class="form-group" style="display: none;">
                      <label for=""><?php echo $key; ?></label>
                      <input type="<?php echo "text"; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control">
                    </div>
                    <?php
                  }
                  elseif (isset($value["rels"])) {

                      ?>
                      <div class="form-group">
                        <label for=""><?php echo $key; ?></label>
                        <input type="<?php echo "text"; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control  dropdown-toggle" data-toggle="dropdown" >
                        <!-- <input type="<?php echo "text"; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control  dropdown-toggle" data-toggle="dropdown" readonly> -->

                        <div class="dropdown-menu" style="width: calc(100% - 2em); padding: 1em;">

                          <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup"."_".$action_type."_".makeSafeForCSS($key); ?>records" style="width : 100%">
                              <thead>
                                <tr>
                                  <!-- <th>ID</th> -->
                                  <?php
                                  foreach ($value["rels"]["rows"] as $key_2 => $value_2) {
                                    ?>
                                    <th><?php echo $key_2; ?></th>
                                    <?php
                                  }
                                  ?>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>

                      <script type="text/javascript">


                      function <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup"; ?>_fetch(){
                        $.ajax({
                          url: "<?php echo base_url(); ?>api/table/t/<?php echo $value["rels"]["table"]; ?>/fetch",
                          type: "post",
                          dataType: "json",
                          success: function(data){
                            if (data.responce == "success") {

                              var i = "1";
                              var <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup" ?> = $('#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup"."_".$action_type."_".makeSafeForCSS($key); ?>records').DataTable( {
                                "select": true,
                                "data": data.posts,
                                "responsive": true,
                                dom:
                                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                                buttons: [
                                  // 'copy', 'excel', 'pdf'
                                  ],
                                  "columns": [
                                  // { "render": function(){
                                  //   return a = i++;
                                  // } },
                                  <?php
                                  foreach ($value["rels"]["rows"] as $key_2 => $value_2) {
                                    // if ($key !== "id") {
                                    ?>
                                    { "data": "<?php echo $key_2; ?>" },
                                    <?php
                                    // }
                                  }
                                  ?>
                                  // { "data": "table_overview" },
                                  // { "data": "event_children" },

                                  ]
                                } );

                                var lookup_input = $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>");
                                <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup" ?>
                                .on( 'select', function ( e, dt, type, indexes ) {
                                  // alert(123);
                                  var rowData = <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup" ?>.rows( indexes ).data().toArray();
                                  // alert(JSON.stringify( rowData ));

                                  lookup_input.val(rowData[0].id);
                                } )
                                .on( 'deselect', function ( e, dt, type, indexes ) {

                                  // var rowData = <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup" ?>.rows( indexes ).data().toArray();

                                  // alert(state["<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]);
                                  // alert("<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>");
                                  lookup_input.val(state["<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]);
                                } );
                              }else{
                                toastr["error"](data.message);
                              }

                            }
                          });

                        }




                        <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup"; ?>_fetch();



                      </script>
                      <?php

                  }
                  else {

                    ?>
                    <div class="form-group">
                      <label for=""><?php echo $key; ?></label>
                      <input type="<?php echo "text"; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control">
                    </div>
                    <?php

                  }
                }
              }

              ?>
              <h5 style="<?php echo $hide_toggle ?>">Owner group</h5>
              <div class="form-group">
                <!-- <label for="">Owner group</label> -->
                <select class="form-control" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS("owner_group"); ?>" style="<?php echo $hide_toggle ?>">
                  <?php
                  foreach ($owner_group_options["options"] as $key => $value) {
                    ?>
                    <option value="<?php echo $value["id"] ?>"><?php echo $value["indent"] ?> <?php echo $value["name"] ?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <?php
              ?>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_add">Add Records</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="row">
  <div class="col-md-12 mt-4">
    <div class="table-responsive">
      <table class="table" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_records">
        <thead>
          <tr>
            <!-- <th>ID</th> -->
            <?php
            foreach ($readable_rows as $key => $value) {
              // if ($key !== "id") {
                ?>
                <th><?php echo $key; ?></th>
                <?php
              // }
            }
            ?>
            <!-- <th>Name</th> -->
            <!-- <th>Event_children</th> -->
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>




<!-- Edit Record Modal -->
<div class="modal fade" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_exampleModalLabel">Edit Record Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Edit Record Form -->
        <?php
        $action_type = "edit";
        ?>
        <form action="" method="post" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_" ?>form">
          <h5 style="<?php echo $hide_toggle ?>">Variables</h5>
          <input type="hidden" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_" ?>record_id" name="edit_record_id" value="">
          <?php
          foreach ($editable_rows as $key => $value) {
            if ($key !== "id") {
              if (isset($value["assumable"])) {

                ?>
                <div class="form-group" style="display: none;">
                  <label for=""><?php echo $key; ?></label>
                  <input type="<?php echo "text"; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control">
                </div>
                <?php
              }
              elseif (isset($value["rels"])) {

                  ?>
                  <div class="form-group">
                    <label for=""><?php echo $key; ?></label>
                    <input type="<?php echo "text"; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control  dropdown-toggle" data-toggle="dropdown" >
                    <!-- <input type="<?php echo "text"; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control  dropdown-toggle" data-toggle="dropdown" readonly> -->

                    <div class="dropdown-menu" style="width: calc(100% - 2em); padding: 1em;">

                      <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup"."_".$action_type."_".makeSafeForCSS($key); ?>records" style="width : 100%">
                          <thead>
                            <tr>
                              <!-- <th>ID</th> -->
                              <?php
                              foreach ($value["rels"]["rows"] as $key_2 => $value_2) {
                                ?>
                                <th><?php echo $key_2; ?></th>
                                <?php
                              }
                              ?>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>

                  <script type="text/javascript">


                  function <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup"; ?>_fetch(){
                    $.ajax({
                      url: "<?php echo base_url(); ?>api/table/t/<?php echo $value["rels"]["table"]; ?>/fetch",
                      type: "post",
                      dataType: "json",
                      success: function(data){
                        if (data.responce == "success") {

                          var i = "1";
                          var <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup" ?> = $('#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup"."_".$action_type."_".makeSafeForCSS($key); ?>records').DataTable( {
                            "select": true,
                            "data": data.posts,
                            "responsive": true,
                            dom:
                            "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                            buttons: [
                              // 'copy', 'excel', 'pdf'
                              ],
                              "columns": [
                              // { "render": function(){
                              //   return a = i++;
                              // } },
                              <?php
                              foreach ($value["rels"]["rows"] as $key_2 => $value_2) {
                                // if ($key !== "id") {
                                ?>
                                { "data": "<?php echo $key_2; ?>" },
                                <?php
                                // }
                              }
                              ?>
                              // { "data": "table_overview" },
                              // { "data": "event_children" },

                              ]
                            } );

                            var lookup_input = $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>");
                            <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup" ?>
                            .on( 'select', function ( e, dt, type, indexes ) {
                              // alert(123);
                              var rowData = <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup" ?>.rows( indexes ).data().toArray();
                              // alert(JSON.stringify( rowData ));

                              lookup_input.val(rowData[0].id);
                            } )
                            .on( 'deselect', function ( e, dt, type, indexes ) {

                              lookup_input.val(state["<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]);
                            } );
                          }else{
                            toastr["error"](data.message);
                          }

                        }
                      });

                    }




                    <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_lookup"; ?>_fetch();



                  </script>
                  <?php

              }
              else {

                ?>
                <div class="form-group">
                  <label for=""><?php echo $key; ?></label>
                  <input type="<?php echo "text"; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control">
                </div>
                <?php

              }
            }
          }

          ?>
          <h5 style="<?php echo $hide_toggle ?>">Owner group</h5>
          <div class="form-group">
            <!-- <label for="">Owner group</label> -->
            <select class="form-control" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS("owner_group"); ?>" style="<?php echo $hide_toggle ?>">
              <?php
              foreach ($owner_group_options["options"] as $key => $value) {
                ?>
                <option value="<?php echo $value["id"] ?>"><?php echo $value["indent"] ?> <?php echo $value["name"] ?></option>
                <?php
              }
              ?>
            </select>
          </div>
          <?php
          ?>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_update">Update</button>
      </div>
    </div>
  </div>
</div>


<script>


<?php
$action_type = "add";
?>
  $(document).on("click", "#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_add", function(e){
    e.preventDefault();

    <?php
    foreach ($editable_rows as $key => $value) {
      if ($key !== "id") {
        ?>
        var <?php echo makeSafeForCSS($key); ?> = $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>").val();
        <?php
      }
    }
    ?>
    var edit_<?php echo "owner_group"; ?> = $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS("owner_group"); ?>").val();
    <?php

    ?>
    // var name = $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_name").val();
    // var event_children = $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_event_children").val();

    // if (name == "")
    if (1 !== 1) {
      alert("Both field is required");
    }else{
      $.ajax({
        url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["g_identity"]["table"]; ?>/insert",
        type: "post",
        dataType: "json",
        data: {
          <?php
          foreach ($editable_rows as $key => $value) {


            if ($key !== "id") {
              if (isset($value["assumable"])) {
                ?>
                "<?php echo urlencode($key); ?>": <?php echo $value["assumable"]; ?>,

                <?php
              }
              else {
                ?>
                "<?php echo urlencode($key); ?>": <?php echo makeSafeForCSS($key); ?>,

                <?php
              }
            }
          }
          ?>
          // name: name,
          // event_children: event_children
        },
        success: function(data){
          if (data.responce == "success") {
            $('#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_records').DataTable().destroy();
            <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_fetch();
            $('#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_exampleModal').modal('hide');
            toastr["success"](data.message);
          }else{
            toastr["error"](data.message);
          }

        }
      });

      $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_form")[0].reset();

    }

  });

  // Fetch Records

  function <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_fetch(){
    $.ajax({
      url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["g_identity"]["table"]; ?>/<?php echo $data["g_identity"]["data_endpoint"]; ?>",
      type: "post",
      dataType: "json",
      success: function(data){
        if (data.responce == "success") {

          var i = "1";
          $('#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_records').DataTable( {
            "data": data.posts,
            "responsive": true,
            dom:
            "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
            'copy', 'excel', 'pdf'
            ],
            "columns": [
            // { "render": function(){
            //   return a = i++;
            // } },
            <?php
            foreach ($readable_rows as $key => $value) {
              // if ($key !== "id") {
                ?>
                { "data": "<?php echo $key; ?>" },
                <?php
              // }
            }
            ?>
            // { "data": "table_overview" },
            // { "data": "event_children" },
            { "render": function ( data, type, row, meta ) {
              var a = `
              <a href="#" value="${row.id}" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_del" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
              <a href="#" value="${row.id}" id="<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_edit" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
              <a href="/record/t/<?php echo $view_link_table; ?>/r/${row.<?php echo $view_link_id_key; ?>}" class="btn btn-sm btn-outline-primary">View</a>
              `;

              // <a href="/record/t/<?php echo 123; ?>/r/${row.<?php echo 123; ?>}" class="btn btn-sm btn-outline-primary">View</a>
              return a;
            } }
            ]
          } );
        }else{
          toastr["error"](data.message);
        }

      }
    });

  }

  <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_fetch();

  // Delete Record

  $(document).on("click", "#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_del", function(e){
    e.preventDefault();

    var del_id = $(this).attr("value");

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger mr-2'
      },
      buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then((result) => {
      if (result.value) {

        $.ajax({
          url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["g_identity"]["table"]; ?>/delete",
          type: "post",
          dataType: "json",
          data: {
            del_id: del_id
          },
          success: function(data){
            if (data.responce == "success") {
              $('#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_records').DataTable().destroy();
              <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_fetch();
              swalWithBootstrapButtons.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
              );
            }else{
              swalWithBootstrapButtons.fire(
              'Cancelled',
              'Your imaginary file is safe :)',
              'error'
              );
            }

          }
        });



      } else if (
      /* Read more about handling dismissals below */
      result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire(
        'Cancelled',
        'Your imaginary file is safe :)',
        'error'
        )
      }
    });

  });

  // Edit Record


  <?php
  $action_type = "edit";
  ?>
  $(document).on("click", "#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_edit", function(e){
    e.preventDefault();

    var edit_id = $(this).attr("value");



    $.ajax({
      url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["g_identity"]["table"]; ?>/edit",
      type: "post",
      dataType: "json",
      data: {
        edit_id: edit_id
      },
      success: function(data){
        if (data.responce == "success") {
          $('#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_" ?>modal').modal('show');
          $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_" ?>record_id").val(data.post.id);
          <?php
          foreach ($editable_rows as $key => $value) {
            ?>

            <?php
            if ($key !== "id") {
              ?>

              var rel_name_id_edit = $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>");

              <?php
              if (isset($value["assumable"])) {
                ?>

                state["<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"] = <?php echo $data["g_identity"]["record_id"] ?>;

                <?php
              }
              else {
                ?>

                state["<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"] = data.post["<?php echo $key; ?>"];

                <?php
              }
              ?>

              rel_name_id_edit.val(state["<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]);
              // alert(state["<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]);

              // alert(JSON.stringify(state["<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]));

              <?php
            }
          }
          ?>
        }else{
          toastr["error"](data.message);
        }
      }
    });

  });

  // Update Record

  <?php
  $action_type = "edit";
  ?>

  $(document).on("click", "#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_update", function(e){
    e.preventDefault();

    var edit_record_id = $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_" ?>record_id").val();
    <?php
    foreach ($editable_rows as $key => $value) {
      if ($key !== "id") {
        ?>
        var edit_<?php echo makeSafeForCSS($key); ?> = $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS($key); ?>").val();
        <?php
      }
    }
    ?>
    var edit_<?php echo "owner_group"; ?> = $("#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_".makeSafeForCSS("owner_group"); ?>").val();
    <?php
    ?>



    // if (edit_record_id == "" || edit_name == "")
    if (1 !== 1) {
      alert("Both field is required");
    }else{
      $.ajax({
        url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["g_identity"]["table"]; ?>/update",
        type: "post",
        dataType: "json",
        data: {
          edit_record_id: edit_record_id,
          <?php
          foreach ($editable_rows as $key => $value) {
            if ($key !== "id") {
              ?>
              edit_<?php echo makeSafeForCSS($key); ?>: edit_<?php echo makeSafeForCSS($key); ?>,
              <?php
            }
          }
          ?>
          // edit_name: edit_name,
          // edit_event_children: edit_event_children
        },
        success: function(data){
          if (data.responce == "success") {
            $('#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_records').DataTable().destroy();
            <?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"]); ?>_fetch();
            $('#<?php echo makeSafeForCSS($data["g_identity"]["rel_name_id"])."_".$action_type."_" ?>modal').modal('hide');
            toastr["success"](data.message);
          }else{
            toastr["error"](data.message);
          }
        }
      });

    }

  });
</script>
