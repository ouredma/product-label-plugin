#!/usr/bin/env bash
set -e

if [ $# -ne 2 ]; then
  echo "Usage: $0 <VendorName> <PluginName>"
  echo "Example: $0 IronMan ProductOnDemand"
  exit 1
fi

VENDOR_RAW="$1"
PLUGIN_RAW="$2"

# Normalize:
# VendorName (PascalCase) → VENDOR
VENDOR=$(echo "$VENDOR_RAW" | sed -r 's/(^| )[a-z]/\U&/g' | sed 's/ //g')
# plugin name in PascalCase
PLUGIN=$(echo "$PLUGIN_RAW" | sed -r 's/(^| )[a-z]/\U&/g' | sed 's/ //g')

# Derived names based on naming guide:
REPO_NAME="${VENDOR}/sylius-${PLUGIN:-plugin}"
COMPOSER_NAME="sylius-${PLUGIN,,}-plugin"             # plugin lower-case for composer
BUNDLE_CLASS="${VENDOR}Sylius${PLUGIN}Plugin"
EXTENSION_CLASS="${VENDOR}Sylius${PLUGIN}Extension"
NAMESPACE="${VENDOR}\\Sylius${PLUGIN}Plugin"
CONFIG_KEY="${VENDOR,,}_sylius_${PLUGIN,,}_plugin"

echo "Applying naming changes for:"
echo "  Vendor:          $VENDOR"
echo "  Plugin:          $PLUGIN"
echo "  Composer name:   $COMPOSER_NAME"
echo "  Bundle class:    $BUNDLE_CLASS"
echo "  Extension class: $EXTENSION_CLASS"
echo "  Namespace:       $NAMESPACE"
echo "  Config key:      $CONFIG_KEY"

# 1. composer.json – update name, description, psr-4 and tests namespace
if [ -f composer.json ]; then
  # Backup
  cp composer.json composer.json.bak
  # Use sed to replace minimal things
  sed -i "s#\"sylius/plugin-skeleton\"#\"${COMPOSER_NAME}\"#g" composer.json
  sed -i "s#\"Acme\\\\SyliusExamplePlugin\\\\\"#\"${NAMESPACE}\\\\\\\\\"#g" composer.json
  sed -i "s#\"Tests\\\\Acme\\\\SyliusExamplePlugin\\\\\"#\"Tests\\\\${VENDOR}\\\\Sylius${PLUGIN}Plugin\\\\\"#g" composer.json
  # You may also update description manually
fi

# 2. Rename bundle class file and update namespace inside
if [ -f "src/AcmeSyliusExamplePlugin.php" ]; then
  mv src/AcmeSyliusExamplePlugin.php "src/${BUNDLE_CLASS}.php"
  sed -i "s#namespace Acme\\\\SyliusExamplePlugin#namespace ${NAMESPACE}#g" "src/${BUNDLE_CLASS}.php"
  sed -i "s#class AcmeSyliusExamplePlugin#class ${BUNDLE_CLASS}#g" "src/${BUNDLE_CLASS}.php"
fi

# 3. Rename extension class
if [ -f "src/DependencyInjection/AcmeSyliusExampleExtension.php" ]; then
  mv src/DependencyInjection/AcmeSyliusExampleExtension.php \
     src/DependencyInjection/${EXTENSION_CLASS}.php
  sed -i "s#namespace Acme\\\\SyliusExamplePlugin\\\\DependencyInjection#namespace ${NAMESPACE}\\\\DependencyInjection#g" \
      src/DependencyInjection/${EXTENSION_CLASS}.php
  sed -i "s#class AcmeSyliusExampleExtension#class ${EXTENSION_CLASS}#g" \
      src/DependencyInjection/${EXTENSION_CLASS}.php
fi

# 4. Configuration key inside Configuration.php
if [ -f "src/DependencyInjection/Configuration.php" ]; then
  sed -i "s#acme_sylius_example_plugin#${CONFIG_KEY}#g" src/DependencyInjection/Configuration.php
fi

# 5. Tests / Application directories
find tests/Application -type f -exec sed -i "s#Acme\\\\SyliusExamplePlugin\\\\#${NAMESPACE}\\\\#g" {} +
find tests -type f -exec sed -i "s#Tests\\\\Acme\\\\SyliusExamplePlugin\\\\#Tests\\\\${VENDOR}\\\\Sylius${PLUGIN}Plugin\\\\#g" {} +

echo "✅ Naming changes applied. Please run:"
echo "    composer dump-autoload"
echo "  and review manually other files and directories (routing, features, etc.) to ensure nothing left with 'AcmeSyliusExamplePlugin'."

exit 0
