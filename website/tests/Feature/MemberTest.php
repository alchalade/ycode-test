<?php

namespace Tests\Feature;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test adding member to waiting list without image
     *
     * @return void
     */
    public function testAddMemberWithoutImage()
    {
        $memberData = [
            'name' => 'Test Member',
            'email' => 'test@example.com'
        ];
        $response = $this->post('/api/members', $memberData);

        $response->assertStatus(201);
        $this->assertDatabaseCount('members', 1);
        $member = Member::first();
        $this->assertNull($member->image_url);
    }

    /**
     * Test adding member to waiting list with image
     *
     * @return void
     */
    public function testAddMemberWithImage()
    {
        $memberData = [
            'name' => 'Test Member',
            'email' => 'test@example.com',
            'image' => new UploadedFile(resource_path('test-files/avatar.jpeg'), 'avatar.png', null, null,  true),
        ];
        $response = $this->post('/api/members', $memberData);

        $response->assertStatus(201);
        $this->assertDatabaseCount('members', 1);
        $member = Member::first();
        $this->assertNotNull($member->image_url);
        $this->assertNotNull($member->image_path);
    }

    /**
     * Test adding member to waiting list with wrong image type
     *
     * @return void
     */
    public function testAddMemberWithWrongImageType()
    {
        $memberData = [
            'name' => 'Test Member',
            'email' => 'test@example.com',
            'image' => new UploadedFile(resource_path('test-files/avatar.png'), 'avatar.png', null, null,  true),
        ];
        $response = $this->post('/api/members', $memberData);

        $response->assertStatus(302);
        $this->assertDatabaseCount('members', 0);

    }
}
