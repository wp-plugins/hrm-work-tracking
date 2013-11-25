<?php

add_action('admin_menu', 'register_my_hrm_submenu_page');

function register_my_hrm_submenu_page() {
global $current_user;
$uid = $current_user->ID;
$hrmid = get_option('human_resources_department');
if($uid==$hrmid || is_hrm()){
add_submenu_page( 'users.php', __('Personalabteilung', 'hrm-work-tracking'), __('Personalabteilung', 'hrm-work-tracking'), 'manage_options', 'hrm-settings-page', 'hrm_settings_page_callback' ); 
}else{}
}

function hrm_settings_page_callback() {
global $current_user;
$uid = $current_user->ID;
$hrmid = get_option('human_resources_department');

 // -------------------------------------------------------------------- 

    
 if(isset($_POST['remote'])){
  $user_remote_id=$_POST['remote'];
  $user_remote=get_userdata($user_remote_id);
  
  if(isset($_POST['logon'])){
  user_begins_to_work("", $user_remote);
  }
  else if(isset($_POST['logoff'])){
  user_stops_to_work($user_remote_id);
  }
  
 
 }  
 // -------------------------------------------------------------------- 

if(isset($_POST['other_hrms'])){
update_option( 'other_hrms', $_POST['other_hrms'] ); 
}else{}

$datecurrent=date("Y")."_".date("F");

if(isset($_POST['dateshow'])){
$dateshow=$_POST['dateshow']; 
}
else{
$dateshow=date("Y")."_".date("F");
$_POST['dateshow']=date("Y")."_".date("F");
}

if(isset($_POST['clear_all_time'])){
$all_users=get_users();

foreach($all_users as $user){

$the_user_id=$user->data->ID;
reset_times($the_user_id);

}

}

?>
<div class="wrap">
<div id="icon-users" class="icon32"></div><h2><?php _e('Personalabteilung', 'hrm-work-tracking'); ?></h2>
<br /><div style="border: 1px dotted gray; width:300px; background:lightgray;padding:5px;">
<?php hrd_dashboard(); 
echo "</div><br />";

/*
if($uid==$hrmid){?>

<form method="POST" name="hrm-settings">
<table style="border: 1px solid gray; background:lightgray;">
<tr><td><input type="submit" class="ill" name="clear_all_time" value="clear all times" /></td></tr>
</table>
<table><tr><td>
<table style="border: 1px solid gray; background:lightgray;">
<tr><td><label for="other_hrms"><?php _e('Andere HRM Mitarbeiter IDs', 'hrm-work-tracking'); ?></label></td><td>
<input type="text" name="other_hrms" value="<?php echo get_option('other_hrms'); ?>" /></td><td><small><?php _e('mehrere mit , getrennt', 'hrm-work-tracking'); ?></small></td></tr>
<tr><td></td><td></td><td><input type="submit" /></td></tr>
</table>
</form>
</td><td>
<?php if(get_option('hrm_box_removed')!="yes"){ ?>
<table style="border: 1px solid gray; background:lightgray;">
<tr><td colspan="3"><small>Do you like this plugin? Do you need help?</small></td></tr><td><?php paypal_spenden_button(); ?></td><td><?php request_support_button();?></td><td><?php remove_box_button();?></td></tr>
</table>
<?php }else{} }else{} ?>
</td></tr></table><br />
<?php 
*/


if(is_hrm()){
//echo "<font color=\"#ff0000\">you are hrm</font><br />";
}else{}
$hddropdown=check_historical_data(); ?>
<form method="POST" name="hrm-years">
<?php _e('Zeitraum', 'hrm-work-tracking'); ?>: <select name="dateshow" onchange="this.form.submit()">
<?php
foreach ($hddropdown as $hd){
echo "<option value=\"".$hd."\"";
if($_POST['dateshow']==$hd){echo " selected ";}else{}
$dt=explode("_",$hd);
echo ">".$dt[0]." ".__($dt[1])."</option>";
}
?>
</select><br /><br />
</form>
<?php


?> 

<table class="wp-list-table widefat fixed users" cellspacing="0">
	<thead>
	<tr>
	<th scope='col' id='working' class='manage-column'><?php _e('Online', 'hrm-work-tracking');?></th><th scope='col' id='working' class='manage-column'><a href="<?php echo curPageURL23();?>&uo=id">ID</a></th><th scope='col' id='cb' class='manage-column'><a href="<?php echo curPageURL23();?>&uo=name"><?php _e('Name', 'hrm-work-tracking');?></a></th><th scope='col' class='manage-column'><?php _e('E-mail', 'hrm-work-tracking');?></th><th scope='col' class='manage-column'><?php _e('Sollstunden pro Tag', 'hrm-work-tracking');?></th><th scope='col' class='manage-column'><?php _e('Stunden pro Woche / Monat', 'hrm-work-tracking');?></th><th scope='col' class='manage-column'><?php _e('Ist-Stunden pro Monat', 'hrm-work-tracking');?></th><?php  if (get_option("remote_logging_option")=="on"){?><th>Remote Logging</th><?php }else{} ?></tr>
	</thead>

	<tfoot>
	<tr>
	<th scope='col' id='working' class='manage-column'><?php _e('Online', 'hrm-work-tracking');?></th><th scope='col' id='working' class='manage-column'><a href="<?php echo curPageURL23();?>&uo=id">ID</a></th><th scope='col' id='cb' class='manage-column'><a href="<?php echo curPageURL23();?>&uo=name"><?php _e('Name', 'hrm-work-tracking');?></a></th><th scope='col' class='manage-column'><?php _e('E-mail', 'hrm-work-tracking');?></th><th scope='col' class='manage-column'><?php _e('Sollstunden pro Tag', 'hrm-work-tracking');?></th><th scope='col' class='manage-column'><?php _e('Stunden pro Woche / Monat', 'hrm-work-tracking');?></th><th scope='col' class='manage-column'><?php _e('Ist-Stunden pro Monat', 'hrm-work-tracking');?></th><?php  if (get_option("remote_logging_option")=="on"){?><th>Remote Logging</th><?php }else{} ?></tr>

	<tbody id="the-list" data-wp-lists='list:user'>
		
<?php
if(isset($_GET['uo'])){
}else{$_GET['uo']="id";}
$blogusers = get_users('blog_id=1&orderby='.$_GET['uo']);

    foreach ($blogusers as $user) {
    $status=show_user_working_status($user->ID);
    $whow=$user->whow;
    $arbeitzeit_diesen_monat=get_user_meta($user->ID, "Arbeitszeit_gesamt_".$dateshow, true);
    //$arbeitzeit_diesen_monat=$user->"Arbeitszeit_gesamt_".$year."_".$month;
    $arbeitzeit_diesen_monat=round($arbeitzeit_diesen_monat/3600,2);
    if($user->in_office=="yes" && $datecurrent==$_POST['dateshow']){
    $heute= round(((current_time('timestamp') - ($user->Pausenkonto) - ($user->Arbeitszeitbeginn))/3600),2);   
    } else {$heute=0;}    
    echo '<tr><td> '.$status.' </td><td>'.$user->ID.'</td><td><a href="user-edit.php?user_id='.$user->ID.'">'.$user->first_name .' '.$user->last_name .'</a></td><td>' . $user->user_email . '</td><td> '.($whow/5).' </td><td> '.($whow).' / '.($whow*4).' </td>';
    $ms=$whow*4;
    if($ms<$arbeitzeit_diesen_monat){
    echo '<td><font color="#ff0000">'.$arbeitzeit_diesen_monat.'';
    }else
    {echo '<td><font>'.$arbeitzeit_diesen_monat;}
    if($heute!=0){echo ' + '.$heute.' '.__('laufend', 'hrm-work-tracking');}else{} 
    echo '</font></td>';
    
  // --------------------------------------------------------------------    
    if (get_option("remote_logging_option")=="on"){
    echo '<form action="users.php?page=hrm-settings-page" method="post" name="remotelogging">';
    echo '<td>';
    echo '<input type="hidden" name="remote" value="'.$user->ID.'"><input type="submit" name="logon" value="Login"><input type="submit" name="logoff" value="Logout">';
    echo '</form></td>';}else{}
 // -------------------------------------------------------------------- 
    echo '</tr>';
    }

?>

</table>



</div>

<?php




}



