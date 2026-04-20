# `append-furuki-smtp-to-wpconfig.sh`

`/var/www/wp-config.php` の `/* That's all, stop editing! */` の**直前**に、Furuki塾テーマ用の SMTP 定数ブロックを挿入します。

## 事前に

1. **必ずバックアップ**（スクリプト自身もタイムスタンプ付きで `wp-config.php.bak.*` を作成しますが、念のため別途コピー推奨）。
2. 本番の `wp-config` のパスが **`/var/www/wp-config.php`** であることを確認（覚書 `docs/production-server-layout.md`）。

## 使い方

### A. プレースホルダだけ挿入（値はあとでエディタで埋める）

```bash
cd /var/www/html/wp-content/themes/furuki-juku/scripts
sudo bash ./append-furuki-smtp-to-wpconfig.sh --placeholder
```

空の `define` が入り、テーマ側は「ホストが空なので SMTP 無効」のままです。ファイルを開き、`''` の中身だけ埋めてください。

### B. 環境変数で一度に書き込み（パスワードをエディタに残さない）

```bash
cd /var/www/html/wp-content/themes/furuki-juku/scripts
export FURUKI_SMTP_HOST='smtp.gmail.com'
export FURUKI_SMTP_PORT='587'
export FURUKI_SMTP_ENCRYPTION='tls'
export FURUKI_SMTP_USER='furuki.jyuku@gmail.com'
export FURUKI_SMTP_PASS='アプリパスワード'
export FURUKI_MAIL_FROM='furuki.jyuku@gmail.com'
export FURUKI_MAIL_FROM_NAME='Furuki塾'
sudo -E bash ./append-furuki-smtp-to-wpconfig.sh
```

`sudo -E` で root に環境変数を引き継ぎます。終わったら `unset` するかターミナルを閉じてください。

## 別パスの wp-config を使う場合

```bash
sudo WP_CONFIG_PATH=/path/to/wp-config.php bash ./append-furuki-smtp-to-wpconfig.sh --placeholder
```

## 再実行

既に `// FURUKI_MAIL_CONFIG_BEGIN` が含まれている場合は **何もしません**（二重挿入防止）。変更したい場合はバックアップから戻すか、該当ブロックを手で削除してから再実行してください。
