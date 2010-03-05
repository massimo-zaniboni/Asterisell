<?php 

  /* Display error messages using a custom 
   * request parameter.
   */

$message = $sf_flash->get('my_error');
if (!is_null($message)): ?>
<div class="form-errors">
   <h2><?php echo $message; ?> </h2>
</div>
<?php endif; ?>
