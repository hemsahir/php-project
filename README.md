RUN below command in terminal to set permission of directory
 * sudo chown -R www-data:www-data /var/www/html/nagarpalika/assets/uploads
 * sudo chmod -R 755 /var/www/html/nagarpalika/assets/uploads

🔧 Install and configure Postfix (for PHP's mail() to work) --> For send mail
 * sudo apt update
 * sudo apt install postfix -y
 * sudo systemctl restart apache2

https://github.com/PHPMailer/PHPMailer
 https://myaccount.google.com/apppasswords ==> set app password
