# CI/CD Pipeline

This repository uses GitHub Actions for continuous integration and deployment.

## Workflow Overview

The CI pipeline runs on:
- **Push** to `main` and `dev` branches
- **Pull requests** to `dev` branch
- **Manual trigger** via workflow_dispatch

## Branch Protection

PRs to the `dev` branch **cannot be merged** until all CI checks pass:
- ✅ PHP 8.3 & 8.4 test matrix
- ✅ Code style validation (Pint)
- ✅ Static analysis (PHPStan)
- ✅ Test execution (Pest)
- ✅ Security audit

## Pipeline Steps

### 1. **Environment Setup**
- PHP 8.3 & 8.4 matrix testing
- MySQL 8.0 service
- Node.js 20 with npm cache
- Composer dependency cache

### 2. **Application Setup**
- Install Composer dependencies
- Install NPM dependencies and build assets
- Create environment configuration
- Generate application key
- Run database migrations

### 3. **Code Quality Checks**
- **IDE Helper Generation**: Updates model type definitions
- **Laravel Pint**: Code style formatting check
- **PHPStan**: Static analysis with custom Eloquent property rules
- **Pest Tests**: Feature and unit test execution

### 4. **Security Audit**
- Composer security audit
- NPM security audit

## Local Testing

Test the CI pipeline locally before pushing:

```bash
# Run the full CI test suite
composer ci

# Or run individual components
composer quality  # IDE Helper + Rector + Pint + PHPStan
composer test      # Pest tests only
```

## Composer Scripts

- `composer lint` - Fix code style issues
- `composer lint:test` - Check code style without fixing
- `composer phpstan` - Run static analysis
- `composer ide-helper` - Generate IDE Helper for models
- `composer rector` - Clean up unnecessary DocBlocks
- `composer quality` - Run all quality tools
- `composer test` - Run tests
- `composer ci` - Run local CI simulation
- `composer ci-full` - Run quality checks + tests

## Custom PHPStan Rules

The pipeline includes custom PHPStan rules that:
- ✅ Validate Eloquent model properties against IDE Helper definitions
- ✅ Catch undefined property access before deployment  
- ✅ Ensure type definitions stay in sync with database schema

When adding new model properties:
1. Add the database column
2. Run `composer ide-helper` to update type definitions
3. Commit both changes together

## Workflow Files

- `.github/workflows/ci.yml` - Main CI pipeline
- `bin/ci-test.sh` - Local CI test script