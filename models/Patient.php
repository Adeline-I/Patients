<?php
require_once(dirname(__FILE__).'/../utils/database.php');

class Patient {

    // Déclaration des attributs
    private object $_pdo;
    private int $_id;
    private string $_lastname;
    private string $_firstname;
    private string $_birthdate;
    private string $_phone;
    private string $_mail;

    /**
     * Méthode magique appelée automatiquement lors de l'instanciation d'une classe
     * 
     * @param string $lastname
     * @param string $firstname
     * @param string $birthdate
     * @param string $phone
     * @param string $mail
     */
    public function __construct(string $lastname, 
                                string $firstname, 
                                string $birthdate, 
                                string $phone, 
                                string $mail) {
        $this->_pdo = Database::dbConnect();
        $this->setLastname($lastname);
        $this->setFirstname($firstname);
        $this->setBirthdate($birthdate);
        $this->setPhone($phone);
        $this->setMail($mail);
    }

    /**
     * Permet de retourner la valeur de l'attribut concerné
     * 
     * @return int
     */
    public function getId():int{
        return $this->_id;
    }

    /**
     * Permet de retourner la valeur de l'attribut concerné
     * 
     * @return string
     */
    public function getLastname():string{
        return $this->_lastname;
    }

    /**
     * Permet de retourner la valeur de l'attribut concerné
     * 
     * @return string
     */
    public function getFirstname():string{
        return $this->_firstname;
    }

    /**
     * Permet de retourner la valeur de l'attribut concerné
     * 
     * @return string
     */
    public function getBirthdate():string{
        return $this->_birthdate;
    }

    /**
     * Permet de retourner la valeur de l'attribut concerné
     * 
     * @return string
     */
    public function getPhone():string{
        return $this->_phone;
    }

    /**
     * Permet de retourner la valeur de l'attribut concerné
     * 
     * @return string
     */
    public function getMail():string{
        return $this->_mail;
    }

    /**
     * Permet d'affecter la valeur passée en paramètre à l'attribut concerné
     * 
     * @param int $id
     * 
     * @return void
     */
    public function setId(int $id):void {
        $this->_id = $id;
    }

    /**
     * Permet d'affecter la valeur passée en paramètre à l'attribut concerné
     * 
     * @param string $lastname
     * 
     * @return void
     */
    public function setLastname(string $lastname):void {
        $this->_lastname = $lastname;
    }

    /**
     * Permet d'affecter la valeur passée en paramètre à l'attribut concerné
     * 
     * @param string $firstname
     * 
     * @return void
     */
    public function setFirstname(string $firstname):void {
        $this->_firstname = $firstname;
    }

    /**
     * Permet d'affecter la valeur passée en paramètre à l'attribut concerné
     * 
     * @param string $birthdate
     * 
     * @return void
     */
    public function setBirthdate(string $birthdate):void {
        $this->_birthdate = $birthdate;
    }

    /**
     * Permet d'affecter la valeur passée en paramètre à l'attribut concerné
     * 
     * @param string $phone
     * 
     * @return void
     */
    public function setPhone(string $phone):void {
        $this->_phone = $phone;
    }

    /**
     * Permet d'affecter la valeur passée en paramètre à l'attribut concerné
     * 
     * @param string $mail
     * 
     * @return void
     */
    public function setMail(string $mail):void {
        $this->_mail = $mail;
    }

    /**
     * Ajouter une ligne en base de données
     * 
     * @param mixed $pdo
     * 
     * @return [type]
     */
    public function add() {
        $sql = 'INSERT INTO `PATIENTS` (`lastname`, `firstname`, `birthdate`, `phone`, `mail`) 
                VALUES (:lastname, :firstname, :birthdate, :phone, :mail);';
        try {
            $sth = $this->_pdo->prepare($sql);
            
            $sth->bindValue(':lastname', $this->getLastname(), PDO::PARAM_STR);
            $sth->bindValue(':firstname', $this->getFirstname(), PDO::PARAM_STR);
            $sth->bindValue(':birthdate', $this->getBirthdate(), PDO::PARAM_STR);
            $sth->bindValue(':phone', $this->getPhone(), PDO::PARAM_STR);
            $sth->bindValue(':mail', $this->getMail(), PDO::PARAM_STR);
            
            if ($sth->execute()) {
                $idPatient = $this->_pdo->lastInsertId();
                return $idPatient;
            }
        } catch (PDOException $exception) {
            
        }
    }

    public static function isExist(string $mail):bool {
        $sql = 'SELECT `mail`
        FROM `patients`
        WHERE `mail` = :mail;';
        try {
            $sth = Database::dbConnect()->prepare($sql);
            $sth->bindValue(':mail', $mail, PDO::PARAM_STR);
            $sth->execute();
            if (empty($sth->fetchAll())) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $exception) {
            return false;
        }
    }

    public static function getAll(string $search = ''):array {
        $sql = 'SELECT *
                FROM `patients`
                WHERE `firstname` LIKE :search
                OR `lastname` LIKE :search;';
        try {
            $sth = Database::dbConnect()->prepare($sql);
            $sth->bindValue(':search', "%$search%", PDO::PARAM_STR);
            $sth->execute();
            if (!$sth) {
                throw new PDOException();
            }
            return $sth->fetchAll();
        } catch (PDOException $exception) {
            return [];
        }
    }

    public static function getById(int $idPatient):object {
        $sql = 'SELECT *
        FROM `patients`
        WHERE `id`= :id;';
        try {
            $sth = Database::dbConnect()->prepare($sql);
            $sth->bindValue(':id', $idPatient, PDO::PARAM_INT);
            $resultExecute = $sth->execute();
            if (!$resultExecute) {
                throw new PDOException();
            } else {
                $resultFetch = $sth->fetch();
                if (!$resultFetch) {
                    throw new PDOException('Patient non trouvé');
                }
                return $resultFetch;
            }
        } catch (PDOException $exception) {
            return $exception;
        }
    }

    public function changeById(int $idPatient):bool {
        $sql = 'UPDATE `patients`
                SET `lastname` = :lastname,
                    `firstname` = :firstname,
                    `birthdate` = :birthdate,
                    `phone` = :phone,
                    `mail` = :mail
                WHERE `id` = :id;';
        try {
            $sth = $this->_pdo->prepare($sql);
            
            $sth->bindValue(':id', $idPatient, PDO::PARAM_INT);
            $sth->bindValue(':lastname', $this->getLastname(), PDO::PARAM_STR);
            $sth->bindValue(':firstname', $this->getFirstname(), PDO::PARAM_STR);
            $sth->bindValue(':birthdate', $this->getBirthdate(), PDO::PARAM_STR);
            $sth->bindValue(':phone', $this->getPhone(), PDO::PARAM_STR);
            $sth->bindValue(':mail', $this->getMail(), PDO::PARAM_STR);

            if (!$sth) {
                throw new PDOException();
            } else {
                return $sth->execute();
            };
        } catch (PDOException $exception) {
            return false;
        }
    }

    public static function deleteById(int $idPatient):bool {
        $sql = 'DELETE FROM `appointments`
                WHERE `idPatients` = :id;
                DELETE FROM `patients`
                WHERE `id` = :id;';
        try {
            $sth = Database::dbConnect()->prepare($sql);
            
            $sth->bindValue(':id', $idPatient, PDO::PARAM_INT);

            if (!$sth) {
                throw new PDOException();
            } else {
                return $sth->execute();
            };
        } catch (PDOException $exception) {
            return false;
        }
    }
}