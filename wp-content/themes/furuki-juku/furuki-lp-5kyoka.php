<?php
/**
 * Template Name: LP 5教科・速読解
 * Description: Furuki塾江東住吉教室 メインLP（5教科学習・速読解力講座）
 * Usage: WordPressの「固定ページ」を新規作成し、テンプレートで「LP 5教科・速読解」を選択してください。
 *        このファイルをアクティブテーマのフォルダ（wp-content/themes/あなたのテーマ名/）に配置してください。
 */

/* ============================================================
   ★ 定期テスト対策 カウントダウン設定
   - exam_date: テスト初日（YYYY-MM-DD）★ 毎年ここだけ更新
   - show_days_before: 何日前から表示するか（デフォルト30日）
============================================================ */
$exam_alerts = [
  [
    'school'           => '深川第四中学校',
    'exam_name'        => '前期中間テスト',
    'exam_date'        => '2026-06-09', // ★ 確定したら更新（昨年度実績より）
    'show_days_before' => 30,
    'link_url'         => home_url('/contact/'),
    'link_text'        => 'テスト対策を申し込む',
  ],
  // 学校を追加したい場合はここにコピー↓
  // [
  //   'school'           => '○○中学校',
  //   'exam_name'        => '前期中間テスト',
  //   'exam_date'        => '2026-06-12',
  //   'show_days_before' => 30,
  //   'link_url'         => home_url('/contact/'),
  //   'link_text'        => 'テスト対策を申し込む',
  // ],
];

/* ============================================================
   ★ お知らせバー設定（最大3件）
   - show:       true=表示 / false=非表示
   - start/end:  表示期間（'YYYY-MM-DD' 形式）不要なら '' にする
   - type:       'info'=青 / 'warn'=オレンジ / 'urgent'=赤
   - icon:       絵文字
   - text:       本文
   - link_url:   リンク先URL（不要なら ''）
   - link_text:  リンクテキスト
============================================================ */
$announcements = [
  [
    'show'       => true,
    'start'      => '2026-04-02',
    'end'        => '2026-05-09',
    'type'       => 'info',
    'icon'       => '🎮',
    'text'       => '【親子体験会】Robloxでプログラミングを学びながらゲームを作ろう！ 5月9日（土）10:00 / 13:00 / 15:00（各回1時間・無料）',
    'link_url'   => home_url('/event/'),
    'link_text'  => '詳細・申し込み',
    'is_default' => false,
  ],
  [
    'show'       => false,
    'start'      => '',
    'end'        => '',
    'type'       => 'warn',
    'icon'       => '📢',
    'text'       => 'お知らせ2（showをtrueにして使用してください）',
    'link_url'   => '',
    'link_text'  => '',
    'is_default' => false,
  ],
  // ★ 常設CTA：テスト対策カウントダウンがない期間は常に表示
  [
    'show'       => true,
    'start'      => '',
    'end'        => '',
    'type'       => 'info',
    'icon'       => '🎓',
    'text'       => '無料体験授業・随時受付中！まずはお気軽にご相談ください',
    'link_url'   => home_url('/contact/'),
    'link_text'  => '無料体験を申し込む',
    'is_default' => true,
  ],
];

// 表示すべきお知らせを絞り込む
$today     = date('Y-m-d');
$today_ts  = strtotime($today);

// ① 通常告知（is_default=false）
$normal_announcements = array_filter($announcements, function($a) use ($today) {
  if ($a['is_default'] ?? false) return false;
  if (!$a['show']) return false;
  if ($a['start'] !== '' && $today < $a['start']) return false;
  if ($a['end']   !== '' && $today > $a['end'])   return false;
  return true;
});

// ② テスト対策カウントダウン（30日前〜テスト当日まで）
$exam_announcements = [];
foreach ($exam_alerts as $ex) {
  $exam_ts  = strtotime($ex['exam_date']);
  $days_left = (int) ceil(($exam_ts - $today_ts) / 86400);
  if ($days_left >= 0 && $days_left <= $ex['show_days_before']) {
    if ($days_left === 0)       { $countdown = '今日がテスト初日！'; $type = 'urgent'; }
    elseif ($days_left <= 7)    { $countdown = "テストまで残り{$days_left}日！"; $type = 'urgent'; }
    elseif ($days_left <= 14)   { $countdown = "テストまであと{$days_left}日"; $type = 'warn'; }
    else                        { $countdown = "テストまであと{$days_left}日"; $type = 'exam'; }
    $exam_announcements[] = [
      'show'       => true,
      'type'       => $type,
      'icon'       => '📝',
      'text'       => "【{$ex['school']} {$ex['exam_name']}】{$countdown} | テスト2週前から対策授業スタート。今すぐご相談を",
      'link_url'   => $ex['link_url'],
      'link_text'  => $ex['link_text'],
      'is_default' => false,
    ];
  }
}

// ③ 常設CTA：テスト対策カウントダウンがない期間は常に表示（イベント告知と共存OK）
//    テスト対策が発動している期間だけCTAは非表示になる（Aパターン：完全切り替え）
$default_announcements = [];
if (empty($exam_announcements)) {
  $default_announcements = array_filter($announcements, function($a) use ($today) {
    if (!($a['is_default'] ?? false)) return false;
    if (!$a['show']) return false;
    if ($a['start'] !== '' && $today < $a['start']) return false;
    if ($a['end']   !== '' && $today > $a['end'])   return false;
    return true;
  });
}

// 合算（最大3件）
$active_announcements = array_slice(
  array_merge(
    array_values($normal_announcements),
    array_values($exam_announcements),
    array_values($default_announcements)
  ), 0, 3
);

// ドット絵ブランド（assets/images/ 参照）看板・横ロゴ・マスコット
$furuki_uri_kanban  = get_template_directory_uri() . '/assets/images/furuki-kanban.png';
$furuki_uri_capsule = get_template_directory_uri() . '/assets/images/furuki-logo-capsule.png';
$furuki_uri_mascot  = get_template_directory_uri() . '/assets/images/furuki-chara-mascot.png';
?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="<?php echo esc_url($furuki_uri_kanban); ?>" type="image/png" sizes="any">
<title>Furuki塾江東住吉教室｜完全個別指導・5教科学習・速読解力講座</title>
<meta name="description" content="江東区の完全個別指導学習塾。電子工学修士・認定心理士の塾長が「自ら考える力」を育てます。5教科学習・速読解力講座。無料体験随時受付中。">
<meta property="og:title" content="Furuki塾江東住吉教室｜完全個別指導・5教科・速読解力">
<meta property="og:description" content="AIの時代でも通用する力を育てる完全個別指導塾。江東区千田。無料体験随時受付中。">
<meta property="og:type" content="website">
<meta property="og:image" content="<?php echo esc_url($furuki_uri_kanban); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
<?php if(function_exists('wp_head')) wp_head(); ?>
<style>
/* ==============================
   Reset & Base
============================== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; font-size: 16px; }
body {
  font-family: 'Noto Sans JP', sans-serif;
  background: #FFFBF5;
  color: #1C1917;
  line-height: 1.7;
  overflow-x: hidden;
}
img { max-width: 100%; height: auto; display: block; }
a { color: inherit; text-decoration: none; }

/* ==============================
   Design Tokens
============================== */
:root {
  --orange:        #F97316;
  --orange-light:  #FED7AA;
  --orange-mid:    #FB923C;
  --orange-dark:   #C2410C;
  --amber:         #F59E0B;
  --amber-light:   #FEF3C7;
  --warm-bg:       #FFFBF5;
  --section-bg:    #FFF7ED;
  --card-bg:       #FFFFFF;
  --text:          #1C1917;
  --text-muted:    #78716C;
  --text-light:    #A8A29E;
  --border:        #E7E5E4;
  --line-green:    #06C755;
  --radius:        16px;
  --radius-sm:     8px;
  --shadow:        0 2px 16px rgba(0,0,0,.07);
  --shadow-lg:     0 6px 32px rgba(0,0,0,.11);
}

/* ==============================
   Layout Utilities
============================== */
.container      { max-width: 860px;  margin: 0 auto; padding: 0 20px; }
.container-wide { max-width: 1080px; margin: 0 auto; padding: 0 20px; }
.text-center    { text-align: center; }
.section        { padding: 72px 0; }
.section-alt    { background: var(--section-bg); }

/* ==============================
   Section Headings
============================== */
.section-label {
  display: inline-block;
  background: var(--orange-light);
  color: var(--orange-dark);
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .1em;
  padding: 4px 14px;
  border-radius: 100px;
  margin-bottom: 12px;
}
.section-title {
  font-size: clamp(22px, 4vw, 32px);
  font-weight: 900;
  line-height: 1.4;
  margin-bottom: 16px;
}
.section-title em   { color: var(--orange); font-style: normal; }
.section-subtitle   { font-size: 15px; color: var(--text-muted); max-width: 560px; margin: 0 auto; line-height: 1.8; }

