<?php
namespace Webcup;

class Article {
    private int $id;
    private User $author;
    private string $title;
    private string $content;
    private \DateTime $created;
    private \DateTime $updated;

    public function __construct(int $id) {
        global $DB;

        $article = $DB->getRow('SELECT * FROM articles WHERE id = :id', array('id' => $id));

        if (count($article) == 0) {
            return;
        }

        foreach ($article as $col => $val) {
            $func = 'set' . snakeToPascal($col);

            if (method_exists($this, $func)) {
                if ($col === 'author') {
                    $this->$func(new User($val));
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

    public function author(): ?User {
        return $this->author;
    }

    private function setAuthor(User $author): void {
        $this->author = $author;
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

class ArticleService {
    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM articles WHERE id = :id', array('id' => $id)) > 0;
    }

    public static function save($values = array()) {
        global $DB;

        $validCols = array('author', 'title', 'content');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols)) {
                $sanitizedValues[$col] = $value;
            }
        }

        return $DB->insert('articles', $sanitizedValues);
    }
}