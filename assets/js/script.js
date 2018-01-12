"use strict";

var MessageBox = {
	open: function(txt) {
		jQuery('#system-alert').empty().html(txt);
		jQuery('#myModalValid').modal('toggle');
	}
};

var ProgressBar = {
	open: function() {
		jQuery('#progress-bar').dialog('open');
	},
	close: function() {
		jQuery('#progress-bar').dialog('close');
	}
}

jQuery(document).ready(function($) {
	var progressbar = $( "#progressbar" );
	  
	$('#progress-bar').dialog({
		autoOpen: false,
		closeOnEscape: false,
		resizable: false,
		modal: true,
		open: function() {
			
		},
		beforeClose: function() {
			//nothing
		}
	});

	progressbar.progressbar({
		value: false,
		change: function() {
			//nothing
		},
		complete: function() {
			
		}
	});

	$('#establishedDate').datepicker();

	//deprecated
	$('#company_industry').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: ajax_var.url,
				method: 'POST',
				dataType: 'json',
				data: {
					action: 'autocomplete_industry',
					nonce: ajax_var.nonce,
					name: request.term
				},
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 1,
		select: function(event, ui) {
			var text = $('#list_inducstry').text();
			var list_id = $('#company_industry_id').val();
			if (list_id != '') {
				list_id = list_id + ',';
			}
				
			list_id = list_id + ui.item.id;
			$('#company_industry_id').val(list_id);
			
			$('#list_industry').append(text + '<li class="btn btn-primary btn-xs btn-tag-remove" id="tag-'+ ui.item.id + '">' + ui.item.value + ' <span class="btn btn-xs glyphicon glyphicon-remove"></span></li>');
			this.value = '';
			return false;
		}
	});

	$('#btnLogin').click(function() {
		var log = $('input[name=log]').val();
		var pwd = $('input[name=pwd]').val();

		if ($.trim(log) == '' || $.trim(pwd) == '') {
			$('#frmLogin .form-group').addClass('has-error');
			return;
		}
		//ProgressBar.open();
		
		$.ajax({
			url: ajax_var.url,
			method: 'post',
			dataType: 'json',
			data: {
				'log': $('input[name=log]').val(),
				'pwd': $('input[name=pwd]').val(),
				'testcookie': 1,
				'customize-login': 1,
				'nonce': ajax_var.nonce,
				'action': 'user_login'
			},
			success: function(data) {
				if (data.status == false) {
					$('#message-login').empty().append('<div class="alert alert-danger">' + data.message + '</div>');
				} else if (data.status == true) {
					window.location.href = data.redirect_to;
				}
			},
			error: function(err) {

			}
		});
	});

	$('input[name=role]').click(function() {
		var val = $('input[name=role]:checked').val();
		if (val == 'candidate') {
			$('#btnCreateAccount').removeClass('hide');
			$('#btnNext').addClass('hide');
		} else if (val == 'recruiter') {
			$('#btnCreateAccount').addClass('hide');
			$('#btnNext').removeClass('hide');
		}
	});

	$('#btnNext').click(function() {
		if (!validate_form()) return false;

		$('#frmInfo').addClass('hide');
		$('#frmRecruiter').removeClass('hide');
		$('#btnCreateAccount').removeClass('hide');
		$('#btnNext').addClass('hide');
	});

	function showTab(tab) {
		var val = $('input[name=role]:checked').val();
		if (val == 'candidate') return;
		if (tab == 1) {
			$('#frmInfo').removeClass('hide');
			$('#frmRecruiter').addClass('hide');
			$('#btnCreateAccount').addClass('hide');
			$('#btnNext').removeClass('hide');
		} else if (tab == 2) {
			$('#frmInfo').addClass('hide');
			$('#frmRecruiter').removeClass('hide');
			$('#btnCreateAccount').removeClass('hide');
			$('#btnNext').addClass('hide');
		}
	}

	function validate_form() {
		var firstName = $('input[name=firstNameReg]').val();
		var lastName = $('input[name=lastNameReg]').val();
		var userName = $('input[name=userNameReg]').val();
		var email = $('input[name=emailReg]').val();
		var pwd = $('input[name=pwdReg]').val();
		var repwd = $('input[name=rePwdReg]').val();
		var role = $('input[name=role]:checked').val();

		if ($.trim(firstName) == '' || $.trim(lastName) == '' || $.trim(userName) == '' || $.trim(email) == '' || $.trim(pwd) == '' || $.trim(repwd) == '' || $.trim(role) == '') {
			$('#frmRegis > div[class=form-group]').addClass('has-error');
			showMessage(lang.msg_all_field_required);
			return false;
		}
		if (pwd !== repwd) {
			$('#frmRegis > div[class=form-group]').addClass('has-error');
			showMessage(lang.msg_password_confirm_incorrect);
			return false;
		}

		return true;
	}

	function validate_com_form() {
		var companyName = $('#companyName').val();
		var comAddress = $('#comAddress').val();
		var comPhone = $('#comPhone').val();
		var comEmail = $('#comEmail').val();
		var website = $('#website').val();
		var comSize = $('#comSize').val();
		var establishedDate = $('#establishedDate').val();

		if ($.trim(companyName) == '' || $.trim(comAddress) == '' 
		|| $.trim(comPhone) == '' || $.trim(comEmail) == '' || $.trim(website) == ''
		|| $.trim(comSize) == '' || $.trim(establishedDate) == '') {
			$('#frmRegis > div[class=form-group]').addClass('has-error');
			showMessage(lang.msg_all_field_required);
			return false;
		}

		return true;
	}

	$('#btnCreateAccount').click(function() {
		
		var firstName = $('input[name=firstNameReg]').val();
		var lastName = $('input[name=lastNameReg]').val();
		var userName = $('input[name=userNameReg]').val();
		var email = $('input[name=emailReg]').val();
		var pwd = $('input[name=pwdReg]').val();
		var repwd = $('input[name=rePwdReg]').val();
		var role = $('input[name=role]:checked').val();
		var companyName = $('#companyName').val();
		var comAddress = $('#comAddress').val();
		var comPhone = $('#comPhone').val();
		var comEmail = $('#comEmail').val();
		var website = $('#website').val();
		var comSize = $('#comSize').val();
		var establishedDate = $('#establishedDate').val();

		if (!validate_form()) return false;

		if (!validate_com_form() && role == 'recruiter') return false;

		//ProgressBar.open();

		$.ajax({
			url: ajax_var.url,
			method: 'post',
			dataType: 'json',
			data: {
				'first_name': firstName,
				'last_name': lastName,
				'user_name': userName,
				'email': email,
				'pwd': pwd,
				'repwd': repwd,
				'role': role,
				'company_name': companyName,
				'company_address': comAddress,
				'company_phone': comPhone,
				'company_email': comEmail,
				'website': website,
				'company_size': comSize,
				'established_date': establishedDate,
				'action': 'create_account'
			},
			success: function(data) {
				if (data.status == false) {
					if (data.tab == 1 || data.tab == 2) {
						showTab(data.tab);
					}
					showMessage(data.message);
				} else if (data.status == true) {
					
					login(userName, pwd);
				}
			},
			error: function(err) {
				
			}
		});
	});

	function login(log, pwd) {
		jQuery.ajax({
			url: ajax_var.url,
			method: 'post',
			dataType: 'json',
			data: {
				'log': log,
				'pwd': pwd,
				'testcookie': 1,
				'customize-login': 1,
				'nonce': ajax_var.nonce,
				'action': 'user_login'
			},
			success: function(data) {
				if (data.status == false) {
					showMessage(data.message);
				} else if (data.status == true) {
					window.location.href = data.redirect_to;
				}
			},
			error: function(err) {
	
			}
		});
	}
	
	function showMessage(message) {
		$('#message-register').empty().append('<div class="alert alert-danger">' + message + '</div>');
	}

});




