<?php
namespace Webcup;

class ResultMetaKeys {
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

class ResultMetaKeysService {

}