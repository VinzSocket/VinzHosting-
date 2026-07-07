# Fitur Source Code (SC)

Isi archive ini adalah file **baru** dan file **yang diubah** untuk nambahin fitur "Source Code" ke panel lu.
Cara pakai: extract archive ini ke root project (timpa file yang sama), lalu jalankin langkah di bawah.

## Yang ditambahin

**Admin (Filament, `/admin`)**
- Menu baru **Content > Source Codes**. Cuma admin yang bisa akses (otomatis ke-gate sama middleware admin panel yang udah ada).
- Setiap entri punya: Judul, Deskripsi, Link (GitHub/MediaFire/apa aja), Kategori/Tag, Thumbnail (isi link gambar), Urutan tampil, dan toggle Aktif/Nonaktif (buat sembunyiin tanpa hapus).

**Client (Dashboard user)**
- Section baru "Source Code" muncul otomatis di Dashboard utama (di atas daftar server), tapi **cuma muncul kalau ada minimal 1 entri aktif**. Kalau belum ada isinya, section ini gak nongol sama sekali.
- Setiap card nampilin thumbnail, judul, kategori, deskripsi, dan tombol download yang buka link di tab baru.
- Begitu ada isinya, user bakal ditanya sekali (modal) mau tombolnya gaya **3D** atau **Biasa**. Pilihan ini disimpan per-user (localStorage) dan bisa diganti kapan aja lewat tombol "Ganti tampilan tombol" di pojok kanan section.

## Langkah setelah extract

```bash
# 1. Jalanin migration buat bikin tabel source_codes
php artisan migrate

# 2. Clear cache config/route/view (karena ada file lang & provider yang berubah)
php artisan optimize:clear

# 3. Build ulang asset frontend (karena ada komponen React baru)
npm run build
# atau kalau lagi development:
npm run dev
```

## Cara nambah SC

1. Login ke `/admin` pake akun admin.
2. Buka menu **Content > Source Codes** di sidebar.
3. Klik **New source code**, isi judul, deskripsi, link (GitHub/MediaFire/dll), kategori, dan link thumbnail (opsional).
4. Save. Entri langsung muncul di Dashboard semua user (kalau toggle "Aktif" nyala).

## File yang kesentuh

**Baru:**
- `database/migrations/2026_07_08_000000_create_source_codes_table.php`
- `app/Models/SourceCode.php`
- `app/Filament/Resources/SourceCodes/SourceCodeResource.php` (+ Pages: List/Create/Edit)
- `app/Http/Controllers/Api/Client/SourceCodesController.php`
- `resources/lang/{en,id}/admin/source_codes.php`
- `resources/scripts/api/getSourceCodes.ts`
- `resources/scripts/components/dashboard/SourceCodeSection.tsx`

**Diubah:**
- `routes/api-client.php` (nambah endpoint `GET /api/client/source-codes`)
- `app/Providers/Filament/AdminPanelProvider.php` (nambah nav group "Content")
- `resources/lang/{en,id}/admin/navigation.php` (nambah label grup "Content")
- `resources/lang/{en,id}/dashboard/index.php` (nambah teks section SC)
- `resources/scripts/components/dashboard/DashboardContainer.tsx` (render section SC)

## Catatan

- Field "Kategori/Tag" itu teks bebas (bukan dropdown fixed), jadi tinggal ketik aja sendiri konsisten (misal: `GitHub`, `MediaFire`, `Tools`, `Bot WA`).
- Field "Thumbnail" isinya link gambar langsung (bukan upload file), sama kayak field image di Eggs/Nests.
- Gak sempet ngetes build asli (npm/composer) di environment ini karena gak ada akses install dependency, jadi kalau ada typo kecil pas `npm run build`/`php artisan migrate`, kabarin aja detail errornya biar gw benerin.
