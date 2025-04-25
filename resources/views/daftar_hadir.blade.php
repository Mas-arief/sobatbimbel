<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Kehadiran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: #1F1AA1;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .logo-sb-icon {
            font-size: 1.8em;
            margin-right: 5px;
        }

        .logo-text {
            font-weight: bold;
            font-size: 1.2em;
        }

        .greeting-text {
            font-size: 1.5em;
            font-weight: bold;
        }

        .user-icon {
            font-size: 2em;
        }

        .main-header {
            padding: 20px;
        }

        .main-title {
            font-size: 2.2em;
            font-weight: bold;
            color: #333;
        }

        .d-flex {
            display: flex;
            margin: 0 20px 20px 20px;
        }

        .sidebar {
            background-color: #1F1AA1;
            color: white;
            width: 250px;
            border-radius: 25px 0 0 25px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        .sidebar-header {
            margin-bottom: 30px;
            text-align: center;
            width: 100%;
        }

        .sidebar-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 20px;
            line-height: 30px;
            color: #FFFFFF;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: background-color 0.2s ease;
            width: 100%;
            text-align: left;
        }

        .sidebar-nav a:hover {
            background-color: #343a40;
        }

        .sidebar-nav a.active {
            background-color: #f39c12;
            color: white;
            font-weight: bold;
        }

        .nav-item-icon {
            background-color: white;
            width: 23px;
            height: 23px;
            border-radius: 50%;
            margin-right: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #1F1AA1;
        }

        .nav-item-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 20px;
            color: #FFFFFF;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .attendance-card {
            width: 100%;
            max-width: 915px;
            background-color: #CCC9C9;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
        }

        .row {
            display: flex;
            border-bottom: 2px solid white;
            height: 40px;
            align-items: center;
            font-size: 16px;
            font-weight: 600;
        }

        .cell {
            text-align: center;
            flex: 1;
            border-right: 2px solid white;
        }

        .cell.mapel {
            flex: 2;
            text-align: left;
            padding-left: 20px;
        }

        .row:last-child {
            border: none;
        }

        .cell:last-child {
            border: none;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-left">
            <div class="logo-container">
                <img src="{{ asset('images/sb-ptih-pnjg.png') }}" alt="images" style="height: 50px;">
            </div>
            <h2 class="greeting-text">HAI, SISWA!</h2>
        </div>
        <div class="user-icon"><i class="fa-regular fa-user"></i></div>
    </div>

    <div class="main-header">
        <h1 class="main-title">DAFTAR HADIR</h1>
    </div>

    <div class="d-flex">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h3 class="sidebar-title">SISTEM INFORMASI<br>SISWA/I SOBAT BIMBEL</h3>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('profil_siswa') }}" class="nav-item">
                    <div class="nav-item-icon"><i class="fa-solid fa-user"></i></div>
                    <span class="nav-item-text">PROFIL</span>
                </a>
                <a href="{{ route('daftar_hadir') }}" class="nav-item active">
                    <div class="nav-item-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <span class="nav-item-text">DAFTAR HADIR</span>
                </a>
                <a href="{{ route('nilai_siswa') }}" class="nav-item">
                    <div class="nav-item-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <span class="nav-item-text">NILAI</span>
                </a>
                <a href="{{ route('kursus_siswa') }}" class="nav-item">
                    <div class="nav-item-icon"><i class="fa-solid fa-book"></i></div>
                    <span class="nav-item-text">KURSUS</span>
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="attendance-card">
                <h4>DAFTAR HADIR</h4>
                <div class="row">
                    <div class="cell mapel">Mapel</div>
                    @for ($i = 1; $i <= 16; $i++)
                        <div class="cell">{{ $i }}</div>
                    @endfor
                </div>

                {{-- Contoh Baris Kosong Untuk 3 Mapel --}}
                @foreach (['Bahasa Indonesia', 'Bahasa Inggris', 'Matematika'] as $mapel)
                    <div class="row">
                        <div class="cell mapel">{{ $mapel }}</div>
                        @for ($i = 1; $i <= 16; $i++)
                            <div class="cell">-</div>
                        @endfor
                    </div>
                @endforeach
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
