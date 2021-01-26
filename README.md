<h1 align="center">
    <a href="http://bitbag.shop" target="_blank">
        <img src="doc/logo.png" width="55%" alt="BitBag" />
    </a>
    <br />
    <a href="https://packagist.org/packages/bitbag/product-bundle-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/bitbag/product-bundle-plugin.svg" alt="License" />
    </a>
    <a href="https://packagist.org/packages/bitbag/product-bundle-plugin" title="Total Downloads" target="_blank">
        <img src="https://poser.pugx.org/bitbag/product-bundle-plugin/downloads" alt="Total downloads"/>
    </a>
    <p>
        <a href="https://sylius.com/plugins/" target="_blank">
            <img src="https://sylius.com/assets/badge-approved-by-sylius.png" width="85" alt="Approved by Sylius">
        </a>
    </p>
</h1>

## About us

At BitBag we do believe in open source. However, we are able to do it just because of our awesome clients, who are kind enough to share some parts of our work with the community. Therefore, if you feel like there is a possibility for us working together, feel free to reach us out. You will find out more about our professional services, technologies and contact details at https://bitbag.io/.

## Overview

This plugin allows you to create new products by bundling existing products together.

## Installation

1. Require plugin with composer:

    ```bash
    composer require bitbag/product-bundle-plugin
    ```
 
2. Add plugin dependencies to your `config/bundles.php` file:
    
    ```php
        return [
         ...
        
            BitBag\SyliusProductBundlePlugin\BitBagSyliusProductBundlePlugin::class => ['all' => true ],
        ];
    ```

3. Import required config in your `config/packages/_sylius.yaml` file:
    
    ```yaml
    # config/packages/_sylius.yaml
    
    imports:
        ...
        
        - { resource: "@BitBagSyliusProductBundlePlugin/Resources/config/config.yml" }
    ```    

4. Import routing in your `config/routes.yaml` file:
    
    ```yaml
    
    # config/routes.yaml
    ...
    
    bitbag_sylius_product_bundle_plugin:
        resource: "@BitBagSyliusProductBundlePlugin/Resources/config/routing.yml"
    ```

5. Extend `Product`(including Doctrine mapping):

    ```php
    <?php 
   
   declare(strict_types=1);
    
    namespace App\Entity\Product;
    
    use BitBag\SyliusProductBundlePlugin\Entity\ProductBundlesAwareInterface;
    use BitBag\SyliusProductBundlePlugin\Entity\ProductBundlesAwareTrait;
    use Sylius\Component\Core\Model\Product as BaseProduct;

    class Product extends BaseProduct implements ProductBundlesAwareInterface
    {
        use ProductBundlesAwareTrait;  
    }
    ```
   
6. Extend `OrderItem` (including Doctrine mapping):

    ```php
   <?php
   
   declare(strict_types=1);
   
   namespace App\Entity\Order;
   
   use BitBag\SyliusProductBundlePlugin\Entity\OrderItemInterface;
   use BitBag\SyliusProductBundlePlugin\Entity\ProductBundleOrderItemsAwareTrait;
   use Sylius\Component\Core\Model\OrderItem as BaseOrderItem;
   
   class OrderItem extends BaseOrderItem implements OrderItemInterface
   {
   
       use ProductBundleOrderItemsAwareTrait;
   
       public function __construct()
       {
           parent::__construct();
           $this->init();
       }
   
   }
    ```

7. Add configuration for extended product, order item and product variant repository:

    ```yaml
    # config/packages/_sylius.yaml
    sylius_product:
        resources:
            product:
                classes:
                    model: App\Entity\Product\Product
            product_variant:
                classes:
                    repository: BitBag\SyliusProductBundlePlugin\Repository\ProductVariantRepository
   sylius_order:
       resources:
           order_item:
               classes:
                   model: App\Entity\Order\OrderItem
    
    ```
    
8. Run database migration:

    ```
    $ cp vendor/bitbag/product-bundle-plugin/src/Migrations/Version20210126022620.php
    $ bin/console doctrine:migrations:migrate
    ```

## Testing
```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn build
$ bin/console assets:install public -e test
$ bin/console doctrine:schema:create -e test
$ bin/console server:run 127.0.0.1:8080 -d public -e test
$ open http://localhost:8080
$ vendor/bin/behat
```

## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/.
