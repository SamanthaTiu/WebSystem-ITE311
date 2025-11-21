<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table      = 'courses';
    protected $primaryKey = 'course_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'course_name',
        'description',
        'instructor_id',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get all active courses
     */
    public function getAllCourses()
    {
        return $this->findAll();
    }

    /**
     * Get a single course by ID
     */
    public function getCourse($id)
    {
        return $this->find($id);
    }

    /**
     * Create a new course
     */
    public function createCourse($data)
    {
        return $this->insert($data);
    }
}