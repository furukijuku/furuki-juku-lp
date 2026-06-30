<?php

/**
 * 本番で PHP mail() が使えない場合、サーバーの wp-config.php に次を定義（Git に含めない）:
 * define( 'FURUKI_SMTP_HOST', 'smtp.gmail.com' );
 * define( 'FURUKI_SMTP_PORT', 587 );
 * define( 'FURUKI_SMTP_ENCRYPTION', 'tls' ); // tls | ssl | ''
 * define( 'FURUKI_SMTP_USER', 'furuki.jyuku@gmail.com' );
 * define( 'FURUKI_SMTP_PASS', 'Googleアプリパスワード' );
 * define( 'FURUKI_MAIL_FROM', 'furuki.jyuku@gmail.com' ); // SMTP 利用アドレスと揃える
 * define( 'FURUKI_MAIL_FROM_NAME', 'Furuki塾' );
 */
function furuki_juku_phpmailer_smtp( $phpmailer ) {
	if ( ! defined( 'FURUKI_SMTP_HOST' ) || ! FURUKI_SMTP_HOST ) {
		return;
	}
	$phpmailer->isSMTP();
	$phpmailer->Host       = FURUKI_SMTP_HOST;
	$phpmailer->SMTPAuth   = true;
	$phpmailer->Port       = defined( 'FURUKI_SMTP_PORT' ) ? (int) FURUKI_SMTP_PORT : 587;
	$phpmailer->Username   = defined( 'FURUKI_SMTP_USER' ) ? FURUKI_SMTP_USER : '';
	$phpmailer->Password   = defined( 'FURUKI_SMTP_PASS' ) ? FURUKI_SMTP_PASS : '';
	$enc                   = defined( 'FURUKI_SMTP_ENCRYPTION' ) ? (string) FURUKI_SMTP_ENCRYPTION : 'tls';
	$phpmailer->SMTPSecure = in_array( $enc, [ 'tls', 'ssl', '' ], true ) ? $enc : 'tls';
	$phpmailer->CharSet    = 'UTF-8';
}
add_action( 'phpmailer_init', 'furuki_juku_phpmailer_smtp' );

if ( defined( 'FURUKI_SMTP_HOST' ) && FURUKI_SMTP_HOST ) {
	add_filter(
		'wp_mail_from',
		static function ( $email ) {
			return ( defined( 'FURUKI_MAIL_FROM' ) && FURUKI_MAIL_FROM ) ? FURUKI_MAIL_FROM : $email;
		}
	);
	add_filter(
		'wp_mail_from_name',
		static function ( $name ) {
			return ( defined( 'FURUKI_MAIL_FROM_NAME' ) && FURUKI_MAIL_FROM_NAME ) ? FURUKI_MAIL_FROM_NAME : $name;
		}
	);
}

function furuki_juku_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );

    register_nav_menus( [
        'primary' => 'ヘッダーナビゲーション',
    ] );
}
add_action( 'after_setup_theme', 'furuki_juku_setup' );

/**
 * 夏期講習固定ページ（/2026summer/）が無ければ自動作成
 */
function furuki_juku_ensure_summer_page() {
	if ( get_page_by_path( '2026summer' ) ) {
		return;
	}
	$page_id = wp_insert_post(
		[
			'post_title'  => '夏期講習 2026',
			'post_name'   => '2026summer',
			'post_status' => 'publish',
			'post_type'   => 'page',
		],
		true
	);
	if ( ! is_wp_error( $page_id ) && $page_id ) {
		update_post_meta( $page_id, '_wp_page_template', 'summer-course-page.php' );
	}
}
add_action( 'init', 'furuki_juku_ensure_summer_page' );

require get_template_directory() . '/inc/furuki-seo-ai.php';

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
