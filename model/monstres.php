<?php

class Monstre {

    private $_id,
            $_nom,
            $_point_vie,
            $_point_def,
            $_point_att,
            $_point_vit;



     const CEST_MOI = 1;
     const MONSTRE_TUE = 2;
     const MONSTRE_FRAPPE = 3;


    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function frapper(Monstre $perso)
    {
        if ($perso->id() == $this->_id) {
            return self::CEST_MOI;
        }

        return $perso->recevoirDegats();
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
    public function recevoirDegats(){

        $this->_point_vie += 5;

        // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
        if ($this->_point_vie >= 100)
        {
            return self::MONSTRE_TUE;
        }

        // Sinon, on se contente de dire que le personnage a bien été frappé.
        return self::MONSTRE_FRAPPE;
    }


    public function id()
    {
        return $this->_id;
    }
    public function nom()
    {
        return $this->_nom;
    }
    public function degats()
    {
        return $this->_point_vie;
    }


    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0)
        {
            $this->_id = $id;
        }
    }
    public function setNom($nom)
    {
        if (is_string($nom))
        {
            $this->_nom = $nom;
        }
    }
    public function setDegats($point_vie)
    {
        $point_vie = (int) $point_vie;

        if ($point_vie >= 0 && $point_vie <= 100)
        {
            $this->_point_vie = $point_vie;
        }
    }
}