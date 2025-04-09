<?php

// use PayPal\Rest\ApiContext;

class Catalog_Controller_Product extends Core_Controller_Customer_Action
{

    protected $_allowedActions = ['view', 'list', 'test'];
    public function viewAction()
    {
        $layout = Mage::getBlock('core/layout');
        $view = $layout->createBlock('catalog/product_view');
        $layout->getChild('content')->addChild('view', $view);
        $layout->getChild('head')->addJs('page/catalog/product/view.js');
        $layout->toHtml();
    }
    public function addReviewAction()
    {
        $review = $this->getRequest()->getParam('catalog_product_review');
        $review['customer_id'] = $this->getSession()->get('customer_id');
        Mage::getModel('catalog/product_review')
            ->setData($review)
            ->save();
        $this->redirect("catalog/product/view?id={$review['product_id']}");
    }
    public function listAction()
    {
        $layout = Mage::getBlockSingleton('core/layout');
        // if (0) {
        //     $layout->removeChild('header');
        // }
        $list = $layout->createBlock('catalog/product_list')
            ->setTemplate('catalog/product/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->getChild('head')->addJs('page/catalog/product/list.js');
        $layout->toHtml();
    }
    public function testAction()
    {
        $paypal = new PayPal_Init();
        // $apiContext = new ApiContext();
        // Mage::log($apiContext);
        $paypal = $paypal->getApiContext();
        $payer = new PayPal\Api\Payer();

        $payer->setPaymentMethod('paypal');

        $amount = new PayPal\Api\Amount();
        $amount->setTotal('10.00')->setCurrency('USD');

        $transaction = new PayPal\Api\Transaction();
        $transaction->setAmount($amount)->setDescription('Payment for Order #1234');

        $redirectUrls = new PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl("http://localhost/paypal/paypal_success.php")
            ->setCancelUrl("http://yourwebsite.com/paypal_cancel.php");

        $payment = new PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($paypal);
            header("Location: " . $payment->getApprovalLink());
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }





        // $filter = Mage::getModel('catalog/filter')->getProductCollection();
        // echo '<pre>';
        // print_r($filter->prepareQuery());
        // echo '</pre>';
        // $collections = Mage::getModel("catalog/product")
        //     ->getcollection()
        //     ->addAttributeToSelect(["series", "material", "weight"]);
        // ->load("41");
        // ->limit(5);
        // echo "<pre>";
        // print_r($collections->getData());
        // echo "</pre>";

        // ->getCollection()
        // ->addAttributeToSelect(["material", "weight"]);

        // ->limit(5);
        // print_r($collection->getData());
        // echo '</pre>';
        // $product = Mage::getModel('catalog/product');
        // $product->load(37)->getData();
        // echo "<pre>";
        // print_r($product);
        // $product = Mage::getModel('catalog/product');
        // print_r($product);
        // $product = Mage::getSingleton('catalog/product');
        // $product->load(37)->getData();
        // $product2 = Mage::getSingleton('catalog/product');
        // print_r($product);
        // print_r($product2);
        // $product2->setName('123');
        // echo $product->getName();
        // print_r($product);


        // ->getCollection()
        // ->addFieldToFilter('product_id', ['<' => 40])
        // ->addFieldToFilter('product_id', ['IN' => [2, 3, 4]])
        // ->leftJoin('catlog_category', 'catlog_category.category_id = catlog_product.category_id', ['category_name' => 'name'])
        // ->rightJoin('catlog_category', 'catlog_category.category_id = catlog_product.category_id', ['category_name' => 'name']);
        // ->innerJoin('catlog_category', 'catlog_category.category_id = catlog_product.category_id', ['category_name' => 'name']);
        // ->join('catlog_category', 'catlog_category.category_id = catlog_product.category_id', ['category_name' => 'name']);
        // ->fullJoin('catlog_category', ['category_name' => 'name']);
        // ->selfJoin(['A', 'B'], ['name' => 'A.name', 'pr' => 'B.price']);
        // ->crossJoin('catlog_category', ['category_name' => 'name']);
        // ->naturalJoin('catlog_category', ['category_name' => 'name']);
        // ->groupBy(['name', 'price'])
        // ->having('COUNT(*)', ['<' => 40]);
        // ->orderBy(['product_id DESC', 'name ASC'])
        // ->limit(1, 2);
        // $product->prepareQuery();
    }
}
