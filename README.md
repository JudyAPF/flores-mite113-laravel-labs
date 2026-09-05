# MITE113 — Laravel Lab Activities 1 & 2

Coursework by Judy Ann P. Flores.

A Laravel 12 project demonstrating the Route → Controller → View flow and a
MySQL + Eloquent data layer, styled with Tailwind CSS v4.

## Lab Activity 1 — Student Profile Page

A student profile page at `/profile` built to show how a request travels through Laravel.

| Piece | File |
| --- | --- |
| Named route `profile.show` | `routes/web.php` |
| Controller | `app/Http/Controllers/ProfileController.php` |
| Blade view | `resources/views/profile.blade.php` |

The page displays the student's name, program, year level, three skills, and a short
career goal.

**Extension:** `/profile/{name}` looks the student up in MySQL with Eloquent instead of
using a hard-coded array.

## Lab Activity 2 — Student Data Layer

Student profiles are stored in MySQL rather than a temporary PHP array.

**`students` table**

| Column | Notes |
| --- | --- |
| `id` | primary key |
| `student_number` | unique, nullable *(extension task)* |
| `name` | |
| `email` | unique |
| `program` | |
| `year_level` | |
| `created_at` / `updated_at` | timestamps |

Records are created and queried with Laravel Tinker, keeping the focus on
migrations and Eloquent rather than forms.

```php
// Create
App\Models\Student::create([
    'name' => 'Judy Ann P. Flores',
    'email' => 'floresjudyannp@gmail.com',
    'program' => 'BSIT',
    'year_level' => '3rd Year',
]);

// Retrieve BSIT students by name
App\Models\Student::where('program', 'BSIT')->orderBy('name')->get();
App\Models\Student::where('program', 'BSIT')->where('name', 'Judy Ann P. Flores')->first();
```

## Color Palette

| Name | Hex | Tailwind class |
| --- | --- | --- |
| Lucky Point | `#121561` | `lucky-point` |
| Cornflower | `#92bfe7` | `cornflower` |
| Mystic | `#edf0f5` | `mystic` |
| Ship Cove | `#6b7abc` | `ship-cove` |

Registered as Tailwind v4 theme colors in `resources/css/app.css`.

## Setup

Requires PHP 8.2+, Composer, Node.js, and MySQL (XAMPP works).

```bash
# 1. Install dependencies
composer install
npm install

# 2. Configure environment
cp .env.example .env
php artisan key:generate

# 3. Create the database (or use phpMyAdmin)
mysql -u root -e "CREATE DATABASE flores_mite113"

# 4. Build the tables
php artisan migrate

# 5. Build assets and run
npm run build
php artisan serve
```

Then open <http://127.0.0.1:8000/profile>.

## Tech Stack

- Laravel 12 (PHP 8.2)
- MySQL / MariaDB
- Tailwind CSS v4 via Vite
- Blade templates

## Reference

- [Laravel Migrations](https://laravel.com/docs/13.x/migrations)
- [Laravel Eloquent](https://laravel.com/docs/13.x/eloquent)
