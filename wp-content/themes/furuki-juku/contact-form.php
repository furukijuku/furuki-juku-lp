<?php
/**
 * Template Name: お問い合わせフォーム
 * Description: Furuki塾 お問い合わせ・無料体験申し込みフォーム
 */

define('FURUKI_MAIL_1', 'furuki.jyuku@gmail.com');
define('FURUKI_MAIL_2', 'furusawa@furuki-juku.com');

require_once get_template_directory() . '/inc/spam-guard.php';

$trial_options = [
	'same_day'      => '無料体験と無料相談を同時に行う',
	'consult_first' => '来塾での無料相談後、無料体験を検討',
];

$errors      = [];
$mail_error  = '';
$success     = false;
$vals        = [];

// 送信成功後は PRG で遷移（スクロール位置が残り成功表示が画面外になるのを防ぐ）
if ( isset( $_GET['thanks'] ) && (string) $_GET['thanks'] === '1' ) {
	$success = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nonce検証
    if (!isset($_POST['_furuki_nonce']) || !wp_verify_nonce($_POST['_furuki_nonce'], 'furuki_contact')) {
        $errors[] = '不正なリクエストです。もう一度お試しください。';
    } else {
        // ハニーポット（スパム対策）
        if (!empty($_POST['website'])) {
            $errors[] = '不正なリクエストです。';
        } else {
            // 値の取得・サニタイズ
            // POST キーは child_name（「name=」は本番 WAF で 404 になるため）
            $vals['name']    = sanitize_text_field($_POST['child_name'] ?? '');
            $vals['furigana'] = sanitize_text_field($_POST['furigana'] ?? '');
            $vals['gender']  = sanitize_text_field($_POST['gender']  ?? '');
            $vals['grade']   = sanitize_text_field($_POST['grade']   ?? '');
            $vals['school']  = sanitize_text_field($_POST['school']  ?? '');
            $vals['phone']   = sanitize_text_field($_POST['phone']   ?? '');
            $vals['email']   = sanitize_email($_POST['email']        ?? '');
            $vals['contact_preference'] = sanitize_text_field($_POST['contact_preference'] ?? '');
            $vals['trial']   = sanitize_text_field($_POST['trial'] ?? '');
            $vals['message'] = sanitize_textarea_field($_POST['message'] ?? '');

            // バリデーション
            if (empty($vals['name']))     $errors[] = 'お名前を入力してください。';
            if (empty($vals['furigana'])) $errors[] = 'ふりがなを入力してください。';
            if (empty($vals['gender']))   $errors[] = 'お子さまの性別を選択してください。';
            if (empty($vals['grade']))    $errors[] = '学年を選択してください。';
            if (empty($vals['email']))    $errors[] = 'メールアドレスを入力してください。';
            elseif (!is_email($vals['email'])) $errors[] = 'メールアドレスの形式が正しくありません。';
            if (empty($vals['message']))  $errors[] = 'お問い合わせ内容を入力してください。';
            if (empty($vals['contact_preference'])) {
                $errors[] = 'ご希望のご連絡方法を選択してください。';
            } elseif (!in_array($vals['contact_preference'], ['電話', 'メール'], true)) {
                $errors[] = 'ご希望のご連絡方法の選択が正しくありません。';
            } elseif ($vals['contact_preference'] === '電話' && empty($vals['phone'])) {
                $errors[] = '電話連絡希望の方は、お電話番号を入力してください。';
            }
            if (empty($vals['trial']) || !isset($trial_options[$vals['trial']])) {
                $errors[] = '無料体験・相談のご希望を選択してください。';
            }

            // 共通スパム対策チェック
            $spam_errors = furuki_spam_check( $_POST, $vals );
            $errors = array_merge( $errors, $spam_errors );

            if (empty($errors)) {
                $trial_label = $trial_options[$vals['trial']];

                // 塾宛メール本文
                $body = "Furuki塾 お問い合わせフォームより送信がありました。\n";
                $body .= str_repeat('-', 40) . "\n";
                $body .= "【お名前】　　　{$vals['name']}\n";
                $body .= "【ふりがな】　　{$vals['furigana']}\n";
                $body .= "【性別】　　　　{$vals['gender']}\n";
                $body .= "【学年】　　　　{$vals['grade']}\n";
                $body .= "【通学校】　　　" . (empty($vals['school']) ? '（未記入）' : $vals['school']) . "\n";
                $body .= "【電話番号】　　" . (empty($vals['phone']) ? '（未記入）' : $vals['phone']) . "\n";
                $body .= "【メール】　　　{$vals['email']}\n";
                $body .= "【ご希望の連絡方法】{$vals['contact_preference']}\n";
                $body .= "【体験・相談】　{$trial_label}\n";
                $body .= str_repeat('-', 40) . "\n";
                $body .= "【お問い合わせ内容】\n{$vals['message']}\n";
                $body .= str_repeat('-', 40) . "\n";
                $body .= "\n※ このメールはFuruki塾LPから自動送信されました。";

                $from_addr = ( defined( 'FURUKI_MAIL_FROM' ) && FURUKI_MAIL_FROM ) ? FURUKI_MAIL_FROM : FURUKI_MAIL_2;
                $headers   = [
                    'Content-Type: text/plain; charset=UTF-8',
                    'From: Furuki塾 <' . $from_addr . '>',
                    'Reply-To: ' . $vals['email'],
                ];

                $subject = "【Furuki塾】お問い合わせ：{$vals['name']} 様";

                // 宛先を分けて送信（環境によって複数 To が失敗することがある）
                $sent_a = wp_mail( FURUKI_MAIL_1, $subject, $body, $headers );
                $sent_b = wp_mail( FURUKI_MAIL_2, $subject, $body, $headers );
                $sent   = $sent_a && $sent_b;

                if ( $sent ) {
                    // 自動返信は塾宛が届いてから（届いていないのに受付済みと出さない）
                    $auto_body  = "{$vals['name']} 様\n\n";
                    $auto_body .= "Furuki塾へのお問い合わせありがとうございます。\n";
                    $auto_body .= "以下の内容でお問い合わせを受け付けました。\n";
                    $auto_body .= "担当より2〜3営業日以内にご連絡いたします。\n\n";
                    $auto_body .= str_repeat('-', 40) . "\n";
                    $auto_body .= "【お名前】　　　{$vals['name']}（{$vals['furigana']}）\n";
                    $auto_body .= "【性別】　　　　{$vals['gender']}\n";
                    $auto_body .= "【学年】　　　　{$vals['grade']}\n";
                    $auto_body .= "【体験・相談】　{$trial_label}\n";
                    $auto_body .= "【ご希望の連絡方法】{$vals['contact_preference']}\n";
                    $auto_body .= "【お問い合わせ内容】\n{$vals['message']}\n";
                    $auto_body .= str_repeat('-', 40) . "\n\n";
                    $auto_body .= "──────────────────────\n";
                    $auto_body .= "Furuki塾 江東住吉教室\n";
                    $auto_body .= "〒135-0013 東京都江東区千田11-13 丸万マンダリンハイム1F\n";
                    $auto_body .= "TEL: 03-6770-6936\n";
                    $auto_body .= "平日 15:00〜21:30（土日祝休み）\n";
                    $auto_body .= "LINE: https://lin.ee/7NV1Pld\n";
                    $auto_body .= "──────────────────────\n";

                    $auto_headers = [
                        'Content-Type: text/plain; charset=UTF-8',
                        'From: Furuki塾 <' . $from_addr . '>',
                    ];

                    wp_mail( $vals['email'], '【Furuki塾】お問い合わせを受け付けました', $auto_body, $auto_headers );

                    nocache_headers();
                    wp_safe_redirect( add_query_arg( 'thanks', '1', get_permalink() ), 303 );
                    exit;
                }

                $mail_error = 'メールの送信に失敗しました。お手数ですが、お電話またはLINEにてご連絡ください。';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>お問い合わせ・無料体験申し込み | Furuki塾</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;600;700;900&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --orange:      #f97316;
  --orange-dark: #c2410c;
  --orange-light:#fff7ed;
  --text:        #1c1917;
  --text-light:  #78716c;
  --border:      #e7e5e4;
  --radius:      12px;
  --line-green:  #06c755;
}

body {
  font-family: 'Noto Sans JP', 'Hiragino Kaku Gothic ProN', sans-serif;
  background: #fafaf9;
  color: var(--text);
  line-height: 1.7;
  min-height: 100vh;
}

/* ナビ */
.cf-nav {
  background: rgba(255,251,245,.97);
  border-bottom: 1px solid var(--border);
  padding: 0 24px;
  height: 60px;
  display: flex; align-items: center; justify-content: space-between;
  position: sticky; top: 0; z-index: 100;
}
.cf-nav-logo { font-size: 18px; font-weight: 900; color: var(--orange); text-decoration: none; }
.cf-nav-back { font-size: 13px; color: var(--text-light); text-decoration: none; display: flex; align-items: center; gap: 4px; }
.cf-nav-back:hover { color: var(--orange); }

/* メインレイアウト */
.cf-wrap {
  max-width: 680px; margin: 0 auto; padding: 48px 20px 80px;
}

/* ヘッダー */
.cf-header { text-align: center; margin-bottom: 40px; }
.cf-label {
  display: inline-block; font-size: 11px; font-weight: 700;
  letter-spacing: .12em; text-transform: uppercase;
  color: var(--orange); background: var(--orange-light);
  padding: 4px 14px; border-radius: 20px; margin-bottom: 12px;
}
.cf-title { font-size: 28px; font-weight: 900; line-height: 1.3; margin-bottom: 10px; }
.cf-title em { color: var(--orange); font-style: normal; }
.cf-subtitle { font-size: 14px; color: var(--text-light); }

/* LINE誘導バナー */
.cf-line-banner {
  display: flex; align-items: center; gap: 14px;
  background: #f0fff8; border: 2px solid #06c755;
  border-radius: var(--radius); padding: 16px 20px; margin-bottom: 32px;
  text-decoration: none; color: var(--text); transition: opacity .15s;
}
.cf-line-banner:hover { opacity: .85; }
.cf-line-icon { font-size: 32px; flex-shrink: 0; }
.cf-line-text strong { display: block; font-size: 15px; font-weight: 700; color: #00a63e; }
.cf-line-text span { font-size: 12px; color: var(--text-light); }
.cf-line-arrow { margin-left: auto; font-size: 18px; color: #06c755; }

.cf-divider { text-align: center; font-size: 12px; color: var(--text-light); margin: 20px 0; position: relative; }
.cf-divider::before, .cf-divider::after {
  content: ''; display: inline-block; width: 80px; height: 1px;
  background: var(--border); vertical-align: middle; margin: 0 12px;
}

/* フォームカード */
.cf-card {
  background: #fff; border-radius: var(--radius);
  box-shadow: 0 2px 16px rgba(0,0,0,.07); padding: 32px 28px;
}

/* アラート */
.cf-alert {
  border-radius: 8px; padding: 14px 16px; margin-bottom: 24px; font-size: 14px;
}
.cf-alert-error { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
.cf-alert-success { background: #f0fdf4; border: 1px solid #86efac; color: #166534; }
.cf-alert ul { padding-left: 18px; margin-top: 6px; }
.cf-alert-success .cf-check { font-size: 32px; margin-bottom: 8px; }
.cf-alert-success strong { font-size: 16px; display: block; margin-bottom: 6px; }

/* フォームフィールド */
.cf-field { margin-bottom: 20px; }
.cf-field label {
  display: flex; align-items: center; gap: 6px;
  font-size: 13px; font-weight: 700; margin-bottom: 6px;
}
.cf-required {
  font-size: 10px; font-weight: 700; color: #fff;
  background: var(--orange); padding: 2px 6px; border-radius: 3px;
}
.cf-optional {
  font-size: 10px; color: var(--text-light); background: var(--border);
  padding: 2px 6px; border-radius: 3px;
}
.cf-field input[type="text"],
.cf-field input[type="email"],
.cf-field input[type="tel"],
.cf-field select,
.cf-field textarea {
  width: 100%; padding: 12px 14px;
  border: 1.5px solid var(--border); border-radius: 8px;
  font-size: 15px; font-family: inherit; color: var(--text);
  background: #fafaf9; transition: border-color .15s, box-shadow .15s;
  appearance: none;
}
.cf-field input:focus,
.cf-field select:focus,
.cf-field textarea:focus {
  outline: none; border-color: var(--orange);
  box-shadow: 0 0 0 3px rgba(249,115,22,.12);
  background: #fff;
}
.cf-field select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%2378716c' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 14px center;
  padding-right: 36px;
}
.cf-field textarea { resize: vertical; min-height: 130px; }

/* 体験・相談の選択肢 */
.cf-choice-group {
  display: flex; flex-direction: column; gap: 8px;
}
.cf-choice-wrap {
  display: flex; align-items: flex-start; gap: 10px;
  background: var(--orange-light); border-radius: 8px; padding: 14px 16px; cursor: pointer;
  border: 2px solid transparent; transition: border-color .15s, background .15s;
}
.cf-choice-wrap:has(input:checked) {
  border-color: var(--orange); background: #fff7ed;
}
.cf-choice-wrap input[type="radio"] {
  width: 20px; height: 20px; flex-shrink: 0; margin-top: 2px;
  accent-color: var(--orange); cursor: pointer;
}
.cf-choice-label { font-size: 14px; font-weight: 600; color: var(--text); line-height: 1.5; }
.cf-choice-note { font-size: 12px; color: var(--text-light); margin-top: 8px; line-height: 1.6; }

/* 送信ボタン */
.cf-submit {
  width: 100%; padding: 16px;
  background: var(--orange); color: #fff;
  font-size: 16px; font-weight: 700; font-family: inherit;
  border: none; border-radius: 30px; cursor: pointer;
  transition: background .2s, transform .1s; margin-top: 8px;
  display: flex; align-items: center; justify-content: center; gap: 8px;
}
.cf-submit:hover { background: var(--orange-dark); }
.cf-submit:active { transform: scale(.98); }

.cf-note { font-size: 12px; color: var(--text-light); text-align: center; margin-top: 12px; }

/* ハニーポット非表示 */
.cf-hp { position: absolute; left: -9999px; opacity: 0; height: 0; }

/* 成功後の誘導 */
.cf-after-success { text-align: center; margin-top: 28px; }
.cf-after-success a {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--line-green); color: #fff;
  padding: 12px 24px; border-radius: 30px;
  font-size: 14px; font-weight: 700; text-decoration: none; transition: opacity .15s;
}
.cf-after-success a:hover { opacity: .85; }
.cf-back-link { margin-top: 16px; }
.cf-back-link a { font-size: 13px; color: var(--text-light); text-decoration: none; }
.cf-back-link a:hover { color: var(--orange); }

.cf-submit:disabled { opacity: .65; cursor: wait; transform: none; }
</style>
</head>
<body>

<nav class="cf-nav">
  <a href="<?php echo home_url('/'); ?>" class="cf-nav-logo">Furuki塾</a>
  <a href="<?php echo home_url('/'); ?>" class="cf-nav-back">← トップに戻る</a>
</nav>

<main class="cf-wrap">

  <div class="cf-header">
    <div class="cf-label">Contact</div>
    <h1 class="cf-title">お問い合わせ・<em>無料体験</em>申し込み</h1>
    <p class="cf-subtitle">しつこい勧誘は一切ありません。お気軽にどうぞ。</p>
  </div>

  <!-- LINE誘導 -->
  <a href="https://lin.ee/7NV1Pld" target="_blank" rel="noopener" class="cf-line-banner">
    <div class="cf-line-icon">💬</div>
    <div class="cf-line-text">
      <strong>LINEで相談する（すぐ返信）</strong>
      <span>かんたん・気軽にメッセージを送れます</span>
    </div>
    <div class="cf-line-arrow">›</div>
  </a>

  <div class="cf-divider">またはフォームでお問い合わせ</div>

  <!-- 営業・スパム抑止 -->
  <div style="background:#fafaf9;border:1px solid #e7e5e4;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:12px;color:#78716c;line-height:1.7;">
    ⚠️ 本フォームは<strong style="color:#1c1917;">保護者・生徒の方専用</strong>です。<br>
    営業・勧誘・広告・SEO・システム販売など、業者様からのお問い合わせはご遠慮ください。<br>
    該当するお問い合わせには返信いたしません。
  </div>

  <div class="cf-card">

    <?php if ($success): ?>
      <div id="cf-result" class="cf-alert cf-alert-success" tabindex="-1">
        <div class="cf-check">✅</div>
        <strong>お問い合わせを受け付けました</strong>
        ご入力いただいたメールアドレスに自動返信メールをお送りしました。
        担当より2〜3営業日以内にご連絡いたします。
      </div>
      <div class="cf-after-success">
        <a href="https://lin.ee/7NV1Pld" target="_blank" rel="noopener">
          💬 LINEで追加の質問をする
        </a>
        <div class="cf-back-link">
          <a href="<?php echo home_url('/'); ?>">← トップページに戻る</a>
        </div>
      </div>

    <?php else: ?>

      <?php if ( ! empty( $errors ) || $mail_error ) : ?>
        <div id="cf-result" tabindex="-1">
          <?php if ( ! empty( $errors ) ) : ?>
            <div class="cf-alert cf-alert-error">
              <strong>入力内容をご確認ください</strong>
              <ul>
                <?php foreach ( $errors as $e ) : ?>
                  <li><?php echo esc_html( $e ); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
          <?php if ( $mail_error ) : ?>
            <div class="cf-alert cf-alert-error" style="<?php echo ! empty( $errors ) ? 'margin-top:16px;' : ''; ?>">
              <strong>メールを送信できませんでした</strong>
              <p style="margin:8px 0 0;padding:0;"><?php echo esc_html( $mail_error ); ?></p>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <form method="post" action="" novalidate onsubmit="var b=this.querySelector('.cf-submit');if(b){b.disabled=true;b.innerHTML='送信中…';}">
        <?php wp_nonce_field('furuki_contact', '_furuki_nonce'); ?>
        <?php furuki_spam_fields(); ?>

        <!-- ハニーポット -->
        <div class="cf-hp">
          <input type="text" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="cf-field">
          <label for="child_name">お子さまのお名前 <span class="cf-required">必須</span></label>
          <input type="text" id="child_name" name="child_name"
            value="<?php echo esc_attr($vals['name'] ?? ''); ?>"
            placeholder="例：山田 太郎" autocomplete="name">
        </div>

        <div class="cf-field">
          <label for="furigana">ふりがな <span class="cf-required">必須</span></label>
          <input type="text" id="furigana" name="furigana"
            value="<?php echo esc_attr($vals['furigana'] ?? ''); ?>"
            placeholder="例：やまだ たろう">
        </div>

        <div class="cf-field">
          <label for="gender">お子さまの性別 <span class="cf-required">必須</span></label>
          <select id="gender" name="gender">
            <option value="">選択してください</option>
            <option value="男の子" <?php selected(($vals['gender'] ?? ''), '男の子'); ?>>男の子</option>
            <option value="女の子" <?php selected(($vals['gender'] ?? ''), '女の子'); ?>>女の子</option>
            <option value="回答しない" <?php selected(($vals['gender'] ?? ''), '回答しない'); ?>>回答しない</option>
          </select>
        </div>

        <div class="cf-field">
          <label for="grade">お子さまの学年 <span class="cf-required">必須</span></label>
          <select id="grade" name="grade">
            <option value="">選択してください</option>
            <optgroup label="小学生">
              <option value="小学1年生" <?php selected(($vals['grade'] ?? ''), '小学1年生'); ?>>小学1年生</option>
              <option value="小学2年生" <?php selected(($vals['grade'] ?? ''), '小学2年生'); ?>>小学2年生</option>
              <option value="小学3年生" <?php selected(($vals['grade'] ?? ''), '小学3年生'); ?>>小学3年生</option>
              <option value="小学4年生" <?php selected(($vals['grade'] ?? ''), '小学4年生'); ?>>小学4年生</option>
              <option value="小学5年生" <?php selected(($vals['grade'] ?? ''), '小学5年生'); ?>>小学5年生</option>
              <option value="小学6年生" <?php selected(($vals['grade'] ?? ''), '小学6年生'); ?>>小学6年生</option>
            </optgroup>
            <optgroup label="中学生">
              <option value="中学1年生" <?php selected(($vals['grade'] ?? ''), '中学1年生'); ?>>中学1年生</option>
              <option value="中学2年生" <?php selected(($vals['grade'] ?? ''), '中学2年生'); ?>>中学2年生</option>
              <option value="中学3年生" <?php selected(($vals['grade'] ?? ''), '中学3年生'); ?>>中学3年生</option>
            </optgroup>
            <optgroup label="その他">
              <option value="高校生（継続）" <?php selected(($vals['grade'] ?? ''), '高校生（継続）'); ?>>高校生（継続通塾）</option>
              <option value="未定・検討中" <?php selected(($vals['grade'] ?? ''), '未定・検討中'); ?>>未定・検討中</option>
            </optgroup>
          </select>
        </div>

        <div class="cf-field">
          <label for="school">通学中の学校名 <span class="cf-optional">任意</span></label>
          <input type="text" id="school" name="school"
            value="<?php echo esc_attr($vals['school'] ?? ''); ?>"
            placeholder="例：江東区立深川第四中学校">
        </div>

        <div class="cf-field">
          <label for="phone">お電話番号 <span class="cf-optional">任意</span></label>
          <input type="tel" id="phone" name="phone"
            value="<?php echo esc_attr($vals['phone'] ?? ''); ?>"
            placeholder="例：03-6770-0000" autocomplete="tel">
        </div>

        <div class="cf-field">
          <label for="email">メールアドレス <span class="cf-required">必須</span></label>
          <input type="email" id="email" name="email"
            value="<?php echo esc_attr($vals['email'] ?? ''); ?>"
            placeholder="例：example@gmail.com" autocomplete="email">
        </div>

        <div class="cf-field">
          <label for="contact_preference">ご希望のご連絡方法 <span class="cf-required">必須</span></label>
          <select id="contact_preference" name="contact_preference">
            <option value="">選択してください</option>
            <option value="電話" <?php selected(($vals['contact_preference'] ?? ''), '電話'); ?>>電話での連絡を希望</option>
            <option value="メール" <?php selected(($vals['contact_preference'] ?? ''), 'メール'); ?>>メールでの連絡を希望</option>
          </select>
        </div>

        <div class="cf-field">
          <label>無料体験・相談のご希望 <span class="cf-required">必須</span></label>
          <div class="cf-choice-group">
            <?php foreach ($trial_options as $trial_key => $trial_text) : ?>
            <label class="cf-choice-wrap">
              <input type="radio" name="trial" value="<?php echo esc_attr($trial_key); ?>"
                <?php checked(($vals['trial'] ?? ''), $trial_key); ?>>
              <span class="cf-choice-label"><?php echo esc_html($trial_text); ?></span>
            </label>
            <?php endforeach; ?>
          </div>
          <p class="cf-choice-note">無料体験は初回含め2週間・最大3回までです。しつこい勧誘はございません。</p>
        </div>

        <div class="cf-field">
          <label for="message">お問い合わせ内容 <span class="cf-required">必須</span></label>
          <textarea id="message" name="message"
            placeholder="例：中学2年生の子どもの数学が苦手で困っています。無料体験の日程について相談したいです。"><?php echo esc_textarea($vals['message'] ?? ''); ?></textarea>
        </div>

        <button type="submit" class="cf-submit">
          📨 送信する
        </button>
        <p class="cf-note">※ 自動返信メールが届かない場合は迷惑メールフォルダをご確認ください</p>
      </form>

    <?php endif; ?>

  </div><!-- /.cf-card -->

  <!-- TEL -->
  <div style="text-align:center;margin-top:28px;font-size:13px;color:var(--text-light);">
    お急ぎの場合はお電話でも受け付けています<br>
    <a href="tel:0367706936" style="font-size:20px;font-weight:900;color:var(--orange);text-decoration:none;">
      03-6770-6936
    </a><br>
    <small>受付時間：平日 15:00〜21:30（土日祝休み）</small>
  </div>

</main>

<?php wp_footer(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var el = document.getElementById('cf-result');
  if (el) {
    el.focus({ preventScroll: true });
    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
});
</script>
</body>
</html>
