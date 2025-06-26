
# 📋 Task Manager – A Trello-Like Task Management System

**Task Manager** is a responsive, modern, and easy-to-use task management application built with Laravel, Blade, Tailwind CSS, jQuery, and SortableJS. It allows teams and individuals to efficiently create, manage, and track tasks using a drag-and-drop interface.

> Developed by [Nabaraj Acharya](https://nabrajacharya.com.np)

---

## 🚀 Features

- 🔐 **User Authentication** – Secure login and registration
- ✅ **Task CRUD & Ownership** – Create, edit, and delete own tasks
- 👥 **Task Assignment** – Assign tasks to users, upload images
- 🧲 **Drag & Drop** – Move tasks between "To Do", "In Progress", and "Done"
- 🔍 **Advanced Filtering** – Filter tasks by user, status, or date
- 📱 **Responsive UI** – Built with Tailwind CSS for all devices
- 🧑‍💼 **Admin Role** – Full task visibility and assignment capability

---

## 🛠️ Tech Stack

| Category        | Tech                      |
|-----------------|---------------------------|
| Backend         | PHP 8.1+, Laravel 10+     |
| Frontend        | Blade, Tailwind CSS 3.x   |
| Interactivity   | jQuery, SortableJS        |
| Database        | MySQL                     |
| Build Tools     | Node.js + NPM             |

---

## 📦 Installation

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/nabaraj999/Task-2.0.git
cd Task-2.0
```

### 2️⃣ Install Dependencies

```bash
composer install
npm install
```

### 3️⃣ Configure Environment

Copy `.env.example` to `.env` and set database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

Generate app key and cache config:

```bash
php artisan key:generate
php artisan config:cache
```

### 4️⃣ Run Migrations & Seeders

```bash
php artisan migrate
php artisan db:seed --class=StatusSeeder
```

### 5️⃣ Link Storage

```bash
php artisan storage:link
```

### 6️⃣ Compile Assets

```bash
npm run dev
```

### 7️⃣ Start the Server

```bash
php artisan serve
```

Visit: [http://localhost:8000](http://localhost:8000)

---

## 👨‍💻 Usage

### 🔑 Register/Login

Visit `/register` or `/login` to get started.

### ➕ Add Tasks

Click “Add Task” and fill in task details. Assign to user and upload image if needed.

### ✏️ Edit/Delete

You can edit or delete only your own tasks.

### 🧲 Drag & Drop

Use drag-and-drop to move tasks across stages.

### 🔍 Filter Tasks

Filter by user, status, or creation date using the search form.

---

## 🛠️ Admin Features

- 🔎 View tasks from all users
- 📌 Assign tasks to any user
- 🗃️ Filter tasks by status, user, or date
- 📈 Monitor project progress

---

## 🐞 Troubleshooting

| Problem                        | Solution                                                                 |
|-------------------------------|--------------------------------------------------------------------------|
| `Undefined variable $slot`    | Use `@extends('layouts.app')` and wrap views with `@section('content')` |
| Styles not applying           | Run `npm run dev` or `npm run build`                                    |
| DB connection error           | Check `.env` database config and rerun `php artisan migrate`             |
| Image upload not working      | Run `php artisan storage:link` and check storage permissions             |
| Tasks not draggable           | Ensure SortableJS is correctly loaded in Blade files                     |

---

## 🤝 Contributing

We welcome contributions! To contribute:

```bash
# Fork the repo and create a feature branch
git checkout -b feature/your-feature

# Make your changes and commit
git commit -m "Added my feature"

# Push to GitHub and submit a Pull Request
git push origin feature/your-feature
```

---

## 📜 License

This project is licensed under the MIT License. See [`LICENSE.md`](LICENSE.md) for more details.

---

## 📧 Contact

**Nabaraj Acharya**  
🌐 [nabrajacharya.com.np](https://nabrajacharya.com.np)  
📧 [support@nabrajacharya.com.np](mailto:support@nabrajacharya.com.np)
