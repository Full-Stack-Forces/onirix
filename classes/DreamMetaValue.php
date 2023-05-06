<?php
namespace Webcup;

class DreamMetaValue {
    private int $id;
    private DreamMetaKey $key;
    private Dream $dream;
    private string $value;

    public function __construct(int $id) {
        if (!is_numeric($id)) {
            return;
        }

        global $DB;

        $dreamMetaValue = $DB->getRow('SELECT * FROM dreams_meta_values WHERE id = :id', array('id' => $id));

        if (count($dreamMetaValue) == 0) {
            return;
        }

        foreach ($dreamMetaValue as $col => $val) {
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

    public function key(): DreamMetaKey {
        return $this->key;
    }

    private function setKey(int $keyId): void {
        $this->key = DreamMetaKeyService::exist($keyId) ? new DreamMetaKey($keyId) : null;
    }

    public function dream(): Dream {
        return $this->dream;
    }

    private function setDream(int $dreamId): void {
        $this->dream = DreamService::exist($dreamId) ? new Dream($dreamId) : null;
    }

    public function value(): string {
        return $this->value;
    }

    private function setValue(string $value): void {
        $this->value = $value;
    }
}

class DreamMetaValueService {
    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM dream_meta_values WHERE id = :id', array('id' => $id)) > 0;
    }

    public static function save($values = array())
    {
        global $DB;

        $validCols = array('key', 'dream', 'value');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols)) {
                $sanitizedValues[$col] = $value;
            }
        }

        return $DB->insert('dream_meta_values', $sanitizedValues);
    }

    public static function update($id, $values = array())
    {
        global $DB;

        $oldValues = $DB->getRow('SELECT * FROM dream_meta_values WHERE id = :id', array('id' => $id));
        $validCols = array('value');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols) && $value != $oldValues[$col]) {
                $sanitizedValues[$col] = $value;
            }
        }

        return count($sanitizedValues) == 0 || $DB->update('dream_meta_values', $sanitizedValues, 'id = ' . $id);
    }

    public static function delete($id)
    {
        global $DB;

        $DB->delete('dream_meta_values', 'id = ' . $id);
    }

    public static function getAll($data = array(), $where = '')
    {
        $ids = self::getAllIds($data, $where);
        $list = array();

        foreach ($ids as $id) {
            $list[] = new DreamMetaValue($id);
        }

        return $list;
    }

    public static function getAllIds($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getCol('SELECT id FROM dream_meta_values ' . $where['where'] . ' ORDER BY id DESC', $where['params']);
    }

    public static function getAllCount($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getVar('SELECT COUNT(*) FROM dream_meta_values ' . $where['where'] . ' ORDER BY id DESC', $where['params']);
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

        return $DB->getVar('SELECT ' . $col . ' FROM dream_meta_values WHERE id = :id LIMIT 1', array('id' => $id));
    }

    public static function getIdFrom($col, $val)
    {
        global $DB;

        return $DB->getVar('SELECT id FROM dream_meta_values WHERE ' . $col . ' = :' . $col . ' LIMIT 1', array($col => $val));
    }
}