<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

/**
 * Seeder untuk membuat data role dan permission.
 *
 * Seeder ini akan membuat daftar role dan permission yang dibutuhkan aplikasi.
 *
 * @author
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Daftar role yang akan dibuat.
     *
     * @var array
     */
    protected array $roles = [
        'IT','IE','Chief', 'SPV','Leader','Technical','QA'
    ];

    /**
     * Daftar permission yang dikelompokkan berdasarkan modul.
     *
     * Key adalah nama modul, value adalah array aksi/permission.
     *
     * @var array
     */
    protected array $permissionGroups = [
        'flowchart' => [
            'list header', 'tambah header', 'edit header', 'menyelesaikan header', 'copy item',
            'list item', 'tambah item', 'edit item', 'hapus item', 'view flow', 'update layout'
        ],
        'masalah' => [
            'list masalah', 'tambah masalah', 'detail masalah', 'edit masalah',
            'menambah penanganan masalah', 'menyelesaikan masalah', 'save masalah', 'post masalah'
        ],
        'komponen' => [
            'list komponen', 'tambah komponen', 'edit komponen', 'hapus komponen'
        ],
        'proses' => [
            'list proses', 'tambah proses', 'edit proses', 'hapus proses'
        ],
        'qc' => [
            'list qc', 'tambah qc', 'edit qc', 'hapus qc'
        ],
        'lokasi' => [
            'list lokasi', 'tambah lokasi', 'edit lokasi', 'hapus lokasi'
        ]
    ];

    /**
     * Menjalankan seeder untuk role dan permission.
     *
     * @return void
     */
    public function run(): void
    {
        $this->seedRoles();
        $this->seedPermissions();
    }

    /**
     * Membuat data role ke database.
     *
     * @return void
     */
    private function seedRoles(): void
    {
        foreach ($this->roles as $role) {
            Role::create(['name' => $role]);
        }
    }

    /**
     * Membuat data permission ke database.
     *
     * @return void
     */
    private function seedPermissions(): void
    {
        foreach ($this->permissionGroups as $group => $actions) {
            foreach ($actions as $action) {
                Permission::create(['name' => $action, 'group' => $group]);
            }
        }
    }
}
