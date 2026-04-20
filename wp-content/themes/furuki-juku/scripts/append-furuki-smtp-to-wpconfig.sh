#!/usr/bin/env bash
# Furuki塾: wp-config.php に FURUKI_SMTP_* を挿入（手編集の代替）
# 既定ターゲット: /var/www/wp-config.php（覚書 docs/production-server-layout.md 参照）
set -euo pipefail

WP_CONFIG="${WP_CONFIG_PATH:-/var/www/wp-config.php}"

usage() {
  if [[ -f "$(dirname "$0")/README-smtp-append.md" ]]; then
    sed -n '1,85p' "$(dirname "$0")/README-smtp-append.md"
  fi
  echo ""
  echo "Usage:"
  echo "  sudo bash $0 --placeholder     # 空の define を挿入（あとで値を埋める）"
  echo "  sudo -E bash $0                # 環境変数 FURUKI_SMTP_* から値を挿入"
  echo "  WP_CONFIG_PATH=/path sudo bash $0 --placeholder"
}

if [[ "${1:-}" == "-h" || "${1:-}" == "--help" ]]; then
  usage
  exit 0
fi

if [[ ! -f "$WP_CONFIG" ]]; then
  echo "Error: not found: $WP_CONFIG" >&2
  exit 1
fi

if [[ $EUID -ne 0 ]]; then
  echo "Error: run as root (sudo)." >&2
  exit 1
fi

if grep -qF '// FURUKI_MAIL_CONFIG_BEGIN' "$WP_CONFIG"; then
  echo "Already contains FURUKI_MAIL_CONFIG block — nothing to do."
  exit 0
fi

if ! grep -qF "That's all, stop editing! Happy publishing." "$WP_CONFIG"; then
  echo "Error: WordPress stop marker not found in $WP_CONFIG" >&2
  exit 1
fi

BAK="${WP_CONFIG}.bak.$(date +%Y%m%d_%H%M%S)"
cp -a "$WP_CONFIG" "$BAK"
echo "Backup: $BAK"

PLACEHOLDER=0
if [[ "${1:-}" == "--placeholder" ]]; then
  PLACEHOLDER=1
fi

export FURUKI_PLACEHOLDER="$PLACEHOLDER"
export FURUKI_WP_CONFIG="$WP_CONFIG"

python3 <<'PY'
import os
import sys

wp = os.environ["FURUKI_WP_CONFIG"]
placeholder = os.environ.get("FURUKI_PLACEHOLDER") == "1"
begin = "// FURUKI_MAIL_CONFIG_BEGIN"
end = "// FURUKI_MAIL_CONFIG_END"
stop = "/* That's all, stop editing! Happy publishing. */"


def php_define_str(name: str, value: str) -> str:
    esc = value.replace("\\", "\\\\").replace("'", "\\'")
    return f"define( '{name}', '{esc}' );"


def build_block() -> str:
    if placeholder:
        lines = [
            begin,
            "// 空のままではテーマの SMTP は有効になりません。値を埋めるか、環境変数付きで再実行してください。",
            php_define_str("FURUKI_SMTP_HOST", ""),
            "define( 'FURUKI_SMTP_PORT', 587 );",
            php_define_str("FURUKI_SMTP_ENCRYPTION", "tls"),
            php_define_str("FURUKI_SMTP_USER", ""),
            php_define_str("FURUKI_SMTP_PASS", ""),
            php_define_str("FURUKI_MAIL_FROM", ""),
            php_define_str("FURUKI_MAIL_FROM_NAME", "Furuki塾"),
            end,
        ]
        return "\n".join(lines) + "\n\n"

    host = os.environ.get("FURUKI_SMTP_HOST", "").strip()
    user = os.environ.get("FURUKI_SMTP_USER", "").strip()
    pwd = os.environ.get("FURUKI_SMTP_PASS", "").strip()
    if not host or not user or not pwd:
        print(
            "Error: set FURUKI_SMTP_HOST, FURUKI_SMTP_USER, FURUKI_SMTP_PASS "
            "or use --placeholder",
            file=sys.stderr,
        )
        sys.exit(1)

    port = os.environ.get("FURUKI_SMTP_PORT", "587").strip() or "587"
    enc = os.environ.get("FURUKI_SMTP_ENCRYPTION", "tls").strip() or "tls"
    mfrom = os.environ.get("FURUKI_MAIL_FROM", user).strip()
    mname = os.environ.get("FURUKI_MAIL_FROM_NAME", "Furuki塾").strip()

    lines = [
        begin,
        php_define_str("FURUKI_SMTP_HOST", host),
        f"define( 'FURUKI_SMTP_PORT', {int(port)} );",
        php_define_str("FURUKI_SMTP_ENCRYPTION", enc),
        php_define_str("FURUKI_SMTP_USER", user),
        php_define_str("FURUKI_SMTP_PASS", pwd),
        php_define_str("FURUKI_MAIL_FROM", mfrom),
        php_define_str("FURUKI_MAIL_FROM_NAME", mname),
        end,
    ]
    return "\n".join(lines) + "\n\n"


with open(wp, encoding="utf-8", errors="surrogateescape") as f:
    text = f.read()

if stop not in text:
    print("Error: stop marker not found:", repr(stop), file=sys.stderr)
    sys.exit(1)

block = build_block()
new_text = text.replace(stop, block + stop, 1)
if new_text == text:
    print("Error: replace failed", file=sys.stderr)
    sys.exit(1)

with open(wp, "w", encoding="utf-8", errors="surrogateescape") as f:
    f.write(new_text)

print("Updated:", wp)
PY

echo "Done. Verify: grep -n FURUKI_MAIL_CONFIG \"$WP_CONFIG\""
