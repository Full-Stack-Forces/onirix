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
        $this->dream = DreamService::exist() ? new Dream($dreamId) : null;
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
}