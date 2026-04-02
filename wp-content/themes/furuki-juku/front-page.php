<?php get_header(); ?>

<?php
/**
 * キャッチコピー 3案
 *
 * 案A：「なにがわからないか、わからない。だから、Furuki塾。」
 *      → バス広告の認知を活かした直球。中高生の共感を狙う。
 *
 * 案B：「つまずきは、伸びしろだ。」
 *      → シンプルで力強い。保護者・生徒両方に響くポジティブな表現。
 *
 * 案C：「あなたの『わからない』を、一緒に見つけよう。」
 *      → 個別指導の温かさを前面に。LP全体のトーンと馴染みやすい。
 *
 * 使用する案のコメントを外してください（現在は案Cを表示）
 */

// 案A（採用）
$catch_main = '何がわからないか<br class="hidden sm:block">わからない。';
$catch_sub  = 'そんな「悩める」キミに、Furuki塾。';

// 案B
// $catch_main = 'つまずきは、<br class="hidden sm:block">伸びしろだ。';
// $catch_sub  = '一人ひとりの「わからない」に向き合う個別指導塾';

// 案C → 「Furuki塾について」セクションのリード文として転用予定
// 「あなたの『わからない』を、一緒に見つけよう。
//   Furuki塾の個別指導で、自分だけのペースで着実に伸びる」
?>

<!-- ヒーローセクション -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">

  <!-- 背景：後で画像に差し替えてください -->
  <div class="absolute inset-0">
    <?php if ( has_post_thumbnail( get_option('page_on_front') ) ) : ?>
      <?php echo get_the_post_thumbnail( get_option('page_on_front'), 'full', ['class' => 'w-full h-full object-cover object-center'] ); ?>
    <?php else : ?>
      <!-- プレースホルダー：グラデーション背景 -->
      <div class="w-full h-full bg-gradient-to-br from-brand-navy via-[#005a96] to-brand-blue"></div>
      <!-- 差し替え方法：WordPress管理画面 > フロントページ > アイキャッチ画像 を設定 -->
    <?php endif; ?>
    <!-- オーバーレイ -->
    <div class="absolute inset-0 bg-brand-navy/70"></div>
    <!-- ドット装飾（ピクセルアートへのオマージュ） -->
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 24px 24px;"></div>
  </div>

  <!-- コンテンツ -->
  <div class="relative z-10 text-center text-white px-6 max-w-4xl mx-auto pt-16">

    <!-- バッジ -->
    <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/30 text-white text-sm font-medium px-5 py-2 rounded-full mb-8">
      <span class="w-2 h-2 rounded-full bg-brand-accent inline-block"></span>
      東京都江東区の個別指導塾
    </div>

    <!-- メインキャッチコピー -->
    <h1 class="font-serif text-3xl sm:text-5xl md:text-6xl font-bold leading-snug mb-5 tracking-wide drop-shadow-lg">
      <?php echo $catch_main; ?>
    </h1>

    <!-- サブコピー -->
    <p class="text-base sm:text-xl text-white/85 mb-4 leading-relaxed font-sans">
      <?php echo $catch_sub; ?>
    </p>

    <!-- 特徴タグ -->
    <div class="flex flex-wrap justify-center gap-3 mb-10 text-sm">
      <span class="bg-white/15 border border-white/30 text-white px-4 py-1.5 rounded-full">小1〜中3対応</span>
      <span class="bg-white/15 border border-white/30 text-white px-4 py-1.5 rounded-full">全科目指導</span>
      <span class="bg-white/15 border border-white/30 text-white px-4 py-1.5 rounded-full">通塾スケジュール自由</span>
      <span class="bg-white/15 border border-white/30 text-white px-4 py-1.5 rounded-full">低価格な季節講習</span>
    </div>

    <!-- CTAボタン -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="#contact"
         class="inline-block bg-brand-accent hover:bg-amber-500 text-white font-bold py-4 px-10 rounded-full text-lg shadow-lg transition-all duration-200 hover:scale-105">
        無料体験・お問い合わせ
      </a>
      <a href="#about"
         class="inline-block bg-white/15 hover:bg-white/25 text-white font-bold py-4 px-10 rounded-full text-lg border border-white/50 backdrop-blur-sm transition-all duration-200">
        塾の詳細を見る
      </a>
    </div>

    <!-- 電話番号 -->
    <p class="mt-8 text-white/70 text-sm">
      お電話でのお問い合わせ：
      <a href="tel:0367706936" class="text-white font-bold text-base hover:text-brand-accent transition">
        03-6770-6936
      </a>
      <span class="ml-2 text-xs">（受付 14:00〜21:00）</span>
    </p>

    <!-- 注記 -->
    <p class="mt-3 text-white/50 text-xs">しつこい勧誘はございません。</p>

  </div>

  <!-- スクロール矢印 -->
  <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/60 animate-bounce">
    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
    </svg>
  </div>

</section>

<!-- 以降のセクション追加予定 -->
<section id="about" class="py-24 bg-brand-warm">
  <div class="container mx-auto text-center text-brand-navy">
    <p class="text-gray-400 text-sm">（次のセクションをここに追加予定）</p>
  </div>
</section>

<?php get_footer(); ?>
