<?php
/*
Plugin Name:  Cf Pendaftaran
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Untuk Belajar CF Processor
Version:      10.0
Author:       Hadie
Author URI:   https://developer.wordpress.org/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  cf-pendaftaran
Domain Path:  /languages
*/

 add_filter('caldera_forms_get_form_processors','cf_pendaftaran_processor');
function cf_pendaftaran_processor($processors){
    $processors['cf-pendaftaran'] = array(
      'name' => 'CF Pendaftaran',
      'description' =>'Caladea Belajar Membuat Processor',
      'processor' =>'cfp_aksi_pendaftaran',
      'pre_processor' =>'cfp_check_pendaftaran',
        'template' => trailingslashit(plugin_dir_path(__FILE__)).'form-fields.php'
    );
    return $processors;
}

function cfp_field_pendaftaran(){
    $fields = array(
        array(
            'id'=> 'cfp_email',
            'label' => 'Email',
            'type' => 'text',
            'required' => true,
        ),

        array(
            'id'=> 'cfp_username',
            'label' => 'Username',
            'type' => 'text',
            'required' => true,
        ),
        array(
            'id'=> 'cfp_name_f',
            'label' => 'First Name',
            'type' => 'text',
        ),
        array(
            'id'=> 'cfp_name_l',
            'label' => 'Last Name',
            'type' => 'text',
        ),
        array(
            'id'=> 'cfp_password',
            'label' => 'Password',
            'type' => 'text',
            'required' => true,
        ),
    );

    return $fields;
}

function cfp_check_pendaftaran($config,$form,$processor_id){
    $email = Caldera_Forms::do_magic_tags($config['cfp_email']);
    $name = Caldera_Forms::do_magic_tags($config['cfp_name_f']);
    $username = Caldera_Forms::do_magic_tags($config['cfp_username']);
    $user_id = username_exists($username);
    if($user_id){
        $output['note'] = 'Mohon Maaf, User sudah terdaftar. Silahkan Login atau gunakan User ID yang lainya';
        $output['type'] = 'error';

        return $output;
    }

    if(email_exists($email)){
        $output['note'] = 'Mohon Maaf, Email sudah terdaftar. Silahkan Login atau gunakan Email yang lainya';
        $output['type'] = 'error';
        return $output;
    }

    return;
}

function cfp_aksi_pendaftaran($config,$form,$processor_id){
    $email = Caldera_Forms::do_magic_tags($config['cfp_email']);
    $name = Caldera_Forms::do_magic_tags($config['cfp_name_f']);
    $username = Caldera_Forms::do_magic_tags($config['cfp_username']);
    $password = Caldera_Forms::do_magic_tags($config['cfp_password']);

    $user_id = username_exists($username);
    if(!$user_id && email_exists($email) == false){
       $create_user = wp_create_user($username,$password,$email);

    }
}


