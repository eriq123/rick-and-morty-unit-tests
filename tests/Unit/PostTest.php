<?php

namespace Tests\Unit;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private $sampleData = [
        'title' => 'Alan Rails',
        'description' => 'Alan Rails is a male human. Latest status is dead.',
        'image' => 'https://rickandmortyapi.com/api/character/avatar/10.jpeg',
    ];

    public function test_add_post()
    {
        $postCount = Post::count();

        $response = $this->postJson('/api/post/store', $this->sampleData);

        $updatedPostCount = Post::count();

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertGreaterThan($postCount, $updatedPostCount, 'Post count is not greater than the updated post count');
    }

    public function test_add_post_with_no_image_link()
    {
        $data = $this->sampleData;
        unset($data['image']);
        $response = $this->post('/api/post/store', $data);
        $response->assertSessionHasErrors('image');
    }

    public function test_get_all_posts()
    {
        $response = $this->getJson('/api/posts');

        $posts = Post::all();

        $response->assertStatus(200)
            ->assertExactJson([
                'status' => 'success',
                'posts' => $posts,
            ]);
    }

    public function test_remove_single_post()
    {
        $post = Post::factory()->create();
        $postCount = Post::count();
        $data = [
            'id' => $post->id
        ];
        $response = $this->postJson('/api/post/delete', $data);

        $response->assertStatus(200)
            ->assertExactJson([
                'status' => 'success',
            ]);

        $this->assertEquals($postCount - 1, Post::count());
    }
}
