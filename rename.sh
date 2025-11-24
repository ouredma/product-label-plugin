#!/usr/bin/env bash
set -e

if [ $# -ne 2 ]; then
  echo "Usage: $0 <VendorName> <PluginName>"
  echo "Example: $0 IronMan ProductOnDemand"
  exit 1
fi

VENDOR_RAW="$1"
PLUGIN_RAW="$2"

# Normalize: PascalCase vendor & plugin
VENDOR=$(echo "$VENDOR_RAW" | sed -E 's/(^|[[:space:]])([a-z])/\U\2/g' | tr -d ' ')
PLUGIN=$(echo "$PLUGIN_RAW" | sed -E 's/(^|[[:space:]])([a-z])/\U\2/g' | tr -d ' ')

# Derived names (Sylius naming conventions)
BUNDLE_CLASS="${VENDOR}Sylius${PLUGIN}Plugin"
EXTENSION_CLASS="${VENDOR}Sylius${PLUGIN}Extension"
NAMESPACE="${VENDOR}\\Sylius${PLUGIN}Plugin"
CONFIG_KEY="$(echo "${VENDOR}_${PLUGIN}" | tr '[:upper:]' '[:lower:]' | sed 's/_/_sylius_/')_plugin"
COMPOSER_NAME="sylius-$(echo "${PLUGIN}" | tr '[:upper:]' '[:lower:]')-plugin"
TESTS_NAMESPACE="Tests\\\\${VENDOR}\\\\Sylius${PLUGIN}Plugin"

# Snake case for DB naming
VENDOR_SNAKE=$(echo "$VENDOR" | sed -E 's/([A-Z])/_\1/g' | tr '[:upper:]' '[:lower:]' | sed 's/^_//')
PLUGIN_SNAKE=$(echo "$PLUGIN" | sed -E 's/([A-Z])/_\1/g' | tr '[:upper:]' '[:lower:]' | sed 's/^_//')
DB_NAME="${VENDOR_SNAKE}_${PLUGIN_SNAKE}_%kernel.environment%"

# Cross-platform sed
if sed --version >/dev/null 2>&1; then
  SED="sed -i"
else
  SED="sed -i ''"
fi

echo "🔧 Applying naming changes..."
echo "Vendor:           $VENDOR"
echo "Plugin:           $PLUGIN"
echo "Bundle class:     $BUNDLE_CLASS"
echo "Extension class:  $EXTENSION_CLASS"
echo "Namespace:        $NAMESPACE"
echo "Config key:       $CONFIG_KEY"
echo "Composer name:    $COMPOSER_NAME"
echo "Database name:    $DB_NAME"
echo

# 1. Rename PHP bundle & extension files
if [ -f "src/AcmeSyliusExamplePlugin.php" ]; then
  mv src/AcmeSyliusExamplePlugin.php "src/${BUNDLE_CLASS}.php"
fi
if [ -f "src/DependencyInjection/AcmeSyliusExampleExtension.php" ]; then
  mv src/DependencyInjection/AcmeSyliusExampleExtension.php "src/DependencyInjection/${EXTENSION_CLASS}.php"
fi

# 2. Replace all occurrences recursively (ignore RENAME_GUIDE and vendor/)
echo "→ Replacing occurrences (skipping vendor/ and RENAME_GUIDE)..."
find . -type f \
  \( -name "*.php" -o -name "*.xml" -o -name "*.yml" -o -name "*.yaml" -o -name "*.json" -o -name "*.md" \) \
  ! -path "./vendor/*" ! -name "RENAME_GUIDE" | while read -r FILE; do
    $SED "s#AcmeSyliusExamplePlugin#${BUNDLE_CLASS}#g" "$FILE"
    $SED "s#Acme\\\\SyliusExamplePlugin#${NAMESPACE}#g" "$FILE"
    $SED "s#acme_sylius_example_plugin#${CONFIG_KEY}#g" "$FILE"
    $SED "s#Tests\\\\Acme\\\\SyliusExamplePlugin#${TESTS_NAMESPACE}#g" "$FILE"
done

# 3. Update composer.json
if [ -f composer.json ]; then
  echo "→ Updating composer.json..."
  cp composer.json composer.json.bak
  $SED "s#\"name\": \".*\"#\"name\": \"${VENDOR,,}/${COMPOSER_NAME}\",#g" composer.json
  $SED "s#\"Acme\\\\\\\\SyliusExamplePlugin\\\\\\\\\"#\"${NAMESPACE}\\\\\\\\\",#g" composer.json
  $SED "s#\"Tests\\\\\\\\Acme\\\\\\\\SyliusExamplePlugin\\\\\\\\\"#\"${TESTS_NAMESPACE}\\\\\\\\\",#g" composer.json
fi

# 4. Optional: rename namespace directory
if [ -d "src/Acme" ]; then
  mkdir -p "src/${VENDOR}"
  mv src/Acme/* "src/${VENDOR}/" || true
  rmdir src/Acme 2>/dev/null || true
fi

# 5. Update DATABASE_URL in tests environment file
ENV_FILE=""
if [ -f "tests/TestApplication/.env.test" ]; then
  ENV_FILE="tests/TestApplication/.env.test"
elif [ -f "tests/Application/.env.test" ]; then
  ENV_FILE="tests/Application/.env.test"
fi

if [ -n "$ENV_FILE" ]; then
  echo "→ Updating database URL in ${ENV_FILE}..."
  $SED "s#^DATABASE_URL=.*#DATABASE_URL=mysql://root:root@127.0.0.1/${DB_NAME}#g" "$ENV_FILE"
else
  echo "⚠️  No .env.test file found under tests/Application or tests/TestApplication"
fi

echo
echo "✅ All occurrences replaced, vendor/ skipped, and database URL updated!"
echo "Next steps:"
echo "  1. Run: composer dump-autoload"
echo "  2. Review configs and tests manually."
echo "  3. Delete this script when done."
