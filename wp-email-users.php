<?php

/**

 * Plugin Name: WP Email Users

 * Plugin URI:  http://www.techspawn.com

 * Description: WP Email Users send mail to individual user or group of users.

 * Version: 1.3.7

 * Author: techspawn1

 * Author URI: http://www.techspawn.com

 * License: GPL2

 */

/*  Copyright 2016-2017  Techspawn  (email : sales@techspawn.com)



    This program is free software; you can redistribute it and/or modify



    it under the terms of the GNU General Public License as published by



    the Free Software Foundation; either version 2 of the License, or



    (at your option) any later version.



    This program is distributed in the hope that it will be useful,



    but WITHOUT ANY WARRANTY; without even the implied warranty of



    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the



    GNU General Public License for more details.



    You should have received a copy of the GNU General Public License



    along with this program; if not, write to the Free Software



    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/



/**



 * Make sure we don't expose any information if called directly



 */



if ( !function_exists( 'add_action' )) {

	echo 'Hi there!  I am just a plugin, not much I can do when called directly.';

	exit;

}



define( 'WP_EMAIL_USERS_PLUGIN_URL', plugin_dir_url(__FILE__) );



define( 'WP_EMAIL_USERS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );



	require_once('wp-autoresponder-email-settings.php');



	require_once('wp-email-user-ajax.php');



	require_once('wp-email-user-ajax-subscribe.php');



	require_once('wp-email-user-template.php');



	require_once('wp-email-user-csv.php');



	require_once('wp-email-user-smtp.php');



	require_once('wp-autoresponder-email-configure.php');



	require_once('wp-email-widget.php');



	require_once('wp-email-shortcode.php');



	require_once('wp-email-user-manage-list.php');



	if ( !function_exists( 'ts_weu_load_enqueue_scripts' )) {



		function ts_weu_load_enqueue_scripts() {



			wp_enqueue_script( 'jquery');



		}



	}

add_action( 'init', 'ts_weu_load_enqueue_scripts' );



if ( !function_exists( 'ts_weu_enqueue_script' )) {



	function ts_weu_enqueue_script(){



	    wp_enqueue_script( 'wp-email-user-datatable-script', plugins_url('js/jquery.dataTables.min.js', __FILE__ ), array(), '1.0.0', false );



	    wp_enqueue_script( 'wp-email-user-script', plugins_url('js/email-admin.js', __FILE__ ), array(), '1.0.0', false );


	    wp_enqueue_script( 'wp-email-user-script', plugins_url('js/jquery.min.js', __FILE__ ), array(), '1.0.0', false );



		wp_enqueue_style( 'wp-email-user-style', plugins_url('css/style.css', __FILE__ ) );



		wp_enqueue_style( 'wp-email-user-datatable-style', plugins_url('css/dt/jquery.dataTables.min.css', __FILE__ ) );

		/* EXPORT DATA TABLE FILES */

		wp_enqueue_style( 'wp-email-user-datatable-style-btncss-dt', plugins_url('css/dt/buttons.dataTables.min.css', __FILE__ ) );

		wp_enqueue_script( 'wp-email-user-script-btn-dt', plugins_url('js/dt/dataTables.buttons.min.js', __FILE__ ), array(), '1.0.0', false );

		wp_enqueue_script( 'wp-email-user-script-flash-dt', plugins_url('js/dt/buttons.flash.min.js', __FILE__ ), array(), '1.0.0', false );

		/*wp_enqueue_script( 'wp-email-user-script-pdfmake-dt', plugins_url('js/dt/pdfmake.min.js', __FILE__ ), array(), '1.0.0', false );
*/
		wp_enqueue_script( 'wp-email-user-script-fonts-dt', plugins_url('js/dt/vfs_fonts.js', __FILE__ ), array(), '1.0.0', false );

		wp_enqueue_script( 'wp-email-user-script-jszip-dt', plugins_url('js/dt/jszip.min.js', __FILE__ ), array(), '1.0.0', false );

		wp_enqueue_script( 'wp-email-user-script-htmlbtn-dt', plugins_url('js/dt/buttons.html5.min.js', __FILE__ ), array(), '1.0.0', false );

		wp_enqueue_script( 'wp-email-user-script-btn-print-dt', plugins_url('js/dt/buttons.print.min.js', __FILE__ ), array(), '1.0.0', false );




	}



}



add_action( 'admin_enqueue_scripts', 'ts_weu_enqueue_script' );



if ( !function_exists( 'weu_admin_page' )) {



function weu_admin_page(){



	global $current_user, $wpdb, $wp_roles;



    $user_roles = $current_user->roles;



    $roles = $wp_roles->get_names();



	if($user_roles[0]=='administrator') {



    wp_enqueue_script( 'wp-email-user-datatable-script', plugins_url('js/jquery.dataTables.min.js', __FILE__ ), array(), '1.0.0', false );



    wp_enqueue_script( 'wp-email-user-script', plugins_url('js/email-admin.js', __FILE__ ), array(), '1.0.0', false );



	wp_enqueue_style( 'wp-email-user-style', plugins_url('css/style.css', __FILE__ ) );



	wp_enqueue_style( 'wp-email-user-datatable-style', plugins_url('css/jquery.dataTables.min.css', __FILE__ ) );



		wp_enqueue_style( 'wp-email-user-datatable-style-btncss-dt', plugins_url('css/dt/buttons.dataTables.min.css', __FILE__ ) );


		wp_enqueue_script( 'wp-email-user-script-btn-dt', plugins_url('js/dt/dataTables.buttons.min.js', __FILE__ ), array(), '1.0.0', false );


		wp_enqueue_script( 'wp-email-user-script-flash-dt', plugins_url('js/dt/buttons.flash.min.js', __FILE__ ), array(), '1.0.0', false );


		/*wp_enqueue_script( 'wp-email-user-script-pdfmake-dt', plugins_url('js/dt/pdfmake.min.js', __FILE__ ), array(), '1.0.0', false );
*/
		wp_enqueue_script( 'wp-email-user-script-fonts-dt', plugins_url('js/dt/vfs_fonts.js', __FILE__ ), array(), '1.0.0', false );

		wp_enqueue_script( 'wp-email-user-script-jszip-dt', plugins_url('js/dt/jszip.min.js', __FILE__ ), array(), '1.0.0', false );

		wp_enqueue_script( 'wp-email-user-script-htmlbtn-dt', plugins_url('js/dt/buttons.html5.min.js', __FILE__ ), array(), '1.0.0', false );

		wp_enqueue_script( 'wp-email-user-script-btn-print-dt', plugins_url('js/dt/buttons.print.min.js', __FILE__ ), array(), '1.0.0', false );


	$wau_status=2;

   	$unsubscribe_flg = 0;

	$wau_too = array();


	if( isset($_POST['rbtn']) && $_POST['rbtn'] == 'csv'){


		$temp_key=isset($_POST['wau_temp_name'])?$_POST['wau_temp_name']:'';


		$chk_val = $_POST['save_temp'];


		$table_name = $wpdb->prefix.'email_user';



		if($wpdb->get_var("show tables like '$table_name'") != $table_name){



		$sql = "CREATE TABLE $table_name(



                id int(11) NOT NULL AUTO_INCREMENT,



                template_key varchar(20) NOT NULL,



                template_value longtext NOT NULL,



                status varchar(20) NOT NULL,



                UNIQUE KEY id(id)



             );";



        $rs = $wpdb->query($sql);



		}



   	if($chk_val==2){



			$wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name."`(`template_key`, `template_value`, `status`) VALUES (%s,%s,%s)



				",



				$temp_key,stripslashes($_POST['wau_mailcontent']),'template'));
		}


	$from_email=sanitize_email($_POST['wau_from_email']);



    $from_name=sanitize_text_field($_POST['wau_from_name']);



   	$headers[] = 'From: ' .$from_name. ' <'. $from_email.' >';



    $headers[] = 'Content-Type: text/html; charset="UTF-8"';



	for($j=0;$j<count($_POST['csv_file_name']);$j++) {

        $csv_to = array();

		$table_name = $wpdb->prefix.'weu_subscribers';

 		$csv_fname = $_POST['csv_file_name'][$j];

        $myrows = $wpdb->get_results("SELECT * FROM $table_name WHERE list ='$csv_fname'");

		foreach ($myrows as $line) {

			array_push($csv_to, $line->email);

			$email = $line->email;


			$user_id = $line->id;


			$list = $line->list;


			$name = $line->name;

		

		$mail_body = $_POST['wau_mailcontent'];



        $subject = sanitize_text_field($_POST['wau_sub']);



		$body = stripslashes($mail_body);

	    sanitize_text_field( $body );

				$weu_arconf_buff = get_option( 'weu_ar_config_options' );

				$unsbscribe_url = isset($weu_arconf_buff['rbtn_user_unsubscribe_url'])?$weu_arconf_buff['rbtn_user_unsubscribe_url']:'';

				$unsubscribe_link = add_query_arg( array(



					'id' => $user_id,



					'email' => $email,



					'list' => $list,



				), $unsbscribe_url );


				$unsubscribe_link_ht = "<a href=".$unsubscribe_link.">unsubscribe</a>";



				$replace = array(

					$name,

					$email,


					get_option( 'blogname' ),

		            $unsubscribe_link_ht

		  		);



				$find = array(



				'[[first-name]]',


				'[[user-email]]',



				'[[site-title]]',



				'[[unsubscribe-link]]'



				);



			    $mail_body = str_replace( $find, $replace, $_POST['wau_mailcontent'] );



		        $subject = sanitize_text_field($_POST['wau_sub']);



				$body = stripslashes($mail_body);



				$from_email=sanitize_email($_POST['wau_from_email']);



		   	    $from_name=sanitize_text_field($_POST['wau_from_name']);



			    sanitize_text_field( $body );



		        $headers[] = 'From: '.$from_name.' <'. $from_email.'>';



			    $headers[] = 'Content-Type: text/html; charset="UTF-8"';



			    $wau_status ='';

			    $unsubscribe_flg = 0;

			    if( !weu_isUnsubscribe( $user_id , $email ) ) {



				 	$wau_status = wp_mail($email, $subject, $body, $headers);

		    	}

		    	else {

		    		$unsubscribe_flg = 1;

		    	}


		} // for ends

		// }

		if( $wau_status==1 || $unsubscribe_flg==1 ){



			echo '<div id="message" class="updated notice is-dismissible"><p>Your message has been sent successfully.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';



		} elseif( $wau_status==0 ){



			echo '<div id="message" class="updated notice is-dismissible error"><p> Sorry,your message has not sent.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';



		}

		/* INSERT VALUE INTO weu_sent_email TABLE AFTER SENDING THE EMAIL */



			$get_sent_type = "List";



			$get_subject = $subject;



			$get_body = $body;



			$get_from_name = $from_name;



			$get_from_email = $from_email;



			$get_user_role = $_POST['rbtn'];



			$get_status = $wau_status;



			$get_current_date = current_time( 'mysql' );



			/*EMAIL SENT TABLE EXISTS CHECK*/



			$table_name_sent_email = $wpdb->prefix.'weu_sent_email';



			weu_setup_activation_data();



			/*EMAIL SENT DETAILS INSERT */



			$wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name_sent_email."`(`weu_sent_type`, `weu_email_subject`, `weu_email_body`, `weu_from_name`, `weu_from_email`, `weu_to_type`, `weu_status`, `weu_sent_date_time`) VALUES (%s,%s,%s,%s,%s,%s,%d,%s)",



			$get_sent_type,$get_subject,$get_body,$get_from_name,$get_from_email,$get_user_role,$get_status,$get_current_date));

  		}

	}



	$wau_to = array();



	if( isset($_POST['rbtn']) && $_POST['rbtn'] == 'user'){



		for($j=0;$j<count($_POST['ea_user_name']);$j++){



			$user= $_POST['ea_user_name'][$j];



			array_push($wau_to,$_POST[$user]);



			$wau_to = array_filter($wau_to,"weu_is_unsubscribe_arr");



		}



	}

	elseif( isset($_POST['rbtn']) && $_POST['rbtn'] =='role'){



		 	for($k=0;$k<count($_POST['user_role']);$k++){


			     	$args = array(



						'role' => $_POST['user_role'][$k]



					);



						$str_brk=explode(' ', $args['role']);



						$str_join=join('_',$str_brk);



						$str_join=strtolower($str_join);



						$args = array(



						'role' => $str_join



						);



				    	$wau_grp_users=get_users($args); //get all users



					   	for($m=0;$m<count($wau_grp_users);$m++){



					   		array_push($wau_to,$wau_grp_users[$m]->data->user_email);



						}



			}

			$wau_to = array_filter($wau_to,"weu_is_unsubscribe_arr");

	}



	/* Send Mail to user using wp_mail */



  	global $wpdb;



	$wau_status=2;

   	$unsubscribe_flg = 0;

	$wau_too = array();



	if(isset($_POST['rbtn']) && $_POST['rbtn'] =='user' ||  isset($_POST['rbtn']) && $_POST['rbtn'] == 'role' ){



		$temp_key=isset($_POST['wau_temp_name'])?$_POST['wau_temp_name']:'';


		$chk_val = $_POST['save_temp'];


		$table_name = $wpdb->prefix.'email_user';



		if($wpdb->get_var("show tables like '$table_name'") != $table_name){



		$sql = "CREATE TABLE $table_name(



                id int(11) NOT NULL AUTO_INCREMENT,



                template_key varchar(20) NOT NULL,



                template_value longtext NOT NULL,



                status varchar(20) NOT NULL,



                UNIQUE KEY id(id)



             );";



        $rs = $wpdb->query($sql);



		}



   	if($chk_val==2){



			$wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name."`(`template_key`, `template_value`, `status`) VALUES (%s,%s,%s)



				",



				$temp_key,stripslashes($_POST['wau_mailcontent']),'template'));
		}

		

	for($j=0;$j<count($wau_to);$j++){


		$curr_email_data = get_user_by ( 'email', $wau_to[$j] );



		$user_id =  $curr_email_data->ID;



		$user_info = get_userdata($user_id);



        $user_val=get_user_meta($user_id);



        // unsubscribe link start

        $list='Test';

		$weu_arconf_buff = get_option( 'weu_ar_config_options' );

		$unsbscribe_url = isset($weu_arconf_buff['rbtn_user_unsubscribe_url'])?$weu_arconf_buff['rbtn_user_unsubscribe_url']:'';

		$unsubscribe_link = add_query_arg( array(



			'id' => $user_id,



			'email' => $wau_to[$j],



			'list' => $list,



		), $unsbscribe_url );



        array_push($wau_too,$user_info->display_name);

        

		$unsubscribe_link_ht = "<a href=".$unsubscribe_link.">unsubscribe</a>";



		$replace = array(

			$user_val['nickname'][0],

			$user_val['first_name'][0],

			$user_val['last_name'][0],

			get_option( 'blogname' ),

            $wau_too[$j],

            $wau_to[$j],

            $unsubscribe_link_ht

  		);



		$find = array(



		'[[user-nickname]]',



		'[[first-name]]',



		'[[last-name]]',



		'[[site-title]]',



		'[[display-name]]',



		'[[user-email]]',



		'[[unsubscribe-link]]'



		);



	    $mail_body = str_replace( $find, $replace, $_POST['wau_mailcontent'] );



        $subject = sanitize_text_field($_POST['wau_sub']);



		$body = stripslashes($mail_body);



		$from_email=sanitize_email($_POST['wau_from_email']);



   	    $from_name=sanitize_text_field($_POST['wau_from_name']);



	    sanitize_text_field( $body );



        $headers[] = 'From: '.$from_name.' <'. $from_email.'>';



	    $headers[] = 'Content-Type: text/html; charset="UTF-8"';



	    $wau_status ='';

	    $unsubscribe_flg = 0;

	    if( !weu_isUnsubscribe( $user_id , $wau_to[$j] ) ) {

		 	$wau_status = wp_mail($wau_to[$j], $subject, $body, $headers);

    	}

    	else {

    		$unsubscribe_flg = 1;

    	}



		/* INSERT VALUE INTO weu_sent_email TABLE AFTER SENDING THE EMAIL */



						$get_sent_type = "Normal";



						$get_subject = $subject;



						$get_body = $body;



						$get_from_name = $from_name;



						$get_from_email = $from_email;



						$get_user_role = $_POST['rbtn'];



						$get_status = $wau_status;



						$get_current_date = current_time( 'mysql' );



            /*EMAIL SENT TABLE EXISTS CHECK*/



            $table_name_sent_email = $wpdb->prefix.'weu_sent_email';



            weu_setup_activation_data();



			/*EMAIL SENT DETAILS INSERT */



			$wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name_sent_email."`(`weu_sent_type`, `weu_email_subject`, `weu_email_body`, `weu_from_name`, `weu_from_email`, `weu_to_type`, `weu_status`, `weu_sent_date_time`) VALUES (%s,%s,%s,%s,%s,%s,%d,%s)",



			$get_sent_type,$get_subject,$get_body,$get_from_name,$get_from_email,$get_user_role,$get_status,$get_current_date));

	} // for ends



	}


	if( $wau_status==1 || $unsubscribe_flg==1 ){



		echo '<div id="message" class="updated notice is-dismissible"><p>Your message has been sent successfully.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';



	} elseif( $wau_status==0 ){



		echo '<div id="message" class="updated notice is-dismissible error"><p> Sorry,your message has not sent.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';



	}



	$wau_users=get_users(); //get all wp users



	echo "<div class='wrap'>";



	echo "<h2> WP Email Users - Send Email </h2>";



	echo "</div>";



	echo "<p>Send email to individual as well as group of users.</p>";



	echo '<form name="myform" id="myForm" class="wau_form" method="POST" action="#" onsubmit="return validation()" >';



	/* User role */



	echo '<table id="" class="form-table" >';



	echo '<tbody>';



	echo '<tr>';



	echo '<th>From Name</th> <td colspan="1"><input type="text" name="wau_from_name" value="'.$current_user->display_name.'" class="wau_boxlen"  id="wau_from_name" required></td>';



	echo '</tr>';



	echo '<tr>';



	echo '<th>From Email</th> <td colspan="2"><input type="text" name="wau_from_email" value="'.$current_user->user_email.'" class="wau_boxlen"  id="wau_from" onblur="myFunction()" required><span id="errfn" style="color: red;"></span></td>';



	echo '</tr>';



	echo '<tr>';



	echo "<th><b>Send Email To &nbsp; </b></th>";



	echo '<td style="width: 224px"><input type="radio" name="rbtn" id="user_role" onclick="radioFunction()" value="user" checked > User &nbsp;</td>';



	echo '<td style="width: 224px"><input type="radio" name="rbtn" id="r_role" onclick="radioFunction()" value="role"> Role </td>';



	echo '<td style="width: 224px"><input type="radio" name="rbtn" id="check_list" onclick="radioFunction()" value="csv"> List </td>';



	echo "</tr>";



	/**



     * Select Users



     **/



    echo '<tr class="wau_user_toggle"><th></th><td colspan="3">';



	echo '<table id="example" class="display alluser_datatable" cellspacing="0" width="100%">



	        <thead>



	            <tr style="text-align:left"> <th style="text-align:center" ><input name="select_all" value="1" id="example-select-all" class="select-all" type="checkbox"></th>



	                 <th>Display name</th>



	                 <th>Email</th>';

	                 $weu_arconf_buff = array();


						$weu_arconf_buff = get_option( 'weu_ar_config_options' );


	                 if(isset($weu_arconf_buff['weu_arconfig_buddypress']) && $weu_arconf_buff['weu_arconfig_buddypress']=='yes')
	                 {
	                 	echo '<th>BP Group</th>';
	                 }


	            echo '</tr>



	        </thead>



	        <tbody>';



	foreach ( $wau_users as $user ){



	echo '<tr style="text-align:left">';



	echo '<td style="text-align:center"><input type="checkbox" name="ea_user_name[]" value="'.$user->ID.'" class="select-all"></td>';



	echo '<td><span id="getDetail">'. esc_html( $user->display_name ).'</span></td>';



	echo '<td><span >'.esc_html( $user->user_email ).'</span></td>';

	if(isset($weu_arconf_buff['weu_arconfig_buddypress']) && $weu_arconf_buff['weu_arconfig_buddypress']=='yes')
	{
		$table_name = $wpdb->prefix.'bp_groups_members';

	$group_id = $wpdb->get_var( "SELECT group_id FROM $table_name WHERE is_confirmed = '1' and user_id=".$user->ID );

	$table_name = $wpdb->prefix.'bp_groups';
	if($group_id != 0){

	$myrows = $wpdb->get_var( "SELECT name FROM $table_name WHERE id =".$group_id );

	echo '<td>'.$myrows.'</td>';
}else{
	echo '<td>--</td>';
}
	}



	echo '</tr>';}



	echo'</tbody></table>'; // end user Data table for user



	foreach ( $wau_users as $user ) {



		echo  '<input type="hidden" name="' . esc_html( $user->ID ) . '" value="'. esc_html( $user->user_email ) . '">';



	}



	echo '<table id="example1" class="display allcsv_datatable" cellspacing="0" width="100%">



	        <thead>



	            <tr style="text-align:left"> <th style="text-align:center" ><input name="select_all_csv" value="1" id="example-csv-select-all" class="select-all" type="checkbox"></th>



	                 <th>Subscriber List</th>



	            </tr>



	        </thead>



	        <tbody>';



	$myrows = get_option('weu_subscriber_lists');



	if(empty($myrows))

		$myrows = array('default');



	foreach ( $myrows as $csv_file ){



	echo '<tr style="text-align:left">';



	echo '<td style="text-align:center"><input type="checkbox" name="csv_file_name[]" value="'.$csv_file.'" class="select-all"></td>';



	echo '<td><span id="getDetail">'. esc_html( $csv_file ).'</span></td>';



	echo '</tr>';}



	echo'</tbody></table></td></tr>'; //end csv table here



	foreach ( $myrows as $csv_file ){



		echo  '<input type="hidden" name="' . esc_html( $csv_file ) . '" value="'. esc_html( $csv_file ) . '">';



	}



	/* select roles */



	$mail_content="";



	echo '<tr id="wau_user_role" style="display:none">';



	echo '<th>Select Roles</th>';



	echo '<td colspan="3"><select name="user_role[]" multiple class="wau_boxlen" id="wau_role" >';



	echo '<option value="" selected disabled>-- Select Role --</option>';



		foreach ($roles as $value) {



			echo  '<option> '.$value.' </option>';



		}



	echo '</select></td>';



	echo '</tr>';



	echo '<tr>';



	echo '<th>Subject</th> <td colspan="3"><input type="text" name="wau_sub" class="wau_boxlen"  id="sub" placeholder="write your email subject here" required></td>';



	echo '</tr>';


