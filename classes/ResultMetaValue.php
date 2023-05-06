<?php
namespace Webcup;

class ResultMetaValue {
    private int $id;
    private Result $result;
    private ResultMetaKey $key;
    private string $value;

    public function __construct(int $id) {
        if (!is_numeric($id)) {
            return;
        }

        global $DB;

        $resultMetaValue = $DB->getRow('SELECT * FROM results_meta_values WHERE id = :id', array('id' => $id));

        if (count($resultMetaValue) == 0) {
            return;
        }

        foreach ($resultMetaValue as $col => $val) {
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

    public function result(): ?Result {
        return $this->result;
    }

    private function setResult($resultId): void {
        $this->result = ResultService::exist() ? new Result($resultId) : null;
    }

    public function key(): ?ResultMetaKey {
        return $this->key;
    }

    private function setKey($keyId): void {
        $this->key = ResultMetaKeyService::exist() ? new ResultMetaKey($keyId) : null;
    }

    public function value(): string {
        return $this->value;
    }

    private function setValue(string $value): void {
        $this->value = $value;
    }
}

class ResultMetaValueService {
    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM result_meta_values WHERE id = :id', array('id' => $id)) > 0;
    }

    public static function save($values = array()) {
        global $DB;

        $validCols = array('key', 'result', 'value');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols)) {
                $sanitizedValues[$col] = $value;
            }
        }

        return $DB->insert('result_meta_values', $sanitizedValues);
    }
}