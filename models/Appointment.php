<?php
require_once(dirname(__FILE__).'/../utils/database.php');

class Appointment {

    private object $_pdo;
    private int $_id;
    private string $_dateHour;
    private int $_idPatients;
    
    public function __construct(string $dateHour, int $idPatients) {
        $this->_pdo = Database::dbConnect();
        $this->_dateHour = $dateHour;
        $this->_idPatients = $idPatients;
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
    /**
     * @return string
     */
    public function getDateHour():string{
        return $this->_dateHour;
    }

    /**
     * Permet de retourner la valeur de l'attribut concerné
     * 
     * @return int
     */
    public function getIdPatients():int{
        return $this->_idPatients;
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
     * @param string $dateHour
     * 
     * @return void
     */
    public function setDateHour(string $dateHour):void {
        $this->_dateHour = $dateHour;
    }

    public function setIdPatients(int $idPatients):void {
        $this->_idPatients = $idPatients;
    }

    public function add():bool {
        $sql = 'INSERT INTO `APPOINTMENTS` (`dateHour`, `idPatients`) 
                VALUES (:dateHour, :idPatients);';
        try {
            $sth = $this->_pdo->prepare($sql);
            
            $sth->bindValue(':dateHour', $this->getdateHour(), PDO::PARAM_STR);
            $sth->bindValue(':idPatients', $this->getIdPatients(), PDO::PARAM_INT);

            
            return $sth->execute();
        } catch (PDOException $exception) {
            return false;
        }
    }

    public static function isExist(string $dateHour):bool {
        $sql = 'SELECT `dateHour`
        FROM `appointments`
        WHERE `dateHour` = :dateHour;';
        try {
            $sth = Database::dbConnect()->prepare($sql);
            $sth->bindValue(':dateHour', $dateHour, PDO::PARAM_STR);
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

    public static function getAll():array {
        $sql = 'SELECT `appointments`.`id` AS `idAppointments`,
                        `appointments`.`dateHour`,
                        `patients`.`lastname`,
                        `patients`.`firstname`
                FROM `appointments`
                LEFT JOIN `patients`
                ON `appointments`.`idPatients` = `patients`.`id`;';
        try {
            $sth = Database::dbConnect()->query($sql);
            if (!$sth) {
                throw new PDOException();
            }
            return $sth->fetchAll();
        } catch (PDOException $exception) {
            return [];
        }
    }

    public static function getById(int $idAppointment):object {
        $sql = 'SELECT `appointments`.`id` AS `idAppointments`,
                        `appointments`.`dateHour`,
                        `patients`.`id`,
                        `patients`.`lastname`,
                        `patients`.`firstname`
                FROM `appointments`
                LEFT JOIN `patients`
                ON `appointments`.`idPatients` = `patients`.`id`
                WHERE `appointments`.`id`= :id;';
        try {
            $sth = Database::dbConnect()->prepare($sql);
            $sth->bindValue(':id', $idAppointment, PDO::PARAM_INT);
            $resultExecute = $sth->execute();
            if (!$resultExecute) {
                throw new PDOException();
            } else {
                $resultFetch = $sth->fetch();
                if (!$resultFetch) {
                    throw new PDOException('Rendez-vous non trouvé');
                }
                return $resultFetch;
            }
        } catch (PDOException $exception) {
            return $exception;
        }
    }

    public static function getByIdPatient(int $idPatient):array {
        $sql = 'SELECT *
                FROM `appointments`
                WHERE `idPatients`= :id;';
        try {
            $sth = Database::dbConnect()->prepare($sql);
            $sth->bindValue(':id', $idPatient, PDO::PARAM_INT);
            $resultExecute = $sth->execute();
            if (!$resultExecute) {
                throw new PDOException();
            } else {
                $resultFetch = $sth->fetchAll();
                if (!$resultFetch) {
                    throw new PDOException('Patient non trouvé');
                }
                return $resultFetch;
            }
        } catch (PDOException $exception) {
            return [];
        }
    }

    public function changeById(int $idAppointment):bool {
        $sql = 'UPDATE `appointments`
                SET `dateHour` = :dateHour,
                    `idPatients` = :idPatients
                WHERE `id` = :id;';
        try {
            $sth = $this->_pdo->prepare($sql);
            
            $sth->bindValue(':id', $idAppointment, PDO::PARAM_INT);
            $sth->bindValue(':dateHour', $this->getDateHour(), PDO::PARAM_STR);
            $sth->bindValue(':idPatients', $this->getIdPatients(), PDO::PARAM_INT);

            if (!$sth) {
                throw new PDOException();
            } else {
                return $sth->execute();
            };
        } catch (PDOException $exception) {
            return false;
        }
    }

    public static function deleteById(int $idAppointment):bool {
        $sql = 'DELETE FROM `appointments`
                WHERE `id` = :id;';
        try {
            $sth = Database::dbConnect()->prepare($sql);
            
            $sth->bindValue(':id', $idAppointment, PDO::PARAM_INT);

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