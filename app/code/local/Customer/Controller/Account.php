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
        "verifyEmail",
        "verifyOtp",
        "resetPassword"
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
        $customer_id =  $this->getSession()->get('customer_id');
        $customer = Mage::getModel('customer/account')->load($customer_id);
        $isPasMatch = password_verify($data['oldpassword'], $customer->getPasswordHash());
        if (!$isPasMatch) {
            echo json_encode(["success" => false, "message" => "you entered wrong password"]);
        } else if (!($data['newpassword'] === $data['confirmpassword'])) {
            echo json_encode(["success" => false, "message" => "new password and confirm password not match"]);
        } else {
            Mage::getModel('customer/account')
                ->setCustomerId($customer_id)
                ->setPasswordHash(password_hash($data['newpassword'], PASSWORD_DEFAULT))
                ->save();
            echo json_encode(["success" => true, "message" => "Password Changed Successfully!"]);
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
    public function resetPasswordAction()
    {
        $data = $this->getRequest()->getParams();
        $customer_id = $this->getSession()->get('customer_id');
        if (!empty($customer_id)) {
            if (!($data['newpassword'] === $data['confirmpassword'])) {
                echo json_encode(["success" => false, "message" => "new password and confirm password not match"]);
            } else {
                Mage::getModel('customer/account')
                    ->setCustomerId($customer_id)
                    ->setPasswordHash(password_hash($data['newpassword'], PASSWORD_DEFAULT))
                    ->save();
                echo json_encode(["success" => true, "message" => "Password Reset Successfully!"]);
                $this->getSession()->remove('customer_id');
            }
        } else {
            echo json_encode(["success" => false, "message" => "Please verify email again!"]);
        }
    }
    public function verifyOtpAction()
    {
        // Mage::log($_SESSION);
        $otpinput = $this->getRequest()->getParams()['otpinput'];
        $otp = $this->getSession()->get('otp');
        // echo $otp;
        // echo $otpinput;
        if (!empty($otp)) {
            if ($otpinput == $otp) {
                echo json_encode(["success" => true, "message" => "otp verifyied"]);
                $this->getSession()->remove('otp');
            } else {
                echo json_encode(["success" => false, "message" => "invalid otp! please enter valid otp"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "error! send otp again"]);
        }
    }
    public function verifyEmailAction()
    {
        $email = $this->getRequest()->getParams()['email'];
        $mail = new PHPMailer(true);
        $otp = rand(1000, 9999);
        $customer_id = Mage::getModel('customer/account')
            ->load($email, "email")
            ->getCustomerId();
        if (empty($customer_id)) {
            echo json_encode(["success" => false, "message" => "user not found"]);
            $this->getSession()->remove('otp');
            $this->getSession()->remove('customer_id');
            return;
        }
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP Server (Gmail, Outlook, etc.)
            $mail->SMTPAuth = true;
            $mail->Username = 'panchalraghu112@gmail.com'; // Replace with your email
            $mail->Password = 'cfzl kmxk apeg khzr'; // Replace with your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            // Email Details
            $mail->setFrom('panchalraghu112@gmail.com', 'Vishal Panchal');
            $mail->addAddress($email);
            // echo $otp;
            $mail->Subject = "Your One-Time Password (OTP)";
            $mail->Body = "Dear User,\n\nYour OTP is: $otp\n\nThis OTP is valid for 10 minutes. Do not share it.";

            if ($mail->send()) {
                // echo "success";
                echo json_encode(["success" => true, "message" => "OTP sent to $email"]);
                $this->getSession()->set('otp', $otp);
                $this->getSession()->set('customer_id', $customer_id);
            } else {
                // echo "error";
                echo json_encode(["success" => false, "message" => "Failed to send OTP."]);
                $this->getSession()->remove('otp');
                $this->getSession()->remove('customer_id');
            }
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Mailer Error: " . $mail->ErrorInfo]);
            $this->getSession()->remove('otp');
            $this->getSession()->remove('customer_id');
        }
    }
    public function logoutAction()
    {
        $session = Mage::getSingleton('core/session');
        if ($session->get('customer_id')) {
            $session->remove('customer_id');
        }
        $this->redirect('customer/account/login');
        $this->getRequest()->getMessageModel()->addMessage('success', "successfully logout!");
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
            $this->getRequest()->getMessageModel()->addMessage('success', "successfully login");
        } else {
            $session->remove('customer_id');
            $this->redirect('customer/account/login');
            $this->getRequest()->getMessageModel()->addMessage('warning', "Wrong credentials!");
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
        if ($customerId) {
            $session = Mage::getSingleton('core/session');
            $session->set('customer_id', $customerId);
            $this->redirect('customer/account/dashboard');
        } else {
            $this->redirect('customer/account/registration');
        }
    }
}
