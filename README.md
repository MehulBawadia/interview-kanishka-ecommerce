## Nano E-Commerce Project

This is a nano E-Commerce project. This is an assignment project for the Technical Round interview for Kanishka Software Pvt. Ltd. company.

### Steps to install this project on your machine

Run the following commands one by one

```bash
git clone git@github.com:MehulBawadia/interview-kanishka-ecommerce.git
cd interview-kanishka-ecommerce
cp .env.example .env
composer install
php artisan key:generate --ansi
php artisan migrate:fresh --seed
php artisan storage:link
npm install
php artisan serve --host=localhost
npm run dev
```

### Test credentials

Admin user:
admin@example.com / Password

Customer
johndoe@example.com / Password
