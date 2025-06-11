# SOAP Wallet Server – Laravel

This project implements a SOAP server simulating a virtual wallet using Laravel 12 and Laminas SOAP.

## 🚀 Requirements

- PHP >= 8.2
- Composer
- Laravel 12
- Postman or SOAP client for testing

## 📂 Project Structure

```
/app/Soap/                  # SOAP logic and service class
/app/Http/Controllers/      # Controllers for handling SOAP/WSDL routes
/routes/web.php             # Routing for SOAP endpoints
```

## 🔧 Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

## 🧪 SOAP Endpoints

- `POST /soap/wallet` — Main entry point for all SOAP operations
- `GET  /soap/wallet.wsdl` — Returns the WSDL definition

## 🧱 Available SOAP Methods

- `registroCliente(nombre, documento, celular)`
- `recargarBilletera(celular, monto)`
- `pagar(referencia, monto)`
- `confirmarPago(referencia, codigo)`
- `consultarSaldo(documento, celular)`


## 🛠 Development Notes

- SOAP is handled manually using `Laminas\Soap\Server` and `AutoDiscover`.
- Each action is implemented in a separate controller, but exposed under a single endpoint.


## ⚙️ Environment Configuration

### 🛢️ Database Setup

Make sure to set your database connection in the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wallet_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run your migrations:

```bash
php artisan migrate
```

### 📧 Mail Setup

To enable email delivery for confirmation tokens or notifications, configure your mail driver in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="SOAP Wallet"
```

> You can use services like [Mailtrap](https://mailtrap.io/) for development and testing purposes.

Once configured, the application will send emails using Laravel’s `Mail` facade via the `LaravelMailer` service.



## 🧱 Architecture Overview – Laravel (DDD)

This project follows a **Domain-Driven Design (DDD)** approach. The codebase is divided into bounded contexts such as `Client`, `Payment`, and `Wallet`, and each context has a clear separation between layers:

```
src/
├── Client/
│   ├── Application/
│   │   └── UseCase/               # Application logic (commands/use cases)
│   ├── Domain/                    # Entities, interfaces, value objects
│   └── Infrastructure/
│       ├── Controller/            # HTTP/SOAP controllers
│       ├── Parser/                # Optional transformation or adapter layer
│       └── Repository/            # Implementation of domain repositories
│
├── Payment/
│   ├── Application/
│   ├── Domain/
│   └── Infrastructure/
│       ├── Controller/
│       ├── Repository/
│       └── Service/               # Infrastructure-specific services like email
│
├── Wallet/
│   ├── Application/
│   ├── Domain/
│   │   ├── Entity/                # Domain models like Wallet
│   │   ├── Repository/            # Interfaces for persistence
│   │   └── ValueObject/           # Immutable value objects like Amount
│   └── Infrastructure/
│       ├── Controller/            # Use case entrypoints (CheckWallet, TopUp)
│       └── Repository/            # Persistence implementation (e.g. Eloquent)
```

### 🔹 Application Layer

Located at `Application/UseCase`, this contains business use cases like:

- `CreateClient`
- `TopUpWallet`
- `CheckWallet`

These are orchestrators, not domain logic holders.

### 🔹 Domain Layer

Located under `Domain/`, it defines the **core business rules**:

- **Entities** – Rich domain objects (e.g., `Wallet`)
- **ValueObjects** – Immutable types (e.g., `Amount`, `Document`)
- **Repository interfaces** – Abstractions for persistence

### 🔹 Infrastructure Layer

All delivery and technical concerns go here:

- **Controller** – Handles HTTP/SOAP requests
- **Repository** – Implements interfaces using Eloquent, etc.
- **Service** – Mailers, queues, external APIs

### 🔄 Flow Example

A request to top up a wallet flows like this:

1. `TopUpController` receives SOAP input.
2. It invokes a **use case** (`TopUpWallet`) in the Application layer.
3. The use case uses domain services or entities to perform logic.
4. Persistence is done through a **repository interface** (in Domain), implemented by `EloquentWalletRepository`.

### ✅ Benefits

- Clear separation of concerns
- Scalable for multiple bounded contexts
- Easily testable (mocks via interfaces)
- Ideal for SOAP/REST hybrid projects

- ## 📄 License

MIT
