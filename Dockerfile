FROM php:8.2-apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80

# Show the demo notice before any application PHP endpoint runs.
RUN printf 'php_value auto_prepend_file /var/www/html/consent.php\n' > /etc/apache2/conf-available/club-notice.conf && a2enconf club-notice

# Keep demonstration and account pages out of search results.
RUN a2enmod headers && printf 'Header always set X-Robots-Tag "noindex, nofollow"\n' > /etc/apache2/conf-available/demo-robots.conf && a2enconf demo-robots
