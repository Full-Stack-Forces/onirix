<?php
namespace Webcup;

class Ads {
    private int $id;
    private bool $isActive;
    private int $order;
    private string $title;
    private string $link;
    private string $illustration;
    private \DateTime $created;

    public function __construct(int $id) {
        global $DB;

        $article = $DB->getRow('SELECT * FROM ads WHERE id = :id', array('id' => $id));

        if (count($article) == 0) {
            return;
        }

        foreach ($article as $col => $val) {
            $func = 'set' . snakeToPascal($col);

            if (method_exists($this, $func)) {
                if ($col === 'is_active') {
                    $this->$func((bool) $val);
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

    public function isActive(): bool {
        return $this->isActive;
    }

    private function setIsActive(bool $isActive): void {
        $this->isActive = $isActive;
    }

    public function order(): string {
        return $this->order;
    }

    private function setOrder(int $order): void {
        $this->order = $order;
    }

    public function title(): string {
        return $this->title;
    }

    private function setTitle(string $title): void {
        $this->title = $title;
    }

    public function link(): string {
        return $this->link;
    }

    private function setLink(string $link): void {
        $this->link = $link;
    }

    public function illustration(): string {
        return $this->illustration;
    }

    private function setIllustration(string $illustration): void {
        $this->illustration = $illustration;
    }

    public function created(): \DateTime {
        return $this->created;
    }

    private function setCreated(string $created): void {
        $this->created = new \DateTime($created);
    }
}

class AdsService {
    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM ads WHERE id = :id', array('id' => $id)) > 0;
    }

    public static function save($values = array()) {
        global $DB;

        $validCols = array('is_active', 'order', 'title', 'link', 'illustration');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols)) {
                $sanitizedValues[$col] = $value;
            }
        }

        return $DB->insert('ads', $sanitizedValues);
    }

    public static function update($id, $values = array())
    {
        global $DB;

        $oldValues = $DB->getRow('SELECT * FROM ads WHERE id = :id', array('id' => $id));
        $validCols = array('is_active', 'order', 'title', 'link', 'illustration');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols) && $value != $oldValues[$col]) {
                $sanitizedValues[$col] = $value;
            }
        }

        return count($sanitizedValues) == 0 || $DB->update('ads', $sanitizedValues, 'id = ' . $id);
    }

    public static function delete($id)
    {
        global $DB;

        $DB->delete('ads', 'id = ' . $id);
    }

    public static function getAll($data = array(), $where = '')
    {
        $ids = self::getAllIds($data, $where);
        $list = array();

        foreach ($ids as $id) {
            $list[] = new Ads($id);
        }

        return $list;
    }

    public static function getAllIds($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getCol('SELECT id FROM ads ' . $where['where'] . ' ORDER BY order ASC', $where['params']);
    }

    public static function getAllCount($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getVar('SELECT COUNT(*) FROM ads ' . $where['where'] . ' ORDER BY order ASC', $where['params']);
    }

    public static function getAllWhere($data = array(), $where = '')
    {
        $params = array();
        $wheres = array();

        if (is_array($data)) {
            if (isset($data['is_active'])) {
                $wheres[] = 'is_active = :is_active';
                $params['is_active'] = $data['is_active'];
            }
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

        return $DB->getVar('SELECT ' . $col . ' FROM ads WHERE id = :id LIMIT 1', array('id' => $id));
    }

    public static function getIdFrom($col, $val)
    {
        global $DB;

        return $DB->getVar('SELECT id FROM ads WHERE ' . $col . ' = :' . $col . ' LIMIT 1', array($col => $val));
    }
}