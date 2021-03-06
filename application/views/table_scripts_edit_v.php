<?php
$editable_rows = $data["g_select"]["editable"];
$readable_rows = $data["g_select"]["visible"];

$safe_ability_id = makeSafeForCSS($data["g_identity"]["g_ability_html_id"]);
$safe_ability_action_id = $safe_ability_id."_".$action_type."_";
?>
<script type="text/javascript">

$(document).on("click", "#<?php echo $safe_ability_id; ?>_edit", function(e){
  e.preventDefault();

  var edit_id = $(this).attr("value");



  $.ajax({
    url: "<?php echo base_url(); ?>api/table/t/<?php echo $data["g_identity"]["g_from"]; ?>/edit",
    type: "post",
    dataType: "json",
    data: {
      edit_id: edit_id
    },
    success: function(data){
      if (data.responce == "success") {
        $('#<?php echo $safe_ability_action_id ?>modal').modal('show');
        $("#<?php echo $safe_ability_action_id ?>record_id").val(data.post.id);
        <?php
        foreach ($editable_rows as $key => $value) {
          $key_safe = makeSafeForCSS($key);
          ?>

          <?php
          if ($key !== "id") {
            ?>

            var g_ability_html_id_edit = $("#<?php echo $safe_ability_action_id.$key_safe; ?>");

            <?php
            if (isset($value["assumable"])) {
              ?>

              state["<?php echo $safe_ability_action_id.$key_safe."_"."value" ?>"] = <?php echo $data["g_identity"]["g_where_needle"] ?>;

              <?php
            }
            else {
              ?>

              state["<?php echo $safe_ability_action_id.$key_safe."_"."value" ?>"] = data.post["<?php echo $key; ?>"];

              <?php
            }
            ?>

            g_ability_html_id_edit.val(
              state["<?php echo $safe_ability_action_id.$key_safe."_"."value" ?>"]
            );

            // alert(state["<?php echo $safe_ability_action_id.$key_safe."_"."value" ?>"]);

            // alert(JSON.stringify(state["<?php echo $safe_ability_action_id.$key_safe."_"."value" ?>"]));

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

</script>
