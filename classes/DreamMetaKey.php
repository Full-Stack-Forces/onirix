<?php
namespace Webcup;

class DreamMetaKey {
    private int $id;
    private string $title;
    private string $description;

    public function __construct(int $id) {
        global $DB;

        $dreamMetaKey = $DB->getRow('SELECT * FROM dream_meta_keys WHERE id = :id', array('id' => $id));

        if (count($dreamMetaKey) == 0) {
            return;
        }

        foreach ($dreamMetaKey as $col => $val) {
            $func = 'set' . snakeToPascal($col);

            if (method_exists($this, $func)) {
                $this->$func($val);
            }
        }
    }

    public function id(): int {
        return $this->id;
    }

    private function setId(int $id): void {
        $this->id = $id;
    }

    public function title(): string {
        return $this->title;
    }

    private function setTitle(string $title): void {
        $this->title = $title;
    }

    public function description(): string {
        return $this->description;
    }

    private function setDescription(string $description): void {
        $this->description = $description;
    }
}

class DreamMetaKeyService {
    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM dream_meta_keys WHERE id = :id', array('id' => $id)) > 0;
    }

    public static function save($values = array()) {
        global $DB;

        $validCols = array('title', 'description');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols)) {
                $sanitizedValues[$col] = $value;
            }
        }

        return $DB->insert('dream_meta_keys', $sanitizedValues);
    }

    public static function update($id, $values = array())
    {
        global $DB;

        $oldValues = $DB->getRow('SELECT * FROM dream_meta_keys WHERE id = :id', array('id' => $id));
        $validCols = array('title', 'description');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols) && $value != $oldValues[$col]) {
                $sanitizedValues[$col] = $value;
            }
        }

        return count($sanitizedValues) == 0 || $DB->update('dream_meta_keys', $sanitizedValues, 'id = ' . $id);
    }

    public static function delete($id)
    {
        global $DB;

        $DB->delete('dream_meta_keys', 'id = ' . $id);
    }

    public static function getAll($data = array(), $where = '')
    {
        $ids = self::getAllIds($data, $where);
        $list = array();

        foreach ($ids as $id) {
            $list[] = new DreamMetaKey($id);
        }

        return $list;
    }

    public static function getAllIds($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getCol('SELECT id FROM dream_meta_keys ' . $where['where'] . ' ORDER BY id ASC', $where['params']);
    }

    public static function getAllCount($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getVar('SELECT COUNT(*) FROM dream_meta_keys ' . $where['where'] . ' ORDER BY id DESC', $where['params']);
    }

    public static function getAllWhere($data = array(), $where = '')
    {
        $params = array();
        $wheres = array();

        if (is_array($data)) {
            // TODO: 
        }

        if ($where != '') {
            $wheres[] = $where;
        }

        return array(
            'where' => count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) : '',
            'params' => $params
        );
    }

    public static function get($id, $col)
    {
        global $DB;

        return $DB->getVar('SELECT ' . $col . ' FROM dream_meta_keys WHERE id = :id LIMIT 1', array('id' => $id));
    }

    public static function getIdFrom($col, $val)
    {
        global $DB;

        return $DB->getVar('SELECT id FROM dream_meta_keys WHERE ' . $col . ' = :' . $col . ' LIMIT 1', array($col => $val));
    }
}