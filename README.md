## Hot to implement Product Badges in Sylius
1. In project override Product.php to use the ProductBadgeableTrait and implement ProductBadgeableInterface
2. Add plugin routes to Project routes
   integritty_sylius_product_badge_plugin:
   resource: "@IntegrittySyliusProductBadgePlugin/config/routes.yaml"
3. Add plugin services to Project Services in _sylius.yaml
   - { resource: "@IntegrittySyliusProductBadgePlugin/config/config.yaml" }
4. Add plugin to bundles.php
   Integritty\SyliusProductBadgePlugin\IntegrittySyliusProductBadgePlugin::class => ['all' => true],
4. Run migrations
