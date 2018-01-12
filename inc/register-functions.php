<?php
/*
 * Copy right of LuckyIT 2017
 *
 * @author ToiNT
 * @since Dec 13, 2017, 10:52:04 AM
 * 
*/

function get_country()
{
	global $wpdb;
	$sql = 'select * from wp_country where deleted = 0 ';
	$countries = $wpdb->get_results($sql);
	return $countries;
}
add_filter('get_country', 'get_country');

/**
 * create form register with short code
 */
function create_form_recruiter_register_shortcode()
{
	echo get_template_part('template-parts/page/content', 'recruiter-register');
}
add_shortcode('create_form_register', 'create_form_recruiter_register_shortcode');

function validate_create_account() 
{
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$user_name = $_POST['user_name'];
	$email = $_POST['email'];
	$pwd = $_POST['pwd'];
	$re_pwd = $_POST['repwd'];
	$role = $_POST['role'];

	if (empty(trim($first_name)) OR empty(trim($last_name)) 
		OR empty(trim($user_name)) OR empty(trim($email)) 
		OR empty(trim($pwd)) OR empty(trim($re_pwd)) OR empty($role)) 
	{
		$err = array('status' => false, 'tab' => 1, 'message' => __('The all field is require.'));
		die(json_encode($err));
		exit();
	}
	if (strlen($first_name) > 250 OR strlen($last_name) > 250 OR strlen($user_name) > 250 OR strlen($email) > 250 OR strlen($pwd) < 6 OR strlen($pwd) > 50)
	{
		$err = array('status' => false, 'tab' => 1, 'message' => __('The length field incorrect.'));
		die(json_encode($err));
		exit();
	}
	if ($pwd != $re_pwd) 
	{
		$err = array('status' => false, 'tab' => 1, 'message' => __('Password confirm incorrect.'));
		die(json_encode($err));
		exit();
	}
	if ($role != 'candidate' && $role != 'recruiter')
	{
		$err = array('status' => false, 'tab' => 1, 'message' => __('Data incorrect.'));
		die(json_encode($err));
		exit();
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$err = array('status' => false, 'tab' => 1, 'message' => __('Invalid email format.'));
		die(json_encode($err));
		exit();
	}
	if (!preg_match("/^[a-zA-Z0-9]*$/",$pwd)) {
		$err = array('status' => false, 'tab' => 1, 'message' => __('Password only letters and number'));
		die(json_encode($err));
		exit(); 
	}

	if ($role == 'recruiter') {
		validate_com_form();
	}

}

function validate_com_form() 
{
	$company_name = $_POST['company_name'];
	$company_address = $_POST['company_address'];
	$company_phone = $_POST['company_phone'];
	$company_email = $_POST['company_email'];
	$website = $_POST['website'];
	$company_size = $_POST['company_size'];
	$established_date = $_POST['established_date'];

	if (empty($company_name) OR empty($company_address) OR empty($company_phone) OR empty($company_email) OR empty($website) OR empty($company_size) OR empty($established_date)) {
		$err = array('status' => false, 'tab' => 2, 'message' => __('The all field is require.'));
		die(json_encode($err));
		exit();
	}
	if (strlen($company_name) > 250 OR strlen($company_address) > 250 OR strlen($company_phone) > 50 OR strlen($company_email) > 250 OR strlen($website) > 250 OR strlen($company_size) > 50) 
	{
		$err = array('status' => false, 'tab' => 2, 'message' => __('The length field incorrect'));
		die(json_encode($err));
		exit();
	}
}

/**
 * create new account
 */
function create_account() 
{
	global $wpdb;
	if (is_user_logged_in()) {
		return;
	}

	validate_create_account();

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$user_name = $_POST['user_name'];
	$email = $_POST['email'];
	$pwd = $_POST['pwd'];
	$re_pwd = $_POST['repwd'];
	$role = $_POST['role'];

	$company_name = $_POST['company_name'];
	$company_address = $_POST['company_address'];
	$company_phone = $_POST['company_phone'];
	$company_email = $_POST['company_email'];
	$website = $_POST['website'];
	$company_size = $_POST['company_size'];
	$established_date = $_POST['established_date'];

	$userdata = array(
			'user_login' => $user_name,
			'user_url' => get_site_url(),
			'user_pass' => NULL,
			'user_email' => $email
	);
	
	$user_id = wp_insert_user($userdata);

	if ( is_wp_error( $user_id ) ) {
		$res = array('status' => false, 'tab' => 1, 'message' => $user_id->get_error_message());
		die(json_encode($res));
		exit();
	}

	$com_data = array(
		'name' => $company_name,
		'address' => $company_address,
		'mobile' => $company_phone,
		'email' => $company_email,
		'website' => $website,
		'com_size' => $company_size,
		'established_date' => format_date($established_date),
		'user_id' => $user_id
	);
	if ($role == 'recruiter') {

		$wpdb->insert('wp_company', $com_data);
		if ( is_wp_error( $company_id ) ) {
			$res = array('status' => false, 'tab' => 2, 'message' => $company_id->get_error_message());
			die(json_encode($res));
			exit();
		}
		$company_id = $wpdb->insert_id;

		add_user_meta($user_id, 'company_id', $company_id, false);
	}
	

	wp_set_password($pwd, $user_id);

	add_user_meta($user_id, 'first_name', $first_name, false);
	add_user_meta($user_id, 'last_name', $first_name, false);
	add_user_meta($user_id, 'role', $role);

	$res = array('status' => true, 'tab' => 1, 'message' => 'Create a account success!');
	die(json_encode($res));
	exit();
}
//add_action( 'admin_post_nopriv_create_account', 'create_account' );
//add_action( 'admin_post_create_account', 'create_account' );

add_action('wp_ajax_nopriv_create_account', 'create_account');
add_action('wp_ajax_create_account', 'create_account');

?>