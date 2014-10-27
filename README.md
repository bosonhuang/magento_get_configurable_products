magento_get_configurable_products
=================================

[Created by Boson](http://www.bosonhuang.com)

Output list of all configurable products on screen in table view.

Need help? Email [Boson](mailto:boson@bosonhuang.com)

USAGE
=====

1. Put this script to root of you Magento installation folder.
2. Run file in browser: http://www.yourStoreURL.com/getConfigProducts.php
3. Put attribute name to (Array type) $headArray for output table head row elements. Search $headArray for 1st result.
4. Put associated product attribute values to (Array type) $itemArray for output content. Search $itemArray for 2nd result.

$headArray will be displayed:
-----------------------------

    '#',
    'Product ID',
    'Product SKU',
    'Product Name',
    'Product Price',
    'Product URL',
    'Product Status',
    'Is Configurable Product?'

Table to be displayed in similar format:
----------------------------------------

    # | Product ID | Product SKU | Product Name | Product Price | Product URL | Product Status | Is Configurable Product?
    --- | --- | --- | --- | --- | --- | --- | ---
