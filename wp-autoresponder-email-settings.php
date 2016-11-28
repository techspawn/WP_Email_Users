<?php
function weu_email_setting(){

		echo "<div class='wrap'>";

		echo "<h2>Autoresponder Email Settings </h2>";

		echo "</div>"; /*end header */

		echo'</br>';

		echo '<form name="autoresponder" class="wau_form" method="POST" action="#" onsubmit="return validation_responder()">';

    	echo '<table id="" class="form-table" >';

		echo '<tbody>';

	global $wpdb; 

	$table_name = $wpdb->prefix.'email_user'; 	

	$myrows = $wpdb->get_results( "SELECT id, template_key, template_value FROM $table_name WHERE status = 'template'" );

	$template_path_one = WP_EMAIL_USERS_PLUGIN_URL.'/template1.html';

	$template_path_two = WP_EMAIL_USERS_PLUGIN_URL.'/template2.html';

	$template_path_three = WP_EMAIL_USERS_PLUGIN_URL.'/new-comment-post.html';

	$template_path_four = WP_EMAIL_USERS_PLUGIN_URL.'/new-post-publish.html';

	$template_path_five = WP_EMAIL_USERS_PLUGIN_URL.'/new-user-register.html';

	$template_path_six = WP_EMAIL_USERS_PLUGIN_URL.'/password-reset.html';

	$template_path_seven = WP_EMAIL_USERS_PLUGIN_URL.'/user-role-changed.html';



/*------------------Email for Row-------------*/



	echo  '<tr>';	

	echo  '<th>Send Email For  </th>';

	echo  '<td colspan="3"><select name="user_email[]" class="wau_boxlen" id="email_role" >';

	echo  '<option >-- Select --</option>';

	echo  '<option value="1-New User Register"> New User Register </option>';

	echo  '<option value="2-New Post Publish" > New Post Publish </option>';

	echo  '<option value="3-New Comment Post" > New Comment Post </option>';

	echo  '<option value="4-Password Reset" > Password Reset </option>';

	echo  '<option value="5-User Role Changed" > User Role Changed </option>';	

	echo '</select></td>';

	echo '</tr>';

	/*----End email for--------*/

	$wau_users=get_users();				

	$ar_conf_page = admin_url( "admin.php?page=weu_email_auto_config");

	echo '<tr id="drop_hide">';				

	echo "<th><b>Send Email To &nbsp; </b></th>";

	echo '<td style="width: 224px"><input type="radio" name="rbtn_respond" id="user_role_email" onclick="radioFunction_responder()" value="user" checked > User &nbsp;</td>';

	echo '<td style="width: 224px"><input type="radio" name="rbtn_respond" id="r_role_email" onclick="radioFunction_responder()" value="role"> Role </td>';

	echo "</tr>";

	/**

    * Select Users

    */ 

    echo '<tr class="wau_user_toggle"><th></th><td colspan="3">';

	echo '<table id="example4" class="display alluser_datatable" cellspacing="0" width="100%">

	        <thead>

	            <tr style="text-align:left"> <th style="text-align:center" ><input name="select_all" value="1" id="example-responder" class="select-all" type="checkbox"></th>

	                 <th>Display name</th>

	                 <th>Email</th>

	            </tr>

	        </thead>    

	        <tbody>';

	foreach ( $wau_users as $user ){

	echo '<tr style="text-align:left">';

	echo '<td style="text-align:center"><input type="checkbox" name="ea_user_name[]" value="'.$user->ID.'" class="select-all"></td>';

	echo '<td><span id="getDetail">'. esc_html( $user->display_name ).'</span></td>';

	echo '<td><span >'.esc_html( $user->user_email ).'</span></td>';

	echo '</tr>';}

	echo'</tbody></table>'; // end user Data table for user

	echo '</td></tr>';

	foreach ( $wau_users as $user ) {

		echo  '<input type="hidden" name="' . esc_html( $user->ID ) . '" value="'. esc_html( $user->user_email ) . '">';

	}

	

//-----------------

	/*---start send to row---*/

	echo  '<tr id="wau_user_responder" style="display:none">';	

	echo  '<th>Select Roles</th>';

	echo  '<td colspan="3"><select name="user_role[]" multiple class="wau_boxlen" id="wau_role" >';

	echo  '<option value="" selected disabled >-- Select Role --</option>';

	echo  '<option> Administrator </option>';

	echo  '<option> Subscriber </option>';

	echo  '<option> Contributor </option>';

	echo  '<option> Author </option>';

	echo  '<option> Editor </option>';	

	echo '</select></td>';

	echo '</tr>';



		/*---end send to row---*/

	echo '<tr>';

	echo '<th>Template</th><td colspan="3"><select autocomplete="off" id="wau_template_single" name="mail_template[]" class="wau-template-selector" style="width:100%; height: 50px ">

        <option selected >Select Template Here...</option>

        <option disabled >----Default Template---</option>

        <option value="'.$template_path_one.'" id="wau_template_t1"> Default Template - 1 </option>

        <option value="'.$template_path_two.'" id="wau_template_t2"> Default Template - 2 </option>';

    echo '<option disabled >------New Event Template------ </option>';    

    echo '<option value=" '.$template_path_five.' "> New User Register </option>';

	echo '<option value=" '.$template_path_four.' "> New Post Publish </option>';

	echo '<option value=" '.$template_path_three.' "> New Comment Post </option>';

	echo '<option value=" '.$template_path_six.' "> Password Reset </option>';

	echo '<option value=" '.$template_path_seven.' "> User Role Changed </option>';

	echo '<option disabled>------ User Created Template------ </option>';



        for ($i=0;$i<count($myrows);$i++) {

        echo '<option value="'.$myrows[$i]->id.'" id="am" >'.$myrows[$i]->template_key.'</option>';   }

       '</select></td>';

    $mail_content="";

	echo '</tr>';

	echo '<tr>';

	echo '<th>Template Name</th>';

	echo '<td colspan="3"><input type="text" name="wau_temp" class="wau_boxlen" id="weu_temp_name" placeholder="Template Name" required=""></td>';

	echo '</tr>';

	echo '<tr>';

	echo '<th>Email Subject</th>';

	echo '<td colspan="3"><input type="text" name="wau_temp_subject" class="wau_boxlen" id="weu_sub_name" placeholder="Email Subject"></td>';

	echo '</tr>';

	echo '<th scope="row" valign="top"><label for="weu_show_area">Message</label></th>';

    echo '<td colspan="2">';

	echo '<div id="msg" class="wau_boxlen" name="weu_show_area">';	

		wp_editor($mail_content, "weu_show_area",array('wpautop'=>false,'media_buttons' => true));

	echo '</div><p>Please make sure you turned autoresponder emails on <a href='.$ar_conf_page.'>here</a></p></td>';

    echo '</tbody>';

	echo '</table>';

	echo '<input type="submit" value="Save" style="margin-left: 30%;" class="button button-hero button-primary" name="save_template">  ';

	echo '<input type="submit" value="Delete" id="weu_delete_template" class="button button-hero button-primary" name="delete_template" >';

	echo '</form>';

}



