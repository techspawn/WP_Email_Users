<?php
add_action( 'wp_ajax_nopriv_weu_subscribe_users_nl', 'weu_subscribe_users_12854' );
add_action( 'wp_ajax_weu_subscribe_users_nl', 'weu_subscribe_users_12854' );
function weu_subscribe_users_12854(){
	global $wpdb;
    $table_name = $wpdb->prefix.'weu_subscribers';
    $weu_subname = isset($_POST['sub_name'])?$_POST['sub_name']:'';
    $weu_subemail = isset($_POST['sub_email'])?$_POST['sub_email']:'';
    $weu_sublist = isset($_POST['sub_list'])?$_POST['sub_list']:'';
    $random_token = rand(1000000,9999999);
    $curr_date = current_time( 'mysql' );
    weu_setup_activation_data();
    $rows_avail = $wpdb->get_var( "SELECT id FROM $table_name WHERE email = '$weu_subemail'" );
    if(!$rows_avail) {
        $status = $wpdb->query($wpdb->prepare( "INSERT INTO `".$table_name."`(`name`, `email`, `list`, `authtoken`, `datetime`) VALUES (%s,%s,%s,%d,%s)",$weu_subname,$weu_subemail,$weu_sublist,$random_token,$curr_date));
        if($status == 1){
            echo "success";
        }
        else {
            echo "fail";   
        }
    }
    else {
        echo "exist";
    }
    wp_die();
}
?>