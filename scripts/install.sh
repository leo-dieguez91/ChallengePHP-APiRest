#!/bin/bash

echo "🚀 Starting automated installation..."

# Check if we're in the project root
if [ ! -f "composer.json" ]; then
    echo "❌ This script must be run from the Laravel project root"
    exit 1
fi

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install it first."
    exit 1
fi

# Set GIPHY API Key
GIPHY_KEY="wFgQKvbIvy4JSUJ3OjX94pkKoMeqkGto"

# Add Sail alias based on shell type
echo "🔧 Configuring Sail alias..."
if [ -f "$HOME/.zshrc" ]; then
    echo 'alias sh="sh $([ -f sail ] && echo sail || echo vendor/bin/sail)"' >> ~/.zshrc
    source ~/.zshrc
    echo "✅ Sail alias added to .zshrc"
elif [ -f "$HOME/.bashrc" ]; then
    echo 'alias sh="sh $([ -f sail ] && echo sail || echo vendor/bin/sail)"' >> ~/.bashrc
    source ~/.bashrc
    echo "✅ Sail alias added to .bashrc"
else
    echo "⚠️ Could not detect shell configuration file (.zshrc or .bashrc)"
fi

# Install dependencies
echo "📦 Installing dependencies..."
composer install

# Copy and configure environment file
echo "⚙️ Configuring environment variables..."
cp .env.example .env

# Update GIPHY API Key in .env
sed -i "s/GIPHY_API_KEY=/GIPHY_API_KEY=$GIPHY_KEY/" .env

# Start containers
echo "🐳 Starting Docker containers..."
./vendor/bin/sail up -d

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be available..."
sleep 30

# Generate application key
echo "🔐 Generating application key..."
sh artisan key:generate

# Install Laravel Passport
echo "🛂 Installing Laravel Passport..."
sh composer require laravel/passport
sh artisan migrate

# Install Passport and update credentials in .env
echo "🔑 Configuring Laravel Passport..."
PASSPORT_KEYS=$(sh artisan passport:install)

# Extract IDs and secrets from command output
CLIENT_ID_1=$(echo "$PASSPORT_KEYS" | grep -oP "Client ID: \K\d+" | sed -n 1p)
CLIENT_SECRET_1=$(echo "$PASSPORT_KEYS" | grep -oP "Client secret: \K[a-zA-Z0-9]+" | sed -n 1p)
CLIENT_ID_2=$(echo "$PASSPORT_KEYS" | grep -oP "Client ID: \K\d+" | sed -n 2p)
CLIENT_SECRET_2=$(echo "$PASSPORT_KEYS" | grep -oP "Client secret: \K[a-zA-Z0-9]+" | sed -n 2p)

# Update .env with Passport credentials
sed -i "s/PASSPORT_PERSONAL_ACCESS_CLIENT_ID=/PASSPORT_PERSONAL_ACCESS_CLIENT_ID=$CLIENT_ID_1/" .env
sed -i "s/PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=/PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=$CLIENT_SECRET_1/" .env
sed -i "s/PASSPORT_PASSWORD_GRANT_CLIENT_ID=/PASSPORT_PASSWORD_GRANT_CLIENT_ID=$CLIENT_ID_2/" .env
sed -i "s/PASSPORT_PASSWORD_GRANT_CLIENT_SECRET=/PASSPORT_PASSWORD_GRANT_CLIENT_SECRET=$CLIENT_SECRET_2/" .env

# Run migrations
echo "🔄 Running migrations..."
sh artisan migrate

# Install Node dependencies and compile assets
echo "📱 Installing frontend dependencies..."
sh npm install
sh npm run dev &

echo "✅ Installation completed!"
echo "🌐 The application should be available at http://localhost"
echo "🔔 Remember to restart your terminal or run 'source ~/.zshrc' to use the new 'sh' alias"
