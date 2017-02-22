<?php

class Joueurs {

    public $prenom = "";
    public $nom = "";
    public $pseudo = "";
    public $email = "";
    public $description = "";

    public function  getDisplayName(){
        return $this->prenom." ".$this->nom;
        return $this-> pseudo;
        return $this-> email;
        return $this-> description;
    }
    public function printDisplayName(){
        echo $this->getDisplayName();
    }
}

$pers1 = new Joueurs ();
$pers1->prenom = "AA";
$pers1->nom = "BB";
$pers1->pseudo = "AABB";
$pers1->email = "AA.BB@gmail.com";
$pers1->description = "AAAAABBBBB";


