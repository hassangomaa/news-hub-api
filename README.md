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


### SOLID, DRY, and KISS in News Hub API

This system follows best practices:

1. **SOLID**  
   - **Single Responsibility:** Each service handles a specific API; each command manages fetching and seeding.  
   - **Open/Closed:** Add new APIs by extending `AbstractAPIService` and `BaseCommand`.  
   - **Liskov Substitution:** All services work interchangeably under common contracts.

2. **DRY**  
   - Common API logic centralized in `AbstractAPIService`.  
   - Command logic streamlined with `BaseCommand`.  

3. **KISS**  
   - API handling abstracted for simplicity.  
   - Minimal logic in commands, standardized configurations.

### Example Structure

- **AbstractAPIService:** Centralized API handling (e.g., headers, responses).  
- **BaseCommand:** Shared command logic for fetch-and-seed flow.  
- **Extending Example:**  
   - Services like `NYTimesAPIService` map and fetch API data.  
   - Commands like `NYTimesAPI` handle parameters and seed data.

This architecture ensures simplicity, modularity, and scalability.


## Database ERD Documentation

The full Entity-Relationship Diagram (ERD) for the **NewsHubAPI** database is available at the link below. It provides a detailed visual representation of all database tables, their fields, and relationships.

**Diagram Name**: `DiagramNewsHubAPI`  
**Link**: [DiagramNewsHubAPI ERD](https://dbdocs.io/hassan.gomaa.dev/DiagramNewsHubAPI)



## **🛠 How to Run the Application using Docker**  

This section provides step-by-step instructions to set up and run the **News Hub API** using Docker and Docker Compose.  

---

### **1️⃣ Prerequisites**
Before you start, ensure you have the following installed on your system:  

- **Docker**: [Download Docker](https://www.docker.com/get-started)  
- **Docker Compose** (included with Docker Desktop)  

---

### **2️⃣ Clone the Repository**
Run the following command to clone the repository:  

```bash
git clone https://github.com/hassangomaa/news-hub-api.git
cd news-hub-api
```

---

### **3️⃣ Configure Environment Variables**
Create a `.env` file (if not already present) by copying the example configuration:  

```bash
cp .env.example .env
```

Then, update the `.env` file with your **database credentials** and **API keys**.

---

### **4️⃣ Build and Start the Docker Containers**
Run the following command to build and start the containers:  

```bash
docker-compose up --build -d
```

This will:  
✅ Build the PHP Laravel container  
✅ Start the MySQL database container  
✅ Start the Nginx web server  
✅ Start PhpMyAdmin for database management  

---

### **5️⃣ Verify Running Containers**
To check if all containers are running properly, use:  

```bash
docker ps
```

You should see containers running for:  
✅ `laravel_app` (Laravel App)  
✅ `laravel_mysql` (MySQL Database)  
✅ `laravel_nginx` (Nginx Server)  
✅ `laravel_phpmyadmin` (PhpMyAdmin)  

---

### **6️⃣ Run Database Migrations**
After the containers are up, run database migrations inside the Laravel container:  

```bash
docker exec -it laravel_app php artisan migrate --seed
```

This will set up the database schema and seed initial data.

---

### **7️⃣ Access the Application**
- **API Endpoints**: `http://localhost:8000/api`  
- **PhpMyAdmin** (Database UI): `http://localhost:8080`  
  - Username: `laravel_user`  
  - Password: `laravel_password`  

---

### **8️⃣ Stopping and Restarting Docker Containers**
To stop the containers:  

```bash
docker-compose down
```

To restart the containers:  

```bash
docker-compose up -d
```

---

### **9️⃣ Running Artisan Commands Inside the Container**
To run any Laravel Artisan command, use:  

```bash
docker exec -it laravel_app php artisan <command>
```

For example, to clear the cache:

```bash
docker exec -it laravel_app php artisan cache:clear
```

---

### **🔹 Troubleshooting**
- If you get permission errors, run:

```bash
sudo chmod -R 777 storage bootstrap/cache
```

- To check logs inside the app container:

```bash
docker logs laravel_app
```

---


## Developer Notes
- **Rate Limiting**: Configured at `throttle:30,1`.
- **Security**: Includes middleware for XSS sanitization and request validation.
- **Logging**: All API and command errors are logged for debugging.

---

## Acknowledgments
This project is fully developed and maintained by Eng. Hassan Gomaa. It integrates cutting-edge technologies and practices to deliver a seamless news aggregation experience.