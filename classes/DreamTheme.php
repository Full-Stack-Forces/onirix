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
}