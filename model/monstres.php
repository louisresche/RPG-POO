<?php
class Monstre
{
    private $_id;
    private $_nom;
    private $_pv;
    private $_pvitesse;
    private $_niveau;
    private $_nbCoups;
    private $_pdefense;
    private $_pattaque;

    const CEST_MOI = 1;
    const MONSTRE_TUE = 2;
    const MONSTRE_FRAPPE = 3;
    const PAS_AUJOURDHUI = 4;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }


    public function frapper(Monstre $monster)
    {
        if ($this->id() == $monster->id()){
            return self::CEST_MOI;
        }



        if ($this->setNbCoups($this->nbCoups() + 1)){

        } else {
            $this->setNbCoups(1);
        }




        return $monster->recevoirpv($this->niveau() - 5);
    }

    public function recevoirpv($force)
    {
        $this->setpv($this->pv() + $force);
        if ($this->pv() == 0){
            return self::MONSTRE_TUE;
        }
        return self::MONSTRE_FRAPPE;
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

    public function pv()
    {
        return $this->_pv;
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

    public function setpv($pv)
    {
        $pv = (int) $pv;
        //if ($pv >= 0 && $pv <= 100) {
        $this->_pv = $pv;
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