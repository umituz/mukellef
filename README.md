# Mukellef Test Case

Bu test case, Mukellef firması için hazırlanmıştır. Detaylı kurulum için aşağıdaki adımları takip edebilirsiniz.

## Gereksinimler

- Git
- Docker, Docker Compose

## Kurulum

1. Bu depoyu klonlayın:

    ```bash
    git clone https://github.com/umituz/mukellef
    ```

2. Proje dizinine gidin:

    ```bash
    cd mukellef
    ```

3. `.env.example` dosyasını kopyalayarak `.env` dosyasını oluşturun:

    ```bash
    cp .env.example .env
    ```

4. Docker container'larını başlatmak için aşağıdaki komutu çalıştırın:

    ```bash
    docker-compose up -d
    ```

5. Laravel projesini oluşturmak ve gerekli dosyaları yüklemek için Docker container'ına giriş yapın:

    ```bash
    docker-compose exec -it mukellef_laravel bash
    ```

   Ardından aşağıdaki komutları çalıştırabilirsiniz.
6.
    ```bash
    
   php artisan key:generate
    
   php artisan setup
   - Veritabanını tablolarını oluşturup veri eklemek için, setup
   
   php artisan app:renew-subscriptions
   - Abonelik yenileme işlemleri için ilgili verileri bulup kuyruğa atar
   
   php artisan queue:work
   - Kuyrukta bekleyen işlemleri çalıştırır
    ```

6. Tarayıcınızda `http://localhost` adresine gidin, Laravel hoş geldiniz sayfasını görmelisiniz.

## Geliştirici

- [Ümit UZ](https://github.com/umituz)

## Postman

Aşağıdaki linkten api dökümantasyonuna ulaşabilirsiniz.

https://documenter.getpostman.com/view/32043497/2sA35MxJBu
