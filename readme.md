# Zagros is a bug tracking system

## Install
1. Run ```composer create-project --prefer-dist mohsen/zagros```
2. Edit database config in ```app/config/database.php```
3. Run ```php artisan migrate```
4. Run Zagros from browser.
5. Register in Zagros as admin user
6. Go to ```za_users``` table of Zagros database and update field ```admin``` to ```1``` for one time.

## Localization
For change language, you must edit ```locale``` index in ```app/config/app.php``` array.

### Current languages
English    => ```en```

Indonesian => ```id``` thanks to [mul14](https://github.com/mul14)

### Languages neet to update
1. Indonesian

### Add language
If you wnat translate this project to your language, you can translate ```app/lang``` to your language and create a pull request or email: ```mohsen.sh12@hotmail.com```

## Read more
This project built on Laravel 4. if you find any issue please report.
