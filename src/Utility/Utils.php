<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utility;

/**
 * Description of UtilityConstants
 *
 * @author enesi
 */
trait Utils {

    //put your code here
    public static function getUtilGender() {
        return array("male", "female");
    }

    public static function getUtilCustomerTypes() {
        return array("individual", "organisation");
    }

    public static function getUtilTitles() {
        return array("Mr.", "Mrs.", "Mallam", "Mallama", "Hajiya", "Alhaji", "Master", "Dr.", "Prof.", "Mistress", "Miss", "Sir", "Pa", "Madam", "Oga", "Sheikh");
    }
    
    public static function getUtilProductQuantityMetrics(){
        return array("litres", "barrels", "gallons");
    }
    
    public static function getUtilCustomerStatus(){
        return array("active", "dormant");
    }
    
    public static function getUtilOrderStatus(){
        return array("pending", "invoiced", "partial-delivery", "delivered", "cancelled");
    }
    
    public static function getUtilOrderItemStatus(){
        return array("pending", "delivered", "disputed", "cancelled");
    }
    
    public static function getUtilInvoiceStatus(){
        return array("draft", "paid", "pending", "partial", "overpaid", "approved", "rejected", "cancelled");
    }
    
    public static function getUtilPaymentStatus(){
        return array("accepted", "diverted", "refunded", "cancelled");
    }
    
    public static function getUtilOrderDeliveryStatus(){
        return array("not-delivered", "partial-delivery", "delivered");
    }
    
    public static function getUtilPaymentOptions(){
        return array("cash", "bank-transfer", "bank-payment", "pos", "cheque", "mobile-transfer", "atm-transfer", "online-payment");
    }
    
    public static function getUtilTruckStatus(){
        return array("active", "inactive");
    }
    
    public static function getUtilUserStatus(){
        return array("enabled", "disabled");
    }
    
    public static function getUtilUserRoles(){
        return array("ROLE_MANAGER_SALES","ROLE_PERSONNEL_SALES", "ROLE_MANAGER_FACILITY", "ROLE_MANAGER_LOADING", "ROLE_PERSONNEL_LOADING");
    }
    
    public static function getUtilLoadingStatus(){
        return array("on-transit", "received-with-dispute", "received", "distribution", "distributed");
    }

        public function generateCustomerId($cid) {
        $id = "C";
        if ($cid < 10) {
            $id .= "00000";
        } elseif ($cid < 100) {
            $id .= "0000";
        } elseif ($cid < 1000) {
            $id .= "000";
        } elseif ($cid < 10000) {
            $id .= "00";
        } elseif ($cid < 100000) {
            $id .= "0";
        }
        $id .= $cid;
        return $id;
    }
    public function generateOrderId($oid) {
        $id = "ORD";
        if ($oid < 10) {
            $id .= "00000";
        } elseif ($oid < 100) {
            $id .= "0000";
        } elseif ($oid < 1000) {
            $id .= "000";
        } elseif ($oid < 10000) {
            $id .= "00";
        } elseif ($oid < 100000) {
            $id .= "0";
        }
        $id .= $oid;
        return $id;
    }


}
