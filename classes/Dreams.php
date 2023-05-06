<?php
namespace Webcup;

class Dreams {
    private int $id;
    private User $user;
    private string $title;
    private string $content;
    private int $isComplete;
    private DreamThemes $theme;
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

    public function theme(): ?DreamThemes {
        return $this->theme;
    }

    private function setTheme($idTheme): void {
        $this->theme = DreamThemesService::exist($idTheme) ? new DreamThemes($idTheme) : null;
    }

    public function created(): \DateTime {
        return $this->created;
    }

    private function setCreated(\DateTime $created): void {
        $this->created = $created;
    }

    public function updated(): \DateTime {
        return $this->updated;
    }

    private function setUpdated(\DateTime $updated): void {
        $this->updated = $updated;
    }

    public function __destruct()
    {
        $this->setUpdated(new \DateTime());
    }
}

class DreamService {
    
}