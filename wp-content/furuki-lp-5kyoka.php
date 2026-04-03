<?php
/**
 * Template Name: LP 5教科・速読解
 * Description: Furuki塾江東住吉教室 メインLP（5教科学習・速読解力講座）
 * Usage: WordPressの「固定ページ」を新規作成し、テンプレートで「LP 5教科・速読解」を選択してください。
 *        このファイルをアクティブテーマのフォルダ（wp-content/themes/あなたのテーマ名/）に配置してください。
 */
?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Furuki塾江東住吉教室｜完全個別指導・5教科学習・速読解力講座</title>
<meta name="description" content="江東区の完全個別指導学習塾。電子工学修士・認定心理士の塾長が「自ら考える力」を育てます。5教科学習・速読解力講座。無料体験随時受付中。">
<meta property="og:title" content="Furuki塾江東住吉教室｜完全個別指導・5教科・速読解力">
<meta property="og:description" content="AIの時代でも通用する力を育てる完全個別指導塾。江東区千田。無料体験随時受付中。">
<meta property="og:type" content="website">
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
  background: linear-gradient(140deg, #FFF7ED 0%, #FEF3C7 55%, #FFF7ED 100%);
  padding: 72px 0 80px;
  position: relative;
  overflow: hidden;
}
.hero::before {
  content: '';
  position: absolute;
  top: -120px; right: -120px;
  width: 480px; height: 480px;
  background: radial-gradient(circle, rgba(249,115,22,.14) 0%, transparent 65%);
  border-radius: 50%;
  pointer-events: none;
}
.hero::after {
  content: '';
  position: absolute;
  bottom: -80px; left: -60px;
  width: 320px; height: 320px;
  background: radial-gradient(circle, rgba(245,158,11,.11) 0%, transparent 65%);
  border-radius: 50%;
  pointer-events: none;
}
.hero-inner {
  display: flex;
  align-items: center;
  gap: 48px;
  position: relative;
  z-index: 1;
}
.hero-content { flex: 1; }
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
.hero-visual-wrap { flex: 0 0 300px; text-align: center; }
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

