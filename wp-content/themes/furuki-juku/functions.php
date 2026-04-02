<?php

function furuki_juku_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );

    register_nav_menus( [
        'primary' => 'ヘッダーナビゲーション',
    ] );
}
add_action( 'after_setup_theme', 'furuki_juku_setup' );

function furuki_juku_enqueue() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&family=Noto+Serif+JP:wght@400;700&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'furuki-juku-style',
        get_stylesheet_uri(),
        [ 'google-fonts' ],
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'furuki_juku_enqueue' );

function furuki_juku_tailwind() {
    echo '<script src="https://cdn.tailwindcss.com"></script>' . "\n";
    echo '<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: {
                        blue:    "#00a0e9",
                        navy:    "#00497a",
                        sky:     "#e8f7fd",
                        warm:    "#fff8f0",
                        accent:  "#f5a623",
                    }
                },
                fontFamily: {
                    sans:  ["Noto Sans JP", "sans-serif"],
                    serif: ["Noto Serif JP", "serif"],
                }
            }
        }
    }
    </script>' . "\n";
}
add_action( 'wp_head', 'furuki_juku_tailwind', 1 );
