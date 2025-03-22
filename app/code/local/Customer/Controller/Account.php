<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Customer_Controller_Account extends Core_Controller_Customer_Action
{
    // login
    // logout
    // registrtion
    // changepas
    // forgtpas
    protected $_allowedActions = [
        "login",
        "validate",
        "registration",
        "save",
        "forgetpassword",
        "sendotp"
    ];
    public function dashboardAction()
    {
        $layout = Mage::getBlock('core/layout');
        $index = $layout->createBlock('customer/account_dashboard');
        $layout->getChild('content')->addChild('index', $index);
        $layout->toHtml();
    }
    public function changepasswordAction()
    {
        $layout = Mage::getBlock('core/layout');
        $index = $layout->createBlock('customer/account_changepassword');
        $layout->getChild('content')->addChild('index', $index);
        $layout->toHtml();
    }
    public function changepasPostAction()
    {
        $data = $this->getRequest()->getParams();
        Mage::log($data);
        $customer_id =  $this->getSession()->get('customer_id');
        $customer = Mage::getModel('customer/account')->load($customer_id);
        $isPasMatch = password_verify($data['oldpassword'], $customer->getPasswordHash());
        if (!$isPasMatch) {
            echo json_encode(["success" => false, "message" => "wrong password"]);
        } else if ($data['newpassword'] === $data['confirmpassword']) {
            echo json_encode(["success" => false, "message" => "new password and confirm password not match"]);
        } else {
        }
    }
    public function registrationAction()
    {
        $layout = Mage::getBlock('core/layout');
        $registration = $layout->createBlock('customer/account_registration');
        $layout->getChild('content')
            ->addChild('registration', $registration);
        $layout->toHtml();
    }

    public function loginAction()
    {
        $layout = Mage::getBlock('core/layout');
        $login = $layout->createBlock('customer/account_login');
        $layout->getChild('content')->addChild('login', $login);
        $layout->toHtml();
    }
    public function forgetpasswordAction()
    {
        $layout = Mage::getBlock('core/layout');
        $login = $layout->createBlock('customer/account_forgetpassword');
        $layout->getChild('content')->addChild('login', $login);
        $layout->toHtml();
    }
    public function sendotpAction()
    {
        $email = $this->getRequest()->getParams()['email'];
        $mail = new PHPMailer(true);
        $otp = rand(1000, 9999);
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP Server (Gmail, Outlook, etc.)
            $mail->SMTPAuth = true;
            $mail->Username = 'vishalvishal00339@gamil.com'; // Replace with your email
            $mail->Password = 'nhqo vmqu bvlp iyme'; // Replace with your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email Details
            $mail->setFrom('vishalvishal00339@gamil.com', 'Vishal Panchal');
            $mail->addAddress($email);
            // echo $otp;
            $mail->Subject = "Your One-Time Password (OTP)";
            $mail->Body = "Dear User,\n\nYour OTP is: $otp\n\nThis OTP is valid for 10 minutes. Do not share it.";

            if ($mail->send()) {
                // echo "success";
                echo json_encode(["success" => true, "message" => "OTP sent to $email"]);
            } else {
                // echo "error";
                echo json_encode(["success" => false, "message" => "Failed to send OTP."]);
            }
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Mailer Error: " . $mail->ErrorInfo]);
        }
    }
    public function logoutAction()
    {
        $session = Mage::getSingleton('core/session');
        if ($session->get('customer_id')) {
            $session->remove('customer_id');
        }
        $this->redirect('customer/account/login');
    }
    public function validateAction()
    {
        $session = Mage::getSingleton('core/session');
        $credencials = $this->getRequest()->getParams();
        $customer = Mage::getModel('customer/account')->load($credencials['email'], 'email');
        if (
            $customer->getEmail() === $credencials['email'] &&
            password_verify($credencials['password'], $customer->getPasswordHash())
        ) {
            $session->set('customer_id', $customer->getCustomerId());
            $this->redirect('customer/account/dashboard');
        } else {
            $session->remove('customer_id');
            $this->redirect('customer/account/login');
        }
    }
    public function saveAction()
    {
        $customerData = $this->getRequest()->getParam('customer_account');
        if (empty($customerData['customer_id'])) {
            $customerData['password_hash'] = password_hash($customerData['password'], PASSWORD_DEFAULT);
            unset($customerData['password']);
            unset($customerData['customer_id']);
        }
        // Mage::log($customerData);
        // die;
        $customerId = Mage::getModel('customer/account')
            ->setData($customerData)
            ->save()
            ->getCustomerId();
        $session = Mage::getSingleton('core/session');
        if ($customerId) {
            $session->set('customer_id', $customerId);
            $this->redirect('customer/account/dashboard ');
        } else {
            $this->redirect('customer/account/registration');
        }
    }
}