echo '<input type="hidden" name="save_temp" id="save_temp" >';


	echo "<tr><th><b>Template Options &nbsp; </b></th>";



	echo '<td style="width: 224px"><input type="radio" id="rdb2" type="radio" name="toggler" value="2" onclick="checkFunction()" checked> Choose Existing Template </td>';


	echo '<td style="width: 224px"><input type="radio" id="rdb1" type="radio" name="toggler" value="1" onclick="checkFunction()" >Create New Template &nbsp;</td>';


	echo '<td style="width: 224px"><input type="radio" id="rdb3" type="radio" name="toggler" value="3" onclick="checkFunction()"> Disable </td>';



	echo "</tr>";



	$table_name = $wpdb->prefix.'email_user';



    $myrows = $wpdb->get_results( "SELECT id, template_key, template_value FROM $table_name WHERE status = 'template'" );



	$template_path_one = plugins_url('template1.html', __FILE__ );



	$template_path_two = plugins_url('template2.html', __FILE__ );

	$ar_conf_page = admin_url( "admin.php?page=weu_email_auto_config");

	echo '<tr id="blk-1" class="toHide1">';



	echo '<th>Select Template </th><td colspan="3"><select autocomplete="off" id="wau_template" name="mail_template[]" class="wau-template-selector" style="width:100%">



        <option selected="selected" value="">- Select -</option>



        <option value="'.$template_path_one.'" id="wau_template_t1"> Default Template - 1 </option>



        <option value="'.$template_path_two.'" id="wau_template_t2"> Default Template - 2 </option>';



        for ($i=0;$i<count($myrows);$i++) {



     		echo '<option value="'.$myrows[$i]->id.'" id="am" >'.$myrows[$i]->template_key.'</option>';



      	}



       '</select></td>';



	echo '</tr>';



	echo '<tr id="blk-2" class="toHide" style="display: none;">';
    


    echo '<th>Template Name</th><td colspan="3"><input type="text" name="wau_temp_name" class="wau_boxlen"  id="temp_name_req" placeholder="write template name here"></td>';


    echo '</tr>';



	echo '<tr>';



	echo '<th scope="row" valign="top"><label for="wau_mailcontent">Message</label></th>';



    echo '<td colspan="3">';



	echo '<div id="msg" class="wau_boxlen" name="wau_mailcontent">';



		wp_editor($mail_content, "wau_mailcontent",array('wpautop'=>false,'media_buttons' => true));



	echo '</div>';



	echo "Please use shortcode placeholder as below.</br>";



    echo '<p id="nickname"><b> [[user-nickname]] : </b>use this placeholder to display user nickname</p> 



          <p><b> [[first-name]] : </b>use this placeholder to display user first name  </p>



          <p id="lname"><b> [[last-name]] :  </b>use this placeholder to display user last name </p>



          <p><b> [[site-title]] : </b>use this placeholder to display your site title</p>



          <p><p id="dname"><b> [[display-name]] : </b>use this placeholder for display name</p>



          <p><b> [[user-email]] : </b>use this placeholder to display user email</p>



		  <p><b> [[unsubscribe-link]] : </b>use this placeholder to display unsubscribe link in email. Please make sure you configure unsubscribe page link <a href='.$ar_conf_page.'>here</a> before using this.</p>';

   	

	echo '</td>';



	echo'</tr>';



	echo '<tr>';



	echo '<th></th>';



	echo '<td colspan="3"> <span id="errfn1" style="color: red;"></span>';



	echo '<div><input type="submit" value="Send" class="button button-hero button-primary" id="weu_send" ></div>';



	echo '</td>';



	echo '</tr>';



	echo '</tbody>';



	echo '</table>';



	echo '</form>';
         }
     }

}



