# APL Upload Image Project

## Local Storage
![Alt text](/screenshots/readme-img-1.png?raw=true "Screenshot 1")
![Alt text](/screenshots/readme-img-2.png?raw=true "Screenshot 2")

## Azure Blob Container
![Alt text](/screenshots/readme-img-3.png?raw=true "Screenshot 3")
![Alt text](/screenshots/readme-img-4.png?raw=true "Screenshot 4")

## What it looks like as an audit in the database table
![Alt text](/screenshots/readme-img-5.png?raw=true "Screenshot 5")

## Folder Structure

The following are the files I have added/changed, rest is part of the Laravel package.
I am using Laravel Breeze as the authentication package.

- .env.example
- .vite.config.js
- composer.json
- composer-lock.json
- .package.json
- .package-lock.json
- app
    -- Classes
        -- HandleImages.php
    -- Http
        --- Controllers
            ---- Admin
                ----- DashboardController.php
                ----- ImageController.php
                ----- StorageSettingController.php
            ---- Public
                ----- HomeController.php
                ----- ImageController.php
            --- Requests
                ---- Images
                    ----- ImageUpdateRequest.php
                    ----- ImageUploadRequest.php
                ---- StorageSetting
                    ----- UpdateStorageSettingRequest.php
    -- Models
        --- Image.php
        --- StorageSetting.php
    -- Providers
        --- AppServiceProvider.php
- config
    -- filesystems.php
    -- image.php
- database
    -- seeders
        --- StorageSettingSeeder.php
    -- migrations
        --- 2025_01_30_143414_create_images_table.php
        --- 2025_01_31_091950_create_storage_settings_table.php
- resources 
    -- js
        --- main.js
        --- storage-setting.js
    -- views
        --- vendor
            ---- pagination
                ----- tailwind.blade.php
        --- auth
            ---- images
                ----- create.blade.php
                ----- edit.blade.php
            ---- forgot-password.blade.php
            ---- login.blade.php
            ---- register.blade.php
        --- images
            ---- show.blade.php
        --- layouts
            ---- global-layout.blade.php
        --- dashboard.blade.php
        --- welcome.blade.php
- routes
    -- auth.php
    -- web.php
- screenshots
    -- readme-img-1.png
    -- readme-img-2.png
    -- readme-img-3.png
    -- readme-img-4.png
    -- readme-img-5.png
- tests
    -- Feature
        --- app
            ---- Classes
                ----- HandleImagesTest.php
            ---- Http
                ----- Controllers
                    ------ Admin
                        ------- DashboardControllerTest.php
                        ------- ImageControllerTest.php
                        ------- StorageSettingControllerTest.php
                    ------ Public 
                        ------- HomeControllerTest.php
                        ------- ImageControllerTest.php

## Installation

1. Ensure you run the following commands when you have properly uploaded to your desired hosting service:

```bash
composer install
npm run install
```

2. Connect to your database in the `.env` file, currently labeled as `.env.example`, so make sure to correctly rename that and then run the following command after configuring your db settings:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apl
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan db:seed --class=StorageSettingSeeder
php artisan migrate
```

3. Remember to also configure Azure for image uploading, in your `.env` file.

```
AZURE_STORAGE_ACCOUNT=your_account_name
AZURE_STORAGE_KEY=your_storage_key
AZURE_STORAGE_CONTAINER=apl-recruitment-images
AZURE_STORAGE_URL=your_url
AZURE_STORAGE_CONNECTION_STRING=your_connection_string
```

4. Then visit your browser after running the following command. You should be able to now explore the contents of the app, enjoy!

```bash
npm run build
php artisan serve
```

5. Incase you run into issues with storage, try running the following:

```
php artisan storage:link
```

6. If you are looking to test the app, please remember to add your config similar to the `.env` variables. 

```
<server name="DB_CONNECTION" value="mysql"/>
<server name="DB_DATABASE" value="test_db"/>
<server name="DB_USERNAME" value="..."/>
<server name="DB_PASSWORD" value="..."/>
```

7. To run the tests, just do:

```
php artisan test
```

## Improvements that could be done with more time

- Could've dade the components more reusable so I didn’t have to repeat myself and made it more accessible
- Could've added roles and permissions to allow access to users with certain permissions
- Could've done a headless approach using backend as API and frontend React
- Could've added cron jobs to retrieve images from azure every half an hour to update local storage
- Ability to support more sizes for imges that are less than 1024 for responsive images, therefore improving wider performance
- Coudl've added a loading state whilst images are loading, which required a lot of frontend work
- On image preview, I could've added zoom functionality for UX
