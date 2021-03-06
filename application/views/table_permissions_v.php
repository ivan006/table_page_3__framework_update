<div style="<?php //echo $hide_toggle ?>">
  <h5>Set permissions</h5>
  <div class="form-group">
    <label for="">Owner</label>
    <select class="form-control" id="<?php echo makeSafeForCSS($data["g_identity"]["g_ability_html_id"])."_".$action_type."_".makeSafeForCSS("owner_group"); ?>">
      <?php
      foreach ($permisssion_options["owner"]["options"] as $key => $value) {
        if ($permisssion_options["owner"]["assumed"] == $value["id"]) {
          $selected_attr =  'selected="selected"';
        } else {
          $selected_attr =  '';
        }
        ?>
        <option value="<?php echo $value["id"] ?>" <?php echo $selected_attr ?>><?php echo $value["indent"] ?> <?php echo $value["name"] ?></option>
        <?php
      }
      ?>
    </select>
  </div>
</div>
