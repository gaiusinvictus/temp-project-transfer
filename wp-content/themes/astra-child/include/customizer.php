<?php

/**
 * Include the kirki framework to create fields
 */
if( !class_exists( 'Kirki' ) ) {
    require CHILD_THEME_ROOT_DIR . 'include/kirki/kirki.php';
}

Kirki::add_config( 'astrachild', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );