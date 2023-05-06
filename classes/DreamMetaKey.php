<?php
namespace Webcup;

class DreamMetaKey {
    private int $id;
    private string $title;
    private string $description;

    public function __construct(int $id) {
        global $DB;

        $dreamMetaKey = $DB->getRow('SELECT * FROM dreams_meta_keys WHERE id = :id', array('id' => $id));

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
}