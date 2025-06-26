Task Manager
A Trello-like task management application built with Laravel, Blade, jQuery, SortableJS, and Tailwind CSS. This project allows users to create, edit, delete, and assign tasks, move them between statuses using drag-and-drop, and filter tasks by user, status, or date. The interface is modern, responsive, and user-friendly, designed for efficient task management.
Features

User Authentication: Register and log in to manage tasks securely.
Task Management: Create, edit, and delete tasks (restricted to task creators).
Task Assignment: Assign tasks to users with optional image uploads.
Drag-and-Drop: Move tasks between statuses (To Do, In Progress, Done).
Task Filtering: Filter tasks by user, status, or creation date.
Responsive UI: Modern, user-friendly interface styled with Tailwind CSS.

Prerequisites

PHP 8.1 or higher
Composer
MySQL
Node.js and npm

Setup Instructions

Clone the Repository:
git clone https://github.com/nabraj999/task2.0
cd task2.0


Install Dependencies:
composer install
npm install


Configure Environment:

Copy .env.example to .env and update database credentials:DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=your_username
DB_PASSWORD=your_password




Run Migrations:
php artisan migrate


Seed Statuses:
php artisan db:seed --class=StatusSeeder


Link Storage:
php artisan storage:link


Compile Assets:
npm run dev


Start the Server:
php artisan serve


Access the application at http://localhost:8000.



Usage

Register: Visit /register to create an account.
Login: Visit /login to sign in.
Task Manager: After login, you’re redirected to /tasks where you can:
Add Tasks: Click "Add Task" to create a new task with a description, optional image, status, and assignee.
Edit/Delete Tasks: Edit or delete tasks you created using the respective buttons.
Drag-and-Drop: Move tasks between To Do, In Progress, and Done columns.
Filter Tasks: Use the filter form to view tasks by user, status, or date.



Contributing
Contributions are welcome! To contribute:

Fork the repository.
Create a new branch (git checkout -b feature/your-feature).
Make your changes and commit (git commit -m 'Add your feature').
Push to the branch (git push origin feature/your-feature).
Open a pull request.

License
This project is licensed under the MIT License - see the LICENSE.md file for details.
Contact
For questions or feedback, contact your-email@example.com.
Troubleshooting

Undefined variable $slot: Ensure views use @extends('layouts.app') with @section('content'). Clear caches with php artisan view:clear.
Styles not applying: Run npm run dev or npm run build to compile Tailwind CSS.
Database errors: Verify .env credentials and run php artisan migrate:fresh.
Image upload issues: Ensure storage is linked (php artisan storage:link) and the images directory is writable.
