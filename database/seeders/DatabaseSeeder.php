<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Book;
use App\Models\BorrowBook;
use App\Models\Degree;
use App\Models\Lecturer;
use App\Models\ReturnBook;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── 1. Degrees ────────────────────────────────────────────────────────────
        $degrees = [
            ['degree_level' => 'associate',  'majors' => 'information technology', 'study_time' => 'morning',   'duration_years' => '2', 'generation' => 'generation 1'],
            ['degree_level' => 'associate',  'majors' => 'information technology', 'study_time' => 'afternoon', 'duration_years' => '2', 'generation' => 'generation 1'],
            ['degree_level' => 'associate',  'majors' => 'accounting',             'study_time' => 'morning',   'duration_years' => '2', 'generation' => 'generation 1'],
            ['degree_level' => 'associate',  'majors' => 'accounting',             'study_time' => 'afternoon', 'duration_years' => '2', 'generation' => 'generation 1'],
            ['degree_level' => 'bachelor',   'majors' => 'computer science',       'study_time' => 'morning',   'duration_years' => '4', 'generation' => 'generation 1'],
            ['degree_level' => 'bachelor',   'majors' => 'computer science',       'study_time' => 'afternoon', 'duration_years' => '4', 'generation' => 'generation 1'],
            ['degree_level' => 'bachelor',   'majors' => 'business administration', 'study_time' => 'morning',  'duration_years' => '4', 'generation' => 'generation 1'],
            ['degree_level' => 'bachelor',   'majors' => 'english',                'study_time' => 'morning',   'duration_years' => '4', 'generation' => 'generation 1'],
            ['degree_level' => 'bachelor',   'majors' => 'english',                'study_time' => 'afternoon', 'duration_years' => '4', 'generation' => 'generation 1'],
            ['degree_level' => 'technical',  'majors' => 'networking',             'study_time' => 'morning',   'duration_years' => '3', 'generation' => 'generation 1'],
            ['degree_level' => 'technical',  'majors' => 'networking',             'study_time' => 'afternoon', 'duration_years' => '3', 'generation' => 'generation 1'],
        ];

        foreach ($degrees as $d) {
            Degree::create($d);
        }

        $degreeCS   = Degree::where('majors', 'computer science')->where('study_time', 'morning')->first();
        $degreeCSAf = Degree::where('majors', 'computer science')->where('study_time', 'afternoon')->first();
        $degreeIT   = Degree::where('majors', 'information technology')->where('study_time', 'morning')->first();
        $degreeITAf = Degree::where('majors', 'information technology')->where('study_time', 'afternoon')->first();
        $degreeAcc  = Degree::where('majors', 'accounting')->where('study_time', 'morning')->first();
        $degreeBA   = Degree::where('majors', 'business administration')->where('study_time', 'morning')->first();
        $degreeEN   = Degree::where('majors', 'english')->where('study_time', 'morning')->first();
        $degreeNet  = Degree::where('majors', 'networking')->where('study_time', 'morning')->first();

        // ── 2. Students ───────────────────────────────────────────────────────────
        $studentsData = [
            ['student_code' => 'STU_2501', 'full_name' => 'Dara Chan',       'gender' => 'male',   'date_of_birth' => '2003-05-15', 'phone' => '0885001001', 'enroll_year' => 2023, 'degree_id' => $degreeCS?->id,   'address' => 'Phnom Penh',  'status' => 'active'],
            ['student_code' => 'STU_2502', 'full_name' => 'Sreymom Ly',      'gender' => 'female', 'date_of_birth' => '2004-08-20', 'phone' => '0885001002', 'enroll_year' => 2024, 'degree_id' => $degreeIT?->id,   'address' => 'Siem Reap',   'status' => 'active'],
            ['student_code' => 'STU_2503', 'full_name' => 'Visal Pov',       'gender' => 'male',   'date_of_birth' => '2002-11-03', 'phone' => '0885001003', 'enroll_year' => 2022, 'degree_id' => $degreeAcc?->id,  'address' => 'Kampong Cham','status' => 'active'],
            ['student_code' => 'STU_2504', 'full_name' => 'Channary Sok',    'gender' => 'female', 'date_of_birth' => '2003-02-14', 'phone' => '0885001004', 'enroll_year' => 2023, 'degree_id' => $degreeBA?->id,   'address' => 'Battambang',  'status' => 'active'],
            ['student_code' => 'STU_2505', 'full_name' => 'Piseth Morn',     'gender' => 'male',   'date_of_birth' => '2004-07-09', 'phone' => '0885001005', 'enroll_year' => 2024, 'degree_id' => $degreeNet?->id,  'address' => 'Phnom Penh',  'status' => 'active'],
            ['student_code' => 'STU_2506', 'full_name' => 'Kunthea Heng',    'gender' => 'female', 'date_of_birth' => '2003-12-25', 'phone' => '0885001006', 'enroll_year' => 2023, 'degree_id' => $degreeEN?->id,   'address' => 'Kandal',      'status' => 'active'],
            ['student_code' => 'STU_2507', 'full_name' => 'Rathanak Kim',    'gender' => 'male',   'date_of_birth' => '2001-09-18', 'phone' => '0885001007', 'enroll_year' => 2021, 'degree_id' => $degreeCSAf?->id, 'address' => 'Phnom Penh',  'status' => 'graduated'],
            ['student_code' => 'STU_2508', 'full_name' => 'Leakena Chhun',   'gender' => 'female', 'date_of_birth' => '2004-04-30', 'phone' => '0885001008', 'enroll_year' => 2024, 'degree_id' => $degreeITAf?->id, 'address' => 'Takeo',       'status' => 'active'],
            ['student_code' => 'STU_2509', 'full_name' => 'Bunthy Rin',      'gender' => 'male',   'date_of_birth' => '2003-06-11', 'phone' => '0885001009', 'enroll_year' => 2023, 'degree_id' => $degreeAcc?->id,  'address' => 'Prey Veng',   'status' => 'active'],
            ['student_code' => 'STU_2510', 'full_name' => 'Sokhom Tep',      'gender' => 'female', 'date_of_birth' => '2005-01-22', 'phone' => '0885001010', 'enroll_year' => 2025, 'degree_id' => $degreeIT?->id,   'address' => 'Sihanoukville','status' => 'active'],
        ];

        foreach ($studentsData as $s) {
            Student::create($s);
        }

        // ── 3. Lecturers ──────────────────────────────────────────────────────────
        $lecturersData = [
            ['lecturer_code' => 'LEC_001', 'full_name' => 'Sophal Keo',    'gender' => 'male',   'date_of_birth' => '1985-03-10', 'phone' => '0885002001', 'enroll_year' => 2015, 'department' => 'Computer Science',       'address' => 'Phnom Penh',  'status' => 'active'],
            ['lecturer_code' => 'LEC_002', 'full_name' => 'Bopha Noun',    'gender' => 'female', 'date_of_birth' => '1990-07-22', 'phone' => '0885002002', 'enroll_year' => 2018, 'department' => 'English',                'address' => 'Battambang',  'status' => 'active'],
            ['lecturer_code' => 'LEC_003', 'full_name' => 'Sreynich Ouk',  'gender' => 'female', 'date_of_birth' => '1988-11-05', 'phone' => '0885002003', 'enroll_year' => 2016, 'department' => 'Business Administration','address' => 'Phnom Penh',  'status' => 'active'],
            ['lecturer_code' => 'LEC_004', 'full_name' => 'Makara Phin',   'gender' => 'male',   'date_of_birth' => '1982-04-17', 'phone' => '0885002004', 'enroll_year' => 2012, 'department' => 'Networking',             'address' => 'Siem Reap',   'status' => 'active'],
            ['lecturer_code' => 'LEC_005', 'full_name' => 'Dany Chhay',    'gender' => 'male',   'date_of_birth' => '1979-08-30', 'phone' => '0885002005', 'enroll_year' => 2010, 'department' => 'Accounting',             'address' => 'Kampong Cham','status' => 'retired'],
        ];

        foreach ($lecturersData as $l) {
            Lecturer::create($l);
        }

        // ── 4. Users ──────────────────────────────────────────────────────────────
        User::factory()->create([
            'name'  => 'Admin',
            'email' => 'admin@example.com',
            'role'  => 'admin',
        ]);

        User::factory()->create([
            'name'  => 'Librarian',
            'email' => 'librarian@example.com',
            'role'  => 'librarian',
        ]);

        // Members linked to students
        $studentUsers = [
            ['name' => 'Dara Chan',     'email' => 'student@example.com',    'student_code' => 'stu_2501'],
            ['name' => 'Sreymom Ly',    'email' => 'sreymom@example.com',    'student_code' => 'stu_2502'],
            ['name' => 'Visal Pov',     'email' => 'visal@example.com',      'student_code' => 'stu_2503'],
            ['name' => 'Channary Sok',  'email' => 'channary@example.com',   'student_code' => 'stu_2504'],
            ['name' => 'Piseth Morn',   'email' => 'piseth@example.com',     'student_code' => 'stu_2505'],
            ['name' => 'Kunthea Heng',  'email' => 'kunthea@example.com',    'student_code' => 'stu_2506'],
            ['name' => 'Rathanak Kim',  'email' => 'rathanak@example.com',   'student_code' => 'stu_2507'],
            ['name' => 'Leakena Chhun', 'email' => 'leakena@example.com',    'student_code' => 'stu_2508'],
        ];

        foreach ($studentUsers as $u) {
            User::factory()->create([
                'name'       => $u['name'],
                'email'      => $u['email'],
                'role'       => 'user',
                'student_id' => Student::where('student_code', $u['student_code'])->first()?->id,
            ]);
        }

        // Members linked to lecturers
        $lecturerUsers = [
            ['name' => 'Sophal Keo',   'email' => 'lecturer@example.com',   'lecturer_code' => 'lec_001'],
            ['name' => 'Bopha Noun',   'email' => 'bopha@example.com',      'lecturer_code' => 'lec_002'],
            ['name' => 'Sreynich Ouk', 'email' => 'sreynich@example.com',   'lecturer_code' => 'lec_003'],
        ];

        foreach ($lecturerUsers as $u) {
            User::factory()->create([
                'name'        => $u['name'],
                'email'       => $u['email'],
                'role'        => 'user',
                'lecturer_id' => Lecturer::where('lecturer_code', $u['lecturer_code'])->first()?->id,
            ]);
        }

        // Plain user (no profile link)
        User::factory()->create([
            'name'  => 'User',
            'email' => 'user@example.com',
            'role'  => 'user',
        ]);

        // ── 5. Books ──────────────────────────────────────────────────────────────
        $books = [
            ['title' => 'Introduction to Algorithms',         'subject' => 'Computer Science', 'category' => 'Textbook',  'author' => 'Thomas H. Cormen',      'pages' => 1312, 'language' => 'English',  'published_date' => '2009-07-31', 'quantity' => 5, 'location' => 'Shelf A1'],
            ['title' => 'Clean Code',                         'subject' => 'Software Engineering', 'category' => 'Textbook', 'author' => 'Robert C. Martin',   'pages' => 464,  'language' => 'English',  'published_date' => '2008-08-11', 'quantity' => 4, 'location' => 'Shelf A2'],
            ['title' => 'Computer Networks',                  'subject' => 'Networking',       'category' => 'Textbook',  'author' => 'Andrew S. Tanenbaum',   'pages' => 960,  'language' => 'English',  'published_date' => '2010-03-09', 'quantity' => 3, 'location' => 'Shelf B1'],
            ['title' => 'Principles of Accounting',           'subject' => 'Accounting',       'category' => 'Textbook',  'author' => 'Belverd E. Needles',    'pages' => 816,  'language' => 'English',  'published_date' => '2013-01-01', 'quantity' => 5, 'location' => 'Shelf C1'],
            ['title' => 'Business Communication Today',       'subject' => 'Business',         'category' => 'Textbook',  'author' => 'Courtland L. Bovee',    'pages' => 624,  'language' => 'English',  'published_date' => '2015-06-20', 'quantity' => 3, 'location' => 'Shelf D1'],
            ['title' => 'English Grammar in Use',             'subject' => 'English',          'category' => 'Reference', 'author' => 'Raymond Murphy',         'pages' => 380,  'language' => 'English',  'published_date' => '2012-04-26', 'quantity' => 6, 'location' => 'Shelf E1'],
            ['title' => 'Database System Concepts',           'subject' => 'Computer Science', 'category' => 'Textbook',  'author' => 'Abraham Silberschatz',  'pages' => 1376, 'language' => 'English',  'published_date' => '2011-02-03', 'quantity' => 4, 'location' => 'Shelf A3'],
            ['title' => 'Operating System Concepts',          'subject' => 'Computer Science', 'category' => 'Textbook',  'author' => 'Abraham Silberschatz',  'pages' => 976,  'language' => 'English',  'published_date' => '2012-12-17', 'quantity' => 3, 'location' => 'Shelf A4'],
            ['title' => 'Network Security Essentials',        'subject' => 'Networking',       'category' => 'Textbook',  'author' => 'William Stallings',     'pages' => 432,  'language' => 'English',  'published_date' => '2017-01-01', 'quantity' => 2, 'location' => 'Shelf B2'],
            ['title' => 'Financial Accounting',               'subject' => 'Accounting',       'category' => 'Textbook',  'author' => 'Walter T. Harrison Jr.','pages' => 720,  'language' => 'English',  'published_date' => '2018-03-01', 'quantity' => 4, 'location' => 'Shelf C2'],
            ['title' => 'Management Information Systems',     'subject' => 'Business',         'category' => 'Textbook',  'author' => 'Kenneth C. Laudon',     'pages' => 624,  'language' => 'English',  'published_date' => '2019-07-01', 'quantity' => 3, 'location' => 'Shelf D2'],
            ['title' => 'Oxford Advanced Learner\'s Dictionary', 'subject' => 'English',       'category' => 'Reference', 'author' => 'Oxford University Press','pages' => 1952,'language' => 'English',  'published_date' => '2015-09-01', 'quantity' => 5, 'location' => 'Shelf E2'],
            ['title' => 'PHP & MySQL: Server-side Web Dev',   'subject' => 'Web Development',  'category' => 'Textbook',  'author' => 'Jon Duckett',           'pages' => 630,  'language' => 'English',  'published_date' => '2022-06-01', 'quantity' => 3, 'location' => 'Shelf A5'],
            ['title' => 'Artificial Intelligence: A Modern Approach', 'subject' => 'Computer Science', 'category' => 'Textbook', 'author' => 'Stuart Russell', 'pages' => 1132, 'language' => 'English', 'published_date' => '2020-04-28', 'quantity' => 2, 'location' => 'Shelf A6'],
            ['title' => 'The Lean Startup',                   'subject' => 'Business',         'category' => 'General',   'author' => 'Eric Ries',             'pages' => 336,  'language' => 'English',  'published_date' => '2011-09-13', 'quantity' => 4, 'location' => 'Shelf D3'],
        ];

        foreach ($books as $b) {
            Book::create($b);
        }

        // ── 6. Borrow Books ───────────────────────────────────────────────────────
        // Fetch user IDs by email
        $userDara     = User::where('email', 'student@example.com')->first();
        $userSreymom  = User::where('email', 'sreymom@example.com')->first();
        $userVisal    = User::where('email', 'visal@example.com')->first();
        $userChannary = User::where('email', 'channary@example.com')->first();
        $userPiseth   = User::where('email', 'piseth@example.com')->first();
        $userKunthea  = User::where('email', 'kunthea@example.com')->first();
        $userRathanak = User::where('email', 'rathanak@example.com')->first();
        $userLeakena  = User::where('email', 'leakena@example.com')->first();
        $userSophal   = User::where('email', 'lecturer@example.com')->first();
        $userBopha    = User::where('email', 'bopha@example.com')->first();

        $book1  = Book::where('title', 'Introduction to Algorithms')->first();
        $book2  = Book::where('title', 'Clean Code')->first();
        $book3  = Book::where('title', 'Computer Networks')->first();
        $book4  = Book::where('title', 'Principles of Accounting')->first();
        $book5  = Book::where('title', 'Business Communication Today')->first();
        $book6  = Book::where('title', 'English Grammar in Use')->first();
        $book7  = Book::where('title', 'Database System Concepts')->first();
        $book8  = Book::where('title', 'Operating System Concepts')->first();
        $book9  = Book::where('title', 'Network Security Essentials')->first();
        $book10 = Book::where('title', 'Financial Accounting')->first();
        $book13 = Book::where('title', 'PHP & MySQL: Server-side Web Dev')->first();
        $book14 = Book::where('title', 'Artificial Intelligence: A Modern Approach')->first();
        $book15 = Book::where('title', 'The Lean Startup')->first();

        // Returned on time
        $borrow1 = BorrowBook::create(['user_id' => $userDara?->id,    'book_id' => $book1?->id,  'borrow_date' => '2026-01-05', 'due_date' => '2026-01-19']);
        $borrow2 = BorrowBook::create(['user_id' => $userSreymom?->id, 'book_id' => $book6?->id,  'borrow_date' => '2026-01-08', 'due_date' => '2026-01-22']);
        $borrow3 = BorrowBook::create(['user_id' => $userVisal?->id,   'book_id' => $book4?->id,  'borrow_date' => '2026-01-10', 'due_date' => '2026-01-24']);
        $borrow4 = BorrowBook::create(['user_id' => $userChannary?->id,'book_id' => $book5?->id,  'borrow_date' => '2026-01-12', 'due_date' => '2026-01-26']);
        $borrow5 = BorrowBook::create(['user_id' => $userSophal?->id,  'book_id' => $book2?->id,  'borrow_date' => '2026-01-15', 'due_date' => '2026-01-29']);

        // Overdue (due date passed, not yet returned)
        $borrow6 = BorrowBook::create(['user_id' => $userPiseth?->id,  'book_id' => $book3?->id,  'borrow_date' => '2026-01-20', 'due_date' => '2026-02-03']);
        $borrow7 = BorrowBook::create(['user_id' => $userKunthea?->id, 'book_id' => $book8?->id,  'borrow_date' => '2026-01-22', 'due_date' => '2026-02-05']);

        // Still borrowed (within due date)
        $borrow8  = BorrowBook::create(['user_id' => $userRathanak?->id,'book_id' => $book14?->id, 'borrow_date' => '2026-02-10', 'due_date' => '2026-02-24']);
        $borrow9  = BorrowBook::create(['user_id' => $userLeakena?->id, 'book_id' => $book13?->id, 'borrow_date' => '2026-02-12', 'due_date' => '2026-02-26']);
        $borrow10 = BorrowBook::create(['user_id' => $userBopha?->id,   'book_id' => $book7?->id,  'borrow_date' => '2026-02-14', 'due_date' => '2026-02-28']);
        $borrow11 = BorrowBook::create(['user_id' => $userDara?->id,    'book_id' => $book9?->id,  'borrow_date' => '2026-02-15', 'due_date' => '2026-03-01']);
        $borrow12 = BorrowBook::create(['user_id' => $userVisal?->id,   'book_id' => $book10?->id, 'borrow_date' => '2026-02-18', 'due_date' => '2026-03-04']);
        $borrow13 = BorrowBook::create(['user_id' => $userSophal?->id,  'book_id' => $book15?->id, 'borrow_date' => '2026-02-19', 'due_date' => '2026-03-05']);

        // ── 7. Return Books ───────────────────────────────────────────────────────
        // Returned on time (no fine)
        ReturnBook::create(['borrow_book_id' => $borrow1->id, 'return_date' => '2026-01-18', 'status' => 'returned', 'fine' => 0.00]);
        ReturnBook::create(['borrow_book_id' => $borrow2->id, 'return_date' => '2026-01-21', 'status' => 'returned', 'fine' => 0.00]);
        ReturnBook::create(['borrow_book_id' => $borrow3->id, 'return_date' => '2026-01-24', 'status' => 'returned', 'fine' => 0.00]);
        ReturnBook::create(['borrow_book_id' => $borrow4->id, 'return_date' => '2026-01-27', 'status' => 'returned', 'fine' => 0.00]);
        ReturnBook::create(['borrow_book_id' => $borrow5->id, 'return_date' => '2026-01-28', 'status' => 'returned', 'fine' => 0.00]);

        // Overdue with fine ($0.25 per day)
        ReturnBook::create(['borrow_book_id' => $borrow6->id, 'return_date' => null, 'status' => 'overdue', 'fine' => 4.50]);
        ReturnBook::create(['borrow_book_id' => $borrow7->id, 'return_date' => null, 'status' => 'overdue', 'fine' => 4.00]);

        // Still borrowed
        ReturnBook::create(['borrow_book_id' => $borrow8->id,  'return_date' => null, 'status' => 'borrowed', 'fine' => 0.00]);
        ReturnBook::create(['borrow_book_id' => $borrow9->id,  'return_date' => null, 'status' => 'borrowed', 'fine' => 0.00]);
        ReturnBook::create(['borrow_book_id' => $borrow10->id, 'return_date' => null, 'status' => 'borrowed', 'fine' => 0.00]);
        ReturnBook::create(['borrow_book_id' => $borrow11->id, 'return_date' => null, 'status' => 'borrowed', 'fine' => 0.00]);
        ReturnBook::create(['borrow_book_id' => $borrow12->id, 'return_date' => null, 'status' => 'borrowed', 'fine' => 0.00]);
        ReturnBook::create(['borrow_book_id' => $borrow13->id, 'return_date' => null, 'status' => 'borrowed', 'fine' => 0.00]);

        // ── 8. Attendances ────────────────────────────────────────────────────────
        $student1 = Student::where('student_code', 'stu_2501')->first();
        $student2 = Student::where('student_code', 'stu_2502')->first();
        $student3 = Student::where('student_code', 'stu_2503')->first();
        $student4 = Student::where('student_code', 'stu_2504')->first();
        $student5 = Student::where('student_code', 'stu_2505')->first();
        $student6 = Student::where('student_code', 'stu_2506')->first();

        $lec1 = Lecturer::where('lecturer_code', 'lec_001')->first();
        $lec2 = Lecturer::where('lecturer_code', 'lec_002')->first();
        $lec3 = Lecturer::where('lecturer_code', 'lec_003')->first();

        $attendances = [
            // Students - past weeks
            ['student_id' => $student1?->id, 'lecturer_id' => null, 'entry_time' => '08:05:00', 'exit_time' => '11:30:00', 'purpose' => 'Study',        'attendance_date' => '2026-02-03'],
            ['student_id' => $student2?->id, 'lecturer_id' => null, 'entry_time' => '08:10:00', 'exit_time' => '11:45:00', 'purpose' => 'Study',        'attendance_date' => '2026-02-03'],
            ['student_id' => $student3?->id, 'lecturer_id' => null, 'entry_time' => '08:00:00', 'exit_time' => '10:00:00', 'purpose' => 'Borrow Book',  'attendance_date' => '2026-02-04'],
            ['student_id' => $student4?->id, 'lecturer_id' => null, 'entry_time' => '13:00:00', 'exit_time' => '15:30:00', 'purpose' => 'Research',     'attendance_date' => '2026-02-04'],
            ['student_id' => $student5?->id, 'lecturer_id' => null, 'entry_time' => '09:00:00', 'exit_time' => '11:00:00', 'purpose' => 'Study',        'attendance_date' => '2026-02-05'],
            ['student_id' => $student6?->id, 'lecturer_id' => null, 'entry_time' => '13:15:00', 'exit_time' => '16:00:00', 'purpose' => 'Study',        'attendance_date' => '2026-02-05'],
            ['student_id' => $student1?->id, 'lecturer_id' => null, 'entry_time' => '08:00:00', 'exit_time' => '12:00:00', 'purpose' => 'Study',        'attendance_date' => '2026-02-10'],
            ['student_id' => $student2?->id, 'lecturer_id' => null, 'entry_time' => '08:30:00', 'exit_time' => '11:00:00', 'purpose' => 'Borrow Book',  'attendance_date' => '2026-02-10'],
            ['student_id' => $student3?->id, 'lecturer_id' => null, 'entry_time' => '14:00:00', 'exit_time' => '16:30:00', 'purpose' => 'Study',        'attendance_date' => '2026-02-11'],
            ['student_id' => $student4?->id, 'lecturer_id' => null, 'entry_time' => '08:00:00', 'exit_time' => '10:30:00', 'purpose' => 'Return Book',  'attendance_date' => '2026-02-12'],
            ['student_id' => $student5?->id, 'lecturer_id' => null, 'entry_time' => '13:00:00', 'exit_time' => null,        'purpose' => 'Study',       'attendance_date' => '2026-02-17'],
            ['student_id' => $student6?->id, 'lecturer_id' => null, 'entry_time' => '08:45:00', 'exit_time' => null,        'purpose' => 'Research',    'attendance_date' => '2026-02-17'],
            ['student_id' => $student1?->id, 'lecturer_id' => null, 'entry_time' => '09:00:00', 'exit_time' => null,        'purpose' => 'Study',       'attendance_date' => '2026-02-18'],
            ['student_id' => $student2?->id, 'lecturer_id' => null, 'entry_time' => '13:30:00', 'exit_time' => null,        'purpose' => 'Borrow Book', 'attendance_date' => '2026-02-19'],

            // Lecturers
            ['student_id' => null, 'lecturer_id' => $lec1?->id, 'entry_time' => '07:50:00', 'exit_time' => '12:00:00', 'purpose' => 'Teaching Preparation', 'attendance_date' => '2026-02-03'],
            ['student_id' => null, 'lecturer_id' => $lec2?->id, 'entry_time' => '08:00:00', 'exit_time' => '11:00:00', 'purpose' => 'Research',             'attendance_date' => '2026-02-04'],
            ['student_id' => null, 'lecturer_id' => $lec3?->id, 'entry_time' => '13:00:00', 'exit_time' => '16:00:00', 'purpose' => 'Borrow Book',          'attendance_date' => '2026-02-05'],
            ['student_id' => null, 'lecturer_id' => $lec1?->id, 'entry_time' => '08:00:00', 'exit_time' => '11:30:00', 'purpose' => 'Study',                'attendance_date' => '2026-02-10'],
            ['student_id' => null, 'lecturer_id' => $lec2?->id, 'entry_time' => '09:00:00', 'exit_time' => null,        'purpose' => 'Research',            'attendance_date' => '2026-02-17'],
            ['student_id' => null, 'lecturer_id' => $lec3?->id, 'entry_time' => '13:15:00', 'exit_time' => null,        'purpose' => 'Teaching Preparation','attendance_date' => '2026-02-19'],
        ];

        foreach ($attendances as $a) {
            Attendance::create($a);
        }
    }
}
