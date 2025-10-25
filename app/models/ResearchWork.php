<?php

namespace App\Models;

use App\Model;

class ResearchWork extends Model
{
    /** static data */
    public    static $table         = 'research_works';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'title', 'abstract', 'publication_year', 'keywords'];

    /** properties */
    protected $title            = '';
    protected $abstract         = '';
    protected $publication_year = '';
    protected $keywords         = '';
    protected $file_path        = '';
    protected $department_id    = 0;
    protected $uploaded_at      = '';


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
     * Gets ResearchWorks title.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * Gets ResearchWorks abstract.
     * @return string
     */
    public function getAbstract(): string
    {
        return $this->abstract;
    }


    /**
     * Gets ResearchWorks publication_year.
     * @return string
     */
    public function getPublicationYear(): string
    {
        return $this->publication_year;
    }


    /**
     * Gets ResearchWorks keywords.
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }


    /**
     * Gets ResearchWorks file_path
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->file_path;
    }


    /**
     * Gets ResearchWorks department_id
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->department_id;
    }


    /**
     * Gets ResearchWorks uploaded_at
     * @return string
     */
    public function getUploadedAt(): string
    {
        return $this->uploaded_at;
    }


    /**
     * Sets ResearchWorks title.
     * @param $title
     * @return void
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }


    /**
     * Sets ResearchWorks abstract.
     * @param $abstract
     * @return void
     */
    public function setAbstract($abstract): void
    {
        $this->abstract = $abstract;
    }


    /**
     * Sets ResearchWorks publication_year.
     * @param $publication_year
     * @return void
     */
    public function setPublicationYear($publication_year): void
    {
        $this->publication_year = $publication_year;
    }


    /**
     * Sets ResearchWorks keywords.
     * @param $keywords
     * @return void
     */
    public function setKeywords($keywords): void
    {
        $this->keywords = $keywords;
    }


    /**
     * Sets ResearchWorks file_path
     * @param $file_path
     * @return void
     */
    public function setFilePath($file_path): void
    {
        $this->file_path = $file_path;
    }


    /**
     * Sets ResearchWorks department_id
     * @param $department_id
     * @return void
     */
    public function setDepartmentId($department_id): void
    {
        $this->department_id = $department_id;
    }


    /**
     * Sets ResearchWorks uploaded_at
     * @param $uploaded_at
     * @return void
     */
    public function setUploadedAt($uploaded_at): void
    {
        $this->uploaded_at = $uploaded_at;
    }


    /**
     * Retrieves all ResearchWorks records, optionally filtering by Department.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @param Department|null $department
     * @return array
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false, ?Department $department = null): array
    {
        $query = "SELECT * FROM `" . self::$table . "`";
        $params = [];
        $types = '';

        if ($department !== null) {
            $query .= " WHERE `department_id` = ?";
            $params[] = $department->getId();
            $types .= "i";
        }

        $stmt = self::getConnectionStatic()->prepare($query);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $research_works = [];

        while ($row = $result->fetch_assoc()) {
            $research_work = new ResearchWork();
            $research_work->hydrate($row);
            $research_works[] = $assoc ? $research_work->getAssoc($assoc_basic) : $research_work;
        }

        return $research_works;
    }


    /**
     * Gets the Department that this ResearchWork belongs to.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return Department|array|null
     * @throws Exception
     */
    public function getDepartment(bool $assoc = false, bool $assoc_basic = false): Department|array|null
    {
        $department = Department::find($this->department_id);
        return ($assoc && $department) ? $department->getAssoc($assoc_basic) : $department;
    }


    /**
     * Gets all Authors that belong to this ResearchWork.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getAuthors(bool $assoc = false, bool $assoc_basic = false): array
    {
        $authors = [];

        $query = "SELECT a.* FROM `authors` a " .
            "JOIN `work_authors` wa ON a.id = wa.author_id " .
            "WHERE wa.work_id = ?";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $author = new Author();
            $author->hydrate($row);
            $authors[] = $assoc ? $author->getAssoc($assoc_basic) : $author;
        }

        return $authors;
    }

    /**
     * Links an Author to this ResearchWork.
     *
     * @param int $author_id
     * @return bool
     */
    public function addAuthor(int $author_id): bool
    {
        // Use IGNORE to prevent a crash if the link already exists
        $stmt = $this->getConnection()->prepare("INSERT IGNORE INTO `work_authors` (work_id, author_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $this->id, $author_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    /**
     * Removes an Author from this ResearchWork.
     *
     * @param int $author_id
     * @return bool
     */
    public function removeAuthor(int $author_id): bool
    {
        $stmt = $this->getConnection()->prepare("DELETE FROM `work_authors` WHERE work_id = ? AND author_id = ?");
        $stmt->bind_param("ii", $this->id, $author_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }


    /**
     * Insert research_work
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`title`, `abstract`, `publication_year`, `keywords`, `file_path`, `department_id`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $this->title, $this->abstract, $this->publication_year, $this->keywords, $this->file_path, $this->department_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update research_work
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `title` = ?, `abstract` = ?, `publication_year` = ?, `keywords` = ?, `file_path` = ?, `department_id` = ? WHERE `id` = ?");
        $stmt->bind_param("sssssii", $this->title, $this->abstract, $this->publication_year, $this->keywords, $this->file_path, $this->department_id, $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }


    /**
     * Delete research_work
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
