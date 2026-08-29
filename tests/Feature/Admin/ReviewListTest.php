<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Reviews\ReviewList;
use App\Models\Review;
use App\Models\User;
use App\Models\Destination;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReviewListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function review_list_page_can_be_rendered()
    {
        Livewire::test(ReviewList::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.admin.reviews.review-list');
    }

    /** @test */
    public function it_can_search_reviews_by_comment()
    {
        $review1 = Review::create(['rating' => 5, 'comment' => 'Amazing destination!', 'status' => 'visible']);
        $review2 = Review::create(['rating' => 1, 'comment' => 'Terrible experience', 'status' => 'visible']);

        Livewire::test(ReviewList::class)
            ->set('search', 'Amazing')
            ->assertSee('Amazing destination!')
            ->assertDontSee('Terrible experience');
    }

    /** @test */
    public function it_can_filter_reviews_by_rating()
    {
        Review::create(['rating' => 5, 'comment' => 'Great 5 star spot', 'status' => 'visible']);
        Review::create(['rating' => 2, 'comment' => 'Poor 2 star spot', 'status' => 'visible']);

        Livewire::test(ReviewList::class)
            ->set('ratingFilter', '5')
            ->assertSee('Great 5 star spot')
            ->assertDontSee('Poor 2 star spot');
    }

    /** @test */
    public function it_can_filter_reviews_by_status()
    {
        Review::create(['rating' => 4, 'comment' => 'Visible feedback', 'status' => 'visible']);
        Review::create(['rating' => 4, 'comment' => 'Hidden feedback', 'status' => 'hidden']);

        Livewire::test(ReviewList::class)
            ->set('statusFilter', 'hidden')
            ->assertSee('Hidden feedback')
            ->assertDontSee('Visible feedback');
    }

    /** @test */
    public function it_can_toggle_review_status()
    {
        $review = Review::create(['rating' => 5, 'comment' => 'Test comment', 'status' => 'visible']);

        Livewire::test(ReviewList::class)
            ->call('toggleStatus', $review->review_id);

        $this->assertEquals('hidden', $review->fresh()->status);
    }

    /** @test */
    public function it_can_open_view_details_modal()
    {
        $review = Review::create(['rating' => 5, 'comment' => 'Modal test comment', 'status' => 'visible']);

        Livewire::test(ReviewList::class)
            ->call('viewReview', $review->review_id)
            ->assertSet('showViewModal', true)
            ->assertSee('Modal test comment');
    }

    /** @test */
    public function it_can_delete_a_review()
    {
        $review = Review::create(['rating' => 3, 'comment' => 'Delete me', 'status' => 'visible']);

        Livewire::test(ReviewList::class)
            ->call('confirmDelete', $review->review_id)
            ->assertSet('showDeleteModal', true)
            ->call('deleteReview');

        $this->assertDatabaseMissing('reviews', [
            'review_id' => $review->review_id,
        ]);
    }
}
