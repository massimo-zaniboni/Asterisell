<?php use_helper('Javascript', 'I18N') ?>

<div id="sf_asset_container">
  <h1><?php echo __('Media library (%1%)', array('%1%' => $current_dir_slash), 'sfMediaLibrary') ?></h1>
  <div id="sf_admin_footer">
  <div id="asterisellHelp">

  <h2>Scope</h2>
    <p>Upload all images and files, that can be used as part of the Asterisell user interface or generated document.</p>

  <h2>Location</h2>
    <p>This is the content of directory "web/<?php echo sfConfig::get('app_sfMediaLibrary_upload_dir')?>". You can upload files using this Web-Form, or adding directories and files directly in it. In this case make sure that the Web-Server process can read and write the added files.</p>

  <h2>Format</h2>
      <p> JPEG images </p>
      <p> PNG images, but without alpha channel (transparent layer)</p>

  <h2>Security</h2>
    <p>Note that the uploaded files can be displayed from users, if they know their name. So does not upload private content, but only user-viewable content.</p>

  </div></div>
  <br/>
  
  <div id="sf_asset_content">

    <div id="sf_asset_controls">

      <?php echo form_tag('sfMediaLibrary/upload', 'class=float-left id=sf_asset_upload_form name=sf_asset_upload_form multipart=true') ?>
      <?php echo input_hidden_tag('current_dir', $currentDir) ?>
      <fieldset>
        <div class="form-row">
          <?php echo label_for('file', __('Add a file:', array(), 'sfMediaLibrary'), '') ?>
          <div class="content"><?php echo input_file_tag('file') ?></div>
        </div>
      </fieldset>

      <ul class="sf_asset_actions">
        <li><?php echo submit_tag(__('Add', array(), 'sfMediaLibrary'), array (
          'name'    => 'add',
          'class'   => 'sf_asset_action_add_file',
          'onclick' => "if($('file').value=='') { alert('".__('Please choose a file first', array(), 'sfMediaLibrary')."');return false; }",
        )) ?></li>
      </ul>

      </form>

      <?php echo form_tag('sfMediaLibrary/mkdir', 'class=float-left id=sf_asset_mkdir_form name=sf_asset_mkdir_form') ?>
      <?php echo input_hidden_tag('current_dir', $currentDir) ?>
      <fieldset>
        <div class="form-row">
          <?php echo label_for('dir', __('Create a dir:', array(), 'sfMediaLibrary'), '') ?>
          <div class="content"><?php echo input_tag('name', null, 'size=15 id=dir') ?></div>
        </div>
      </fieldset>

      <ul class="sf_asset_actions">
        <li><?php echo submit_tag(__('Create', array(), 'sfMediaLibrary'), array (
          'name'    => 'create',
          'class'   => 'sf_asset_action_add_folder',
          'onclick' => "if($('dir').value=='') { alert('".__('Please enter a directory name first', array(), 'sfMediaLibrary')."');return false; }",
        )) ?></li>
      </ul>

      </form>

    </div>

    <div id="sf_asset_assets">

      <?php include_partial('sfMediaLibrary/dirs', array('dirs' => $dirs, 'currentDir' => $currentDir, 'parentDir' => $parentDir, 'is_file' => (count($files) > 0))) ?>
      <?php include_partial('sfMediaLibrary/files', array('files' => $files, 'currentDir' => $currentDir, 'webAbsCurrentDir' => $webAbsCurrentDir, 'count' => count($dirs))) ?>

    </div>

  </div>

</div>
