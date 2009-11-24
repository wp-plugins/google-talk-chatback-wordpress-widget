<?php
/*
 * Plugin Name: Google Talk Chatback Widget
 * Version: 1.4
 * Plugin URI: http://fixmonster.com/google-talk-chatback-wordpress-widget/
 * Description: Lets users on your blog chat with you live through Google Chatback. If you are offline it links to your contact form instead.  Get your Google Chatback hash key <a href="http://www.google.com/talk/service/badge/New">HERE</a>.  It is the part between "tk=" and "&amp" 
 * Author: Mike Duncan
 * Author URI: http://fixmonster.com/
 */
class GChatWidget extends WP_Widget
{
 /**
  * Declares the GChatWidget class.
  *
  */
    function GChatWidget(){
    $widget_ops = array('classname' => 'widget_Google_Chatback', 'description' => __( "Lets users on your blog chat with you live through Google Chatback. If you are offline it links to your contact form instead.") );
    $control_ops = array('width' => 300, 'height' => 300);
    $this->WP_Widget('GoogleChatback', __('GoogleChatback'), $widget_ops, $control_ops);
    }

  /**
    * Displays the Widget
    *
    */
    function widget($args, $instance){
      extract($args);
      $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
      $lineOne = empty($instance['lineOne']) ? 'empty' : $instance['lineOne'];
      $lineTwo = empty($instance['lineTwo']) ? 'empty' : $instance['lineTwo'];

      # Before the widget
      echo $before_widget;

      # The title
      if ( $title )
      echo $before_title . $title . $after_title;

      # Make the GChatback widget

if ($lineOne == 'Chatback Hash Key')
{
echo 'Not Configured';
}
else
{	  
include 'gtalkStatus.class.php';

$gtalkStatus = new gtalkStatus($lineOne);

$status = ($gtalkStatus->isOnline()?'online':'offline');

if ($status == 'online')
{
echo '<a href="http://www.google.com/talk/service/badge/Start?tk='.$lineOne.'" onclick="window.open(\'http://www.google.com/talk/service/badge/Start?tk='.$lineOne.'\',\'popup\',\'width=250,height=450,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0\'); return false"><img src="/wp-content/plugins/google-talk-chatback-wordpress-widget/live-support.png" border="0"></img></a>';
}
else
{
echo '<a href="'.$lineTwo.'"><img src="/wp-content/plugins/google-talk-chatback-wordpress-widget/contact-us.png" border="0"></img></a>';
}
}

      # After the widget
      echo $after_widget;
  }

  /**
    * Saves the widgets settings.
    *
    */
    function update($new_instance, $old_instance){
      $instance = $old_instance;
      $instance['title'] = strip_tags(stripslashes($new_instance['title']));
      $instance['lineOne'] = strip_tags(stripslashes($new_instance['lineOne']));
      $instance['lineTwo'] = strip_tags(stripslashes($new_instance['lineTwo']));

    return $instance;
  }

  /**
    * Creates the edit form for the widget.
    *
    */
    function form($instance){
      //Defaults
      $instance = wp_parse_args( (array) $instance, array('title'=>'Customer Support', 'lineOne'=>'Chatback Hash Key', 'lineTwo'=>'Contact Form URL') );

      $title = htmlspecialchars($instance['title']);
      $lineOne = htmlspecialchars($instance['lineOne']);
      $lineTwo = htmlspecialchars($instance['lineTwo']);

      # Output the options
      echo '<p style="text-align:right;"><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' <input style="width: 250px;" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></label></p>';
      # Text line 1
      echo '<p style="text-align:right;"><label for="' . $this->get_field_name('lineOne') . '">' . __('Chatback Hash:') . ' <input style="width: 250px;" id="' . $this->get_field_id('lineOne') . '" name="' . $this->get_field_name('lineOne') . '" type="text" value="' . $lineOne . '" /></label></p>';
      # Text line 2
      echo '<p style="text-align:right;"><label for="' . $this->get_field_name('lineTwo') . '">' . __('Contact URL:') . ' <input style="width: 250px;" id="' . $this->get_field_id('lineTwo') . '" name="' . $this->get_field_name('lineTwo') . '" type="text" value="' . $lineTwo . '" /></label></p>';
  }

}// END class

/**
  * Register GChat widget.
  *
  * Calls 'widgets_init' action after the GChat widget has been registered.
  */
  function GChatInit() {
  register_widget('GChatWidget');
  }
  add_action('widgets_init', 'GChatInit');
?>
