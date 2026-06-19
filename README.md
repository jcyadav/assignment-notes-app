<img width="959" height="512" alt="Screenshot 2026-06-19 130037" src="https://github.com/user-attachments/assets/fae19722-fb65-40c1-8d9b-aec472394ddd" />
<img width="959" height="474" alt="Screenshot 2026-06-19 130118" src="https://github.com/user-attachments/assets/a73f35d9-b39f-4486-8ec2-ecb333d90f94" />
<img width="959" height="478" alt="Screenshot 2026-06-19 130145" src="https://github.com/user-attachments/assets/72f935a2-b4b6-461f-87be-19ad42b32e90" />
<img width="959" height="473" alt="Screenshot 2026-06-19 130225" src="https://github.com/user-attachments/assets/1e20e899-0127-4426-bc1f-136f8ea82cb8" />

# AI Notes Dashboard (Laravel Backend)

## Project Overview

AI Notes Dashboard is a Laravel-based Notes Management System that provides CRUD operations, pagination, semantic search, and AI-powered note summarization through REST APIs.

## Features

- Create Note
- Update Note
- Delete Note
- Get Single Note
- Get All Notes with Pagination
- AI Semantic Search
- AI-based Note Summary
- RESTful JSON APIs

## Tech Stack

- Laravel
- PHP
- MySQL
- REST API
- Vite
- AI Integration

## API Endpoints

### Create Note

POST /api/notes

### Get All Notes

GET /api/notes?page=1&limit=10

### Get Single Note

GET /api/notes/{id}

### Update Note

PUT /api/notes/{id}

### Delete Note

DELETE /api/notes/{id}

### Semantic Search

GET /api/notes/search?q=keyword

### AI Summary

POST /api/notes/{id}/summary

## Database Structure

Table: notes

Fields:

- id
- title
- content
- created_at
- updated_at

## Screenshots / Demo

Include:

- Create Note API Response
- Notes List with Pagination
- Semantic Search Result
- AI Summary Result
- Database Records Screenshot
- Postman Collection Screenshot

# AI Notes Dashboard

## Project Overview

...

## Features

...

## Tech Stack

...

## Setup Instructions

1. Clone Repository
2. composer install
3. npm install
4. cp .env.example .env
5. Configure Database
6. php artisan key:generate
7. php artisan migrate
8. php artisan serve
9. npm run dev

## Author

Jaichand Yadav

Software Developer
