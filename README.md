# Laravel Assessment - Notes API & Book Tracker

This Laravel project implements two RESTful APIs with user authentication:

1. **Notes API** - Personal note management system
2. **Book Tracker** - Personal book reading tracker

## Features

### Authentication (Laravel Sanctum)
- User registration
- User login/logout
- Token-based authentication
- Protected API routes

### Notes API
- Create, read, update, delete personal notes
- User-specific note access
- Pagination support
- Form request validation

### Book Tracker API
- Manage personal book collection
- Track reading status (reading/completed)
- Filter books by status
- Human-readable status accessor
- User-specific book access

## Setup Instructions

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL or another supported database

### Installation

1. **Clone the repository**
   \`\`\`bash
   git clone <repository-url>
   cd laravel-assessment
   \`\`\`

2. **Install dependencies**
   \`\`\`bash
   composer install
   \`\`\`

3. **Environment setup**
   \`\`\`bash
   cp .env.example .env
   php artisan key:generate
   \`\`\`

4. **Configure database**
   Edit `.env` file with your database credentials:
   \`\`\`env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_assessment
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   \`\`\`

5. **Run migrations**
   \`\`\`bash
   php artisan migrate
   \`\`\`

6. **Start the development server**
   \`\`\`bash
   php artisan serve
   \`\`\`

The API will be available at `http://localhost:8000`

## API Endpoints

### Authentication

#### Register
\`\`\`http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
\`\`\`

#### Login
\`\`\`http
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
\`\`\`

#### Logout
\`\`\`http
POST /api/logout
Authorization: Bearer {token}
\`\`\`

### Notes API

#### Get all notes (paginated)
\`\`\`http
GET /api/notes
Authorization: Bearer {token}
\`\`\`

#### Create a note
\`\`\`http
POST /api/notes
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "My Note Title",
    "content": "This is the note content"
}
\`\`\`

#### Get specific note
\`\`\`http
GET /api/notes/{id}
Authorization: Bearer {token}
\`\`\`

#### Update a note
\`\`\`http
PUT /api/notes/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Updated Title",
    "content": "Updated content"
}
\`\`\`

#### Delete a note
\`\`\`http
DELETE /api/notes/{id}
Authorization: Bearer {token}
\`\`\`

### Books API

#### Get all books (paginated, with optional status filter)
\`\`\`http
GET /api/books
GET /api/books?status=reading
GET /api/books?status=completed
Authorization: Bearer {token}
\`\`\`

#### Create a book
\`\`\`http
POST /api/books
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "The Great Gatsby",
    "author": "F. Scott Fitzgerald",
    "status": "reading"
}
\`\`\`

#### Get specific book
\`\`\`http
GET /api/books/{id}
Authorization: Bearer {token}
\`\`\`

#### Update a book
\`\`\`http
PUT /api/books/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Updated Title",
    "author": "Updated Author",
    "status": "completed"
}
\`\`\`

#### Delete a book
\`\`\`http
DELETE /api/books/{id}
Authorization: Bearer {token}
\`\`\`

## cURL Examples

### Register a new user
\`\`\`bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
\`\`\`

### Login
\`\`\`bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
\`\`\`

### Create a note (replace {token} with actual token)
\`\`\`bash
curl -X POST http://localhost:8000/api/notes \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "My First Note",
    "content": "This is my first note content"
  }'
\`\`\`

### Create a book (replace {token} with actual token)
\`\`\`bash
curl -X POST http://localhost:8000/api/books \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "1984",
    "author": "George Orwell",
    "status": "reading"
  }'
\`\`\`

## Security Features

- **Authentication**: Laravel Sanctum token-based authentication
- **Authorization**: Policy-based authorization ensuring users can only access their own data
- **Validation**: Form Request validation for all input data
- **Database Security**: Foreign key constraints and cascade deletes

## Bonus Features Implemented

- ✅ Form Request validation for all endpoints
- ✅ Pagination for listing endpoints
- ✅ Status filtering for books (`?status=reading` or `?status=completed`)
- ✅ Eloquent Accessor for human-readable book status
- ✅ Policy-based authorization
- ✅ Comprehensive API documentation

## Testing

You can test the API using:
- Postman (import the cURL examples)
- Any HTTP client
- Frontend applications

## Project Structure

\`\`\`
app/
├── Http/
│   ├── Controllers/Api/
│   │   ├── AuthController.php
│   │   ├── NoteController.php
│   │   └── BookController.php
│   └── Requests/
│       ├── LoginRequest.php
│       ├── RegisterRequest.php
│       ├── StoreNoteRequest.php
│       ├── UpdateNoteRequest.php
│       ├── StoreBookRequest.php
│       └── UpdateBookRequest.php
├── Models/
│   ├── User.php
│   ├── Note.php
│   └── Book.php
└── Policies/
    ├── NotePolicy.php
    └── BookPolicy.php
