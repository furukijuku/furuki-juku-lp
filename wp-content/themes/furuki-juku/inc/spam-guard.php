<?php
/**
 * Furuki塾 共通スパム対策ユーティリティ
 *
 * 使い方:
 *   require_once get_template_directory() . '/inc/spam-guard.php';
 *   $spam_errors = furuki_spam_check( $_POST, $vals );
 *   $errors = array_merge( $errors, $spam_errors );
 */

defined( 'ABSPATH' ) || exit;

/**
 * 共通スパムチェックを実行し、エラーメッセージの配列を返す。
 *
 * @param array $post  $_POST データ
 * @param array $vals  サニタイズ済みフォーム値（name, furigana, phone, email を参照）
 * @return array       エラーメッセージの配列（空ならスパム検出なし）
 */
function furuki_spam_check( array $post, array $vals ): array {
	$errors = [];

	// --- 1. 時間ベース検知 ---
	$ts = intval( $post['_form_ts'] ?? 0 );
	if ( $ts === 0 || ( time() - $ts ) < 3 ) {
		$errors[] = '不正なリクエストです。もう一度お試しください。';
		return $errors;
	}

	// --- 2. JSトークン検証 ---
	if ( empty( $post['_js_token'] ) ) {
		$errors[] = '不正なリクエストです。JavaScriptを有効にしてください。';
		return $errors;
	}

	// --- 3. ふりがなパターン検証 ---
	$furigana = $vals['furigana'] ?? $vals['child_kana'] ?? '';
	if ( ! empty( $furigana ) && ! preg_match( '/[\p{Hiragana}\p{Katakana}]/u', $furigana ) ) {
		$errors[] = 'ふりがなはひらがなで入力してください。';
	}

	// --- 4. 名前に日本語が含まれるか ---
	$name = $vals['name'] ?? $vals['child_name'] ?? '';
	if ( ! empty( $name ) && ! preg_match( '/[\p{Han}\p{Hiragana}\p{Katakana}]/u', $name ) ) {
		$errors[] = 'お名前を正しく入力してください。';
	}

	// --- 5. 電話番号（日本国内形式） ---
	$phone = $vals['phone'] ?? '';
	if ( ! empty( $phone ) ) {
		$phone_clean = preg_replace( '/[\s\-ー−()（）]/', '', $phone );
		if ( ! preg_match( '/\A0[1-9][0-9]{8,9}\z/', $phone_clean ) ) {
			$errors[] = '電話番号は日本国内の番号を入力してください。';
		}
	}

	// --- 6. メールドメインブロック ---
	$email = $vals['email'] ?? '';
	if ( ! empty( $email ) ) {
		$blocked_domains = [
			'example.com', 'example.org', 'example.net',
			'test.com', 'test.org',
			'mailinator.com', 'guerrillamail.com', 'tempmail.com',
			'throwaway.email', 'yopmail.com', 'sharklasers.com',
			'grr.la', 'guerrillamailblock.com', 'dispostable.com',
		];
		$email_domain = strtolower( substr( strrchr( $email, '@' ), 1 ) );
		if ( in_array( $email_domain, $blocked_domains, true ) ) {
			$errors[] = '有効なメールアドレスを入力してください。';
		}
	}

	// --- 7. NGキーワードブロック（営業・スパム） ---
	$check_fields = [ $name, $vals['message'] ?? '' ];
	$check_text   = implode( ' ', $check_fields );
	$spam_keywords = [
		'SEO', 'seo', '集客', '広告', '営業', '勧誘',
		'マーケティング', 'リスティング', 'アフィリエイト',
		'代行', '外注', '投資', '副業', 'ビジネス', 'システム販売',
		'弊社', '株式会社', '合同会社', '有限会社',
		'ホームページ制作', 'LP制作', 'サイト制作',
	];
	foreach ( $spam_keywords as $kw ) {
		if ( mb_strpos( $check_text, $kw ) !== false ) {
			$errors[] = '本フォームは保護者・生徒の方専用です。業者様からのお問い合わせはご遠慮ください。';
			break;
		}
	}

	// --- 8. レート制限（10分間で3回まで） ---
	$ip       = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
	$rate_key = 'furuki_spam_' . md5( $ip );
	$attempts = (int) get_transient( $rate_key );
	if ( $attempts >= 3 ) {
		$errors[] = '送信回数の上限に達しました。しばらく時間をおいて再度お試しください。';
	} else {
		set_transient( $rate_key, $attempts + 1, 600 );
	}

	return $errors;
}

/**
 * フォーム内に埋め込む hidden フィールド + JS トークン生成スクリプトを出力する。
 * フォームの <form> タグ直後に呼び出す。
 */
function furuki_spam_fields(): void {
	$ts = time();
	?>
	<input type="hidden" name="_form_ts" value="<?php echo esc_attr( $ts ); ?>">
	<input type="hidden" name="_js_token" id="furuki_js_token" value="">
	<script>document.getElementById('furuki_js_token').value=btoa(Date.now().toString(36));</script>
	<?php
}
