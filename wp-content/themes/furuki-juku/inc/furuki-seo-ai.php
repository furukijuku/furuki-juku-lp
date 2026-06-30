<?php
/**
 * SEO / AEO: 構造化データ・llms.txt 連携（LP本文は増やさない）
 */

function furuki_seo_ai_base_url() {
	return untrailingslashit( home_url( '/' ) );
}

function furuki_seo_ai_should_output_schema() {
	if ( is_admin() || ! is_singular( 'page' ) ) {
		return is_front_page();
	}
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	$tpl  = get_page_template_slug();
	if ( is_front_page() ) {
		return true;
	}
	if ( in_array( $slug, [ '2026summer', 'contact', 'event' ], true ) ) {
		return true;
	}
	return in_array( $tpl, [ 'furuki-lp-5kyoka.php', 'summer-course-page.php', 'contact-form.php', 'event-page.php' ], true );
}

function furuki_seo_ai_org_block( $base ) {
	return [
		'@type'        => [ 'EducationalOrganization', 'LocalBusiness' ],
		'@id'          => $base . '/#organization',
		'name'         => 'Furuki塾 江東住吉教室',
		'alternateName'=> [ 'Furuki塾', 'ふるき塾', 'フルキジュク', 'furuki juku' ],
		'url'          => $base . '/',
		'logo'         => $base . '/wp-content/themes/furuki-juku/assets/images/furuki-kanban.png',
		'image'        => $base . '/wp-content/themes/furuki-juku/assets/images/furuki-kanban.png',
		'description'  => '東京都江東区千田の個別指導学習塾。小学1年〜中学3年対象。5教科・速読解・プログラミング。夏期講習は通い放題プランで低価格。認定心理士の塾長が完全個別指導。',
		'telephone'    => '+81-3-6770-6936',
		'email'        => 'furusawa@furuki-juku.com',
		'address'      => [
			'@type'           => 'PostalAddress',
			'streetAddress'   => '千田11-13 丸万マンダリンハイム1F',
			'addressLocality' => '江東区',
			'addressRegion'   => '東京都',
			'postalCode'      => '135-0007',
			'addressCountry'  => 'JP',
		],
		'geo'          => [
			'@type'     => 'GeoCoordinates',
			'latitude'  => 35.6742,
			'longitude' => 139.8063,
		],
		'areaServed'   => [
			[ '@type' => 'City', 'name' => '江東区' ],
			[ '@type' => 'AdministrativeArea', 'name' => '東京都' ],
		],
		'knowsAbout'   => [
			'個別指導',
			'学習塾',
			'夏期講習',
			'定期テスト対策',
			'中学受験',
			'プログラミング教室',
			'速読解力',
		],
		'openingHoursSpecification' => [
			[
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ],
				'opens'     => '15:00',
				'closes'    => '21:30',
			],
		],
		'priceRange'   => '¥¥',
		'sameAs'       => [
			'https://www.instagram.com/furukijuku/',
			'https://lin.ee/7NV1Pld',
		],
		'hasOfferCatalog' => [
			'@type'           => 'OfferCatalog',
			'name'            => '学習コース・季節講習',
			'itemListElement' => [
				[ '@type' => 'Offer', 'itemOffered' => [ '@type' => 'Service', 'name' => '5教科学習コース（小学生）', 'serviceType' => '個別指導' ] ],
				[ '@type' => 'Offer', 'itemOffered' => [ '@type' => 'Service', 'name' => '5教科学習コース（中学生）', 'serviceType' => '個別指導' ] ],
				[ '@type' => 'Offer', 'itemOffered' => [ '@type' => 'Service', 'name' => '速読解力講座' ] ],
				[ '@type' => 'Offer', 'itemOffered' => [ '@type' => 'Service', 'name' => 'プログラミング講座' ] ],
				[ '@type' => 'Offer', 'itemOffered' => [ '@type' => 'Course', 'name' => '夏期講習 2026', 'url' => $base . '/2026summer/' ] ],
			],
		],
	];
}

