<?php
class PayPal_Controller_Transaction extends Core_Controller_Front_Action
{
    public function startAction()
    {
        $totalAmount = Mage::getModel('checkout/session')->getCart()->getTotalAmount();
        $paypal = new PayPal_Init();
        $paypal = $paypal->getApiContext();
        $payer = new PayPal\Api\Payer();

        $payer->setPaymentMethod('paypal');

        $amount = new PayPal\Api\Amount();
        $amount->setTotal($totalAmount)->setCurrency('USD');

        $transaction = new PayPal\Api\Transaction();
        $transaction->setAmount($amount)->setDescription('Payment for Order #1234');

        $redirectUrls = new PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(Mage::getBaseUrl() . 'paypal/transaction/success')
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
    }
    public function successAction()
    {
        $paypal = new PayPal_Init();
        $paypal = $paypal->getApiContext();

        if (!isset($_GET['paymentId'], $_GET['PayerID'])) {
            die("Payment failed or canceled.");
        }

        $paymentId = $_GET['paymentId'];
        $payerId = $_GET['PayerID'];

        try {
            // Retrieve the payment by ID
            $payment = PayPal\Api\Payment::get($paymentId, $paypal);

            // Create an execution object
            $execution = new PayPal\Api\PaymentExecution();
            $execution->setPayerId($payerId);

            // Execute the payment
            $result = $payment->execute($execution, $paypal);
            // Check if the payment was successful
            if ($result->getState() == 'approved') {
                echo "Payment successful! Transaction ID: " . $result->getId();
                // Mage::log($_GET);
                // die;
                $this->redirect("checkout/cart_order/convert?transacionId={$result->getId()}");
            } else {
                echo "Payment not approved.";
            }
        } catch (Exception $ex) {
            echo "Payment execution error: " . $ex->getMessage();
        }
    }
    public function cancelAction() {}
}
