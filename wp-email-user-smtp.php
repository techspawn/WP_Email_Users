<?php
function ts_weu_smtp_conf($phpmailer){
	$weu_tempOptions = get_option( 'weu_smtp_data_options' ); 
 	if($weu_tempOptions['smtp_status']=='yes') {
	$phpmailer->Mailer = "smtp";
	$phpmailer->Host = $weu_tempOptions["smtp_host"];
	$phpmailer->SMTPSecure = $weu_tempOptions["smtp_smtpsecure"];
	$phpmailer->Port = $weu_tempOptions["smtp_port"];
	$phpmailer->SMTPAuth = TRUE;
		if($phpmailer->SMTPAuth){
			$phpmailer->Username = $weu_tempOptions["smtp_username"];
			$phpmailer->Password = $weu_tempOptions["smtp_password"];
		}
	}
}
add_action('phpmailer_init','ts_weu_smtp_conf');
function weu_smtp_config_page() {
	if(isset($_POST['weu_smtp_update'])) {
			$weu_temp_options = array();
			$weu_temp_options["smtp_status"] = trim($_POST['weu_smtp_status']);
			$weu_temp_options["smtp_host"] = trim($_POST['weu_smtp_host']);
			$weu_temp_options["smtp_smtpsecure"] = trim($_POST['weu_smtp_smtpsecure']);
			$weu_temp_options["smtp_port"] = trim($_POST['weu_smtp_port']);
			$weu_temp_options["smtp_username"] = trim($_POST['weu_smtp_username']);
			$weu_temp_options["smtp_password"] = trim($_POST['weu_smtp_password']);
			update_option("weu_smtp_data_options",$weu_temp_options);
			echo '<div id="message" class="updated notice is-dismissible"><p>options successfully saved.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	}		
	$weu_temp = get_option( 'weu_smtp_data_options' );
	$temp_port = isset($weu_temp['smtp_port'])?$weu_temp['smtp_port']:'';
	$temp_host = isset($weu_temp['smtp_host'])?$weu_temp['smtp_host']:'';
	$temp_username = isset($weu_temp['smtp_username'])?$weu_temp['smtp_username']:'';
	$temp_password = isset($weu_temp['smtp_password'])?$weu_temp['smtp_password']:'';
	?>
	<div class="wrap">
	<h2>WP Email Users - SMTP Configuration</h2>
	</div>
	<form action="#" method="post" class="wau_form"><table id="" class="form-table" >
	<tbody>
	<tr>
	<th>Use SMTP : &nbsp;</th>
	<td style="width: 170px"><input type="radio" name="weu_smtp_status" value="yes" <?php if($weu_temp['smtp_status']=='yes') echo 'checked'; ?> > Yes &nbsp;</td>
	<td style="width: 170px"><input type="radio" name="weu_smtp_status" value="no" <?php if($weu_temp['smtp_status']=='no') echo 'checked'; ?> > No </td>
	</tr>
	<tr>
	<th>SMTP Host</th> <td colspan="1"><input type="text" style="width: 100%;" name="weu_smtp_host" value="<?php echo $temp_host; ?>" class="wau_boxlen"  id="wau_from_name" required></td>
	</tr>
	<tr>
	<th>Type of Encription : &nbsp;</th>

	<td style="width: 170px"><input type="radio" name="weu_smtp_smtpsecure" value="" <?php if($weu_temp['smtp_smtpsecure']=='') echo 'checked'; ?> > None &nbsp;</td>
	<td style="width: 170px"><input type="radio" name="weu_smtp_smtpsecure" value="ssl" <?php if($weu_temp['smtp_smtpsecure']=='ssl') echo 'checked'; ?> > SSL </td>
	<td style="width: 170px"><input type="radio" name="weu_smtp_smtpsecure" value="tls" <?php if($weu_temp['smtp_smtpsecure']=='tls') echo 'checked'; ?> > TLS </td>
	</tr>
	<tr>
	<th>SMTP Port</th> <td colspan="2"><input type="number" name="weu_smtp_port" value="<?php echo $temp_port; ?>" class="wau_boxlen" id="wau_port" required></td>
	</tr>
	<tr>
	<th>SMTP Username</th> <td colspan="2"><input type="text" style="width: 100%;" name="weu_smtp_username" value="<?php echo $temp_username; ?>" class="wau_boxlen" id="wau_uname" required></td>
	</tr>
	<tr>
	<th>SMTP Password</th> <td colspan="2"><input type="password" style="width: 100%;" name="weu_smtp_password" value="<?php echo $temp_password ?>" class="wau_boxlen" id="wau_pass" required></td>
	</tr>
	</tbody>
	</table>
	<div><input type="hidden" name="weu_smtp_update" value="weu_update" /><input type="submit" value="Save changes" class="button button-hero button-primary"></div></form>
<?php
}
?>