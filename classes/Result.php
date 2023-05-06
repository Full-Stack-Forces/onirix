<?php
namespace Webcup;

class Result {
    private int $id;
    private Dream $dream;
    private string $prediction;
    private string $illustration;
    private float $accuracy;
    private \DateTime $created;

    public function __construct(int $id) {
        if (!is_numeric($id)) {
            return;
        }

        global $DB;

        $result = $DB->getRow('SELECT * FROM results WHERE id = :id', array('id' => $id));

        if (count($result) == 0) {
            return;
        }

        foreach ($result as $col => $val) {
            $func = 'set' . snakeToPascal($col);

            if (method_exists($this, $func)) {
                if ($col === 'accuracy') {
                    $this->$func((float) $val);
                } else {
                    $this->$func($val);
                }                
            }
        }
    }

    public function id(): int {
        return $this->id;
    }

    private function setId(int $id): void {
        $this->id = $id;
    }

    public function dream(): ?Dream {
        return $this->dream;
    }

    private function setDream($dreamId): void {
        $this->dream = DreamService::exist($dreamId) ? new Dream($dreamId) : null;
    }

    public function prediction(): string {
        return $this->prediction;
    }

    private function setPrediction(string $prediction): void {
        $this->prediction = $prediction;
    }

    public function illustration(): string {
        return $this->illustration;
    }

    private function setIllustration(string $illustration): void {
        $this->illustration = $illustration;
    }

    public function accuracy(): float {
        return $this->accuracy;
    }

    private function setAccuracy(float $accuracy): void {
        $this->accuracy = $accuracy;
    }

    public function created(): \DateTime {
        return $this->created;
    }

    private function setCreated(\DateTime $created): void {
        $this->created = $created;
    }
}

class ResultService {
    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM results WHERE id = :id', array('id' => $id)) > 0;
    }

    public static function save($values = array()) {
        global $DB;

        $validCols = array('dream', 'prediction', 'illustration', 'accuracy');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols)) {
                $sanitizedValues[$col] = $value;
            }
        }

        return $DB->insert('results', $sanitizedValues);
    }

    public static function update($id, $values = array())
    {
        global $DB;

        $oldValues = $DB->getRow('SELECT * FROM results WHERE id = :id', array('id' => $id));
        $validCols = array('prediction', 'illustration', 'accuracy');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols) && $value != $oldValues[$col]) {
                $sanitizedValues[$col] = $value;
            }
        }

        return count($sanitizedValues) == 0 || $DB->update('results', $sanitizedValues, 'id = ' . $id);
    }

    public static function delete($id)
    {
        global $DB;

        $DB->delete('results', 'id = ' . $id);
    }

    public static function getAll($data = array(), $where = '')
    {
        $ids = self::getAllIds($data, $where);
        $list = array();

        foreach ($ids as $id) {
            $list[] = new Result($id);
        }

        return $list;
    }

    public static function getAllIds($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getCol('SELECT id FROM results ' . $where['where'] . ' ORDER BY id DESC', $where['params']);
    }

    public static function getAllCount($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getVar('SELECT COUNT(*) FROM results ' . $where['where'] . ' ORDER BY id DESC', $where['params']);
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

        return $DB->getVar('SELECT ' . $col . ' FROM results WHERE id = :id LIMIT 1', array('id' => $id));
    }

    public static function getIdFrom($col, $val)
    {
        global $DB;

        return $DB->getVar('SELECT id FROM results WHERE ' . $col . ' = :' . $col . ' LIMIT 1', array($col => $val));
    }
}