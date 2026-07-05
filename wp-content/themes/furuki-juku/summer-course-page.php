<?php
/**
 * Template Name: 夏期講習募集ページ
 * Description: Furuki塾 夏期講習 2026 募集・申込ページ
 */

define( 'FURUKI_SUMMER_MAIL_1', 'furuki.jyuku@gmail.com' );
define( 'FURUKI_SUMMER_MAIL_2', 'furusawa@furuki-juku.com' );

$summer_base = get_template_directory_uri() . '/assets/summer/';
$summer_dir  = get_template_directory() . '/assets/summer/';

function furuki_summer_asset( $filename, $base, $dir ) {
	$path = $dir . $filename;
	if ( ! file_exists( $path ) ) {
		return '';
	}
	return $base . $filename;
}

/* ============================================================
   ★ 夏期講習設定（残席・表示はここを更新）
============================================================ */
$summer = [
	'year'     => '2026',
	'period'   => '7/21（月）〜8/31（月）',
	'hours'    => '9:00〜13:00・14:00〜18:00',
	'deadline' => '満席になり次第',
	'place'    => 'Furuki塾 江東住吉教室（東京都江東区千田11-13 丸万マンダリンハイム1F）',
	'perks'    => [
		'入塾金不要',
		'無料体験は1回のみ',
	],
];

$courses = [
	'elementary' => [
		'id'       => 'elementary',
		'label'    => '小学3〜5',
		'tab'      => '小学生',
		'theme'    => 'warm',
		'badge'    => '夏期講習 ｜ 小学3〜5年生コース',
		'headline' => '夏休みの成長を、確実に。',
		'lead'     => '「のんびりさせてあげたい」と「宿題が心配」——そのギャップを、私たちが埋めます。',
		'sub'      => '「やりきった！」という自信と一緒に、ひと回り大きくなった姿で秋を迎えましょう。',
		'checks'   => [
			'読書感想文・作文は、対話しながら「言葉を引き出す」',
			'夏休みの宿題を、涼しい教室で計画的に終わらせる',
			'「わからない」をそのままにしない、完全個別指導',
			'秋を、ひと回り大きくなった姿で迎える',
		],
		'highlight' => '夏期は『通い放題』・毎日でも通えます',
		'target'    => '小学3〜5年生',
		'time_note' => '1日最大2時間',
		'price'     => '39,650',
		'left'      => 0,
		'char'      => 'character-banzai.png',
	],
	'middle' => [
		'id'       => 'middle',
		'label'    => '中学1・2',
		'tab'      => '中学1・2',
		'theme'    => 'green',
		'badge'    => '夏期講習 ｜ 中学1年・中学2年生コース',
		'headline' => '定期テスト対策から、受験準備へ。',
		'lead'     => 'この夏は、「自分で勉強するリズム」を整える。2学期からの差は、ここでつきます。',
		'sub'      => '',
		'checks'   => [
			'定期テストの「次の一手」を一緒に設計',
			'苦手単元までさかのぼる完全個別指導',
			'部活と両立できる柔軟な時間割',
			'「自分で計画して進める」学習リズムが身につく',
		],
		'highlight' => '通い放題｜9月の定期テスト終了まで通塾OK',
		'target'    => '中学1年・中学2年生',
		'time_note' => '1日最大4時間',
		'price'     => '39,650',
		'left'      => 2,
		'char'      => '',
	],
	'junior3' => [
		'id'       => 'junior3',
		'label'    => '中学3・受験',
		'tab'      => '中3受験',
		'theme'    => 'dark',
		'badge'    => '夏期講習 ｜ 中学3年生・受験対策コース',
		'headline' => '志望校合格へ、本気の夏。',
		'lead'     => '漠然とした不安を、「覚悟」と「自信」に変える一歩に。',
		'sub'      => '',
		'checks'   => [
			'親の「大丈夫？」という不安を、安心感に変える',
			'1日最大8時間、じっくり机に向かう環境',
			'数学・英語の強化ポイントを的確に絞り込む',
			'大手塾の競争ではなく「一人の課題と向き合う」個別対応',
		],
		'highlight' => '夏期は通い放題・本番まで通い込める',
		'target'    => '中学3年生',
		'time_note' => '1日最大8時間',
		'price'     => '55,000',
		'left'      => 1,
		'urgent'    => true,
		'char'      => '',
	],
	'programming' => [
		'id'       => 'programming',
		'label'    => 'プログラミング',
		'tab'      => 'プログラミング',
		'theme'    => 'code',
		'badge'    => '夏期講習 ｜ プログラミングコース',
		'headline' => '論理的思考力を、この夏に。',
		'lead'     => 'ゲームを「見る側」から「作る側」へ。',
		'sub'      => '',
		'checks'   => [
			'ゲーム・YouTubeを「見る側」から「作る側」へ',
			'論理的思考力（これからの時代に最も必要な力）が自然と身につく',
			'少人数制で「つまずいてもすぐ隣に先生がいる安心感」',
			'初心者でも「自分で作ったゲームが動く」喜びを体感',
		],
		'highlight' => '',
		'target'    => '全学年対象・初心者歓迎',
		'time_note' => '',
		'price'     => '8,800〜',
		'price_note'=> '60分×3回 ¥8,800 ／ 120分×3回 ¥15,400（追加受講も可）',
		'left'      => 3,
		'char'      => 'character-brain-idea.png',
	],
];

