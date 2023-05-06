<?php
namespace Webcup;

use DateTime;

class Dream {
    private int $id;
    private User $user;
    private string $title;
    private string $content;
    private bool $isComplete;
    private DreamTheme $theme;
    private \DateTime $created;
    private \DateTime $updated;

    public function __construct(int $id) {
        if (!is_numeric($id)) {
            return;
        }

        global $DB;

        $dream = $DB->getRow('SELECT * FROM dreams WHERE id = :id', array('id' => $id));

        if (count($dream) == 0) {
            return;
        }

        foreach ($dream as $col => $val) {
            $func = 'set' . snakeToPascal($col);

            if (method_exists($this, $func)) {
                if ($col === 'isComplete') {
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

    public function user(): ?User {
        return $this->user;
    }

    private function setUser($idUser): void {
        $this->user = UserService::exist($idUser) ? new User($idUser) : null;
    }

    public function title(): string {
        return $this->title;
    }

    private function setTitle(string $title): void {
        $this->title = $title;
    }

    public function content(): string {
        return $this->content;
    }

    private function setContent(string $content): void {
        $this->content = $content;
    }

    public function isComplete(): bool {
        return $this->isComplete;
    }

    private function setIsComplete(bool $isComplete): void {
        $this->isComplete = $isComplete;
    }

    public function theme(): ?DreamTheme {
        return $this->theme;
    }

    private function setTheme($idTheme): void {
        $this->theme = DreamThemeService::exist($idTheme) ? new DreamTheme($idTheme) : new DreamTheme(1);
    }

    public function created(): \DateTime {
        return $this->created;
    }

    private function setCreated(string $created): void {
        $this->created = new \DateTime($created);
    }

    public function updated(): \DateTime {
        return $this->updated;
    }

    private function setUpdated(string $updated): void {
        $this->updated = new \DateTime($updated);
    }
}

class DreamService {
    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM dreams WHERE id = :id', array('id' => $id)) > 0;
    }

    public static function save($values = array()) {
        global $DB;

        $validCols = array('user', 'title', 'content', 'is_complete', 'theme');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols)) {
                $sanitizedValues[$col] = $value;
            }
        }

        return $DB->insert('dreams', $sanitizedValues);
    }

    public static function update($id, $values = array())
    {
        global $DB;

        $oldValues = $DB->getRow('SELECT * FROM dreams WHERE id = :id', array('id' => $id));
        $validCols = array('title', 'content', 'is_complete', 'theme');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols) && $value != $oldValues[$col]) {
                $sanitizedValues[$col] = $value;
            }
        }

        return count($sanitizedValues) == 0 || $DB->update('dreams', $sanitizedValues, 'id = ' . $id);
    }

    public static function delete($id)
    {
        global $DB;

        $DB->delete('dreams', 'id = ' . $id);
    }
}