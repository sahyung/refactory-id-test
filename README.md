# Refactory Coding Interview - Backend
https://gitlab.refactory.id/snippets/3 | challenge no. 2

## Quickstart
```
$ git clone
$ cp .env.example .env
$ composer install
$ php artisan serve
```

## Test
```sh
curl --location --request POST '127.0.0.1:8000/api' \
--header 'Accept: */*' \
--header 'Content-Type: application/json' \
--data-raw '{
    "counter": "810"
}'
```

## Simple Client-Server App
Buatlah aplikasi client-server dengan kriteria sebagai berikut:

1. Setiap menit client akan mengirimkan POST request ke server, dengan payload seperti contoh berikut:
```json
// Header
"X-RANDOM": "93f9h3dx"
// Body
{ "counter": 1 }
```
```json
// Header
"X-RANDOM": "fe9g83jm"
// Body
{ "counter": 2 }
```
```json
// Header
"X-RANDOM": "igrijd9p"
// Body
{ "counter": 3 }
```

2. Server akan menerima request dari client tersebut. Menyimpan body maupun header ke file `server.log`. Lalu memberikan response HTTP code 201.
Contoh isi file `server.log`
```
[2020-07-28T16:23:40+07:00] Success: POST http://192.168.1.30/ {"counter": 1, "X-RANDOM": "93f9h3dx"}
[2020-07-28T16:24:40+07:00] Success: POST http://192.168.1.30/ {"counter": 2, "X-RANDOM": "fe9g83jm"}
[2020-07-28T16:25:40+07:00] Success: POST http://192.168.1.30/ {"counter": 3, "X-RANDOM": "igrijd9p"}
```

