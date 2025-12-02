<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table      = 'materials';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'course_id',
        'file_name',
        'file_path',
        'created_at',
    ];

    protected $useTimestamps = false; // Since only created_at is in the table

    /**
     * Insert a new material record.
     *
     * @param array $data ['course_id' => int, 'file_name' => string, 'file_path' => string, 'created_at' => datetime (optional)]
     * @return int|false The insert ID on success, false on failure
     */
    public function insertMaterial(array $data)
    {
        if (empty($data['course_id']) || empty($data['file_name']) || empty($data['file_path'])) {
            return false;
        }

        if (empty($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        return $this->insert($data) ? $this->getInsertID() : false;
    }

    /**
     * Get all materials for a specific course.
     *
     * @param int $course_id
     * @return array
     */
    public function getMaterialsByCourse(int $course_id): array
    {
        return $this->where('course_id', $course_id)->findAll();
    }
}
