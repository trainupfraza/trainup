# Use an official PHP image with Apache
FROM php:8.2-apache

# Enable commonly used PHP extensions (MySQLi, PDO, etc.)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files into the Apache web root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Create a simple health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD curl -f http://localhost/ || exit 1

# Use PORT environment variable (Render provides this)
EXPOSE 10000

# Start Apache on the Render-provided port
CMD sed -i "s/80/${PORT}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && \
    docker-php-entrypoint apache2-foreground
