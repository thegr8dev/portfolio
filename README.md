# Portfolio

[![Laravel](https://img.shields.io/badge/Laravel-12.24.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3.24-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Filament](https://img.shields.io/badge/Filament-4.0.1-FDBA74?style=for-the-badge&logo=laravel&logoColor=white)](https://filamentphp.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.6.4-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.0.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Pest](https://img.shields.io/badge/Pest-3.8.2-4F46E5?style=for-the-badge)](https://pestphp.com)
[![Tests](https://img.shields.io/badge/Tests-80%20Passing-4CAF50?style=for-the-badge)](https://pestphp.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

A modern Laravel application with Filament admin panel for managing customer inquiries and contact forms. Built with the latest Laravel 12, Filament 4, and cutting-edge web technologies.

## 🚀 Features

- **Customer Inquiry Management**: Complete CRUD operations for customer inquiries with unique ticket ID generation
- **Contact Form**: Public-facing contact form with email notifications
- **Admin Panel**: Powerful Filament admin interface with authentication
- **Status Tracking**: Inquiry status management (Pending, In Progress, Resolved, Closed)
- **Email Notifications**: Automated email notifications for form submissions
- **Modern UI**: Built with TailwindCSS 4 and Livewire 3
- **Comprehensive Testing**: 80 passing tests with Pest framework
- **Code Quality**: PHPStan, Pint, and Rector for code quality assurance

## 🛠️ Tech Stack

- **Backend**: Laravel 12.24.0 with PHP 8.3.24
- **Admin Panel**: Filament 4.0.1
- **Frontend**: Livewire 3.6.4 + TailwindCSS 4.0.0
- **Database**: MySQL with Eloquent ORM
- **Testing**: Pest 3.8.2 with Laravel and Livewire plugins
- **Code Quality**: PHPStan (Larastan), Laravel Pint, Rector
- **Development**: Laravel Herd, Vite 7.0.4

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL/MariaDB
- Laravel Herd (recommended) or traditional LAMP/LEMP stack

## 🔧 Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd boost
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

## 🚀 Development

Start the development environment:

```bash
composer run dev
```

This command runs:
- Laravel development server
- Queue worker
- Log monitoring (Pail)
- Vite asset compilation

Or run services individually:
```bash
php artisan serve          # Development server
npm run dev                # Asset compilation
php artisan queue:work     # Queue processing
```

## 🧪 Testing

Run the complete test suite:
```bash
composer run test
```

Run specific test types:
```bash
php artisan test --filter=ContactForm    # Specific test
php artisan test tests/Feature/          # Feature tests only
php artisan test tests/Unit/              # Unit tests only
```

## 🔍 Code Quality

The project includes comprehensive code quality tools:

```bash
composer run quality    # Run all quality checks
composer run pint       # Fix code style
composer run lint       # Static analysis
composer run rector     # Code refactoring
```

## 📊 Models & Database

### Inquiry Model
- **Ticket ID**: Unique auto-generated ticket identifier
- **Customer Info**: Name, email, subject, message
- **Status**: Pending, In Progress, Resolved, Closed
- **Timestamps**: Creation and update tracking

### User Model
- Standard Laravel authentication
- Admin panel access control

## 🎨 Admin Panel

Access the Filament admin panel at: `https://localhost:8000/admin`

Features:
- Inquiry management with full CRUD operations
- User management
- Advanced filtering and search
- Bulk operations
- Responsive design

## 📧 Email Configuration

Configure your email settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run quality checks: `composer run quality`
5. Run tests: `composer run test`
6. Submit a pull request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🔗 Links

- **Application**: https://localhost:8000
- **Admin Panel**: https://localhost:8000/admin
- **Laravel Documentation**: https://laravel.com/docs
- **Filament Documentation**: https://filamentphp.com/docs
- **Pest Testing**: https://pestphp.com

---

Built with ❤️ using Laravel and modern web technologies.
