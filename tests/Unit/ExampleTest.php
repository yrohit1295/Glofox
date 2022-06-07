<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * Create classes in the database and check the status code and records
     *
     * @return void
     */
    public function testCreateClasses() {
        $data = [
            'class_name' => 'pilates',
            'start_date' => '2022/12/17',
            'end_date' => '2022/12/18',
            'capacity' => '10'];
        $response = $this->json('post', 'api/classes', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('classes', ['class_name' => 'pilates']);
    }

    /**
     * Create classes in the database and check the status code and records
     * 
     * @return void
     */
    public function testCreateBookings() {
        $data = [
            'name' => 'John',
            'date' => '2022-12-17'];
        $response = $this->json('post', 'api/bookings', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('bookings', ['name' => 'John']);
    }
}
