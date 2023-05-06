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

    public static function update($id, $values = array())
    {
        global $DB;

        $oldValues = $DB->getRow('SELECT * FROM articles WHERE id = :id', array('id' => $id));
        $validCols = array('title', 'content');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols) && $value != $oldValues[$col]) {
                $sanitizedValues[$col] = $value;
            }
        }

        return count($sanitizedValues) == 0 || $DB->update('articles', $sanitizedValues, 'id = ' . $id);
    }

    public static function delete($id)
    {
        global $DB;

        $DB->delete('articles', 'id = ' . $id);
    }

    public static function getAll($data = array(), $where = '')
    {
        $ids = self::getAllIds($data, $where);
        $list = array();

        foreach ($ids as $id) {
            $list[] = new Article($id);
        }

        return $list;
    }

    public static function getAllIds($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getCol('SELECT id FROM articles ' . $where['where'] . ' ORDER BY id DESC', $where['params']);
    }

    public static function getAllCount($data = array(), $where = '')
    {
        global $DB;

        $where = self::getAllWhere($data, $where);

        return $DB->getVar('SELECT COUNT(*) FROM articles ' . $where['where'] . ' ORDER BY id DESC', $where['params']);
    }

    public static function getAllWhere($data = array(), $where = '')
    {
        $params = array();
        $wheres = array();

        if (is_array($data)) {
            // TODO: 
        }

        if ($where != '') {
            $wheres[] = $where;
        }

        return array(
            'where' => count($wheres) > 0 ? ' WHERE ' . implode(' AND ', $wheres) : '',
            'params' => $params
        );
    }

    public static function get($id, $col)
    {
        global $DB;

        return $DB->getVar('SELECT ' . $col . ' FROM articles WHERE id = :id LIMIT 1', array('id' => $id));
    }

    public static function getIdFrom($col, $val)
    {
        global $DB;

        return $DB->getVar('SELECT id FROM articles WHERE ' . $col . ' = :' . $col . ' LIMIT 1', array($col => $val));
    }
}