/* ==============================
   Buttons
============================== */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 14px 28px;
  border-radius: 100px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  transition: transform .15s, box-shadow .15s;
  border: none;
}
.btn:hover  { transform: translateY(-2px); box-shadow: var(--shadow); }
.btn:active { transform: scale(.97); }
.btn-outline {
  background: transparent;
  color: var(--orange);
  border: 2px solid var(--orange);
}
.btn-outline:hover { background: var(--orange); color: #fff; }

/* ==============================
   Announcement Bar
============================== */
.announcement-bar      { position: fixed; top: 0; left: 0; right: 0; z-index: 9100; width: 100%; }
.announcement-item     { display: flex; align-items: center; gap: 10px; padding: 9px 20px; font-size: 13px; font-weight: 600; line-height: 1.4; }
.announcement-item.info   { background: #1e40af; color: #fff; }
.announcement-item.warn   { background: var(--orange); color: #fff; }
.announcement-item.urgent { background: #dc2626; color: #fff; }
.announcement-item.exam   { background: #0f766e; color: #fff; } /* テスト対策：ティール */
.announcement-icon     { font-size: 16px; flex-shrink: 0; }
.announcement-text     { flex: 1; }
.announcement-link     { flex-shrink: 0; background: rgba(255,255,255,.25); color: #fff; text-decoration: none; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 10px; white-space: nowrap; transition: background .15s; }
.announcement-link:hover { background: rgba(255,255,255,.4); }
.announcement-close         { flex-shrink: 0; background: none; border: none; color: rgba(255,255,255,.7); font-size: 18px; cursor: pointer; padding: 0 4px; line-height: 1; transition: color .15s; }
.announcement-close:hover   { color: #fff; }
.announcement-close-spacer  { flex-shrink: 0; display: inline-block; width: 26px; }
@media(max-width: 640px) {
  .announcement-item   { font-size: 12px; padding: 8px 12px; }
  .announcement-text   { font-size: 12px; }
}

/* ==============================
   Global Navbar
============================== */
.global-nav {
  position: fixed; top: 0; left: 0; right: 0; z-index: 9000;
  background: rgba(255,251,245,.97);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid var(--border);
  height: 60px;
  display: flex; align-items: center;
}
.global-nav .nav-inner {
  max-width: 1100px; width: 100%; margin: 0 auto;
  padding: 0 24px;
  display: flex; align-items: center; justify-content: space-between; gap: 16px;
}
.nav-logo {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
  letter-spacing: .02em;
  white-space: nowrap;
}
.pixel-art-img {
  image-rendering: -webkit-optimize-contrast;
  image-rendering: crisp-edges;
  image-rendering: pixelated;
}
.nav-logo-mark {
  width: 48px;
  height: 48px;
  flex-shrink: 0;
  display: block;
  border-radius: 10px;
  box-shadow: 0 1px 8px rgba(0,160,233,.2);
}
.nav-logo-text {
  display: flex;
  flex-direction: column;
  line-height: 1.15;
}
.nav-logo-text strong {
  font-size: 18px;
  font-weight: 900;
  color: var(--orange);
}
.nav-logo-sub {
  font-size: 13px;
  font-weight: 700;
  color: var(--text);
  margin-top: 1px;
}
.nav-links {
  display: flex; align-items: center; gap: 4px; list-style: none; margin: 0; padding: 0;
}
.nav-links a {
  font-size: 13px; font-weight: 600; color: var(--text); text-decoration: none;
  padding: 6px 10px; border-radius: 6px; transition: all .15s; white-space: nowrap;
}
.nav-links a:hover { background: var(--orange-light); color: var(--orange-dark); }
.nav-cta {
  background: var(--orange); color: #fff !important; padding: 8px 14px !important;
  border-radius: 20px !important; font-size: 12px !important; white-space: nowrap;
}
.nav-cta:hover { background: var(--orange-dark) !important; color: #fff !important; }
.nav-hamburger {
  display: none; flex-direction: column; gap: 5px; cursor: pointer;
  padding: 6px; background: none; border: none;
}
.nav-hamburger span { display: block; width: 22px; height: 2px; background: var(--text); border-radius: 2px; transition: all .2s; }
.nav-hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.nav-hamburger.open span:nth-child(2) { opacity: 0; }
.nav-hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }
.nav-mobile-menu {
  display: none; position: fixed; top: 60px; left: 0; right: 0;
  background: rgba(255,251,245,.98); backdrop-filter: blur(10px);
  border-bottom: 1px solid var(--border);
  padding: 16px 24px 20px; z-index: 8999;
  flex-direction: column; gap: 4px;
}
.nav-mobile-menu.open { display: flex; }
.nav-mobile-menu a {
  font-size: 14px; font-weight: 600; color: var(--text); text-decoration: none;
  padding: 12px 8px; border-bottom: 1px solid var(--border);
}
.nav-mobile-menu a:last-child { border-bottom: none; }
.nav-mobile-menu a:hover { color: var(--orange); }
body { padding-top: 60px; }
body.has-announcements-1 { padding-top: calc(60px + 38px); }
body.has-announcements-2 { padding-top: calc(60px + 76px); }
body.has-announcements-3 { padding-top: calc(60px + 114px); }
body.has-announcements-1 .global-nav { top: 38px; }
body.has-announcements-2 .global-nav { top: 76px; }
body.has-announcements-3 .global-nav { top: 114px; }
body.has-announcements-1 .nav-mobile-menu { top: calc(38px + 60px); }
body.has-announcements-2 .nav-mobile-menu { top: calc(76px + 60px); }
body.has-announcements-3 .nav-mobile-menu { top: calc(114px + 60px); }
@media(max-width: 768px) {
  .nav-links    { display: none; }
  .nav-hamburger { display: flex; }
}

/* ==============================
   Sticky CTA bar (mobile only)
============================== */
.sticky-cta {
  display: none;
  position: fixed;
  bottom: 0; left: 0; right: 0;
  background: rgba(255,251,245,.96);
  backdrop-filter: blur(8px);
  border-top: 1px solid var(--border);
  padding: 10px 16px;
  gap: 10px;
  z-index: 9999;
}
@media(max-width: 768px) {
  .sticky-cta         { display: flex; }
  .sticky-cta .btn    { flex: 1; font-size: 13px; padding: 12px 8px; }
  body                { padding-bottom: 72px; }
}

/* ==============================
   1. HERO
============================== */
.hero {
  background: linear-gradient(140deg, #EFF8FF 0%, #FFF7ED 45%, #FEF3C7 100%);
  padding: 72px 0 80px;
  position: relative;
  overflow: hidden;
}
/* 右上：ブルーの光彩 */
.hero::before {
  content: '';
  position: absolute;
  top: -100px; right: -80px;
  width: 500px; height: 500px;
  background: radial-gradient(circle, rgba(0,160,233,.10) 0%, transparent 65%);
  border-radius: 50%;
  pointer-events: none;
}
/* 左下：オレンジの光彩 */
.hero::after {
  content: '';
  position: absolute;
  bottom: -80px; left: -60px;
  width: 360px; height: 360px;
  background: radial-gradient(circle, rgba(245,163,35,.13) 0%, transparent 65%);
  border-radius: 50%;
  pointer-events: none;
}
/* 浮遊SVG装飾 */
.hero-deco {
  position: absolute; pointer-events: none; user-select: none; opacity: .22;
}
.hero-deco.d1  { top: 10%; left: 4%;   width: 44px; transform: rotate(-20deg); }
.hero-deco.d2  { top: 60%; left: 6%;   width: 32px; transform: rotate(10deg);  }
.hero-deco.d3  { bottom: 12%; left: 16%; width: 48px; transform: rotate(-12deg); }
.hero-deco.d4  { top: 20%; left: 20%;  width: 28px; transform: rotate(8deg);   }
.hero-deco.d5  { top: 8%;  left: 40%;  width: 36px; transform: rotate(15deg);  }
.hero-deco.d6  { bottom: 15%; left: 38%; width: 30px; transform: rotate(-18deg); }
.hero-deco.d7  { top: 12%; right: 38%; width: 40px; transform: rotate(-10deg); }
.hero-deco.d8  { bottom: 18%; right: 40%; width: 26px; transform: rotate(20deg); }
.hero-deco.d9  { top: 45%; left: 10%;  width: 20px; }
.hero-deco.d10 { top: 35%; left: 32%;  width: 16px; }
.hero-inner {
  display: flex;
  align-items: center;
  gap: 48px;
  position: relative;
  z-index: 1;
}
.hero-content { flex: 1; }
.hero-brand-row {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 14px 20px;
  margin-bottom: 18px;
}
.hero-kanban {
  width: 72px;
  height: auto;
  border-radius: 12px;
  box-shadow: 0 2px 14px rgba(0,160,233,.22);
  flex-shrink: 0;
}
.hero-capsule {
  height: 48px;
  width: auto;
  max-width: min(100%, 440px);
}
@media(max-width: 480px) {
  .hero-capsule { height: 40px; }
  .hero-kanban { width: 58px; }
}
.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: var(--orange);
  color: #fff;
  font-size: 12px;
  font-weight: 700;
  padding: 5px 16px;
  border-radius: 100px;
  margin-bottom: 20px;
}
.hero-title {
  font-size: clamp(28px, 5vw, 48px);
  font-weight: 900;
  line-height: 1.22;
  margin-bottom: 20px;
}
.hero-title .accent { color: var(--orange); }
.hero-sub {
  font-size: 15px;
  color: var(--text-muted);
  margin-bottom: 36px;
  line-height: 1.8;
}
.hero-cta-wrap      { display: flex; flex-direction: column; gap: 12px; align-items: flex-start; }
.hero-cta-note      { font-size: 12px; color: var(--text-light); margin-top: 4px; }
.hero-line-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: var(--line-green);
  color: #fff;
  padding: 16px 36px;
  border-radius: 100px;
  font-size: 17px;
  font-weight: 700;
  box-shadow: 0 4px 20px rgba(6,199,85,.30);
  transition: transform .15s, box-shadow .15s;
}
.hero-line-btn:hover  { transform: translateY(-2px); box-shadow: 0 6px 28px rgba(6,199,85,.40); color: #fff; }
.hero-stats {
  display: flex;
  gap: 28px;
  margin-top: 36px;
}
.hero-stat-num   { font-size: 26px; font-weight: 900; color: var(--orange); line-height: 1; }
.hero-stat-label { font-size: 11px; color: var(--text-muted); margin-top: 3px; }
.hero-visual-wrap  { flex: 0 0 300px; text-align: center; }
.hero-visual {
  width: 260px; height: 260px;
  background: var(--card-bg);
  border-radius: 50%;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: var(--shadow-lg);
  font-size: 88px;
  border: 5px solid var(--orange-light);
}
.hero-season-img   { width: 300px; height: 300px; object-fit: cover; border-radius: 50%; box-shadow: var(--shadow-lg); border: 5px solid var(--orange-light); display: block; margin: 0 auto; }
.hero-chara-mid    { flex-shrink: 0; align-self: flex-end; padding-bottom: 8px; }
.hero-chara-mid img { width: 168px; display: block; filter: drop-shadow(2px 4px 6px rgba(0,0,0,.15)); transform: scaleX(-1); }
@media(max-width: 960px) { .hero-chara-mid { display: none; } }

@media(max-width: 768px) {
  .hero-brand-row    { justify-content: center; width: 100%; }
  .hero-inner         { flex-direction: column; gap: 32px; }
  .hero-visual-wrap   { display: block; }
  .hero-season-img    { width: 200px; height: 200px; }
  .hero-cta-wrap      { width: 100%; }
  .hero-cta-wrap > *  { width: 100%; justify-content: center; }
  .hero-stats         { justify-content: center; flex-wrap: wrap; gap: 20px; }
}

/* ==============================
   2. PAIN POINTS
============================== */
.pain-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
  gap: 14px;
  margin-top: 40px;
}
.pain-card {
  background: var(--card-bg);
  border: 1.5px solid var(--border);
  border-radius: var(--radius);
  padding: 18px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
}
.pain-icon {
  width: 36px; height: 36px;
  background: var(--amber-light);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  flex-shrink: 0;
}
.pain-text { font-size: 14px; font-weight: 700; color: var(--text); line-height: 1.55; }
.pain-resolve {
  margin-top: 40px;
  background: var(--orange);
  color: #fff;
  border-radius: var(--radius);
  padding: 24px 32px;
  text-align: center;
  font-size: clamp(15px, 2.5vw, 19px);
  font-weight: 700;
  line-height: 1.7;
}

/* ==============================
   3. REASONS
============================== */
.reasons-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-top: 48px;
}
.reason-card {
  background: var(--card-bg);
  border-radius: var(--radius);
  padding: 28px 22px;
  text-align: center;
  box-shadow: var(--shadow);
  position: relative;
  overflow: hidden;
}
.reason-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--orange), var(--amber));
}
.reason-num   { font-size: 44px; font-weight: 900; color: var(--orange-light); line-height: 1; margin-bottom: 6px; }
.reason-icon  { width: 64px; height: 64px; margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; }
.reason-icon svg { width: 100%; height: 100%; }
.reason-title { font-size: 15px; font-weight: 700; margin-bottom: 10px; line-height: 1.45; }
.reason-body  { font-size: 13px; color: var(--text-muted); line-height: 1.75; }

@media(max-width: 640px) { .reasons-grid { grid-template-columns: 1fr; } }
@media(min-width: 641px) and (max-width: 900px) {
  .reasons-grid { grid-template-columns: repeat(2, 1fr); }
  .reason-card:last-child { grid-column: span 2; max-width: 420px; margin: 0 auto; width: 100%; }
}

/* ==============================
   3.5 VACANCY（残り席数）
============================== */
.vacancy-section       { background: #1c1917; color: #fff; padding: 48px 0; }
.vacancy-lead          { text-align: center; margin-bottom: 32px; }
.vacancy-lead-label    { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--orange); background: rgba(249,115,22,.15); padding: 4px 14px; border-radius: 20px; margin-bottom: 10px; }
.vacancy-lead-title    { font-size: 22px; font-weight: 900; }
.vacancy-lead-title em { color: var(--orange); font-style: normal; }
.vacancy-lead-note     { font-size: 13px; color: #a8a29e; margin-top: 6px; }
.vacancy-grid          { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; }
.vacancy-card          { background: #292524; border-radius: 10px; padding: 16px 12px; text-align: center; border: 1px solid #44403c; }
.vacancy-grade         { font-size: 12px; font-weight: 700; color: #a8a29e; margin-bottom: 8px; letter-spacing: .03em; }
.vacancy-count         { font-size: 28px; font-weight: 900; line-height: 1; color: #4ade80; }
.vacancy-count.warn    { color: var(--orange); }
.vacancy-count.urgent  { color: #f87171; }
.vacancy-count.full    { font-size: 16px; color: #6b7280; }
.vacancy-status        { font-size: 11px; margin-top: 4px; font-weight: 700; letter-spacing: .04em; color: #4ade80; }
.vacancy-status.warn   { color: var(--orange); }
.vacancy-status.urgent { color: #f87171; }
.vacancy-status.full   { color: #6b7280; }
.vacancy-bar           { margin-top: 8px; height: 4px; background: #44403c; border-radius: 2px; overflow: hidden; }
.vacancy-bar-fill      { height: 100%; border-radius: 2px; background: #4ade80; }
.vacancy-bar-fill.warn   { background: var(--orange); }
.vacancy-bar-fill.urgent { background: #f87171; }
.vacancy-bar-fill.full   { background: #6b7280; }
.vacancy-unlimited     { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; margin-top: 20px; }
.vacancy-unlimited-item{ background: #292524; border: 1px solid #44403c; border-radius: 8px; padding: 10px 20px; font-size: 13px; color: #a8a29e; display: flex; align-items: center; gap: 8px; }
.vacancy-unlimited-item strong { color: #fff; font-size: 14px; }
.vacancy-unlimited-badge { background: #166534; color: #4ade80; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 10px; letter-spacing: .05em; }
.vacancy-cta           { text-align: center; margin-top: 28px; }
.vacancy-cta a         { display: inline-flex; align-items: center; gap: 8px; background: var(--orange); color: #fff; padding: 14px 28px; border-radius: 30px; font-size: 15px; font-weight: 700; text-decoration: none; transition: background .2s; }
.vacancy-cta a:hover   { background: var(--orange-dark); }
@media(max-width: 640px) { .vacancy-grid { grid-template-columns: repeat(3, 1fr); } }
@media(max-width: 400px) { .vacancy-grid { grid-template-columns: repeat(2, 1fr); } }

/* ==============================
   4. CONCEPT
============================== */
.concept-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-top: 48px;
}
.concept-item {
  text-align: center;
  padding: 28px 18px;
  background: var(--card-bg);
  border-radius: var(--radius);
  border: 2px solid var(--orange-light);
}
.concept-num {
  width: 48px; height: 48px;
  background: var(--orange);
  color: #fff;
  border-radius: 50%;
  font-size: 20px;
  font-weight: 900;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
}
.concept-title { font-size: 16px; font-weight: 700; color: var(--orange-dark); margin-bottom: 10px; }
.concept-body  { font-size: 13px; color: var(--text-muted); line-height: 1.75; }
.concept-note  {
  margin-top: 36px;
  padding: 20px 28px;
  background: var(--amber-light);
  border-radius: var(--radius);
  font-size: 14px;
  color: #78350F;
  line-height: 1.85;
  text-align: center;
}
.concept-note strong { color: #292524; }

@media(max-width: 640px) { .concept-grid { grid-template-columns: 1fr; } }

/* ==============================
   5. TEACHER PROFILE
============================== */
.teacher-card {
  background: var(--card-bg);
  border-radius: var(--radius);
  box-shadow: var(--shadow-lg);
  overflow: hidden;
  display: flex;
}
.teacher-sidebar {
  flex: 0 0 200px;
  background: linear-gradient(160deg, #FFF7ED, #FEF3C7);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
  text-align: center;
  border-right: 1px solid var(--orange-light);
}
.teacher-avatar        { width: 160px; height: 160px; margin: 0 auto 16px; }
.teacher-avatar img    { width: 100%; height: 100%; object-fit: contain; }
.teacher-name          { font-size: 18px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
.teacher-role          { font-size: 11px; color: var(--text-muted); line-height: 1.6; }
.teacher-content       { flex: 1; padding: 36px 40px; }
.teacher-headline      { font-size: clamp(17px, 2.5vw, 21px); font-weight: 700; line-height: 1.5; margin-bottom: 20px; }
.teacher-headline em   { color: var(--orange); font-style: normal; }
.teacher-bio           { font-size: 14px; color: var(--text-muted); line-height: 1.95; margin-bottom: 24px; }
.teacher-tags          { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 28px; }
.teacher-tag {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: var(--amber-light);
  color: #92400E;
  font-size: 12px;
  font-weight: 700;
  padding: 4px 12px;
  border-radius: 100px;
}
.teacher-tag::before   { content: '✓'; color: var(--orange); }


@media(max-width: 768px) {
  .teacher-card        { flex-direction: column; }
  .teacher-sidebar     { flex: none; padding: 28px 20px; border-right: none; border-bottom: 1px solid var(--orange-light); }
  .teacher-content     { padding: 24px 20px; }
  .teacher-chara-gallery { gap: 12px; }
  .teacher-chara-item img { height: 140px; }
}

/* ==============================
   WAVE DIVIDERS
============================== */
.wave-divider {
  width: 100%;
  overflow: hidden;
  line-height: 0;
  margin: -1px 0;
  display: block;
}
.wave-divider svg {
  display: block;
  width: 100%;
  height: 56px;
}
@media(max-width: 640px) {
  .wave-divider svg { height: 36px; }
}

/* ==============================
   5.5 USAGE（こんな使い方ができます）
============================== */
.usage-section         { background: var(--orange-light); }
.usage-grid            { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 40px; }
.usage-card            { background: #fff; border-radius: var(--radius); padding: 22px 20px; display: flex; gap: 14px; align-items: flex-start; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
.usage-icon            { font-size: 28px; flex-shrink: 0; }
.usage-title           { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
.usage-body            { font-size: 12px; color: var(--text-light); line-height: 1.65; }
.usage-note            { text-align: center; margin-top: 24px; font-size: 13px; color: var(--text-light); }
.usage-note strong     { color: var(--orange-dark); }
@media(max-width: 768px) { .usage-grid { grid-template-columns: repeat(2, 1fr); } }
@media(max-width: 480px) { .usage-grid { grid-template-columns: 1fr; } }

/* ==============================
   6. COURSES
============================== */
.course-tabs {
  display: flex;
  border-radius: var(--radius);
  overflow: hidden;
  border: 2px solid var(--orange-light);
  margin-bottom: 28px;
}
.course-tab {
  flex: 1;
  padding: 14px 12px;
  text-align: center;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  color: var(--text-muted);
  background: var(--card-bg);
  transition: all .2s;
  border: none;
}
.course-tab.active     { background: var(--orange); color: #fff; }
.course-detail         { display: none; }
.course-detail.active  { display: block; animation: fadeIn .3s ease; }
@keyframes fadeIn      { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }

.course-card           { background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; }
.course-header         { background: var(--orange); color: #fff; padding: 20px 28px; display: flex; align-items: center; gap: 16px; }
.course-header-amber   { background: var(--amber); }
.course-icon           { font-size: 32px; }
.course-header-title   { font-size: 19px; font-weight: 700; }
.course-header-sub     { font-size: 13px; opacity: .85; margin-top: 2px; }
.course-body           { padding: 28px; }

.course-for            { background: var(--amber-light); border-radius: var(--radius-sm); padding: 14px 18px; margin-bottom: 20px; }
.course-for-label      { font-size: 11px; font-weight: 700; color: #92400E; margin-bottom: 8px; }
.course-for-list       { list-style: none; display: flex; flex-wrap: wrap; gap: 6px; }
.course-for-list li    { font-size: 13px; color: #78350F; background: #fff; padding: 3px 10px; border-radius: 100px; }
.course-for-list li::before { content: '👍 '; }

.course-features       { list-style: none; margin-bottom: 20px; }
.course-features li    { font-size: 14px; padding: 9px 0; border-bottom: 1px solid var(--border); display: flex; align-items: flex-start; gap: 8px; }
.course-features li::before { content: '✔'; color: var(--orange); font-weight: 700; flex-shrink: 0; margin-top: 1px; }

.course-subjects       { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px; }
.subject-tag           { background: var(--orange-light); color: var(--orange-dark); font-size: 12px; font-weight: 500; padding: 3px 10px; border-radius: 100px; }

/* 速読解力講座 バナー・よみとくんCTA */
.sokudoku-banners            { display: flex; gap: 20px; align-items: flex-start; margin-top: 4px; }
.sokudoku-banner-wrap        { flex: 1; min-width: 0; }
.sokudoku-banner-link        { display: block; text-decoration: none; border-radius: 10px; border: 1px solid var(--border); overflow: hidden; transition: box-shadow .2s, opacity .2s; }
.sokudoku-banner-link:hover  { opacity: .9; box-shadow: 0 4px 16px rgba(0,0,0,.12); }
.sokudoku-link-label         { display: flex; align-items: center; justify-content: flex-end; gap: 4px; font-size: 11px; color: var(--text-light); margin-top: 5px; }
.sokudoku-placeholder        { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; background: linear-gradient(135deg, #fff8e1, #fff3cd); border: 2px dashed #f5a623; border-radius: 10px; padding: 32px 20px; text-align: center; color: #92400e; font-weight: 700; font-size: 15px; }
@media(max-width:560px) {
  .sokudoku-banners { flex-direction: column; }
}

/* ==============================
   7. SCHEDULE
============================== */
.schedule-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
  gap: 18px;
}
.schedule-example      { background: var(--card-bg); border-radius: var(--radius); border: 1.5px solid var(--border); overflow: hidden; }
.schedule-head         { background: var(--section-bg); padding: 12px 16px; font-size: 13px; font-weight: 700; border-bottom: 1px solid var(--border); }
.schedule-table        { width: 100%; border-collapse: collapse; font-size: 12px; }
.schedule-table th, .schedule-table td { padding: 8px 4px; text-align: center; border: 1px solid var(--border); }
.schedule-table th     { background: var(--section-bg); font-weight: 700; color: var(--text-muted); }
.schedule-table td.on  { background: var(--orange-light); color: var(--orange-dark); font-weight: 700; }
.schedule-tip {
  margin-top: 28px;
  background: var(--orange-light);
  border-radius: var(--radius);
  padding: 20px 24px;
  display: flex;
  align-items: flex-start;
  gap: 14px;
}
.schedule-tip-icon     { font-size: 28px; flex-shrink: 0; }
.schedule-tip-text     { font-size: 14px; color: var(--text); line-height: 1.75; font-weight: 500; }

/* ==============================
   8. TESTIMONIALS
============================== */
.testimonials-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 18px;
  margin-top: 40px;
}
.t-card                { background: var(--card-bg); border-radius: var(--radius); border: 1.5px solid var(--border); padding: 22px; }
.t-quote               { font-size: 40px; color: var(--orange-light); line-height: 1; margin-bottom: 10px; }
.t-text                { font-size: 14px; color: var(--text); line-height: 1.85; margin-bottom: 16px; }
.t-author              { display: flex; align-items: center; gap: 10px; }
.t-avatar              { width: 38px; height: 38px; border-radius: 50%; background: var(--orange-light); display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
.t-name                { font-size: 13px; font-weight: 700; }
.t-meta                { font-size: 12px; color: var(--text-light); }
.t-note                { margin-top: 28px; padding: 18px 24px; background: var(--section-bg); border-radius: var(--radius); text-align: center; font-size: 14px; color: var(--text-muted); line-height: 1.75; }
.t-note strong         { color: var(--orange-dark); }

/* ==============================
   9. PRICING
============================== */
.pricing-tabs          { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; margin-top: 40px; border-bottom: 2px solid var(--border); padding-bottom: 0; }
.pricing-tab           { padding: 10px 18px; font-size: 13px; font-weight: 700; border: 2px solid var(--border); border-bottom: none; border-radius: 8px 8px 0 0; background: #fff; color: var(--text-light); cursor: pointer; margin-bottom: -2px; transition: all .2s; }
.pricing-tab.active    { background: var(--orange); color: #fff; border-color: var(--orange); }
.pricing-tab:hover:not(.active) { background: var(--orange-light); color: var(--orange-dark); border-color: var(--orange-light); }
.pricing-panel         { display: none; padding: 28px 0 8px; }
.pricing-panel.active  { display: block; }
.pricing-tax-note      { font-size: 12px; color: var(--text-light); margin-bottom: 12px; }
.pricing-table-wrap    { overflow-x: auto; margin-bottom: 8px; }
.pricing-table         { width: auto; min-width: 360px; max-width: 100%; border-collapse: collapse; font-size: 14px; margin: 0 auto; }
.pricing-table th      { background: var(--orange); color: #fff; padding: 11px 20px; text-align: center; font-weight: 700; white-space: nowrap; }
.pricing-table th.sub  { background: var(--orange-dark); font-size: 12px; }
.pricing-table td      { padding: 11px 20px; border-bottom: 1px solid var(--border); text-align: center; white-space: nowrap; }
.pricing-table tr:nth-child(even) td { background: var(--section-bg); }
.pricing-table td.lbl  { text-align: center; font-weight: 700; }
.pricing-table td.hl   { font-weight: 700; color: var(--orange-dark); }
.pricing-note          { font-size: 12px; color: var(--text-light); margin-top: 6px; line-height: 1.7; }
.pricing-extras        { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 12px; margin-top: 32px; }
.pricing-extra         { background: var(--section-bg); border-radius: var(--radius-sm); padding: 14px 16px; font-size: 13px; color: var(--text); line-height: 1.7; }
.pricing-extra strong  { display: block; font-size: 14px; color: var(--orange-dark); margin-bottom: 4px; }
.pricing-h3            { font-size: 16px; font-weight: 700; margin: 24px 0 10px; padding-left: 12px; border-left: 4px solid var(--orange); color: var(--text); }
@media(max-width:600px) { .pricing-tab { font-size: 12px; padding: 8px 12px; } }

/* ==============================
   10. FAQ
============================== */
.faq-list              { margin-top: 40px; display: flex; flex-direction: column; gap: 10px; }
.faq-item              { background: var(--card-bg); border-radius: var(--radius); border: 1.5px solid var(--border); overflow: hidden; }
.faq-q {
  padding: 17px 18px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 12px;
  user-select: none;
}
.faq-q-badge {
  width: 26px; height: 26px;
  background: var(--orange);
  color: #fff;
  border-radius: 50%;
  font-size: 13px;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.faq-q-text    { flex: 1; }
.faq-chevron   { font-size: 14px; color: var(--text-light); transition: transform .25s; flex-shrink: 0; }
.faq-item.open .faq-chevron { transform: rotate(180deg); }
.faq-a {
  display: none;
  padding: 0 18px 16px 56px;
  font-size: 14px;
  color: var(--text-muted);
  line-height: 1.85;
  border-top: 1px solid var(--border);
}
.faq-item.open .faq-a { display: block; }
.faq-a .hl             { color: var(--orange-dark); font-weight: 700; }

/* ==============================
   11. CTA SECTION
============================== */
.cta-section {
  background: linear-gradient(140deg, #FFF7ED, #FEF3C7);
  padding: 88px 0;
  text-align: center;
}
.cta-title             { font-size: clamp(24px, 4vw, 38px); font-weight: 900; line-height: 1.4; margin-bottom: 16px; }
.cta-title em          { color: var(--orange); font-style: normal; }
.cta-sub               { font-size: 15px; color: var(--text-muted); margin-bottom: 44px; line-height: 1.85; }
.cta-btn-group         { display: flex; flex-direction: column; align-items: center; gap: 14px; }
.cta-line-btn {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  background: var(--line-green);
  color: #fff;
  padding: 18px 52px;
  border-radius: 100px;
  font-size: 18px;
  font-weight: 700;
  box-shadow: 0 4px 20px rgba(6,199,85,.32);
  transition: transform .15s, box-shadow .15s;
}
.cta-line-btn:hover    { transform: translateY(-2px); box-shadow: 0 6px 28px rgba(6,199,85,.42); color: #fff; }
.cta-form-btn          { display: inline-flex; align-items: center; gap: 8px; color: var(--orange-dark); font-size: 15px; font-weight: 700; padding: 13px 32px; border-radius: 100px; border: 2px solid var(--orange); transition: all .15s; }
.cta-form-btn:hover    { background: var(--orange); color: #fff; }
.cta-tel               { font-size: 14px; color: var(--text-muted); margin-top: 4px; }
.cta-tel a             { color: var(--orange-dark); font-weight: 700; font-size: 18px; }
.cta-meta              { font-size: 12px; color: var(--text-light); margin-top: 16px; line-height: 1.85; }
.cta-unschool {
  display: inline-block;
  margin-top: 32px;
  padding: 16px 28px;
  background: rgba(255,255,255,.7);
  border-radius: var(--radius);
  border: 1.5px dashed var(--amber);
  max-width: 480px;
  text-align: left;
  font-size: 13px;
  color: var(--text-muted);
  line-height: 1.75;
}
.cta-unschool strong   { color: var(--text); display: block; margin-bottom: 4px; }

@media(max-width: 640px) {
  .cta-line-btn         { width: 100%; justify-content: center; max-width: 360px; }
  .cta-form-btn         { width: 100%; justify-content: center; max-width: 360px; }
}

/* ==============================
   12. ACCESS
============================== */
.access-maps-grid      { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 48px; align-items: stretch; }
.access-map-card       { background: #fff; border-radius: var(--radius); box-shadow: 0 2px 12px rgba(0,0,0,.07); overflow: hidden; display: flex; flex-direction: column; }
.access-map-card-header{ background: var(--orange); color: #fff; text-align: center; padding: 10px 16px; font-size: 13px; font-weight: 700; letter-spacing: .05em; flex-shrink: 0; }
.access-map-card-header.google { background: #4285f4; }
.access-map-iframe-wrap{ flex: 1; position: relative; min-height: 260px; }
.access-map-iframe-wrap iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: none; }
.access-map-card img   { width: 100%; height: auto; display: block; flex: 1; }
.access-map-link       { display: block; text-align: center; padding: 8px; font-size: 12px; color: #1a73e8; text-decoration: none; flex-shrink: 0; }
.access-info-row       { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 24px; background: #fff; border-radius: var(--radius); padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,.07); }
.access-info-item      { display: flex; gap: 12px; align-items: flex-start; }
.access-info-icon      { font-size: 22px; flex-shrink: 0; margin-top: 2px; }
.access-info-label     { font-size: 11px; font-weight: 700; color: var(--text-light); letter-spacing: .05em; text-transform: uppercase; margin-bottom: 4px; }
.access-info-value     { font-size: 13px; color: var(--text); line-height: 1.7; }
.access-info-value a   { color: var(--orange); font-weight: 700; }
.access-line-link      { color: var(--line-green) !important; }

@media(max-width: 768px) {
  .access-maps-grid   { grid-template-columns: 1fr; }
  .access-info-row    { grid-template-columns: 1fr; }
}

/* ==============================
   13. FOOTER
============================== */
.footer                { background: #292524; color: #fff; padding: 52px 0 32px; }
.footer-brand          { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 10px; }
.footer-logo-mark      { width: 56px; height: 56px; flex-shrink: 0; display: block; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.25); }
.footer-capsule-wrap   { margin: 0 0 22px; max-width: 100%; }
.footer-capsule-img    { height: 46px; width: auto; max-width: 100%; display: block; }
.footer-brand-text     { min-width: 0; }
.footer-logo           { font-size: 19px; font-weight: 900; color: var(--orange); margin-bottom: 6px; }
.footer-tagline        { font-size: 13px; color: #A8A29E; margin-bottom: 28px; }
.footer-grid           { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 32px; padding-bottom: 32px; border-bottom: 1px solid #44403C; }
.footer-col-title      { font-size: 11px; font-weight: 700; color: #78716C; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 14px; }
.footer-links          { list-style: none; display: flex; flex-direction: column; gap: 8px; }
.footer-links a        { font-size: 13px; color: #A8A29E; transition: color .15s; }
.footer-links a:hover  { color: var(--orange); }
.footer-social a       { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; color: #A8A29E; transition: all .2s; margin-top: 14px; text-decoration: none; }
.footer-social a:hover { color: #fff; }
.footer-social a:hover .ig-icon { background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); }
.ig-icon               { width: 28px; height: 28px; border-radius: 8px; background: #555; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: background .2s; }
.ig-icon svg           { width: 16px; height: 16px; fill: #fff; }
.footer-bottom         { padding-top: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
.footer-copy           { font-size: 12px; color: #78716C; }

@media(max-width: 640px) {
  .footer-grid          { grid-template-columns: 1fr; gap: 24px; }
  .footer-bottom        { flex-direction: column; align-items: flex-start; }
}
</style>
</head>
<?php
$ann_count = count($active_announcements);
$body_class = $ann_count > 0 ? "has-announcements-{$ann_count}" : '';
?>
<body class="<?php echo $body_class; ?>">

<?php if (!empty($active_announcements)): ?>
<!-- ============================================================
   ANNOUNCEMENT BAR（お知らせバー）
============================================================ -->
<div class="announcement-bar" id="announcementBar">
  <?php foreach ($active_announcements as $i => $a): ?>
  <div class="announcement-item <?php echo esc_attr($a['type']); ?>" id="ann-<?php echo $i; ?>">
    <span class="announcement-icon"><?php echo $a['icon']; ?></span>
    <span class="announcement-text"><?php echo esc_html($a['text']); ?></span>
    <?php if (!empty($a['link_url'])): ?>
      <a href="<?php echo esc_url($a['link_url']); ?>" class="announcement-link"><?php echo esc_html($a['link_text'] ?: '詳しくはこちら'); ?> →</a>
    <?php endif; ?>
    <?php if (!($a['is_default'] ?? false)): ?>
      <button class="announcement-close" onclick="closeAnnouncement('ann-<?php echo $i; ?>')" aria-label="閉じる">×</button>
    <?php else: ?>
      <span class="announcement-close-spacer"></span>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ============================================================
   GLOBAL NAV
============================================================ -->
<nav class="global-nav" role="navigation">
  <div class="nav-inner">
    <a href="#top" class="nav-logo">
      <img src="<?php echo esc_url($furuki_uri_kanban); ?>" alt="Furuki塾" class="nav-logo-mark pixel-art-img" width="48" height="48" decoding="async" fetchpriority="high">
      <span class="nav-logo-text"><span class="nav-logo-sub">江東住吉教室</span></span>
    </a>
    <ul class="nav-links">
      <li><a href="#reasons">選ばれる理由</a></li>
      <li><a href="#courses">コース紹介</a></li>
      <li><a href="#pricing">料金</a></li>
      <li><a href="#faq">よくある質問</a></li>
      <li><a href="#access">アクセス</a></li>
      <li><a href="https://lin.ee/7NV1Pld" class="nav-cta">💬 無料体験</a></li>
    </ul>
    <button class="nav-hamburger" onclick="toggleNavMenu(this)" aria-label="メニュー">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- モバイルメニュー -->
<div class="nav-mobile-menu" id="navMobileMenu">
  <a href="#reasons"  onclick="closeNavMenu()">選ばれる理由</a>
  <a href="#courses"  onclick="closeNavMenu()">コース紹介</a>
  <a href="#pricing"  onclick="closeNavMenu()">料金のご案内</a>
  <a href="#faq"      onclick="closeNavMenu()">よくある質問</a>
  <a href="#access"   onclick="closeNavMenu()">アクセス</a>
  <a href="https://lin.ee/7NV1Pld" style="color:var(--orange);font-weight:700;">💬 LINEで無料体験に申し込む</a>
</div>

<!-- ============================================================
   STICKY CTA（モバイル専用 画面下部固定）
============================================================ -->
<div class="sticky-cta">
  <a href="https://lin.ee/7NV1Pld" class="btn" style="background:var(--line-green);color:#fff;">💬 LINEで無料相談</a>
  <a href="<?php echo home_url("/contact/"); ?>" class="btn btn-outline">📝 問い合わせ</a>
</div>

<!-- ============================================================
   1. HERO
============================================================ -->
<section class="hero" id="top">
  <!-- 浮遊SVG装飾 -->
  <!-- 鉛筆 -->
  <svg class="hero-deco d1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" fill="#f5a623"/>
  </svg>
  <!-- 星 -->
  <svg class="hero-deco d2" viewBox="0 0 24 24" fill="#00a0e9" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
  </svg>
  <!-- 本 -->
  <svg class="hero-deco d3" viewBox="0 0 24 24" fill="#00497a" xmlns="http://www.w3.org/2000/svg">
    <path d="M18 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
  </svg>
  <!-- 電球 -->
  <svg class="hero-deco d4" viewBox="0 0 24 24" fill="#f5a623" xmlns="http://www.w3.org/2000/svg">
    <path d="M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7z"/>
  </svg>
  <!-- 三角定規 -->
  <svg class="hero-deco d5" viewBox="0 0 24 24" fill="#00a0e9" xmlns="http://www.w3.org/2000/svg">
    <path d="M3 21L12 3l9 18H3zm2.5-2h13L12 6.5 5.5 19z"/>
  </svg>
  <!-- 星（小） -->
  <svg class="hero-deco d6" viewBox="0 0 24 24" fill="#f5a623" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
  </svg>
  <!-- 鉛筆（右） -->
  <svg class="hero-deco d7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" fill="#00497a"/>
  </svg>
  <!-- 本（小） -->
  <svg class="hero-deco d8" viewBox="0 0 24 24" fill="#f5a623" xmlns="http://www.w3.org/2000/svg">
    <path d="M18 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
  </svg>
  <!-- 丸ドット装飾 -->
  <svg class="hero-deco d9" viewBox="0 0 24 24" fill="#00a0e9" xmlns="http://www.w3.org/2000/svg">
    <circle cx="12" cy="12" r="10"/>
  </svg>
  <svg class="hero-deco d10" viewBox="0 0 24 24" fill="#f5a623" xmlns="http://www.w3.org/2000/svg">
    <circle cx="12" cy="12" r="10"/>
  </svg>
  <div class="container">
    <div class="hero-inner">
      <div class="hero-content">
        <div class="hero-brand-row">
          <img src="<?php echo esc_url($furuki_uri_kanban); ?>" alt="" width="72" height="72" class="hero-kanban pixel-art-img" aria-hidden="true" decoding="async">
          <img src="<?php echo esc_url($furuki_uri_capsule); ?>" alt="Furuki塾 小中学生向け プログラム・学習塾" class="hero-capsule pixel-art-img" decoding="async">
        </div>
        <div class="hero-badge">✦ 無料体験 随時受付中</div>
        <h1 class="hero-title">
          何がわからないか、<br>
          <span class="accent">わからない。</span>
        </h1>
        <p class="hero-sub">
          そんな「悩める」キミに、Furuki塾。<br>
          東京都江東区千田の完全個別指導塾 ／ 小学1年生〜中学3年生対象
        </p>
        <div class="hero-cta-wrap">
          <a href="https://lin.ee/7NV1Pld" class="hero-line-btn">
            💬 LINEで無料体験に申し込む
          </a>
          <a href="<?php echo home_url("/contact/"); ?>" class="btn btn-outline">
            📝 フォームでお問い合わせ
          </a>
          <p class="hero-cta-note">※ 無理な勧誘は一切ありません。相談だけでも歓迎です。</p>
        </div>
        <div class="hero-stats">
          <div>
            <div class="hero-stat-num">完全個別</div>
            <div class="hero-stat-label">指導スタイル</div>
          </div>
          <div>
            <div class="hero-stat-num">5教科＋α</div>
            <div class="hero-stat-label">読解・プログラミング含む</div>
          </div>
          <div>
            <div class="hero-stat-num">最大4回</div>
            <div class="hero-stat-label">無料で体験できます</div>
          </div>
        </div>
      </div>
      <!-- 中間装飾キャラ -->
      <div class="hero-chara-mid">
        <img src="<?php echo esc_url($furuki_uri_mascot); ?>"
             alt="" class="pixel-art-img" aria-hidden="true" decoding="async">
      </div>
      <div class="hero-visual-wrap">
        <?php
          $month = (int) date('n');
          $day   = (int) date('j');
          // 12/26〜1/10 は正月、それ以外の冬は雪だるま
          $is_newyear = ( $month === 12 && $day >= 26 ) || ( $month === 1 && $day <= 10 );
          if      ($month >= 3 && $month <= 5)  { $season_img = 'spring.png';  $season_alt = '春のふるき塾'; }
          elseif  ($month >= 6 && $month <= 8)  { $season_img = 'summer.png';  $season_alt = '夏のふるき塾'; }
          elseif  ($month >= 9 && $month <= 11) { $season_img = 'autumn.png';  $season_alt = '秋のふるき塾'; }
          elseif  ($is_newyear)                  { $season_img = 'winter.png';  $season_alt = 'お正月のふるき塾'; }
          else                                   { $season_img = 'snow.png';    $season_alt = '冬のふるき塾'; }
          $season_path = get_template_directory() . '/assets/images/seasons/' . $season_img;
          $season_url  = get_template_directory_uri() . '/assets/images/seasons/' . $season_img;
        ?>
        <?php if ( file_exists($season_path) ): ?>
          <img src="<?php echo esc_url($season_url); ?>"
               alt="<?php echo esc_attr($season_alt); ?>"
               class="hero-season-img">
        <?php else: ?>
          <div class="hero-visual">📚</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
   2. PAIN POINTS
============================================================ -->
<section class="section" id="pain">
  <div class="container">
    <div class="text-center">
      <span class="section-label">こんなお悩みはありませんか？</span>
      <h2 class="section-title">お子さんの勉強、<br>こう感じていませんか？</h2>
    </div>
    <div class="pain-grid">
      <div class="pain-card">
        <div class="pain-icon">😓</div>
        <p class="pain-text">勉強の仕方がわからず、何から始めたらいいか途方に暮れている</p>
      </div>
      <div class="pain-card">
        <div class="pain-icon">⏰</div>
        <p class="pain-text">部活や習い事があって、決まった時間に塾へ通えない</p>
      </div>
      <div class="pain-card">
        <div class="pain-icon">📉</div>
        <p class="pain-text">塾に通っているのに、テストの点数が思うように上がらない</p>
      </div>
      <div class="pain-card">
        <div class="pain-icon">🤔</div>
        <p class="pain-text">AIが普及する将来、子どもに本当に必要な力って何だろう…</p>
      </div>
    </div>
    <div class="pain-resolve">
      その悩み、Furuki塾の<strong>「完全個別指導 × 考える力を育てる授業」</strong>で、<br>
      一つずつ解決できます。
    </div>
  </div>
</section>

<!-- wave: white → #FFF7ED -->
<div class="wave-divider" style="background:#fff;">
  <svg viewBox="0 0 1440 56" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,28 C240,56 480,0 720,28 C960,56 1200,0 1440,28 L1440,56 L0,56 Z" fill="#FFF7ED"/>
  </svg>
</div>
<!-- ============================================================
   3. REASONS（選ばれる3つの理由）
============================================================ -->
<section class="section section-alt" id="reasons">
  <div class="container">
    <div class="text-center">
      <span class="section-label">Furuki塾が選ばれる理由</span>
      <h2 class="section-title">他塾と<em>ここが違う</em>、3つのポイント</h2>
    </div>
    <div class="reasons-grid">
      <div class="reason-card">
        <div class="reason-num">01</div>
        <div class="reason-icon">
          <!-- カレンダー＋時計：自由な時間割 -->
          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="6" y="12" width="42" height="38" rx="5" fill="#FEF3C7" stroke="#F97316" stroke-width="2.5"/>
            <rect x="6" y="12" width="42" height="12" rx="5" fill="#F97316"/>
            <rect x="14" y="6" width="4" height="12" rx="2" fill="#F97316"/>
            <rect x="36" y="6" width="4" height="12" rx="2" fill="#F97316"/>
            <circle cx="46" cy="44" r="12" fill="#fff" stroke="#F97316" stroke-width="2.5"/>
            <line x1="46" y1="38" x2="46" y2="44" stroke="#F97316" stroke-width="2" stroke-linecap="round"/>
            <line x1="46" y1="44" x2="51" y2="47" stroke="#F97316" stroke-width="2" stroke-linecap="round"/>
            <circle cx="18" cy="32" r="2.5" fill="#F97316"/>
            <circle cx="27" cy="32" r="2.5" fill="#F97316"/>
            <circle cx="18" cy="41" r="2.5" fill="#F97316"/>
            <circle cx="27" cy="41" r="2.5" fill="#F97316"/>
          </svg>
        </div>
        <h3 class="reason-title">完全個別指導 ×<br>自由な時間割</h3>
        <p class="reason-body">月ごとにスケジュールをカスタマイズ。部活・習い事との両立が可能です。15:00〜22:00の間で通塾時間を自由に設定できます。</p>
      </div>
      <div class="reason-card">
        <div class="reason-num">02</div>
        <div class="reason-icon">
          <!-- 本＋稲妻：5教科＋速読解力 -->
          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="8" y="10" width="30" height="40" rx="3" fill="#FEF3C7" stroke="#F97316" stroke-width="2.5"/>
            <rect x="8" y="10" width="30" height="40" rx="3" fill="none" stroke="#F97316" stroke-width="2.5"/>
            <line x1="16" y1="22" x2="30" y2="22" stroke="#F97316" stroke-width="2" stroke-linecap="round"/>
            <line x1="16" y1="29" x2="30" y2="29" stroke="#F97316" stroke-width="2" stroke-linecap="round"/>
            <line x1="16" y1="36" x2="24" y2="36" stroke="#F97316" stroke-width="2" stroke-linecap="round"/>
            <path d="M38 8 L28 32 H38 L26 56 L52 24 H40 L50 8 Z" fill="#FBBF24" stroke="#F97316" stroke-width="2" stroke-linejoin="round"/>
          </svg>
        </div>
        <h3 class="reason-title">5教科 ＋ 速読解力の<br>一体型学習</h3>
        <p class="reason-body">5教科の学習に加え、速読解力講座で「読む力」を底上げ。読む力が上がると、全科目の理解力・得点力が向上します。</p>
      </div>
      <div class="reason-card">
        <div class="reason-num">03</div>
        <div class="reason-icon">
          <!-- 電球＋歯車：エンジニアが教える -->
          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="28" cy="24" r="14" fill="#FEF3C7" stroke="#F97316" stroke-width="2.5"/>
            <path d="M22 34 Q22 40 28 40 Q34 40 34 34" fill="#FEF3C7" stroke="#F97316" stroke-width="2" stroke-linecap="round"/>
            <line x1="24" y1="40" x2="32" y2="40" stroke="#F97316" stroke-width="2" stroke-linecap="round"/>
            <line x1="25" y1="44" x2="31" y2="44" stroke="#F97316" stroke-width="2" stroke-linecap="round"/>
            <path d="M28 18 L26 24 H30 L27 30" stroke="#F97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="48" cy="46" r="8" fill="#FEF3C7" stroke="#F97316" stroke-width="2"/>
            <circle cx="48" cy="46" r="3" fill="#F97316"/>
            <rect x="46" y="36" width="4" height="4" rx="1" fill="#F97316"/>
            <rect x="46" y="52" width="4" height="4" rx="1" fill="#F97316"/>
            <rect x="36" y="44" width="4" height="4" rx="1" fill="#F97316"/>
            <rect x="52" y="44" width="4" height="4" rx="1" fill="#F97316"/>
          </svg>
        </div>
        <h3 class="reason-title">現場経験20年のエンジニアが<br>「なぜ？」から教える</h3>
        <p class="reason-body">電子工学修士・認定心理士でもある塾長が指導。答えを与えるのではなく、自分で考えられるようになる授業が特長です。</p>
      </div>
    </div>
  </div>
</section>

<!-- wave: #FFF7ED → #1c1917 -->
<div class="wave-divider" style="background:#FFF7ED;">
  <svg viewBox="0 0 1440 56" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,0 C360,56 1080,0 1440,40 L1440,56 L0,56 Z" fill="#1c1917"/>
  </svg>
</div>
<!-- ============================================================
   3.5 VACANCY（残り募集枠）
   ★ 空き数が変わったら vacancy-count の数字と vacancy-bar-fill の width を更新
============================================================ -->
<?php
// ★ 空き数をここで管理（満席は 0）
// level: 'ok'=余裕あり(4名以上) / 'warn'=残りわずか(2〜3名) / 'urgent'=残りわずか(1名) / 'full'=満席
$vacancy = [
  ['grade' => '小1〜小3', 'left' => 1, 'total' => 2],
  ['grade' => '小4〜小6', 'left' => 2, 'total' => 6],
  ['grade' => '中学1年',  'left' => 4, 'total' => 6],
  ['grade' => '中学2年',  'left' => 2, 'total' => 6],
  ['grade' => '中学3年',  'left' => 3, 'total' => 6],
];
?>
<section class="vacancy-section" id="vacancy">
  <div class="container">
    <div class="vacancy-lead">
      <div class="vacancy-lead-label">Availability</div>
      <h2 class="vacancy-lead-title">現在の<em>残り募集枠</em></h2>
      <p class="vacancy-lead-note">各学年ごとに人数を限定した少人数制です。お早めにご検討ください。</p>
    </div>
    <div class="vacancy-grid">
      <?php foreach ($vacancy as $v):
        if ($v['left'] === 0)     { $level = 'full';   $pct = 100; }
        elseif ($v['left'] === 1) { $level = 'urgent'; $pct = 85; }
        elseif ($v['left'] <= 3)  { $level = 'warn';   $pct = 60; }
        else                      { $level = 'ok';     $pct = 25; }
        $status_text = [
          'ok'     => '受付中',
          'warn'   => '残りわずか',
          'urgent' => '残り1名',
          'full'   => '受付停止中',
        ][$level];
      ?>
      <div class="vacancy-card">
        <div class="vacancy-grade"><?php echo $v['grade']; ?></div>
        <?php if ($level === 'full'): ?>
          <div class="vacancy-count full">満席</div>
        <?php else: ?>
          <div class="vacancy-count <?php echo $level !== 'ok' ? $level : ''; ?>">
            <?php echo $v['left']; ?><small style="font-size:14px;font-weight:400;">名</small>
          </div>
        <?php endif; ?>
        <div class="vacancy-status <?php echo $level; ?>"><?php echo $status_text; ?></div>
        <div class="vacancy-bar">
          <div class="vacancy-bar-fill <?php echo $level !== 'ok' ? $level : ''; ?>" style="width:<?php echo $pct; ?>%;"></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- 制限なしコース -->
    <div class="vacancy-unlimited">
      <div class="vacancy-unlimited-item">
        <strong>プログラミングコース</strong>
        <span class="vacancy-unlimited-badge">随時受付中</span>
        <span>人数制限なし</span>
      </div>
      <div class="vacancy-unlimited-item">
        <strong>読解力・国語力コース</strong>
        <span class="vacancy-unlimited-badge">随時受付中</span>
        <span>人数制限なし</span>
      </div>
    </div>

    <div class="vacancy-cta">
      <a href="https://lin.ee/7NV1Pld" target="_blank" rel="noopener">
        💬 空き状況をLINEで確認する
      </a>
    </div>
  </div>
</section>

<!-- wave: #1c1917 → white -->
<div class="wave-divider" style="background:#1c1917;">
  <svg viewBox="0 0 1440 56" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,40 C480,0 960,56 1440,20 L1440,56 L0,56 Z" fill="#ffffff"/>
  </svg>
</div>
<!-- ============================================================
   4. CONCEPT（塾のコンセプト）
============================================================ -->
<section class="section" id="concept">
  <div class="container">
    <div class="text-center">
      <span class="section-label">塾のコンセプト</span>
      <h2 class="section-title">「時代に左右されない能力」を<br><em>この塾で鍛える</em></h2>
      <p class="section-subtitle">10年後・20年後も通用する力は、特別な才能ではなく<br>正しい学習習慣と思考の積み重ねで育てられます。</p>
    </div>
    <div class="concept-grid">
      <div class="concept-item">
        <div class="concept-num">1</div>
        <div class="concept-title">自立学習力</div>
        <div class="concept-body">「教えてもらわないとわからない」から卒業。自分で調べ、自分で考えて進める力を育てます。</div>
      </div>
      <div class="concept-item">
        <div class="concept-num">2</div>
        <div class="concept-title">情報収集・整理力</div>
        <div class="concept-body">あふれる情報の中から必要なものを選び取り整理する力は、AI時代に最も求められるスキルです。</div>
      </div>
      <div class="concept-item">
        <div class="concept-num">3</div>
        <div class="concept-title">論理思考力</div>
        <div class="concept-body">「なぜそうなるのか」を原理から理解する習慣が、どんな科目にも応用できる思考の土台になります。</div>
      </div>
    </div>
    <div class="concept-note">
      小学校でのプログラミング教育が始まった目的の一つは<br>
      「論理的思考力・創造性・問題解決能力などの育成」です。<br>
      <strong>Furuki塾は開塾当初から、この力を育てることを授業の中心に置いています。</strong>
    </div>
  </div>
</section>

<!-- wave: white → #FFF7ED -->
<div class="wave-divider" style="background:#ffffff;">
  <svg viewBox="0 0 1440 56" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,28 C360,0 720,56 1080,20 C1200,8 1320,40 1440,28 L1440,56 L0,56 Z" fill="#FFF7ED"/>
  </svg>
</div>
<!-- ============================================================
   5. TEACHER PROFILE（塾長について）
============================================================ -->
<section class="section section-alt" id="teacher">
  <div class="container">
    <div class="text-center" style="margin-bottom:40px;">
      <span class="section-label">塾長について</span>
      <h2 class="section-title">「教える」より<br><em>「考える力を引き出す」</em></h2>
    </div>
    <div class="teacher-card">
      <div class="teacher-sidebar">
        <div class="teacher-avatar">
          <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/teacher-chara-final.png'); ?>"
               alt="古澤塾長キャラクター">
        </div>
        <div class="teacher-name">古澤 塾長</div>
        <div class="teacher-role">Furuki塾<br>江東住吉教室</div>
      </div>
      <div class="teacher-content">
        <h3 class="teacher-headline">
          <em>「自分で考える力」</em>こそが、<br>どんな時代でも一番の武器になる。
        </h3>
        <p class="teacher-bio">
          朝日新聞奨学生として自ら働きながら大学へ進み、電子工学の修士号を取得
          苦労して学んだその経験が、「自分で道を切り拓く力」の大切さを体で教えてくれました。<br><br>
          その後20年以上、現役エンジニアとして開発の第一線に携わり続けました。
          さらに認定心理士の資格も取得し、子どもの学習心理についても深く学びました。<br><br>
          「答えを教えるのではなく、答えを導き出す考え方を育てたい」——
          その想いを胸に、2021年にFuruki塾を開塾しました。<br><br>
          <em style="color:var(--orange);font-style:normal;">10年後・20年後に「通っていてよかった」と思ってもらえる塾を目指しています。</em>
        </p>
        <div class="teacher-tags">
          <span class="teacher-tag">電子工学修士</span>
          <span class="teacher-tag">認定心理士</span>
          <span class="teacher-tag">エンジニア歴20年以上</span>
          <span class="teacher-tag">朝日新聞奨学生出身</span>
          <span class="teacher-tag">2021年開塾</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- wave: #FFF7ED → #FEF3C7 -->
<div class="wave-divider" style="background:#FFF7ED;">
  <svg viewBox="0 0 1440 56" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,20 C480,56 960,0 1440,36 L1440,56 L0,56 Z" fill="#FEF3C7"/>
  </svg>
</div>
<!-- ============================================================
   5.5 USAGE（こんな使い方ができます）
============================================================ -->
<section class="section usage-section" id="usage">
  <div class="container">
    <div class="text-center">
      <span class="section-label">自由な学び方</span>
      <h2 class="section-title">1回の通塾で、<br><em>何でもできます</em></h2>
      <p class="section-subtitle">「今日は何をするか」をお子さん自身が決められる。それがFuruki塾のスタイルです。</p>
    </div>
    <div class="usage-grid">
      <div class="usage-card">
        <div class="usage-icon">📚</div>
        <div>
          <div class="usage-title">学校の宿題を進める</div>
          <div class="usage-body">わからない問題はその場で解決。宿題を終わらせながら、理解を深められます。</div>
        </div>
      </div>
      <div class="usage-card">
        <div class="usage-icon">🔭</div>
        <div>
          <div class="usage-title">次の単元を予習する</div>
          <div class="usage-body">授業の前に基礎を固めておくことで、学校の授業が格段にわかりやすくなります。</div>
        </div>
      </div>
      <div class="usage-card">
        <div class="usage-icon">🔄</div>
        <div>
          <div class="usage-title">テスト前に集中して復習</div>
          <div class="usage-body">定期テストの2週前から対策開始。苦手な単元を集中的に仕上げられます。</div>
        </div>
      </div>
      <div class="usage-card">
        <div class="usage-icon">🏆</div>
        <div>
          <div class="usage-title">英検・漢検・数検の対策</div>
          <div class="usage-body">各種検定の対策も通常の通塾時間内で対応。別途費用はかかりません。</div>
        </div>
      </div>
      <div class="usage-card">
        <div class="usage-icon">🎯</div>
        <div>
          <div class="usage-title">苦手科目を集中的に克服</div>
          <div class="usage-body">「数学だけ徹底的にやりたい」そんな希望にも柔軟に対応します。</div>
        </div>
      </div>
      <div class="usage-card">
        <div class="usage-icon">📖</div>
        <div>
          <div class="usage-title">複数科目をまとめて学ぶ</div>
          <div class="usage-body">1回の通塾で2〜3教科を並行して進めることも可能。効率よく成績を上げられます。</div>
        </div>
      </div>
    </div>
    <p class="usage-note">「何をするか」はその日の状況に合わせてOK。<strong>決まったカリキュラムに縛られない</strong>のがFuruki塾の強みです。</p>
  </div>
</section>

<!-- wave: #FEF3C7 → white -->
<div class="wave-divider" style="background:#FEF3C7;">
  <svg viewBox="0 0 1440 56" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,36 C360,0 1080,56 1440,20 L1440,56 L0,56 Z" fill="#ffffff"/>
  </svg>
</div>
<!-- ============================================================
   6. COURSES（コース紹介）
============================================================ -->
<section class="section" id="courses">
  <div class="container">
    <div class="text-center">
      <span class="section-label">コース紹介</span>
      <h2 class="section-title">お子さんに合った<br><em>学び方</em>を選べます</h2>
    </div>
    <div style="margin-top:40px;">
      <div class="course-tabs">
        <button class="course-tab active" onclick="showCourse('5kyoka', this)">📚 5教科学習コース</button>
        <button class="course-tab" onclick="showCourse('sokudoku', this)">⚡ 速読解力講座</button>
      </div>

      <!-- 5教科学習 -->
      <div id="course-5kyoka" class="course-detail active">
        <div class="course-card">
          <div class="course-header">
            <div class="course-icon">📚</div>
            <div>
              <div class="course-header-title">5教科学習コース</div>
              <div class="course-header-sub">小学1年生 〜 中学3年生 ／ 完全個別指導</div>
            </div>
          </div>
          <div class="course-body">
            <div class="course-for">
              <div class="course-for-label">👇 こんなお子さんにおすすめ</div>
              <ul class="course-for-list">
                <li>定期テストで点数を上げたい</li>
                <li>苦手科目を克服したい</li>
                <li>高校受験に向けて準備したい</li>
                <li>自分のペースで着実に学びたい</li>
              </ul>
            </div>
            <ul class="course-features">
              <li>完全個別指導 ——一人ひとりのペース・理解度に合わせた授業です</li>
              <li>月ごとのスケジュールカスタマイズで部活・行事にも対応</li>
              <li>自習席を無料で利用可能。学習習慣づくりもサポートします</li>
              <li>中学生は通い放題プランあります。受験直前まで徹底サポート</li>
              <li>速読解力講座（読む力の強化）を授業に組み込んでいます（小1〜小3除く）</li>
            </ul>
            <div>
              <p style="font-size:13px;font-weight:700;color:var(--text-muted);margin-bottom:8px;">指導科目</p>
              <div class="course-subjects">
                <span class="subject-tag">算数・数学</span>
                <span class="subject-tag">国語</span>
                <span class="subject-tag">英語</span>
                <span class="subject-tag">理科（小3〜）</span>
                <span class="subject-tag">社会（小3〜）</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 速読解力講座 -->
      <div id="course-sokudoku" class="course-detail">
        <div class="course-card">
          <div class="course-header course-header-amber">
            <div class="course-icon">⚡</div>
            <div>
              <div class="course-header-title">速読解力講座</div>
              <div class="course-header-sub">小学1年生 〜 中学3年生</div>
            </div>
          </div>
          <div class="course-body">
            <p style="font-size:15px;line-height:1.85;color:var(--text);margin-bottom:24px;">
              Furuki塾では、一般社団法人 <strong>日本速読解力協会</strong> の講座を導入しています。<br>
              25年以上の研究と脳科学に基づいたトレーニングで、「速く・正確に読む力」を養います。<br>
              読解力が上がると、国語だけでなく<strong>全科目の得点力</strong>が向上します。
            </p>

            <!-- バナー2枚横並び -->
            <div class="sokudoku-banners">
              <!-- 公式サイトバナー -->
              <div class="sokudoku-banner-wrap">
                <a href="https://www.sokunousokudoku.net/" target="_blank" rel="noopener noreferrer"
                   class="sokudoku-banner-link">
                  <?php
                    $banner_img = get_template_directory_uri() . '/assets/images/sokudoku-banner.png';
                    if ( file_exists( get_template_directory() . '/assets/images/sokudoku-banner.png' ) ) :
                  ?>
                    <img src="<?php echo esc_url($banner_img); ?>"
                         alt="日本速読解力協会 公式サイト"
                         style="width:100%;display:block;">
                  <?php else : ?>
                    <div class="sokudoku-placeholder">
                      <span style="font-size:28px;">⚡</span>
                      <span>日本速読解力協会 公式サイトへ</span>
                    </div>
                  <?php endif; ?>
                </a>
                <p class="sokudoku-link-label">🔗 日本速読解力協会 公式サイト（外部リンク）</p>
              </div>
              <!-- よみとくんバナー -->
              <div class="sokudoku-banner-wrap">
                <a href="https://www.sokunousokudoku.net/yomitokun/" target="_blank" rel="noopener noreferrer"
                   class="sokudoku-banner-link">
                  <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/yomitoku-banner.png'); ?>"
                       alt="読解問題よみとくん - 基礎的読解力をチェック"
                       style="width:100%;display:block;">
                </a>
                <p class="sokudoku-link-label">🔗 よみとくん（外部リンク・無料）</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
   7. SCHEDULE（通塾の柔軟さ）
============================================================ -->
<section class="section section-alt" id="schedule">
  <div class="container">
    <div class="text-center">
      <span class="section-label">通塾スケジュール</span>
      <h2 class="section-title">部活も習い事も、<br><em>諦めなくていい</em></h2>
      <p class="section-subtitle" style="margin-top:16px;">
        開塾時間は平日15:00〜22:00。月ごとにスケジュールを自由に組めます。<br>
        実際に通っているお子さんの例をご覧ください。
      </p>
    </div>
    <div class="schedule-cards" style="margin-top:40px;">
      <div class="schedule-example">
        <div class="schedule-head">例① 小学5年生 / 週2回</div>
        <table class="schedule-table">
          <tr><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th></tr>
          <tr>
            <td>—</td>
            <td class="on">16:30<br>〜18:00</td>
            <td>—</td>
            <td class="on">16:30<br>〜18:00</td>
            <td>—</td>
          </tr>
        </table>
      </div>
      <div class="schedule-example">
        <div class="schedule-head">例② 中学2年生 / 週3回（部活あり）</div>
        <table class="schedule-table">
          <tr><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th></tr>
          <tr>
            <td class="on">19:00<br>〜21:00</td>
            <td>—</td>
            <td class="on">17:00<br>〜19:00</td>
            <td>—</td>
            <td class="on">19:00<br>〜21:00</td>
          </tr>
        </table>
      </div>
      <div class="schedule-example">
        <div class="schedule-head">例③ 中学3年生 / 通い放題</div>
        <table class="schedule-table">
          <tr><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th></tr>
          <tr>
            <td class="on">17:00<br>〜20:00</td>
            <td class="on">17:00<br>〜20:00</td>
            <td>—</td>
            <td class="on">17:00<br>〜20:00</td>
            <td class="on">17:00<br>〜20:00</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="schedule-tip">
      <div class="schedule-tip-icon">💡</div>
      <p class="schedule-tip-text">
        定期テスト前や行事が重なる月は、スケジュールを調整してOKです。<br>
        「今月は部活が忙しい」という相談も大歓迎。塾長と一緒に、無理のないプランを一から考えます。
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
   8. TESTIMONIALS（保護者・生徒の声）
============================================================ -->
<section class="section" id="voice">
  <div class="container">
    <div class="text-center">
      <span class="section-label">保護者・生徒の声</span>
      <h2 class="section-title">通ってよかった、<br><em>という声をいただいています</em></h2>
    </div>
    <div class="testimonials-grid">
      <!--
        TODO: 声が集まり次第、以下のカードを実際のものに差し替えてください。
        1枚のカード構成:
        <div class="t-card">
          <div class="t-quote">"</div>
          <p class="t-text">（具体的なエピソード）</p>
          <div class="t-author">
            <div class="t-avatar">👩</div>
            <div>
              <div class="t-name">保護者のお名前（イニシャル可）</div>
              <div class="t-meta">中2 / 5教科学習コース など</div>
            </div>
          </div>
        </div>
      -->
      <div class="t-card">
        <div class="t-quote">"</div>
        <p class="t-text">個別指導なので、子どもが「わからない」と言いやすい雰囲気が良かったです。集団塾では手が挙げられなかった子が、自分から質問するようになりました。</p>
        <div class="t-author">
          <div class="t-avatar">👩</div>
          <div>
            <div class="t-name">保護者の方（小5・お子さん）</div>
            <div class="t-meta">5教科学習コース受講</div>
          </div>
        </div>
      </div>
      <div class="t-card">
        <div class="t-quote">"</div>
        <p class="t-text">スケジュールが自由なので、部活と無理なく両立できています。テスト前には集中して通えるのが本当に助かります。</p>
        <div class="t-author">
          <div class="t-avatar">🙋</div>
          <div>
            <div class="t-name">中学2年生（生徒）</div>
            <div class="t-meta">5教科学習コース受講</div>
          </div>
        </div>
      </div>
      <div class="t-card">
        <div class="t-quote">"</div>
        <p class="t-text">（体験談募集中）より多くの声を集めています。ご協力いただける方はLINEよりご連絡ください。</p>
        <div class="t-author">
          <div class="t-avatar">👤</div>
          <div>
            <div class="t-name">近日公開予定</div>
            <div class="t-meta">保護者・生徒の方</div>
          </div>
        </div>
      </div>
    </div>
    <div class="t-note">
      現在、より多くの声を募集しています。<br>
      通塾中で掲載にご協力いただける方は、<strong>LINEにてご連絡ください</strong>。
    </div>
  </div>
</section>

<!-- ============================================================
   9. PRICING（料金）
============================================================ -->
<section class="section section-alt" id="pricing">
  <div class="container">
    <div class="text-center">
      <span class="section-label">料金のご案内</span>
      <h2 class="section-title">明確な料金設定で<br><em>安心して通えます</em></h2>
    </div>

    <!-- タブ -->
    <div class="pricing-tabs" role="tablist">
      <button class="pricing-tab active" onclick="switchPricingTab(this,'tab-elem')"   role="tab">5教科（小学生）</button>
      <button class="pricing-tab"        onclick="switchPricingTab(this,'tab-chugaku')" role="tab">5教科（中学生）</button>
      <button class="pricing-tab"        onclick="switchPricingTab(this,'tab-dokkai')"  role="tab">読解力・国語力</button>
      <button class="pricing-tab"        onclick="switchPricingTab(this,'tab-prog')"    role="tab">プログラミング</button>
    </div>

    <!-- 小学生 -->
    <div id="tab-elem" class="pricing-panel active">
      <p class="pricing-tax-note">※ すべて税込・月額表記です</p>
      <div class="pricing-table-wrap">
        <table class="pricing-table">
          <thead>
            <tr>
              <th>学年</th><th>授業時間</th>
              <th>週1回<br><small>算数のみ</small></th>
              <th>週2回<br><small>算数＋国語</small></th>
              <th>週3回<br><small>3教科以上</small></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="lbl">小1〜小3</td><td>60分</td>
              <td class="hl">11,000円 <small>※1</small></td>
              <td class="hl">16,500円</td>
              <td>—</td>
            </tr>
            <tr>
              <td class="lbl">小4〜小6</td><td>90分</td>
              <td class="hl">14,300円</td>
              <td class="hl">19,800円</td>
              <td class="hl">22,000円</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="pricing-note">※1 小1〜小3の週1回コースには読解力講座が含まれません。読解力を加える場合は週2回コースになります。</p>
    </div>

    <!-- 中学生 -->
    <div id="tab-chugaku" class="pricing-panel">
      <p class="pricing-tax-note">※ すべて税込・月額表記です</p>
      <div class="pricing-table-wrap">
        <table class="pricing-table">
          <thead>
            <tr>
              <th>学年</th><th>授業時間</th>
              <th>週1回</th>
              <th>週2回</th>
              <th>通い放題<br><small>1日4時間まで</small></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="lbl">中1・中2</td><td>120分</td>
              <td class="hl">19,800円</td>
              <td class="hl">28,600円</td>
              <td class="hl">37,950円</td>
            </tr>
            <tr>
              <td class="lbl">中3</td><td>120分</td>
              <td>—</td>
              <td class="hl">33,000円</td>
              <td class="hl">42,900円</td>
            </tr>
            <tr>
              <td class="lbl">中3<br><small>春期講習以降入塾</small></td><td>120分</td>
              <td>—</td><td>—</td>
              <td class="hl">55,000円〜<br><small>（応相談）</small></td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="pricing-note">◎ 定期テスト対策講座：各学校の定期テスト2週前より開始。通常授業に加えてご利用いただけます。<br>
      ◎ 高校生コースは中学から継続通塾の生徒さんのみ対応。新規の方はお気軽にご相談ください。料金は個別にご案内します。</p>
    </div>

    <!-- 読解力 -->
    <div id="tab-dokkai" class="pricing-panel">
      <p class="pricing-tax-note">※ すべて税込・月額表記です</p>
      <div class="pricing-table-wrap">
        <table class="pricing-table">
          <thead>
            <tr><th>学年</th><th>授業時間</th><th>月4回</th><th>月8回</th></tr>
          </thead>
          <tbody>
            <tr>
              <td class="lbl">小1〜中3</td><td>50分</td>
              <td class="hl">9,900円</td>
              <td class="hl">14,300円</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="pricing-note">読解力・国語力を集中的に伸ばしたい方向けのコースです。5教科コースと組み合わせることもできます。</p>
    </div>

    <!-- プログラミング -->
    <div id="tab-prog" class="pricing-panel">
      <p class="pricing-tax-note">※ すべて税込・月額表記です</p>
      <div class="pricing-table-wrap">
        <table class="pricing-table">
          <thead>
            <tr><th>授業時間</th><th>月2回</th><th>月4回</th></tr>
          </thead>
          <tbody>
            <tr><td class="lbl">60分</td><td>—</td><td class="hl">16,500円</td></tr>
            <tr><td class="lbl">120分</td><td class="hl">12,100円</td><td class="hl">23,100円</td></tr>
          </tbody>
        </table>
      </div>
      <p class="pricing-note">プログラミングコースの詳細は専用ページをご覧ください。5教科コースとの併用も可能です。</p>
    </div>

    <!-- 共通費用 -->
    <div class="pricing-extras">
      <div class="pricing-extra">
        <strong>入塾金</strong>
        全学年・全コース 22,000円（税込）<br>
        兄弟姉妹の同時入塾は全員で22,000円。同時でない場合は2人目以降11,000円/人
      </div>
      <div class="pricing-extra">
        <strong>兄弟姉妹割引</strong>
        同時通塾の場合、2人目のお子さまの受講費（低い方）から<strong>20%割引</strong>
      </div>
      <div class="pricing-extra">
        <strong>システム利用料</strong>
        毎月 3,300円（税込）
      </div>
      <div class="pricing-extra">
        <strong>教材費</strong>
        実費負担<br>各生徒の進捗に合わせた教材をご提案します。
      </div>
      <div class="pricing-extra">
        <strong>自習席</strong>
        無料で利用可能<br>小4以上（2〜3教科コース）は20時まで、中学生は開塾時間中いつでも利用可
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
   10. FAQ
============================================================ -->
<section class="section" id="faq">
  <div class="container">
    <div class="text-center">
      <span class="section-label">よくある質問</span>
      <h2 class="section-title">気になること、<br><em>まとめて答えます</em></h2>
    </div>
    <div class="faq-list">
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <div class="faq-q-badge">Q</div>
          <div class="faq-q-text">無料体験はいつでも受けられますか？</div>
          <span class="faq-chevron">▼</span>
        </div>
        <div class="faq-a">はい、随時受け付けています。まずはLINEまたはフォームからご連絡ください。日程はお子さんのご都合に合わせて調整します。</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <div class="faq-q-badge">Q</div>
          <div class="faq-q-text">途中でコース変更・追加はできますか？</div>
          <span class="faq-chevron">▼</span>
        </div>
        <div class="faq-a">もちろん可能です。5教科学習コースに速読解力講座を追加したり、週の回数を変更したりと、お子さんの状況に合わせて柔軟に対応します。</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <div class="faq-q-badge">Q</div>
          <div class="faq-q-text">兄弟・姉妹で一緒に通えますか？</div>
          <span class="faq-chevron">▼</span>
        </div>
        <div class="faq-a">はい。兄弟姉妹割引があります。同時入塾の場合は全員で入塾金22,000円。2人目以降の入塾でも11,000円/人に割引されます。</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <div class="faq-q-badge">Q</div>
          <div class="faq-q-text">定期テスト前に特別な対応はありますか？</div>
          <span class="faq-chevron">▼</span>
        </div>
        <div class="faq-a">はい。テスト前には通塾日を増やすなど柔軟に対応しています。中学生向けには「定期テストまでサポート込みのプラン」も用意しています（季節講習時）。</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <div class="faq-q-badge">Q</div>
          <div class="faq-q-text">学校になかなか行けない時期でも通えますか？</div>
          <span class="faq-chevron">▼</span>
        </div>
        <div class="faq-a"><span class="hl">はい、ぜひご相談ください。</span>お子さんの状況を丁寧に伺った上で、無理のない通い方を一緒に考えます。まずはLINEまたはフォームからお気軽にご連絡ください。</div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <div class="faq-q-badge">Q</div>
          <div class="faq-q-text">入塾前に後悔しないか不安です</div>
          <span class="faq-chevron">▼</span>
        </div>
        <div class="faq-a">まずは無料体験で、授業の雰囲気・塾長の教え方を実際に体験してからご判断ください。無理な勧誘は一切行っておりません。「相談だけ」でも大歓迎です。</div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
   11. CTA（メインコンバージョン）
============================================================ -->
<section class="cta-section" id="cta">
  <div class="container">
    <h2 class="cta-title">
      まず、<em>一歩</em>踏み出してみませんか？<br>
      無料体験、随時受付中です。
    </h2>
    <p class="cta-sub">
      「相談だけ」でも大丈夫。お子さんの勉強のお悩みを<br>
      気軽に話しかけてください。
    </p>
    <div class="cta-btn-group">
      <a href="https://lin.ee/7NV1Pld" class="cta-line-btn">
        💬 LINEで無料体験に申し込む
      </a>
      <a href="<?php echo home_url("/contact/"); ?>" class="cta-form-btn">
        📝 フォームでお問い合わせ
      </a>
      <p class="cta-tel">
        お電話でも受け付けています　
        <a href="tel:0367706936">03-6770-6936</a>
      </p>
      <p class="cta-meta">
        受付時間：平日 15:00〜22:00（土日祝休み）<br>
        ※ 無理な勧誘は一切ありません
      </p>
    </div>
    <!-- 不登校・通いにくい方への配慮ライン -->
    <div style="text-align:center;margin-top:36px;">
      <div class="cta-unschool">
        <strong>通い方に不安がある方も、まずはご相談ください。</strong>
        学校の状況や生活リズムに合わせて、一緒に無理のない学習プランを考えます。
        お気軽にLINEまたはフォームからお声がけください。
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
   12. ACCESS（教室案内）
============================================================ -->
<section class="section" id="access">
  <div class="container">
    <div class="text-center">
      <span class="section-label">教室のご案内</span>
      <h2 class="section-title">Furuki塾<br><em>江東住吉教室</em></h2>
    </div>
    <!-- 地図2枚並び -->
    <div class="access-maps-grid">
      <!-- 周辺案内図（カスタム画像） -->
      <div class="access-map-card">
        <div class="access-map-card-header">周辺案内図</div>
        <?php
          $map_image = get_template_directory_uri() . '/assets/images/map_furuki-juku.png';
          if ( file_exists( get_template_directory() . '/assets/images/map_furuki-juku.png' ) ) :
        ?>
          <img src="<?php echo esc_url( $map_image ); ?>" alt="Furuki塾 周辺地図">
        <?php else : ?>
          <div style="height:280px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;background:#fafaf9;color:#a8a29e;font-size:13px;padding:24px;text-align:center;">
            <span style="font-size:40px;">🗺️</span>
            <p>周辺案内図<br>（画像を <code>assets/images/map_furuki-juku.png</code> に配置してください）</p>
          </div>
        <?php endif; ?>
      </div>
      <!-- Google マップ -->
      <div class="access-map-card">
        <div class="access-map-card-header google">Google マップ</div>
        <div class="access-map-iframe-wrap">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6481.60952027972!2d139.8142867!3d35.6818091!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018893f3f884b41%3A0xf3a175abf6d924a2!2zRnVydWtp5aG-!5e0!3m2!1sja!2sjp!4v1775175504227!5m2!1sja!2sjp"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            title="Furuki塾江東住吉教室 地図">
          </iframe>
        </div>
      </div>
    </div>

    <!-- アクセス情報 -->
    <div class="access-info-row">
      <div class="access-info-item">
        <div class="access-info-icon">🚌</div>
        <div>
          <div class="access-info-label">バス・電車</div>
          <div class="access-info-value">都営バス「千田」停 徒歩約2分<br>東西線 東陽町駅<br>半蔵門線・都営新宿線 住吉駅</div>
        </div>
      </div>
      <div class="access-info-item">
        <div class="access-info-icon">🏫</div>
        <div>
          <div class="access-info-label">目印</div>
          <div class="access-info-value">石島交差点そば<br>江東区役所小松橋出張所 近く<br>丸万マンダリンハイム1F</div>
        </div>
      </div>
      <div class="access-info-item">
        <div class="access-info-icon">🕐</div>
        <div>
          <div class="access-info-label">受付時間</div>
          <div class="access-info-value">平日 15:00〜21:30<br>土・日・祝 休塾<br><small style="color:var(--text-light);">※定期テスト前は開塾することがあります</small></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
   13. INSTAGRAM FEED
============================================================ -->
<section class="section" style="background:#fff8f0;" id="instagram">
  <div class="container">
    <div class="text-center" style="margin-bottom:32px;">
      <span class="section-label">Instagram</span>
      <h2 class="section-title">塾の日常を<br><em>Instagramで発信中</em></h2>
      <p class="section-desc">授業の様子・合格報告・イベント情報などをお届けしています</p>
    </div>
    <?php echo do_shortcode('[instagram-feed feed=1]'); ?>
    <div class="text-center" style="margin-top:24px;">
      <a href="https://www.instagram.com/furukijuku" target="_blank" rel="noopener noreferrer"
         style="display:inline-flex;align-items:center;gap:8px;color:var(--navy);font-weight:700;font-size:15px;text-decoration:none;">
        <span style="font-size:20px;">📷</span> @furukijuku をフォローする
      </a>
    </div>
  </div>
</section>

<!-- ============================================================
   14. FOOTER
============================================================ -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">
          <img src="<?php echo esc_url($furuki_uri_kanban); ?>" alt="Furuki塾" class="footer-logo-mark pixel-art-img" width="56" height="56" decoding="async">
          <div class="footer-brand-text">
            <div class="footer-logo">Furuki塾</div>
            <p class="footer-tagline">時代に左右されない能力を身につけよう。</p>
          </div>
        </div>
        <p class="footer-capsule-wrap">
          <img src="<?php echo esc_url($furuki_uri_capsule); ?>" alt="小中学生向け プログラム・学習塾 Furuki塾" class="footer-capsule-img pixel-art-img" decoding="async">
        </p>
        <p style="font-size:13px;color:#A8A29E;line-height:1.9;">
          〒135-0013<br>
          東京都江東区千田11-13 丸万マンダリンハイム1F<br>
          TEL: <a href="tel:0367706936" style="color:#A8A29E;">03-6770-6936</a><br>
          平日 15:00〜22:00（土日祝休み）
        </p>
      </div>
      <div>
        <div class="footer-col-title">メニュー</div>
        <ul class="footer-links">
          <li><a href="#reasons">選ばれる理由</a></li>
          <li><a href="#concept">塾のコンセプト</a></li>
          <li><a href="#teacher">塾長について</a></li>
          <li><a href="#courses">コース紹介</a></li>
          <li><a href="#pricing">料金のご案内</a></li>
          <li><a href="#faq">よくある質問</a></li>
          <li><a href="#access">アクセス</a></li>
        </ul>
      </div>
      <div>
        <div class="footer-col-title">お問い合わせ</div>
        <ul class="footer-links">
          <li><a href="https://lin.ee/7NV1Pld">LINEで相談する</a></li>
          <li><a href="<?php echo home_url("/contact/"); ?>">お問い合わせフォーム</a></li>
          <li><a href="tel:0367706936">03-6770-6936</a></li>
        </ul>
        <div class="footer-social">
          <a href="https://www.instagram.com/furukijuku" target="_blank" rel="noopener noreferrer">
            <span class="ig-icon">
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
              </svg>
            </span>
            @furukijuku
          </a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p class="footer-copy">© 2021 Furuki塾江東住吉教室 All Rights Reserved.</p>
    </div>
  </div>
</footer>

<!-- ============================================================
   JavaScript
============================================================ -->
<script>
/* お知らせバー 閉じる */
function closeAnnouncement(id) {
  var el = document.getElementById(id);
  if (el) {
    el.style.transition = 'opacity .2s, max-height .3s';
    el.style.opacity = '0';
    el.style.maxHeight = '0';
    el.style.overflow = 'hidden';
    el.style.padding = '0';
    setTimeout(function() { el.remove(); }, 350);
  }
}

/* ナビゲーション ハンバーガー */
function toggleNavMenu(btn) {
  btn.classList.toggle('open');
  document.getElementById('navMobileMenu').classList.toggle('open');
}
function closeNavMenu() {
  document.querySelector('.nav-hamburger').classList.remove('open');
  document.getElementById('navMobileMenu').classList.remove('open');
}

/* 料金タブ切り替え */
function switchPricingTab(btn, panelId) {
  document.querySelectorAll('.pricing-tab').forEach(function(t) { t.classList.remove('active'); });
  document.querySelectorAll('.pricing-panel').forEach(function(p) { p.classList.remove('active'); });
  btn.classList.add('active');
  document.getElementById(panelId).classList.add('active');
}

/* コースタブ切り替え */
function showCourse(id, btn) {
  document.querySelectorAll('.course-detail').forEach(function(el) {
    el.classList.remove('active');
  });
  document.querySelectorAll('.course-tab').forEach(function(el) {
    el.classList.remove('active');
  });
  document.getElementById('course-' + id).classList.add('active');
  btn.classList.add('active');
}

/* FAQアコーディオン */
function toggleFaq(el) {
  var item = el.closest('.faq-item');
  var isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(function(i) {
    i.classList.remove('open');
  });
  if (!isOpen) { item.classList.add('open'); }
}

/* スクロール時にスティッキーCTAを表示 */
window.addEventListener('scroll', function() {
  var bar = document.querySelector('.sticky-cta');
  if (bar) {
    bar.style.display = window.scrollY > 300 ? 'flex' : 'none';
  }
});
</script>

<?php if(function_exists('wp_footer')) wp_footer(); ?>
</body>
</html>
