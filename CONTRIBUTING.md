# Contributing to Cobaliveware

Thank you for your interest in contributing to Cobaliveware! This document provides guidelines and information for contributors.

## Getting Started

1. **Fork the repository** on GitHub
2. **Clone your fork** locally
3. **Create a feature branch** for your changes
4. **Make your changes** following the coding standards
5. **Test your changes** thoroughly
6. **Submit a pull request**

## Development Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Git

### Quick Setup
```bash
# Clone your fork
git clone https://github.com/your-username/cobaliveware.git
cd cobaliveware

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env file

# Run migrations and seeders
php artisan migrate --seed

# Create storage link
php artisan storage:link

# Build assets
npm run build

# Start development server
php artisan serve
```

## Coding Standards

### PHP/Laravel
- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
- Use meaningful variable and function names
- Add proper PHPDoc comments for classes and methods
- Keep methods small and focused
- Use Laravel conventions for naming

### JavaScript/CSS
- Use consistent indentation (2 spaces)
- Follow ESLint configuration
- Use meaningful variable names
- Comment complex logic

### Git Commit Messages
- Use conventional commit format
- Keep commits small and focused
- Use present tense ("Add feature" not "Added feature")
- Reference issues when applicable

Example:
```
feat: add user profile management
fix: resolve image upload issue
docs: update README with setup instructions
```

## Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test --filter UserTest

# Run with coverage
php artisan test --coverage
```

### Writing Tests
- Write tests for new features
- Ensure good test coverage
- Use descriptive test names
- Follow AAA pattern (Arrange, Act, Assert)

## Pull Request Process

1. **Update documentation** if needed
2. **Add tests** for new functionality
3. **Ensure all tests pass**
4. **Update CHANGELOG.md** with your changes
5. **Submit PR** with clear description

### PR Template
```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Tests added/updated
- [ ] All tests pass
- [ ] Manual testing completed

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] CHANGELOG updated
```

## Issue Reporting

When reporting issues, please include:

1. **Environment details** (OS, PHP version, Laravel version)
2. **Steps to reproduce** the issue
3. **Expected behavior** vs actual behavior
4. **Screenshots** if applicable
5. **Error logs** if available

## Code of Conduct

- Be respectful and inclusive
- Help others learn and grow
- Provide constructive feedback
- Follow the project's coding standards

## Getting Help

- Check existing issues and PRs
- Read the documentation
- Ask questions in discussions
- Join our community channels

Thank you for contributing to Cobaliveware! 🚀 
