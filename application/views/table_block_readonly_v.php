

<?php

$readable_rows = $rows["visible"];
?>


<div class="row">
  <div class="col-md-12 mt-4">
    <div class="table-responsive">
      <table class="table" id="<?php echo $overview["table_id"]; ?>_records">
        <thead>
          <tr>
            <th>ID</th>
            <?php
            foreach ($readable_rows as $key => $value) {
              if ($key !== "id") {
                ?>
                <th><?php echo $key; ?></th>
                <?php
              }
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




<script>


  // Fetch Records

  function <?php echo $overview["table_id"]; ?>_fetch(){
    $.ajax({
      url: "<?php echo base_url(); ?><?php echo $data_endpoint; ?>",
      type: "post",
      dataType: "json",
      success: function(data){
        if (data.responce == "success") {

          var i = "1";
          $('#<?php echo $overview["table_id"]; ?>_records').DataTable( {
            "data": data.posts,
            // "responsive": true,
            dom:
            "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
            'copy', 'excel', 'pdf'
            ],
            "columns": [
            { "render": function(){
              return a = i++;
            } },
            <?php
            foreach ($readable_rows as $key => $value) {
              if ($key !== "id") {
                ?>
                { "data": "<?php echo $key; ?>" },
                <?php
              }
            }
            ?>
            // { "data": "name" },
            // { "data": "event_children" },
            { "render": function ( data, type, row, meta ) {
              var a = `
              <a href="/table_page/table/t/${row.name}" class="btn btn-sm btn-outline-primary">View</a>
              `;
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

  <?php echo $overview["table_id"]; ?>_fetch();


</script>
