<?php
Auto populate login user details in gravity form field
======================================================


1. Enable Dynamic Population in the Form Fields
   1. Edit your Gravity Form in the WordPress admin.
   2. Select the fields you want to populate (e.g., Name, Email, etc.).
   3. Go to the Advanced tab of the field settings.
   4. Check the Allow field to be populated dynamically option.
   5. Enter a parameter name (e.g., user_name, user_email, etc.).


2. Add Custom Code to Populate Fields
You need to use WordPress hooks (gform_field_value_{parameter_name}) to populate the fields dynamically.

Here’s an example code snippet to add to your theme’s functions.php file or a custom plugin:


////Auto populate in user details gravity form field

//User First name 
add_filter('gform_field_value_user_firstname', function () {
    return wp_get_current_user()->first_name;
});

//User Last name 
add_filter('gform_field_value_user_lastname', function () {
    return wp_get_current_user()->last_name;
});

//User  Email 
add_filter('gform_field_value_user_email', function () {
    return wp_get_current_user()->user_email;
});

//User meta field (Ex. "_user_phone")
add_filter('gform_field_value_user_phone', function () {

    $user_id = wp_get_current_user()->ID;
    return get_user_meta( $user_id, '_user_phone' , true ); // meta field
});



3. Test the Form
   1. Log in as a WordPress user.
   2. View the form on the front end.
   3. The fields should automatically populate with the logged-in user's details.

4. Optional: Conditional Logic for Logged-Out Users
If you want to show default values or hide fields for users who are not logged in, you can use conditional logic in Gravity Forms:

Set default values for fields in the editor.
Use conditional logic to show/hide fields based on dynamic data.  