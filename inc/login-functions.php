<?php

function validate_form_login()
{
    $user_name = $_POST['log'];
    $pwd = $_POST['pwd'];
    if (empty($user_name)) 
    {
        $err = json_encode(array('status'=> false, 'message' => _e('User is required.')));
        die($err);
    }
    if (empty($pwd))
    {
        $err = json_encode(array('status'=> false, 'message' => _e('Password is required.')));
        die($err);
    }
}

function user_login()
{
    global $error;
    $response = array('status' => true, 'message' => '', 'redirect_to' => '');
	if (is_user_logged_in())
	{
        die(json_encode($response));
		exit();
	}

	if (isset($_POST['log']) && isset($_POST['pwd']))
	{
        $http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
        $interim_login = isset($_REQUEST['interim-login']);
		$user_name = $_POST['log'];
        $pwd = $_POST['pwd'];
        
        validate_form_login();

        $response = array('status' => true, 'message' => '', 'redirect_to' => '');

        $secure_cookie = '';

        // If the user wants ssl but the session is not ssl, force a secure cookie.
        if ( !empty($_POST['log']) && !force_ssl_admin() ) {
            $user_name = sanitize_user($_POST['log']);
            $user = get_user_by( 'login', $user_name );

            if ( ! $user && strpos( $user_name, '@' ) ) {
                $user = get_user_by( 'email', $user_name );
            }

            if ( $user ) {
                if ( get_user_option('use_ssl', $user->ID) ) {
                    $secure_cookie = true;
                    force_ssl_admin(true);
                }
            }
        }

        if ( isset( $_REQUEST['redirect_to'] ) ) {
            $redirect_to = $_REQUEST['redirect_to'];
            // Redirect to https if user wants ssl
            if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
                $redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
        } else {
            $redirect_to = admin_url();
        }

        $reauth = empty($_REQUEST['reauth']) ? false : true;

        $user = wp_signon( array(), $secure_cookie );

        /*
        if ( empty( $_COOKIE[ LOGGED_IN_COOKIE ] ) ) {
            if ( headers_sent() ) {
                $response['status'] = false;
                $response['message'] = __( '<strong>ERROR</strong>: Cookies are blocked due to unexpected output. For help, please see <a href="%1$s">this documentation</a> or try the <a href="%2$s">support forums</a>.' );
            } elseif ( isset( $_POST['testcookie'] ) && empty( $_COOKIE[ TEST_COOKIE ] ) ) {
                $response['status'] = false;
                $response['message'] = __( '<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href="%s">enable cookies</a> to use WordPress.' );
            }
        }
        */

        $requested_redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';

        if ( !is_wp_error($user) && !$reauth ) {
            if ( $interim_login ) {
                $message = '<p class="message">' . __('You have logged in successfully.') . '</p>';
                $interim_login = 'success';
                $response['status'] = true;
                $response['message'] = $message;
            }
    
            if ( ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) ) {
                // If the user doesn't belong to a blog, send them to user admin. If the user can't edit posts, send them to their profile.
                if ( is_multisite() && !get_active_blog_for_user($user->ID) && !is_super_admin( $user->ID ) )
                    $redirect_to = user_admin_url();
                elseif ( is_multisite() && !$user->has_cap('read') )
                    $redirect_to = get_dashboard_url( $user->ID );
                elseif ( !$user->has_cap('edit_posts') )
                    $redirect_to = $user->has_cap( 'read' ) ? admin_url( 'profile.php' ) : home_url();
    
                    $response['redirect_to'] = $redirect_to;
            }
            //wp_safe_redirect($redirect_to);
            //exit();

            die(json_encode($response));
            exit();
        }

        $errors = $user;
        // Clear errors if loggedout is set.
        if ( !empty($_GET['loggedout']) || $reauth )
            $errors = new WP_Error();

        if ( $interim_login ) {
            if ( ! $errors->get_error_code() ) {
                $response['status'] = false;
                $response['message'] = __( 'Your session has expired. Please log in to continue where you left off.' );
            }
        } else {
            // Some parts of this script use the main login form to display a message
            if		( isset($_GET['loggedout']) && true == $_GET['loggedout'] ) 
            {
                $response['status'] = false;
                $response['message'] = __('You are now logged out.');
            }
            elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] ) 
            {
                $response['status'] = false;
                $response['message'] = __('User registration is currently not allowed.');
            }
            elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] ) {
                $response['status'] = false;
                $response['message'] = __('Check your email for the confirmation link.');
            }
            elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] ) {
                $response['status'] = false;
                $response['message'] = __('Check your email for your new password.');
            }
            elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] ) {
                $response['status'] = false;
                $response['message'] = __('Registration complete. Please check your email.');
            }
            elseif ( strpos( $redirect_to, 'about.php?updated' ) ) {
                $response['status'] = false;
                $response['message'] = __( '<strong>You have successfully updated WordPress!</strong> Please log back in to see what&#8217;s new.' );
            }
        }
        // Clear any stale cookies.
            if ( $reauth )
            wp_clear_auth_cookie();

        if ('incorrect_password' == $errors->get_error_code())
        {
            $response['status'] = false;
            $response['message'] = __('Incorrect Password');
        }
        elseif ('empty_password' == $errors->get_error_code())
        {
            $response['status'] = false;
            $response['message'] = __('Password is required');
        }

        die(json_encode($response));
        exit();
	}
	
}
//add_action( 'admin_post_nopriv_user_login', 'user_login' );
//add_action( 'admin_post_user_login', 'user_login' );

add_action('wp_ajax_nopriv_user_login', 'user_login');
add_action('wp_ajax_user_login', 'user_login');

