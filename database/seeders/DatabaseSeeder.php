<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin & Client Users
        User::updateOrCreate(
            ['email' => 'admin@bookshop.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'client@bookshop.com'],
            [
                'name' => 'Client User',
                'password' => Hash::make('password123'),
                'is_admin' => false,
            ]
        );

        // Seed Sample Books if none exist
        if (Book::count() === 0) {
            $books = [
                [
                    'title' => 'Atomic Habits',
                    'author' => 'James Clear',
                    'isbn' => '978-0735211292',
                    'description' => 'Tiny Changes, Remarkable Results: An Easy & Proven Way to Build Good Habits & Break Bad Ones.',
                    'price' => 24.99,
                    'stock_quantity' => 45,
                    'view_count' => 128,
                    'search_count' => 84,
                    'purchase_count' => 32,
                    'is_active' => true,
                ],
                [
                    'title' => 'The Psychology of Money',
                    'author' => 'Morgan Housel',
                    'isbn' => '978-0857197689',
                    'description' => 'Timeless lessons on wealth, greed, and happiness doing well with money isn’t necessarily about what you know.',
                    'price' => 21.50,
                    'stock_quantity' => 28,
                    'view_count' => 95,
                    'search_count' => 62,
                    'purchase_count' => 19,
                    'is_active' => true,
                ],
                [
                    'title' => 'Deep Work',
                    'author' => 'Cal Newport',
                    'isbn' => '978-1455586699',
                    'description' => 'Rules for Focused Success in a Distracted World. Master high-value skills without distraction.',
                    'price' => 27.00,
                    'stock_quantity' => 15,
                    'view_count' => 110,
                    'search_count' => 51,
                    'purchase_count' => 24,
                    'is_active' => true,
                ],
                [
                    'title' => 'Clean Code',
                    'author' => 'Robert C. Martin',
                    'isbn' => '978-0132350884',
                    'description' => 'A Handbook of Agile Software Craftsmanship. Learn how to write maintainable, elegant code.',
                    'price' => 45.99,
                    'stock_quantity' => 8, // Low stock example
                    'view_count' => 215,
                    'search_count' => 140,
                    'purchase_count' => 45,
                    'is_active' => true,
                ],
                [
                    'title' => 'The Pragmatic Programmer',
                    'author' => 'Andrew Hunt & David Thomas',
                    'isbn' => '978-0201616224',
                    'description' => 'Your journey to mastery. 20th Anniversary Edition with classic advice for modern developers.',
                    'price' => 39.99,
                    'stock_quantity' => 19,
                    'view_count' => 160,
                    'search_count' => 98,
                    'purchase_count' => 38,
                    'is_active' => true,
                ],
                [
                    'title' => 'Design Systems Handbook',
                    'author' => 'Marco Suárez',
                    'isbn' => '978-1939902311',
                    'description' => 'A comprehensive guide to creating, documenting, and maintaining robust design systems.',
                    'price' => 29.99,
                    'stock_quantity' => 22,
                    'view_count' => 74,
                    'search_count' => 40,
                    'purchase_count' => 12,
                    'is_active' => true,
                ],
            ];

            foreach ($books as $b) {
                Book::create($b);
            }
        }
    }
}
