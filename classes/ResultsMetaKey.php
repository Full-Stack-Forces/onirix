<?php
namespace Webcup;

class ResultMetaKey {
    private int $id;
    private string $title;
    private string $description;

    public function __construct(int $id) {
        global $DB;

        $resulstMetaKey = $DB->getRow('SELECT * FROM results_meta_keys WHERE id = :id', array('id' => $id));

        if (count($resulstMetaKey) == 0) {
            return;
        }

        foreach ($resulstMetaKey as $col => $val) {
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

class ResultMetaKeyService {
    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM result_meta_keys WHERE id = :id', array('id' => $id)) > 0;
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

        return $DB->insert('result_meta_keys', $sanitizedValues);
    }

    public static function update($id, $values = array())
    {
        global $DB;

        $oldValues = $DB->getRow('SELECT * FROM result_meta_keys WHERE id = :id', array('id' => $id));
        $validCols = array('title', 'description');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols) && $value != $oldValues[$col]) {
                $sanitizedValues[$col] = $value;
            }
        }

        return count($sanitizedValues) == 0 || $DB->update('result_meta_keys', $sanitizedValues, 'id = ' . $id);
    }

    public static function delete($id)
    {
        global $DB;

        $DB->delete('result_meta_keys', 'id = ' . $id);
    }
}