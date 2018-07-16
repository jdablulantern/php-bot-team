<?php

$firstNames = array('Alex', 'Brian', 'Chris', 'Daniel', 'Eric', 'Frank', 'Griffin', 'Harold', 'Isaiah', 'John', 'Kevin', 'Larry', 'Michael', 'Nick', 'Oliver', 'Paul', 'Quincy', 'Richard', 'Stephen', 'Travis', 'Ulysses', 'Victor', 'William', 'Xander', 'Yusef', 'Zeke');
$lastNames = array('Anderson', 'Boston', 'Chase', 'Davidson', 'Engram', 'Fox', 'Grant', 'Harrison', 'Irving', 'Johnson', 'Keith', 'Livingston', 'Matthews', 'Nelson', 'Owens', 'Price', 'Quick', 'Robertson', 'Smith', 'Tyler', 'Ulman', 'Vaughn', 'Williams', 'Xavier', 'Young', 'Zachary');

class bot {
    const MAX_PLAYER_TAS = 100;

    public $id = '';
    public $firstName = '';
    public $lastName = '';
    public $fullName = '';
    public $strength = 0;
    public $speed = 0;
    public $agility = 0;
    public $tas = 0;

    public function __construct($first, $last, $id) 
    {
        $this->generateName($first, $last);
        $this->generateId($id);
    }

    public function addAttribute() 
    {
        $this->tas++;
        $attr = rand(1,3);
        switch($attr){
            case 1:
                $this->strength++;
                break;
            case 2:
                $this->speed++;
                break;
            case 3:
                $this->agility++;
                break;
        }
    }

    private function generateName($firstId, $lastId) 
    {
        global $firstNames;
        global $lastNames;
        $this->firstName = $firstNames[$firstId];
        $this->lastName = $lastNames[$lastId];
        $this->fullName = $this->firstName.' '.$this->lastName;
        return $this->fullName;
    }

    private function generateId($id) 
    {
        $this->id = substr(strtoupper($this->firstName), 0, 1).substr(strtoupper($this->lastName), 0, 2).$id;
        return $this->id;
    }


}

class team {
    const MAX_TEAM_TAS = 175;
    const MAX_STARTERS = 10;
    const MAX_PLAYERS = 15;

    private $maxUniqueNumber = 0;
    private $currentTas = 0; 
    private $generatedIds = array();
    public $starters = array();
    public $bench = array();
    public $players = array();

    public function __construct() 
    {
        $this->getMaxUniqueNumber();
        $this->createPlayers();
        $this->generatePlayerAttributes();
        usort($this->players, array($this, 'sortPlayers'));
        $this->setStarters();
    }

    private function createPlayers()
    {
        $playerCount = count($this->players);
        global $firstNames;
        global $lastNames;
        $first = $this->generateRandomUniqueNumbers(count($firstNames) - 1);
        $last = $this->generateRandomUniqueNumbers(count($lastNames) - 1);
        $ids = $this->generateRandomUniqueNumbers(100);
        while($playerCount < self::MAX_PLAYERS) {
            $player = new bot($first[$playerCount], $last[$playerCount], $ids[$playerCount]);
            $this->players[] = $player;
            $playerCount++;
        }
    }

    private function generatePlayerAttributes() 
    {
        $playerIndex = 0;
        $mean = 0;
        $tasTop = 0;
        $tasValue = 0;
        $playerTas = array();
        $tasRemaining = self::MAX_TEAM_TAS;

        while($playerIndex < self::MAX_PLAYERS) {
            if ($playerIndex == 0) {
                $this->currentTAS = rand(1, $this->maxUniqueNumber);
                $mean = floor((self::MAX_TEAM_TAS - $this->maxUniqueNumber)/(self::MAX_PLAYERS - 1));
                $firstTasValue = $tasValue = $mean + ((self::MAX_PLAYERS - 1)/2);
                $playerTas[$playerIndex] = $this->currentTAS;
            } else if($playerIndex == (self::MAX_PLAYERS - 1)) {
                if ( $playerTas[0] > $this->maxUniqueNumber - $firstTasValue) {
                    $this->currentTAS += $tasValue;
                    $playerTas[$playerIndex] = $tasValue;
                    $tasRemaining = self::MAX_TEAM_TAS - $this->currentTAS;
                    $playerTas[1] += $tasRemaining;
                } else {
                    $this->currentTAS += $tasRemaining;
                    $playerTas[$playerIndex] = $tasRemaining;
                }
            } else {
                if($tasValue == $playerTas[0]) {
                    $tasValue--;
                }
                $this->currentTAS += $tasValue;
                $playerTas[$playerIndex] = $tasValue;
                $tasValue--;
            }

            $tasRemaining = self::MAX_TEAM_TAS - $this->currentTAS;
            $playerIndex++;            
                
        }
        for($index = 0; $index < self::MAX_PLAYERS; $index++){
            for($j = 0; $j < $playerTas[$index]; $j++) {
                $this->players[$index]->addAttribute();
            }
        }
    }

    private function sortPlayers(bot $a, bot $b)
    {
        return $b->tas - $a->tas;
    }

    private function setStarters()
    {
        $total = count($this->players);
        for($index = 0 ; $index < $total; $index++) {
            if ($index < self::MAX_STARTERS) {
                $this->starters[] = $this->players[$index]->id;
            } else {
                $this->bench[] = $this->players[$index]->id;
            }
        } 
    }

    private function getMaxUniqueNumber() {
        $uniquePlayerTotal = 0;
        $uniquePlayerCount = self::MAX_PLAYERS - 1;
        for ($index = 1; $index <= $uniquePlayerCount; $index++){
            $uniquePlayerTotal += $index; 
        }
        $this->maxUniqueNumber = self::MAX_TEAM_TAS - $uniquePlayerTotal;
    
        return $this->maxUniqueNumber;
    }

    private function generateRandomUniqueNumbers($maxNumber) {
        $numbers = array();
        while (count($numbers) < self::MAX_PLAYERS) {
            $random_number = rand(0, $maxNumber);
            if (!in_array($random_number, $numbers)) { 
                $numbers[] = $random_number;
            }
        }
        return $numbers;
    }

}

$team = new team();
echo '<pre>';
print_r($team->starters);
print_r($team->bench);
print_r($team->players);
echo '</pre>';