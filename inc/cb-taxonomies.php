<?php

function cb_register_taxes()
{
    $args = [
        "labels" => [
            "name" => "Teams",
            "singular_name" => "Team",
        ],
        "public" => true,
        "publicly_queryable" => false,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => false,
        "show_admin_column" => true,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "show_in_quick_edit" => true,
    ];
    register_taxonomy("team", [ "people" ], $args);

    $args = [
        "labels" => [
            "name" => "Offices",
            "singular_name" => "Office",
        ],
        "public" => true,
        "publicly_queryable" => false,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => false,
        "show_admin_column" => true,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "show_in_quick_edit" => true,
    ];
    register_taxonomy("office", [ "people" ], $args);

}
add_action('init', 'cb_register_taxes');
