# Laravel Real-Time Chat System

A scalable real-time chat system built with Laravel that enables users to send and receive messages instantly. This project follows SOLID principles and leverages Laravel's robust ecosystem, including WebSockets for real-time messaging.

## Features

- **Real-Time Messaging:** Instant delivery of messages using Laravel WebSockets, Laravel Echo, and Pusher (or native WebSockets).
- **RESTful API Endpoints:** Endpoints for sending messages, retrieving paginated chat history, and marking messages as read.
- **Offline Message Support:** Messages are stored in the database if the receiver is offline and delivered once they come online.
- **Security:** Secured API endpoints with JWT authentication and rate limiting to prevent abuse.
- **Performance:** Database indexing and event-driven architecture ensure efficient message storage and delivery.
- **Unit Tests:** Comprehensive tests for message storage and retrieval.
- **API Documentation:** Documented endpoints using Swagger or Postman for easy integration.

## Technical Requirements

1. **Database Schema Design**
   - Create a `messages` table with necessary fields:
     - `id`
     - `sender_id`
     - `receiver_id`
     - `message`
     - `status` (e.g., delivered, read)
     - `created_at`
     - `updated_at`

2. **API Endpoints**
   - **Send Message:**  
     `POST /api/chat/send`  
     **Request Body:**
     ```json
     {
       "receiver_id": 2,
       "message": "Hello, how are you?"
     }
     ```  
     **Response:** HTTP 201 Created

   - **Retrieve Messages (Paginated):**  
     `GET /api/chat/messages/{user_id}`  
     **Response:**
     ```json
     {
       "data": [
         {
           "id": 1,
           "sender_id": 1,
           "receiver_id": 2,
           "message": "Hello, how are you?",
           "status": "delivered",
           "created_at": "2024-03-22T12:00:00Z"
         }
       ],
       "meta": {
         "current_page": 1,
         "total": 20
       }
     }
     ```

   - **Mark Messages as Read:**  
     `PATCH /api/chat/read/{message_id}`  
     **Response:** HTTP 200 OK

3. **Real-Time Features**
   - **WebSockets:** Utilize Laravel WebSockets for persistent, real-time connections.
   - **Event Broadcasting:** Use Laravel Echo & Pusher (or native WebSockets) to broadcast new messages instantly.
   - **Event-Driven Architecture:** Decouples message storage from the delivery notifications.

4. **Security & Performance**
   - **JWT Authentication:** Secures the API endpoints.
   - **Rate Limiting:** Protects against API abuse.
   - **Database Indexing:** Optimizes queries for sender, receiver, and timestamps.
   - **Queue Processing:** Asynchronous processing of background tasks using Laravel queues.

## Installation

1. php artisan serve

2. php artisan reverb:start

3. php artisan queue:work
