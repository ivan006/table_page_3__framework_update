<?php

$editable_rows = $data["tab_d"]["cols"]["editable"];
$readable_rows = $data["tab_d"]["cols"]["visible"];


$view_link_table = $data["tab_o"]["table"];
$view_link_id_key = "id";


// if (!isset($join)) {
//   $editable_rows = $data["tab_d"]["cols"]["editable"];
//   $readable_rows = $data["tab_d"]["cols"]["visible"];
//
//
//   $view_link_table = $data["tab_o"]["table"];
//   $view_link_id_key = "id";
// } else {
//
//
//   $editable_rows = $data["tab_d"]["cols"]["editable"];
//   $readable_rows = $join["rows"]["editable"];
//   $data["tab_o"]["data_endpoint"] = $join["data_endpoint"];
//
//   $lookup_table_names = $join["lookup"]["table_overview"];
//   $view_link_table = $join["table_overview"]["table"];
//   $view_link_id_key = $join["table_overview"]["foreign_key"];
// }
?>

<?php
if (isset($data["tab_o"]["type"])) {

  ?>
    <div class="row">
      <div class="col-md-12 mt-5">
        <?php
        if ($data["tab_o"]["type"] == "dedicated_items") {
          ?>
          <h3 class="text-center">
            <?php echo $data["tab_o"]["rel_name"] ?>
          </h3>
          <?php
        } else {
          ?>
          <h2 class="text-center">
            <?php echo $data["tab_o"]["rel_name"] ?>
          </h2>
          <?php
        }
        ?>
        <hr style="background-color: black; color: black; height: 1px;">
      </div>
    </div>
  <?php
}
?>
<div class="row">
  <div class="col-md-12 mt-2">
    <!-- Add Records Modal -->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#<?php echo $data["tab_o"]["rel_name_id"]; ?>_exampleModal">
      Add Records
    </button>

    <!-- Modal -->
    <div class="modal fade" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_exampleModalLabel">Add Records</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Add Records Form -->
            <form action="" method="post" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_form">
              <?php
              foreach ($editable_rows as $key => $value) {
                if ($key !== "id") {
                  ?>
                  <div class="form-group">
                    <label for=""><?php echo $key; ?></label>
                    <input type="<?php echo "text"; ?>" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_<?php echo $key; ?>" class="form-control">
                  </div>
                  <?php
                }
              }
              ?>
              <!-- <div class="form-group"> -->
              <!-- <label for="">Name</label> -->
              <!-- <input type="text" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_name" class="form-control"> -->
              <!-- </div> -->
              <!-- <div class="form-group"> -->
              <!-- <label for="">Event_children</label> -->
              <!-- <input type="event_children" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_event_children" class="form-control"> -->
              <!-- </div> -->
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_add">Add Records</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 mt-4">
    <div class="table-responsive">
      <table class="table" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_records">
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
<div class="modal fade" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_exampleModalLabel">Edit Record Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Edit Record Form -->
        <form action="" method="post" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_form">
          <input type="hidden" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_record_id" name="edit_record_id" value="">
          <?php
          foreach ($editable_rows as $key => $value) {
            if ($key !== "id") {
              if (!isset($value["rels"])) {

                ?>
                <div class="form-group">
                  <label for=""><?php echo $key; ?></label>
                  <input type="<?php echo "text"; ?>" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_<?php echo $key; ?>" class="form-control">
                </div>
                <?php

              } else {
                ?>
                <div class="form-group">
                  <label for=""><?php echo $key; ?></label>
                  <input type="<?php echo "text"; ?>" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_<?php echo $key; ?>" class="form-control  dropdown-toggle" data-toggle="dropdown" readonly>

                  <div class="dropdown-menu" style="width: calc(100% - 2em); padding: 1em;">

                    <div class="table-responsive">
                      <table class="table" id="<?php echo $data["tab_o"]["rel_name_id"]."_lookup"; ?>_records" style="width : 100%">
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
                var state = [];

                function <?php echo $data["tab_o"]["rel_name_id"]."_lookup"; ?>_fetch(){
                  $.ajax({
                    url: "<?php echo base_url(); ?>api/table/t/<?php echo $value["rels"]["table"]; ?>/fetch",
                    type: "post",
                    dataType: "json",
                    success: function(data){
                      if (data.responce == "success") {

                        var i = "1";
                        var <?php echo $data["tab_o"]["rel_name_id"]."_lookup" ?> = $('#<?php echo $data["tab_o"]["rel_name_id"]."_lookup"; ?>_records').DataTable( {
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

                          var lookup_input = $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_<?php echo $key; ?>");
                          <?php echo $data["tab_o"]["rel_name_id"]."_lookup" ?>
                          .on( 'select', function ( e, dt, type, indexes ) {
                            // alert(123);
                            var rowData = <?php echo $data["tab_o"]["rel_name_id"]."_lookup" ?>.rows( indexes ).data().toArray();
                            // alert(JSON.stringify( rowData ));

                            lookup_input.val(rowData[0].id);
                          } )
                          .on( 'deselect', function ( e, dt, type, indexes ) {
                            // rel_name_id_edit_value
                            // var rowData = <?php echo $data["tab_o"]["rel_name_id"]."_lookup" ?>.rows( indexes ).data().toArray();

                            // alert(state["<?php echo $data["tab_o"]["rel_name_id"]."_edit_value" ?>"]);
                            // alert("<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_<?php echo $key; ?>");
                            lookup_input.val(state["<?php echo $data["tab_o"]["rel_name_id"]."_edit_value" ?>"]);
                          } );
                        }else{
                          toastr["error"](data.message);
                        }

                      }
                    });

                  }




                  <?php echo $data["tab_o"]["rel_name_id"]."_lookup"; ?>_fetch();



                </script>
                <?php
              }
            }
          }
          ?>
          <!-- <div class="form-group">
            <label for="">Name</label>
            <input type="text" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_name" class="form-control">
          </div>
          <div class="form-group">
            <label for="">Event_children</label>
            <input type="event_children" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_event_children" class="form-control">
          </div> -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_update">Update</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Records -->
<script>
  $(document).on("click", "#<?php echo $data["tab_o"]["rel_name_id"]; ?>_add", function(e){
    e.preventDefault();

    <?php
    foreach ($editable_rows as $key => $value) {
      if ($key !== "id") {
        ?>
        var <?php echo $key; ?> = $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_<?php echo $key; ?>").val();
        <?php
      }
    }
    ?>
    // var name = $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_name").val();
    // var event_children = $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_event_children").val();

    // if (name == "")
    if (1 !== 1) {
      alert("Both field is required");
    }else{
      $.ajax({
        url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["tab_o"]["table"]; ?>/insert",
        type: "post",
        dataType: "json",
        data: {
          <?php
          foreach ($editable_rows as $key => $value) {
            if ($key !== "id") {
              ?>
              <?php echo $key; ?>: <?php echo $key; ?>,
              <?php
            }
          }
          ?>
          // name: name,
          // event_children: event_children
        },
        success: function(data){
          if (data.responce == "success") {
            $('#<?php echo $data["tab_o"]["rel_name_id"]; ?>_records').DataTable().destroy();
            <?php echo $data["tab_o"]["table"]; ?>_fetch();
            $('#<?php echo $data["tab_o"]["rel_name_id"]; ?>_exampleModal').modal('hide');
            toastr["success"](data.message);
          }else{
            toastr["error"](data.message);
          }

        }
      });

      $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_form")[0].reset();

    }

  });

  // Fetch Records

  function <?php echo $data["tab_o"]["table"]; ?>_fetch(){
    $.ajax({
      url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["tab_o"]["table"]; ?>/<?php echo $data["tab_o"]["data_endpoint"]; ?>",
      type: "post",
      dataType: "json",
      success: function(data){
        if (data.responce == "success") {

          var i = "1";
          $('#<?php echo $data["tab_o"]["rel_name_id"]; ?>_records').DataTable( {
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
              <a href="#" value="${row.id}" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_del" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
              <a href="#" value="${row.id}" id="<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
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

  <?php echo $data["tab_o"]["table"]; ?>_fetch();

  // Delete Record

  $(document).on("click", "#<?php echo $data["tab_o"]["rel_name_id"]; ?>_del", function(e){
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
          url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["tab_o"]["table"]; ?>/delete",
          type: "post",
          dataType: "json",
          data: {
            del_id: del_id
          },
          success: function(data){
            if (data.responce == "success") {
              $('#<?php echo $data["tab_o"]["rel_name_id"]; ?>_records').DataTable().destroy();
              <?php echo $data["tab_o"]["table"]; ?>_fetch();
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

  $(document).on("click", "#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit", function(e){
    e.preventDefault();

    var edit_id = $(this).attr("value");



    $.ajax({
      url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["tab_o"]["table"]; ?>/edit",
      type: "post",
      dataType: "json",
      data: {
        edit_id: edit_id
      },
      success: function(data){
        if (data.responce == "success") {
          $('#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_modal').modal('show');
          $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_record_id").val(data.post.id);
          <?php
          foreach ($editable_rows as $key => $value) {
            if ($key !== "id") {
              ?>
              var rel_name_id_edit = $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_<?php echo $key; ?>");
              state["<?php echo $data["tab_o"]["rel_name_id"]."_edit_value" ?>"] = data.post.<?php echo $key; ?>;

              rel_name_id_edit.val(state["<?php echo $data["tab_o"]["rel_name_id"]."_edit_value" ?>"]);
              // alert(state["<?php echo $data["tab_o"]["rel_name_id"]."_edit_value" ?>"]);


              <?php
            }
          }
          ?>
          // $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_name").val(data.post.name);
          // $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_event_children").val(data.post.event_children);
        }else{
          toastr["error"](data.message);
        }
      }
    });

  });

  // Update Record

  $(document).on("click", "#<?php echo $data["tab_o"]["rel_name_id"]; ?>_update", function(e){
    e.preventDefault();

    var edit_record_id = $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_record_id").val();
    <?php
    foreach ($editable_rows as $key => $value) {
      if ($key !== "id") {
        ?>
        var edit_<?php echo $key; ?> = $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_<?php echo $key; ?>").val();
        <?php
      }
    }
    ?>

    // var edit_name = $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_name").val();
    // var edit_event_children = $("#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_event_children").val();

    // if (edit_record_id == "" || edit_name == "")
    if (1 !== 1) {
      alert("Both field is required");
    }else{
      $.ajax({
        url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["tab_o"]["table"]; ?>/update",
        type: "post",
        dataType: "json",
        data: {
          edit_record_id: edit_record_id,
          <?php
          foreach ($editable_rows as $key => $value) {
            if ($key !== "id") {
              ?>
              edit_<?php echo $key; ?>: edit_<?php echo $key; ?>,
              <?php
            }
          }
          ?>
          // edit_name: edit_name,
          // edit_event_children: edit_event_children
        },
        success: function(data){
          if (data.responce == "success") {
            $('#<?php echo $data["tab_o"]["rel_name_id"]; ?>_records').DataTable().destroy();
            <?php echo $data["tab_o"]["table"]; ?>_fetch();
            $('#<?php echo $data["tab_o"]["rel_name_id"]; ?>_edit_modal').modal('hide');
            toastr["success"](data.message);
          }else{
            toastr["error"](data.message);
          }
        }
      });

    }

  });
</script>
