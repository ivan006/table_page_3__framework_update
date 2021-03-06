<div style="<?php //echo $hide_toggle ?>">
  <h5>Set permissions</h5>
  <div class="form-group">
    <label for="">Owner</label>
    <select class="form-control" id="edit_owner">
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
  <div class="form-group">
    <label for="">Editability</label>
    <select class="form-control" id="edit_editability">
      <?php
      foreach ($permisssion_options["editability"]["options"] as $key => $value) {
        ?>
        <option><?php echo $value ?></option>
        <?php
      }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="">Visibility</label>
    <select class="form-control" id="edit_visibility">
      <?php
      foreach ($permisssion_options["visibility"]["options"] as $key => $value) {
        ?>
        <option><?php echo $value ?></option>
        <?php
      }
      ?>
    </select>
  </div>
</div>
