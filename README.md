# Club Management

A PHP web app for running a club: members, events, announcements and internal messages, with separate admin and member roles.

## Features

- **Admin:** manage members, create/edit/delete events and announcements, read member messages.
- **Member:** browse events and register or cancel, read announcements, message the admins, edit own profile and picture.
- Role-based access: admin-only pages and actions are enforced on the server (`auth.php`).

## Tech stack

- PHP 8.2 (no framework), OOP classes in `classes/`, PDO with prepared statements
- MySQL (tested on Aiven with SSL)
- HTML, Bootstrap, vanilla JS
- Docker (`php:8.2-apache`)

## Structure

```
classes/   User, Admin, Member, Event, Announcement, Message, Registration
actions/   POST handlers (one script per operation)
public/    pages (login, dashboard, members, events, messages, profile ...)
auth.php   session checks (require_login / require_admin / require_post) and safe image upload
connexion.php  PDO connection built from environment variables
```

## Security notes

- Passwords are stored with `password_hash` and checked with `password_verify`. Accounts created before this change still hold plain text; they are re-hashed automatically the first time the user logs in.
- All queries use prepared statements.
- Every action script requires a signed-in user, admin actions require the admin role, and members can only touch their own registrations, messages and profile. A user cannot change their own role.
- Profile pictures are checked by MIME type and size, and stored with an extension chosen by the server, not the client file name.
- Not implemented yet: CSRF tokens and output escaping on every page.

## Setup

1. Create a MySQL database named `club_management` with the tables `users`, `events`, `announcements`, `messages` and `registrations` (see the column names used in `classes/`).
2. The `users.password` column must hold a bcrypt hash, so make sure it is long enough:
   ```sql
   ALTER TABLE users MODIFY password VARCHAR(255) NOT NULL;
   ```
3. Copy `.env.example` to `.env` and fill in your database values, then export them as environment variables (or set them on your host).
4. Run with PHP's built-in server or Docker:
   ```bash
   docker build -t club-management .
   docker run -p 8080:80 --env-file .env club-management
   ```
5. Open `http://localhost:8080/public/login.php`.
