<?php

include_once __DIR__.'/Informations.php';

class LocationPrice{
    
    
    const PITCH_TENT_WITHOUT_ELECTRICITY = 'Emplacement tente sans electricité';
    const PITCH_TENT_WITH_ELECTRICITY = 'Emplacement tente avec electricité';
    const PITCH_CARAVAN_WITHOUT_ELECTRICITY = 'Emplacement caravane sans electricité';
    const PITCH_CARAVAN_WITH_ELECTRICITY = 'Emplacement caravane avec electricité';
    
    private $informations;
        
    private $locationPrice = 4.7;
    private $childrenPriceFromOneToTenYears = 2.7;
    private $adultPrice = 5;
    private $electricalConnectionPrice = 3.6;
    private $additionalTentPrice = 1;
    private $additionalCarPrice = 1;
    private $visitorsPrice = 1;
    private $adultsTouristTax = 0.5;
    
    public function __construct(Informations $informations) {
        $this->informations = $informations;
    }
    public function calculatePrice(){
        // die('$price');
        $price = 0;
       
        $days = $this->informations->getNumberOfDaysBooked();

        $price += $this->getLocationPrice() * $days;
        
       
        # Avec adultes
        $price += $this->getAdultPrice() * $this->informations->getNumberOfAdults() * $days;
        
        # Avec enfants entre 1 et 10 ans
        $price += $this->getChildrenPriceFromOneToTenYears() * $this->informations->getNumberOfChildrenAged10To18Years() * $days;
       
        # Avec électricité
        if(in_array($this->informations->getReservationType(),[self::PITCH_CARAVAN_WITH_ELECTRICITY,self::PITCH_TENT_WITH_ELECTRICITY])){
            $price += $this->getElectricalConnectionPrice() * $days; 
        }
        
        return $price;
    }
    
    public function getLocationPrice() {
        return $this->locationPrice;
    }

    public function getChildrenPriceFromOneToTenYears() {
        return $this->childrenPriceFromOneToTenYears;
    }

    public function getAdultPrice() {
        return $this->adultPrice;
    }

    public function getElectricalConnectionPrice() {
        return $this->electricalConnectionPrice;
    }

    public function getAdditionalTentPrice() {
        return $this->additionalTentPrice;
    }

    public function getAdditionalCarPrice() {
        return $this->additionalCarPrice;
    }

    public function getVisitorsPrice() {
        return $this->visitorsPrice;
    }

    public function getAdultsTouristTax() {
        return $this->adultsTouristTax;
    }

    
    public function setLocationPrice($locationPrice) {
        $this->locationPrice = $locationPrice;
        return $this;
    }

    public function setChildrenPriceFromOneToTenYears($childrenPriceFromOneToTenYears) {
        $this->childrenPriceFromOneToTenYears = $childrenPriceFromOneToTenYears;
        return $this;
    }

    public function setAdultPrice($adultPrice) {
        $this->adultPrice = $adultPrice;
        return $this;
    }

    public function setElectricalConnectionPrice($electricalConnectionPrice) {
        $this->electricalConnectionPrice = $electricalConnectionPrice;
        return $this;
    }

    public function setAdditionalTentPrice($additionalTentPrice) {
        $this->additionalTentPrice = $additionalTentPrice;
        return $this;
    }

    public function setAdditionalCarPrice($additionalCarPrice) {
        $this->additionalCarPrice = $additionalCarPrice;
        return $this;
    }

    public function setVisitorsPrice($visitorsPrice) {
        $this->visitorsPrice = $visitorsPrice;
        return $this;
    }

    public function setAdultsTouristTax($adultsTouristTax) {
        $this->adultsTouristTax = $adultsTouristTax;
        return $this;
    }


}

