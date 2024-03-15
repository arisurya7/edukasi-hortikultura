## ABOUT
Application for learning media for understanding and caring for horticultural plants

## INSTALLING

### 1. Clone this repo
```bash
git clone https://github.com/arisurya7/edukasi-hortikultura.git
```

### 2. Change directory
```bash
cd edukasi-hortikultura
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
