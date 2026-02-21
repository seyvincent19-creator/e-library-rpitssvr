# E-Library Management System

A full-featured library management system built with **Laravel 12** for managing books, members, borrowing, returns, and attendance — with an analytics dashboard and a public-facing e-library portal.

---

## Requirements

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js & npm (optional, for asset compilation)

> **PHP ini settings** — for PDF upload support, ensure your `php.ini` has:
> ```
> upload_max_filesize = 20M
> post_max_size = 25M
> ```

---

## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd e-library
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_library
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run migrations

```bash
php artisan migrate
```

### 5. Link storage (for uploaded images and PDFs)

```bash
php artisan storage:link
```

### 6. Start the development server

```bash
php artisan serve
```

Visit `http://localhost:8000`

---

## Default Credentials

Run the seeder to create test accounts, sample degrees, students, and lecturers:

```bash
php artisan db:seed
```

| Role | Email | Password | Notes |
|------|-------|----------|-------|
| `admin` | `admin@example.com` | `password` | Full admin access |
| `librarian` | `librarian@example.com` | `password` | Admin panel access |
| `user` (student) | `student@example.com` | `password` | Linked to STU_2501 — Dara Chan |
| `user` (lecturer) | `lecturer@example.com` | `password` | Linked to LEC_001 — Sophal Keo |
| `user` (plain) | `user@example.com` | `password` | No profile link |

The seeder also creates:
- **9 degree records** (Associate, Bachelor, Technical — with multiple majors and study times)
- **2 students** (STU_2501, STU_2502) — available to link when creating members
- **2 lecturers** (LEC_001, LEC_002) — available to link when creating members

---

## Default Roles

| Role | Access |
|------|--------|
| `admin` | Full access to all admin pages |
| `librarian` | Admin panel access |
| `user` | Public e-library portal (books, dashboard, downloads) |

---

## Admin Panel Pages

All admin routes are protected by `auth` + `role:admin,librarian` middleware under the `/admin` prefix.

| Page | URL | Description |
|------|-----|-------------|
| Dashboard | `/admin/dashboard` | Overview stats and recent activity |
| Analytics | `/admin/analytic` | Charts: books, attendance, gender, top borrows |
| Members | `/admin/member` | Manage library members (linked student/lecturer) |
| Students | `/admin/student` | Student records with degree info |
| Lecturers | `/admin/lecturer` | Lecturer records |
| Degrees | `/admin/degree` | Degree levels, majors, study times |
| Books | `/admin/manage_book` | Book catalog with cover image and PDF upload |
| Borrow Books | `/admin/borrow_book` | Issue books to members |
| Return Books | `/admin/return_book` | Process returns and track fines |
| Attendance | `/admin/attendance` | Track library visits by purpose |
| Users | `/admin/user` | Manage system user accounts |

---

## User-Facing Portal

Public and member pages are accessible under the `/user` prefix and at `/`.

| Page | URL | Auth Required |
|------|-----|---------------|
| Home | `/` | No — shows featured/new books, search |
| Book Browser | `/user/books` | No — browse, search, filter by category/language |
| Download PDF | `/user/books/{id}/download` | Yes |
| Dashboard | `/user/dashboard` | Yes — profile, borrow history, stats |

---

## User Registration Flow

Visitors can self-register in three ways from the `/registration` page:

### Student
1. Go to `/registration` → select **"Yes"** to "Are you a student from RPITSSVR?"
2. Fill in personal details (Student ID, name, degree, major, study time, photo)
3. Submit → account creation form appears (`/registration/register`)
4. Enter username, email, and password → account is created and linked to your student profile
5. Log in at `/login`

### Lecturer
1. Go to `/registration` → select **"No"** to student, then **"Yes"** to "Are you a lecturer from RPITSSVR?"
2. Fill in personal details (Lecturer ID, name, department, photo)
3. Submit → account creation form appears
4. Enter username, email, and password → account is created and linked to your lecturer profile
5. Log in at `/login`

### Plain Member
1. Go to `/registration` → select **"No"** to both student and lecturer
2. Select **"Yes"** to "Would you like to register as a regular member?"
3. Enter username, email, and password directly
4. Log in at `/login`

> The account creation step (`/registration/register`) is protected by the `registration.complete` middleware, which requires completing the profile form first.

---

## Key Features

### Admin
- **Book Management** — Add/edit/delete books with cover image upload, PDF file upload (up to 20 MB), category, language, location, quantity tracking
- **PDF Download** — Admin can download any book PDF via `/admin/manage_book/{id}/download`
- **Borrow & Return** — Issue books to members, process returns with automatic fine calculation, overdue detection
- **Attendance Tracking** — Log library visits with purpose (Reading, Use PC, Assignment, Other)
- **Analytics Dashboard** — Highcharts visualizations:
  - Books by language (donut chart)
  - Books by category & language (column chart)
  - Student gender breakdown (pie chart)
  - Weekly attendance trend (spline chart)
  - Most borrowed books table
- **Member Management** — Link accounts to student/lecturer profiles, search by code or name
- **Role-based Access Control** — Admin, Librarian, User roles via middleware

### User Portal
- **Dynamic Home Page** — Featured and new books carousels, live search, book detail modal, auth-aware navigation
- **Book Browser** — Browse all books with live search (by title/author/subject), category and language filters, pagination
- **PDF Download** — Authenticated users can download available book PDFs
- **User Dashboard** — Profile card (with student/lecturer details), borrow statistics (total, active, returned, overdue), fine alerts, borrow history table, currently borrowed books with days remaining

---

## Project Structure

```
app/Http/Controllers/
  AuthController.php          # Login, register, user CRUD
  HomeController.php          # Public home page with featured/new books
  UserBookController.php      # User book browser + PDF download
  UserDashboardController.php # User dashboard stats and borrow history
  DashboardController.php     # Admin dashboard stats
  AnalyticController.php      # Analytics charts data
  StudentController.php       # Student CRUD + self-registration
  LecturerController.php      # Lecturer CRUD + self-registration
  DegreeController.php        # Degree/major management
  BookController.php          # Book catalog CRUD + PDF upload/download
  BorrowController.php        # Borrow book CRUD
  ReturnController.php        # Return book CRUD
  MemberController.php        # Member management
  AttendanceController.php    # Attendance CRUD

resources/views/
  welcome.blade.php                        # Public home page
  layout/user/
    app.blade.php                          # User portal layout (navbar/footer)
    dashboard.blade.php                    # User dashboard
    books/index.blade.php                  # Book browser
    registration/index.blade.php           # Role selection (SweetAlert2)
    registration/student/index.blade.php   # Student registration form
    registration/lecturer/index.blade.php  # Lecturer registration form
  layout/admin/content/
    analytic/   borrow_book/  degree/    lecturer/
    manage_book/ member/      return_book/ student/
    user/        attendance/
```

---

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Bootstrap 5, Bootstrap Icons, Google Fonts (Poppins)
- **Charts:** Highcharts
- **Tables:** DataTables (with export to CSV/Excel/PDF/Print)
- **Alerts:** SweetAlert2
- **Carousels:** Swiper.js
- **Database:** MySQL with Eloquent ORM
- **File Storage:** Laravel Storage (public disk) — images and PDFs

---

## License

MIT
