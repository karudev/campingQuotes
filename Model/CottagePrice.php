<?php

include_once __DIR__.'/Informations.php';

class CottagePrice{
    
    
    const CHALET_WITH_TERRACE = 'Chalet avec terrasse 4-5 personnes- Provence';
  
    private $informations;
        
    private $twoPersons = [
        'period1' => [
            'week' => 180,
            'night' => 35
            ],
        'period2' => [
            'week' => 270,
            'night' => 45
            ],
        'period3' => [
            'week' => 480,
            ],
        ];
    private $threePersons = [
        'period1' => [
            'week' => 215,
            'night' => 40
            ],
        'period2' => [
            'week' => 305,
            'night' => 50
            ],
        'period3' => [
            'week' => 480,
            ],
        ];
    private $fourPersons = [
        'period1' => [
            'week' => 250,
            'night' => 45
            ],
        'period2' => [
            'week' => 340,
            'night' => 55
            ],
        'period3' => [
            'week' => 480,
            ],
        ];
    
    private $additionalTent = [
        'period1' => [
            'week' => 7,
            'night' => 1
            ],
        'period2' => [
            'week' => 7,
            'night' => 1
            ],
        'period3' => [
            'week' => 7,
            ],
        ];
    
    private $additionalPerson = [
        'period1' => [
            'week' => 35,
            'night' => 5
            ],
        'period2' => [
            'week' => 42,
            'night' => 6
            ],
        'period3' => [
            'week' => 45,
            ],
        ];
    
    private $additionalCar = [
        'period1' => [
            'week' => 7,
            'night' => 1
            ],
        'period2' => [
            'week' => 7,
            'night' => 1
            ],
        'period3' => [
            'week' => 7,
            ],
        ];
    
    private $touristTax = [
        'period1' => [
            'week' => 0.5,
            'night' => 0.5
            ],
        'period2' => [
            'week' => 0.5,
            'night' => 0.5
            ],
        'period3' => [
            'week' => 0.5,
            ],
        ];
    
    private $period = null;
    
    private $nbWeek = 0;
    
    private $nbNight = 0;
    
    public function __construct(Informations $informations) {
        $this->informations = $informations;
    }
    
    public function calculatePrice(){
        
        $price = 0;
        
        $this->setPeriod();
        
        //var_dump($this->getPeriod()); 
        $this->setNbWeekAndNight();
        
        $persons = $this->informations->getNumberOfAdults();
        $persons += $this->informations->getNumberOfChildrenAged10To18Years();
        $persons += $this->informations->getNumberOfChildrenUnder10Years();
        
        $priceByPersons = null;
        
        if($persons >= 4){
           $priceByPersons = $this->getFourPersons();  
        } elseif($persons == 3){
           $priceByPersons = $this->getThreePersons(); 
        } else {
           $priceByPersons = $this->getTwoPersons(); 
        }
        
        $nbWeek = $this->getNbWeek();
        $nbNight = $this->getNbNight();
        
        $additionnalPersonsPrice = $this->getAdditionalPerson(); 
        
        $weekPrice = $priceByPersons[$this->getPeriod()]['week'];
        $dayPrice = isset($priceByPersons[$this->getPeriod()]['night']) ? $priceByPersons[$this->getPeriod()]['night'] : 0;
        $additionnalPersonsPriceWeek = $additionnalPersonsPrice[$this->getPeriod()]['week'];
        $additionnalPersonsPriceDay = isset($additionnalPersonsPrice[$this->getPeriod()]['night']) ? $additionnalPersonsPrice[$this->getPeriod()]['night'] : 0;

        
        
        if($this->getPeriod() == 'period3'){
            
            // -5% à partir de la 2eme semaine
            if($nbWeek > 0){
               $price += $weekPrice; 
               $price += ($nbWeek - 1) * ($weekPrice - $weekPrice * 0.05); 
               
            }
            
            if($nbNight > 0){
                $price += $weekPrice;
            }
        }else{
            $price += $nbWeek * $weekPrice;
            $price += $nbNight * $dayPrice;

            
            
        }
        
        $additionnalPersons = floor($persons - 4);
        
        
        $price +=$additionnalPersons * $nbWeek * $additionnalPersonsPriceWeek;
        $price += $additionnalPersons * $nbNight * $additionnalPersonsPriceDay;
        
        
        
        echo '$persons = '.$persons;
        echo '<br/>$weekPrice = '.$weekPrice;
        echo '<br/>$nbWeek = '.$nbWeek;
        echo '<br/>$dayPrice = '.$dayPrice;
        echo '<br/>$nbNight = '.$nbNight;
        
        
       
        
        
        //die();
        
        return $price;
        
    }
    private function setNbWeekAndNight(){
        $tps = $this->informations->getEndDate()->getTimestamp() - $this->informations->getBeginDate()->getTimestamp();
        
        $days = $tps / 86400;
        $weeks = $days / 7;
        $weekAbs = floor($weeks);
        $daysRestants = round(($weeks - $weekAbs) * 7);
        
        
        echo '<br/>$days = '.$days;
        echo '<br/>$weekAbs = '.$weekAbs;
        echo '<br/>$weekAbs = '.$weekAbs;
        echo '<br/>$daysRestants = '.$daysRestants;
        
        $this->setNbWeek($weekAbs);
        $this->setNbNight($daysRestants);
        
        
    }
    public function getNbWeek() {
        return $this->nbWeek;
    }