$course_options = [
	'elementary'  => '小学3〜5年生コース（通い放題 ¥39,650）',
	'middle'      => '中学1・2年生コース（通い放題 ¥39,650）',
	'junior3'     => '中学3年生・受験コース（通い放題 ¥55,000）',
	'programming' => 'プログラミングコース',
];

$prog_plans = [
	'60分×3回 ¥8,800（税込）',
	'120分×3回 ¥15,400（税込）',
];

/* ============================================================
   フォーム処理
============================================================ */
$errors  = [];
$success = false;
$vals    = [];

if ( isset( $_GET['thanks'] ) && (string) $_GET['thanks'] === '1' ) {
	$success = true;
}

$available_courses = array_filter( $courses, fn( $c ) => $c['left'] > 0 );
$all_full          = empty( $available_courses );

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! $success ) {
	if ( ! isset( $_POST['_summer_nonce'] ) || ! wp_verify_nonce( $_POST['_summer_nonce'], 'furuki_summer' ) ) {
		$errors[] = '不正なリクエストです。';
	} elseif ( ! empty( $_POST['website'] ) ) {
		$errors[] = '不正なリクエストです。';
	} else {
		$vals['child_name']          = sanitize_text_field( $_POST['child_name'] ?? '' );
		$vals['child_kana']          = sanitize_text_field( $_POST['child_kana'] ?? '' );
		$vals['gender']              = sanitize_text_field( $_POST['gender'] ?? '' );
		$vals['grade']               = sanitize_text_field( $_POST['grade'] ?? '' );
		$vals['school']              = sanitize_text_field( $_POST['school'] ?? '' );
		$vals['course']              = sanitize_text_field( $_POST['course'] ?? '' );
		$vals['prog_plan']           = sanitize_text_field( $_POST['prog_plan'] ?? '' );
		$vals['contact_preference']  = sanitize_text_field( $_POST['contact_preference'] ?? '' );
		$vals['phone']               = sanitize_text_field( $_POST['phone'] ?? '' );
		$vals['email']               = sanitize_email( $_POST['email'] ?? '' );
		$vals['consult']             = isset( $_POST['consult'] ) ? '希望する' : '希望しない';
		$vals['trial']               = isset( $_POST['trial'] ) ? '希望する' : '希望しない';
		$vals['message']             = sanitize_textarea_field( $_POST['message'] ?? '' );

		if ( empty( $vals['child_name'] ) ) {
			$errors[] = 'お子さまのお名前を入力してください。';
		}
		if ( empty( $vals['child_kana'] ) ) {
			$errors[] = 'ふりがなを入力してください。';
		}
		if ( empty( $vals['gender'] ) ) {
			$errors[] = 'お子さまの性別を選択してください。';
		} elseif ( ! in_array( $vals['gender'], [ '男の子', '女の子', '回答しない' ], true ) ) {
			$errors[] = '性別の選択が正しくありません。';
		}
		if ( empty( $vals['grade'] ) ) {
			$errors[] = '学年を選択してください。';
		}
		if ( empty( $vals['course'] ) || ! isset( $course_options[ $vals['course'] ] ) ) {
			$errors[] = '希望コースを選択してください。';
		} elseif ( isset( $courses[ $vals['course'] ] ) && $courses[ $vals['course'] ]['left'] <= 0 ) {
			$errors[] = '選択されたコースは満席です。';
		}
		if ( $vals['course'] === 'programming' && empty( $vals['prog_plan'] ) ) {
			$errors[] = 'プログラミングコースのプランを選択してください。';
		}
		if ( empty( $vals['contact_preference'] ) ) {
			$errors[] = 'ご希望のご連絡方法を選択してください。';
		} elseif ( ! in_array( $vals['contact_preference'], [ '電話', 'メール' ], true ) ) {
			$errors[] = 'ご希望のご連絡方法の選択が正しくありません。';
		} elseif ( $vals['contact_preference'] === '電話' && empty( $vals['phone'] ) ) {
			$errors[] = '電話連絡希望の方は、お電話番号を入力してください。';
		}
		if ( empty( $vals['email'] ) ) {
			$errors[] = 'メールアドレスを入力してください。';
		} elseif ( ! is_email( $vals['email'] ) ) {
			$errors[] = 'メールアドレスの形式が正しくありません。';
		}

		if ( empty( $errors ) ) {
			$course_label = $course_options[ $vals['course'] ];
			$plan_line    = ( $vals['course'] === 'programming' ) ? "\n【プラン】　　　{$vals['prog_plan']}" : '';

			$subject = "【Furuki塾夏期講習】申込：{$vals['child_name']} 様";
			$body    = "夏期講習のお申し込みが届きました。\n";
			$body   .= str_repeat( '━', 28 ) . "\n";
			$body   .= "【期間】　　　　{$summer['period']}\n";
			$body   .= str_repeat( '━', 28 ) . "\n";
			$body   .= "【お子さまの名前】{$vals['child_name']}（{$vals['child_kana']}）\n";
			$body   .= "【性別】　　　　{$vals['gender']}\n";
			$body   .= "【学年】　　　　{$vals['grade']}\n";
			$body   .= "【通学校】　　　" . ( $vals['school'] ?: '（未記入）' ) . "\n";
			$body   .= "【希望コース】　{$course_label}{$plan_line}\n";
			$body   .= "【事前相談】　　{$vals['consult']}\n";
			$body   .= "【体験希望】　　{$vals['trial']}\n";
			$body   .= "【連絡方法】　　{$vals['contact_preference']}\n";
			$body   .= "【電話番号】　　" . ( $vals['phone'] ?: '（未記入）' ) . "\n";
			$body   .= "【メール】　　　{$vals['email']}\n";
			if ( ! empty( $vals['message'] ) ) {
				$body .= "【備考】\n{$vals['message']}\n";
			}
			$body .= str_repeat( '━', 28 ) . "\n";

			$headers = [
				'Content-Type: text/plain; charset=UTF-8',
				'Reply-To: ' . $vals['child_name'] . ' <' . $vals['email'] . '>',
			];

			$sent_a = wp_mail( FURUKI_SUMMER_MAIL_1, $subject, $body, $headers );
			$sent_b = wp_mail( FURUKI_SUMMER_MAIL_2, $subject, $body, $headers );

			if ( $sent_a && $sent_b ) {
				$auto  = "{$vals['child_name']} 様\n\n";
				$auto .= "Furuki塾 夏期講習のお申し込みありがとうございます。\n";
				$auto .= "以下の内容で受け付けました。担当よりご連絡いたします。\n\n";
				$auto .= str_repeat( '━', 28 ) . "\n";
				$auto .= "【期間】　　　　{$summer['period']}\n";
				$auto .= "【希望コース】　{$course_label}{$plan_line}\n";
				$auto .= "【学年】　　　　{$vals['grade']}\n";
				$auto .= "【事前相談】　　{$vals['consult']}\n";
				$auto .= "【体験希望】　　{$vals['trial']}\n";
				$auto .= "【連絡方法】　　{$vals['contact_preference']}\n";
				$auto .= str_repeat( '━', 28 ) . "\n\n";
				$auto .= "※ 夏期講習のみのお申し込みに入塾金はかかりません。\n";
				$auto .= "※ 夏期講習の無料体験は1回のみです。\n\n";
				$auto .= "しつこい勧誘はございません。ご不明点はお気軽にどうぞ。\n\n";
				$auto .= "Furuki塾 江東住吉教室\n";
				$auto .= "TEL: 03-6770-6936\n";
				$auto .= "LINE: https://lin.ee/7NV1Pld\n";

				$auto_headers = [
					'Content-Type: text/plain; charset=UTF-8',
					'From: Furuki塾 <furusawa@furuki-juku.com>',
				];
				wp_mail( $vals['email'], '【Furuki塾】夏期講習お申し込みありがとうございます', $auto, $auto_headers );

				wp_safe_redirect( add_query_arg( 'thanks', '1', home_url( '/2026summer/#form' ) ) );
				exit;
			}
			$errors[] = '送信に失敗しました。お手数ですがLINEまたはお電話でご連絡ください。';
		}
	}
}