function furuki_seo_ai_summer_courses( $base ) {
	$org = [ '@id' => $base . '/#organization' ];
	return [
		[
			'@type'            => 'Course',
			'@id'              => $base . '/2026summer/#course-elementary',
			'name'             => '夏期講習 小学3〜5年生コース',
			'description'      => '夏休みの宿題・読書感想文対応。完全個別指導。通い放題（1日最大2時間）。',
			'provider'         => $org,
			'url'              => $base . '/2026summer/',
			'courseMode'       => 'blended',
			'educationalLevel' => '小学3年生〜小学5年生',
			'hasCourseInstance'=> [
				'@type'     => 'CourseInstance',
				'name'      => '夏期講習 2026',
				'courseMode'=> 'onsite',
				'startDate' => '2026-07-21',
				'endDate'   => '2026-08-31',
			],
			'offers'           => [
				'@type'         => 'Offer',
				'price'         => '39650',
				'priceCurrency' => 'JPY',
				'availability'  => 'https://schema.org/LimitedAvailability',
				'url'           => $base . '/2026summer/#form',
				'validFrom'     => '2026-06-01',
				'validThrough'  => '2026-08-31',
			],
		],
		[
			'@type'            => 'Course',
			'@id'              => $base . '/2026summer/#course-middle',
			'name'             => '夏期講習 中学1・2年生コース',
			'description'      => '定期テスト対策から受験準備へ。通い放題（1日最大4時間）。9月定期テストまで通塾可。',
			'provider'         => $org,
			'url'              => $base . '/2026summer/',
			'educationalLevel' => '中学1年生・中学2年生',
			'hasCourseInstance'=> [
				'@type'     => 'CourseInstance',
				'startDate' => '2026-07-21',
				'endDate'   => '2026-08-31',
			],
			'offers'           => [
				'@type'         => 'Offer',
				'price'         => '39650',
				'priceCurrency' => 'JPY',
				'url'           => $base . '/2026summer/#form',
			],
		],
		[
			'@type'            => 'Course',
			'@id'              => $base . '/2026summer/#course-junior3',
			'name'             => '夏期講習 中学3年生・受験対策コース',
			'description'      => '志望校合格に向けた夏期集中。通い放題（1日最大8時間）。',
			'provider'         => $org,
			'url'              => $base . '/2026summer/',
			'educationalLevel' => '中学3年生',
			'offers'           => [
				'@type'         => 'Offer',
				'price'         => '55000',
				'priceCurrency' => 'JPY',
				'url'           => $base . '/2026summer/#form',
			],
		],
		[
			'@type'       => 'Course',
			'@id'         => $base . '/2026summer/#course-programming',
			'name'        => '夏期講習 プログラミングコース',
			'description' => 'Scratch・Roblox。初心者歓迎。60分×3回または120分×3回。',
			'provider'    => $org,
			'url'         => $base . '/2026summer/',
			'offers'      => [
				'@type'         => 'Offer',
				'price'         => '8800',
				'priceCurrency' => 'JPY',
				'url'           => $base . '/2026summer/#form',
			],
		],
	];
}

function furuki_seo_ai_faq_entities() {
	return [
		[
			'@type'          => 'Question',
			'name'           => '無料体験はいつでも受けられますか？',
			'acceptedAnswer' => [
				'@type' => 'Answer',
				'text'  => 'はい、随時受け付けています。初回から2週間以内に最大3回まで無料で体験できます。',
			],
		],
		[
			'@type'          => 'Question',
			'name'           => '定期テスト前に特別な対応はありますか？',
			'acceptedAnswer' => [
				'@type' => 'Answer',
				'text'  => 'テスト前には通塾日を増やすなど柔軟に対応しています。中学生向けには定期テストまでサポート込みのプランも用意しています（季節講習時）。',
			],
		],
		[
			'@type'          => 'Question',
			'name'           => '発達の特性があるお子さんでも通えますか？',
			'acceptedAnswer' => [
				'@type' => 'Answer',
				'text'  => 'はい、対応しています。塾長は認定心理士でもあり、お子さんの特性や学習スタイルを丁寧に把握しながら指導します。',
			],
		],
		[
			'@type'          => 'Question',
			'name'           => '入塾前に後悔しないか不安です',
			'acceptedAnswer' => [
				'@type' => 'Answer',
				'text'  => 'まずは無料体験で授業の雰囲気を確認してからご判断ください。無理な勧誘は一切行っておりません。',
			],
		],
	];
}

