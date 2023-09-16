
# ExampleSMS API V1.0

ExampleSMS firması müşterilerine sms gönderim hizmeti sunan bir
firmadır. Bu müşterilerin kendilerine ait kullanıcı adları ve
şifreleri vardır. Müşteriler restful api kullanarak sms gönderimi
yapabilir, sms raporlarını(kayıtlarını) görebilir, sms rapor
detayını görebilir ve bu raporları tarih filtresine göre
filtreleyebilir.


## Bilgisayarınızda Çalıştırın

Projeyi klonlayın

```bash
  git clone https://github.com/furkankaracam/ExampleSMS.git
```

Proje dizinine gidin

```bash
  cd vatansoft
```

Gerekli paketleri yükleyin

```bash
  npm install
```

.env dosyanızın veritabanı ayarlarını güncelleyin.

Veritabanı migrasyonlarını yapın

```bash
  php artisan:migrate
```

Veritabanına sahte verileri ekleyin.

```bash
  php artisan db:seed
```

Sunucuyu çalıştırın

```bash
  php artisan serve
```
## API Kullanımı

#### Kullanıcı Kayıt İşlemi

```http
  POST /api/auth/register
```

| Parametre | Tip     | Açıklama                |
| :-------- | :------- | :------------------------- |
| `username` | `string` | **Gerekli, Unique**. Kullanı Adı. |
| `password` | `string` | **Gerekli**. Parola. |


Girilen kullanıcı adı ve parola ile kullanıcı kayıt işlemini yapar. Geri dönüş:

```json
{
  "status": 200",
  "data": {
    username : 'kullanici_adi',
    id : 2
    }
}
```

#### Kullanıcı Giriş İşlemi

```http
  POST /api/auth/login
```

| Parametre | Tip     | Açıklama                |
| :-------- | :------- | :------------------------- |
| `username` | `string` | **Gerekli**. Kullanı Adı. |
| `password` | `string` | **Gerekli**. Parola. |

Girilen kullanıcı adı ve parolayı kontrole edip giriş işlemini yapar. Giriş başarılıysa JWT Token oluşturup token'ı geri döndürür.

```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vdmF0YW5zb2Z0LnRlc3QvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2OTQ3ODcwNzEsImV4cCI6MTY5NDc5MDY3MSwibmJmIjoxNjk0Nzg3MDcxLCJqdGkiOiIwRlRncFZoUGVvdjhTcVRjIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.h4nNg9_596gGI9Zo3RSVAc6IbAbZ-_03VZ-f8-MacvU"
}
```

#### Sms'leri Listeleme

```http
  GET /api/sms
```

Sistemdeki gönderilen sms'leri listeler.

```json
{
  "data": [
    {
      "id": 1,
      "username": "user",
      "number": "+905442241798",
      "message": "Gönderilen mesaj içeriği",
      "created_at": "2023-09-15T14:13:16.000000Z",
      "updated_at": "2023-09-15T14:13:16.000000Z"
    }
  ]
}
```

#### Sms'leri Tarih Bazlı Filtreleme

```http
  GET /api/sms/{date}
```

| Parametre | Tip     | Açıklama                |
| :-------- | :------- | :------------------------- |
| `date` | `string` | **Opsiyonel Y-m-d**. Tarih.|

Sistemdeki gönderilen sms'leri verilen tarihe göre filtreleyip listeler.

```json
{
  "data": [
    {
      "id": 1,
      "username": "user",
      "number": "+905442241798",
      "message": "Gönderilen mesaj içeriği",
      "created_at": "2023-09-15T14:13:16.000000Z",
      "updated_at": "2023-09-15T14:13:16.000000Z"
    }
  ]
}
```

#### Sms kaydı görüntüleme

```http
  GET /api/sms/show/{id}
```

| Parametre | Tip     | Açıklama                |
| :-------- | :------- | :------------------------- |
| `id` | `int` | **Zorunlu**. Mesaj ID'si.|

İstenilen mesajı listeler.

```json
{
  "status": true,
  "data": {
    "id": 1,
    "username": "user",
    "number": "+905442241798",
    "message": "Gönderilen mesaj içeriği",
    "created_at": "2023-09-15T14:13:16.000000Z",
    "updated_at": "2023-09-15T14:13:16.000000Z"
  }
}
```

#### Sms gönderme

```http
  POST /api/sms/send
```

| Parametre | Tip     | Açıklama                |
| :-------- | :------- | :------------------------- |
| `username` | `string` | **Zorunlu**. Kullanıcı adı.|
| `number` | `string` | **Zorunlu**. Gönderilecek numara.|
| `message` | `string` | **Zorunlu**. Mesaj.|

Mesaj gönderme işlemi yapar.

```json
{
  "status": true,
  "data": {
    "username": "user",
    "number": "+905442241798",
    "message": "Gönderilen mesaj içeriği"
  }
}
```