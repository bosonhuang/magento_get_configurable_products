<?php
/*
 *
 * NOTICE OF LICENSE
 *
 * Ther is no license at all. Free to use.
 * Credit to Boson @ bosonhuang.com
 *
 *
 * USAGE
 *
 * This script generates table-viewed all configurable products output on screen.
 * 
 * 1. Put this file to root of your Magento installation folder.
 * 2. Type in URL http://www.example.com/getConfigProducts.php
 * 3. DO NOT CHANGE OR MODIFY OTHER CODES.
 * 
 */

// define Magento root path & get Mage class
define('MAGENTO', realpath(dirname(__FILE__)));
require_once MAGENTO . '/app/Mage.php';
Mage::app();

umask(0);

// retrieve configurable product collection
$collectionConfigurable = Mage::getResourceModel('catalog/product_collection')
  ->addAttributeToFilter('type_id', array('eq' => 'configurable'));

// only proceed if there are configurable products created in Magento
if(!empty($collectionConfigurable)) {
  /*
   * Define table output head row elements,
   *
   * @var array
   */
  $headArray = array(
    '#',
    'Product ID',
    'Product SKU',
    'Product Name',
    'Product Price',
    'Product URL',
    'Product Status',
    'Is Configurable Product?'
  );
  
  $itemArray = array();
  $index     = 1;
  
  foreach($collectionConfigurable as $_configurableproduct) {
    /*
     * get single configurable product model
     *
     * @var Model
     */
    $product      = Mage::getModel('catalog/product')->load($_configurableproduct->getId());
    
    /*
     * Define table output content row elements
     *
     * @var array
     */
    $productArray = array(
      $index,
      $product->getId(),
      $product->getSku(),
      $product->getName(),
      $product->price,
      $product->url_path,
      $product->isAvailable() ? 'In Stock' : 'Out of Stock',
      $product->isConfigurable() ? 'Yes' : 'No'
    );
    
    // add each product output array to table content row array
    array_push($itemArray, $productArray);
    
    $index++;
  }
  
  
  // output configurable product table
  echo getTable($headArray, $itemArray);
}

/*
 * Generate table output
 *
 * @param array $headArray - table head elements
 * @param array $itemArray - table content elements
 * @return string
 */
function getTable($headArray, $itemArray) {
  $countHead   = itemCount($headArray);
  $countItem   = itemCount($itemArray);
  $tableString = '<table>';
  
  for($i = 0; $i < $countHead; $i++) {
    $tableString .= '<col width="auto">';
  }
  
  if($countHead > 0 && $countItem > 0) {
    $tableString .= getTableRow($headArray, 'th', $countHead);
    $tableString .= getTableRow($itemArray, 'td', $countHead);
  } else
    $tableString .= getTableRow(array());
  
  $tableString .= '</table>';
  
  return $tableString;
}

/*
 * Generate table rows output
 *
 * @param array $arrayList - table row elements
 * @param String $flag     - table row HTML tags
 * @param int $arrayCount  - table row elements size
 * @return string
 */
function getTableRow($arrayList, $flag = '', $arrayCount = 0) {
  if(empty($flag)) {
    $startTag = '<td align="right">';
    $endTag   = '</td>';
  } elseif($flag === 'th') {
    $startTag = '<th align="right">';
    $endTag   = '</th>';
  } elseif($flag === 'td') {
    $startTag = '<td align="right">';
    $endTag   = '</td>';
  }
  
  $tableHeadString = '';
  // output table head
  if(itemCount($arrayList) == $arrayCount) {
    $tableHeadString .= '<tr>';
    foreach($arrayList as $arrayItem) {
      $tableHeadString .= $startTag . $arrayItem . $endTag;
    }
    $tableHeadString .= '</tr>';
  }
  // output table content
  else {
    foreach($arrayList as $listItem) {
      $tableHeadString .= '<tr>';
      if(itemCount($listItem) == $arrayCount) {
        foreach($listItem as $item) {
          $tableHeadString .= $startTag . $item . $endTag;
        }
      }
      $tableHeadString .= '</tr>';
    }
  }
  
  return $tableHeadString;
}

/*
 * count row element size
 *
 * @param array $arrayList - table row elements
 * @return int
 */
function itemCount($arrayList) {
  if(is_array($arrayList) && !empty($arrayList))
    return count($arrayList);
  else
    return 0;
}