/**



 * add admin menu to wp menu



 */



function add_weu_custom_menu() {



	global $current_user;



    $user_roles = $current_user->roles;



    if($user_roles[0]=='administrator') {



		add_menu_page( 'WP Email Users page', 'WP Email Users', 'manage_options', 'weu-admin-page', 'weu_admin_page','dashicons-email-alt');



		add_submenu_page('weu-admin-page', 'Send Email', 'Send Email', 'manage_options', 'weu_send_email', 'weu_admin_page' );



		add_submenu_page('weu-admin-page', 'WP Template page', 'Template Editor', 'manage_options', 'weu-template', 'weu_template' );



		add_submenu_page('weu-admin-page', 'SMTP Config', 'SMTP Configuration', 'manage_options', 'weu-smtp-config', 'weu_smtp_config_page' );



		add_submenu_page('weu-admin-page', 'WP Autoresponder Send', 'Send Autoresponder Email', 'manage_options', 'weu_email_setting', 'weu_email_setting');



		add_submenu_page('weu-admin-page', 'WP Autoresponder Manage', 'Settings', 'manage_options', 'weu_email_auto_config', 'weu_email_auto_config');



		add_submenu_page('weu-admin-page', 'List Manager', 'List Manager', 'manage_options', 'weu-manage-list', 'weu_admin_manage_list' );



		add_submenu_page('weu-admin-page', 'List Of Sent Emails', 'Sent Emails', 'manage_options', 'weu_sent_emails', 'weu_sent_emails');



		add_submenu_page( NULL,'List Editor','List Editor','manage_options','weu-list-editor','weu_list_editor');



   		remove_submenu_page('weu-admin-page','weu-admin-page');

    }

}



