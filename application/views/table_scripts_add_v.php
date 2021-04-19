<?php
$editable_rows = $data["g_select"]["editable"];
$readable_rows = $data["g_select"]["visible"];
?>
<script type="text/javascript">

$(document).on("click", "#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_add", function(e){
  e.preventDefault();

  <?php
  foreach ($editable_rows as $key => $value) {
    if ($key !== "id") {
      ?>
      var <?php echo makeSafeForCSS($key); ?> = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key); ?>").val();
      <?php
    }
  }
  ?>
  var edit_permissions_owner = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_"."permissions_owner"; ?>").val();
  var edit_permissions_editability = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_"."permissions_editability"; ?>").val();
  var edit_permissions_visibility = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_"."permissions_visibility"; ?>").val();
  <?php

  ?>
  // var name = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_name").val();
  // var event_children = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_event_children").val();

  // if (name == "")
  if (1 !== 1) {
    alert("Both field is required");
  }else{
    $.ajax({
      url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["g_identity"]["g_from"]; ?>/insert",
      type: "post",
      dataType: "json",
      data: {
        variables: {
          <?php
          foreach ($editable_rows as $key => $value) {


            if ($key !== "id") {
              if (isset($value["assumable"])) {
                ?>
                "<?php echo makeSafeForCSS($key); ?>": <?php echo $value["assumable"]; ?>,

                <?php
              }
              else {
                ?>
                "<?php echo makeSafeForCSS($key); ?>": <?php echo makeSafeForCSS($key); ?>,

                <?php
              }
            }
          }
          ?>
          // name: name,
          // event_children: event_children
        },
        permissions: {
          edit_permissions_owner: edit_permissions_owner,
          edit_permissions_editability: edit_permissions_editability,
          edit_permissions_visibility: edit_permissions_visibility
        }
      },
      success: function(data){
        if (data.responce == "success") {
          $('#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_records').DataTable().destroy();
          <?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_fetch();
          $('#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_exampleModal').modal('hide');
          toastr["success"](data.message);
        }else{
          toastr["error"](data.message);
        }

      }
    });

    $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_form")[0].reset();

  }

})

</script>
