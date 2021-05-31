Magento 2 Micro Features Module
============================

by [Orba](https://orba.co)

## Features list

### 1. Admin name added to order comment

In admin panel, on order details view, show for each order comment the name of the admin who added the comment.

### 2. Config for defining admin only payment methods

In admin panel, in Stores > Configuration > Sales > Payment Methods > General Settings > Admin Only one can switch some payment methods to be available only for orders created in admin panel.

### 3. Add possibility to brand system.xml config fields

One can add branding (logo) to system.xml config field by applying the following code snippet:

```xml
<field ...>
    ...
    <attribute type="brand">{{ brand_code }}</attribute>
</field>
```

where `{{ brand_code }}` is a code of the brand defined in `etc/adminhtml/di.xml` inside `Orba\MicroFeatures\Model\System\Config\BrandProvider` type.

In this module brand with code `orba` is provided. All custom configs added by this module are branded using it.

You can specify merchant's brand in your custom module for merchant's custom configs.
