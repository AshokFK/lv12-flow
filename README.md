# Flowchart Sewing dan Non Sewing

## Master data
- Komponen
```bash
# create model and migration
php artisan make:model Komponen -m

# create livewire components
php artisan livewire:make komponen/list-komponen
php artisan livewire:make komponen/create-komponen
php artisan livewire:make komponen/edit-komponen

# trait for searching and sorting data
php artisan make:trait Traits/TableTools

# trait for autofill created and updated user
php artisan make:trait Traits/CreatedUpdatedBy

# make data seeder from csv 
composer require --dev league/csv
php artisan make:seeder CsvImportSeeder
php artisan db:seed --class=CsvImportSeeder
```

- Proses
- QC
- Lokasi