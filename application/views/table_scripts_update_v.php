<?php
$editable_rows = $data["g_select"]["editable"];
$readable_rows = $data["g_select"]["visible"];
?>
<script type="text/javascript">

$(document).on("click", "#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_update", function(e){
  e.preventDefault();

  var edit_record_id = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_" ?>record_id").val();
  <?php
  foreach ($editable_rows as $key => $value) {
    if ($key !== "id") {
      ?>
      var edit_<?php echo makeSafeForCSS($key); ?> = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key); ?>").val();
      <?php
    }
  }
  ?>
  var edit_permisssions_owner = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_"."permisssions_owner"; ?>").val();
  var edit_permisssions_editability = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_"."permisssions_editability"; ?>").val();
  var edit_permisssions_visibility = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_"."permisssions_visibility"; ?>").val();
  <?php
  ?>



  // if (edit_record_id == "" || edit_name == "")
  if (1 !== 1) {
    alert("Both field is required");
  }else{
    $.ajax({
      url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["g_identity"]["g_from"]; ?>/update",
      type: "post",
      dataType: "json",
      data: {
        variables: {
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
        permissions: {
          edit_permisssions_owner: edit_permisssions_owner,
          edit_permisssions_editability: edit_permisssions_editability,
          edit_permisssions_visibility: edit_permisssions_visibility
        }
      },
      success: function(data){
        if (data.responce == "success") {
          $('#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_records').DataTable().destroy();
          <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_fetch();
          $('#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_" ?>modal').modal('hide');
          toastr["success"](data.message);
        }else{
          toastr["error"](data.message);
        }
      }
    });

  }

})

</script>