if(isset($_POST['rbtn_respond'])&& $_POST['rbtn_respond'] !=''){

$wau_to=array();

if(isset($_POST['rbtn_respond']) && $_POST['rbtn_respond'] =='user'){



		if(isset($_POST['ea_user_name'])) {

			for($j=0;$j<count($_POST['ea_user_name']);$j++){


				$user= $_POST['ea_user_name'][$j];

				array_push($wau_to,$_POST[$user]);

			}

		$get_role_value=serialize($wau_to);

		}

	}

elseif(isset($_POST['rbtn_respond']) && $_POST['rbtn_respond'] =='role'){


for($k=0;$k<count($_POST['user_role']);$k++){

		     	$group_role = array(

					'role' => $_POST['user_role'][$k]

				);

			    	$wau_grp_users=get_users( $group_role ); //get all users

				   	for($m=0;$m<count($wau_grp_users);$m++){

				   	array_push($wau_to,$wau_grp_users[$m]->data->user_email);

					}

			}

			$get_role_value=serialize($_POST['user_role']); // get all selected roles

			

		}



/*For email By Dropdown */

$user_email_count=isset($_POST['user_email'])? $_POST['user_email']:'';

for($k=0;$k<count($user_email_count);$k++){

		     	$email_by_val = array(

					'role' => $_POST['user_email'][$k]

				);

			}

			$event_val=$email_by_val['role'];

			$event_val=explode("-",$event_val);



		/*End*/

/*For Template Dropdown Menu*/

for($k=0;$k<count($_POST['mail_template']);$k++){

		     	$temp_url = array(

					'role' => $_POST['mail_template'][$k]

				);

			}

		/* End*/

	weu_setup_activation_data();

	$table_name = $wpdb->prefix.'weu_user_notification';

	$myrows = $wpdb->get_results( "SELECT template_id FROM $table_name" );

	$all_temp_id=array();

	for($i=0;$i<count($myrows);$i++){

		array_push($all_temp_id, $myrows[$i]->template_id);

	}

	switch($event_val[0]){

		case 1:

		if(isset($_POST['wau_temp_subject']) && $_POST['wau_temp_subject'] !=''){

			update_option( 'weu_new_user_register', $_POST['wau_temp_subject'] );

		}

		break;



		case 2:

		if(isset($_POST['wau_temp_subject']) && $_POST['wau_temp_subject'] !=''){

			update_option( 'weu_new_post_publish', $_POST['wau_temp_subject'] );

		}

		break;

		

		case 3:

		if(isset($_POST['wau_temp_subject']) && $_POST['wau_temp_subject'] !=''){

			update_option( 'weu_new_comment_post', $_POST['wau_temp_subject'] );

		}

		break;

		

		case 4:

		if(isset($_POST['wau_temp_subject']) && $_POST['wau_temp_subject'] !=''){

			update_option( 'weu_password_reset', $_POST['wau_temp_subject'] );

		}

		break;

		

		case 5:

		if(isset($_POST['wau_temp_subject']) && $_POST['wau_temp_subject'] !=''){

			update_option( 'weu_user_role_changed', $_POST['wau_temp_subject'] );

		}

		break;

	}

			if(in_array( $event_val[0],$all_temp_id)){ 

			$wpdb->query($wpdb->prepare("UPDATE $table_name SET `template_value` = %s, `email_for` = %s, `email_by` = %s, `email_value` = %s WHERE `template_id` = ".$event_val[0].";",$_POST['weu_show_area'], $event_val[1], $_POST['rbtn_respond'], $get_role_value) );

			echo "SETTING UPDATED";

			} else { 

			$wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name."`(`template_id`,`template_value`,`email_for`,`email_by`,`email_value`) VALUES (%d,%s,%s,%s,%s)",

				$event_val[0],$_POST['weu_show_area'],$event_val[1],$_POST['rbtn_respond'],$get_role_value));

			echo "SETTING SAVED";

	}

}