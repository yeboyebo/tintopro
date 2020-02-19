<?php
namespace Yeboyebo\Sync\Model;

class ProductUrlPathGenerator extends \Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator
{
    /**
     * Ignore attribute url_path. Always use url_key instead.
     *
     * @inheritdoc
     */
    public function getUrlPath($product, $category = null)
    {
    	$log = \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface');
    	//$log->debug($product->getSku());

        $path = $product->getUrlKey()
            ? $this->prepareProductUrlKey($product)
            : $this->prepareProductDefaultUrlKey($product);
        //$log->debug($path." ".$product->getId());
        return $path."-".$product->getId();
        return $category === null
            ? $path
            : $this->categoryUrlPathGenerator->getUrlPath($category) . '/' . $path;
    }
}


?>