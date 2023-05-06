<?php

namespace Webcup;

use \PDO;
use \Exception;

class Database
{
    private $db;

    public function __construct($host, $dbname, $user, $password)
    {
        $this->db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $user, $password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function execute($query, $params = array())
    {
        $query = $this->db->prepare($query);

        if (!$query->execute($params)) {
            throw new Exception('La requête n\'a pas pu être exécutée');
        }
    }

    public function query($query, $params = array())
    {
        $query = $this->db->prepare($query);

        if (!$query->execute($params)) {
            throw new Exception('La requête n\'a pas pu être exécutée');
        }

        $query->setFetchMode(PDO::FETCH_ASSOC);

        return $query->fetchAll();
    }

    public function getResult($query, $params = array())
    {
        return $this->query($query, $params);
    }

    public function getRow($query, $params = array())
    {
        $results = $this->query($query, $params);

        if (count($results) > 1) {
            throw new Exception('La requête a retourné plusieurs lignes');
        } else {
            return count($results) == 1 ? $results[0] : array();
        }
    }

    public function getCol($query, $params = array())
    {
        $results = $this->query($query, $params);

        if (count($results) > 0) {
            if (count($results[0]) > 1) {
                throw new Exception('La requête a retourné plusieurs colonnes');
            } else {
                $colResult = array();

                foreach ($results as $row) {
                    $colResult[] = array_values($row)[0];
                }

                return $colResult;
            }
        } else {
            return array();
        }
    }

    public function getVar($query, $params = array())
    {
        $results = $this->query($query, $params);

        if (count($results) > 0) {
            if (count($results) > 1) {
                throw new Exception('La requête a retourné plus plusieurs lignes');
            } elseif (count($results[0]) == 1) {
                return array_values($results[0])[0];
            } else {
                throw new Exception('La requête a retourné plus plusieurs colonnes');
            }
        } else {
            return '';
        }
    }

    public function insert($table, $values = array())
    {
        $cols = array_keys($values);
        $withTable = array();

        foreach ($cols as $c) {
            $withTable[] = $table . '.' . $c;
        }

        $this->execute('INSERT INTO ' . $table . '(' . implode(', ', $withTable) . ') VALUES(:' . implode(', :', $cols) . ') ', $values);

        return $this->db->lastInsertId();
    }

    public function update($table, $values = array(), $where = '')
    {
        $sets = array();
        $where = $where != '' ? ' WHERE ' . $where : '';

        foreach ($values as $key => $val) {
            $sets[] = $key . ' = :' . $key;
        }

        $this->execute('UPDATE ' . $table . ' SET ' . implode(', ', $sets) . $where, $values);
    }

    public function delete($table, $where = '')
    {
        $where = $where != '' ? ' WHERE ' . $where : '';

        $this->execute('DELETE FROM ' . $table . $where);
    }
}
