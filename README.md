
# 📝 Simple Blog API with Laravel

This is a simple blog backend project built with Laravel. It provides RESTful APIs for managing users, articles, and comments.

---

## 🚀 Features

- 🔐 User authentication (Register & Login using Laravel Sanctum)
- ✍️ CRUD operations for articles
- 💬 Commenting on articles (authenticated users only)
- 📄 Export article to PDF
- 🧪 Fully JSON-based API

---

**METHOD:** `POST`  
**URL:** `/auth/register`  
**Headers:**  
`Content-Type: application/json`


#### Body Parameters

- `username` *(string, required)* – Unique, 5–255 characters  
- `email` *(string, required)* – Valid and unique  
- `password` *(string, required)* – Minimum 6 characters  

#### Example Request

```json
{
  "username": "farham",
  "email": "farham@example.com",
  "password": "secret123"
}
```
### ✅ Success Response

**Status Code:** `200 OK`  
**Content-Type:** `application/json`

```json
{
  "success": true,
  "statusCode": 200,
  "message": "User registered successfully.",
  "data": {
    "username": "farham",
    "email": "farham@example.com",
    "password": "$2y$10$encrypted...",
    "reg_ip": "192.168.1.5",
    "last_login": "2025-07-12T11:23:00.000000Z",
    "last_ip": "192.168.1.5"
  }
}
```


### ❌ Error Responses

#### Validation Error – 422 Unprocessable Entity

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["This email is already taken."],
    "username": ["Username must be at least 5 characters."]
  }
}
```
---

