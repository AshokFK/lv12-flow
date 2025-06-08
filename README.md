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
```bash
# create model and migration
php artisan make:model Proses -m

# create livewire components
php artisan livewire:make proses/list-proses
php artisan livewire:make proses/create-proses
php artisan livewire:make proses/edit-proses
```
tambahan: kombinasi unique dari kolom mastercode dan lokasi

- QC
```bash
# create model and migration
php artisan make:model Qc -m

# create livewire components
php artisan livewire:make qc/list-qc
php artisan livewire:make qc/create-qc
php artisan livewire:make qc/edit-qc
```

- Lokasi
```bash
# create model and migration
php artisan make:model Lokasi -m

# create livewire components
php artisan livewire:make qc/list-qc
php artisan livewire:make qc/create-qc
php artisan livewire:make qc/edit-qc
```
tambahan: 
    - kombinasi unique dari kolom nama dan sub
    - listSub diambil dari nama lokasi yang sub lokasi nya kosong

## Flowchart
- Flow Header
```bash
# create model and migration
php artisan make:model FlowHeader -m

# create livewire components
php artisan livewire:make flow/list-header
php artisan livewire:make flow/create-header
php artisan livewire:make flow/edit-header
```

- Flow Item

```bash
# create model and migration
php artisan make:model FlowItem -m

# create livewire components
php artisan livewire:make flow/list-item
php artisan livewire:make flow/create-item
```

Menambahkan component `tom-select.blade.php`

Menambahkan model FlowItem
`php artisan make:model FlowItem -m`

Menambahkan model Mesin
`php artisan make:model Mesin`
Menambahkan config database `mysql_machine`

Menambahkan model Operator untuk hit request ke API Spisy

Update FlowHeader model, menambahkan relasi items ke FlowItem

Update list header untuk menampilkan list item flow

Update AppServiceProvider, menambahkan mapping model `MorphMap` dan Macro search


Perbaikan list item operator, 
- kolom operator: mengambil data dari db lokal
- menampilkan komponen edit item
- perbaikan proses delete item

Menambahkan OperatorHelper
- melakukan pencarian operator dari db lokal maupun api
- menyimpan operator yang dipilih dari api ke db lokal

Update Model Operator untuk mengambil data operator dari db lokal
Menambahkan Operator migration

Perbaikan create item
- `fetchOperator` menggunakan OperatorHelper
- menambahkan `simpanOperator` untuk menyimpan operator terpilih menggunakan operator helper, dipanggil hanya ketika operator terpilih source nya dari remote api
- valueField operator yg disimpan diubah menjadi nik, sebelumnya berupa json nik dan nama

create edit item component
`php artisan livewire:make flow/edit-item`