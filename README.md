# Book Shop

A Laravel + Inertia.js + Vue.js + Tailwind CSS book shopping project with admin dashboard.

## Features

- Admin dashboard showing statistics (total books, active books, most viewed, most sold, low stock)
- Admin can create, edit, delete books (with image upload)
- Client side book listing and detailed view
- Purchase functionality (increments purchase count and decreases stock)
- View count tracking
- Authentication (Laravel Breeze) with admin role protection

## Setup

1. Install dependencies:
   ```bash
   composer install
   npm install
   ```

2. Copy environment file and generate key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Configure database in `.env` and run migrations:
   ```bash
   php artisan migrate
   ```

4. Link storage:
   ```bash
   php artisan storage:link
   ```

5. Build assets:
   ```bash
   npm run build   # for production
   # or
   npm run dev     # for development (watch mode)
   ```

6. Register a user and set as admin:
   - Register a user at `/register`
   - Set `is_admin` to `1` in the `users` table for that user

## Access

- Admin dashboard: `/admin/dashboard` (requires auth and admin)
- Admin books: `/admin/books` (requires auth and admin)
- Client books: `/books`
- Book details: `/books/{id}`
- Purchase: `/books/{id}/purchase` (requires auth)

## Technologies

- Laravel 13
- Inertia.js
- Vue 3
- Tailwind CSS
- Vite

## Design

- Modern premium color combos (indigo, green, blue, purple)
- Responsive layout
- GSAP-inspired animations (via Breeze's default transitions)