<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portofolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fff4ec 0%, #ffe8d6 100%);
            min-height: 100vh;
            color: #1a1a1a;
        }

        /* Navbar */
        .navbar {
            background: #fff;
            border-bottom: 3px solid #ffb347;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(255, 140, 66, 0.08);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-size: 16px;
            font-weight: 600;
            color: #ff8c42;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-brand i {
            font-size: 18px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff7f0;
            border: 1px solid #fde0c8;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 13px;
            font-weight: 500;
            color: #ff8c42;
            cursor: pointer;
            transition: background 0.15s;
        }

        .user-btn:hover {
            background: #ffe8d6;
        }

        .user-btn i {
            font-size: 15px;
        }

        .dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #fff;
            border: 1px solid #fde0c8;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(255, 140, 66, 0.12);
            min-width: 160px;
            display: none;
            overflow: hidden;
        }

        .dropdown.show {
            display: block;
        }

        .dropdown a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            font-size: 13px;
            color: #e25c5c;
            text-decoration: none;
            transition: background 0.15s;
        }

        .dropdown a:hover {
            background: #fff3f3;
        }

        /* Content */
        .content {
            max-width: 680px;
            margin: 100px auto 0;
            padding: 2rem 1rem;
        }
        .avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff8c42, #ffb347);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            font-weight: 600;
            flex-shrink: 0;
            margin: 0 auto
        }

        .icon-green {
            background: #f0fff4;
            color: #2ecc71;
        }

        .icon-blue {
            background: #eef4ff;
            color: #4f8ef7;
        }

        .icon-orange {
            background: #fff7f0;
            color: #ff8c42;
        }

    

        /* 2 kolom */
.team {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 20px;
}

/* card profile */
.profile-card {
    background: #fff;
    border: 1px solid #fde0c8;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(255, 140, 66, 0.06);
    text-align: center;
}

.profile-card h3 {
    margin: 10px 0;
    font-size: 15px;
}

/* row data */
.profile-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    padding: 6px 0;
    border-bottom: 1px solid #f5f5f5;
}

.profile-row:last-child {
    border-bottom: none;
}

/* carousel */
.my-carousel-card {
    background: #fff;
    border: 1px solid #fde0c8;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(255, 140, 66, 0.06);
    text-align: center;
}



.slide-title {
    font-size: 14px;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 2px;
}

.desc.clamp {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.desc.clamp.expanded {
    -webkit-line-clamp: unset;
    display: block;
}

.read-more-btn {
    background: none;
    border: none;
    color: #ff8c42;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    padding: 0;
    margin-top: 4px;
    text-decoration: underline;
}
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">
          
        </div>
        <div class="navbar-right">
            <button class="user-btn" onclick="toggleDropdown()">
                <i class="fa fa-user-circle"></i>
                <?= htmlspecialchars($_SESSION['username']) ?>
                <i class="fa fa-chevron-down" style="font-size:10px;"></i>
            </button>
            <div class="dropdown" id="dropdown">
                <a href="logout.php"><i class="fa fa-right-from-bracket"></i> Logout</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="content">
<div class="team">
    <!-- ORANG 1 -->
    <div class="profile-card">
        <div class="avatar">Y</div>
        <h3>Yanuar Abimanyu</h3>

        <div class="profile-row">
            <span>NIM</span>
            <strong>243026017</strong>
        </div>
        <div class="profile-row">
            <span>Prodi</span>
            <strong>Sistem Informasi</strong>
        </div>
        <div class="profile-row">
            <span>Fakultas</span>
            <strong>Sains dan Teknologi</strong>
        </div>
         <div class="profile-row">
            <span>Universitas</span>
            <strong>Universitas Pignatelli Triputra</strong>
        </div>
    </div>

    <!-- ORANG 2 -->
    <div class="profile-card">
        <div class="avatar">A</div>
        <h3>Angello Giovanida Anthony</h3>

        <div class="profile-row">
            <span>NIM</span>
            <strong>243026006</strong>
        </div>
      <div class="profile-row">
            <span>Prodi</span>
            <strong>Sistem Informasi</strong>
        </div>
        <div class="profile-row">
            <span>Fakultas</span>
            <strong>Sains dan Teknologi</strong>
        </div>
         <div class="profile-row">
            <span>Universitas</span>
            <strong>Universitas Pignatelli Triputra</strong>
        </div>
    </div>
</div>

<!-- CAROUSEL -->
<div class="my-carousel-card">
    <h3>Achievement</h3>

    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">

            <!-- SLIDE 1 -->
            <div class="carousel-item active text-center">
                <img src="../image/YISF2025.jpeg" class="d-block w-100 rounded">
                <p class="mt-2 slide-title">YISF 2025</p>
                <p class="mt-1 desc clamp" id="desc-1">Kegiatan diskusi kelompok saat mengerjakan project bersama. Kami berdiskusi untuk menentukan pembagian tugas dan alur pengerjaan agar project dapat diselesaikan tepat waktu sesuai target yang telah ditetapkan.</p>
                <button class="read-more-btn" onclick="toggleDesc('desc-1', this)">Baca selengkapnya ▾</button>
            </div>

            <!-- SLIDE 2 -->
            <div class="carousel-item text-center">
                <img src="../image/YISF2026.jpeg" class="d-block w-100 rounded">
                <p class="mt-2 slide-title">YISF 2026</p>
                <p class="mt-1 desc clamp" id="desc-2">Presentasi hasil kerja di depan kelas sebagai bentuk pertanggungjawaban atas project yang dikerjakan. Setiap anggota tim menjelaskan bagian masing-masing dan menjawab pertanyaan dari dosen maupun teman-teman.</p>
                <button class="read-more-btn" onclick="toggleDesc('desc-2', this)">Baca selengkapnya ▾</button>
            </div>

            <!-- SLIDE 3 -->
            <div class="carousel-item text-center">
                <img src="../image/Krenova.jpeg" class="d-block w-100 rounded">
                <p class="mt-2 slide-title">Krenova</p>
                <p class="mt-1 desc" id="desc-3">Dokumentasi kegiatan bersama seluruh anggota tim.</p>
            </div>

               <!-- SLIDE 4 -->
            <div class="carousel-item text-center">
                <img src="../image/AISEFF2025.jpg" class="d-block w-100 rounded">
                <p class="mt-2 slide-title">AISEFF 2025</p>
                <p class="mt-1 desc" id="desc-3">Dokumentasi kegiatan bersama seluruh anggota tim.</p>
            </div>

        </div>
    </div>
</div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('show');
        }
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.navbar-right')) {
                document.getElementById('dropdown').classList.remove('show');
            }
        });

        function toggleDesc(id, btn) {
            const el = document.getElementById(id);
            const isExpanded = el.classList.toggle('expanded');
            btn.textContent = isExpanded ? 'Sembunyikan ▴' : 'Baca selengkapnya ▾';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>