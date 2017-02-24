<?php
class HerosManager
{
    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function add(Joueur $perso)
    {
        $q = $this->_db->prepare('INSERT INTO Héros (nom) VALUES (:nom)');
        $q->bindValue(':nom', $perso->nom());
        $q->execute();

        $perso->hydrate([
            'id'=>$this->_db->lastInsertId(),
            'point_vie' => 0,
            'classe' => 0,
            'niveau' => 1,
            'nbCoups' => 0,]);
    }

    public function count()
    {
        return $this->_db->query('SELECT COUNT(*) FROM Héros')->fetchColumn();
    }

    public function delete(Joueur $perso)
    {
        $this->_db->exec('DELETE FROM Héros WHERE id = '.$perso->id());
    }

    public function exists($info)
    {
        if (is_int($info))
        {
            return (bool)$this->_db->query('SELECT COUNT(*) FROM Héros WHERE id = '.$info)->fetchColumn();
        }

        $q = $this->_db->prepare('SELECT COUNT(*) FROM Héros WHERE nom = :nom');
        $q -> execute([':nom' => $info]);

        return (bool) $q->fetchColumn();
    }

    public function get($info)
    {
        if (is_int($info))
        {
            $q = $this->_db->query('SELECT id, nom, point_vie, classe, niveau  FROM Héros WHERE id = '.$info);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);

            return new Joueur($donnees);
        }

        $q = $this -> _db ->prepare('SELECT id, nom, point_vie, classe, niveau FROM Héros WHERE nom = :nom');
        $q->execute([':nom' => $info]);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new heros($donnees);
    }

    public function getList($nom)
    {
        $persos = [];

        $q  =  $this->_db->prepare('SELECT id, nom, point_vie, classe, niveau FROM Héros WHERE nom <> :nom ORDER BY nom');
        $q->execute([':nom'=>$nom]);

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $persos[] = new Joueur($donnees);
        }
        return $persos;
    }

    public function update(Joueur $perso)
    {
        $q  =  $this->_db->prepare('UPDATE Héros SET point_vie = :point_vie, classe = :classe, niveau = :niveau WHERE id = :id');
        $q->bindValue(':pv',$perso->pv(), PDO::PARAM_INT);
        $q->bindValue(':classe',$perso->classe(), PDO::PARAM_INT);
        $q->bindValue(':niveau',$perso->niveau(), PDO::PARAM_INT);


        $q->bindValue(':id',$perso->id(), PDO::PARAM_INT);
        $q->execute();
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

}