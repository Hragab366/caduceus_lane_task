# Book and Author Management System

This Laravel application manages books and authors. Each author can add, edit, and delete their own books, while an admin can manage authors and view all books. The application uses a MySQL database.

## Features

- **Admin Management**
  - Seed admin credentials: `admin@email.com`, password: `1234@Abcd`.
  - Admin can add, edit, and delete authors.
  - Admin can filter and view all books with author details title and description.

- **Author Management**
  - Admin can create authors with validation rules.
  - Authors have unique credentials and can manage their own books.

- **Login System**
  - Admins and authors can log in using their credentials.
  - Upon successful login, user information and authentication tokens are returned.

- **Book CRUD Operations**
  - Authors can add, update, and delete their own books.
  - Book data includes title, description, published date, bio, and cover image.
  - Authors can only manage their own books.

- **Book Import/Export**
  - Authors can export their own books as an Excel file.
  - Authors can import books via an Excel or CSV file with validation rules applied.

- **Book Filtering**
  - Admins can retrieve and filter all books in the system by author ID.
  - Each book includes the author’s details in the response.

- **Additional Features**
  - Search functionality: Users can search for books by title or description.
  - Enhanced password validation for authors (upper case, lower case, and special characters).

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/your-username/laravel-book-author-management.git
    cd laravel-book-author-management
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Create a copy of the environment file:
    ```bash
    cp .env.example .env
    ```

4. Set up the database:
    - Update your `.env` file with the database credentials.

5. Run migrations and seed the admin user:
    ```bash
    php artisan migrate --seed
    
