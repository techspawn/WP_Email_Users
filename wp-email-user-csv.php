<?php
$wau_to=array();
if( isset($_POST['rbtn_csv']) && $_POST['rbtn_csv'] == 'user'){ 
		for($j=0;$j<count($_POST['ea_user_name']);$j++){
			$user= $_POST['ea_user_name'][$j];
			$first_name = get_user_meta( $user,'first_name');
	        $last_name = get_user_meta( $user,'last_name');
			$wau_to['first'][$j]=$first_name[0];
			$wau_to['last'][$j]=$last_name[0];
			$wau_to['email'][$j]=$_POST[$user];
		}
		 header("Content-type: application/vnd.ms-excel");
		 header("Content-Encoding: UTF-8");
		 header("Content-Type: text/html; charset=utf-8");
		 header("Content-disposition: csv" . date("Y-m-d"). "csv");
		 header("Content-disposition: attachment; filename=subscribers.xls");
		 echo '<table><thead><th>First Name</th><th>Last Name</th><th>Email Address</th></thead><tbody>';
			    for($j=0;$j<count($wau_to['email']);$j++){
				echo '<tr><td>'.$wau_to['first'][$j].'</td><td>'.$wau_to['last'][$j].'</td><td>'.$wau_to['email'][$j].'</td></tr>';
			}
		 echo '</tbody></table>';
		 exit();
		 }elseif( isset($_POST['rbtn_csv']) && $_POST['rbtn_csv'] =='role'){
		 	for($k=0;$k<count($_POST['user_role']);$k++){
		     	$args = array(
					'role' => $_POST['user_role'][$k]
				);
			    	$wau_grp_users=get_users( $args ); //get all users	

			for($m=0;$m<count($wau_grp_users);$m++){
				   		$user=$wau_grp_users[$m]->data->ID;
				   		$first_name = get_user_meta( $user,'first_name');
	    			    $last_name = get_user_meta( $user,'last_name');
	    			    $wau_to['First'][]=$first_name[0];
						$wau_to['Last'][]=$last_name[0];
						$wau_to['email'][]=$wau_grp_users[$m]->data->user_email;
				  	 	//array_push($wau_to[],$wau_grp_users[$m]->data->user_email);
					}
			}
			//print_r($wau_to);	
		 header("Content-type: application/vnd.ms-excel");
		 header("Content-Encoding: UTF-8");
		 header("Content-Type: text/html; charset=utf-8");
		 header("Content-disposition: csv" . date("Y-m-d"). "csv");
		 header("Content-disposition: attachment; filename=ExportUsers.xls");
		 echo '<table><thead><th>First Name</th><th>Last Name</th><th>Email Address</th></thead>
			   <tbody>';
			    for($j=0;$j<count($wau_to['email']);$j++){
				echo '<tr><td>'.$wau_to['First'][$j].'</td><td>'.$wau_to['Last'][$j].'</td><td>'.$wau_to['email'][$j].'</td></tr>';
			}
		 echo '</tbody></table>';
		 exit();
	}
	function weu_members_import(){
		echo "<div class='wrap'>";
		echo "<h2>WP Email User Members Import & Export </h2>";
		echo "</div>"; /*end header */
		echo'</br>';
/*----------------------- Left Data Table for CSV PAGE----------------------*/
echo '<div style="float:left;width: 75%; background-color: #fff;padding: 18px;border-top: 10px solid #F1F1F1;">';
	echo '<form name="impot_form" class="" style="width:87%;" method="POST" action="#" enctype="multipart/form-data">';
	echo '<h2>Import CSV</h2>';
	echo '<table id="" class="form-table" >';
	echo '<tbody>';
	echo '<tr>';
	echo '<td><input type="file" name="uploadfiles" id="uploadfiles" size="35" class="uploadfiles">
	      </td>';
	echo '<td><input class="button-primary" type="submit" name="uploadfile" id="uploadfile_btn" value="Import CSV">
	      </td>';
	echo '</tr>';
	echo '</tbody>';
    echo '</table>'; 
    echo '<i style="font-size: 12px;">Upload CSV File Formate: User First Name, Last Name, Email Address </i>';
	echo '</form>';
	echo '<table style="float:left" id="example2" class="display allcsvlist_datatable" cellspacing="0" width="100%">
	        <thead>
	            <tr style="text-align:left"> <th style="text-align:center" ><input name="select_all_export" value="1" id="example-select-all-import" class="select-all" type="checkbox">
	                 <th>CSV File</th>
	                 <th>Show Users</th>
	                 <th>Delete File</th>
	            </tr>
	        </thead>    
	        <tbody>';
	global $wpdb;        
	$table_name = $wpdb->prefix.'email_user';
	$myrows = $wpdb->get_results( "SELECT id,template_key FROM $table_name WHERE status = 'csv'" );
	foreach ( $myrows as $csv_file ){
	echo '<tr style="text-align:left">';
	echo '<td style="text-align:center"><input type="checkbox" name="export_csv_file_id[]" value="'. esc_html( $csv_file->id ) . '" class="select-all"></td>';
	echo '<input type="hidden" class="weu_csv" name="CSV_ID" value="'. esc_html( $csv_file->id ) . '">';
	echo '<td><span id="getDetail" class="weu_csv">'. esc_html( $csv_file->template_key ).'</span></td>';
	echo '<td><a href="#" class="editor_edit ">show file</a></td>';
	echo '<td><a href="#" class="editor_remove dashicons dashicons-trash"></a></td>';
	echo '</tr>';
		}
	echo'</tbody></table></br>';
	echo '<div id="csv_textarea"></div>';
	echo "<input type='hidden' name='weu_temp_update' id='weu_temp_update' value=''>";
	echo '</div>';
	/*End Left Data Table*/

	echo '<div style="float:left; width:75%; background-color: #fff;padding: 18px;border-top: 10px solid #F1F1F1;">';
	echo '<form name="export_form" class="" style="width: 55%;" method="POST" action="#" enctype="multipart/form-data" onsubmit="return validation_csv()">';
	echo'<h2>Export CSV</h2>';
	echo '<table id="" class="form-table">';
	echo '<tbody>'; 
	$wau_users=get_users(); //get all wp users
	echo '<tr>';   
	echo '<td><input type="radio" name="rbtn_csv" id="user_role_csv" onclick="radioFunction_csv()" value="user" checked > User &nbsp</td>';
	echo '<td><input type="radio" name="rbtn_csv" id="r_role_csv" onclick="radioFunction_csv()" value="role"> Role </td>';
	echo '</tr>';
	echo '</tbody>';
    echo '</table>';   
	
	/**
    * Select Users
    */ 
	echo '<table id="example3" class="display alluser_datatable" cellspacing="0">
	        <thead>
	            <tr style="text-align:left"> <th style="text-align:center" ><input name="select_all" value="1" id="example-select-all-export" class="select-all" type="checkbox"></th>
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
	foreach ( $wau_users as $user ) {
		echo  '<input type="hidden" name="' . esc_html( $user->ID ) . '" value="'. esc_html( $user->user_email ) . '">';
	} //end csv table
	echo '<table class="form-table" >';
	echo '<tbody>';
	echo '<tr>';
	echo '</tr>';
	/* select roles */
	$mail_content="";
	echo '<tr>';
	//echo '<th>Select Roles</th>';
	echo '<td id="a"><select name="user_role[]" multiple class="role_wau_boxlen_csv" id="wau_role_csv" style="display:none">';
	echo  '<option value="" selected>-- Select Role --</option>';
	echo  '<option> administrator </option>';
	echo  '<option> subscriber </option>';
	echo  '<option> contributor </option>';
	echo  '<option> author </option>';
	echo  '<option> editor </option>';	
	echo '</select></td>';
	echo '</tr>';
	echo '<tr>
	      <td><input class="button-primary" type="submit" name="exportfile" id="exportfile_btn" value="Export as CSV File"></td>
	      </tr>';   
	echo '</tbody>';
	echo '</table>';
	echo '</form>';
	echo'</div>';
}