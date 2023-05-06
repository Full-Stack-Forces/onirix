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
        $this->key = DreamMetaKeyService::exist() ? new DreamMetaKey($keyId) : null;
    }

    public function dream(): Dream {
        return $this->dream;
    }

    private function setDream(int $dreamId): void {
        $this->dream = DreamService::exist() ? new Dream($dreamId) : null;
    }

    public function value(): string {
        return $this->value;
    }

    private function setValue(string $value): void {
        $this->value = $value;
    }
}

class DreamMetaValueService {
    
}