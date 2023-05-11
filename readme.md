## 📱SMS Sender📱

Sms Sender is a package that provides a simple and efficient way to send SMS messages in Laravel applications. It uses TCG API services to send messages and can be easily set up and integrated into your project.

### 🛠️Installation

To install SMS Sender, simply run the following command in your Laravel project:

```bash
composer require invoyer/sms-sender
```

After installing the package, you need to update your .env file with the following values:

```
TCG_BASE_URL=https://sms4.tcg.lt/external/get/
TCG_SENDER=your_sender_name
TCG_SMS_API_KEY=your_api_key
TCG_LOGIN=your_login
```

If you need to modify any of these values, you can publish the config file using the following command:

```bash
php artisan vendor:publish --provider="Invoyer\SmsSender\SmsSenderServiceProvider" --tag=config
```

This will create a `sms-sender.php` file in your `config` directory, which you can edit to customize the package settings.

### 🚀Usage

Using SMS Sender is straightforward. First, you need to create a new instance of the `SmsSender` class, passing the recipient phone number and the message as parameters:
Then, you can call the `send` method to send the message:

```php
use Invoyer\SmsSender\SmsSender;

$sms = new SmsSender('+37060000000', 'Hello world!' );
$sms->send();
```

That's it! Your message will be sent using the TCG API services.

### 🙏 Credits

SMS Sender was created by [Invoyer](https://github.com/invoyer) and uses TCG API services to send SMS messages.

### 📜 License

Sms Sender is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).