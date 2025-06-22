# Cobaliveware - Laravel E-commerce with Filament Admin

A modern e-commerce application built with Laravel, Filament Admin Panel, and Livewire.

## Features

- 🛍️ **E-commerce Platform**: Product catalog, shopping cart, and order management
- 👨‍💼 **Admin Panel**: Beautiful Filament admin interface for managing products, orders, and users
- 👤 **User Management**: User registration, login, profile management
- 📦 **Product Management**: CRUD operations for products with image upload
- 🛒 **Shopping Cart**: Add products to cart, update quantities, checkout
- 📋 **Order Management**: Complete order lifecycle from pending to completed
- 🎨 **Modern UI**: Bootstrap-based responsive design with Font Awesome icons

## Tech Stack

- **Backend**: Laravel 11
- **Admin Panel**: Filament 3
- **Frontend**: Livewire 3, Bootstrap 5
- **Database**: MySQL/PostgreSQL
- **File Storage**: Local storage with public disk
- **Authentication**: Laravel Breeze (custom implementation)

## Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Web server (Apache/Nginx) or Laragon/XAMPP

## Installation

### 1. Clone the repository
```bash
git clone <repository-url>
cd cobaliveware
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Install Node.js dependencies
```bash
npm install
```

### 4. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure database
Edit `.env` file and set your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cobaliveware
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run migrations and seeders
```bash
php artisan migrate
php artisan db:seed
```

### 7. Create storage link
```bash
php artisan storage:link
```

### 8. Build assets
```bash
npm run build
```

### 9. Set proper permissions (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

## Default Users

After running seeders, you'll have these default users:

### Admin User
- **Email**: admin@example.com
- **Password**: password
- **Access**: `/admin` (Filament admin panel)

### Regular User
- **Email**: user@example.com
- **Password**: password
- **Access**: `/` (User dashboard)

## Usage

### For Users
1. Visit `/register` to create an account
2. Browse products at `/`
3. Add products to cart
4. Checkout and place orders
5. View order history at `/orders`
6. Manage profile at `/profile`

### For Admins
1. Login at `/admin` with admin credentials
2. Manage products, categories, and orders
3. View analytics and reports
4. Import products via Excel

## File Structure

```
cobaliveware/
├── app/
│   ├── Filament/Resources/     # Admin panel resources
│   ├── Livewire/              # Livewire components
│   ├── Models/                # Eloquent models
│   └── Http/Controllers/      # Controllers
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/              # Database seeders
├── resources/
│   ├── views/                # Blade templates
│   └── css/js/              # Frontend assets
└── storage/
    └── app/public/          # Public file storage
```

## Key Features Explained

### Product Management
- **Image Upload**: Products can have images stored in `storage/app/public/products/`
- **Categories**: Products are organized by categories
- **Stock Management**: Automatic stock deduction on order placement

### Order System
- **Cart Management**: Session-based shopping cart
- **Order Status**: pending → processing → completed/cancelled
- **Order Items**: Detailed breakdown of ordered products

### User Roles
- **Admin**: Full access to admin panel and all features
- **User**: Can browse products, place orders, manage profile

## Troubleshooting

### Common Issues

1. **Storage link not working**
   ```bash
   php artisan storage:link
   ```

2. **Permission denied errors**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

3. **Composer dependencies issues**
   ```bash
   composer install --ignore-platform-reqs
   ```

4. **Database connection issues**
   - Check `.env` database credentials
   - Ensure database server is running
   - Run `php artisan migrate:fresh --seed`

### Upload Issues
- Ensure `storage/app/public/` directory exists and is writable
- Check symbolic link: `public/storage` should point to `storage/app/public`
- Verify file permissions on upload directory

## Development

### Running in development mode
```bash
npm run dev
php artisan serve
```

### Testing
```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support, please open an issue on GitHub or contact the development team.
