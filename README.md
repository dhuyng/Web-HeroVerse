# Web-HeroVerse

## Setup eviroments

### Configure `.env` for Database Connection

Make sure to set up your database connection by creating or updating the `.env` file in the root of your project. Add the following environment variables:
```env
DB_HOST=localhost  
DB_USER=username  
DB_PASS=password  
DB_NAME=heroverse
```
- Replace `localhost` with your database host if different.
- Set `DB_USER` and `DB_PASS` to your database credentials.
- Set `DB_NAME` to the name of your database (e.g., `heroverse`).

### Configure `RewriteBase`

If your application is in a subdirectory, update the `.htaccess` file to set the correct `RewriteBase`. For example:

```apache
RewriteBase /your-subdirectory/
```
Replace ```/your-subdirectory/``` with the actual path where your app is hosted (e.g., /BTL/HeroVerse/).

### Enabling GD Library for QR Code Generation in XAMPP

1. **Locate `php.ini`**:
   - Go to `C:\xampp\php` and open `php.ini` in a text editor.

2. **Enable GD extension**:
   - Find `;extension=gd` and remove the semicolon to make it `extension=gd`.

3. **Save the file** and **restart Apache**:
   - Save the `php.ini` file and restart Apache via the XAMPP Control Panel.

4. **Verify GD is enabled**:
   - Create a PHP file with `phpinfo();` and check for `GD` in the output.

This will enable QR code generation in your project.

### Git Line Endings Setup

To ensure consistent line endings across different systems, follow these steps:

1. **Windows**:  
   Run the following command:
   ```bash
   git config --global core.autocrlf true
   ```
2. **macOS/Linux**:  
   Run the following command:
   ```bash
   git config --global core.autocrlf input
   ```
3. **Run `renormalize`**:  
   After setting the above, execute:
   ```bash
   git add --renormalize .
   ```

## Project structure

```
/HeroVerse
│
├── /public                  # Publicly accessible files
│   ├── /css                 # Stylesheets
│   ├── /js                  # JavaScript files
│   ├── /img                 # Images and icons
│   
│
├── /app
│   ├── /controllers         # Handles logic for requests
│       └── HomeController.php
│   ├── /models              # Database interaction logic
│   ├── /views               # HTML templates or views
│       ├── admin            # Admin-specific pages
│       ├── heroes           # Hero-related pages
│       ├── layouts          # Shared layout files
│       ├── pages            # Static or general pages
│       ├── user             # User-specific pages
│
├── /config                  # Configuration files
│   ├── database.php         # Database connection logic
│   ├── env.php              # Environment variable loader
├── index.php                # Main entry point (public-facing)
├── .env                     # Stores environment variables
└── .htaccess                # Optional for URL rewriting
```
## Database Schema

This document provides an overview of the database schema for the application. It includes the structure for users, heroes, comments, news, and pages tables.

### 1. `users` Table

| Column       | Type            | Constraints                | Description                       |
|--------------|-----------------|----------------------------|-----------------------------------|
| `id`         | INT             | PRIMARY KEY, AUTO_INCREMENT | Unique ID for each user.          |
| `username`   | VARCHAR(50)     | UNIQUE, NOT NULL            | User’s username.                  |
| `email`      | VARCHAR(100)    | UNIQUE, NOT NULL            | User’s email address.             |
| `password`   | VARCHAR(255)    | NOT NULL                    | Hashed password.                  |
| `role`       | ENUM('admin', 'member') | DEFAULT 'member'     | User’s role (Admin/Member).       |
| `avatar`     | VARCHAR(255)    | NULL                        | Path to profile image.            |
| `created_at` | TIMESTAMP       | DEFAULT CURRENT_TIMESTAMP   | Account creation date.            |
| `updated_at` | TIMESTAMP       | ON UPDATE CURRENT_TIMESTAMP | Last update date.                 |

### 2. `heroes` Table

| Column       | Type            | Constraints                | Description                       |
|--------------|-----------------|----------------------------|-----------------------------------|
| `id`         | INT             | PRIMARY KEY, AUTO_INCREMENT | Unique ID for each hero.          |
| `name`       | VARCHAR(100)    | NOT NULL                    | Hero name.                        |
| `description`| TEXT            | NOT NULL                    | Detailed hero description.        |
| `image`      | VARCHAR(255)    | NULL                        | Path to hero image.               |
| `type`       | VARCHAR(50)     | NOT NULL                    | Hero type/class (e.g., Warrior).  |
| `created_at` | TIMESTAMP       | DEFAULT CURRENT_TIMESTAMP   | Entry creation date.              |
| `updated_at` | TIMESTAMP       | ON UPDATE CURRENT_TIMESTAMP | Last update date.                 |

### 3. `comments` Table

| Column       | Type            | Constraints                | Description                       |
|--------------|-----------------|----------------------------|-----------------------------------|
| `id`         | INT             | PRIMARY KEY, AUTO_INCREMENT | Unique ID for each comment.       |
| `user_id`    | INT             | FOREIGN KEY (`users.id`)    | User who posted the comment.      |
| `content`    | TEXT            | NOT NULL                    | Comment text.                     |
| `type`       | ENUM('hero', 'news') | NOT NULL                | Type of comment (Hero/News).      |
| `type_id`    | INT             | NOT NULL                    | ID of the hero/news being commented. |
| `created_at` | TIMESTAMP       | DEFAULT CURRENT_TIMESTAMP   | Comment creation date.            |

### 4. `news` Table

| Column       | Type            | Constraints                | Description                       |
|--------------|-----------------|----------------------------|-----------------------------------|
| `id`         | INT             | PRIMARY KEY, AUTO_INCREMENT | Unique ID for each news item.     |
| `title`      | VARCHAR(200)    | NOT NULL                    | News title.                       |
| `content`    | TEXT            | NOT NULL                    | News content.                     |
| `image`      | VARCHAR(255)    | NULL                        | Path to news image.               |
| `keywords`   | VARCHAR(255)    | NULL                        | SEO keywords.                     |
| `created_at` | TIMESTAMP       | DEFAULT CURRENT_TIMESTAMP   | News creation date.               |
| `updated_at` | TIMESTAMP       | ON UPDATE CURRENT_TIMESTAMP | Last update date.                 |

### 5. `pages` Table

| Column       | Type            | Constraints                | Description                       |
|--------------|-----------------|----------------------------|-----------------------------------|
| `id`         | INT             | PRIMARY KEY, AUTO_INCREMENT | Unique ID for each page.          |
| `title`      | VARCHAR(100)    | NOT NULL                    | Page title.                       |
| `content`    | TEXT            | NOT NULL                    | Page content (HTML or Markdown).  |
| `created_at` | TIMESTAMP       | DEFAULT CURRENT_TIMESTAMP   | Page creation date.               |
| `updated_at` | TIMESTAMP       | ON UPDATE CURRENT_TIMESTAMP | Last update date.                 |
