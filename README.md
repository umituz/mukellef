# Mukellef Test Case

Bu test case, Mukellef firması için hazırlanmıştır. Detaylı kurulum için aşağıdaki adımları takip edebilirsiniz.

## Detaylar
Laravel 11 ile kodlanmıştır ve PHP sürümü 8.3

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

4. Docker container'larını başlatmak için aşağıdaki komutu çalıştırın:

    ```bash
    docker-compose up -d
    ```

5. Laravel projesini oluşturmak ve gerekli dosyaları yüklemek için Docker container'ına giriş yapın:

    ```bash
    docker-compose exec -it backend bash
    ```

   Ardından aşağıdaki komutları çalıştırabilirsiniz.
6.
    ```bash
    
   php artisan setup
   - Veritabanını tablolarını oluşturup veri eklemek için, setup
   
   php artisan app:renew-subscriptions
   - Abonelik yenileme işlemleri için ilgili verileri bulup kuyruğa atar
   
   php artisan queue:work
   - Kuyrukta bekleyen işlemleri çalıştırır
   
   php artisan test
   - Hazırlanan tüm entegrasyon ve birim testlerini çalıştırır
   
   php artisan test --coverage-html=coverage
   - Hazırlanan tüm entegrasyon ve birim testlerini coverage alınarak tarayıcıda gösterilmesi için gerekli html dosyalarını oluşturur
    ```

7. Tarayıcınızda `http://localhost:8000` adresine gidin, Laravel hoş geldiniz sayfasını görmelisiniz.
8. RabbitMQ admin paneline giriş bilgileri: kullanıcı adı - admin, şifre - password
9. Phpmyadmin veritabanı arayüzüne giriş bilgileri: host - mysql, kullanıcı adı - root, şifre - password
10. Postman collection import ettikten sonra yeni bir environment oluşturmanız gerekebilir.(Mukellef_Local_ENV) Bunun nedeni login işlemi sonrası bearer token işlemleri için gerekli olan TOKEN değerini global olarak eklemek gerekiyor. Her bir istek bu değeri kontrol ettiği için konulması gerekmektedir.
## Geliştirici

- [Ümit UZ](https://github.com/umituz)

## Postman

Aşağıdaki linkten api dökümantasyonuna ulaşabilirsiniz.

https://documenter.getpostman.com/view/32043497/2sA35MxJR5
