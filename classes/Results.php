<?php
namespace Webcup;

class Results {
    private int $id;
    private Dreams $dream;
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

    public function dream(): ?Dreams {
        return $this->dream;
    }

    private function setDream($dreamId): void {
        $this->dream = DreamService::exist() ? new Dreams($dreamId) : null;
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

class ResultsService {

}