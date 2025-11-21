<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table      = 'enrollments';
    protected $primaryKey = 'enrollment_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id',
        'course_id',
        'enrollment_date',
        'status',
    ];

    /**
     * Insert a new enrollment record.
     * Returns the insert ID on success, or false if the user is already enrolled or on invalid input.
     *
     * @param array $data ['user_id' => int, 'course_id' => int, 'enrollment_date' => 'Y-m-d H:i:s' (optional)]
     * @return int|false
     */
    public function enrollUser(array $data)
    {
        if (empty($data['user_id']) || empty($data['course_id'])) {
            return false;
        }

        $userId   = (int) $data['user_id'];
        $courseId = (int) $data['course_id'];

        if ($this->isAlreadyEnrolled($userId, $courseId)) {
            // prevent duplicates
            return false;
        }

        if (empty($data['enrollment_date'])) {
            $data['enrollment_date'] = date('Y-m-d H:i:s');
        }

        $this->insert([
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrollment_date' => $data['enrollment_date'],
        ]);

        return $this->getInsertID() ?: false;
    }

    /**
     * Fetch all courses a user is enrolled in.
     * Returns an array of enrollment rows joined with course data.
     *
     * @param int $user_id
     * @return array
     */
    public function getUserEnrollments(int $user_id): array
{
    return $this->select('enrollments.enrollment_id as enrollment_id, enrollments.enrollment_date, courses.*, courses.course_name as name')
                ->join('courses', 'courses.course_id = enrollments.course_id')
                ->where('enrollments.user_id', $user_id)
                ->orderBy('enrollments.enrollment_date', 'DESC')
                ->findAll();
}

    /**
     * Check if a user is already enrolled in a specific course.
     *
     * @param int $user_id
     * @param int $course_id
     * @return bool
     */
    public function isAlreadyEnrolled(int $user_id, int $course_id): bool
    {
        return (bool) $this->where(['user_id' => $user_id, 'course_id' => $course_id])->countAllResults();
    }

    /**
     * Fetch all courses a user is enrolled in with instructor details.
     * Returns an array of enrollment rows joined with course and user (instructor) data.
     *
     * @param int $user_id
     * @return array
     */
    public function getUserEnrollmentsWithInstructor(int $user_id): array
    {
        return $this->select('enrollments.enrollment_id as enrollment_id, enrollments.enrollment_date, courses.*, courses.course_name as name, users.name as instructor_name')
                    ->join('courses', 'courses.course_id = enrollments.course_id')
                    ->join('users', 'users.user_id = courses.instructor_id')
                    ->where('enrollments.user_id', $user_id)
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll();
    }
}
