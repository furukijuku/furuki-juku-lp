<?php
/**
 * Template Name: イベント申し込みページ
 * Description: Furuki塾 イベント・体験会 申し込みページ（使い回しテンプレート）
 */

/* ============================================================
   ★ イベント設定（次回以降はここだけ書き換える）
============================================================ */
$event = [
  'title'       => 'Robloxでプログラミングを学びながらゲームを作ろう！',
  'subtitle'    => '親子プログラミング体験会',
  'emoji'       => '🎮',
  'date_str'    => '2026年5月9日（土）',
  'place'       => 'Furuki塾 江東住吉教室（東京都江東区千田11-13 丸万マンダリンハイム1F）',
  'target'      => '小学3年生〜中学3年生とその保護者',
  'fee'         => '無料',
  'description' => '大人気ゲーム「Roblox（ロブロックス）」を使って、プログラミングの基礎を楽しく体験できるイベントです。難しいコードは不要！ブロックを組み合わせる感覚でゲームを作りながら、「プログラミングってこういうことか！」を体で感じてもらえます。お子さんと一緒に、未来の力を体験しに来てください。',

  // ★ 時間帯ごとの定員管理（満席は left => 0 にする）
  'slots' => [
    ['time' => '10:00〜11:00', 'left' => 3],
    ['time' => '13:00〜14:00', 'left' => 3],
    ['time' => '15:00〜16:00', 'left' => 3],
  ],

  // FAQ
  'faq' => [
    ['q' => 'パソコンや機材は必要ですか？', 'a' => 'いいえ、不要です。塾のパソコンを使用します。お子さんはお手ぶらでお越しください。'],
    ['q' => 'プログラミング経験がなくても大丈夫ですか？', 'a' => 'まったく問題ありません。初めての方を対象にしたイベントです。難しい知識は一切必要ありません。'],
    ['q' => '保護者も一緒に参加できますか？', 'a' => 'ぜひご一緒にどうぞ。親子で体験していただくことを想定しています。'],
    ['q' => 'キャンセルしたい場合はどうすればいいですか？', 'a' => 'LINEまたはお電話（03-6770-6936）にてご連絡ください。他の方に席を譲るため、なるべくお早めにご連絡いただけると助かります。'],
    ['q' => '体験会後に入塾を勧誘されますか？', 'a' => 'しつこい勧誘は一切行いません。興味を持っていただいた場合のみ、ご希望に応じてご案内します。'],
  ],
];

require_once get_template_directory() . '/inc/spam-guard.php';

/* ============================================================
   フォーム処理
============================================================ */
$errors  = [];
$success = false;
$vals    = [];

