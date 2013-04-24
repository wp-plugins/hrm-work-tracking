<?php

/*
Plugin Name: HRM Work Tracking	
Version: 1.0
Description: Ein Plug-in um die Arbeitszeit von mehreren WordPress Usern zu erfassen.
Author: wp-plugin-dev.com
Author URI: http://www.wp-plugin-dev.com
Text Domain:   hrm-work-tracking
Domain Path:   /lang/

This Plugin is licensed under GPL

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/


include ('hrm_dashboard.php');
include ('hrm_core.php');
include ('user-extras.php');
include ('hrm-users.php');
include ('hrm_ill.php');

add_action( 'admin_enqueue_scripts', 'hrm_add_my_stylesheet_and_scripts' );
add_action('wp_login', 'user_begins_to_work', 10, 2);
register_activation_hook( __FILE__, 'hrm_activate' );
add_action( 'admin_init', 'register_hrm' );

//doesnt work good
//add_action('wp_logout', 'user_stops_to_work', 10, 1);

function add_dashboard_clock() {
	wp_add_dashboard_widget('dashboard_clock', __('Uhr', 'hrm-work-tracking'), 'dashboard_clock_function');	
} 

function add_dashboard_hrd() {
	wp_add_dashboard_widget('dashboard_hrd', __('Personalabteilung', 'hrm-work-tracking'), 'hrd_dashboard');	
} 

function add_hrm_wt() {
	wp_add_dashboard_widget('dashboard_hrm_wt', __('Zeiterfassung', 'hrm-work-tracking'), 'dashboard_hrm_wt_function');	
} 


add_action('wp_dashboard_setup', 'add_dashboard_clock' );
add_action('wp_dashboard_setup', 'add_dashboard_hrd' );
add_action('wp_dashboard_setup', 'add_hrm_wt' );

?>