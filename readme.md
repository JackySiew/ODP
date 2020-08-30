<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Step
<p>1. Please install XAMPP into your personal computer.(Require PHP version >7.x)</p>
<p>2. Copy the odp into C:\xampp\htdocs</p>
<p>3. Import sql to the database as the step below:</p>
<p>	A. go to the file directory of the XAMPP (C:\xampp)</p>
<p>	B. open the xampp_control.exe</p>
<p>	C. start both "Apache" and "MySQL", activate function can see by the background color that change to green after start.</p>
<p>4. Go to the website "http://localhost/phpmyadmin/"</p>
<p>5. Create a new database call "odp".</p>
<p>5. Select the created "odp" database and click "Import",than select the odp.sql file and import it.</p>
<p>6. Go to C:\xampp\apache\conf\extra\httpd-vhosts.conf and set the roots and server name as below:</p>

      <VirtualHost *:80>
          DocumentRoot "C:/xampp/htdocs"
          ServerName localhost
      </VirtualHost>
      <VirtualHost *:80>
          DocumentRoot "C:/xampp/htdocs/odp/public"
          ServerName odp.test
      </VirtualHost>

<p>7. Go to C:\WINDOWS\System32\drivers\etc and open hosts(open with notepad and run as administrator), then write these statements into the file:</p>
      <p>127.0.0.1 localhost</p>
      <p>127.0.0.1 odp.test</p>
<p>8. Finally, you can type the website http://odp.test or http://localhost/odp/public and enjoy yourself</p>

## Customer
Email: user@user.com
Password: 00000000

## Designer
Email: design@design.com
Password: 11111111

## Admin
Email: admin@admin.com
Password: 11111111

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](http://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Styde](https://styde.net)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