function show_weekly_hours_of_work( $user ) { 
global $current_user;
$uid = $current_user->ID;
$hrmid = get_option('human_resources_department');
if($uid==$hrmid || is_hrm()){
?>

	<h3><?php _e('Arbeitszeit Einstellung', 'hrm-work-tracking'); ?></h3>

	<table class="form-table">

		<tr>
			<th><label for="whow"><?php _e('Wochenarbeitszeit', 'hrm-work-tracking'); ?></label></th>

			<td>
				<input type="text" name="whow" id="whow" value="<?php echo esc_attr( get_the_author_meta( 'whow', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Die wöchentliche Arbeitszeit', 'hrm-work-tracking'); ?></span>
			</td>
		</tr>

	</table>
<?php } 
else{}
}

add_action( 'show_user_profile', 'show_weekly_hours_of_work' );
add_action( 'edit_user_profile', 'show_weekly_hours_of_work' );
add_action( 'personal_options_update', 'save_weekly_hours_of_work' );
add_action( 'edit_user_profile_update', 'save_weekly_hours_of_work' );


function save_weekly_hours_of_work( $user_id ) {
global $current_user;
$uid = $current_user->ID;
$hrmid = get_option('human_resources_department');

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	if($uid==$hrmid || is_hrm()){
	update_usermeta( $user_id, 'whow', $_POST['whow'] );}
	else {}
}

