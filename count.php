<?php 


if ($in_pause=="yes"){
$statusword=__('Pause', 'hrm-work-tracking');
echo "<font color=\"#0000ff\">";
show_work($anfang_pause,$statusword,$pausenkonto); 
echo "</font>";

}
else {
$statusword=__('Arbeit', 'hrm-work-tracking');

if($ueberstunden){echo "<font color=\"#ff0000\">";

show_work($anfang,$statusword,$pausenkonto); echo "</font>";}else{
show_work($anfang,$statusword,$pausenkonto);
} } 
?>


<?php


function show_work($anfang,$statusword,$pausenkonto){
?>
		
		<div id="cpcontainer">&nbsp;</div>

<script type="text/javascript">

var workingtime=new dcountup("<?php 
//$datum= change_time_to_js($datum);
//$anfang=date("m d, Y h:s:i",$datum);
echo $anfang;

 ?>", "days")

workingtime.oncountup=function(result){

var mycountainer=document.getElementById("cpcontainer")
	mycountainer.innerHTML="<?php echo $statusword; ?> "+result['days']+" <?php _e('Tage', 'hrm-work-tracking'); ?> "+result['hours']+" <?php _e('Stunden', 'hrm-work-tracking'); ?> "+result['minutes']+" <?php _e('Minuten', 'hrm-work-tracking'); ?> "+result['seconds']+" <?php _e('Sekunden', 'hrm-work-tracking'); ?>"
}

</script>	
<?php
if ($pausenkonto>0 && $statusword==__('Arbeit', 'hrm-work-tracking')){
echo "<font color=\"#0000ff\">- ".round(($pausenkonto/60),0)." ".__('Minuten', 'hrm-work-tracking')." ".__('Pause', 'hrm-work-tracking')."</font>";
}

}


 ?>