# Use an official PHP image with Apache
FROM php:8.2-apache

# Enable commonly used PHP extensions (MySQLi, PDO, etc.)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files into the Apache web root
COPY . /var/www/html/

# Expose the port Render will assign dynamically
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