function check_historical_data(){
$hrdm=get_user_meta(get_option('human_resources_department'));
$hrdms = array();

foreach ($hrdm as $meta => $value){

$string=strstr($meta,"Arbeitszeit_gesamt");
if($string==true){
$string=str_replace("Arbeitszeit_gesamt_","",$string);
array_push($hrdms,$string);
}else{}

}
return $hrdms;
}


function curPageURL23() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 
 $pageURL=str_replace("&uo=name","",$pageURL);
 $pageURL=str_replace("&uo=id","",$pageURL);
 return $pageURL;
}

function paypal_spenden_button(){
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="GV4C5EGJ4JXLA">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form>
<?php

}

function request_support_button(){
?><a href="http://www.wp-plugin-dev.com/support-contact/" class="button" >Request Support</a><?php
}

function remove_box_button(){
$box_x =$_POST['remove_box_x'];
if($box_x>0){
update_option( 'hrm_box_removed', 'yes');
}

?><form method="post">
<input type="button" value="Remove Box" name="remove_box" />
</form><?php
}


function checkout_if_any_user_is_over_time(){
$all_users=get_users();

foreach($all_users as $user){

$the_user_id=$user->data->ID;
$in_office=get_user_meta($the_user_id,"in_office", true); 

if ($in_office=="yes")
{

$beginn=get_user_meta($the_user_id, "Arbeitszeitbeginn", true);

$pausenkonto=get_user_meta($the_user_id, "Pausenkonto", true);
$date_now=current_time('timestamp');
$ref_time=$date_now-($beginn+$pausenkonto);
$whow=get_user_meta($the_user_id, "whow", true)/5*3600;
// Hier muss getestet werden ob user schon zu lange da ist.
//echo "<hr>".$ref_time." ".$whow;

if($ref_time>$whow){
user_stops_to_work($the_user_id);
}

}else{}



}

}


?>