<?php

require_once __DIR__ . '/Model.php';

class Department extends Model
{
    /** static data */
    public    static $table         = 'departments';
    public    static $table_columns = [];
    protected static $basic_columns = ['id', 'name'];

    /** properties */
    protected $name = '';


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
     * Gets Department name.
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Sets Department name.
     * @param $name
     * @return void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


    /**
     * Get all Department.
     * @param false $assoc
     * @param false $assoc_basic
     * @return array
     */
    public static function all(bool $assoc = false, bool $assoc_basic = false): array
    {
        $departments = [];

        $stmt = self::getConnectionStatic()->prepare("SELECT * FROM `" . self::$table . "`");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $department = new Department();
                $department->hydrate($row);

                $departments[] = $assoc ? $department->getAssoc($assoc_basic) : $department;
            }
        }

        return $departments;
    }


    /**
     * Gets all ResearchWorks that belong to this Department.
     *
     * @param bool $assoc
     * @param bool $assoc_basic
     * @return array
     */
    public function getResearchWorks(bool $assoc = false, bool $assoc_basic = false): array
    {
        require_once __DIR__ . '/ResearchWork.php';
        return ResearchWork::all($assoc, $assoc_basic, $this);
    }


    /**
     * Insert department
     *
     * @return bool
     * @throws Exception
     */
    public function insert(): bool
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO `" . self::$table . "` (`name`) VALUES (?)");
        $stmt->bind_param("s", $this->name);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $this->setId($stmt->insert_id);
            return true;
        }
        return false;
    }


    /**
     * Update department
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        $stmt = $this->getConnection()->prepare("UPDATE `" . self::$table . "` SET `name` = ? WHERE `id` = ?");
        $stmt->bind_param("si",$this->name, $this->id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }


    /**
     * Delete department
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
