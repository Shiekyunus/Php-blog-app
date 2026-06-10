<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_home_page_loads()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_about_page_loads()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }
    public function test_categories_page_loads()
    {
        $response = $this->get('/categories');

        $response->assertStatus(200);
    }
    public function test_tags_page_loads()
    {
        $response = $this->get('/tags');

        $response->assertStatus(200);
    }
    public function test_login_page_loads()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    public function test_register_page_loads()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }
    public function test_dashboard_requires_authentication()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
    public function test_authenticated_user_can_access_dashboard()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }
    public function test_profile_requires_authentication()
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');
    }
    public function test_articles_requires_authentication()
    {
        $response = $this->get('/articles');
        $response->assertRedirect('/login');
    }
    public function test_feedback_page_loads()
    {
        $response = $this->get('/feedback/create');

        $response->assertStatus(200);
    }
    public function test_feedback_requires_authention()
    {
        $response = $this->get('/feedback/sent');
        $response->assertRedirect('/login');
    }
    public function test_saved_articles_requires_auth()
    {
        $response = $this->get('saved');
        $response->assertRedirect('/login');
    }
    public function test_authenticated_user_can_access_saved_articles()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/saved');
        $response->assertStatus(200);
    }
    public function test_liked_articles_requires_auth()
    {
        $response = $this->get('likes');
        $response->assertRedirect('/login');
    }
    public function test_authenticated_user_can_access_liked_articles()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/likes');
        $response->assertStatus(200);
    }
    public function test_comments_requires_auth()
    {
        $response = $this->get('/comments/pending');
        $response->assertRedirect('/login');
    }
    public function test_backup_requires_auth()
    {
        $response = $this->get('/backup/create');
        $response->assertRedirect('/login');
    }
    public function test_notifications_requires_auth()
    {
        $response = $this->get('/notifications');
        $response->assertRedirect('/login');
    }
    public function test_authenticated_user_can_access_notifications()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/notifications');
        $response->assertStatus(200);
    }
    public function test_authentication_user_can_access_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/profile');
        $response->assertStatus(200);
    }
    public function test_subscription_requires_auth()
    {
        $response = $this->post('/subscribe');
        $response->assertRedirect('/login');
    }
    public function test_authenticated_user_can_access_subscription()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/subscribe');
        $response->assertStatus(302);
    }
    public function test_unsubscription_requires_auth()
    {
        $response = $this->delete('/unsubscribe');
        $response->assertRedirect('/login');
    }
    public function test_authenticated_user_can_access_unsubscription()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete('/unsubscribe');
        $response->assertStatus(302);
    }
    public function test_search_page_loads()
    {
        $response = $this->get('/search');
        $response->assertStatus(200);
    }
    public function test_guest_can_view_categories_index_page()
    {
        $response = $this->get('/categories');
        $response->assertStatus(200);
    }
    public function test_guest_can_view_tags_index_page()
    {
        $response = $this->get('/tags');
        $response->assertStatus(200);
    }
}