// 満席スロットのチェック用
$available_slots = array_filter($event['slots'], fn($s) => $s['left'] > 0);
$all_full        = empty($available_slots);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['_ev_nonce']) || !wp_verify_nonce($_POST['_ev_nonce'], 'furuki_event')) {
    $errors[] = '不正なリクエストです。';
  } elseif (!empty($_POST['website'])) {
    $errors[] = '不正なリクエストです。';
  } else {
    $vals['child_name']   = sanitize_text_field($_POST['child_name']   ?? '');
    $vals['child_kana']   = sanitize_text_field($_POST['child_kana']   ?? '');
    $vals['grade']        = sanitize_text_field($_POST['grade']        ?? '');
    $vals['parent_name']  = sanitize_text_field($_POST['parent_name']  ?? '');
    $vals['phone']        = sanitize_text_field($_POST['phone']        ?? '');
    $vals['email']        = sanitize_email($_POST['email']             ?? '');
    $vals['slot']         = sanitize_text_field($_POST['slot']         ?? '');
    $vals['attendees']    = sanitize_text_field($_POST['attendees']    ?? '');
    $vals['message']      = sanitize_textarea_field($_POST['message']  ?? '');

    if (empty($vals['child_name']))  $errors[] = 'お子さまのお名前を入力してください。';
    if (empty($vals['child_kana']))  $errors[] = 'ふりがなを入力してください。';
    if (empty($vals['grade']))       $errors[] = '学年を選択してください。';
    if (empty($vals['parent_name'])) $errors[] = '保護者のお名前を入力してください。';
    if (empty($vals['phone']))       $errors[] = '電話番号を入力してください。';
    if (empty($vals['email']))       $errors[] = 'メールアドレスを入力してください。';
    elseif (!is_email($vals['email'])) $errors[] = 'メールアドレスの形式が正しくありません。';
    if (empty($vals['slot']))        $errors[] = '希望の時間帯を選択してください。';
    if (empty($vals['attendees']))   $errors[] = '参加人数を入力してください。';

    // 共通スパム対策チェック
    $spam_vals = [
      'name'     => $vals['child_name'],
      'furigana' => $vals['child_kana'],
      'phone'    => $vals['phone'],
      'email'    => $vals['email'],
      'message'  => $vals['message'],
    ];
    $spam_errors = furuki_spam_check( $_POST, $spam_vals );
    $errors = array_merge( $errors, $spam_errors );

    if (empty($errors)) {
      $subject = "【Furuki塾イベント】申し込み：{$vals['child_name']} 様";
      $body  = "イベント申し込みが届きました。\n";
      $body .= "━━━━━━━━━━━━━━━━━━━━━━━\n";
      $body .= "【イベント】{$event['title']}\n";
      $body .= "【日程】　　{$event['date_str']}\n";
      $body .= "━━━━━━━━━━━━━━━━━━━━━━━\n";
      $body .= "【お子さまの名前】{$vals['child_name']}（{$vals['child_kana']}）\n";
      $body .= "【学年】　　　　　{$vals['grade']}\n";
      $body .= "【保護者名】　　　{$vals['parent_name']}\n";
      $body .= "【電話番号】　　　{$vals['phone']}\n";
      $body .= "【メール】　　　　{$vals['email']}\n";
      $body .= "【希望時間帯】　　{$vals['slot']}\n";
      $body .= "【参加人数】　　　{$vals['attendees']}\n";
      if (!empty($vals['message'])) $body .= "【備考】\n{$vals['message']}\n";
      $body .= "━━━━━━━━━━━━━━━━━━━━━━━\n";

      $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $vals['parent_name'] . ' <' . $vals['email'] . '>',
      ];
      wp_mail(['furuki.jyuku@gmail.com', 'furusawa@furuki-juku.com'], $subject, $body, $headers);

      // 自動返信
      $auto  = "{$vals['parent_name']} 様\n\n";
      $auto .= "以下の内容でイベントのお申し込みを受け付けました。\n";
      $auto .= "当日を楽しみにお待ちしています！\n\n";
      $auto .= "━━━━━━━━━━━━━━━━━━━━━━━\n";
      $auto .= "【イベント名】{$event['title']}\n";
      $auto .= "【日時】　　　{$event['date_str']} {$vals['slot']}\n";
      $auto .= "【場所】　　　{$event['place']}\n";
      $auto .= "【お子さま】　{$vals['child_name']} さん（{$vals['grade']}）\n";
      $auto .= "【参加人数】　{$vals['attendees']}\n";
      $auto .= "━━━━━━━━━━━━━━━━━━━━━━━\n\n";
      $auto .= "当日はお気軽にお越しください。\n";
      $auto .= "ご不明な点はLINEまたはお電話でお気軽にどうぞ。\n\n";
      $auto .= "Furuki塾 江東住吉教室\n";
      $auto .= "TEL: 03-6770-6936\n";
      $auto .= "LINE: https://lin.ee/7NV1Pld\n";
      $auto .= "平日 15:00〜21:30（土日祝休み）\n";

      $auto_headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: Furuki塾 <furusawa@furuki-juku.com>',
      ];
      wp_mail($vals['email'], "【Furuki塾】イベントお申し込みありがとうございます", $auto, $auto_headers);

      $success = true;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo esc_html($event['subtitle']); ?> | Furuki塾</title>
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
body { font-family: 'Noto Sans JP', sans-serif; background: #fafaf9; color: var(--text); line-height: 1.7; }

/* ナビ */
.ev-nav { background: rgba(255,251,245,.97); border-bottom: 1px solid var(--border); padding: 0 24px; height: 60px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
.ev-nav-logo { font-size: 18px; font-weight: 900; color: var(--orange); text-decoration: none; }
.ev-nav-back { font-size: 13px; color: var(--text-light); text-decoration: none; }
.ev-nav-back:hover { color: var(--orange); }

/* ヒーロー */
.ev-hero { background: linear-gradient(135deg, #1c1917 0%, #292524 100%); color: #fff; padding: 56px 20px 48px; text-align: center; }
.ev-hero-emoji { font-size: 56px; margin-bottom: 16px; }
.ev-hero-sub { display: inline-block; font-size: 12px; font-weight: 700; letter-spacing: .12em; color: var(--orange); background: rgba(249,115,22,.15); padding: 4px 14px; border-radius: 20px; margin-bottom: 14px; }
.ev-hero-title { font-size: clamp(18px, 4vw, 28px); font-weight: 900; line-height: 1.4; margin-bottom: 16px; }
.ev-hero-title em { color: var(--orange); font-style: normal; }
.ev-hero-meta { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-top: 20px; }
.ev-hero-badge { background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); border-radius: 8px; padding: 8px 16px; font-size: 13px; }
.ev-hero-badge strong { color: var(--orange); }

/* メイン */
.ev-wrap { max-width: 720px; margin: 0 auto; padding: 40px 20px 80px; }

/* カード */
.ev-card { background: #fff; border-radius: var(--radius); box-shadow: 0 2px 16px rgba(0,0,0,.07); padding: 28px; margin-bottom: 24px; }
.ev-card-title { font-size: 16px; font-weight: 900; color: var(--orange-dark); margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid var(--orange-light); }

/* 概要 */
.ev-info-list { display: flex; flex-direction: column; gap: 10px; }
.ev-info-row { display: flex; gap: 12px; font-size: 14px; }
.ev-info-label { font-size: 11px; font-weight: 700; color: var(--text-light); letter-spacing: .06em; text-transform: uppercase; min-width: 56px; padding-top: 2px; }
.ev-info-value { flex: 1; color: var(--text); }
.ev-description { font-size: 14px; color: var(--text-light); line-height: 1.8; margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border); }

/* 時間帯 */
.ev-slots { display: flex; flex-direction: column; gap: 10px; }
.ev-slot-item { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1.5px solid var(--border); border-radius: 8px; }
.ev-slot-time { font-size: 15px; font-weight: 700; }
.ev-slot-status { font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 10px; }
.ev-slot-status.ok     { background: #dcfce7; color: #166534; }
.ev-slot-status.warn   { background: #fff7ed; color: #c2410c; }
.ev-slot-status.urgent { background: #fef2f2; color: #991b1b; }
.ev-slot-status.full   { background: #f5f5f4; color: #78716c; }

/* FAQ */
.ev-faq-list { display: flex; flex-direction: column; gap: 0; }
.ev-faq-item { border-bottom: 1px solid var(--border); }
.ev-faq-item:last-child { border-bottom: none; }
.ev-faq-q { display: flex; gap: 10px; padding: 14px 4px; cursor: pointer; font-size: 14px; font-weight: 700; align-items: flex-start; }
.ev-faq-q-badge { background: var(--orange); color: #fff; font-size: 11px; font-weight: 900; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
.ev-faq-a { display: none; font-size: 13px; color: var(--text-light); padding: 0 4px 14px 30px; line-height: 1.8; }
.ev-faq-item.open .ev-faq-a { display: block; }
.ev-faq-chevron { margin-left: auto; color: var(--text-light); transition: transform .2s; flex-shrink: 0; }
.ev-faq-item.open .ev-faq-chevron { transform: rotate(180deg); }

/* フォーム */
.ev-field { margin-bottom: 18px; }
.ev-field label { display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 700; margin-bottom: 6px; }
.ev-required { font-size: 10px; font-weight: 700; color: #fff; background: var(--orange); padding: 2px 6px; border-radius: 3px; }
.ev-optional { font-size: 10px; color: var(--text-light); background: var(--border); padding: 2px 6px; border-radius: 3px; }
.ev-field input[type="text"],
.ev-field input[type="email"],
.ev-field input[type="tel"],
.ev-field select,
.ev-field textarea {
  width: 100%; padding: 11px 14px; border: 1.5px solid var(--border); border-radius: 8px;
  font-size: 15px; font-family: inherit; color: var(--text); background: #fafaf9;
  transition: border-color .15s, box-shadow .15s; appearance: none;
}
.ev-field input:focus, .ev-field select:focus, .ev-field textarea:focus {
  outline: none; border-color: var(--orange); box-shadow: 0 0 0 3px rgba(249,115,22,.12); background: #fff;
}
.ev-field select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%2378716c' d='M1 1l5 5 5-5'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; }
.ev-field textarea { min-height: 100px; resize: vertical; }
.ev-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

/* 時間帯選択ラジオ */
.ev-slot-radio-list { display: flex; flex-direction: column; gap: 8px; }
.ev-slot-radio { display: flex; align-items: center; gap: 10px; padding: 12px 14px; border: 1.5px solid var(--border); border-radius: 8px; cursor: pointer; transition: border-color .15s; }
.ev-slot-radio:has(input:checked) { border-color: var(--orange); background: var(--orange-light); }
.ev-slot-radio.disabled { opacity: .5; cursor: not-allowed; background: #f5f5f4; }
.ev-slot-radio input[type="radio"] { accent-color: var(--orange); width: 16px; height: 16px; flex-shrink: 0; }
.ev-slot-radio-time { font-size: 14px; font-weight: 700; flex: 1; }
.ev-slot-radio-left { font-size: 12px; font-weight: 700; padding: 2px 8px; border-radius: 8px; }
.ev-slot-radio-left.ok     { background: #dcfce7; color: #166534; }
.ev-slot-radio-left.warn   { background: #fff7ed; color: #c2410c; }
.ev-slot-radio-left.urgent { background: #fef2f2; color: #991b1b; }
.ev-slot-radio-left.full   { background: #f5f5f4; color: #78716c; }

/* ボタン */
.ev-submit { width: 100%; padding: 16px; background: var(--orange); color: #fff; font-size: 16px; font-weight: 700; font-family: inherit; border: none; border-radius: 30px; cursor: pointer; transition: background .2s; margin-top: 8px; }
.ev-submit:hover { background: var(--orange-dark); }
.ev-submit:disabled { background: #d6d3d1; cursor: not-allowed; }
.ev-caution { font-size: 12px; color: var(--text-light); margin-top: 10px; text-align: center; line-height: 1.7; }

/* アラート */
.ev-alert { border-radius: 8px; padding: 14px 16px; margin-bottom: 20px; font-size: 14px; }
.ev-alert-error   { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
.ev-alert-success { background: #f0fdf4; border: 1px solid #86efac; color: #166534; text-align: center; }
.ev-alert-error ul { padding-left: 18px; margin-top: 6px; }
.ev-success-icon { font-size: 40px; margin-bottom: 8px; }
.ev-success-title { font-size: 18px; font-weight: 900; margin-bottom: 8px; }

/* 満席バナー */
.ev-full-banner { background: #f5f5f4; border: 2px solid #d6d3d1; border-radius: var(--radius); padding: 24px; text-align: center; color: var(--text-light); }
.ev-full-banner strong { display: block; font-size: 18px; color: var(--text); margin-bottom: 8px; }

/* hidden */
.ev-hp { position: absolute; left: -9999px; opacity: 0; height: 0; }

@media(max-width: 480px) { .ev-field-row { grid-template-columns: 1fr; } }
</style>
</head>
<body>

<nav class="ev-nav">
  <a href="<?php echo home_url('/'); ?>" class="ev-nav-logo">Furuki塾</a>
  <a href="<?php echo home_url('/'); ?>" class="ev-nav-back">← トップに戻る</a>
</nav>

<!-- ヒーロー -->
<div class="ev-hero">
  <div class="ev-hero-emoji"><?php echo $event['emoji']; ?></div>
  <div class="ev-hero-sub"><?php echo esc_html($event['subtitle']); ?></div>
  <h1 class="ev-hero-title"><?php echo esc_html($event['title']); ?></h1>
  <div class="ev-hero-meta">
    <div class="ev-hero-badge">📅 <strong><?php echo esc_html($event['date_str']); ?></strong></div>
    <div class="ev-hero-badge">📍 江東区千田 Furuki塾</div>
    <div class="ev-hero-badge">💰 参加費 <strong>無料</strong></div>
    <div class="ev-hero-badge">👥 <?php echo esc_html($event['target']); ?></div>
  </div>
</div>

<main class="ev-wrap">

  <!-- 概要 -->
  <div class="ev-card">
    <div class="ev-card-title">📋 イベント概要</div>
    <div class="ev-info-list">
      <div class="ev-info-row"><span class="ev-info-label">日時</span><span class="ev-info-value"><?php echo esc_html($event['date_str']); ?></span></div>
      <div class="ev-info-row"><span class="ev-info-label">場所</span><span class="ev-info-value"><?php echo esc_html($event['place']); ?></span></div>
      <div class="ev-info-row"><span class="ev-info-label">対象</span><span class="ev-info-value"><?php echo esc_html($event['target']); ?></span></div>
      <div class="ev-info-row"><span class="ev-info-label">参加費</span><span class="ev-info-value"><strong style="color:var(--orange);"><?php echo esc_html($event['fee']); ?></strong></span></div>
    </div>
    <p class="ev-description"><?php echo esc_html($event['description']); ?></p>
  </div>

  <!-- 時間帯・残り枠 -->
  <div class="ev-card">
    <div class="ev-card-title">🕐 時間帯と残り枠</div>
    <div class="ev-slots">
      <?php foreach ($event['slots'] as $s):
        if ($s['left'] === 0)     { $sl = 'full';   $st = '満席'; }
        elseif ($s['left'] === 1) { $sl = 'urgent'; $st = '残り1席'; }
        elseif ($s['left'] <= 2)  { $sl = 'warn';   $st = '残りわずか'; }
        else                      { $sl = 'ok';     $st = '受付中'; }
      ?>
      <div class="ev-slot-item">
        <span class="ev-slot-time"><?php echo esc_html($s['time']); ?></span>
        <span class="ev-slot-status <?php echo $sl; ?>"><?php echo $st; ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- FAQ -->
  <div class="ev-card">
    <div class="ev-card-title">❓ よくある質問</div>
    <div class="ev-faq-list">
      <?php foreach ($event['faq'] as $faq): ?>
      <div class="ev-faq-item">
        <div class="ev-faq-q" onclick="this.closest('.ev-faq-item').classList.toggle('open')">
          <span class="ev-faq-q-badge">Q</span>
          <span><?php echo esc_html($faq['q']); ?></span>
          <span class="ev-faq-chevron">▼</span>
        </div>
        <div class="ev-faq-a"><?php echo esc_html($faq['a']); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- 申し込みフォーム -->
  <div class="ev-card" id="form">
    <div class="ev-card-title">✏️ 申し込みフォーム</div>

    <?php if ($success): ?>
      <div class="ev-alert ev-alert-success">
        <div class="ev-success-icon">✅</div>
        <div class="ev-success-title">お申し込みを受け付けました！</div>
        <p>ご入力のメールアドレスに確認メールをお送りしました。<br>当日を楽しみにしています。お気軽にお越しください。</p>
      </div>
      <p style="text-align:center;margin-top:16px;font-size:13px;color:var(--text-light);">
        <a href="<?php echo home_url('/'); ?>" style="color:var(--orange);">← トップページに戻る</a>
      </p>

    <?php elseif ($all_full): ?>
      <div class="ev-full-banner">
        <strong>🙇 申し訳ありません。全枠が満席となりました。</strong>
        次回のイベントはLINEまたはInstagramでお知らせします。ぜひフォローしてお待ちください。
      </div>

    <?php else: ?>
      <?php if (!empty($errors)): ?>
        <div class="ev-alert ev-alert-error">
          <strong>入力内容をご確認ください</strong>
          <ul><?php foreach ($errors as $e): ?><li><?php echo esc_html($e); ?></li><?php endforeach; ?></ul>
        </div>
      <?php endif; ?>

      <form method="post" action="#form" novalidate>
        <?php wp_nonce_field('furuki_event', '_ev_nonce'); ?>
        <?php furuki_spam_fields(); ?>
        <div class="ev-hp"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>

        <div class="ev-field-row">
          <div class="ev-field">
            <label>お子さまのお名前 <span class="ev-required">必須</span></label>
            <input type="text" name="child_name" value="<?php echo esc_attr($vals['child_name'] ?? ''); ?>" placeholder="例：山田 太郎">
          </div>
          <div class="ev-field">
            <label>ふりがな <span class="ev-required">必須</span></label>
            <input type="text" name="child_kana" value="<?php echo esc_attr($vals['child_kana'] ?? ''); ?>" placeholder="例：やまだ たろう">
          </div>
        </div>

        <div class="ev-field">
          <label>学年 <span class="ev-required">必須</span></label>
          <select name="grade">
            <option value="">選択してください</option>
            <?php foreach(['小学3年生','小学4年生','小学5年生','小学6年生','中学1年生','中学2年生','中学3年生'] as $g): ?>
            <option value="<?php echo $g; ?>" <?php selected(($vals['grade'] ?? ''), $g); ?>><?php echo $g; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="ev-field">
          <label>保護者のお名前 <span class="ev-required">必須</span></label>
          <input type="text" name="parent_name" value="<?php echo esc_attr($vals['parent_name'] ?? ''); ?>" placeholder="例：山田 花子">
        </div>

        <div class="ev-field-row">
          <div class="ev-field">
            <label>電話番号 <span class="ev-required">必須</span></label>
            <input type="tel" name="phone" value="<?php echo esc_attr($vals['phone'] ?? ''); ?>" placeholder="例：090-0000-0000">
          </div>
          <div class="ev-field">
            <label>メールアドレス <span class="ev-required">必須</span></label>
            <input type="email" name="email" value="<?php echo esc_attr($vals['email'] ?? ''); ?>" placeholder="例：example@gmail.com">
          </div>
        </div>

        <div class="ev-field">
          <label>希望の時間帯 <span class="ev-required">必須</span></label>
          <div class="ev-slot-radio-list">
            <?php foreach ($event['slots'] as $s):
              $is_full = $s['left'] === 0;
              if ($is_full)            { $sl = 'full';   $st = '満席'; }
              elseif ($s['left'] === 1){ $sl = 'urgent'; $st = '残り1席'; }
              elseif ($s['left'] <= 2) { $sl = 'warn';   $st = '残りわずか'; }
              else                     { $sl = 'ok';     $st = '受付中'; }
            ?>
            <label class="ev-slot-radio <?php echo $is_full ? 'disabled' : ''; ?>">
              <input type="radio" name="slot" value="<?php echo esc_attr($s['time']); ?>"
                <?php echo $is_full ? 'disabled' : ''; ?>
                <?php checked(($vals['slot'] ?? ''), $s['time']); ?>>
              <span class="ev-slot-radio-time"><?php echo esc_html($s['time']); ?></span>
              <span class="ev-slot-radio-left <?php echo $sl; ?>"><?php echo $st; ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="ev-field">
          <label>参加人数 <span class="ev-required">必須</span></label>
          <select name="attendees">
            <option value="">選択してください</option>
            <option value="子ども1名・保護者1名" <?php selected(($vals['attendees'] ?? ''), '子ども1名・保護者1名'); ?>>子ども1名・保護者1名</option>
            <option value="子ども1名・保護者2名" <?php selected(($vals['attendees'] ?? ''), '子ども1名・保護者2名'); ?>>子ども1名・保護者2名</option>
            <option value="子ども2名・保護者1名" <?php selected(($vals['attendees'] ?? ''), '子ども2名・保護者1名'); ?>>子ども2名・保護者1名</option>
            <option value="子ども2名・保護者2名" <?php selected(($vals['attendees'] ?? ''), '子ども2名・保護者2名'); ?>>子ども2名・保護者2名</option>
          </select>
        </div>

        <div class="ev-field">
          <label>ご質問・備考 <span class="ev-optional">任意</span></label>
          <textarea name="message" placeholder="アレルギーや配慮が必要なことなどあればご記入ください"><?php echo esc_textarea($vals['message'] ?? ''); ?></textarea>
        </div>

        <button type="submit" class="ev-submit">📨 申し込む</button>
        <p class="ev-caution">
          ※ 送信後に自動返信メールが届きます。届かない場合は迷惑メールフォルダをご確認ください。<br>
          ※ 無断キャンセルはご遠慮ください。キャンセルの際はLINEまたはお電話でご連絡をお願いします。
        </p>
      </form>
    <?php endif; ?>
  </div>

  <!-- TEL -->
  <div style="text-align:center;font-size:13px;color:var(--text-light);">
    お急ぎの場合はお電話またはLINEでもご連絡いただけます<br>
    <a href="tel:0367706936" style="font-size:20px;font-weight:900;color:var(--orange);text-decoration:none;">03-6770-6936</a><br>
    <small>受付時間：平日 15:00〜21:30（土日祝休み）</small>
  </div>

</main>
<?php wp_footer(); ?>
</body>
</html>
