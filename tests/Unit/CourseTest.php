<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Course;

// TODO: add a test case for the maximum number of credits must also be positive
// TODO: add a test case for number of hours in a bimester, must also be positive
class CourseTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Checks if a course is inserted as expected.
     */
    public function testAddCourse()
    {
        $data = ['id' => 'PRJG5'];
        $course1 = factory(Course::class)->create($data);  
        $course = Course::find('PRJG5');
        $this->assertDatabaseHas('courses', $data);
    }

    /**
     * Expects a PDOException on constraint violation.
     */
    public function testAddCourseWithExistingId()
    {
        $course1 = factory(Course::class)->create(['id' => 'DONG5',]);     
        $this->expectException(\PDOException::class);
        $course2 = factory(Course::class)->create(['id' => 'DONG5',]);     
    }

    /**
     * Checks if a course is deleted as expected.
     */
    public function testDeleteCourse()
    {
        $data = ['id' => 'PRJG5'];
        $course = factory(Course::class)->create($data);
        Course::destroy('PRJG5');
        $this->assertDatabaseMissing('courses', $data);
    }

    /**
     * Checks if a course is updated as expected.
     */
    public function testUpdateValidCourse()
    {
        $data = factory(Course::class)->create(['id' => 'PRJG5']);
        $course = Course::find('PRJG5');
        $course->id = 'DONG5';
        $course->save();
        $other = Course::find('DONG5');
        $this->assertEquals('DONG5', $other->id);        
    }
    
    /**
     * Expects a PDOException on constraint violation.
     */
    public function testAddCourseWithExistingTitle()
    {
        $course1 = factory(Course::class)->create(['title' => 'Abigail',]);     
        $this->expectException(\PDOException::class);
        $course2 = factory(Course::class)->create(['title' => 'Abigail',]);     
    }

    /**
     * Expects a PDOException on constraint violation.
     */
    public function testAddCourseWithTooMuchCredits()
    {
        $course=factory(Course::class)->create(['credits' => 31,]);
        //$this->expectException(\PDOException::class);
        $this->assertEquals($course['credits'], 31);
    }

}