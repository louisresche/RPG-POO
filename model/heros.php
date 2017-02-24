<?php

class Heros 
{
    private $_id;
    private $_nom;
    private $_point_vie;
    private $_experience;
    private $_niveau;
    private $_nbCoups;
    private $_dateDernierCoup;

    const CEST_MOI = 1;
    const PERSONNAGE_TUE = 2;
    const PERSONNAGE_FRAPPE = 3;
    const PAS_AUJOURDHUI = 4;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }


    public function frapper(Personnage $perso)
    {
        if ($this->id() == $perso->id()){
            return self::CEST_MOI;
        }



        if ($this->setNbCoups($this->nbCoups() + 1)){

        } else {
            $this->setNbCoups(1);
        }




        return $perso->recevoirpoint_vie($this->niveau() - 5);
    }

    public function recevoirpoint_vie($force)
    {
        $this->setpoint_vie($this->point_vie() + $force);
        if ($this->point_vie() == 0){
            return self::PERSONNAGE_TUE;
        }
        return self::PERSONNAGE_FRAPPE;
    }

    public function gagnerExperience(){
        $this->setExperience($this->experience() + $this->niveau() * 2);

        if ($this->experience() >= 100){
            $this->setNiveau($this->niveau() + 1);
            $this->setExperience(0);
        }
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

    public function id()
    {
        return $this->_id;
    }

    public function nom()
    {
        return $this->_nom;
    }

    public function point_vie()
    {
        return $this->_point_vie;
    }

    public function experience(){
        return $this->_experience;
    }

    public function niveau()
    {
        return $this->_niveau;
    }

    public function nbCoups()
    {
        return $this->_nbCoups;
    }

    public function dateDernierCoup()
    {
        return $this->_dateDernierCoup;
    }

    public function setId($id)
    {
        $id = (int) $id;
        if ($id >= 0) {
            $this->_id = $id;
        }
    }

    public function setNom($nom)
    {
        if (is_string($nom)) {
            $this->_nom = $nom;
        }
    }

    public function setpoint_vie($point_vie)
    {
        $point_vie = (int) $point_vie;
        //if ($point_vie >= 0 && $point_vie <= 100) {
        $this->_point_vie = $point_vie;
        //}
    }

    public function setExperience($experience)
    {
        $experience = (int) $experience;
        //if ($experience >= 0 && $experience <= 100) {
        $this->_experience = $experience;
        //}
    }

    public function setNiveau($niveau)
    {
        $niveau = (int) $niveau;
        if ($niveau >= 0 && $niveau <= 100) {
            $this->_niveau = $niveau;
        }
    }

    public function setNbCoups($nbCoups)
    {
        $nbCoups = (int) $nbCoups;
        if ($nbCoups >= 0 && $nbCoups <= 100) {
            $this->_nbCoups = $nbCoups;
        }
    }

    public function setDateDernierCoup($dateDernierCoup)
    {
        $dateDernierCoup = DateTime::createFromFormat("Y-m-d", $dateDernierCoup);
        $this->_dateDernierCoup = $dateDernierCoup;
    }

    public function nomValide()
    {
        return !(empty($this->_nom));
    }
}


class Magicien extends Heros
{

    private $_magie; // Indique la puissance du magicien sur 100, sa capacité à produire de la magie.

    public function lancerUnSort($perso)
    {
        $perso->recevoirDegats($this->_magie); // On va dire que la magie du magicien représente sa force.
    }

}

class Paladin extends Heros
{

}

class Barbare extends Heros
{

}