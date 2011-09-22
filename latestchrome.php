<?php
/**
 * @package LatestChrome
 * @version 0.0.1
 */
/*
Plugin Name: Latest Chrome
Plugin URI: http://wordpress.org/extend/plugins/latest-chrome/
Description: A gadget including the latest Chrome downloads and a script to check if the visitor is using a latest version.
Author: Dean Lee
Version: 0.0.1
Author URI: http://lidian.info/
*/

/*	Copyright 2011 Dean Lee <xslidian@gmail.com>

		This program is free software; you can redistribute it and/or
		modify it under the terms of the GNU General Public License
		as published by the Free Software Foundation; either version 2
		of the License, or (at your option) any later version.
	
		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.
	
		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

register_sidebar( array(
	'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget' => "</li>\n",
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => "</h2>\n") );

class LatestChrome extends WP_Widget {
	function LatestChrome() {
		parent::WP_Widget(false, $name = 'LatestChrome');
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title; }
		else {
		}
		require_once('chromeversioninline.html');
		/*echo '<div id="currentchromeversion" onclick="ischromelatest()">';
		if ($_SERVER['HTTP_USER_AGENT']) {
			$ua = str_replace('Chromium','Chrome',$_SERVER['HTTP_USER_AGENT']);
			$uv = trim(substr(strstr($ua, 'Chrome/'), 7,
			strpos(strstr($ua,'Chrome/'), ' ') - 7));
			echo 'Currently installed version is: ';
			echo (strstr($ua,'Chrome/')) ? $uv : 'Are you using Chrome?';
		}
		echo '</div>';*/
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		$title = esc_attr($instance['title']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<?php
	}

}

add_action('widgets_init', create_function('', 'return register_widget("LatestChrome");'));

?>