/**



 * Validate Unsubscribers/Subscribers It Works



 */



 function weu_isUnsubscribe($userId,$userEmail) {



	 	 global $wpdb;



		 $table_name = $wpdb->prefix.'weu_unsubscriber';



		 $myrows = $wpdb->get_row( "SELECT * FROM $table_name WHERE uid = $userId AND email = '$userEmail'" );



		 if ( count($myrows) != 0 ) {



			 return true;



		 } else {



			 return false;



		 }



 }

/**

* User Unsubscribe It Works

*/

function weu_userUnsubscibe($id,$email,$list) {

		$weu_arconf_buff = get_option( 'weu_ar_config_options' );

		$unubscribe_url = isset($weu_arconf_buff['rbtn_user_unsubscribe_url'])?$weu_arconf_buff['rbtn_user_unsubscribe_url']:'';

		$unsubscribe_link = add_query_arg( array(

			'id' => $id,

			'email' => $email,

			'list' => $list,

		), $unubscribe_url );

		$unsubscribe_link_details = '<a href="'.$unsubscribe_link.'">Unsubscribe</a>';

		return $unsubscribe_link_details;

}

/**



 * User check by array



 */



function weu_is_unsubscribe_arr($emails_arr) {



	global $wpdb;



	$sent_to_emails = array();



 	$table_name = $wpdb->prefix.'weu_unsubscriber';



	$unsubscribers = $wpdb->get_results( "SELECT `email` FROM $table_name");



	for ($i=0; $i < count($emails_arr) ; $i++) {



		if(!in_array($emails_arr[$i], $unsubscribers)){



		 	array_push($sent_to_emails, $emails_arr[$i]);



		}



	}



	return $sent_to_emails;



}



