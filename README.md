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

Menambahkan chart item
- menambahkan layout flow
- update menu flowchart sidebar


Update flow header
- menambahkan wrapper width dan wrapper height, untuk menyimpan lebar dan tinggi wrapper flow item

Update flow item
- menambahkan left dan top, untuk menyimpan posisi item flow

Menambahkan import csv seeder header

Update relasi lokasi pada header dan proses
- update kolom lokasi create dan edit header
- update kolom lokasi create dan edit proses
- update migration proses dan header

Create-proses update validasi unique mastercode dan lokasi

Update chart item
- perbaikan format header wrapper width dan height 
- menambahakan selection box untuk multiple select item dan geser item menggunakan arrow

Update create dan edit item 
- menampilkan proses type (standar,custom) pada type item komponen
- update item, ketika save berhasil, dispatch event `item-updated` untuk reset list-item tanpa reload halaman

Update list item
- menampilkan badge (tim, bahan) jika item type komponen

Update database seeder
- seeder import csv dipisahkan sesuai masing masing model/table

Update flow item seeder
- menambahkan data item standar sjc, slj, slp, sls, spa dan spb

Update seeder komponen, proses dan qc
- menambahkan truncate sebelum seeding

Refactor toast notif
- ganti menggunakan sweetalert2

Custom login eksternal user
- menambahkan model auth LoginUser
- membuat guard `login`
- menambahkan db config eksternal user
- perbaikan form login user

Menambahkan data header standar line
- menambahkan header standar non-sewing
- perbaikan urutan data lokasi

Perbaikan master data proses dan item
- menambahkan constrain item dengan header
- update proses lokasi id
- menambahkan master proses matome jas
- skip import item, kolom operator dan mesin

## duplikat header dan item

membuat component duplikat item
`php artisan livewire:make flow/copy`

menambahkan validasi unique 
pada kolom ['kontrak', 'brand', 'pattern', 'style', 'tgl_berjalan', 'lokasi_id']

menambahkan trait lokasi
`php artisan make:trait FetchLokasi`

refactor fetchLokasi
- dari public function menjadi menggunakan trait

Menambahakn detail item pada flowchart
`php artisan livewire:make flow/detail-item`

## masalah dan evaluasi

Menambahkan module masalah
`php artisan make:model Masalah -m`
`php artisan livewire:make masalah/list-masalah`
`php artisan livewire:make masalah/create-masalah`
`php artisan livewire:make masalah/edit-masalah`
`php artisan livewire:make masalah/list-by-header`

Menambahkan action evaluasi pada list masalah

## role dan permission

install laravel permission
`composer require spatie/laravel-permission`

publish migration dan config
`php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`

create custom [Role, Permission] model

membuat seeder role permission
`php artisan make:seeder RolePermissionSeeder`

membuat module role dan permission
`php artisan livewire:make access/list-role-permission`
`php artisan livewire:make access/create-role-permission`
`php artisan livewire:make access/edit-role-permission`

membuat list user dan assign role
`php artisan livewire:make access/list-user`
`php artisan livewire:make access/user-assign-role`

membuat grouping permission
`php artisan make:migration add_group_to_permissions`

update list permission di create dan edit RolePermission


