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

## Submission Contents

- GitHub Repository Link
- Setup Instructions
- README Documentation
- Screenshots / Video Demo

## Author

Jaichand Yadav

Software Developer