<?php

namespace Webcup;

use \DateTime;

class User
{
    private $id;
    private $email;
    private $password;
    private $isActive;
    private $isAdmin;
    private $avatar;
    private $bio;
    private $firstName;
    private $lastName;
    private $gender;
    private $birthdate;

    public function __construct($id)
    {
        if (!is_numeric($id)) {
            return;
        }

        global $DB;

        $user = $DB->getRow('SELECT * FROM users WHERE id = :id', array('id' => $id));

        if (count($user) == 0) {
            return;
        }

        foreach ($user as $col => $val) {
            $func = 'set' . snakeToPascal($col);

            if (method_exists($this, $func)) {
                $this->$func($val);
            }
        }
    }

    public function id()
    {
        return $this->id;
    }

    public function email()
    {
        return $this->email;
    }

    public function password()
    {
        return $this->password;
    }

    public function isActive()
    {
        return $this->isActive == 1;
    }

    public function isAdmin()
    {
        return $this->isAdmin == 1;
    }

    public function avatar()
    {
        return $this->avatar;
    }

    public function bio()
    {
        return $this->bio;
    }

    public function firstName()
    {
        return $this->firstName;
    }

    public function lastName()
    {
        return $this->lastName;
    }

    public function formattedName($isShort = false)
    {
        return ($isShort && $this->firstName != '' ? strtoupper($this->firstName)[0] . '.' : ucfirst(strtolower($this->firstName))) . ($this->firstName != '' && $this->lastName != '' ? ' ' : '') . ucfirst(strtolower($this->lastName));
    }

    public function gender()
    {
        return $this->gender;
    }

    public function isMale()
    {
        return $this->gender === 'M';
    }

    public function isFemale()
    {
        return $this->gender === 'F';
    }

    public function birthdate()
    {
        return $this->birthdate;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function setEmail($email)
    {
        return $this->email = $email;
    }

    public function setPassword($password)
    {
        return $this->password = $password;
    }

    public function setIsActive($isActive)
    {
        return $this->isActive = $isActive;
    }

    public function setIsAdmin($isAdmin)
    {
        return $this->isAdmin = $isAdmin;
    }

    public function setAvatar($avatar)
    {
        return $this->avatar = $avatar;
    }

    public function setBio($bio)
    {
        return $this->bio = $bio;
    }

    public function setFirstName($firstName)
    {
        return $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        return $this->lastName = $lastName;
    }

    public function setGender($gender)
    {
        return $this->gender = $gender;
    }

    public function setBirthdate($birthdate)
    {
        if (!$birthdate instanceof DateTime) {
            $birthdate = stringToDate($birthdate);
        }

        return $this->birthdate = $birthdate;
    }

    public function dreams(): array
    {
        return DreamService::getAll(array('user' => $this->id));
    }

    public function articles(): array
    {
        return ArticleService::getAll(array('author' => $this->id));
    }
}

class UserService
{
    public function __construct()
    {
        
    }

    public static function hashPass($password)
    {
        return md5($password);
    }

    public static function getAll($isActive = -1, $isAdmin = -1, $search = '', $where = '', $limit = '')
    {
        $userIds = self::getAllIds($isActive, $isAdmin, $search, $where, $limit);
        $users = array();

        foreach ($userIds as $id) {
            $users[] = new User($id);
        }

        return $users;
    }

    public static function getAllIds($isActive = -1, $isAdmin = -1, $search = '', $where = '', $limit = '')
    {
        global $DB;

        $where = self::getAllWhere($isActive, $isAdmin, $search, $where);

        return $DB->getCol('SELECT id FROM users ' . $where['where'] . ' ORDER BY id DESC ' . $limit, $where['params']);
    }

    public static function getAllCount($isActive = -1, $isAdmin = -1, $search = '', $where = '')
    {
        global $DB;

        $where = self::getAllWhere($isActive, $isAdmin, $search, $where);

        return $DB->getVar('SELECT COUNT(*) FROM users ' . $where['where'] . ' ORDER BY id DESC', $where['params']);
    }

    public static function getAllWhere($isActive = -1, $isAdmin = -1, $search = '', $where = '')
    {
        $params = array();
        $customWhere = $where;
        $where = '';

        if ($isActive != -1) {
            $where .= ($where != '' ? ' AND ' : '') . 'is_active = :is_active';
            $params['is_active'] = $isActive;
        }

        if ($isAdmin != -1) {
            $where .= ($where != '' ? ' AND ' : '') . 'is_admin = :is_admin';
            $params['is_admin'] = $isAdmin;
        }

        if ($search != '') {
            $where .= ($where != '' ? ' AND ' : '') . '(first_name LIKE CONCAT("%", :search, "%") OR last_name LIKE CONCAT("%", :search, "%") OR email LIKE CONCAT("%", :search, "%") OR bio LIKE CONCAT("%", :search, "%"))';
            $params['search'] = $search;
        }

        if ($customWhere != '') {
            $where .= ($where != '' ? ' AND ' : '') . $customWhere;
        }

        if ($where != '') {
            $where = ' WHERE ' . $where;
        }

        return array(
            'where' => $where,
            'params' => $params
        );
    }

    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM users WHERE id = :id', array('id' => $id)) > 0;
    }

    public static function save($values = array())
    {
        global $DB;

        $validCols = array('is_active', 'is_admin', 'email', 'password', 'avatar', 'bio', 'first_name', 'last_name', 'gender', 'birthdate', 'height', 'weight', 'fat_ratio', 'date_measure');
        $sanitizedValues = array();

        if (isset($values['password'])) {
            $values['password'] = self::hashPass($values['password']);
        }

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols)) {
                $sanitizedValues[$col] = $value;
            }
        }

        return $DB->insert('users', $sanitizedValues);
    }

    public static function update($id, $values = array())
    {
        global $DB;

        $oldValues = $DB->getRow('SELECT * FROM users WHERE id = :id', array('id' => $id));
        $validCols = array('is_active', 'is_admin', 'email', 'password', 'avatar', 'bio', 'first_name', 'last_name', 'gender', 'birthdate', 'height', 'weight', 'fat_ratio', 'date_measure');
        $sanitizedValues = array();

        if (isset($values['password'])) {
            $values['password'] = self::hashPass($values['password']);
        }

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols) && $value != $oldValues[$col]) {
                $sanitizedValues[$col] = $value;
            }
        }

        return count($sanitizedValues) == 0 || $DB->update('users', $sanitizedValues, 'id = ' . $id);
    }

    public static function delete($id)
    {
        global $DB;

        $DB->delete('users', 'id = ' . $id);
    }

    public static function get($id, $col)
    {
        global $DB;

        return $DB->getVar('SELECT ' . $col . ' FROM users WHERE id = :id LIMIT 1', array('id' => $id));
    }

    public static function getIdFrom($col, $val)
    {
        global $DB;

        return $DB->getVar('SELECT id FROM users WHERE ' . $col . ' = :' . $col . ' LIMIT 1', array($col => $val));
    }

    public static function emailIsUsed($email, $reference = 0)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM users WHERE ' . ($reference != 0 ? 'id <> ' . $reference . ' AND ' : '') . 'email = :email LIMIT 1', array('email' => $email)) > 0;
    }

    public static function checkLogin($username, $password)
    {
        global $DB;

        $password = self::hashPass($password);
        $ids = $DB->getCol('SELECT id FROM users WHERE email = :username AND password = :password AND is_active = 1', array('username' => $username, 'password' => $password));

        return count($ids) == 1 ? $ids[0] : 0;
    }
}
