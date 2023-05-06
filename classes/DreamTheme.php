<?php
namespace Webcup;

class DreamTheme {
    private int $id;
    private string $title;
    private string $foregroundColor;
    private string $backgroundColor;
    private string $backgroundImage;

    public function __construct(int $id) {
        if (!is_numeric($id)) {
            return;
        }

        global $DB;

        $dreamTheme = $DB->getRow('SELECT * FROM dream_themes WHERE id = :id', array('id' => $id));

        if (count($dreamTheme) == 0) {
            return;
        }

        foreach ($dreamTheme as $col => $val) {
            $func = 'set' . snakeToPascal($col);

            if (method_exists($this, $func)) {
                $this->$func($val);
            }
        }      
    }

    public function id(): int {
        return $this->id;
    }

    public function title(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function foregroundColor(): string {
        return $this->foregroundColor;
    }

    public function setForegroundColor(string $foregroundColor): void {
        $this->foregroundColor = $foregroundColor;
    }

    public function backgroundColor(): string {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): void {
        $this->backgroundColor = $backgroundColor;
    }

    public function backgroundImage(): string {
        return $this->backgroundImage;
    }

    public function setBackgroundImage(string $backgroundImage): void {
        $this->backgroundImage = $backgroundImage;
    }
}

class DreamThemeService {
    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM dream_themes WHERE id = :id', array('id' => $id)) > 0;
    }

    public static function save($values = array()) {
        global $DB;

        $validCols = array('title', 'foreground_color', 'background_color', 'background_image');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols)) {
                $sanitizedValues[$col] = $value;
            }
        }

        return $DB->insert('dream_themes', $sanitizedValues);
    }

    public static function update($id, $values = array())
    {
        global $DB;

        $oldValues = $DB->getRow('SELECT * FROM dream_themes WHERE id = :id', array('id' => $id));
        $validCols = array('title', 'foreground_color', 'background_color', 'background_image');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols) && $value != $oldValues[$col]) {
                $sanitizedValues[$col] = $value;
            }
        }

        return count($sanitizedValues) == 0 || $DB->update('dream_themes', $sanitizedValues, 'id = ' . $id);
    }

    public static function delete($id)
    {
        global $DB;

        $DB->delete('dream_themes', 'id = ' . $id);
    }

    public static function getAll($data = array(), $where = '')
    {
        $ids = self::getAllIds($data, $where);
        $list = array();

        foreach ($ids as $id) {
            $list[] = new DreamTheme($id);
        }

        return $list;
    }

    public static function getAllIds($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getCol('SELECT id FROM dream_themes ' . $where['where'] . ' ORDER BY id DESC', $where['params']);
    }

    public static function getAllCount($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getVar('SELECT COUNT(*) FROM dream_themes ' . $where['where'] . ' ORDER BY id DESC', $where['params']);
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

        return $DB->getVar('SELECT ' . $col . ' FROM dream_themes WHERE id = :id LIMIT 1', array('id' => $id));
    }

    public static function getIdFrom($col, $val)
    {
        global $DB;

        return $DB->getVar('SELECT id FROM dream_themes WHERE ' . $col . ' = :' . $col . ' LIMIT 1', array($col => $val));
    }
}