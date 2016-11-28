<?php

function weu_admin_manage_list(){

global $wpdb;

$subscibers_arr =array();

$table_name = $wpdb->prefix.'weu_subscribers';



if(isset($_POST['add_new_list']) && $_POST['add_new_list']=='Add New List') {

	global $wpdb;

	$table_name = $wpdb->prefix.'weu_subscribers';

	$new_listname = isset($_POST['new_list_name'])?$_POST['new_list_name']:'';

    weu_setup_activation_data();

    $def_list = array();

    // get option

    $pre_list = get_option('weu_subscriber_lists');

    if(empty($pre_list)) {

    	$pre_list = array();

    	$def_list = array('default');

    }

    //push array

    array_push($pre_list,$new_listname);

    $sub_list = array_merge( $def_list,$pre_list );

    update_option('weu_subscriber_lists',$sub_list);

}

if( isset($_POST['uploadfile']) && $_POST['uploadfile']=='Import CSV'){

  	 $i = 0;

	 $filename=$_FILES["uploadfiles"]["tmp_name"];

	 $excelFileType = $_POST['weu_subscribers_import'];

	 $random_token = rand(1000000,9999999);

	 $curr_date = current_time( 'mysql' );

	 $target_file = basename($_FILES["uploadfiles"]["name"]);


	 $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


	 $allowed_ext = array('csv');

	 //echo $_FILES['uploadfiles']['type'];



    if(in_array($imageFileType, $allowed_ext)){

	 if($_FILES["uploadfiles"]["size"] > 0) {

			$file = fopen($filename, "r");

			$table_name = $wpdb->prefix.'weu_subscribers';

			while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){

				if($i>=1 ){

				 		 	$wpdb->query("INSERT INTO $table_name SET 

								`name`='".mysql_real_escape_string($emapData[0])."', 

								`email`='". mysql_real_escape_string($emapData[1])."',

								`list`='".$excelFileType."',

								`authtoken`='".$random_token."',

								`datetime`='".$curr_date."'

								");

				}

				$i++;

			}
			echo '<div id="" class="notice notice-success is-dismissible"><p>Members Added Successfully</p></div>';

		}
	}else
	{
		echo '<div id="" class="notice notice-error is-dismissible"><p>Invalid file extension. Please Upload CSV (.csv) File Format.</p></div>';
	}

	}

	if(isset($_POST['weu_subscribers_list']) &&  isset($_POST['exportfile']) && $_POST['exportfile']=='Export List') {

		$list = isset($_POST['weu_subscribers_list'])?$_POST['weu_subscribers_list']:'';

		$table_name = $wpdb->prefix.'weu_subscribers';

		$subscribers = $wpdb->get_results("SELECT * FROM $table_name WHERE list='$list'");

		for($j=0;$j<count($subscribers);$j++){

			$subscibers_arr['name'][$j] = $subscribers[$j]->name;

			$subscibers_arr['email'][$j] = $subscribers[$j]->email;

			$subscibers_arr['list'][$j] = $subscribers[$j]->list;

		}

	   	if (ob_get_contents()) ob_clean();

		header("Content-type: application/vnd.ms-excel");

		header("Content-Encoding: UTF-8");

		header("Content-Type: text/html; charset=utf-8");

		header("Content-disposition: csv" . date("Y-m-d"). "csv");

		header("Content-disposition: attachment; filename=ExportUsers.xls");

		echo '<table><thead><th>Name</th><th>Email</th><th>List</th></thead><tbody>';

	    for($j=0;$j<count($subscribers);$j++) {

			echo '<tr><td>'.$subscibers_arr['name'][$j].'</td><td>'.$subscibers_arr['email'][$j].'</td><td>'.$subscibers_arr['list'][$j].'</td></tr>';

		}

		echo '</tbody></table>';

		exit();

		ob_end_clean();

	}



	if(isset($_POST['delete'])) {

		$delete_list = $_POST['delete'];

		global $wpdb;

		$table_name = $wpdb->prefix.'weu_subscribers';

		$mylink = $wpdb->delete( $table_name, array( 'list' => $delete_list ), array( '%s' ) );

		$all_sublist = get_option('weu_subscriber_lists');

		$del_list_name[] = $_POST['delete'];

		$new_lists = array_diff($all_sublist, $del_list_name);

	    update_option('weu_subscriber_lists',$new_lists);

	}

	echo '<div style="float:left; width:75%; background-color: #fff;padding: 18px;border-top: 10px solid #F1F1F1;">';

	echo '<form name="export_form" class="" style="" method="POST" action="#" enctype="multipart/form-data">';

	echo '<div class="wrap"><h1 style="margin: 10px 0px;">Manage Subscriber List <a href="#TB_inline?width=300&height=250&inlineId=add-new-list" class="page-title-action thickbox">Add New List</a></h1></div>';

	echo '<table id="" class="form-table">';

	echo '<tbody>';

	$table_name = $wpdb->prefix.'weu_subscribers';

	$wau_lists = $wpdb->get_results( "SELECT DISTINCT list FROM $table_name" );

	echo '</tbody>';

    echo '</table>';

	/**

    * Select Users

    */ 

	echo '<table id="example3" class="display alluser_datatable data_list" cellspacing="0">

        <thead>

            <tr style="text-align:center"> 

            	

            	<th>List Name</th>

    			<th>List Count</th>

        		<th>Manage</th>

        		<th>Delete</th>

            </tr>

        </thead>    

    <tbody>';

	$all_sublist = get_option('weu_subscriber_lists');

	$list_al = count($all_sublist);

	$list_tbl = count($wau_lists); 

	$sub_list_nz = array();

	foreach ( $wau_lists as $s_list ){

	global $wpdb;

	$table_name = $wpdb->prefix.'weu_subscribers';

	$curr_list = $s_list->list;

	$list_count = $wpdb->get_row("SELECT COUNT(*) AS list_count FROM $table_name WHERE list='$curr_list'");

	$list_editor_page = get_admin_url('','/admin.php');

	if(empty($all_sublist)) $all_sublist = array('default');

	$list_editor_inst = add_query_arg( array(

	    'page' => 'weu-list-editor',

	    'listname' =>  $s_list->list,

	), $list_editor_page );

	echo '<tr style="text-align:center">';

	echo '<td><span id="getDetail">'. esc_html(  $s_list->list  ).'</span></td>';

	echo '<td><span>'.esc_html( $list_count->list_count ).'</span></td>';

	echo '<td><a style="text-decoration: none;" href="'.$list_editor_inst.'" id="'.$s_list->list.'" class="select-all">Manage</a> </td><td> <button class="delete-email-indi" name="delete" type="submit" value="'.$s_list->list.'"><input type="hidden" id="delete-email-indi" name="weu_delete_list" value=""><span class="dashicons dashicons-trash"></span></button></td>';

	echo '</tr>'; 

	array_push($sub_list_nz, $s_list->list);

	}

	if($list_al!=$list_tbl) {

		$all_sublist_z = array();

		$all_sublist_z = array_diff($all_sublist,$sub_list_nz);

		foreach ( $all_sublist_z as $s_list ){

				$curr_list = (string)$s_list;

				$list_editor_page = get_admin_url('','/admin.php');

				$list_editor_inst = add_query_arg( array(

				    'page' => 'weu-list-editor',

				    'listname' =>  $curr_list,

				), $list_editor_page );

				echo '<tr style="text-align:center">';

				echo '<td><span id="getDetail">'.$curr_list.'</span></td>';

				echo '<td><span> 0 </span></td>';

				echo '<td><a style="text-decoration: none;" href="'.$list_editor_inst.'" id="'.$curr_list.'" class="select-all">Manage</a> </td><td> <button class="delete-email-indi" name="delete" type="submit" value="'.$curr_list.'"><input type="hidden" id="delete-email-indi" name="weu_delete_list" value=""><span class="dashicons dashicons-trash"></span></button></td>';

				echo '</tr>';

		}

	}



	echo '</tbody></table>'; // end user Data table for user

	echo '<table class="form-table" style="background: #f1f1f1;">';

	echo '<tbody>';

	echo '<tr>';

	echo '<td><h4>Import List to </h4></td>';

	echo '<td>';



  	echo '<select style="width: 150px;" name="weu_subscribers_import">';

			foreach ( $all_sublist as $s_list ){ ?>

					<option value="<?php echo $s_list; ?>"> <?php echo $s_list; ?> </option>

			<?php }

	echo '</select>

	<input type="file" name="uploadfiles" id="uploadfiles" size="35" class="uploadfiles" style="padding:0 5%;"></td>';

	echo '<td><input class="button-primary" type="submit" name="uploadfile" id="uploadfile_btn" value="Import CSV"></td>';

	echo '</tr>';

	echo '</tbody>';

	echo '</table>';

	echo '</form>';

	echo'</div>';

	add_thickbox();

	?>

	<div id="add-new-list" style="display:none;">

	     <p>

          	<form method="post" action="#">

	    		<table>

	      			<tr>

	      				<td> <label> New List Name </label> </td> 

	      				<td> <input type="text" name="new_list_name"> </td>

	      			</tr>

	  				<tr>

	      				<td colspan="2"><label><input style="width: 100%;" class="button-primary" type="submit" name="add_new_list" value="Add New List"></label> </td>

	      			</tr>

	      		</table>

			</form>

	     </p>

	</div>

	<div id="rename-list" style="display:none;">

     <p>

		 

     </p>

	</div>

<?php

}

