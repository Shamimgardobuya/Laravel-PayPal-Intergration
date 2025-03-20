__Laravel PayPal Integration Web App__

This is a Laravel-based web application that integrates PayPal for processing donations to a school. Additionally, it provides API endpoints for managing users and staff within the school system.

__Getting Started__
Prerequisites
Ensure you have the following installed before setting up the project:

1. Laravel
2. Composer
3. Relational Database (e.g., MySQL, PostgreSQL)
4. Node.js and npm

__Installation Steps__
1. Clone the repository:

```git clone <repository-url>```
```cd <project-folder>```
2. Install dependencies by running ``` composer install```
4. Run database migrations:


```php artisan migrate ```
5. Seed the database

```
php artisan db:seed
```
6. Compile frontend assets:
```
npm install
npm run dev
```
  __REST API Routes__
1. Making a Payment
To make a payment, visit:
📍 http://localhost:8000/

2. Staff Management
Create a Staff Member
Endpoint: POST http://localhost:8000/api/staff/create

Payload:

```json
{
  "first_name": "required",
  "last_name": "required",
  "role": "required (Teacher, Head Teacher, Cook, etc.)",
  "email": "optional",
  "phone": "optional",
  "file": "optional (Profile Picture)"
}
```
3. User Management
Create a User
Endpoint: POST http://localhost:8000/api/users/create

Payload:
```
json
{
  "name": "required",
  "email": "required",
  "password": "required",
  "role_name": "required (Super Admin or Staff)"
}
```
User Login
Endpoint: POST http://localhost:8000/api/users/login

Payload:
```
json

{
  "email": "required",
  "password": "required"
}
```
Response:

A token is returned, which must be included in all authenticated requests.

Update a User
Endpoint: PATCH http://localhost:8000/api/users/update/{id}

Payload:
```
json

{
  "name": "optional",
  "email": "optional",
  "password": "optional"
}
```
Delete a User
Endpoint: DELETE http://localhost:8000/api/users/delete/{id}

**Notes**
Ensure that environment variables (e.g., database credentials, PayPal API keys) are correctly set in the .env file.

Use the provided authentication token when making requests to protected API endpoints.

