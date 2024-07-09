# Instrucciones para correr la aplicación

## Pasos 

1. **ejecutar en terminal los comandos**
    ```bash
    composer install
    npm install
    ```

2. **migrar nuevas tablas y seeders para datos de prueba**
    ```bash
    php artisan migrate:refresh 
    ```
    - Si sale error intenta con 
    ```bash
    php artisan migrate:fresh
    ```

    - Si quieres crear usuarios por defecto
    ```bash
    php artisan migrate:refresh --seed
    ```
    - Si sale error intenta con 
    ```bash
    php artisan migrate:fresh --seed
    ```
    
3. **crea y configura archivo .env**

4. **copia contenido del archivo .env.example y genera key**
    ```bash
    php artisan key:generate
    ```

5. **inicar servidor artisan y node**
    ```bash
    php artisan serve
    npm run dev
    ```
