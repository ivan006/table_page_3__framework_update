<?php
$editable_rows = $data["g_select"]["editable"];
$readable_rows = $data["g_select"]["visible"];
?>
<script type="text/javascript">

$(document).on("click", "#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"]); ?>_edit", function(e){
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
        $('#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_" ?>modal').modal('show');
        $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_" ?>record_id").val(data.post.id);
        <?php
        foreach ($editable_rows as $key => $value) {
          ?>

          <?php
          if ($key !== "id") {
            ?>

            var g_ability_html_id_edit = $("#<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key); ?>");

            <?php
            if (isset($value["assumable"])) {
              ?>

              state["<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"] = <?php echo $data["g_identity"]["g_where_needle"] ?>;

              <?php
            }
            else {
              ?>

              state["<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"] = data.post["<?php echo $key; ?>"];

              <?php
            }
            ?>

            g_ability_html_id_edit.val(state["<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]);
            // alert(state["<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]);

            // alert(JSON.stringify(state["<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS($key)."_"."value" ?>"]));

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