/**



 * Sent Emails



 **/



function weu_sent_emails() {



		global $wpdb;



		if(isset($_POST['submit-delete']))



		{



				$table_name = $wpdb->prefix.'weu_sent_email';



				$local_weu_sent_id = $_POST['submit-delete'];



				// Using where formatting.



				$mylink = $wpdb->delete( $table_name, array( 'weu_sent_id' => $local_weu_sent_id ), array( '%d' ) );



				if ( null !== $mylink ) { //It works



					echo '<div id="message" class="updated notice is-dismissible"><p>Email has been successfully deleted.</p></div>';



				} else {



					echo '<div class="error"><p>Email is not deleted.</p></div>';



				}



		 }



		$table_name = $wpdb->prefix.'weu_sent_email';



		$myrows = $wpdb->get_results( "SELECT * FROM $table_name" );



		echo '<div class="wrap"><h2> List Of All Sent Emails </h2></div><p>Here you will find the list of all Sent Emails which are sent through this (WP Email Users) plugin.</p>';



		echo '<table id="example5" class="display alluser_datatable" cellspacing="0" width="100%">



					<thead>



							<tr style="text-align:left"> <th style="text-align:center" ><input name="select_all" value="1" id="example-select-all" class="select-all" type="checkbox"></th>



								<th>From Name</th>



								<th>From Email</th>



								<th>Subject</th>



								<th>Email Type</th>



								<th>User Type</th>



								<th>Date-Time</th>



								<th>Status</th>



					 			<th>Delete</th>



							</tr>



					</thead>



				<tbody>';



		foreach ( $myrows as $user ){







			$status = esc_html( $user->weu_status );



			if ($status == 1) {



				$status_result = "Sent";



			} else {



				$status_result = "Failed";



			}



			$sent_email_id = $user->weu_sent_id;







		echo '<tr style="text-align:left">';



		echo '<td style="text-align:center"><input type="checkbox" name="ea_user_name[]" value="'.$user->weu_sent_type.'" class="select-all"></td>';



		echo '<td><span id="getDetail">'. esc_html( $user->weu_from_name ).'</span></td>';



		echo '<td><span >'.esc_html( $user->weu_from_email ).'</span></td>';



		echo '<td><span >'.esc_html( $user->weu_email_subject ).'</span></td>';



		echo '<td><span >'.esc_html( $user->weu_sent_type ).'</span></td>';



		echo '<td><span >'.esc_html( $user->weu_to_type ).'</span></td>';



		echo '<td><span >'.esc_html( $user->weu_sent_date_time ).'</span></td>';



		echo '<td><span class="status-'.$status_result.'">'.$status_result.'</span></td>';



		echo '<td><form action="" method="post">



									<button class="delete-email-indi" name="'.$sent_email_id.'" type="submit" value="" ><span class="dashicons dashicons-trash"></span></button>



									<input type="hidden" name="submit-delete" value="'.$sent_email_id.'" >



							</form></td>';



		echo '</tr>';}



		echo'</tbody></table>'; // end user Data table for user



	}











