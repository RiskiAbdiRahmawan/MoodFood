<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\UserSession;
use App\Models\MoodModel;
use App\Models\MoodTracking;
use App\Models\FoodAnalytics;
use App\Models\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TrackingSystemTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $session;
    protected $mood;    protected function setUp(): void
    {
        parent::setUp();
        
        // Disable CSRF middleware for testing
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        
        // Create test session
        $this->session = UserSession::create([
            'session_id' => 'test_session_' . uniqid(),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'TestAgent/1.0',
            'preferences' => [],
            'last_activity_at' => now(),
            'first_visit_at' => now(),
            'total_visits' => 1,
        ]);

        // Create test mood
        $this->mood = MoodModel::create([
            'name' => 'bahagia',
            'description' => 'Mood bahagia untuk testing',
            'color' => '#FFD700'
        ]);
    }

    /** @test */
    public function it_can_track_food_interactions()
    {
        $response = $this->postJson('/api/track-food-interaction', [
            'session_id' => $this->session->id,
            'food_name' => 'Pisang',
            'interaction_type' => 'view',
            'metadata' => [
                'type' => 'natural',
                'mood' => 'bahagia',
                'calories' => 89
            ]
        ]);

        $response->assertStatus(200)
                ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('food_analytics', [
            'session_id' => $this->session->id,
            'food_name' => 'Pisang',
            'interaction_type' => 'view'
        ]);
    }

    /** @test */
    public function it_can_submit_feedback()
    {
        $response = $this->postJson('/api/submit-feedback', [
            'session_id' => $this->session->id,
            'type' => 'general',
            'rating' => 5,
            'content' => 'Great application!',
            'scope' => 'overall_experience'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['status', 'message']);

        $this->assertDatabaseHas('feedback', [
            'session_id' => $this->session->id,
            'type' => 'general',
            'rating' => 5,
            'content' => 'Great application!'
        ]);
    }    /** @test */
    public function it_can_track_mood_selections()
    {
        // Set up session for the request
        $this->withSession(['mood_food_session' => $this->session->session_id]);
        
        $response = $this->get("/mood-food?mood={$this->mood->name}&intensity=7");

        // Debug the response if it fails
        if ($response->status() !== 200) {
            dump('Response status: ' . $response->status());
            dump('Response content: ' . $response->getContent());
        }

        $response->assertStatus(200);

        $this->assertDatabaseHas('mood_tracking', [
            'session_id' => $this->session->id,
            'mood_id' => $this->mood->id,
            'intensity' => 7
        ]);
    }

    /** @test */
    public function it_can_retrieve_analytics_data()
    {        // Create some test data
        MoodTracking::create([
            'session_id' => $this->session->id,
            'mood_id' => $this->mood->id,
            'intensity' => 6,
            'tracked_at' => now(),
            'context' => json_encode(['test' => true])
        ]);

        FoodAnalytics::create([
            'session_id' => $this->session->id,
            'food_name' => 'Test Food',
            'interaction_type' => 'click',
            'metadata' => json_encode(['test' => true]),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'TestAgent/1.0'
        ]);

        Feedback::create([
            'session_id' => $this->session->id,
            'type' => 'general',
            'rating' => 4,
            'content' => 'Test feedback',
            'scope' => 'overall_experience',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'TestAgent/1.0'
        ]);

        $response = $this->getJson('/api/analytics');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'total_sessions',
                    'total_mood_selections',
                    'total_food_interactions',
                    'popular_moods',
                    'popular_foods',
                    'feedback_summary'
                ]);
    }

    /** @test */
    public function it_validates_required_fields_for_food_tracking()
    {
        $response = $this->postJson('/api/track-food-interaction', [
            'session_id' => $this->session->id,
            // Missing required fields
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['food_name', 'interaction_type']);
    }

    /** @test */
    public function it_validates_feedback_submission()
    {
        $response = $this->postJson('/api/submit-feedback', [
            'session_id' => $this->session->id,
            'type' => 'invalid_type', // Invalid type
            'rating' => 6, // Invalid rating (should be 1-5)
            'content' => '', // Empty content
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['type', 'rating', 'content']);
    }    /** @test */
    public function it_updates_session_activity_on_interaction()
    {
        $oldActivity = $this->session->last_activity_at;
        
        sleep(1); // Ensure time difference
        
        $this->postJson('/api/track-food-interaction', [
            'session_id' => $this->session->id,
            'food_name' => 'Test Food',
            'interaction_type' => 'view'
        ]);

        $this->session->refresh();
        $this->assertNotEquals($oldActivity, $this->session->last_activity_at);
    }
}
