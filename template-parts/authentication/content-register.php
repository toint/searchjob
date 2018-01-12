<?php 
if(!is_user_logged_in()) {
?>
<div class="modal fade" id="myModalRegister" tabindex="-1" role="dialog" aria-labelledby="modalRegisTitle">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalRegisTitle"><?php echo _e('Register Account') ?></h4>
      </div>
      <div class="modal-body">
        	<div id="message-register"></div>
        	<form method="post" id="frmRegis">
                <div id="frmInfo">
                    <div class="form-group">
                        <label for="firstNameReg"><?php echo _e('First Name'); ?></label>
                        <input type="text" class="form-control" maxlength="250" name="firstNameReg" />
                    </div>
                    <div class="form-group">
                        <label for="lastNameReg"><?php echo _e('Last Name'); ?></label>
                        <input type="text" class="form-control" maxlength="250" name="lastNameReg" />
                    </div>
                    <div class="form-group">
                        <label for="userNameReg"><?php echo _e('User Name'); ?></label>
                        <input type="text" class="form-control" maxlength="250" name="userNameReg" /> 
                    </div>
                    <div class="form-group">
                        <label for="emailReg"><?php echo _e('Email'); ?></label>
                        <input type="email" class="form-control" maxlength="250" name="emailReg" />
                    </div>
                    <div class="form-group">
                        <label for="pwdReg"><?php echo _e('Password (6 or more characters)'); ?></label>
                        <input type="password" name="pwdReg" maxlength="50" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="rePwdReg"><?php echo _e('Confirm Password'); ?></label>
                        <input type="password" name="rePwdReg" maxlength="250" class="form-control" />
                    </div>
                    <p class="text-center">
                        <label class="radio-inline">
                            <input type="radio" name="role" value="candidate" checked /> <?php echo __('Candidate');?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="role" value="recruiter" /> <?php echo __('Recruiter'); ?>
                        </label>
                    </p>
                </div>
                <div id="frmRecruiter" class="frm-recruiter hide">
                    <div class="form-group">
                        <label for="companyName"><?php echo __('Company Name');?></label>
                        <input type="text" class="form-control" id="companyName" name="companyName" maxlength="250" />
                    </div>
                    <div class="form-group">
                        <label for="comAddress"><?php echo __('Company Address'); ?></label>
                        <input type="text" class="form-control" id="comAddress" name="comAddress" maxlength="250" />
                    </div>
                    <div class="form-group">
                        <label for="comPhone"><?php echo __('Company Phone'); ?></label>
                        <input type="text" class="form-control" id="comPhone" name="comPhone" maxlength="50" />
                    </div>
                    <div class="form-group">
                        <label for="comEmail"><?php echo __('Company Email');?></label>
                        <input type="text" class="form-control" id="comEmail" name="comEmail" maxlength="250" />
                    </div>
                    <div class="form-group">
                        <label for="website"><?php echo __('Website');?></label>
                        <input type="text" class="form-control" id="website" name="website" maxlength="250" />
                    </div>
                    <div class="form-group">
                        <label for="comSize"><?php echo __('Company Size');?></label>
                        <input type="text" class="form-control" id="comSize" name="comSize" maxlength="50" />
                    </div>
                    <div class="form-group">
                        <label for="establishedDate"><?php echo __('Established Date');?></label>
                        <input type="text" class="form-control" id="establishedDate" name="establishedDate" />
                    </div>
                </div>
                <input type="hidden" name="action" value="create_account" />
            </form>
        </div>
      <div class="modal-footer center">
        <button type="button" id="btnCreateAccount" class="btn btn-default"><?php echo _e('Register');?></button>
		<button type="button" id="btnNext" class="btn btn-default hide"><?php echo _e('Next');?></button>
       	<button type="button" id="btnBack" class="btn btn-default hide"><?php echo _e('Back'); ?></button>
      </div>
    </div>
  </div>
</div>
<?php 
}
?>
