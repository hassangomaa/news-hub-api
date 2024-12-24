# News Hub API

## Overview
The News Hub API is a robust, feature-rich platform designed and developed by Eng. Hassan Gomaa to aggregate and process news articles from multiple sources, including:

- **The Guardian API**
- **New York Times API**
- **NewsAPI**

The system provides categorized, filtered, and sanitized news content while implementing industry-standard security and optimization practices.

---

## Key Features

### 1. Command-Line Integration for APIs
Easily fetch and seed articles into the database using the following commands:

#### **The Guardian API**
```bash
php artisan guardianapi:fetch --section=technology --from-date=2024-01-01
```

#### **New York Times API**
```bash
php artisan nytimes:fetch --query=technology --begin-date=20240101 --end-date=20241231 --page=0
```

#### **NewsAPI**
```bash
php artisan newsapi:test --country=us --category=business --source=newsapi
```

---

### 2. Configurable API Keys
The API requires the following keys, which must be defined in the `.env` file:

```env
NEWSAPI_API_KEY=<YOUR_NEWSAPI_KEY>
GUARDIAN_API_KEY=<YOUR_GUARDIAN_KEY>
NYT_API_KEY=<YOUR_NYT_KEY>
```

---

### 3. RESTful API Endpoints
This system provides a set of endpoints to interact with articles, authors, sources, and categories:

#### **Articles**
- **GET /api/articles**: List all articles with filters and pagination.

#### **Authors**
- **GET /api/authors**: List all authors with optional filters and pagination.

#### **Sources**
- **GET /api/sources**: List all sources with optional filters and pagination.

#### **Categories**
- **GET /api/categories**: List all categories with optional filters and pagination.

---

### 4. Middleware for Security
The platform incorporates advanced middleware to:

- **Prevent XSS and injection attacks**: Using a custom XSS sanitizer.
- **Rate Limiting**: Throttle API requests to 30 requests per minute to ensure stability.

---

### 5. Database Schema
The project utilizes a relational database with the following key tables:

- `articles`: Stores article data, including title, URL, publication date, etc.
- `authors`: Stores author information.
- `sources`: Stores information about news sources.
- `categories`: Stores categories to which articles belong.

Refer to the attached SQL schema for details.

---

## Project Structure
The project is organized into a clean and modular structure for maintainability:

```plaintext
app/
├── Console/Commands   # Artisan commands for APIs
├── Exceptions         # Custom exception handling
├── Helpers            # Helper classes for seeding and utilities
├── Http               # Controllers, middleware, requests, resources
├── Models             # Eloquent models
├── Providers          # Service providers
├── Repositories       # Data repositories
├── Services           # Service classes for API integrations
├── Traits             # Shared traits
```

---

## How to Run

### 1. Clone the Repository
```bash
git clone https://github.com/hassangomaa/news-hub-api.git
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Set Environment Variables
Create a `.env` file and add the required environment variables (API keys and database configuration).

### 4. Run Migrations
```bash
php artisan migrate
```

### 5. Seed the Database
You can seed articles by running the respective API commands.

### 6. Start the Server
```bash
php artisan serve
```

---

## API Documentation
Detailed API documentation is available and should be updated regularly using Swagger.

---

## Developer Notes
- **Rate Limiting**: Configured at `throttle:30,1`.
- **Security**: Includes middleware for XSS sanitization and request validation.
- **Logging**: All API and command errors are logged for debugging.

---

## Acknowledgments
This project is fully developed and maintained by Eng. Hassan Gomaa. It integrates cutting-edge technologies and practices to deliver a seamless news aggregation experience.

