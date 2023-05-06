<?php
namespace Webcup;

class ResultMetaValues {
    private int $id;
    private Results $result;
    private ResultMetaKeys $key;
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

    public function result(): ?Results {
        return $this->result;
    }

    private function setResult($resultId): void {
        $this->result = ResultsService::exist() ? new Results($resultId) : null;
    }

    public function key(): ?ResultMetaKeys {
        return $this->key;
    }

    private function setKey($keyId): void {
        $this->key = ResultMetaKeysService::exist() ? new ResultMetaKeys($keyId) : null;
    }

    public function value(): string {
        return $this->value;
    }

    private function setValue(string $value): void {
        $this->value = $value;
    }
}

class ResultMetaValuesService {

}