/**



 * WP NEW USER REGISTER



 **/



		function wp_registration_send( $user_id ) {


			$current_user = wp_get_current_user();

			$from_email=$current_user->user_email;

			$user = new WP_User( $current_user->ID );

			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
			    foreach ( $user->roles as $role )
			    	$role;
			};



		    $from_name=$current_user->display_name;


			global $wpdb;



			$table_name = $wpdb->prefix.'weu_user_notification';



  			$myrows = $wpdb->get_results( "SELECT template_value, email_for,email_by,email_value FROM $table_name WHERE email_for = 'New User Register'" );



			if ( count($myrows) != 0 ){ 	// chack if table is empty



  			$to=array();



			if($myrows[0]->email_by=='role'){



						$role_res=unserialize($myrows[0]->email_value);



						for($k=0;$k<count($role_res);$k++){



						     	$args = array(



									'role' => $role_res[$k]



								);



							    	$wau_grp_users=get_users( $args ); //get all users



								   	for($m=0;$m<count($wau_grp_users);$m++){



								   	array_push($to,$wau_grp_users[$m]->data->user_email);



									}



							}



				}



			else{



  					$to=unserialize($myrows[0]->email_value);



				}



				$userdata=get_user_by('id',$user_id);



				$useremail=$userdata->data->user_email;



				array_push($to, $useremail);



		 		$subject = get_option( 'weu_new_user_register', 'Welcome to Wordpress' );



				$replace = array(



					$userdata->data->user_login,



					$useremail



		  		);



				$find = array(



				'[[username]]',



				'[[useremail]]'



				);


				$body = str_replace( $find, $replace, $myrows[0]->template_value );



				$headers[] = 'Content-Type: text/html; charset="UTF-8"';



				$to = array_filter($to,"weu_is_unsubscribe_arr");



				$wau_status = wp_mail($to, $subject, $body, $headers);



				/* INSERT VALUE INTO weu_sent_email TABLE AFTER SENDING THE EMAIL */


				$get_sent_type = "New User Register";


				$get_subject = $subject;


				$get_body = $body;


				$get_from_name = $from_name;


				$get_from_email = $from_email;


				$get_user_role = $role;



				$get_status = $wau_status;



				$get_current_date = current_time( 'mysql' );



                /*EMAIL SENT TABLE EXISTS CHECK*/



				$table_name_sent_email = $wpdb->prefix.'weu_sent_email';



				weu_setup_activation_data();



				/*EMAIL SENT DETAILS INSERT */


				// $query_test = ("INSERT INTO `".$table_name_sent_email."`(`weu_sent_type`, `weu_email_subject`, `weu_email_body`, `weu_from_name`, `weu_from_email`, `weu_to_type`, `weu_status`, `weu_sent_date_time`) VALUES ($get_sent_type,$get_subject,$get_body,$get_from_name,$get_from_email,$get_user_role,$get_status,$get_current_date)");
				// $wpdb->query($wpdb->prepare( $query_test ));
				$wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name_sent_email."`(`weu_sent_type`, `weu_email_subject`, `weu_email_body`, `weu_from_name`, `weu_from_email`, `weu_to_type`, `weu_status`, `weu_sent_date_time`) VALUES (%s,%s,%s,%s,%s,%s,%d,%s)",



				$get_sent_type,$get_subject,$get_body,$get_from_name,$get_from_email,$get_user_role,$get_status,$get_current_date));
			}



		}



/* End User Notification */







/**



 * WP NEW POST PUBLISH



 **/



		function wp_post_published_notification( $ID, $post ) {


			$current_user = wp_get_current_user();

			$wau_status = "";

			$from_email=$current_user->user_email;

			$user = new WP_User( $current_user->ID );

			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
					foreach ( $user->roles as $role )
						$role;
			};



				$from_name=$current_user->display_name;


			global $wpdb;



				$author = $post->post_author; /* Post author ID. */



			    $name = get_the_author_meta( 'display_name', $author );



			    $email = get_the_author_meta( 'user_email', $author ); //who Post add



			    $title = $post->post_title;



			    $post_type = $post->post_type;



			    $permalink = get_permalink( $ID );



			    $edit = get_edit_post_link( $ID, '' );



			    $subject_def = 'Published: ' .$title;



				$subject = get_option( 'weu_new_post_publish', $subject_def);



				global $wpdb;



				$table_name = $wpdb->prefix.'weu_user_notification';



				$myrows = $wpdb->get_results( "SELECT template_value, email_for,email_by,email_value FROM $table_name WHERE email_for = 'New Post Publish'" );



				if ( count($myrows) != 0 ){ 	// chack if table is empty



					$to=array();



					if($myrows[0]->email_by=='role'){



						$role_res=unserialize($myrows[0]->email_value);



					for($k=0;$k<count($role_res);$k++){



							     	$args = array(



										'role' => $role_res[$k]



									);



							    	$wau_grp_users=get_users( $args ); //get all users



								   	for($m=0;$m<count($wau_grp_users);$m++){



								   	array_push($to,$wau_grp_users[$m]->data->user_email);



									}



								}



						}



					else{



		  				$to=unserialize($myrows[0]->email_value);  // to which you want to send mail



		  			}



				   	$message = $myrows[0]->template_value;



				    $message .= sprintf( 'View: %s', $permalink );



				    $headers[] = 'Content-Type: text/html; charset="UTF-8"';



				    $wau_status = wp_mail( $to, $subject, $message, $headers );



					/* INSERT VALUE INTO weu_sent_email TABLE AFTER SENDING THE EMAIL */



						$get_sent_type = "New Post Publish";



						$get_subject = $subject;



						$get_body = $body;



						$get_from_name = $from_name;



						$get_from_email = $from_email;



						$get_user_role = $role;



						$get_status = $wau_status;



						$get_current_date = current_time( 'mysql' );



                		/*EMAIL SENT TABLE EXISTS CHECK*/



      					$table_name_sent_email = $wpdb->prefix.'weu_sent_email';



      					weu_setup_activation_data();



						/*EMAIL SENT DETAILS INSERT */



						$wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name_sent_email."`(`weu_sent_type`, `weu_email_subject`, `weu_email_body`, `weu_from_name`, `weu_from_email`, `weu_to_type`, `weu_status`, `weu_sent_date_time`) VALUES (%s,%s,%s,%s,%s,%s,%d,%s)",



						$get_sent_type,$get_subject,$get_body,$get_from_name,$get_from_email,$get_user_role,$get_status,$get_current_date));



				}



			}



/* End Post Notifiaction */







