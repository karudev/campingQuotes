<?php

include_once __DIR__.'/LocationPrice.php';
include_once __DIR__.'/CottagePrice.php';
/**
 * Classe permettant que calculer le prix à payer en fonction des informations soumises
 * @author Dolyveen Renault, Karudev Informatique <renault@karudev.fr> <06 36 92 36 23>
 */
class Informations {

    private $reservationType;
    private $beginDate;
    private $endDate;
    private $firstname;
    private $lastname;
    private $email;
    private $phone;
    private $numberOfAdults = 0;
    private $numberOfChildrenUnder10Years = 0;
    private $numberOfChildrenAged10To18Years = 0;
    private $zipCode;

    public function __construct() {
        
    }

    public function getTotalPrice() {
       
        $totalPrice = 0;
        $reservationType = $this->getReservationType();
        if(in_array($reservationType,[
        LocationPrice::PITCH_TENT_WITHOUT_ELECTRICITY,
        LocationPrice::PITCH_TENT_WITH_ELECTRICITY,
        LocationPrice::PITCH_CARAVAN_WITHOUT_ELECTRICITY,
        LocationPrice::PITCH_CARAVAN_WITH_ELECTRICITY])){
            
            $obj = new LocationPrice($this);
        }elseif($reservationType == CottagePrice::CHALET_WITH_TERRACE){
            $obj = new CottagePrice($this);
        }
            
        $totalPrice = $obj->calculatePrice();
        return $totalPrice;
    }
    
    public function getNumberOfDaysBooked(){
        $interval = $this->getEndDate()->diff($this->getBeginDate());
       // var_dump($interval); die();
        return (int) $interval->days;
        
    }

    public function getReservationType() {
        return $this->reservationType;
    }

    /**
     * 
     * @return DateTime
     */
    public function getBeginDate() {
        return $this->beginDate;
    }

    /**
     * 
     * @return DateTime
     */
    public function getEndDate() {
        return $this->endDate;
    }

    public function setReservationType($reservationType) {
        $this->reservationType = $reservationType;
        return $this;
    }

    public function setBeginDate(DateTime $beginDate) {
        $this->beginDate = $beginDate;
        return $this;
    }

    
    public function setEndDate(DateTime $endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getNumberOfAdults() {
        return $this->numberOfAdults;
    }

    public function getNumberOfChildrenUnder10Years() {
        return $this->numberOfChildrenUnder10Years;
    }

    public function getNumberOfChildrenAged10To18Years() {
        return $this->numberOfChildrenAged10To18Years;
    }

    public function getZipCode() {
        return $this->zipCode;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    public function setNumberOfAdults($numberOfAdults) {
        $this->numberOfAdults = $numberOfAdults;
        return $this;
    }

    public function setNumberOfChildrenUnder10Years($numberOfChildrenUnder10Years) {
        $this->numberOfChildrenUnder10Years = $numberOfChildrenUnder10Years;
        return $this;
    }

    public function setNumberOfChildrenAged10To18Years($numberOfChildrenAged10To18Years) {
        $this->numberOfChildrenAged10To18Years = $numberOfChildrenAged10To18Years;
        return $this;
    }

    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
        return $this;
    }

}
