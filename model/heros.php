<?php

class Heros {

    private  $_id,
             $_nom,
             $_classe,
             $_point_vie,
             $_point_def,
             $_point_att,
             $_point_vit,
             $_point_mag,
             $_bourse_or;

    const CEST_MOI = 1;
    const PERSONNAGE_TUE = 2;
    const PERSONNAGE_FRAPPE = 3;


    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function frapper(Personnage $perso)
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
            return self::PERSONNAGE_TUE;
        }

        // Sinon, on se contente de dire que le personnage a bien été frappé.
        return self::PERSONNAGE_FRAPPE;
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

    function execute($sql) {
        $result = self::$pdo->query($sql);
        return $result;
    }

    function insert($table, $values) {
        $sql = 'INSERT INTO '.$table.' (';

        foreach ($values as $fieldName => $value) {
            $sql .= $fieldName.',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ') VALUES (';

        foreach ($values as $fieldName => $value) {
            $sql .= '"'.$value.'",';
        }
        $sql = rtrim($sql, ',');
        $sql .= ')';

        $result = self::$pdo->query($sql);
        return $result;
    }

    function select($table, $fields, $where = '') {
        $sql = 'SELECT ';
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $sql .= $field.',';
            }
            $sql = rtrim($sql, ',');
        } else {
            $sql .= $fields;
        }

        $sql .= ' FROM '.$table.' WHERE 1 = 1 AND '.$where;

        $result = self::$pdo->query($sql);
        if (!empty($result)) {
            $result = $result->fetchAll(PDO::FETCH_ASSOC);
        }
        return $result;
    }

    function update($table, $values, $where) {
        $sql = 'UPDATE '.$table.' SET ';

        foreach ($values as $fieldName => $value) {
            $sql .= $fieldName.' = "'.$value.'",';
        }
        $sql = rtrim($sql, ',');
        $sql .= ' WHERE '.$where;

        $result = self::$pdo->query($sql);
        return $result;
    }

    function delete($table, $where) {
        $sql = 'DELETE FROM '.$table.' WHERE '.$where;
        $result = self::$pdo->query($sql);
        return $result;
    }

}