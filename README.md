📋 Task Manager – A Trello-Like Task Management System
Task Manager is a powerful, responsive, and user-friendly Laravel-based task management platform inspired by Trello. Designed and developed by Nabaraj Acharya, this app helps teams efficiently create, assign, organize, and track tasks through a drag-and-drop interface.

Built using Laravel, Blade, Tailwind CSS, jQuery, and SortableJS, this system is ideal for personal productivity or collaborative team environments.

🚀 Features
✅ User Authentication
Secure registration and login for user-specific task management.

✅ Task CRUD & Ownership
Create, update, and delete tasks (only accessible by the task creator).

✅ Task Assignment
Assign tasks to registered users and optionally upload task-related images.

✅ Drag & Drop Interface
Move tasks smoothly between To Do, In Progress, and Done using SortableJS.

✅ Advanced Filtering
Filter tasks by assignee, status, or creation date.

✅ Responsive UI
Modern Tailwind CSS layout ensures usability across all devices.

✅ Role Differentiation
Admin dashboard includes task assignment and monitoring of all users.

🛠️ Tech Stack
PHP 8.1+
Laravel 10+
Blade Templating Engine
jQuery + SortableJS
Tailwind CSS 3.x
MySQL
Node.js + NPM

📦 Installation & Setup
1. Clone the Repository
bash
Copy
Edit
git clone https://github.com/nabaraj999/Task-2.0.git
cd Task-2.0
2. Install PHP & JS Dependencies
bash
Copy
Edit
composer install
npm install
3. Configure Environment
Create and edit .env file:

env
Copy
Edit
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
Generate keys and cache config:

bash
Copy
Edit
php artisan key:generate
php artisan config:cache
4. Run Migrations & Seeders
bash
Copy
Edit
php artisan migrate
php artisan db:seed --class=StatusSeeder
5. Link Storage
bash
Copy
Edit
php artisan storage:link
6. Compile Frontend Assets
bash
Copy
Edit
npm run dev
7. Launch Development Server
bash
Copy
Edit
php artisan serve
Visit: http://localhost:8000

👨‍💻 Usage Guide
🔑 Register/Login: Go to /register or /login to access your dashboard.

➕ Add Task: Click “Add Task” to input details including optional image and assignee.

✏️ Edit/Delete: Manage your created tasks through contextual buttons.

🧲 Drag Tasks: Organize your workflow by dragging tasks between columns.

🔍 Filter: Use filter form to narrow tasks by user, status, or date.

🛠️ Admin Functionality
Admins have the ability to:

View all tasks from all users

Assign tasks to users

Filter based on progress and assigned users

Monitor project status

🐞 Troubleshooting
Problem	Solution
Undefined variable $slot	Ensure all views use @extends('layouts.app') and wrap content in @section('content').
Styles not applying	Re-run npm run dev or npm run build.
DB Connection Issues	Verify .env file DB settings, try php artisan migrate:fresh.
Image upload not working	Run php artisan storage:link and ensure storage/app/public is writable.
Tasks not draggable	Confirm SortableJS is loaded correctly in your scripts.

🤝 Contributing
We welcome contributors to enhance the project:

bash
Copy
Edit
# Step 1: Fork the repo
# Step 2: Create a branch
git checkout -b feature/my-feature

# Step 3: Commit changes
git commit -m "Add my feature"

# Step 4: Push to branch
git push origin feature/my-feature

# Step 5: Submit Pull Request
📜 License
This project is licensed under the MIT License. See LICENSE.md for full details.

📧 Contact
Developed by Nabaraj Acharya
🌐 Website: nabrajacharya.com.np
📧 Email: support@nabrajacharya.com.np