/**



 * WP LOST PASSWORD



 **/



    	function weu_my_password_reset( $user, $new_pass ) {

				$current_user = wp_get_current_user();


				$from_email=$current_user->user_email;

				$user = new WP_User( $current_user->ID );

				if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
						foreach ( $user->roles as $role )
							$role;
				};



					$from_name=$current_user->display_name;

				global $wpdb;



			$name= $user->data->user_login;



			$to = $user->data->user_email;


    		$headers[] = '';



			$subject = get_option( 'weu_password_reset', 'Password Changed');



			$replace = array(



							$name,



							$new_pass



			  			);



						$find = array(



						'[[name]]',



						'[[password]]'



						);



			$body = str_replace( $find, $replace, $myrows[0]->template_value );


		 	if( !weu_isUnsubscribe( $user->ID , $to ) ) {



				wp_mail( $to, $subject, $body, $headers );


	    	}







			/* INSERT VALUE INTO weu_sent_email TABLE AFTER SENDING THE EMAIL */



						$get_sent_type = "Password Reset";



						$get_subject = $subject;



						$get_body = $body;



						$get_from_name = $from_name;



						$get_from_email = $from_email;



						$get_user_role = $role;



						$get_status = $wau_status;



						$get_current_date = current_time( 'mysql' );






              			/*EMAIL SENT TABLE EXISTS CHECK*/



    					$table_name_sent_email = $wpdb->prefix.'weu_sent_email';



    					weu_setup_activation_data();






						/*EMAIL SENT DETAILS INSERT */



						$wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name_sent_email."`(`weu_sent_type`, `weu_email_subject`, `weu_email_body`, `weu_from_name`, `weu_from_email`, `weu_to_type`, `weu_status`, `weu_sent_date_time`) VALUES (%s,%s,%s,%s,%s,%s,%d,%s)",



						$get_sent_type,$get_subject,$get_body,$get_from_name,$get_from_email,$get_user_role,$get_status,$get_current_date));


    		}







/* End Lost Password */







/**



 * WP POST COMMENT



 **/



function show_message_function( $comment_id ) {

	$wau_status = "";

	$current_user = wp_get_current_user();

	$from_email=$current_user->user_email;

	$user = new WP_User( $current_user->ID );

	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
			foreach ( $user->roles as $role )
				$role;
	};



		$from_name=$current_user->display_name;


	global $wpdb;



$table_name = $wpdb->prefix.'weu_user_notification';



	$myrows = $wpdb->get_results( "SELECT template_value, email_for,email_by,email_value FROM $table_name WHERE email_for = 'New Comment Post'" );



			$to=array();



			if($myrows[0]->email_by=='role'){



						$role_res=unserialize($myrows[0]->email_value);



				for($k=0;$k<count($role_res);$k++){



						     	$args = array(



									'role' => $role_res[$k]



								);



							    	$wau_grp_users=get_users( $args ); //get all users



								   	for($m=0;$m<count($wau_grp_users);$m++){



								   	array_push($to,$wau_grp_users[$m]->data->user_email);



									}



							}



				}



			else{



  			$to=unserialize($myrows[0]->email_value);



  		}



		$the_comment = get_comment( $comment_id );



		$post = get_post( $the_comment->comment_post_ID );



		$post_author_id=$post->post_author;



		$post_author_details=get_user_by('id', $post_author_id);



		$to_author=$post_author_details->data->user_email;



		array_push($to, $to_author);



		$subject_cm_def =sprintf('comment : "%s" ' . "\n\n", $post->post_title);



		$subject = get_option( 'weu_new_comment_post', $subject_cm_def);



						$replace = array(



							$post->post_title,



							$the_comment->comment_author,



							$the_comment->comment_author_email,



							$the_comment->comment_content



				  		);



						$find = array(



						'[[title]]',



						'[[Author]]',



						'[[Email]]',



						'[[Comment]]'



						);



						$message = str_replace( $find, $replace, $myrows[0]->template_value );



						$headers[] = 'Content-Type: text/html; charset="UTF-8"';

						

						$wau_status = wp_mail( $to, $subject, $message, $headers );



						/* INSERT VALUE INTO weu_sent_email TABLE AFTER SENDING THE EMAIL */


						$get_sent_type = "New Comment Publish";



						$get_subject = $subject;



						$get_body = $body;



						$get_from_name = $from_name;


						$get_from_email = $from_email;


						$get_user_role = $role;



						$get_status = $wau_status;



						$get_current_date = current_time( 'mysql' );







                		/*EMAIL SENT TABLE EXISTS CHECK*/



      					$table_name_sent_email = $wpdb->prefix.'weu_sent_email';



      					weu_setup_activation_data();



						/*EMAIL SENT DETAILS INSERT */



						$wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name_sent_email."`(`weu_sent_type`, `weu_email_subject`, `weu_email_body`, `weu_from_name`, `weu_from_email`, `weu_to_type`, `weu_status`, `weu_sent_date_time`) VALUES (%s,%s,%s,%s,%s,%s,%d,%s)",



						$get_sent_type,$get_subject,$get_body,$get_from_name,$get_from_email,$get_user_role,$get_status,$get_current_date));



					}



/**



 * WP USER ROLE CHENGED



 **/



function wp_role_changed( $user_id, $new_role, $old_role ) {



if(!empty($old_role)) {



		if($old_role[0]!=''){

			$wau_status = "";

			$current_user = wp_get_current_user();

			$from_email=$current_user->user_email;

			$user = new WP_User( $current_user->ID );

			if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
					foreach ( $user->roles as $role )
						$role;
			};



				$from_name=$current_user->display_name;


			global $wpdb;



		$table_name = $wpdb->prefix.'weu_user_notification';



		$myrows = $wpdb->get_results( "SELECT template_value, email_for,email_by,email_value FROM $table_name WHERE email_for = 'User Role Changed'" );



		$user = get_user_by('id',$user_id);



		$to=$user->data->user_email;



		$subject = get_option( 'weu_user_role_changed', 'User Role Changed!');



							$replace = array(



								$old_role[0],



								$new_role



					  		);



							$find = array(



							'[[old role]]',



							'[[new role]]'



							);



							$message = str_replace( $find, $replace, $myrows[0]->template_value );



		$headers[] = 'Content-Type: text/html; charset="UTF-8"';



	 	if( !weu_isUnsubscribe( $user_id , $to ) ) {



			$wau_status = wp_mail( $to, $subject, $message, $headers );



	    }



						$get_sent_type = "User Role Changed";



						$get_subject = $subject;



						$get_body = $body;



						$get_from_name = $from_name;



						$get_from_email = $from_email;



						$get_user_role = $role;



						$get_status = $wau_status;



						$get_current_date = current_time( 'mysql' );







					/*EMAIL SENT TABLE EXISTS CHECK*/



					$table_name_sent_email = $wpdb->prefix.'weu_sent_email';



					weu_setup_activation_data();







					/*EMAIL SENT DETAILS INSERT */



					$wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name_sent_email."`(`weu_sent_type`, `weu_email_subject`, `weu_email_body`, `weu_from_name`, `weu_from_email`, `weu_to_type`, `weu_status`, `weu_sent_date_time`) VALUES (%s,%s,%s,%s,%s,%s,%d,%s)",



					$get_sent_type,$get_subject,$get_body,$get_from_name,$get_from_email,$get_user_role,$get_status,$get_current_date));



		}



	}



}



