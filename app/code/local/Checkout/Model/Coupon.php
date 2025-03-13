<?php
class Checkout_Model_Coupon
{
    public function getAllCoupons()
    {
        $coupons = [
            "NEWYEAR15"  => "15%",
            "FLAT200"    => "200₹",
            "SPRING5"    => "5%",
            "DISCOUNT50" => "50₹",
            "MEGA50"     => "50%"
        ];
        return $coupons;
    }
    public function calculateDiscount($couponCode, $subTotal)
    {
        $coupons = $this->getAllCoupons();
        if (isset($coupons[$couponCode])) {
            $discountstr = $coupons[$couponCode];
            if (str_contains($discountstr, '%')) {
                $discountPrice = (str_replace("%", "", $discountstr) * $subTotal) / 100;
            } else {
                $discountPrice = str_replace("₹", "", $discountstr);
            }
            // echo '<pre>';
            // print_r($discountPrice);
            // echo '</pre>';
            // die;
            return $discountPrice;
        }
        return 0;
    }
}
