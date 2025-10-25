<?php

require_once __DIR__ . '/Model.php';

class Author extends Model
{
    /** static data */
    public    static $table         = 'authors';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'first_name', 'last_name', 'email'];

    /** properties */
    protected $first_name = '';
    protected $last_name = '';
    protected $email = '';


    /**
     * Constructor
     * @param int $id
     */
    public function __construct(int $id = 0)
    {
        parent::__construct();

        if ($id > 0) {
            $stmt = $this->getConnection()->prepare("SELECT * FROM `" . self::$table . "` WHERE `id` = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->hydrate($row);
            }
        }
    }


    /**
     * Gets Author first_name.
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }


    /**
     * Gets Author last_name
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }


    /**
     * Gets Author email
     * @return mixed|string
     */
    public function getEmail(): mixed
    {
        return $this->email;
    }


    /**
     * Sets Author first_name.
     * @param $first_name
     * @return void
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }


    /**
     * Sets Author last_name
     * @param $last_name
     * @return void
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }


    /**
     * Sets Author email
     * @param $email
     * @return void
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }


    /**
     * Get all Author.
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false): array
    {
        $authors = [];

        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "`");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $author = new Author();
                $author->hydrate($row);

                $authors[] = $assoc ? $author->getAssoc($assoc_basic) : $author;
            }
        }

        return $authors;
    }


    /**
     * Gets all ResearchWorks that this Author has written.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getResearchWorks(bool $assoc = false, bool $assoc_basic = false): array
    {
        require_once __DIR__ . '/ResearchWork.php';
        $research_works = [];

        $query = "SELECT rw.* FROM `research_works` rw " .
            "JOIN `work_authors` wa ON rw.id = wa.work_id " .
            "WHERE wa.author_id = ?";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $research_work = new ResearchWork();
            $research_work->hydrate($row);
            $research_works[] = $assoc ? $research_work->getAssoc($assoc_basic) : $research_work;
        }

        return $research_works;
    }


    /**
     * Insert author
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`first_name`, `last_name`, `email`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $this->first_name, $this->last_name, $this->email);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update author
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `first_name` = ?, `last_name` = ?, `email` = ? WHERE `id` = ?");
        $stmt->bind_param("sssi",$this->first_name, $this->last_name, $this->email, $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }


    /**
     * Delete author
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        $stmt = $this->getConnection()->prepare("DELETE FROM `" . self::$table . "` WHERE `id` = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
