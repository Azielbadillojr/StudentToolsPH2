# Student Tools PH 2.0 — PHP + MySQL starter

A responsive college-student toolkit with a separate HTML/PHP structure, CSS, JavaScript, student accounts, an admin dashboard, online/offline heartbeat, tool-use analytics, and activity logs. This is a local-development starter; it is not yet production-hardened or deployed.

## Requirements
- XAMPP with Apache, PHP 8+, and MySQL/MariaDB
- Browser

## Install on Windows/XAMPP
1. Extract this folder into `C:\xampp\htdocs\StudentToolsPH2`.
2. Open XAMPP Control Panel and start **Apache** and **MySQL**.
3. Open `http://localhost/phpmyadmin`.
4. Choose **Import**, select `database.sql`, and run it. This creates `student_tools_ph` and the required tables.
5. Check `config.php`. Default XAMPP settings are host `127.0.0.1`, user `root`, blank password. If your MySQL root has a password, update `DB_PASS`.
6. Open `http://localhost/StudentToolsPH2/`.
7. Register a normal student account to test the public website and tools.

## Create the first admin account (safe local setup)
1. Register your own account through the website.
2. Open phpMyAdmin → `student_tools_ph` → SQL.
3. Run the following query, replacing the email with the exact email you registered:

```sql
UPDATE users SET role='admin' WHERE email='your-email@example.com';
```

4. Log out and log in again. The Admin link should appear in the navigation.

Never publish a default admin password or allow public self-registration as admin. This project deliberately has no hard-coded admin password.

## What works
- Student registration and login with `password_hash` / `password_verify`
- Prepared SQL statements and CSRF tokens on account forms and admin account actions
- Admin overview: total students, online now (heartbeat within 120 seconds), new registrations today, disabled accounts, distinct users with tool usage in the last 7/30 days, most-used tools, searchable latest 100 accounts, enable/disable, and recent activity log
- Heartbeat updates every 45 seconds while logged in
- Grade contribution, GWA, target grade, Pomodoro, study tasks, class schedule, allowance/expense tracker, quick notes, flashcards, and exam countdown
- Browser-local tools save to localStorage on the device/browser. They do not sync across devices in this starter.

## Important limitations before public launch
- The online status is an estimate based on the last heartbeat. It can take up to about two minutes for a disconnected user to show offline.
- Tool analytics count tool actions that are sent to the server; unique active users in this dashboard means users with tracked tool usage, not all visits.
- This starter does not yet include email verification, password reset, rate limiting, CAPTCHA/anti-bot controls, formal privacy/retention settings, or full production security review. Add these before a public launch.
- Add a proper HTTPS-enabled PHP/MySQL host for deployment. GitHub Pages cannot run PHP. Do not upload database credentials or real user data to a public repository.
- LocalStorage-based notes, tasks, schedule, expenses, and flashcards stay in that browser only and can be lost when browser storage is cleared.
- The interface loads Google Fonts from a third-party host. Remove the `@import` if you prefer fully local assets.


## Visual theme
The interface uses the Blue & Purple palette: primary blue `#3B82F6`, premium purple `#8B5CF6`, light purple `#EDE9FE`, white `#FFFFFF`, light gray `#F8FAFC`, and dark navy `#1E1B4B`.
