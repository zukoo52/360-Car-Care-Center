<?php

namespace Tests\Feature;

use App\Models\Branch;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BranchManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    // @test */
    public function test_create_new_branch()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('POST', '/api/branch', [
            'name' => 'Sample branch name',
            'address' => 'Some branch in kandy',
            'code' => 'KAN'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseCount('branches', 1);
    }

    // @test */
    public function test_get_all_branches()
    {
        Branch::insert([
            'name' => 'Sample branch name',
            'address' => 'Some branch in kandy',
            'code' => 'KAN'
        ]);

        Branch::insert([
            'name' => 'Sample branch two',
            'address' => 'Some branch in nuwara eliya',
            'code' => 'NUW'
        ]);

        $response = $this->json('GET', '/api/branch');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Sample branch two'
        ]);
    }

    // @test */
    public function test_get_branch_by_keyword()
    {
        Branch::insert([
            'name' => 'Sample branch name',
            'address' => 'Some branch in kandy',
            'code' => 'KAN'
        ]);

        Branch::insert([
            'name' => 'Sample branch two',
            'address' => 'Some branch in nuwara eliya',
            'code' => 'NUW'
        ]);

        $response = $this->json('GET', '/api/branch', [
            'keyword' => 'nuwara eliya'
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Sample branch two'
        ]);
        $response->assertJsonCount(1);
    }

    // @test */
    public function test_get_branches_paginated()
    {
        $per_page = 1;
        Branch::insert([
            'name' => 'Sample branch name',
            'address' => 'Some branch in kandy',
            'code' => 'KAN'
        ]);

        Branch::insert([
            'name' => 'Sample branch two',
            'address' => 'Some branch in nuwara eliya',
            'code' => 'NUW'
        ]);

        $response = $this->json('GET', '/api/branch', [
            'limit' => $per_page
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            $per_page
        ]);
    }

    // @test */
    public function test_get_branch_by_id()
    {

        Branch::insert([
            'name' => 'Sample branch name',
            'address' => 'Some branch in kandy',
            'code' => 'KAN'
        ]);

        Branch::insert([
            'name' => 'Sample branch two',
            'address' => 'Some branch in nuwara eliya',
            'code' => 'NUW'
        ]);

        $response = $this->json('GET', '/api/branch/1');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Sample branch name',
        ]);
    }

    // @test */
    public function test_update_branch_details()
    {
        Branch::insert([
            'name' => 'Sample branch name',
            'address' => 'Some branch in kandy',
            'code' => 'KAN'
        ]);

        Branch::insert([
            'name' => 'Sample branch two',
            'address' => 'Some branch in nuwara eliya',
            'code' => 'NUW'
        ]);

        $response = $this->json('PATCH', '/api/branch/1', [
            'name' => 'Updated name',
            'address' => 'Some branch in colombo',
            'code' => 'COL'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'address' => 'Some branch in colombo'
        ]);
    }

    // @test */
    public function test_ignore_code_not_unique_updating_same_record()
    {
        Branch::insert([
            'name' => 'Sample branch name',
            'address' => 'Some branch in kandy',
            'code' => 'KAN'
        ]);

        Branch::insert([
            'name' => 'Sample branch two',
            'address' => 'Some branch in nuwara eliya',
            'code' => 'NUW'
        ]);

        $response = $this->json('PATCH', '/api/branch/1', [
            'name' => 'Updated name',
            'address' => 'Some branch in colombo',
            'code' => 'KAN'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'address' => 'Some branch in colombo'
        ]);
    }

    // @test */
    public function test_delete_branch()
    {
        Branch::insert([
            'name' => 'Sample branch name',
            'address' => 'Some branch in kandy',
            'code' => 'KAN'
        ]);

        Branch::insert([
            'name' => 'Sample branch two',
            'address' => 'Some branch in nuwara eliya',
            'code' => 'NUW'
        ]);

        $response = $this->json('DELETE', '/api/branch/1');
        $response->assertStatus(200);
        $this->assertDatabaseCount('branches', 1);
    }
}