function furuki_seo_ai_output_schema() {
	if ( ! furuki_seo_ai_should_output_schema() ) {
		return;
	}

	$base   = furuki_seo_ai_base_url();
	$graph  = [];
	$graph[] = furuki_seo_ai_org_block( $base );

	$graph[] = [
		'@type'     => 'WebSite',
		'@id'       => $base . '/#website',
		'url'       => $base . '/',
		'name'      => 'Furuki塾 江東住吉教室',
		'publisher' => [ '@id' => $base . '/#organization' ],
		'inLanguage'=> 'ja',
	];

	$is_summer = is_page( '2026summer' ) || get_page_template_slug() === 'summer-course-page.php';
	$is_home   = is_front_page() || get_page_template_slug() === 'furuki-lp-5kyoka.php';

	if ( $is_home || $is_summer ) {
		foreach ( furuki_seo_ai_summer_courses( $base ) as $course ) {
			$graph[] = $course;
		}
	}

	if ( $is_home ) {
		$graph[] = [
			'@type'      => 'FAQPage',
			'@id'        => $base . '/#faq',
			'mainEntity' => furuki_seo_ai_faq_entities(),
		];
	}

	if ( $is_summer ) {
		$graph[] = [
			'@type'       => 'WebPage',
			'@id'         => $base . '/2026summer/#webpage',
			'url'         => $base . '/2026summer/',
			'name'        => '夏期講習 2026 | Furuki塾 江東住吉教室',
			'description' => 'Furuki塾の夏期講習2026。7/21〜8/31。小学3〜5・中学1・2・中3受験・プログラミング。江東区千田の個別指導塾。',
			'isPartOf'    => [ '@id' => $base . '/#website' ],
			'about'       => [ '@id' => $base . '/#organization' ],
			'inLanguage'  => 'ja',
		];
	}

	echo '<script type="application/ld+json">' . wp_json_encode(
		[
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		],
		JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
	) . '</script>' . "\n";
}
add_action( 'wp_head', 'furuki_seo_ai_output_schema', 2 );

function furuki_seo_ai_llms_link() {
	if ( ! furuki_seo_ai_should_output_schema() ) {
		return;
	}
	echo '<link rel="alternate" type="text/plain" href="' . esc_url( home_url( '/llms.txt' ) ) . '" title="LLM site summary">' . "\n";
}
add_action( 'wp_head', 'furuki_seo_ai_llms_link', 1 );

function furuki_seo_ai_robots_txt( $output, $public ) {
	if ( ! $public ) {
		return $output;
	}
	$lines = [
		'',
		'# AI crawlers welcome',
		'User-agent: GPTBot',
		'Allow: /',
		'',
		'User-agent: ChatGPT-User',
		'Allow: /',
		'',
		'User-agent: Google-Extended',
		'Allow: /',
		'',
		'User-agent: anthropic-ai',
		'Allow: /',
		'',
		'User-agent: ClaudeBot',
		'Allow: /',
		'',
		'User-agent: PerplexityBot',
		'Allow: /',
		'',
		'Sitemap: ' . home_url( '/wp-sitemap.xml' ),
		'Llms-Txt: ' . home_url( '/llms.txt' ),
	];
	return trim( $output ) . implode( "\n", $lines ) . "\n";
}
add_filter( 'robots_txt', 'furuki_seo_ai_robots_txt', 10, 2 );

function furuki_seo_ai_register_llms_route() {
	add_rewrite_rule( '^llms\.txt$', 'index.php?furuki_llms_txt=1', 'top' );
}
add_action( 'init', 'furuki_seo_ai_register_llms_route' );

function furuki_seo_ai_llms_query_var( $vars ) {
	$vars[] = 'furuki_llms_txt';
	return $vars;
}
add_filter( 'query_vars', 'furuki_seo_ai_llms_query_var' );

function furuki_seo_ai_serve_llms_txt() {
	if ( ! get_query_var( 'furuki_llms_txt' ) ) {
		return;
	}
	$file = get_template_directory() . '/assets/llms.txt';
	if ( ! is_readable( $file ) ) {
		status_header( 404 );
		exit;
	}
	header( 'Content-Type: text/plain; charset=utf-8' );
	readfile( $file );
	exit;
}
add_action( 'template_redirect', 'furuki_seo_ai_serve_llms_txt' );

function furuki_seo_ai_maybe_flush_llms_rewrite() {
	if ( get_option( 'furuki_llms_rewrite_flushed' ) ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'furuki_llms_rewrite_flushed', 1 );
}
add_action( 'init', 'furuki_seo_ai_maybe_flush_llms_rewrite', 99 );