function weu_list_editor() {

	$curr_list = '';

	if(isset($_GET['listname']) && !empty($_GET['listname'])) {

		$curr_list = $_GET['listname']; 

	}

	if(isset($_POST['add_new_mem']) && $_POST['add_new_mem']=='Add New Member') {

		global $wpdb;

		$table_name = $wpdb->prefix.'weu_subscribers';

		$curr_list = $_GET['listname'];

		$new_memname = isset($_POST['member_name'])?$_POST['member_name']:''; 

		$new_mememail = isset($_POST['member_email'])?$_POST['member_email']:'';

	    $curr_date = current_time( 'mysql' );

     	$random_token = rand(1000000,9999999);

	    weu_setup_activation_data();

	    $rows_avail = $wpdb->get_var( "SELECT id FROM $table_name WHERE email = '$new_mememail' and list='$curr_list'" );

	    if(!$rows_avail) {

	        $status = $wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name."`(`name`, `email`, `list`, `authtoken`, `datetime`) VALUES (%s,%s,%s,%d,%s)",$new_memname,$new_mememail,$curr_list,$random_token,$curr_date));

	        if($status == 1){

				echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Member added Successfully. </p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	        }

	        else {
	        	echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Fail to add new member. </p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	            
	        }

	    }

	    else {

	       	echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Member already exist. </p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	         

	    }

	}

	if(isset($_POST['delete_subs'])) {

		global $wpdb;

		if(isset($_GET['listname']))

			$curr_list = $_GET['listname'];

		$delete_subs = $_POST['delete_subs'];

		$table_name = $wpdb->prefix.'weu_subscribers';

		$mylink = $wpdb->delete( $table_name, array( 'list' => $curr_list,'name' => $delete_subs ), array( '%s','%s' ) );

	}

	if( isset($_POST['uploadfile']) && $_POST['uploadfile']=='Import CSV'){

  	 $i = 0;

  	 global $wpdb;

	 $filename=$_FILES["uploadfiles"]["tmp_name"];

	 $excelFileType = $_POST['weu_subscribers_import'];

	 $random_token = rand(1000000,9999999);

	 $curr_date = current_time( 'mysql' );

	 $target_file = basename($_FILES["uploadfiles"]["name"]);


	 $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


	 $allowed_ext = array('csv');

    if(in_array($imageFileType, $allowed_ext)){


	 if($_FILES["uploadfiles"]["size"] > 0) {

			$file = fopen($filename, "r");

			$table_name = $wpdb->prefix.'weu_subscribers';

			while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){

				$rows_avail = $wpdb->get_var( "SELECT id FROM $table_name WHERE email = '".mysql_real_escape_string($emapData[1])."' and list='".$excelFileType."'" );

				if(!$rows_avail) {

				if($i>=1 ){

				 		 	$wpdb->query("INSERT INTO $table_name SET 

								`name`='".mysql_real_escape_string($emapData[0])."', 

								`email`='". mysql_real_escape_string($emapData[1])."',

								`list`='".$excelFileType."',

								`authtoken`='".$random_token."',

								`datetime`='".$curr_date."'

								");

				}
			}

				$i++;

			}
			echo '<div id="" class="notice notice-success is-dismissible"><p>Members Added Successfully</p></div>';

			

		}
	}
	else
	{
		echo '<div id="" class="notice notice-error is-dismissible"><p>Invalid file extension. Please Upload CSV (.csv) File Format.</p></div>';
	}

	}

	if(isset($_POST['weu_subscribers_list_expo']) &&  isset($_POST['exportfile']) && $_POST['exportfile']=='Export List') {

		global $wpdb;

		$list = isset($_POST['weu_subscribers_list_expo'])?$_POST['weu_subscribers_list_expo']:'';

		$table_name = $wpdb->prefix.'weu_subscribers';

		$subscribers = $wpdb->get_results("SELECT * FROM $table_name WHERE list='$list'");

		for($j=0;$j<count($subscribers);$j++){

			$subscibers_arr['name'][$j] = $subscribers[$j]->name;

			$subscibers_arr['email'][$j] = $subscribers[$j]->email;

			$subscibers_arr['list'][$j] = $subscribers[$j]->list;

		}

	   	if (ob_get_contents()) ob_clean();

		header("Content-type: application/vnd.ms-excel");

		header("Content-Encoding: UTF-8");

		header("Content-Type: text/html; charset=utf-8");

		header("Content-disposition: csv" . date("Y-m-d"). "csv");

		header("Content-disposition: attachment; filename=ExportUsers.xls");

		echo '<table><thead><th>Name</th><th>Email</th><th>List</th></thead><tbody>';

	    for($j=0;$j<count($subscribers);$j++){

			echo '<tr><td>'.$subscibers_arr['name'][$j].'</td><td>'.$subscibers_arr['email'][$j].'</td><td>'.$subscibers_arr['list'][$j].'</td></tr>';

		}

		echo '</tbody></table>';

		exit();

		ob_end_clean();

	}

	/**

    * Select Users

    */

	echo '<div style="float:left; width:75%; background-color: #fff;padding: 18px;border-top: 10px solid #F1F1F1;">';

	echo '<form name="member_form" class="" style="" method="POST" action="#" enctype="multipart/form-data">';


	echo '<div class="wrap"><h1 style="margin: 10px 0px;">List Subscriber Editor - '.$curr_list.' <a href="#TB_inline?width=250&height=250&inlineId=add-new-member" class="page-title-action thickbox">Add New Member</a></h1></div>';

	echo '<table id="example3" class="display alluser_datatable data_expo" cellspacing="0">

        <thead>

            <tr style="text-align:center"> <th>Id</th>

    			<th>Name</th>

        		<th>Email</th>

				<th>Delete</th>

            </tr>

        </thead>    

    <tbody>';

    global $wpdb;

	$table_name = $wpdb->prefix.'weu_subscribers';

	$wau_lists = $wpdb->get_results( "SELECT * FROM $table_name WHERE list='$curr_list'" );

	foreach ( $wau_lists as $s_list ){

	$table_name = $wpdb->prefix.'weu_subscribers';

	$curr_list = $s_list->list;

	$list_count = $wpdb->get_row("SELECT COUNT(*) AS list_count FROM $table_name WHERE list='$curr_list'");

	$list_editor_page = get_admin_url('','/admin.php');

	$list_editor_inst = add_query_arg( array(

	    'page' => 'weu-list-editor',

	    'listname' =>  $s_list->list,

	), $list_editor_page );

	echo '<tr style="text-align:center">';

	echo '<td><span id="getDetail">'. esc_html(  $s_list->id  ).'</span></td>';

	echo '<td><span>'.esc_html( $s_list->name ).'</span></td>';

	echo '<td>'.esc_html( $s_list->email ).'</td>';

	echo '<td> <button class="delete-member-indi" name="delete_subs" type="submit" value="'.$s_list->name.'"><span class="dashicons dashicons-trash"></span></button></td>';

	echo '</tr>'; }

	echo '</tbody></table>'; // end user Data table for user

	echo '<input style="margin: 2em;" type="file" name="uploadfiles" id="uploadfiles" size="35" class="uploadfiles">';

	echo '<input style="margin: 2em;" class="button-primary" type="submit" name="uploadfile" id="uploadfile_btn" value="Import CSV">';

	echo '<input name="weu_subscribers_list_expo" type="hidden" value="'.$curr_list.'">';

	echo '<input name="weu_subscribers_import" type="hidden" value="'.$curr_list.'">';

	echo '</form>';

	echo '</div>';

	add_thickbox();

?>

<div id="add-new-member" style="display:none;">

     <p><h2> Add New Member to <?php echo $curr_list; ?> List  </h2>

      	<form method="post" action="#">

      		<table>

      			<tr>

      				<td> <label> Member Name </label> </td> 

      				<td> <input type="text" name="member_name"> </td>

      			</tr>

      			<tr>

  					<td> <label> Member Email </label> </td> 

  					<td> <input type="email" name="member_email"> </td>

      			</tr>

  				<tr>

      				<td colspan="2"><label><input style="width: 100%;" class="button-primary" type="submit" name="add_new_mem" value="Add New Member"></label> </td>

      			</tr>

      		</table>

		</form></p>

</div>

<?php

}

?>