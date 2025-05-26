<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::all();
        $users = User::all();

        // Make sure we have books and users
        if ($books->count() === 0 || $users->count() === 0) {
            $this->command->info('No books or users found. Please seed books and users first.');
            return;
        }

        foreach ($books as $book) {
            // Each book gets 3 to 7 reviews
            $reviewCount = rand(3, 7);
            for ($i = 0; $i < $reviewCount; $i++) {
                $user = $users->random();

                Review::create([
                    'book_id' => $book->id,
                    'user_id' => $user->id,
                    'review' => fake()->paragraph(2),
                    'rating' => fake()->randomFloat(1, 1, 5),
                    'status' => 'active',
                ]);
            }
        }
    }
}
