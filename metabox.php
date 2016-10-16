<?php 
/*
 * METABOX REGISTRATION
 */

add_action('add_meta_boxes', 'event_meta_box_setup');
add_action('save_post', 'event_meta_box_save', 10, 2);

function event_meta_box_setup() {
  add_meta_box(
    'np_event_info', // ID
    'Event', // Box title
    'event_meta_box_render', // Callback
    'events', // Admin page or post type
    'side', // Position
    'default' // Priority
  );
}

function event_meta_box_render($object, $box) {
  ?>
  <?php wp_nonce_field(basename(__FILE__), 'np-event-info-nonce'); ?>
  <p>
    <!-- Start date field -->
    <label for="np-event-start-date">Start date and time</label>
    <br>
    <input type="datetime-local" name="np-event-start-date" id="np-event-start-date"
      value="<?php echo esc_attr(date('Y-m-d\TH:i:s', intval(get_post_meta($object->ID, 'events_date_start_epoque', true)))); ?>"/>
  </p>
  <p>
    <!-- End date field -->
    <label for="np-event-end-date">End date and time</label>
    <br />
    <input type="datetime-local" name="np-event-end-date" id="np-event-end-date"
      value="<?php echo esc_attr(date('Y-m-d\TH:i:s', intval(get_post_meta($object->ID, 'events_date_end_epoque', true)))); ?>"/>
  </p>
  <p>
    <!-- Display end date checkbox -->
    <input type="checkbox" name="np-event-disp-end" id="np-event-disp-end"
      value="true" <?php if(get_post_meta($object->ID, 'events_display_end', true) == 'true') echo 'checked'; ?>/>
    <label for="np-event-disp-end">Display end date?</label>
  </p>
  <p>
    <!-- Display time checkbox -->
    <input type="checkbox" name="np-event-disp-time" id="np-event-disp-time"
      value="true" <?php if(get_post_meta($object->ID, 'events_display_time', true) == 'true') echo 'checked'; ?>/>
    <label for="np-event-disp-time">Display time?</label>
  </p>
  <p>
    <!-- Custom date string text field -->
    <label for="np-event-date-string">Custom date string</label>
    <br />
    <input type="text" name="np-event-date-string" id="np-event-date-string"
      value="<?php echo esc_attr(get_post_meta($object->ID, 'events_date_string', true)); ?>" placeholder="Leave empty to disable"/>
  </p>
  <p>
    <!-- Location text field -->
    <label for="np-event-location">Location</label>
    <br />
    <input type="text" name="np-event-location" id="np-event-location"
      value="<?php echo esc_attr(get_post_meta($object->ID, 'events_location', true)); ?>"/>
  </p>
<?php 
}

function event_meta_box_save($post_id, $post) {
  // Verify the nonce before proceeding.
  if(!isset($_POST['np-event-info-nonce'] ) || !wp_verify_nonce($_POST['np-event-info-nonce'], basename(__FILE__)))
    return $post_id;

  // Get the post type object.
  $post_type = get_post_type_object($post->post_type);

  // Check if the current user has permission to edit the post.
  if(!current_user_can($post_type->cap->edit_post, $post_id))
    return $post_id;

  // Start date
  if(isset($_POST['np-event-start-date']))
    save_date($post_id, 'events_date_start_epoque', $_POST['np-event-start-date']);

  // End date
  if(isset($_POST['np-event-end-date']))
    save_date($post_id, 'events_date_end_epoque', $_POST['np-event-end-date']);

  // Display end date checkbox
  if(isset($_POST['np-event-disp-end'])
    && $_POST['np-event-disp-end'] == 'true')
    update_post_meta($post_id, 'events_display_end', 'true');
  else
    update_post_meta($post_id, 'events_display_time', 'false');

  // Display time checkbox
  if(isset($_POST['np-event-disp-time'])
    && $_POST['np-event-disp-time'] == 'true')
    update_post_meta($post_id, 'events_display_time', 'true');
  else
    update_post_meta($post_id, 'events_display_time', 'false');

  // Custom date string
  if(isset($_POST['np-event-date-string']))
    update_post_meta($post_id, 'events_date_string', sanitize_text_field($_POST['np-event-date-string']));

  // Location
  if(isset($_POST['np-event-location']))
    update_post_meta($post_id, 'events_location', sanitize_text_field($_POST['np-event-location']));
}

// Parses a date field value and updates the given key on the given post with
// the parsed value.
function save_date($post_id, $key, $value) {
  $date = DateTime::createFromFormat('Y-m-d\TH:i', $value);
  if($date == false)
    $date = DateTime::createFromFormat('Y-m-d\TH:i:s', $value);

  if($date != false) {
    $new = $date->getTimestamp();
    update_post_meta($post_id, $key, $new);
  }
}

?>