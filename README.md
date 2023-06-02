Magento 2 Micro Features Module
============================

Created by [Lingaro](https://lingarogroup.com/)

## Features list

### 1. Admin name added to order comment

In admin panel, on order details view, show for each order comment the name of the admin who added the comment.

### 2. Config for defining admin only payment methods

In admin panel, in `Stores > Configuration > Sales > Payment Methods > General Settings > Admin Only` one can switch some payment methods to be available only for orders created in admin panel.

### 3. Possibility to brand system.xml config fields

One can add branding (logo) to system.xml config field by applying the following code snippet:

```xml
<field ...>
    ...
    <attribute type="brand">{{ brand_code }}</attribute>
</field>
```

where `{{ brand_code }}` is a code of the brand defined in `etc/adminhtml/di.xml` inside `Lingaro\MicroFeatures\Model\System\Config\BrandProvider` type.

In this module brand with code `lingaro` is provided. All custom configs added by this module are branded using it.

You can specify merchant's brand in your custom module for merchant's custom configs.

### 4. Config for hiding Downloadable Products section on Customer Account page

In admin panel, in `Stores > Configuration > Catalog > Downloadable Products Options > Show Link in Customer Account` one can hide Downloadable Products section on Customer Account page.

### 5. Config for disabling necessity of opt-in to Login as Customer feature

In admin panel, in `Stores > Configuration > Customers > Login as Customer > Is Login as Customer opt-in needed` one can disable necessity of opt-in to Login as Customer feature.
If this config is set to "No", admins will be able to login as any customer.

### 6. Config for always expanding cart items block in Checkout

In admin panel, in `Stores > Configuration > Sales > Checkout > Checkout Options > Always Expand Items Block` one can force Items Block to be always expanded on Checkout load.

### 7. Config for disabling Product Comparison

In admin panel, in `Stores > Configuration > Catalog > Catalog > Storefront > Enable Product Comparison` one can disable Product Comparison add-to buttons and sidebar on frontend.

### 8. Config for defining input masks for Customer phone number and postcode

In admin panel, in `Stores > Configuration > Customers > Customer Configuration > Name and Address Options > Telephone Input Mask / Postcode Input Mask` one can add input masks for phone number and postcode fields visible in Address Book (in My Account) and in Checkout.

Watchout: The config is for projects in which in one website you can create addresses for one specific country. For multi-country websites you need to customize `\Lingaro\MicroFeatures\ViewModel\Customer\Address\Form\InputMask`.

### 9. Config for enabling "Upsert quantity" widget in place of "Add to cart" buttons

In admin panel, in `Stores > Configuration > Catalog > Catalog > Storefront > Enable Upsert Quantity` one can enable "Upsert Quantity" widget. When the feature is enabled, all "Add to cart" buttons for simple, virtual and downloadable products on catalog pages (listings, details, comparison list, product widgets) will be replaced with "Upsert Quantity" widgets that are synchronized with mini-cart and always show the quantity that is currently inside user's cart.

### 10. Config for enabling AJAX for Footer Newsletter form

In admin panel, in `Stores > Configuration > Customers > Newsletter > General Options > Enable AJAX in Footer Form` one can force Footer Newsletter form to use AJAX and not reload page after each submission. 


## Supported Magento versions

* 2.4.0
* 2.4.1
* 2.4.2
* 2.4.3
* 2.4.4
* 2.4.5