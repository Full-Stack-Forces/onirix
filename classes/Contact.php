<?php
namespace Webcup;

class Contact {
    private int $id;
    private bool $isSent;
    private string $lastName;
    private string $firstName;
    private string $email;
    private string $phone;
    private string $subject;
    private string $content;
    private \DateTime $created;

    public function __construct(int $id) {
        global $DB;

        $contact = $DB->getRow('SELECT * FROM contacts WHERE id = :id', array('id' => $id));

        if (count($contact) == 0) {
            return;
        }

        foreach ($contact as $col => $val) {
            $func = 'set' . snakeToPascal($col);

            if (method_exists($this, $func)) {
                if ($col === 'isSent') {
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

    public function isSent(): bool {
        return $this->isSent;
    }

    private function setIsSent(bool $isSent): void {
        $this->isSent = $isSent;
    }

    public function lastName(): string {
        return $this->lastName;
    }

    private function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function firstName(): string {
        return $this->firstName;
    }

    private function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function email(): string {
        return $this->email;
    }

    private function setEmail(string $email): void {
        $this->email = $email;
    }

    public function phone(): string {
        return $this->phone;
    }

    private function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    public function subject(): string {
        return $this->subject;
    }

    private function setSubject(string $subject): void {
        $this->subject = $subject;
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
}

class ContactService {
    public static function exist($id)
    {
        global $DB;

        return $DB->getVar('SELECT COUNT(*) FROM contacts WHERE id = :id', array('id' => $id)) > 0;
    }

    public static function save($values = array()) {
        global $DB;

        $validCols = array('is_sent', 'last_name', 'first_name', 'email', 'phone', 'subject', 'content');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols)) {
                $sanitizedValues[$col] = $value;
            }
        }

        return $DB->insert('contacts', $sanitizedValues);
    }

    public static function update($id, $values = array())
    {
        global $DB;

        $oldValues = $DB->getRow('SELECT * FROM contacts WHERE id = :id', array('id' => $id));
        $validCols = array('is_sent', 'last_name', 'first_name', 'email', 'phone', 'subject', 'content');
        $sanitizedValues = array();

        foreach ($values as $col => $value) {
            if (in_array($col, $validCols) && $value != $oldValues[$col]) {
                $sanitizedValues[$col] = $value;
            }
        }

        return count($sanitizedValues) == 0 || $DB->update('contacts', $sanitizedValues, 'id = ' . $id);
    }

    public static function delete($id)
    {
        global $DB;

        $DB->delete('contacts', 'id = ' . $id);
    }
}