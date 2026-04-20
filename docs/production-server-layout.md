# Furuki塾 本番サーバー構成（覚書）

最終確認: 2026-04 時点。Lightsail 上の実測と Apache 設定に基づく。

## ドメイン・接続

- 公開サイト: `https://furuki-juku.com/`
- SSH 例: `ssh -i ~/.ssh/LightsailDefaultKey-ap-northeast-1.pem -p 2222 admin@<サーバーIP>`

## Apache（SSL）

- `default-ssl.conf`: `ServerName furuki-juku.com` / **`DocumentRoot /var/www/html`**
- 静的ファイル・WordPress の入口は **`/var/www/html`**

## WordPress の実体

| 役割 | パス |
|------|------|
| コア・`wp-content`・テーマ | **`/var/www/html/`** |
| **`wp-config.php` の場所** | **`/var/www/wp-config.php`**（`html` の**親**） |

- `wp-load.php` が「親ディレクトリの `wp-config.php`」も探す標準動作のため、**`html` に `wp-config.php` が無くても動く**。
- メール SMTP 用の `define( 'FURUKI_SMTP_*' ... )` は **`/var/www/wp-config.php`** に書く（`html` 側には無い）。

## デプロイ（GitHub Actions）

- リポジトリ: `furukijuku/furuki-juku-lp`
- ワークフロー: `.github/workflows/deploy.yml`
- 同期先: **`/var/www/html/wp-content/themes/furuki-juku/`**（`rsync --delete`）
- DocumentRoot と一致しているため、**プッシュしたテーマがそのまま本番に反映される**。

## メール（問い合わせフォーム）

- テーマ `functions.php` の `phpmailer_init` が、**`wp-config.php` で定義された `FURUKI_SMTP_*`** があるときだけ SMTP を使う。
- Lightsail デフォルトの `mail()` だけでは送れないことが多い → **SMTP 定数が必須**。

### 定数を安全に追記する

手編集が不安な場合は、テーマ同梱のスクリプトを使う（バックアップ後に実行）。

```bash
cd /var/www/html/wp-content/themes/furuki-juku/scripts
sudo bash ./append-furuki-smtp-to-wpconfig.sh --help
```

詳細は `wp-content/themes/furuki-juku/scripts/README-smtp-append.md` を参照。

## 注意（`/var/www/wp-config.php`）

- 末尾付近の **`ABSPATH` 定義**が誤っている行があっても、`wp-load.php` が先に正しい `ABSPATH`（`/var/www/html/`）を定義しているため **現状は動いている可能性がある**。
- 手で直す場合は必ずバックアップのうえ、WordPress 公式の `wp-config-sample.php` と照合すること。

## 確認コマンド（SSH）

```bash
# DocumentRoot
sudo grep -Rni 'DocumentRoot\|ServerName' /etc/apache2/sites-enabled/

# WordPress ルートの中身
ls -la /var/www/html/

# 設定ファイルの場所
ls -la /var/www/wp-config.php
```
