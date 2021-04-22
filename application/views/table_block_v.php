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

$editable_rows = $data["g_select"]["editable"];
$readable_rows = $data["g_select"]["visible"];


$view_link_table = $data["g_identity"]["g_from"];
$view_link_id_key = "id";

// $hide_toggle = "";
if ($permisssion_options["owner"]["assumed"] == "1") {
  // $hide_toggle = "display:none;";
}


// if (!isset($join)) {
//   $editable_rows = $data["g_select"]["editable"];
//   $readable_rows = $data["g_select"]["visible"];
//
//
//   $view_link_table = $data["g_identity"]["g_from"];
//   $view_link_id_key = "id";
// } else {
//
//
//   $editable_rows = $data["g_select"]["editable"];
//   $readable_rows = $join["rows"]["editable"];
//   $data["g_identity"]["data_endpoint"] = $join["data_endpoint"];
//
//   $lookup_table_names = $join["lookup"]["table_overview"];
//   $view_link_table = $join["table_overview"]["g_from"];
//   $view_link_id_key = $join["table_overview"]["foreign_key"];
// }
?>

<?php
if (isset($type)) {

  ?>
    <div class="row">
      <div class="col-md-12 mt-5">
        <?php
        if ($type == "g_record_parental_abilities") {
          ?>
          <h3 class="text-center">
            <?php echo $data["g_identity"]["g_ability_name"] ?>
          </h3>
          <hr style="background-color: black; color: black; height: 1px;">
          <?php
        }
        elseif ($type == "g_record_core_abilities") {
          ?>
          <h2 class="text-center">
            <?php echo $data["g_identity"]["g_ability_name"] ?>
          </h2>
          <hr style="background-color: black; color: black; height: 1px;">
          <?php
        }
        // elseif ($type == "g_table_core_abilities") {
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
    <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_add_modal">
      Add Records
    </button>

  </div>
</div>


<?php
$action_types = array(
  "add",
  "edit"
);
foreach ($action_types as $key => $value) {
  // code...
  $action_type = $value;
  ?>
  <div class="modal fade" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type; ?>_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo $action_type ?> Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_" ?>form">

            <h5 style="<?php //echo $hide_toggle ?>">Variables</h5>
            <?php
            if ($action_type == "edit") {
              ?>
              <input type="hidden" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_" ?>record_id" name="edit_record_id" value="">
              <?php
            }
            ?>
            <?php
            foreach ($editable_rows as $key => $value) {
              if ($value["col_deets"]["Type"] == "date") {
                $field_type = "date";
              } else {
                $field_type = "text";
              }
              if ($key !== "id") {
                if (isset($value["assumable"])) {

                  ?>
                  <div class="form-group" style="display: none;">
                    <label for=""><?php echo $key; ?></label>
                    <input type="<?php echo $field_type; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control">
                  </div>
                  <?php
                }
                elseif (isset($value["rels"])) {

                  ?>
                  <div class="form-group">
                    <label for=""><?php echo $key; ?></label>
                    <input type="<?php echo $field_type; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control  dropdown-toggle" data-toggle="dropdown" >
                    <!-- <input type="<?php echo $field_type; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control  dropdown-toggle" data-toggle="dropdown" readonly> -->

                    <div class="dropdown-menu" style="width: calc(100% - 2em); padding: 1em;">

                      <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_lookup"."_".$action_type."_".makeSafeForCSS($key); ?>records" style="width : 100%">
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


                    function <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_lookup"; ?>_fetch(){
                      $.ajax({
                        url: "<?php echo base_url(); ?>api/table/t/<?php echo $value["rels"]["table"]; ?>/fetch",
                        type: "post",
                        dataType: "json",
                        success: function(data){
                          if (data.responce == "success") {

                            var i = "1";
                            var <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_lookup" ?> = $('#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_lookup"."_".$action_type."_".makeSafeForCSS($key); ?>records').DataTable( {
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

                            var lookup_input = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key); ?>");
                            <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_lookup" ?>
                            .on( 'select', function ( e, dt, type, indexes ) {
                              // alert(123);
                              var rowData = <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_lookup" ?>.rows( indexes ).data().toArray();
                              // alert(JSON.stringify( rowData ));

                              lookup_input.val(rowData[0].id);
                            } )
                            .on( 'deselect', function ( e, dt, type, indexes ) {

                              // var rowData = <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_lookup" ?>.rows( indexes ).data().toArray();

                              // alert(state["<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]);
                              // alert("<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key); ?>");
                              lookup_input.val(state["<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]);
                            } );
                          }else{
                            toastr["error"](data.message);
                          }

                        }
                      });

                    }




                    <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_lookup"; ?>_fetch();



                  </script>
                  <?php

                }
                else {

                  ?>
                  <div class="form-group">
                    <label for=""><?php echo $key; ?></label>
                    <input type="<?php echo $field_type; ?>" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key); ?>" class="form-control">
                  </div>
                  <?php

                }
              }
            }


            $this->load->view('table_permissions_v', array(
            "permisssion_options"=>$permisssion_options,
            "action_type"=>$action_type,
            ));
            ?>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type; ?>">Submit</button>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>


<div class="row">
  <div class="col-md-12 mt-4">
    <div class="table-responsive">
      <table class="table" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_records">
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






<?php
$action_type = "add";

$this->load->view('table_scripts_add_v', array(
  "data"=>$data,
  "action_type"=>$action_type,
  // "permisssion_options"=>$permisssion_options,
  // "type"=>"g_record_core_abilities"
));
?>


<script>

  // Fetch Records

  function <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_fetch(){
    $.ajax({
      url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["g_identity"]["g_from"]; ?>/<?php echo $data["g_identity"]["data_endpoint"]; ?>",
      type: "post",
      dataType: "json",
      success: function(data){
        if (data.responce == "success") {

          var i = "1";
          $('#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_records').DataTable( {
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
              <a href="#" value="${row.id}" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_del" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
              <a href="#" value="${row.id}" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_edit_model" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
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

  <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_fetch();

  // Delete Record

  $(document).on("click", "#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_del", function(e){
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
          url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["g_identity"]["g_from"]; ?>/delete",
          type: "post",
          dataType: "json",
          data: {
            del_id: del_id
          },
          success: function(data){
            if (data.responce == "success") {
              $('#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_records').DataTable().destroy();
              <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_fetch();
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




</script>
<?php
// Edit Record
$action_type = "edit";

$this->load->view('table_scripts_edit_v', array(
  "data"=>$data,
  "action_type"=>$action_type,
  // "permisssion_options"=>$permisssion_options,
  // "type"=>"g_record_core_abilities"
));
?>


<?php

// Update Record

$action_type = "edit";





$this->load->view('table_scripts_update_v', array(
  "data"=>$data,
  "action_type"=>$action_type,
  // "permisssion_options"=>$permisssion_options,
  // "type"=>"g_record_core_abilities"
));
?>