$default_tab = 'elementary';
if ( ! empty( $_GET['course'] ) && isset( $courses[ $_GET['course'] ] ) ) {
	$default_tab = sanitize_key( $_GET['course'] );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>夏期講習 <?php echo esc_html( $summer['year'] ); ?> | Furuki塾 江東住吉教室</title>
<meta name="description" content="江東区千田のFuruki塾 夏期講習2026。7/21〜8/31。小学3〜5・中学1・2・中3受験・プログラミング。個別指導・通い放題で低価格。Web申込受付中。">
<link rel="canonical" href="<?php echo esc_url( home_url( '/2026summer/' ) ); ?>">
<meta property="og:title" content="夏期講習2026 | Furuki塾 江東住吉教室">
<meta property="og:description" content="江東区の個別指導塾Furuki塾の夏期講習。通い放題39,650円〜。7/21〜8/31。">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo esc_url( home_url( '/2026summer/' ) ); ?>">
<meta property="og:locale" content="ja_JP">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@500;700;900&family=Noto+Sans+JP:wght@400;500;700;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --navy:#2B4C7E;--orange:#E8964F;--orange-dark:#D97E3A;
  --green:#57A27F;--green-dark:#468A70;
  --gold:#D4A574;--dark:#2C3E50;
  --code:#1BB4C4;--line:#06C755;
  --text:#1a1a1a;--muted:#78716c;--border:#EADFCE;
  --radius:16px;
}
body{font-family:'Noto Sans JP',sans-serif;background:#fafaf9;color:var(--text);line-height:1.7}
.zen{font-family:'Zen Maru Gothic',sans-serif}

.sm-nav{background:rgba(255,251,245,.97);border-bottom:1px solid var(--border);padding:0 20px;height:60px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
.sm-nav-logo{font-family:'Zen Maru Gothic',sans-serif;font-weight:900;font-size:18px;color:var(--orange);text-decoration:none}
.sm-nav-back{font-size:13px;font-weight:600;color:var(--navy);text-decoration:none}

.sm-hero{background:linear-gradient(140deg,#FBF6EF 0%,#FFF4E6 50%,#EFF8FF 100%);padding:48px 20px 40px;text-align:center;position:relative;overflow:hidden}
.sm-hero-badge{display:inline-block;background:var(--navy);color:#fff;font-size:13px;font-weight:700;letter-spacing:.08em;padding:8px 18px;border-radius:9999px;margin-bottom:16px}
.sm-hero-title{font-family:'Zen Maru Gothic',sans-serif;font-weight:900;font-size:clamp(28px,5vw,42px);line-height:1.25;margin-bottom:10px}
.sm-hero-title em{font-style:normal;color:var(--orange)}
.sm-hero-meta{font-size:15px;color:#555;font-weight:500}
.sm-hero-meta strong{color:var(--navy)}
.sm-hero-perks{display:flex;flex-wrap:wrap;justify-content:center;gap:8px;margin-top:14px}
.sm-hero-perk{display:inline-flex;align-items:center;gap:4px;background:#fff;border:1.5px solid var(--orange);color:var(--orange-dark);font-size:13px;font-weight:700;padding:6px 14px;border-radius:9999px}

.sm-wrap{max-width:920px;margin:0 auto;padding:0 20px 64px}

.sm-tabs{display:flex;flex-wrap:wrap;gap:8px;margin:28px 0 20px}
.sm-tab{flex:1;min-width:120px;border:2px solid var(--border);background:#fff;border-radius:12px;padding:12px 8px;font-size:13px;font-weight:700;color:var(--muted);cursor:pointer;text-align:center;transition:all .15s}
.sm-tab.active{border-color:var(--navy);background:var(--navy);color:#fff}
.sm-tab[data-theme="green"].active{border-color:var(--green-dark);background:var(--green-dark)}
.sm-tab[data-theme="dark"].active{border-color:var(--gold);background:var(--dark);color:var(--gold)}
.sm-tab[data-theme="code"].active{border-color:var(--code);background:#12122A;color:var(--code)}

.sm-panel{display:none;border-radius:var(--radius);padding:28px 24px 24px;position:relative;overflow:hidden;border:1.5px solid var(--border)}
.sm-panel.active{display:block}
.sm-panel.theme-warm{background:#FBF6EF;background-image:radial-gradient(rgba(43,76,126,.05) 1.4px,transparent 1.4px);background-size:22px 22px}
.sm-panel.theme-green{background:#F4FAF6;background-image:radial-gradient(rgba(43,76,126,.05) 1.4px,transparent 1.4px);background-size:22px 22px}
.sm-panel.theme-dark{background:var(--dark);color:#F5F7FA;border-color:#41576C}
.sm-panel.theme-code{background:#12122A;color:#fff;border-color:#2a2a5e;background-image:linear-gradient(rgba(0,212,170,.07) 1px,transparent 1px),linear-gradient(90deg,rgba(0,212,170,.07) 1px,transparent 1px);background-size:40px 40px}

.sm-course-badge{display:inline-block;font-family:'Zen Maru Gothic',sans-serif;font-weight:700;font-size:14px;padding:7px 16px;border-radius:9999px;margin-bottom:14px}
.theme-warm .sm-course-badge{background:var(--orange);color:#fff}
.theme-green .sm-course-badge{background:var(--green);color:#fff}
.theme-dark .sm-course-badge{background:rgba(212,165,116,.16);color:var(--gold);border:1.5px solid rgba(212,165,116,.5)}
.theme-code .sm-course-badge{background:rgba(27,180,196,.14);color:var(--code);border:1.5px solid rgba(27,180,196,.5)}

.sm-headline{font-family:'Zen Maru Gothic',sans-serif;font-weight:900;font-size:clamp(24px,4vw,34px);line-height:1.25;margin-bottom:12px;max-width:520px}
.theme-warm .sm-headline em,.theme-green .sm-headline em{font-style:normal}
.theme-warm .sm-headline em{color:var(--orange)}
.theme-green .sm-headline em{color:var(--green)}
.theme-dark .sm-headline em{color:var(--gold)}
.theme-code .sm-headline em{color:var(--code)}
.sm-lead{font-size:16px;line-height:1.7;margin-bottom:8px;max-width:560px}
.theme-warm .sm-lead{color:#555}
.theme-green .sm-lead{color:#3a3a3a}
.theme-dark .sm-lead{color:#D7DEE5}
.theme-code .sm-lead{color:rgba(255,255,255,.82)}

.sm-char{position:absolute;right:16px;top:80px;width:140px;height:auto;image-rendering:pixelated;filter:drop-shadow(0 8px 16px rgba(0,0,0,.15));pointer-events:none}
.theme-code .sm-char{right:20px;top:auto;bottom:120px;width:90px;filter:drop-shadow(0 0 12px rgba(0,212,170,.35))}
@media(max-width:720px){.sm-char{display:none}}

.sm-checks{display:flex;flex-direction:column;gap:12px;margin:20px 0;position:relative;z-index:1}
.sm-check{display:flex;align-items:flex-start;gap:12px;background:#fff;border:1.5px solid var(--border);border-left:5px solid var(--orange);border-radius:12px;padding:14px 16px;font-size:15px;line-height:1.55}
.theme-green .sm-check{border-color:#D8EDE0;border-left-color:var(--green)}
.theme-dark .sm-check{background:#34495E;border-color:#41576C;border-left-color:var(--gold);color:#F5F7FA}
.theme-code .sm-check{background:#1a1a3e;border-color:#2a2a5e;border-left-color:var(--code);color:#F2F2FF}
.sm-check-mark{font-weight:900;flex-shrink:0}
.theme-warm .sm-check-mark{color:var(--orange)}
.theme-green .sm-check-mark{color:var(--green)}
.theme-dark .sm-check-mark{color:var(--gold)}
.theme-code .sm-check-mark{color:#00D4AA}

.sm-info-row{display:flex;flex-wrap:wrap;gap:14px;margin-top:8px;position:relative;z-index:1}
.sm-info-box{flex:1;min-width:240px;background:#FFF4E6;border:1.5px solid var(--border);border-radius:14px;padding:16px 18px}
.theme-green .sm-info-box{background:#EAF4EE;border-color:#D8EDE0}
.theme-dark .sm-info-box{background:#34495E;border-color:#41576C;color:#E6ECF1}
.theme-code .sm-info-box{background:#1a1a3e;border-color:#2a2a5e;color:#E6E6F5}
.sm-info-highlight{display:inline-block;font-family:'Zen Maru Gothic',sans-serif;font-weight:700;font-size:13px;padding:5px 14px;border-radius:9999px;margin-bottom:10px}
.theme-warm .sm-info-highlight{background:var(--orange);color:#fff}
.theme-green .sm-info-highlight{background:var(--green-dark);color:#fff}
.theme-dark .sm-info-highlight{background:var(--gold);color:var(--dark);font-weight:900}
.sm-info-line{display:flex;gap:10px;font-size:15px;margin-bottom:6px}
.sm-info-label{font-weight:700;min-width:48px;flex-shrink:0}
.theme-warm .sm-info-label{color:#4A90A4}
.theme-green .sm-info-label{color:var(--green-dark)}
.theme-dark .sm-info-label{color:var(--gold)}
.theme-code .sm-info-label{color:var(--code)}
.sm-price{font-family:'Zen Maru Gothic',sans-serif;font-weight:900;font-size:24px}
.theme-dark .sm-price{color:#fff}

.sm-seats{width:150px;background:var(--orange-dark);border-radius:14px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#fff;padding:16px 12px;text-align:center;box-shadow:0 8px 20px rgba(217,126,58,.3);position:relative}
.theme-green .sm-seats{background:var(--green-dark);box-shadow:0 8px 20px rgba(70,138,112,.28)}
.theme-dark .sm-seats{background:#C85A54;box-shadow:0 8px 20px rgba(200,90,84,.35)}
.theme-code .sm-seats{background:#128C9E;box-shadow:0 0 20px rgba(18,140,158,.4)}
.sm-seats-label{font-size:12px;font-weight:700;opacity:.92}
.sm-seats-num{font-family:'Zen Maru Gothic',sans-serif;font-weight:900;font-size:32px;line-height:1.1;margin-top:4px}
.sm-seats.full{background:#78716C;box-shadow:none}

.sm-brand{text-align:center;margin:40px 0 8px;font-family:'Zen Maru Gothic',sans-serif;font-weight:700;font-size:clamp(18px,3vw,24px);color:var(--navy);line-height:1.6}

.sm-cta-bar{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin:24px 0}
.sm-cta-btn{display:flex;flex-direction:column;align-items:center;gap:4px;padding:16px 8px;border-radius:9999px;text-decoration:none;font-family:'Zen Maru Gothic',sans-serif;font-weight:700;font-size:15px;color:#fff;transition:transform .15s}
.sm-cta-btn:hover{transform:translateY(-2px);color:#fff}
.sm-cta-line{background:var(--line)}
.sm-cta-tel{background:var(--orange)}
.sm-cta-web{background:var(--navy)}
@media(max-width:560px){.sm-cta-bar{grid-template-columns:1fr}}

.sm-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:24px;margin-top:32px;box-shadow:0 4px 20px rgba(0,0,0,.06)}
.sm-card-title{font-family:'Zen Maru Gothic',sans-serif;font-weight:900;font-size:20px;margin-bottom:18px;color:var(--navy)}

.sm-alert{padding:16px;border-radius:10px;margin-bottom:16px;font-size:14px}
.sm-alert-error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}
.sm-alert-success{background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;text-align:center;padding:28px}
.sm-success-icon{font-size:40px;margin-bottom:8px}

.sm-field{margin-bottom:16px}
.sm-field label{display:block;font-size:13px;font-weight:700;margin-bottom:6px}
.sm-req{color:#dc2626;font-size:11px;margin-left:4px}
.sm-opt{color:var(--muted);font-size:11px;margin-left:4px;font-weight:500}
.sm-field input,.sm-field select,.sm-field textarea{width:100%;padding:12px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:15px;font-family:inherit;background:#fff}
.sm-field textarea{min-height:100px;resize:vertical}
.sm-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
@media(max-width:560px){.sm-row{grid-template-columns:1fr}}

.sm-course-radio{display:flex;flex-direction:column;gap:8px}
.sm-course-radio label{display:flex;align-items:center;gap:10px;padding:12px 14px;border:1.5px solid var(--border);border-radius:10px;cursor:pointer;font-size:14px;font-weight:500}
.sm-course-radio label.disabled{opacity:.45;cursor:not-allowed}
.sm-course-radio input{accent-color:var(--navy);width:18px;height:18px;flex-shrink:0}
.sm-course-radio .full-tag{margin-left:auto;font-size:11px;font-weight:700;color:#78716C}

.sm-prog-plans{display:none;flex-direction:column;gap:8px;margin-top:8px;padding-left:4px}
.sm-prog-plans.show{display:flex}

.sm-check-wrap{display:flex;align-items:flex-start;gap:10px;padding:12px 14px;border:1.5px solid var(--border);border-radius:10px;cursor:pointer;margin-bottom:8px}
.sm-check-wrap input{margin-top:3px;accent-color:var(--navy);width:18px;height:18px;flex-shrink:0}
.sm-check-label{font-size:14px;font-weight:600;line-height:1.45}
.sm-check-label small{display:block;font-size:12px;font-weight:400;color:var(--muted);margin-top:2px}

.sm-submit{width:100%;padding:16px;background:var(--orange);color:#fff;border:none;border-radius:9999px;font-family:'Zen Maru Gothic',sans-serif;font-weight:900;font-size:17px;cursor:pointer;margin-top:8px;transition:background .15s}
.sm-submit:hover{background:var(--orange-dark)}
.sm-caution{font-size:12px;color:var(--muted);margin-top:12px;line-height:1.7}

.sm-footer{text-align:center;font-size:13px;color:var(--muted);margin-top:24px;line-height:1.8}
.sm-hp{position:absolute;left:-9999px;opacity:0;height:0;overflow:hidden}
</style>
<?php wp_head(); ?>
</head>
<body>

<nav class="sm-nav">
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sm-nav-logo">Furuki塾</a>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sm-nav-back">← トップに戻る</a>
</nav>

<div class="sm-hero">
  <div class="sm-hero-badge">SUMMER <?php echo esc_html( $summer['year'] ); ?> ☀</div>
  <h1 class="sm-hero-title zen">夏期講習 <em>受付中</em></h1>
  <p class="sm-hero-meta">
    <strong><?php echo esc_html( $summer['period'] ); ?></strong>
     ｜ 締切：<?php echo esc_html( $summer['deadline'] ); ?>
  </p>
  <div class="sm-hero-perks">
    <?php foreach ( $summer['perks'] as $perk ) : ?>
    <span class="sm-hero-perk">✓ <?php echo esc_html( $perk ); ?></span>
    <?php endforeach; ?>
  </div>
</div>

<main class="sm-wrap">

  <div class="sm-tabs" role="tablist">
    <?php foreach ( $courses as $key => $c ) : ?>
    <button type="button" class="sm-tab<?php echo $key === $default_tab ? ' active' : ''; ?>"
      data-tab="<?php echo esc_attr( $key ); ?>"
      data-theme="<?php echo esc_attr( $c['theme'] ); ?>"
      role="tab"><?php echo esc_html( $c['tab'] ); ?></button>
    <?php endforeach; ?>
  </div>

  <?php foreach ( $courses as $key => $c ) :
	$char_url = $c['char'] ? furuki_summer_asset( $c['char'], $summer_base, $summer_dir ) : '';
	$is_full  = $c['left'] <= 0;
	$hl       = $c['headline'];
	if ( preg_match( '/^(.+[、,])(.+)$/u', $hl, $m ) ) {
		$headline_html = esc_html( $m[1] ) . '<em>' . esc_html( $m[2] ) . '</em>';
	} else {
		$headline_html = esc_html( $hl );
	}
  ?>
  <div class="sm-panel theme-<?php echo esc_attr( $c['theme'] ); ?><?php echo $key === $default_tab ? ' active' : ''; ?>"
    id="panel-<?php echo esc_attr( $key ); ?>" role="tabpanel">
    <?php if ( $char_url ) : ?>
    <img src="<?php echo esc_url( $char_url ); ?>" alt="" class="sm-char" aria-hidden="true">
    <?php endif; ?>
    <div class="sm-course-badge"><?php echo esc_html( $c['badge'] ); ?></div>
    <h2 class="sm-headline zen"><?php echo $headline_html; ?></h2>
    <?php if ( $c['lead'] ) : ?><p class="sm-lead"><?php echo esc_html( $c['lead'] ); ?></p><?php endif; ?>
    <?php if ( ! empty( $c['sub'] ) ) : ?><p class="sm-lead"><?php echo esc_html( $c['sub'] ); ?></p><?php endif; ?>

    <div class="sm-checks">
      <?php foreach ( $c['checks'] as $check ) : ?>
      <div class="sm-check"><span class="sm-check-mark">✓</span><span><?php echo esc_html( $check ); ?></span></div>
      <?php endforeach; ?>
    </div>

    <div class="sm-info-row">
      <div class="sm-info-box">
        <?php if ( ! empty( $c['highlight'] ) ) : ?>
        <div class="sm-info-highlight">✦ <?php echo esc_html( $c['highlight'] ); ?></div>
        <?php endif; ?>
        <div class="sm-info-line"><span class="sm-info-label">対象</span><span><?php echo esc_html( $c['target'] ); ?></span></div>
        <div class="sm-info-line"><span class="sm-info-label">時間</span><span><?php echo esc_html( $summer['hours'] ); ?><?php echo $c['time_note'] ? '（' . esc_html( $c['time_note'] ) . '）' : ''; ?></span></div>
        <div class="sm-info-line"><span class="sm-info-label">料金</span><span>
          <?php if ( ! empty( $c['price_note'] ) ) : ?>
            <strong><?php echo esc_html( $c['price_note'] ); ?></strong> <span style="font-size:13px;opacity:.75">（税込）</span>
          <?php else : ?>
            <span class="sm-price">¥<?php echo esc_html( $c['price'] ); ?></span> <span style="font-size:13px;opacity:.75">（税込・通い放題）</span>
          <?php endif; ?>
        </span></div>
      </div>
      <div class="sm-seats<?php echo $is_full ? ' full' : ''; ?>">
        <span class="sm-seats-label"><?php echo $key === 'junior3' ? '受験生 募集' : '夏期 募集'; ?></span>
        <span class="sm-seats-num"><?php echo $is_full ? '満席' : '残り' . (int) $c['left'] . '名'; ?></span>
        <?php if ( $is_full ) : ?><span class="sm-seats-label">ご応募ありがとうございました</span><?php endif; ?>
        <?php if ( ! $is_full && ! empty( $c['urgent'] ) ) : ?><span class="sm-seats-label">ラスト1枠</span><?php endif; ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>

  <p class="sm-brand zen">自分で考える力は、<br>どんな時代でも一番の武器になる。</p>

  <div class="sm-cta-bar">
    <a href="https://lin.ee/7NV1Pld" class="sm-cta-btn sm-cta-line" target="_blank" rel="noopener">📱 LINEで相談</a>
    <a href="tel:0367706936" class="sm-cta-btn sm-cta-tel">📞 電話する</a>
    <a href="#form" class="sm-cta-btn sm-cta-web">📝 Webで申込</a>
  </div>

  <div class="sm-card" id="form">
    <div class="sm-card-title">✏️ 夏期講習 申し込みフォーム</div>

    <?php if ( $success ) : ?>
      <div class="sm-alert sm-alert-success">
        <div class="sm-success-icon">✅</div>
        <strong>お申し込みを受け付けました</strong>
        <p style="margin-top:8px">ご入力のメールアドレスに確認メールをお送りしました。<br>担当よりご連絡いたします。</p>
      </div>
      <p style="text-align:center;margin-top:16px"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--orange);font-weight:700">← トップページに戻る</a></p>

    <?php elseif ( $all_full ) : ?>
      <div class="sm-alert sm-alert-error">
        <strong>🙇 申し訳ありません。全コース満席となりました。</strong><br>
        キャンセル待ちをご希望の方はLINEまたはお電話（03-6770-6936）にてご連絡ください。
      </div>

    <?php else : ?>
      <?php if ( ! empty( $errors ) ) : ?>
        <div class="sm-alert sm-alert-error">
          <strong>入力内容をご確認ください</strong>
          <ul style="margin:8px 0 0 18px"><?php foreach ( $errors as $e ) : ?><li><?php echo esc_html( $e ); ?></li><?php endforeach; ?></ul>
        </div>
      <?php endif; ?>

      <form method="post" action="#form" novalidate>
        <?php wp_nonce_field( 'furuki_summer', '_summer_nonce' ); ?>
        <div class="sm-hp"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>

        <div class="sm-row">
          <div class="sm-field">
            <label>お子さまのお名前 <span class="sm-req">必須</span></label>
            <input type="text" name="child_name" value="<?php echo esc_attr( $vals['child_name'] ?? '' ); ?>" placeholder="例：山田 太郎">
          </div>
          <div class="sm-field">
            <label>ふりがな <span class="sm-req">必須</span></label>
            <input type="text" name="child_kana" value="<?php echo esc_attr( $vals['child_kana'] ?? '' ); ?>" placeholder="例：やまだ たろう">
          </div>
        </div>

        <div class="sm-field">
          <label>学年 <span class="sm-req">必須</span></label>
          <select name="grade">
            <option value="">選択してください</option>
            <?php
            foreach ( [ '小学3年生', '小学4年生', '小学5年生', '小学6年生', '中学1年生', '中学2年生', '中学3年生' ] as $g ) :
            ?>
            <option value="<?php echo esc_attr( $g ); ?>" <?php selected( $vals['grade'] ?? '', $g ); ?>><?php echo esc_html( $g ); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="sm-row">
          <div class="sm-field">
            <label>お子さまの性別 <span class="sm-req">必須</span></label>
            <select name="gender">
              <option value="">選択してください</option>
              <option value="男の子" <?php selected( $vals['gender'] ?? '', '男の子' ); ?>>男の子</option>
              <option value="女の子" <?php selected( $vals['gender'] ?? '', '女の子' ); ?>>女の子</option>
              <option value="回答しない" <?php selected( $vals['gender'] ?? '', '回答しない' ); ?>>回答しない</option>
            </select>
          </div>
          <div class="sm-field">
            <label>通学中の学校名 <span class="sm-opt">できるだけご記入ください</span></label>
            <input type="text" name="school" value="<?php echo esc_attr( $vals['school'] ?? '' ); ?>" placeholder="例：○○小学校 / ○○中学校">
          </div>
        </div>

        <div class="sm-field">
          <label>希望コース <span class="sm-req">必須</span></label>
          <div class="sm-course-radio">
            <?php foreach ( $course_options as $cid => $clabel ) :
              $full = $courses[ $cid ]['left'] <= 0;
            ?>
            <label class="<?php echo $full ? 'disabled' : ''; ?>">
              <input type="radio" name="course" value="<?php echo esc_attr( $cid ); ?>"
                <?php echo $full ? 'disabled' : ''; ?>
                <?php checked( $vals['course'] ?? $default_tab, $cid ); ?>>
              <span><?php echo esc_html( $clabel ); ?></span>
              <?php if ( $full ) : ?><span class="full-tag">満席・ありがとうございました</span><?php endif; ?>
            </label>
            <?php endforeach; ?>
          </div>
          <div class="sm-prog-plans" id="progPlans">
            <?php foreach ( $prog_plans as $plan ) : ?>
            <label class="sm-course-radio" style="margin:0">
              <input type="radio" name="prog_plan" value="<?php echo esc_attr( $plan ); ?>"
                <?php checked( $vals['prog_plan'] ?? '', $plan ); ?>>
              <span><?php echo esc_html( $plan ); ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="sm-field">
          <label>ご希望のご連絡方法 <span class="sm-req">必須</span></label>
          <select name="contact_preference">
            <option value="">選択してください</option>
            <option value="電話" <?php selected( $vals['contact_preference'] ?? '', '電話' ); ?>>電話</option>
            <option value="メール" <?php selected( $vals['contact_preference'] ?? '', 'メール' ); ?>>メール</option>
          </select>
        </div>

        <div class="sm-row">
          <div class="sm-field">
            <label>電話番号 <span class="sm-opt">電話希望時必須</span></label>
            <input type="tel" name="phone" value="<?php echo esc_attr( $vals['phone'] ?? '' ); ?>" placeholder="例：090-0000-0000">
          </div>
          <div class="sm-field">
            <label>メールアドレス <span class="sm-req">必須</span></label>
            <input type="email" name="email" value="<?php echo esc_attr( $vals['email'] ?? '' ); ?>" placeholder="例：example@gmail.com">
          </div>
        </div>

        <div class="sm-field">
          <label class="sm-check-wrap">
            <input type="checkbox" name="consult" value="1" <?php checked( ( $vals['consult'] ?? '' ) === '希望する' ); ?>>
            <span class="sm-check-label">
              夏期講習の事前相談を希望する
              <small>コース選びや通塾スケジュールなど、申込前にご相談いただけます</small>
            </span>
          </label>
          <label class="sm-check-wrap">
            <input type="checkbox" name="trial" value="1" <?php checked( ( $vals['trial'] ?? '' ) === '希望する' ); ?>>
            <span class="sm-check-label">
              夏期講習の無料体験を希望する
              <small>夏期講習の体験は1回のみ無料です（通年コースの体験とは異なります）</small>
            </span>
          </label>
        </div>

        <div class="sm-field">
          <label>ご質問・備考 <span class="sm-opt">任意</span></label>
          <textarea name="message" placeholder="通塾希望日時やご質問など"><?php echo esc_textarea( $vals['message'] ?? '' ); ?></textarea>
        </div>

        <button type="submit" class="sm-submit">📨 夏期講習に申し込む</button>
        <p class="sm-caution">
          ※ 夏期講習のみのお申し込みに<strong>入塾金はかかりません</strong>。<br>
          ※ 夏期講習の無料体験は<strong>1回のみ</strong>です。<br>
          ※ 送信後に自動返信メールが届きます。届かない場合は迷惑メールフォルダをご確認ください。<br>
          ※ しつこい勧誘はございません。相談だけでも歓迎です。
        </p>
      </form>
    <?php endif; ?>
  </div>

  <div class="sm-footer">
    📞 03-6770-6936 ｜ 📷 @furukijuku<br>
    📍 <?php echo esc_html( $summer['place'] ); ?>
  </div>

</main>

<script>
(function(){
  var tabs = document.querySelectorAll('.sm-tab');
  var panels = document.querySelectorAll('.sm-panel');
  tabs.forEach(function(tab){
    tab.addEventListener('click', function(){
      var id = tab.getAttribute('data-tab');
      tabs.forEach(function(t){ t.classList.remove('active'); });
      panels.forEach(function(p){ p.classList.remove('active'); });
      tab.classList.add('active');
      var panel = document.getElementById('panel-' + id);
      if (panel) panel.classList.add('active');
    });
  });

  function toggleProgPlans(){
    var checked = document.querySelector('input[name="course"]:checked');
    var box = document.getElementById('progPlans');
    if (!box) return;
    box.classList.toggle('show', checked && checked.value === 'programming');
  }
  document.querySelectorAll('input[name="course"]').forEach(function(r){
    r.addEventListener('change', toggleProgPlans);
  });
  toggleProgPlans();
})();
</script>
<?php wp_footer(); ?>
</body>
</html>
