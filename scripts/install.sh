#!/bin/bash

echo "🚀 Starting installation..."

# Configure environment variables in .env
sed -i 's/DB_HOST=127.0.0.1/DB_HOST=mysql/g' .env
sed -i 's/DB_PASSWORD=/DB_PASSWORD=password/g' .env
sed -i 's/GIPHY_API_KEY=/GIPHY_API_KEY=wFgQKvbIvy4JSUJ3OjX94pkKoMeqkGto/g' .env

# Install Passport and capture output
echo "⏳ Installing Passport..."
php artisan passport:install --force --no-interaction > passport_output.txt

# Extract IDs and secrets
PERSONAL_CLIENT_ID=$(grep -i "Client ID" passport_output.txt | head -n 1 | awk '{print $NF}')
PERSONAL_CLIENT_SECRET=$(grep -i "Client secret" passport_output.txt | head -n 1 | awk '{print $NF}')
PASSWORD_CLIENT_ID=$(grep -i "Client ID" passport_output.txt | tail -n 1 | awk '{print $NF}')
PASSWORD_CLIENT_SECRET=$(grep -i "Client secret" passport_output.txt | tail -n 1 | awk '{print $NF}')

# Debug - show captured values
echo "Personal Client ID: $PERSONAL_CLIENT_ID"
echo "Personal Client Secret: $PERSONAL_CLIENT_SECRET"
echo "Password Client ID: $PASSWORD_CLIENT_ID"
echo "Password Client Secret: $PASSWORD_CLIENT_SECRET"

# Update .env with Passport values
sed -i "s|PASSPORT_PERSONAL_ACCESS_CLIENT_ID=.*|PASSPORT_PERSONAL_ACCESS_CLIENT_ID=$PERSONAL_CLIENT_ID|" .env
sed -i "s|PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=.*|PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=$PERSONAL_CLIENT_SECRET|" .env
sed -i "s|PASSPORT_PASSWORD_GRANT_CLIENT_ID=.*|PASSPORT_PASSWORD_GRANT_CLIENT_ID=$PASSWORD_CLIENT_ID|" .env
sed -i "s|PASSPORT_PASSWORD_GRANT_CLIENT_SECRET=.*|PASSPORT_PASSWORD_GRANT_CLIENT_SECRET=$PASSWORD_CLIENT_SECRET|" .env

# Clean up temporary file
rm passport_output.txt

# Clear and cache configuration
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan config:cache
echo "✅ Installation completed!"
