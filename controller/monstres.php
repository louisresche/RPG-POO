<?php
class MonstresManager
{
    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function add(Monstre $monster)
    {
        $q = $this->_db->prepare('INSERT INTO hero (nom) VALUES (:nom)');
        $q->bindValue(':nom', $monster->nom());
        $q->execute();

        $monster->hydrate([
            'id'=>$this->_db->lastInsertId(),
            'pv' => 0,
            'experience' => 0,
            'niveau' => 1,
            'nbCoups' => 0,]);
    }

    public function count()
    {
        return $this->_db->query('SELECT COUNT(*) FROM hero')->fetchColumn();
    }

    public function delete(Monstre $monster)
    {
        $this->_db->exec('DELETE FROM hero WHERE id = '.$monster->id());
    }

    public function exists($info)
    {
        if (is_int($info))
        {
            return (bool)$this->_db->query('SELECT COUNT(*) FROM hero WHERE id = '.$info)->fetchColumn();
        }

        $q = $this->_db->prepare('SELECT COUNT(*) FROM hero WHERE nom = :nom');
        $q -> execute([':nom' => $info]);

        return (bool) $q->fetchColumn();
    }

    public function get($info)
    {
        if (is_int($info))
        {
            $q = $this->_db->query('SELECT id, nom, pv, experience, niveau  FROM hero WHERE id = '.$info);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);

            return new Monstre($donnees);
        }

        $q = $this -> _db ->prepare('SELECT id, nom, pv, experience, niveau FROM hero WHERE nom = :nom');
        $q->execute([':nom' => $info]);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Monstre($donnees);
    }

    public function getList($nom)
    {
        $monsters = [];

        $q  =  $this->_db->prepare('SELECT id, nom, pv, experience, niveau FROM hero WHERE nom <> :nom ORDER BY nom');
        $q->execute([':nom'=>$nom]);

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $monsters[] = new Monstre($donnees);
        }
        return $monsters;
    }

    public function update(Monstre $monster)
    {
        $q  =  $this->_db->prepare('UPDATE hero SET pv = :pv, experience = :experience, niveau = :niveau WHERE id = :id');
        $q->bindValue(':pv',$monster->pv(), PDO::PARAM_INT);
        $q->bindValue(':experience',$monster->experience(), PDO::PARAM_INT);
        $q->bindValue(':niveau',$monster->niveau(), PDO::PARAM_INT);


        $q->bindValue(':id',$monster->id(), PDO::PARAM_INT);
        $q->execute();
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

}