    public function getNbNight() {
        return $this->nbNight;
    }

    public function setNbWeek($nbWeek) {
        $this->nbWeek = $nbWeek;
        return $this;
    }

    public function setNbNight($nbNight) {
        $this->nbNight = $nbNight;
        return $this;
    }

        
    public function getPeriod() {
        return $this->period;
    }

    public function setPeriod() {
        
        
        $beginDate = (int) $this->informations->getBeginDate()->format('md'); // 0430  
        $endDate = (int) $this->informations->getEndDate()->format('md');
        
        $period = null;
        
        
        if(($beginDate >= 429 && $beginDate < 618) || ($beginDate >= 827 && $beginDate < 925)){
           $period = 'period1'; // 29/04 au 18/06 et du 27/08 au 25/09 
        }elseif(($beginDate >= 618 && $beginDate < 709) || ($beginDate >= 820 && $beginDate < 827)){
           $period = 'period2'; // 18/06 au 09/07 et du 20/08 au 27/08 
        }elseif($beginDate >= 709 && $beginDate < 820){
           $period = 'period3'; // 09/07 au 20/08 
        }
        
        
        $this->period = $period;
        return $this;
    }

        
    
    
  
    public function getInformations() {
        return $this->informations;
    }

    public function getTwoPersons() {
        return $this->twoPersons;
    }

    public function getThreePersons() {
        return $this->threePersons;
    }

    public function getFourPersons() {
        return $this->fourPersons;
    }

    public function getAdditionalTent() {
        return $this->additionalTent;
    }

    public function getAdditionalPerson() {
        return $this->additionalPerson;
    }

    public function getAdditionalCar() {
        return $this->additionalCar;
    }

    public function getTouristTax() {
        return $this->touristTax;
    }

    public function setInformations($informations) {
        $this->informations = $informations;
        return $this;
    }

    public function setTwoPersons($twoPersons) {
        $this->twoPersons = $twoPersons;
        return $this;
    }

    public function setThreePersons($threePersons) {
        $this->threePersons = $threePersons;
        return $this;
    }

    public function setFourPersons($fourPersons) {
        $this->fourPersons = $fourPersons;
        return $this;
    }

    public function setAdditionalTent($additionalTent) {
        $this->additionalTent = $additionalTent;
        return $this;
    }

    public function setAdditionalPerson($additionalPerson) {
        $this->additionalPerson = $additionalPerson;
        return $this;
    }

    public function setAdditionalCar($additionalCar) {
        $this->additionalCar = $additionalCar;
        return $this;
    }

    public function setTouristTax($touristTax) {
        $this->touristTax = $touristTax;
        return $this;
    }


}

