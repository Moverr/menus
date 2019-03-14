<?php 

class CustomerData {

    private $clientprofileID;
    private $profileactive;
    private $customeractive;
    private $profile_pin_status;
    private $customerNames;
    private $profileActiveStatus;
    private $customerActiveStatus;
    private $serviceList;
    private $aliases;

    function __construct() {
        
    }

    public function getClientprofileID() {
        return $this->clientprofileID;
    }

    public function getProfileactive() {
        return $this->profileactive;
    }

    public function getCustomeractive() {
        return $this->customeractive;
    }

    public function getProfile_pin_status() {
        return $this->profile_pin_status;
    }

    public function getCustomerNames() {
        return $this->customerNames;
    }

    public function getProfileActiveStatus() {
        return $this->profileActiveStatus;
    }

    public function getCustomerActiveStatus() {
        return $this->customerActiveStatus;
    }

    public function getServiceList() {
        return $this->serviceList;
    }

    public function getAliases() {
        return $this->aliases;
    }

    public function setClientprofileID($clientprofileID) {
        $this->clientprofileID = $clientprofileID;
        return $this;
    }

    public function setProfileactive($profileactive) {
        $this->profileactive = $profileactive;
        return $this;
    }

    public function setCustomeractive($customeractive) {
        $this->customeractive = $customeractive;
        return $this;
    }

    public function setProfile_pin_status($profile_pin_status) {
        $this->profile_pin_status = $profile_pin_status;
        return $this;
    }

    public function setCustomerNames($customerNames) {
        $this->customerNames = $customerNames;
        return $this;
    }

    public function setProfileActiveStatus($profileActiveStatus) {
        $this->profileActiveStatus = $profileActiveStatus;
        return $this;
    }

    public function setCustomerActiveStatus($customerActiveStatus) {
        $this->customerActiveStatus = $customerActiveStatus;
        return $this;
    }

    public function setServiceList($serviceList) {
        $this->serviceList = $serviceList;
        return $this;
    }

    public function setAliases($aliases) {
        $this->aliases = $aliases;
        return $this;
    }

}
