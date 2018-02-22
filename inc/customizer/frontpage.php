<?php


function bootswatch_frontpage_settings($wp_customize) {

    // $section = 'rontpage_settings_section'; // old section
    $section = 'static_front_page';

    // $label_args = array(
    //     'section' => $section,
    //     'setting_id' => 'frontpage_header_content_label',
    //     'label' => __('Header Content Settings', 'bootswatch'),
    //     'control_id' => 'frontpage_header_label_control'
    // );
    // bootswatch_customizer_label($wp_customize, $label_args);




    // select the what to display in the header
    $wp_customize->add_setting( 'frontpage_hero_content_setting', array(
        'default'  => 'callout',
        'sanitize_callback' => 'bootswatch_frontpage_hero_content_sanitize',
    ) );

    $wp_customize->add_control( 'frontpage_hero_content_control', array(
            'description' => __('Select what to display in the header.','bootswatch'),
            'label'   => __('Header Content', 'bootswatch'),
            'section' => $section,
            'settings'=> 'frontpage_hero_content_setting',
            'priority' => 1,
            'type' => 'select',
            'choices' => array(
                'callout' => __('Callout', 'bootswatch'),
                'page' => __('Select a Page', 'bootswatch'),
                'title' => __('Site title', 'bootswatch'),
            )
        )
    );


    // Select the page link to use in the callout
     $wp_customize->add_setting( 'frontpage_hero_callout_setting', array(
         'default' => '',
         'sanitize_callback' => 'absint',
     ) );
     $wp_customize->add_control( 'frontpage_hero_callout_control',
         array(
             'description' => __('Display a button link in the callout to a selected page','bootswatch'),
             'label'   => __('Callout Button Link', 'bootswatch'),
             'section' => $section,
             'settings'=> 'frontpage_hero_callout_setting',
             'type'    => 'dropdown-pages',
             'priority' => 1,
         )
     );



    $wp_customize->add_setting( 'frontpage_hero_page_setting', array(
        'default'        => '',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'frontpage_hero_page_control', array(
            'label'   => __('Select a Page', 'bootswatch'),
            'section' => $section,
            'settings'=> 'frontpage_hero_page_setting',
            'type'    => 'dropdown-pages',
            'priority' => 1,
         )
    );



     /**
      * Sortables
      * @var string
      */
     $wp_customize->add_setting( 'frontpage_sortables_setting', array(
         'default'        => '[{"name":"page-content","label":"Page Content"}]',
         'sanitize_callback' => 'bootswatch_frontpage_sortable_sanitize',
     ) );

     $description = __('The page content is sortable, and optional.  Simply drag the
          available components from the "available" box over to active.  This setting
          does not depend on the "Settings Active" setting above.', 'bootswatch');

     $wp_customize->add_control( new Bootswatch_Sortable_Control( $wp_customize,
        'frontpage_sortables_control', array(
            'description' => sprintf(' %s', $description ),
            'label'   => __('Sortable Page Content', 'bootswatch'),
            'section' => $section,
            'settings'=> 'frontpage_sortables_setting',
            'priority' => 1,
            'optional' => true,
            'choices' => array(
                    'widget-area-1' => __('Widget Area 1', 'bootswatch'),
                    'widget-area-2' => __('Widget Area 2', 'bootswatch'),
                    'widget-area-3' => __('Widget Area 3', 'bootswatch'),
                    'page-content' => __('Page Content', 'bootswatch'),
                ),
            )
        )
    );

}
add_action('customize_register', 'bootswatch_frontpage_settings');