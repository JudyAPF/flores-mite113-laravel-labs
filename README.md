# MITE113 — Laravel Lab Activities 1, 2 & 3

Coursework by Judy Ann P. Flores.

A Laravel 12 project demonstrating the Route → Controller → View flow, a
MySQL + Eloquent data layer with a one-to-many relationship, and full CRUD,
styled with Tailwind CSS v4.

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
| `course_id` | foreign key → `courses.id`, nullable *(added in Lab 3)* |
| `name` | |
| `email` | unique |
| `year_level` | nullable |
| `created_at` / `updated_at` | timestamps |

> Lab 3 replaced the old `program` text column with `course_id`. Existing rows
> were migrated across automatically, so no data was lost.

Records are created and queried with Laravel Tinker, keeping the focus on
migrations and Eloquent rather than forms.

```php
// Create
App\Models\Student::create([
    'name' => 'Judy Ann P. Flores',
    'email' => 'floresjudyannp@gmail.com',
    'course_id' => App\Models\Course::where('code', 'BSIT')->value('id'),
    'year_level' => '3rd Year',
]);

// Retrieve BSIT students by name (through the course relationship)
App\Models\Course::where('code', 'BSIT')->first()->students()->orderBy('name')->get();
App\Models\Student::with('course')->where('name', 'Judy Ann P. Flores')->first();
```

## Lab Activity 3 — Courses & Student CRUD

### The `courses` table and its relationship

A course is no longer a string repeated on every student row. It has its own
table, and each student points at one of its rows.

| Column | Notes |
| --- | --- |
| `id` | primary key |
| `code` | unique, e.g. `BSIT` |
| `name` | e.g. BS Information Technology |
| `created_at` / `updated_at` | timestamps |

**One-to-many:** one course has many students; a student belongs to one course.

```php
// app/Models/Course.php
public function students(): HasMany   { return $this->hasMany(Student::class); }

// app/Models/Student.php
public function course(): BelongsTo   { return $this->belongsTo(Course::class); }
```

```php
$student->course->code;                 // "BSIT"
Course::where('code', 'BSIT')->first()->students;   // every BSIT student
Student::with('course')->get();         // eager load, avoids the N+1 problem
```

Deleting a course does **not** delete its students — the foreign key is
`nullOnDelete()`, so those students are simply left without a course.

### Student CRUD

`Route::resource('students', StudentController::class)` registers all seven routes:

| Method | URI | Action | Page |
| --- | --- | --- | --- |
| GET | `/students` | `index` | list, with View Details / Edit / Delete |
| GET | `/students/create` | `create` | Add Student form |
| POST | `/students` | `store` | saves the new student |
| GET | `/students/{id}` | `show` | Student Details |
| GET | `/students/{id}/edit` | `edit` | Update Student form |
| PUT | `/students/{id}` | `update` | saves the edits |
| DELETE | `/students/{id}` | `destroy` | deletes the student |

| Piece | File |
| --- | --- |
| Controller | `app/Http/Controllers/StudentController.php` |
| Views | `resources/views/students/` |
| Shared layout | `resources/views/layouts/app.blade.php` |

The Course dropdown on both forms is built from the `courses` table, so the
options come from the database rather than being hard-coded in the HTML.

**Validation** — name required; email required, valid, and unique (a student
keeps their own email when editing); course required and must exist. Errors are
listed above the form and the typed values are kept via `old()`.

Success messages (`Student created successfully.`, updated, deleted) are flashed
to the session and shown once on the next page.

### Seeding the courses

```bash
php artisan migrate
php artisan db:seed --class=CourseSeeder   # BSIT, BSA, BCS
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

# 4. Build the tables and add the courses
php artisan migrate
php artisan db:seed

# 5. Build assets and run
npm run build
php artisan serve
```

Then open <http://127.0.0.1:8000/> for the profile page, or
<http://127.0.0.1:8000/students> for the student list.

## Tech Stack

- Laravel 12 (PHP 8.2)
- MySQL / MariaDB
- Tailwind CSS v4 via Vite
- Blade templates

## Reference

- [Laravel Migrations](https://laravel.com/docs/13.x/migrations)
- [Laravel Eloquent](https://laravel.com/docs/13.x/eloquent)
- [Eloquent Relationships](https://laravel.com/docs/13.x/eloquent-relationships)
- [Resource Controllers](https://laravel.com/docs/13.x/controllers#resource-controllers)
- [Validation](https://laravel.com/docs/13.x/validation)
