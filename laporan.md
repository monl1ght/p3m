# 📋 LAPORAN IDENTIFIKASI FILE FRONTEND ADMIN PANEL P3M

**Project:** Sistem Informasi P3M Politeknik Balekambang Jepara  
**Framework:** Laravel 10 + AdminLTE 3  
**Tanggal:** 10 September 2026  
**Fokus:** Frontend/UI Admin Panel (tanpa logic backend)

---

## 📌 RINGKASAN EKSEKUTIF

Laporan ini mengidentifikasi semua file frontend yang membentuk tampilan Admin Panel P3M, meliputi:
- Layout template Blade
- Asset CSS (AdminLTE + Custom)
- Asset JavaScript
- Images & Logo
- Icon fonts
- External libraries (CDN)

Admin panel menggunakan **AdminLTE 3** sebagai framework UI dengan **custom styling tema hijau P3M**.

---

## 🗂️ DAFTAR ISI

1. [File Layout Utama](#1-file-layout-utama)
2. [Asset CSS](#2-asset-css)
3. [Asset JavaScript](#3-asset-javascript)
4. [Asset Images & Logo](#4-asset-images--logo)
5. [Fonts](#5-fonts)
6. [External Libraries](#6-external-libraries)
7. [Struktur UI Admin Panel](#7-struktur-ui-admin-panel)
8. [Color Scheme & Design System](#8-color-scheme--design-system)
9. [Responsive Breakpoints](#9-responsive-breakpoints)
10. [Rekomendasi](#10-rekomendasi)

---

## 1. FILE LAYOUT UTAMA

### 1.1 Layout Master Admin

**📄 File:** `resources/views/layout/main.blade.php`

**Path Lengkap:** `c:\laragon\www\p3m\resources\views\layout\main.blade.php`

**Fungsi:**
- Template wrapper untuk semua halaman admin
- Mendefinisikan struktur HTML dasar
- Meng-include semua CSS dan JS dependencies
- Mengatur layout header, sidebar, dan content area

**Bagian UI yang Dikontrol:**

| Baris | Elemen UI | Deskripsi |
|-------|-----------|-----------|
| 1-35 | **Head Section** | Meta tags, title, favicon, CSS links |
| 36-870 | **Inline Styles** | Custom CSS untuk styling admin panel |
| 896-946 | **Header/Topbar** | Navbar atas dengan menu toggle & notifikasi |
| 948-990 | **Sidebar: Brand Panel** | Logo P3M + nama aplikasi |
| 991-1000+ | **Sidebar: User Panel** | Profil admin dengan foto & role |
| 1001-1100+ | **Sidebar: Navigation** | Menu utama & submenu dengan icon |
| 1150+ | **Content Wrapper** | Area konten dinamis (@yield) |
| 1200+ | **Script Section** | JavaScript libraries & custom scripts |

**Dependencies yang Di-load:**

```html
<!-- CSS -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.0/ckeditor5.css">

<!-- JavaScript -->
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
```

---

### 1.2 Contoh Halaman Child

**📄 File:** `resources/views/dashadmin.blade.php`

**Path Lengkap:** `c:\laragon\www\p3m\resources\views\dashadmin.blade.php`

**Fungsi:**
- Halaman dashboard utama admin
- Extends dari `layout.main`
- Menggunakan section `@section('content')` dan `@section('css')`

**Komponen UI:**
- Hero card dengan gradient background
- Quick access cards untuk navigasi cepat
- Custom styling dengan inline CSS

---

## 2. ASSET CSS

### 2.1 CSS Core (AdminLTE Framework)

**📁 Folder:** `public/lte/dist/css/`

| File | Size | Fungsi |
|------|------|--------|
| **adminlte.min.css** | ~200KB | Core stylesheet AdminLTE (minified) |
| **adminlte.css** | ~400KB | Versi non-minified untuk development |
| **adminlte.min.css.map** | - | Source map untuk debugging |

**Mengatur:**
- Base layout (sidebar + content wrapper)
- Grid system & spacing utilities
- Typography base
- Komponen: card, table, form, button (default styling)
- Navigation structure
- Responsive breakpoints

---

### 2.2 CSS Plugins

**📁 Folder:** `public/lte/plugins/`

#### **2.2.1 FontAwesome Icons**

**Path:** `public/lte/plugins/fontawesome-free/css/all.min.css`

**Fungsi:**
- Semua icon di menu navigasi
- Icon di button (tambah, edit, hapus)
- Icon di card header
- Icon notifikasi
- Icon status badge

**Contoh Penggunaan:**
```html
<i class="nav-icon fas fa-home"></i>
<i class="fas fa-newspaper"></i>
<i class="far fa-bell"></i>
```

---

#### **2.2.2 OverlayScrollbars**

**Path:** `public/lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css`

**Fungsi:**
- Custom scrollbar untuk sidebar
- Smooth scrolling behavior
- Hidden scrollbar pada mobile

---

#### **2.2.3 iCheck Bootstrap**

**Path:** `public/lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css`

**Fungsi:**
- Styling checkbox custom
- Styling radio button
- Switch toggle button

---

#### **2.2.4 Tempusdominus Bootstrap 4**

**Path:** `public/lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css`

**Fungsi:**
- Date picker styling
- Time picker styling
- Calendar dropdown UI

---

#### **2.2.5 DateRangePicker**

**Path:** `public/lte/plugins/daterangepicker/daterangepicker.css`

**Fungsi:**
- Range date picker styling
- Calendar view untuk filter tanggal

---

#### **2.2.6 Summernote**

**Path:** `public/lte/plugins/summernote/summernote-bs4.min.css`

**Fungsi:**
- Rich text editor styling
- Toolbar editor (bold, italic, dll)
- Digunakan untuk input konten berita/artikel

---

#### **2.2.7 JQVMap**

**Path:** `public/lte/plugins/jqvmap/jqvmap.min.css`

**Fungsi:**
- Map visualization styling (jika digunakan)

---

### 2.3 Custom CSS (Inline dalam main.blade.php)

**Location:** `resources/views/layout/main.blade.php` line 36-870

**CSS Variables Defined:**

```css
:root {
    /* Default Theme */
    --admin-bg: #f6f8fb;
    --admin-surface: #ffffff;
    --admin-border: #e2e8f0;
    --admin-text: #334155;
    --admin-heading: #0f172a;
    --admin-muted: #64748b;
    --admin-blue: #2563eb;
    --admin-blue-hover: #1d4ed8;
    --admin-green: #063f35;
    --admin-dark: #071f24;
    --admin-gold: #d5a72f;
    --admin-radius: 18px;
    --admin-shadow: 0 18px 45px rgba(15, 23, 42, .07);
    --admin-font: "Inter", system-ui, sans-serif;
    --admin-heading-font: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
    
    /* P3M Green Theme */
    --p3m-green-900: #006b3c;
    --p3m-green-800: #087844;
    --p3m-green-700: #0a8f52;
    --p3m-green-600: #16a765;
    --p3m-green-100: #e9f8ef;
    --p3m-green-050: #f4fbf7;
    --p3m-text: #17221d;
    --p3m-muted: #66756d;
    --p3m-line: #e5eee9;
    --p3m-danger: #ef4444;
}
```

**CSS Classes Custom:**

| Class | Elemen UI | Style |
|-------|-----------|-------|
| `.p3m-admin-redesign` | Body wrapper | Theme hijau P3M |
| `.main-header` | Header/topbar | Background blur, height 72px |
| `.main-sidebar` | Sidebar kiri | Gradient hijau, rounded corners |
| `.brand-panel` | Logo area | Flex layout, gap 13px |
| `.user-panel` | Profil admin | Card dengan border, padding 12px |
| `.admin-avatar` | Avatar placeholder | Circle, background blue |
| `.nav-sidebar` | Menu container | Margin top 16px |
| `.nav-link` | Menu item | Min-height 46px, rounded 16px |
| `.nav-link.active` | Active menu | Background white, shadow |
| `.nav-treeview` | Submenu | Padding left, smaller font |
| `.content-wrapper` | Content area | Background image + gradient |
| `.content-header` | Page header | Padding, breadcrumb |
| `.breadcrumb` | Breadcrumb nav | Font size 14px, color green |
| `.card` | Content card | Rounded 24px, shadow |
| `.card-header` | Card header | Padding 24px 26px |
| `.btn-primary` | Button primary | Gradient green, shadow |
| `.form-control` | Input field | Rounded 12px, height 42px |
| `.table thead th` | Table header | Background green-100, uppercase |

---

## 3. ASSET JAVASCRIPT

### 3.1 JavaScript Core (AdminLTE)

**📁 Folder:** `public/lte/dist/js/`

| File | Fungsi UI |
|------|-----------|
| **adminlte.min.js** | Core JavaScript AdminLTE |
| **adminlte.js** | Versi non-minified |
| **demo.js** | Demo utilities (optional) |

**Functionality:**
- ☰ **PushMenu** - Toggle sidebar collapse/expand
- 📂 **Treeview** - Expand/collapse submenu
- 📱 **Responsive** - Auto-collapse sidebar pada mobile
- 📍 **Active State** - Highlight menu aktif
- 🔍 **Sidebar Search** - Filter menu berdasarkan keyword
- 📜 **OverlayScrollbars** - Initialize custom scrollbar

**Event Handlers:**
```javascript
// Toggle sidebar
$('[data-widget="pushmenu"]').click()

// Treeview menu
$('[data-widget="treeview"]').click()

// Sidebar search
$('.sidebar-search-input').keyup()
```

---

### 3.2 JavaScript Plugins

**📁 Folder:** `public/lte/plugins/`

#### **3.2.1 jQuery**

**Path:** `public/lte/plugins/jquery/jquery.min.js`

**Fungsi:**
- Base library untuk semua interaksi DOM
- Event handling
- AJAX requests
- Animation

---

#### **3.2.2 Bootstrap Bundle**

**Path:** `public/lte/plugins/bootstrap/js/bootstrap.bundle.min.js`

**Fungsi:**
- Modal popup
- Dropdown menu
- Tooltip
- Toast notification
- Collapse accordion

---

#### **3.2.3 OverlayScrollbars**

**Path:** `public/lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js`

**Fungsi:**
- Initialize custom scrollbar di sidebar
- Smooth scroll behavior
- Auto-hide scrollbar

---

#### **3.2.4 Moment.js**

**Path:** `public/lte/plugins/moment/moment.min.js`

**Fungsi:**
- Date formatting
- Time parsing
- Digunakan oleh daterangepicker

---

#### **3.2.5 DateRangePicker**

**Path:** `public/lte/plugins/daterangepicker/daterangepicker.js`

**Fungsi:**
- Date range selection
- Calendar popup
- Filter tanggal

---

#### **3.2.6 Tempusdominus Bootstrap 4**

**Path:** `public/lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js`

**Fungsi:**
- Date picker widget
- Time picker widget
- Datetime kombinasi

---

#### **3.2.7 Summernote**

**Path:** `public/lte/plugins/summernote/summernote-bs4.min.js`

**Fungsi:**
- Rich text editor initialization
- Toolbar actions (bold, italic, link, image)
- Content formatting

---

### 3.3 External JavaScript (CDN)

#### **3.3.1 CKEditor**

**URL:** `https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js`

**Fungsi:**
- Rich text editor (alternative dari Summernote)
- Digunakan untuk input konten berita
- Classic editor build

---

## 4. ASSET IMAGES & LOGO

### 4.1 Logo P3M

**📄 File:** `public/mte/assets/img/Pusat_Penelitian.png`

**Lokasi Penggunaan:**
- Sidebar brand panel (logo bulat)
- Size: 54x54px dengan padding 5px

**HTML:**
```html
<img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M">
```

---

### 4.2 Favicon

**📁 Folder:** `public/favicon/`

| File | Fungsi |
|------|--------|
| **icon_log.ico** | Favicon utama di browser tab |
| **icon.png** | Icon PNG format |
| **politbang.ico** | Alternative icon Polibang |

**HTML:**
```html
<link rel="shortcut icon" href="{{ asset('favicon/icon_log.ico') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('favicon/icon_log.ico') }}" type="image/x-icon">
```

---

### 4.3 Background Image

**📄 File:** `public/lte/dist/img/bg-admin.webp`

**Lokasi Penggunaan:**
- Background content-wrapper (area konten admin)
- Dengan overlay gradient untuk readability

**CSS:**
```css
body.p3m-admin-redesign .content-wrapper {
    background-image: url('{{ asset('lte/dist/img/bg-admin.webp') }}');
    background-repeat: no-repeat;
    background-position: center top;
    background-size: cover;
    background-attachment: fixed;
}
```

---

### 4.4 Avatar/User Photos

**📁 Folder:** `public/lte/dist/img/`

**Default Avatars:**
- `avatar.png`, `avatar2.png`, `avatar3.png`, `avatar4.png`, `avatar5.png`
- `default-150x150.png` - Placeholder default

**📁 Folder Upload:** `storage/app/public/photo-user/`

**User Uploaded Photos:**
- `{user_id}_{timestamp}.jpg/png` - Foto profil admin yang diupload
- Linked via: `{{ asset('storage/photo-user/'.$user->image) }}`

---

### 4.5 AdminLTE Sample Images

**📁 Folder:** `public/lte/dist/img/`

| File | Fungsi |
|------|--------|
| `AdminLTELogo.png` | Logo AdminLTE (tidak digunakan) |
| `user1-128x128.jpg` ... `user8-128x128.jpg` | Sample user avatars |
| `photo1.png`, `photo2.png`, dll | Sample content images |
| `boxed-bg.jpg`, `boxed-bg.png` | Background patterns |
| `icons.png` | Icon sprite |

**Status:** Sebagian besar tidak digunakan di project P3M, hanya bawaan AdminLTE template.

---

## 5. FONTS

### 5.1 Google Fonts (CDN)

**URL:** 
```
https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap
```

**Font Families:**

#### **Inter**
- **Weights:** 400, 500, 600, 700, 800, 900
- **Digunakan untuk:**
  - Body text
  - Paragraph
  - Label form
  - Table content
  - Breadcrumb
  - Dropdown menu

**CSS:**
```css
--admin-font: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
```

---

#### **Plus Jakarta Sans**
- **Weights:** 600, 700, 800, 900
- **Digunakan untuk:**
  - Page headings (h1, h2, h3)
  - Card titles
  - Menu items
  - Button text
  - Brand name di sidebar

**CSS:**
```css
--admin-heading-font: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
```

---

### 5.2 Icon Font (FontAwesome)

**Path:** `public/lte/plugins/fontawesome-free/`

**Version:** FontAwesome Free 5.x

**Styles Available:**
- **Solid (fas)** - Icon padat
- **Regular (far)** - Icon outline
- **Brands (fab)** - Logo brand

**Total Icons:** 1,600+ icons

**Contoh Penggunaan:**
```html
<!-- Solid Icons -->
<i class="fas fa-home"></i>
<i class="fas fa-users"></i>
<i class="fas fa-newspaper"></i>

<!-- Regular Icons -->
<i class="far fa-bell"></i>
<i class="far fa-calendar-alt"></i>

<!-- Navigation Icons -->
<i class="nav-icon fas fa-home"></i>
<i class="nav-icon fas fa-id-card-alt"></i>
<i class="nav-icon fas fa-layer-group"></i>
```

---

## 6. EXTERNAL LIBRARIES

### 6.1 CKEditor 5

**CDN URLs:**
```html
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.0/ckeditor5.css">
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
```

**Fungsi:**
- Rich text editor untuk input konten
- Alternative dari Summernote
- Classic build dengan toolbar lengkap

**Features:**
- Bold, Italic, Underline
- Heading styles
- Lists (bullet, numbered)
- Links
- Block quotes
- Image upload
- Table

---

### 6.2 Google Fonts

**CDN URL:**
```html
<link href="https://fonts.googleapis.com" rel="preconnect">
<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">
```

**Optimization:**
- Preconnect untuk faster loading
- Display swap untuk prevent FOIT

---

## 7. STRUKTUR UI ADMIN PANEL

### 7.1 Header/Topbar

**Lokasi Code:** `resources/views/layout/main.blade.php` line 896-946

**HTML Structure:**
```html
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav align-items-center">
        <!-- Left side -->
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item">
            <div class="topbar-title">
                <strong>Dashboard P3M</strong>
                <span>Panel pengelola website</span>
            </div>
        </li>
    </ul>
    
    <ul class="navbar-nav ml-auto align-items-center">
        <!-- Right side -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-globe"></i> Lihat Website
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge"></span>
            </a>
            <!-- Dropdown menu -->
        </li>
    </ul>
</nav>
```

**Komponen:**

| Elemen | Deskripsi | CSS Class |
|--------|-----------|-----------|
| **Hamburger Menu** | Toggle sidebar | `.nav-link[data-widget="pushmenu"]` |
| **Title Area** | "Dashboard P3M" + subtitle | `.topbar-title` |
| **Link Website** | External link ke frontend | `.nav-link` |
| **Notifikasi** | Bell icon + badge counter | `.dropdown` |
| **Badge** | Red dot indicator | `.navbar-badge` |

**Styling:**
- Height: 72px
- Background: rgba(255,255,255,.92) dengan blur
- Border bottom: 1px solid hijau P3M
- Shadow: subtle untuk depth

---

### 7.2 Sidebar Kiri

**Lokasi Code:** `resources/views/layout/main.blade.php` line 948-1100+

#### **7.2.1 Brand Panel (Logo Area)**

**HTML:**
```html
<a href="{{ route('dash.dashadmin') }}" class="brand-panel">
    <img src="{{ asset('mte/assets/img/Pusat_Penelitian.png') }}" alt="Logo P3M">
    <span>
        <strong>P3M Polibang</strong>
        <span>Admin Panel</span>
    </span>
</a>
```

**Styling:**
- Logo: 54x54px, rounded, white background
- Font: Plus Jakarta Sans, 19px, bold
- Subtitle: 11px, uppercase, letter-spacing

---

#### **7.2.2 User Panel (Profil Admin)**

**HTML:**
```html
<div class="user-panel mt-3 pb-3 mb-2 d-flex">
    <div class="image">
        @if($avatarExists)
            <img src="{{ asset($avatarPath) }}" class="img-circle elevation-2">
        @else
            <div class="admin-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
    </div>
    <div class="info">
        <a href="#" class="d-block">{{ $user->name }}</a>
        <span class="user-role">{{ $user->role ?? 'Admin' }}</span>
    </div>
</div>
```

**Komponen:**
- Avatar image (46x46px) atau initial placeholder
- Nama admin (14px, bold)
- Role badge (11px, opacity .6)

---

#### **7.2.3 Sidebar Search**

**HTML:**
```html
<div class="form-inline">
    <div class="input-group">
        <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu...">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>
```

**Fungsi:**
- Filter menu berdasarkan keyword
- Real-time search
- Case insensitive

---

#### **7.2.4 Navigation Menu**

**HTML Structure:**
```html
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
        <!-- Menu Item dengan Submenu -->
        <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    Home
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Admin</p>
                    </a>
                </li>
            </ul>
        </li>
        
        <!-- Menu Item Tunggal -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</nav>
```

**Menu Hierarchy:**

```
📁 HOME
├── 📄 Dashboard
└── 👤 Admin

📁 PROFIL
├── 👥 Pengelola P3M
├── ℹ️ Tentang P3M
└── 📖 Panduan P3M

📁 KONTEN WEBSITE
├── 🏷️ Kategori Berita
├── 📰 Kegiatan P3M
├── 📅 Agenda
├── 📁 Dokumen
└── 📚 Jurnal

📁 PENELITIAN
├── 📝 Proposal Penelitian
└── 📊 Laporan Penelitian

📁 PENGABDIAN
├── 📝 Proposal Pengabdian
└── 📊 Laporan Pengabdian

⚙️ PENGATURAN
└── 🚪 Logout
```

**CSS Classes:**

| Class | State | Styling |
|-------|-------|---------|
| `.nav-item` | Container | Margin bottom 6px |
| `.nav-link` | Link default | Min-height 46px, rgba white .88 |
| `.nav-link:hover` | Hover state | Background rgba white .09 |
| `.nav-link.active` | Active menu | Background white .96, shadow |
| `.nav-icon` | Icon | Width 22px, font-size 15px |
| `.menu-open` | Expanded state | Submenu visible |
| `.nav-treeview` | Submenu container | Padding left 10px |

---

### 7.3 Content Area

**Lokasi Code:** `resources/views/layout/main.blade.php` + child views

**HTML Structure:**
```html
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Page Title</h1>
                </div>
                <div class="col-sm-5">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Current Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </section>
</div>
```

**Komponen:**

#### **7.3.1 Content Header**
- Page title (h1)
- Breadcrumb navigation
- Padding: 28px 44px 12px

#### **7.3.2 Main Content**
- Container untuk halaman child
- Padding: 12px 44px 36px
- Background: image + gradient overlay

---

### 7.4 Komponen UI Umum

#### **7.4.1 Card**

**HTML:**
```html
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Card Title</h3>
        <div class="card-tools">
            <button class="btn btn-tool">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        Card content here
    </div>
</div>
```

**Styling:**
- Border radius: 24px
- Shadow: 0 16px 50px rgba(19, 74, 45, .08)
- Border: 1px solid rgba(20, 91, 54, .08)
- Background: rgba(255,255,255,.94)

---

#### **7.4.2 Button**

**HTML:**
```html
<button class="btn btn-primary">
    <i class="fas fa-save"></i> Simpan
</button>

<button class="btn btn-success">
    <i class="fas fa-plus"></i> Tambah
</button>

<button class="btn btn-danger">
    <i class="fas fa-trash"></i> Hapus
</button>
```

**Styling:**
- Primary/Success: Gradient green, shadow
- Danger: Light red background
- Min-height: 42px
- Border radius: 13px
- Font weight: 800

---

#### **7.4.3 Form Control**

**HTML:**
```html
<div class="form-group">
    <label>Label</label>
    <input type="text" class="form-control" placeholder="Placeholder">
</div>

<div class="form-group">
    <label>Select</label>
    <select class="custom-select">
        <option>Option 1</option>
        <option>Option 2</option>
    </select>
</div>
```

**Styling:**
- Min-height: 42px
- Border radius: 12px
- Border color: #dfe9e3
- Focus: Border hijau + shadow

---

#### **7.4.4 Table**

**HTML:**
```html
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Data 1</td>
            <td>
                <button class="btn btn-sm btn-primary">Edit</button>
                <button class="btn btn-sm btn-danger">Hapus</button>
            </td>
        </tr>
    </tbody>
</table>
```

**Styling:**
- Header: Background #f0f8f3, uppercase, font-size 11px
- Border: #edf2ef
- Hover row: Background #fbfefc
- Padding: 16px 15px

---

#### **7.4.5 Badge**

**HTML:**
```html
<span class="badge badge-success">Approved</span>
<span class="badge badge-primary">Pending</span>
<span class="badge badge-danger">Rejected</span>
```

**Styling:**
- Success: #e7f8ee background, #087744 text
- Primary: #edf5ff background, #0b65cf text
- Danger: #fff1f2 background, #ef3340 text

---

## 8. COLOR SCHEME & DESIGN SYSTEM

### 8.1 Brand Colors (P3M Theme)

**Primary Greens:**
```css
--p3m-green-900: #006b3c;  /* Darkest - Logo, headings */
--p3m-green-800: #087844;  /* Dark - Buttons, links */
--p3m-green-700: #0a8f52;  /* Medium - Buttons hover */
--p3m-green-600: #16a765;  /* Light - Accents */
```

**Neutral Greens:**
```css
--p3m-green-100: #e9f8ef;  /* Very light - Backgrounds */
--p3m-green-050: #f4fbf7;  /* Ultra light - Surfaces */
```

**Text Colors:**
```css
--p3m-text: #17221d;       /* Body text */
--p3m-muted: #66756d;      /* Secondary text */
```

**UI Colors:**
```css
--p3m-line: #e5eee9;       /* Borders */
--p3m-danger: #ef4444;     /* Error, delete */
```

---

### 8.2 Semantic Colors

**Success (Approved):**
- Background: `#e7f8ee`
- Text: `#087744`
- Border: `#c4ead4`

**Primary (Pending):**
- Background: `#edf5ff`
- Text: `#0b65cf`
- Border: `#d0e7ff`

**Danger (Rejected):**
- Background: `#fff1f2`
- Text: `#ef3340`
- Border: `#ffd2d8`

**Warning (Review):**
- Background: `#fff7ed`
- Text: `#ea580c`
- Border: `#fed7aa`

---

### 8.3 Typography Scale

**Font Families:**
```css
--admin-font: "Inter", system-ui, sans-serif;
--admin-heading-font: "Plus Jakarta Sans", "Inter", system-ui, sans-serif;
```

**Font Sizes:**
| Element | Size | Weight | Line Height |
|---------|------|--------|-------------|
| Page Title (h1) | 36px | 900 | 1.2 |
| Section Title (h2) | 28px | 850 | 1.3 |
| Subsection (h3) | 22px | 850 | 1.4 |
| Card Title | 18px | 850 | 1.4 |
| Body Text | 14px | 400 | 1.6 |
| Small Text | 12px | 600 | 1.5 |
| Caption | 11px | 700 | 1.4 |

**Font Weights:**
- Normal: 400
- Medium: 500, 600
- Bold: 700, 800
- Extra Bold: 850, 900

---

### 8.4 Spacing System

**Base Unit:** 4px

**Spacing Scale:**
```
4px   (spacing-1)
8px   (spacing-2)
12px  (spacing-3)
16px  (spacing-4)
20px  (spacing-5)
24px  (spacing-6)
28px  (spacing-7)
32px  (spacing-8)
44px  (spacing-11)
```

**Common Uses:**
- Card padding: 24px 26px
- Section padding: 28px 44px
- Button padding: 9px 16px
- Gap between cards: 16px
- Margin bottom: 18px

---

### 8.5 Border Radius

**Radius Scale:**
```css
--radius-sm: 12px;   /* Form controls, small cards */
--radius-md: 16px;   /* Buttons, menu items */
--radius-lg: 18px;   /* User panel */
--radius-xl: 24px;   /* Cards, main surfaces */
--radius-2xl: 30px;  /* Sidebar corners */
--radius-full: 999px; /* Avatar, badges */
```

---

### 8.6 Shadows

**Shadow Levels:**

**Level 1 (Subtle):**
```css
box-shadow: 0 10px 22px rgba(5, 126, 68, .16);
/* Buttons, hover states */
```

**Level 2 (Medium):**
```css
box-shadow: 0 16px 50px rgba(19, 74, 45, .08);
/* Cards, content surfaces */
```

**Level 3 (Strong):**
```css
box-shadow: 0 12px 28px rgba(0, 0, 0, .10);
/* Active menu, modals */
```

**Level 4 (Header):**
```css
box-shadow: 0 10px 30px rgba(8, 65, 39, .06);
/* Header/topbar */
```

---

## 9. RESPONSIVE BREAKPOINTS

### 9.1 Media Query Breakpoints

**Bootstrap 4 Standard:**
```css
/* Extra Small (Mobile) */
@media (max-width: 575.98px) { }

/* Small (Mobile Landscape) */
@media (max-width: 767.98px) { }

/* Medium (Tablet) */
@media (max-width: 991.98px) { }

/* Large (Desktop) */
@media (min-width: 992px) { }

/* Extra Large (Large Desktop) */
@media (min-width: 1200px) { }
```

---

### 9.2 Mobile Adjustments (≤575px)

**Changes:**
```css
/* Background */
.content-wrapper {
    background-size: auto 100%; /* Fit height */
}

/* Header */
.topbar-title strong {
    font-size: 14px; /* Smaller title */
}

/* Cards */
.card {
    border-radius: 18px !important; /* Smaller radius */
}

.card-header,
.card-body {
    padding: 18px; /* Reduced padding */
}

/* Buttons */
.btn {
    width: 100%; /* Full width buttons */
}
```

---

### 9.3 Tablet Adjustments (≤991px)

**Changes:**
```css
/* Sidebar */
.main-sidebar {
    width: 290px !important; /* Narrower sidebar */
    border-radius: 0 24px 24px 0;
}

/* Header */
.main-header {
    height: 64px; /* Shorter header */
    min-height: 64px;
}

/* Content */
.content-header {
    padding: 22px 18px 10px; /* Reduced padding */
}

.content {
    padding: 10px 18px 28px;
}

/* Sidebar Behavior */
.sidebar-collapse .main-sidebar {
    margin-left: -290px; /* Hide off-screen */
}
```

---

### 9.4 Desktop Adjustments (≥992px)

**Changes:**
```css
/* Sidebar Width */
.main-sidebar {
    width: 318px !important;
}

/* Content Offset */
.content-wrapper,
.main-footer {
    margin-left: 318px !important; /* Sidebar width */
}

/* Sidebar Collapsed State */
.sidebar-collapse .main-sidebar {
    width: 4.6rem !important; /* Mini sidebar */
}

.sidebar-collapse .content-wrapper {
    margin-left: 4.6rem !important;
}
```

---

## 10. REKOMENDASI

### 10.1 Optimasi Performance

#### **CSS Optimization**

**Current Issues:**
- ❌ Inline CSS di `main.blade.php` (±900 baris)
- ❌ Multiple CSS files loaded

**Rekomendasi:**
1. ✅ Extract inline CSS ke file terpisah
   ```
   public/css/admin-custom.css
   ```

2. ✅ Minify CSS untuk production
   ```bash
   npm run prod
   ```

3. ✅ Combine CSS files dengan Laravel Mix
   ```javascript
   // webpack.mix.js
   mix.styles([
       'public/lte/dist/css/adminlte.min.css',
       'public/lte/plugins/fontawesome-free/css/all.min.css',
       'public/css/admin-custom.css'
   ], 'public/css/admin-all.min.css');
   ```

---

#### **JavaScript Optimization**

**Current Issues:**
- ❌ Multiple JS files loaded
- ❌ Unused plugins loaded

**Rekomendasi:**
1. ✅ Combine JS files
   ```javascript
   // webpack.mix.js
   mix.scripts([
       'public/lte/plugins/jquery/jquery.min.js',
       'public/lte/plugins/bootstrap/js/bootstrap.bundle.min.js',
       'public/lte/dist/js/adminlte.min.js'
   ], 'public/js/admin-all.min.js');
   ```

2. ✅ Lazy load plugins yang jarang digunakan
   ```html
   @if($needsDatePicker)
       <script src="{{ asset('lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
   @endif
   ```

---

#### **Image Optimization**

**Rekomendasi:**
1. ✅ Compress background image
   ```
   bg-admin.webp (current)
   → optimize dengan TinyPNG/Squoosh
   → target size: <200KB
   ```

2. ✅ Use responsive images
   ```html
   <img srcset="logo-150w.png 150w, logo-300w.png 300w" 
        sizes="(max-width: 768px) 150px, 300px" 
        src="logo-300w.png">
   ```

3. ✅ Lazy load images
   ```html
   <img src="placeholder.jpg" data-src="actual-image.jpg" loading="lazy">
   ```

---

### 10.2 Code Organization

#### **Separate Layout Files**

**Current:**
```
resources/views/layout/
└── main.blade.php (1300+ lines)
```

**Recommended:**
```
resources/views/layout/
├── master.blade.php        (HTML structure)
├── partials/
│   ├── head.blade.php      (CSS, meta tags)
│   ├── header.blade.php    (Topbar)
│   ├── sidebar.blade.php   (Sidebar menu)
│   ├── footer.blade.php    (Footer jika ada)
│   └── scripts.blade.php   (JavaScript)
└── admin.blade.php         (Extends master)
```

**Benefits:**
- ✅ Easier maintenance
- ✅ Reusable components
- ✅ Better version control (smaller diffs)

---

#### **CSS File Structure**

**Recommended:**
```
public/css/
├── admin/
│   ├── variables.css       (CSS variables)
│   ├── base.css            (Reset, typography)
│   ├── layout.css          (Header, sidebar, content)
│   ├── components.css      (Card, button, form)
│   ├── utilities.css       (Spacing, colors)
│   └── responsive.css      (Media queries)
└── admin.css               (Import all)
```

---

### 10.3 Accessibility Improvements

#### **Current Issues:**
- ⚠️ Missing ARIA labels di beberapa button
- ⚠️ Color contrast ratio bisa ditingkatkan
- ⚠️ Keyboard navigation belum optimal

#### **Rekomendasi:**

1. ✅ **Add ARIA Labels**
   ```html
   <button data-widget="pushmenu" aria-label="Toggle sidebar">
       <i class="fas fa-bars"></i>
   </button>
   
   <a href="#" class="nav-link" aria-label="Notifikasi">
       <i class="far fa-bell"></i>
   </a>
   ```

2. ✅ **Improve Color Contrast**
   ```css
   /* Current: rgba(226, 232, 240, .68) */
   /* Recommended: rgba(226, 232, 240, .85) */
   
   .nav-sidebar .nav-link {
       color: rgba(226, 232, 240, .85) !important; /* Better contrast */
   }
   ```

3. ✅ **Keyboard Navigation**
   ```css
   /* Add focus states */
   .nav-link:focus {
       outline: 2px solid var(--p3m-green-600);
       outline-offset: 2px;
   }
   
   .btn:focus {
       box-shadow: 0 0 0 3px rgba(10, 143, 82, .25);
   }
   ```

4. ✅ **Skip Navigation Link**
   ```html
   <a href="#main-content" class="skip-link">Skip to main content</a>
   ```

---

### 10.4 Dark Mode Support

**Preparation untuk future dark mode:**

1. ✅ **CSS Variables Structure**
   ```css
   /* Light mode (default) */
   :root {
       --color-bg: #f7fbf8;
       --color-text: #17221d;
       --color-surface: #ffffff;
   }
   
   /* Dark mode */
   @media (prefers-color-scheme: dark) {
       :root {
           --color-bg: #0f1712;
           --color-text: #e8efe9;
           --color-surface: #1a221c;
       }
   }
   
   /* Manual toggle */
   [data-theme="dark"] {
       --color-bg: #0f1712;
       --color-text: #e8efe9;
       --color-surface: #1a221c;
   }
   ```

2. ✅ **Toggle Button**
   ```html
   <button onclick="toggleTheme()" aria-label="Toggle dark mode">
       <i class="fas fa-moon"></i>
   </button>
   ```

---

### 10.5 Browser Support

**Current Support:**
- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+

**Features yang butuh polyfill:**
- CSS `backdrop-filter` (untuk blur effect)
- CSS custom properties (untuk IE11 jika perlu)

**Recommended:**
```html
<!-- Add autoprefixer via Laravel Mix -->
<script src="https://cdn.jsdelivr.net/npm/css-vars-ponyfill@2"></script>
```

---

### 10.6 Documentation

**Create Component Library:**

```markdown
docs/
├── components/
│   ├── buttons.md          (Button variants)
│   ├── forms.md            (Form controls)
│   ├── cards.md            (Card layouts)
│   ├── tables.md           (Table styles)
│   └── badges.md           (Badge colors)
├── layouts/
│   ├── header.md           (Header structure)
│   ├── sidebar.md          (Sidebar menu)
│   └── content.md          (Content area)
└── design-system.md        (Colors, typography, spacing)
```

**Benefits:**
- ✅ Konsistensi UI
- ✅ Faster development
- ✅ Onboarding developer baru

---

## 📊 SUMMARY

### File Count

| Kategori | Jumlah File | Total Size |
|----------|-------------|------------|
| **Blade Templates** | 1 master + 50+ child | ~500 KB |
| **CSS Files** | 15+ plugin files | ~3 MB |
| **JS Files** | 20+ plugin files | ~5 MB |
| **Images** | 30+ files | ~2 MB |
| **Fonts** | 2 families (CDN) | External |

### Key Files

**Must-Have Files:**
1. ✅ `resources/views/layout/main.blade.php` - Layout master
2. ✅ `public/lte/dist/css/adminlte.min.css` - Core CSS
3. ✅ `public/lte/dist/js/adminlte.min.js` - Core JS
4. ✅ `public/lte/plugins/fontawesome-free/` - Icons
5. ✅ `public/mte/assets/img/Pusat_Penelitian.png` - Logo

**Optional (dapat di-lazy load):**
- CKEditor (hanya untuk halaman dengan rich text editor)
- DateRangePicker (hanya untuk halaman dengan date filter)
- Chart.js (hanya untuk dashboard dengan grafik)

---

## 🎯 ACTION ITEMS

### Priority 1 (Performance)
- [ ] Extract inline CSS ke file terpisah
- [ ] Minify & combine CSS files
- [ ] Minify & combine JS files
- [ ] Compress background image

### Priority 2 (Code Quality)
- [ ] Split `main.blade.php` ke partial files
- [ ] Remove unused AdminLTE plugins
- [ ] Create reusable components
- [ ] Add code comments

### Priority 3 (Accessibility)
- [ ] Add ARIA labels
- [ ] Improve color contrast
- [ ] Add keyboard navigation
- [ ] Add skip navigation link

### Priority 4 (Future)
- [ ] Prepare dark mode structure
- [ ] Create component library docs
- [ ] Add unit tests untuk JavaScript
- [ ] Setup automated screenshot testing

---

## 📞 KONTAK & REFERENSI

**Project Location:**
```
c:\laragon\www\p3m\
```

**Key Documentation:**
- AdminLTE: https://adminlte.io/docs/3.2/
- Laravel Blade: https://laravel.com/docs/10.x/blade
- FontAwesome: https://fontawesome.com/icons
- Bootstrap 4: https://getbootstrap.com/docs/4.6/

**Developer Notes:**
- Semua perubahan styling sebaiknya dilakukan di `main.blade.php` section `@yield('css')`
- Jangan edit langsung file di `public/lte/` karena akan hilang saat update AdminLTE
- Gunakan `asset()` helper untuk semua path file
- Test responsive di Chrome DevTools (F12 → Toggle Device Toolbar)

---

**Laporan dibuat:** 10 September 2026  
**Versi:** 1.0  
**Status:** ✅ Complete

---

## APPENDIX A: File Tree Frontend

```
resources/views/layout/
└── main.blade.php              (1300+ lines - Layout master)

public/
├── lte/
│   ├── dist/
│   │   ├── css/
│   │   │   ├── adminlte.min.css       (Core CSS)
│   │   │   └── adminlte.css
│   │   ├── js/
│   │   │   ├── adminlte.min.js        (Core JS)
│   │   │   └── adminlte.js
│   │   └── img/
│   │       ├── bg-admin.webp          (Background)
│   │       ├── avatar.png
│   │       └── default-150x150.png
│   └── plugins/
│       ├── fontawesome-free/          (Icons)
│       ├── bootstrap/                 (Grid, components)
│       ├── jquery/                    (Base library)
│       ├── overlayScrollbars/         (Custom scrollbar)
│       ├── daterangepicker/           (Date picker)
│       ├── summernote/                (Rich text editor)
│       └── [20+ other plugins]
├── mte/
│   └── assets/
│       └── img/
│           └── Pusat_Penelitian.png   (Logo P3M)
├── favicon/
│   ├── icon_log.ico                   (Favicon)
│   └── icon.png
└── storage/
    └── photo-user/                    (User avatars)
```

---

## APPENDIX B: CSS Classes Quick Reference

### Layout Classes
```css
.wrapper                    /* Main wrapper */
.main-header               /* Topbar */
.main-sidebar              /* Sidebar kiri */
.content-wrapper           /* Content area */
.content-header            /* Page header */
.content                   /* Main content */
```

### Navigation Classes
```css
.nav-sidebar               /* Menu container */
.nav-item                  /* Menu item */
.nav-link                  /* Menu link */
.nav-link.active           /* Active menu */
.nav-treeview              /* Submenu */
.menu-open                 /* Expanded state */
```

### Component Classes
```css
.card                      /* Card container */
.card-header               /* Card header */
.card-body                 /* Card content */
.btn                       /* Button base */
.btn-primary               /* Primary button */
.form-control              /* Input field */
.table                     /* Table */
.badge                     /* Badge/label */
```

### Custom P3M Classes
```css
.p3m-admin-redesign        /* Body theme class */
.brand-panel               /* Logo area */
.user-panel                /* User profile */
.admin-avatar              /* Avatar placeholder */
.topbar-title              /* Header title */
.user-role                 /* Role badge */
```

---

## APPENDIX C: Color Palette

### Primary Colors
```
#006b3c - P3M Green 900 (Darkest)
#087844 - P3M Green 800 (Dark)
#0a8f52 - P3M Green 700 (Medium)
#16a765 - P3M Green 600 (Light)
```

### Neutral Colors
```
#17221d - Text Primary
#66756d - Text Secondary
#e5eee9 - Border
#f4fbf7 - Background Light
#ffffff - Surface White
```

### Semantic Colors
```
#e7f8ee - Success Background
#087744 - Success Text
#edf5ff - Info Background
#0b65cf - Info Text
#fff1f2 - Danger Background
#ef3340 - Danger Text
```

---

**END OF REPORT**