@media(max-width: 768px) {
  .hero-inner         { flex-direction: column; gap: 32px; }
  .hero-visual-wrap   { display: none; }
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
.reason-icon  { font-size: 36px; margin-bottom: 12px; }
.reason-title { font-size: 15px; font-weight: 700; margin-bottom: 10px; line-height: 1.45; }
.reason-body  { font-size: 13px; color: var(--text-muted); line-height: 1.75; }

@media(max-width: 640px) { .reasons-grid { grid-template-columns: 1fr; } }
@media(min-width: 641px) and (max-width: 900px) {
  .reasons-grid { grid-template-columns: repeat(2, 1fr); }
  .reason-card:last-child { grid-column: span 2; max-width: 420px; margin: 0 auto; width: 100%; }
}

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
.teacher-avatar        { width: 96px; height: 96px; margin: 0 auto 16px; }
.teacher-avatar svg    { width: 100%; height: 100%; }
.teacher-name          { font-size: 18px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
.teacher-role          { font-size: 11px; color: var(--text-muted); line-height: 1.6; }
.teacher-content       { flex: 1; padding: 36px 40px; }
.teacher-headline      { font-size: clamp(17px, 2.5vw, 21px); font-weight: 700; line-height: 1.5; margin-bottom: 20px; }
.teacher-headline em   { color: var(--orange); font-style: normal; }
.teacher-bio           { font-size: 14px; color: var(--text-muted); line-height: 1.95; margin-bottom: 24px; }
.teacher-tags          { display: flex; flex-wrap: wrap; gap: 8px; }
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
}

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
.pricing-table-wrap    { overflow-x: auto; margin-bottom: 20px; }
.pricing-table         { width: 100%; border-collapse: collapse; font-size: 14px; min-width: 460px; }
.pricing-table th      { background: var(--orange); color: #fff; padding: 11px 14px; text-align: center; font-weight: 700; }
.pricing-table td      { padding: 11px 14px; border-bottom: 1px solid var(--border); text-align: center; }
.pricing-table tr:nth-child(even) td { background: var(--section-bg); }
.pricing-table td.lbl  { text-align: left; font-weight: 700; }
.pricing-table td.hl   { font-weight: 700; color: var(--orange-dark); }
.pricing-h3            { font-size: 17px; font-weight: 700; margin: 36px 0 14px; padding-left: 12px; border-left: 4px solid var(--orange); color: var(--text); }
.pricing-note          { font-size: 12px; color: var(--text-light); margin-top: 6px; }
.pricing-extras {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
  gap: 12px;
  margin-top: 24px;
}
.pricing-extra         { background: var(--section-bg); border-radius: var(--radius-sm); padding: 14px 16px; font-size: 13px; color: var(--text); line-height: 1.7; }
.pricing-extra strong  { display: block; font-size: 14px; color: var(--orange-dark); margin-bottom: 4px; }

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
.access-grid           { display: grid; grid-template-columns: 1fr 1fr; gap: 36px; margin-top: 48px; align-items: start; }
.access-map iframe     { width: 100%; height: 300px; border-radius: var(--radius); border: none; }
.access-info           { display: flex; flex-direction: column; gap: 18px; }
.access-row            { display: flex; gap: 12px; align-items: flex-start; }
.access-row-icon       { width: 32px; height: 32px; background: var(--orange-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; margin-top: 2px; }
.access-row-label      { font-size: 11px; font-weight: 700; color: var(--text-light); letter-spacing: .05em; text-transform: uppercase; margin-bottom: 2px; }
.access-row-value      { font-size: 14px; color: var(--text); line-height: 1.65; }
.access-row-value a    { color: var(--orange); font-weight: 700; }
.access-line-link      { color: var(--line-green) !important; }

@media(max-width: 768px) { .access-grid { grid-template-columns: 1fr; } }

/* ==============================
   13. FOOTER
============================== */
.footer                { background: #292524; color: #fff; padding: 52px 0 32px; }
.footer-logo           { font-size: 19px; font-weight: 900; color: var(--orange); margin-bottom: 6px; }
.footer-tagline        { font-size: 13px; color: #A8A29E; margin-bottom: 28px; }
.footer-grid           { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 32px; padding-bottom: 32px; border-bottom: 1px solid #44403C; }
.footer-col-title      { font-size: 11px; font-weight: 700; color: #78716C; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 14px; }
.footer-links          { list-style: none; display: flex; flex-direction: column; gap: 8px; }
.footer-links a        { font-size: 13px; color: #A8A29E; transition: color .15s; }
.footer-links a:hover  { color: var(--orange); }
.footer-social a       { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #A8A29E; transition: color .15s; margin-top: 14px; }
.footer-social a:hover { color: var(--orange); }
.footer-bottom         { padding-top: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
.footer-copy           { font-size: 12px; color: #78716C; }

@media(max-width: 640px) {
  .footer-grid          { grid-template-columns: 1fr; gap: 24px; }
  .footer-bottom        { flex-direction: column; align-items: flex-start; }
}
</style>
</head>
<body>

<!-- ============================================================
   STICKY CTA（モバイル専用 画面下部固定）
============================================================ -->
<div class="sticky-cta">
  <a href="https://lin.ee/7NV1Pld" class="btn" style="background:var(--line-green);color:#fff;">💬 LINEで無料相談</a>
  <a href="https://furuki-juku.com/?page_id=70" class="btn btn-outline">📝 問い合わせ</a>
</div>

<!-- ============================================================
   1. HERO
============================================================ -->
<section class="hero" id="top">
  <div class="container">
    <div class="hero-inner">
      <div class="hero-content">
        <div class="hero-badge">✦ 無料体験 随時受付中</div>
        <h1 class="hero-title">
          AIの時代でも、<br>
          <span class="accent">通用する力</span>を。
        </h1>
        <p class="hero-sub">
          プログラミング × 5教科学習の完全個別指導塾<br>
          東京都江東区千田 ／ 小学1年生〜中学3年生対象
        </p>
        <div class="hero-cta-wrap">
          <a href="https://lin.ee/7NV1Pld" class="hero-line-btn">
            💬 LINEで無料体験に申し込む
          </a>
          <a href="https://furuki-juku.com/?page_id=70" class="btn btn-outline">
            📝 フォームでお問い合わせ
          </a>
          <p class="hero-cta-note">※ 無理な勧誘は一切ありません。相談だけでも歓迎です。</p>
        </div>
        <div class="hero-stats">
          <div>
            <div class="hero-stat-num">2021</div>
            <div class="hero-stat-label">開塾年</div>
          </div>
          <div>
            <div class="hero-stat-num">20年+</div>
            <div class="hero-stat-label">塾長の現場経験</div>
          </div>
          <div>
            <div class="hero-stat-num">完全個別</div>
            <div class="hero-stat-label">指導スタイル</div>
          </div>
        </div>
      </div>
      <div class="hero-visual-wrap">
        <div class="hero-visual">📚</div>
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
        <div class="reason-icon">🗓️</div>
        <h3 class="reason-title">完全個別指導 ×<br>自由な時間割</h3>
        <p class="reason-body">月ごとにスケジュールをカスタマイズ。部活・習い事との両立が可能です。15:00〜22:00の間で通塾時間を自由に設定できます。</p>
      </div>
      <div class="reason-card">
        <div class="reason-num">02</div>
        <div class="reason-icon">📖</div>
        <h3 class="reason-title">5教科 ＋ 速読解力の<br>一体型学習</h3>
        <p class="reason-body">5教科の学習に加え、速読解力講座で「読む力」を底上げ。読む力が上がると、全科目の理解力・得点力が向上します。</p>
      </div>
      <div class="reason-card">
        <div class="reason-num">03</div>
        <div class="reason-icon">🧠</div>
        <h3 class="reason-title">現場経験20年のエンジニアが<br>「なぜ？」から教える</h3>
        <p class="reason-body">電子工学修士・認定心理士でもある塾長が指導。答えを与えるのではなく、自分で考えられるようになる授業が特長です。</p>
      </div>
    </div>
  </div>
</section>

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
        <!-- シンプルなアイコンアバター（SVG） -->
        <div class="teacher-avatar">
          <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="50" fill="#FED7AA"/>
            <circle cx="50" cy="37" r="19" fill="#FDBA74"/>
            <rect x="18" y="60" width="64" height="40" rx="22" fill="#FDBA74"/>
            <rect x="27" y="33" width="15" height="10" rx="5" fill="none" stroke="#C2410C" stroke-width="2.5"/>
            <rect x="58" y="33" width="15" height="10" rx="5" fill="none" stroke="#C2410C" stroke-width="2.5"/>
            <line x1="42" y1="38" x2="58" y2="38" stroke="#C2410C" stroke-width="2"/>
            <path d="M41 46 Q50 53 59 46" fill="none" stroke="#C2410C" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="teacher-name">古澤 塾長</div>
        <div class="teacher-role">Furuki塾<br>江東住吉教室</div>
      </div>
      <div class="teacher-content">
        <h3 class="teacher-headline">
          <em>「自分で考える力」</em>こそが、<br>どんな時代でも一番の武器になる。
        </h3>
        <p class="teacher-bio">
          朝日新聞奨学生として自ら働きながら大学へ進み、電子工学の修士号を取得。
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
              <li>中3生には通い放題プランあり。受験直前まで徹底サポート</li>
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
              <div class="course-header-sub">小学1年生 〜 中学3年生 ／ 2025年夏より開始</div>
            </div>
          </div>
          <div class="course-body">
            <div class="course-for">
              <div class="course-for-label">👇 こんなお子さんにおすすめ</div>
              <ul class="course-for-list">
                <li>本を読むのが遅い・苦手</li>
                <li>テストで時間が足りなくなる</li>
                <li>長文・文章問題に弱い</li>
                <li>全科目の読解力を底上げしたい</li>
              </ul>
            </div>
            <ul class="course-features">
              <li>「速く・正確に読む力」を科学的なトレーニングで身につけます</li>
              <li>国語だけでなく、理科・社会・数学の文章問題にも大きな効果があります</li>
              <li>5教科学習コースと組み合わせることで、相乗効果が期待できます</li>
              <li>週1回50分・月8,800円（税込）から気軽にスタートできます</li>
            </ul>
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

    <h3 class="pricing-h3">速読解力講座</h3>
    <div class="pricing-table-wrap">
      <table class="pricing-table">
        <thead><tr><th>学年</th><th>授業時間</th><th>週1回</th><th>週2回</th></tr></thead>
        <tbody>
          <tr><td class="lbl">小1〜中3</td><td>50分</td><td class="hl">8,800円/月</td><td class="hl">13,200円/月</td></tr>
        </tbody>
      </table>
    </div>

    <h3 class="pricing-h3">5教科学習コース（小学生）</h3>
    <div class="pricing-table-wrap">
      <table class="pricing-table">
        <thead><tr><th>学年</th><th>授業時間</th><th>週1回</th><th>週2回</th><th>週3回以上</th></tr></thead>
        <tbody>
          <tr><td class="lbl">小1〜小3</td><td>60分</td><td class="hl">9,900円/月</td><td class="hl">15,400円/月</td><td>—</td></tr>
          <tr><td class="lbl">小4〜小6</td><td>90分</td><td class="hl">13,200円/月</td><td class="hl">18,700円/月</td><td class="hl">20,900円/月</td></tr>
        </tbody>
      </table>
    </div>

    <h3 class="pricing-h3">5教科学習コース（中学生）</h3>
    <div class="pricing-table-wrap">
      <table class="pricing-table">
        <thead><tr><th>学年</th><th>授業時間</th><th>週1回</th><th>週2回</th><th>通い放題</th></tr></thead>
        <tbody>
          <tr><td class="lbl">中1・中2</td><td>90分</td><td class="hl">14,300円/月</td><td class="hl">25,300円/月</td><td>—</td></tr>
          <tr><td class="lbl">中1・中2</td><td>120分</td><td class="hl">16,500円/月</td><td class="hl">27,500円/月</td><td class="hl">34,650円/月</td></tr>
          <tr><td class="lbl">中3</td><td>120分</td><td>—</td><td class="hl">31,900円/月</td><td class="hl">41,800円/月</td></tr>
          <tr><td class="lbl">中3（4月以降入塾）</td><td>120分</td><td>—</td><td>—</td><td class="hl">55,000円/月</td></tr>
        </tbody>
      </table>
    </div>
    <p class="pricing-note">※ 通い放題は1日4時間まで。すべて税込表記です。</p>

    <div class="pricing-extras">
      <div class="pricing-extra">
        <strong>入塾金</strong>
        22,000円（税込）<br>
        兄弟・姉妹同時入塾の場合は全員で22,000円。2人目以降は11,000円/人。
      </div>
      <div class="pricing-extra">
        <strong>システム利用料</strong>
        3,300円/月（税込）<br>
        冷暖房費・入退出通知などを含みます。4月・10月に半年分まとめて納入。
      </div>
      <div class="pricing-extra">
        <strong>自習席</strong>
        無料で利用可能<br>
        課題サポートあり。小4以上は20時まで、中学生は開塾時間中いつでも利用可。
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
      <a href="https://furuki-juku.com/?page_id=70" class="cta-form-btn">
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
    <div class="access-grid">
      <div class="access-map">
        <!--
          TODO: 下記のiframe src をGoogle Mapsの実際の埋め込みURLに差し替えてください。
          取得方法: Googleマップで教室を検索 → 「共有」→「地図を埋め込む」→ HTMLをコピー → src="..." の部分を貼り付け
        -->
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12963.218877927051!2d139.80398654937747!3d35.68181010100668!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018893f3f884b41%3A0xf3a175abf6d924a2!2zRnVydWtp5aG-!5e0!3m2!1sja!2sjp!4v1775174637660!5m2!1sja!2sjp"
          allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          title="Furuki塾江東住吉教室 地図">
        </iframe>
      </div>
      <div class="access-info">
        <div class="access-row">
          <div class="access-row-icon">📍</div>
          <div>
            <div class="access-row-label">住所</div>
            <div class="access-row-value">〒135-0013<br>東京都江東区千田11-13<br>丸万マンダリンハイム1F</div>
          </div>
        </div>
        <div class="access-row">
          <div class="access-row-icon">📞</div>
          <div>
            <div class="access-row-label">電話</div>
            <div class="access-row-value"><a href="tel:0367706936">03-6770-6936</a></div>
          </div>
        </div>
        <div class="access-row">
          <div class="access-row-icon">🕐</div>
          <div>
            <div class="access-row-label">開塾時間</div>
            <div class="access-row-value">平日 15:00〜22:00<br>土・日・祝 定休</div>
          </div>
        </div>
        <div class="access-row">
          <div class="access-row-icon">💬</div>
          <div>
            <div class="access-row-label">LINE</div>
            <div class="access-row-value"><a href="https://lin.ee/7NV1Pld" class="access-line-link">友だち追加はこちら</a></div>
          </div>
        </div>
        <div class="access-row">
          <div class="access-row-icon">📷</div>
          <div>
            <div class="access-row-label">Instagram</div>
            <div class="access-row-value"><a href="https://www.instagram.com/furukijuku" target="_blank" rel="noopener noreferrer">@furukijuku</a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
   13. FOOTER
============================================================ -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-logo">Furuki塾</div>
        <p class="footer-tagline">時代に左右されない能力を身につけよう。</p>
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
          <li><a href="https://furuki-juku.com/?page_id=70">お問い合わせフォーム</a></li>
          <li><a href="tel:0367706936">03-6770-6936</a></li>
        </ul>
        <div class="footer-social">
          <a href="https://www.instagram.com/furukijuku" target="_blank" rel="noopener noreferrer">
            📷 @furukijuku
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
