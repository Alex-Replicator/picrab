#!/usr/bin/env bash

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
SCRIPT_PATH="$SCRIPT_DIR/$(basename "$0")"

SEARCH_DIR="$SCRIPT_DIR"
while [ ! -f "$SEARCH_DIR/exclude.conf" ] && [ "$SEARCH_DIR" != "/" ]; do
SEARCH_DIR="$(dirname "$SEARCH_DIR")"
done

if [ ! -f "$SEARCH_DIR/exclude.conf" ]; then
echo "Файл exclude.conf не найден."
exit 1
fi

PROJECT_ROOT="$SEARCH_DIR"
EXCLUDE_FILE="$PROJECT_ROOT/exclude.conf"
OUTPUT_FILE="$PROJECT_ROOT/output.md"

EXCLUDE_PATTERNS=()
while IFS= read -r line; do
line="${line%$'\r'}"
line="$(echo "$line" | sed 's/^[[:space:]]*//;s/[[:space:]]*$//')"
[ -z "$line" ] && continue
if [[ "$line" != ./* ]]; then
line="./$line"
fi
EXCLUDE_PATTERNS+=("$line")
done < "$EXCLUDE_FILE"

[ -f "$OUTPUT_FILE" ] && rm "$OUTPUT_FILE"

cd "$PROJECT_ROOT" || exit 1

find . -type f | while read -r file; do
if [[ "$PROJECT_ROOT/$file" == "$SCRIPT_PATH" ]]; then
continue
fi
if [[ "$PROJECT_ROOT/$file" == "$SCRIPT_DIR"* ]]; then
continue
fi

skip_file=false
for pattern in "${EXCLUDE_PATTERNS[@]}"; do
case "$file" in
$pattern*) skip_file=true; break ;;
esac
done
[ "$skip_file" = true ] && continue

echo "#### Файл: *${file#./}*" >> "$OUTPUT_FILE"
echo '```' >> "$OUTPUT_FILE"
echo " " >> "$OUTPUT_FILE"
cat "$file" >> "$OUTPUT_FILE"
echo " " >> "$OUTPUT_FILE"
echo '```' >> "$OUTPUT_FILE"
echo " " >> "$OUTPUT_FILE"
echo >> "$OUTPUT_FILE"
done