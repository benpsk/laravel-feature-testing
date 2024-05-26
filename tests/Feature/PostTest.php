<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected $categories;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->seed(CategorySeeder::class);
        $this->categories = Category::all();
    }

    public function test_index_displays_posts()
    {
        Post::factory(10)->create();
        Post::factory()->count(30)->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user)->get(route('posts.index'));
        $response->assertOk()
            ->assertViewIs('post.index')
            ->assertViewHas('posts');
        $this->assertEquals(10, $response->viewData('posts')->count());
        $this->assertEquals(30, $response->viewData('posts')->total());
    }

    public function test_create_displays_form()
    {
        $response = $this->actingAs($this->user)->get(route('posts.create'));
        $response->assertOk()
            ->assertViewIs('post.create');
        $this->categories->each(function ($category) use ($response) {
            $response->assertSee($category->name);
        });
    }

    public function test_store_new_post()
    {
        $category = $this->categories->first();
        $data = [
            'title' => 'New Post',
            'body' => 'This is a new post.',
            'category_id' => $category->id,
        ];
        $response = $this->actingAs($this->user)->post(route('posts.store'), $data);
        $response->assertRedirect(route('posts.index'))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('posts', [
            'title' => 'New Post',
            'body' => 'This is a new post.',
            'category_id' => $category->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_edit_displays_form()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user)->get(route('posts.edit', $post->id));
        $response->assertOk()
            ->assertViewIs('post.edit')
            ->assertViewHas('post', $post);
        $this->categories->each(function ($category) use ($response) {
            $response->assertSee($category->name);
        });
    }

    public function test_update_post_data()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $category = $this->categories->last();
        $data = [
            'title' => 'Updated Post',
            'body' => 'This post has been updated.',
            'category_id' => $category->id,
        ];
        $response = $this->actingAs($this->user)->put(route('posts.update', $post->id), $data);
        $response->assertRedirect(route('posts.index'))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post',
            'body' => 'This post has been updated.',
            'category_id' => $category->id,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_destroy_post()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user)->delete(route('posts.destroy', $post->id));
        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_non_owner_cannot_edit_post_form()
    {
        $nonOwner = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($nonOwner)->get(route('posts.edit', $post->id));
        $response->assertStatus(403);
    }
    public function test_non_owner_cannot_update_post()
    {
        $nonOwner = User::factory()->create();
        $category = $this->categories->first();
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $data = [
            'title' => 'Updated Title by Non-Owner',
            'body' => 'Updated body by non-owner.',
            'category_id' => $category->id,
        ];
        $response = $this->actingAs($nonOwner)->put(route('posts.update', $post->id), $data);
        $response->assertStatus(403);
    }

    public function test_non_owner_cannot_destroy_post()
    {
        $nonOwner = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($nonOwner)->delete(route('posts.destroy', $post->id));
        $response->assertStatus(403);
    }

    public static function invalidPostDataProvider()
    {
        return [
            [
                ['title' => '', 'body' => 'Valid body', 'category_id' => 1],
                ['title'],
            ],
            [
                ['title' => 123, 'body' => 'Valid body', 'category_id' => 1],
                ['title'],
            ],
            [
                ['title' => str_repeat('a', 226), 'body' => 'Valid body', 'category_id' => 1],
                ['title'],
            ],
            [
                ['title' => 'Valid title', 'body' => '', 'category_id' => 1],
                ['body'],
            ],
            [
                ['title' => 'Valid title', 'body' => 123, 'category_id' => 1],
                ['body'],
            ],
            [
                ['title' => 'Valid title', 'body' => str_repeat('a', 6001), 'category_id' => 1],
                ['body'],
            ],
            [
                ['title' => 'Valid title', 'body' => 'Valid body', 'category_id' => ''],
                ['category_id'],
            ],
            [
                ['title' => 'Valid title', 'body' => 'Valid body', 'category_id' => 999],
                ['category_id'],
            ],
            [
                ['title' => '', 'body' => '', 'category_id' => 999],
                ['title', 'body', 'category_id'],
            ],
        ];
    }

    #[DataProvider('invalidPostDataProvider')]
    public function test_update_post_validation(array $invalidData, array $errorFields)
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user)->put(route('posts.update', $post->id), $invalidData);
        $response->assertSessionHasErrors($errorFields);
    }

    #[DataProvider('invalidPostDataProvider')]
    public function test_store_post_validation(array $invalidData, array $errorFields)
    {
        $response = $this->actingAs($this->user)->post(route('posts.store'), $invalidData);
        $response->assertSessionHasErrors($errorFields);
    }
}
