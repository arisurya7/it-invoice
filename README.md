# it-Invoice

it-Invoice is a website-based application that functions to manage invoices from companies that have products in the form of services such as project creation. This website was created using the [Laravel](https://laravel.com/) and [Boostrap](https://getbootstrap.com/) frameworks.


## INSTALLING

### 1. Clone this repo
```bash
git clone https://github.com/arisurya7/it-invoice.git
```

### 2. Change directory
```bash
cd it-invoice
```

### 3. Create and `Setup` .env file (DB)
```bash
cp .env.example .env
```

### 4. Generate key
```bash
php artisan key:generate
```

### 5. Migrate database
```bash
php artisan migrate:fresh --seed
```

### 4. Run application
```bash
php artisan serve
```
