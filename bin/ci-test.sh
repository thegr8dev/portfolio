#!/bin/bash

# Local CI Test Script
# This script mimics what the GitHub Actions workflow does locally

set -e

echo "🚀 Starting local CI test..."

echo "📦 Installing Composer dependencies..."
composer install --prefer-stable --prefer-dist --no-interaction

echo "📦 Installing NPM dependencies..."
npm ci

echo "🏗️  Building assets..."
npm run build

echo "🔧 Setting up environment..."
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

echo "🗄️  Running migrations..."
php artisan migrate --force

echo "🔧 Generating IDE Helper..."
composer ide-helper

echo "✨ Running Pint (Code Style Check)..."
composer lint:test

echo "🔍 Running PHPStan (Static Analysis)..."
composer phpstan

echo "🧪 Running Tests..."
composer test

echo "✅ All checks passed! Your code is ready for CI."