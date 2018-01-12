<?php
/*
 * Copy right of LuckyIT 2017
 *
 * @author ToiNT
 * @since Dec 13, 2017, 5:16:15 PM
 * 
*/
?>
<?php if (!is_user_logged_in()) { ?>
<div class="modal fade" id="myModalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginTitle">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLoginTitle"><?php echo _e('Login'); ?></h4>
      </div>
      <div class="modal-body">
      		<div id="message-login"></div>
      		<div class="form-login">
      			<div class="row">
      				<div class="col-sm-6"><button type="button" class="btn btn-default"><img width="15" height="15" src="<?php echo get_template_directory_uri() . '/assets/images/facebook-icon.svg'?>" />&nbsp;Dùng tài khoản Facebook</button></div>
      				<div class="col-sm-6 right"><button type="button" class="btn btn-default"><img width="15" height="15" src="<?php echo get_template_directory_uri() . '/assets/images/1000px-Google_Logo.svg';?>" />&nbsp;Dùng tài khoản Google</button></div>
      			</div>
      			<br/>
      			<form id="frmLogin" method="post">
					<div class="form-group">
						<label for="log"><?php echo __('User Name');?></label>
						<input type="text" name="log" class="form-control" placeholder="<?php echo _e('Enter User Name');?>" />
					</div>
					<div class="form-group">
						<label for="password"><?php echo __('Password');?></label>
						<input type="password" name="pwd" class="form-control" placeholder="<?php echo _e('Enter Password'); ?>" />
					</div>
					<input type="hidden" name="action" value="user_login" />
					<input type="hidden" name="testcookie" value="1" />
					<input type="hidden" name="customize-login" value="1" />
				</form>
	        </div>
      </div>
      <div class="modal-footer center">
        <button type="button" id="btnLogin" class="btn btn-default"><?php echo _e('Login')?></button>
      </div>
    </div>
  </div>
</div>
<?php } ?>