$weu_arconf_sett = array();



$weu_arconf_sett = get_option( 'weu_ar_config_options' );



$temp_ar_rc = isset($weu_arconf_sett['weu_arconfig_role_change'])?$weu_arconf_sett['weu_arconfig_role_change']:'';



$temp_ar_ppub = isset($weu_arconf_sett['weu_arconfig_post_pub'])?$weu_arconf_sett['weu_arconfig_post_pub']:'';



$temp_ar_cpub = isset($weu_arconf_sett['weu_arconfig_comment_pub'])?$weu_arconf_sett['weu_arconfig_comment_pub']:'';



$temp_ar_pas_reset = isset($weu_arconf_sett['weu_arconfig_pass_reset'])?$weu_arconf_sett['weu_arconfig_pass_reset']:'';



$temp_ar_ureg = isset($weu_arconf_sett['weu_arconfig_user_reg'])?$weu_arconf_sett['weu_arconfig_user_reg']:'';



if($temp_ar_rc =='' || $temp_ar_rc =='on') {



	add_action( 'set_user_role', 'wp_role_changed', 10, 3 );



}



if($temp_ar_cpub =='' || $temp_ar_cpub =='on') {



	add_action( 'comment_post', 'show_message_function', 10, 2 );



}



if($temp_ar_pas_reset =='' || $temp_ar_pas_reset =='on') {



	add_action( 'password_reset', 'weu_my_password_reset', 10, 2 );



}



if($temp_ar_ppub =='' || $temp_ar_ppub =='on') {



	add_action( 'publish_post', 'wp_post_published_notification', 10, 2 );



}



if($temp_ar_ureg =='' || $temp_ar_ureg =='on') {



	add_action( 'user_register', 'wp_registration_send', 10, 1 );



}



add_action('admin_menu', 'add_weu_custom_menu');



function weu_setup_activation_data() {



		global $wpdb, $table_prefix;//Fixed



		$table_name = $wpdb->prefix.'email_user';



			if($wpdb->get_var("show tables like '$table_name'") != $table_name){



				$sql = "CREATE TABLE $table_name(



                        id int(11) NOT NULL AUTO_INCREMENT,



                        template_key varchar(20) NOT NULL,



                        template_value longtext NOT NULL,



                        status varchar(20) NOT NULL,



                        UNIQUE KEY id(id)



                     );";



		        $rs = $wpdb->query($sql);



			}



			$table_name_notifi = $wpdb->prefix.'weu_user_notification';



			if($wpdb->get_var("show tables like '$table_name_notifi'") != $table_name_notifi){



				$sql = "CREATE TABLE $table_name_notifi(



	                    id int(11) NOT NULL AUTO_INCREMENT,



	                    template_id int(11) NOT NULL,



	                    template_value longtext NOT NULL,



	                   	email_for varchar(20) NOT NULL,



	                   	email_by varchar(20) NOT NULL,



	                   	email_value longtext NOT NULL,



	                    UNIQUE KEY id(id)



	                 );";



	        	$rs2 = $wpdb->query($sql);



	        }







          /*EMAIL SENT TABLE STARTS*/



      		$table_name_sent_email = $wpdb->prefix.'weu_sent_email';



      		if($wpdb->get_var("show tables like '$table_name_sent_email'") != $table_name_sent_email){



      		$sql = "CREATE TABLE $table_name_sent_email(



						weu_sent_id INT unsigned NOT NULL AUTO_INCREMENT,



						weu_sent_type VARCHAR(25),



						weu_email_subject varchar(100) NOT NULL,



						weu_email_body longtext NOT NULL,



						weu_from_name varchar(50) NOT NULL,



						weu_from_email varchar(50) NOT NULL,



						weu_to_type varchar(25) NOT NULL,



						weu_status int(1) NOT NULL,



						weu_sent_date_time datetime NOT NULL default '0000-00-00 00:00:00',



						PRIMARY KEY (weu_sent_id)



				 		);";



      				$rs3 = $wpdb->query($sql);



      		}



			/*EMAIL SENT TABLE ENDS*/







        	$table_name_subscribe = $wpdb->prefix.'weu_subscribers';



			if($wpdb->get_var("show tables like '$table_name_subscribe'") != $table_name_subscribe){



			$sql = "CREATE TABLE $table_name_subscribe(



		                id int(11) NOT NULL AUTO_INCREMENT,



		                name varchar(100) NOT NULL,



		                email varchar(100) NOT NULL,



		               	list varchar(100) NOT NULL,



		       	  		status int(11) NOT NULL,



		               	authtoken int(11) NOT NULL,



		               	datetime datetime NOT NULL default '0000-00-00 00:00:00',



		                UNIQUE KEY id(id)



		             );";



		    	$rs4 = $wpdb->query($sql);



			}



			$table_name_unsubscribe = $wpdb->prefix.'weu_unsubscriber';



			if($wpdb->get_var("show tables like '$table_name_unsubscribe'") != $table_name_unsubscribe){



			$sql = "CREATE TABLE $table_name_unsubscribe(



		                id int(11) NOT NULL AUTO_INCREMENT,



		                uid int(30) NOT NULL,



		                email varchar(100) NOT NULL,



		               	datetime datetime NOT NULL,



		                UNIQUE KEY id(id)



		             );";



		    	$rs5 = $wpdb->query($sql);

			}

			$weu_arconf_buff = get_option( 'weu_ar_config_options' );

			if(empty($weu_arconf_buff)){

			$weu_temp_config = array();

			$weu_temp_config["weu_arconfig_user_reg"] = "off";

			$weu_temp_config["weu_arconfig_post_pub"] = "off";

			$weu_temp_config["weu_arconfig_comment_pub"] = "off";

			$weu_temp_config["weu_arconfig_pass_reset"] = "off";

			$weu_temp_config["weu_arconfig_role_change"] = "off";

			$weu_temp_config["weu_arconfig_buddypress"] = "no";

			$weu_temp_config["rbtn_user_unsubscribe_url"] = "";

			$weu_temp_config["rbtn_user_unsubscribe_success"] = "";

			$weu_temp_config["rbtn_user_unsubscribe_failure"] = "";


			$option = "weu_ar_config_options";

 			add_option( $option, $weu_temp_config );

 		}

 		$weu_arconf = get_option( 'weu_subscriber_lists' );

			if(empty($weu_arconf_buff)){

			$weu_temp_list = array();

 			$weu_temp_list[] = "default";

 			$options = "weu_subscriber_lists";

 			add_option($options, $weu_temp_list);

 		}

}

register_activation_hook( __FILE__ , 'weu_setup_activation_data' );

?>
