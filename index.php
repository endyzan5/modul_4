<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Three Brother Law</title>
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="image" href="./assets/img/banner.webp" fetchpriority="high">
  <link rel="stylesheet" href="./public/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- CSS utama -->
  <link rel="preload" href="./public/output.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="./public/output.css"></noscript>
  <!-- Font Awesome -->
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>


  <style>
    body { font-family: sans-serif; background-color: #fff; color: #333; margin:0; }
	  header { position:fixed; top:0; width:100%; background:#fff; z-index:50; }
	  .hero { min-height:600px; display:flex; align-items:center; justify-content:center; }
    /* Animasi Hero */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .animate-fade-in-up {
      animation: fadeInUp 1s ease-out forwards;
    }

    /* 🔧 Responsif Khusus untuk HP ≤ 400px */
    @media (max-width: 400px) {
      h1 {
        font-size: 1.8rem; /* ~29px */
        line-height: 2.2rem;
      }
      h2 {
        font-size: 1.25rem; /* ~20px */
      }
      p {
        font-size: 0.9rem;
        line-height: 1.4rem;
      }
      .container {
        padding-left: 1rem;
        padding-right: 1rem;
      }
      .hero-buttons a {
        display: block;
        width: 100%;
        margin-bottom: 0.75rem;
      }
      nav a {
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
      }
      img {
        max-width: 100%;
        height: auto;
      }
      .w-28 {
        width: 5rem !important;
        height: 4.5rem !important;
      }
    }
    /* 🔧 Responsif tambahan untuk layar 401px - 430px */
    @media (max-width: 430px) {
      .hero-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem; /* jarak antar tombol */
      }

      .hero-buttons a {
        width: 100%;
        max-width: 280px;
        margin: 0 auto;
        display: block;
      }

      h1 {
        font-size: 2rem;
      }

      p {
        font-size: 1rem;
      }
    }
    @font-face {
      font-family: 'Font Awesome 6 Free';
      font-display: swap;
    }
    @font-face {
      font-family: 'Font Awesome 6 Brands';
      font-display: swap;
    }

  </style>
</head>
<body class="font-sans bg-white text-gray-800">

  <!-- Navbar -->
  <header class="fixed w-full bg-white shadow z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <!-- Logo -->
      <div class="flex items-center space-x-2">
        <a href="index.php" class="flex items-center space-x-2">
          <img src="./assets/img/logo.webp" alt="Logo Three Brother Law" class="w-10 h-10">
        </a>
      </div>

      <!-- Menu -->
      <nav
        id="menu"
        class="absolute top-16 left-0 w-full bg-white shadow-md flex flex-col items-center space-y-4 py-4 transform scale-y-0 origin-top transition-transform duration-300 md:transform-none md:scale-y-100 md:flex md:flex-row md:space-y-0 md:space-x-6 md:static md:bg-transparent md:shadow-none md:justify-center flex-1"
      >
        <a href="#about" class="py-2 px-6 hover:text-gray-900 transition">Tentang Kami</a>
        <a href="#services" class="py-2 px-6 hover:text-gray-900 transition">Layanan</a>
        <a href="#testimony" class="py-2 px-6 hover:text-gray-900 transition">Testimoni</a>
        <a href="#contact" class="py-2 px-6 hover:text-gray-900 transition">Lokasi</a>
        <a href="#contact" class="py-2 px-6 hover:text-gray-900 transition">Kontak</a>

        <!-- Tombol login/daftar di mobile -->
        <div class="flex flex-col space-y-2 md:hidden w-4/5 text-center">
          <a href="login.php" class="px-4 py-2 border rounded hover:bg-gray-100 transition">Masuk</a>
          <a href="register.php" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">Daftar</a>
        </div>
      </nav>

      <!-- Tombol hamburger -->
      <button id="menu-btn" aria-label="Buka menu navigasi" class="md:hidden text-2xl focus:outline-none transition-transform duration-300">
        <i class="fa-solid fa-bars"></i>
      </button>


      <!-- Tombol login/daftar di desktop -->
      <div class="hidden md:flex space-x-3">
        <a href="login.php" class="px-4 py-2 border rounded hover:bg-gray-100 transition">Masuk</a>
        <a href="register.php" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">Daftar</a>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="relative min-h-[600px] flex items-center justify-center bg-cover bg-center bg-fixed" style="background-image: url('./assets/img/banner.webp');" fetchpriority="high">
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40"></div>
    <div class="relative z-10 text-center text-white container mx-auto px-6">
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 animate-fade-in-up">Three Brother Law</h1>
      <p class="text-lg md:text-2xl mb-8 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.3s;">
        Firma Hukum & Layanan Pengacara Profesional untuk Perlindungan Hukum Terbaik Anda
      </p>
      <div class="animate-fade-in-up hero-buttons" style="animation-delay: 0.6s;">
        <a href="#contact" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-semibold px-8 py-3 rounded-lg transition duration-300 mr-4">
          Konsultasi Gratis
        </a>
        <a href="#services" class="inline-block border-2 border-white hover:bg-white hover:text-gray-900 text-white font-semibold px-8 py-3 rounded-lg transition duration-300">
          Layanan Kami
        </a>
      </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
      <a href="#about" class="text-white text-2xl">
        <i class="fas fa-chevron-down"></i>
      </a>
    </div>
  </section>

  <!-- 2 Gambar Section -->
  <section class="py-12 px-6 container mx-auto">
    <h2 class="text-2xl font-bold mb-8 text-center">Mengapa Memilih Kami?</h2>
    <div class="grid md:grid-cols-2 gap-6">
      <div class="relative">
        <img src="./assets/img/imgwelcome1.webp" alt="Pertemuan pengacara" class="w-full h-[300px] object-cover rounded-xl shadow">
        <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-xl">
          <p class="text-white font-semibold text-lg">Diskusi Kasus</p>
        </div>
      </div>
      <div class="relative">
        <img src="./assets/img/imgwelcome2.webp" alt="Diskusi pengadilan" class="w-full h-[300px] object-cover rounded-xl shadow">
        <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-xl">
          <p class="text-white font-semibold text-lg">Solusi Hukum Terbaik</p>
        </div>
      </div>
    </div>
  </section>

  <!-- About -->
  <section id="about" class="py-20 px-6 container mx-auto">
    <h2 class="text-2xl font-bold mb-6">Tentang Kami</h2>
    <p class="text-gray-700 leading-relaxed text-justify">
      Three Brother Law adalah firma hukum yang didedikasikan berdasarkan prinsip integritas, profesionalisme, dan komitmen terhadap keadilan.
      Didirikan oleh tiga bersaudara dengan keahlian hukum beragam, kami menyediakan layanan hukum komprehensif meliputi perdata, pidana, korporat, dan keluarga.
      Dengan pendekatan berpusat pada klien, kami menekankan komunikasi jelas, strategi disesuaikan, dan solusi praktis untuk memenuhi kebutuhan unik Anda.
    </p>
  </section>

  <!-- Services -->
  <section id="services" class="py-20 bg-gray-50 px-6">
    <div class="container mx-auto">
      <h2 class="text-2xl font-bold mb-3">Layanan Kami</h2>
      <p class="mb-10 text-gray-600">Layanan kami hadir dengan harga yang wajar</p>
      <div class="space-y-6">
        <div class="flex items-center bg-white p-4 rounded-xl border">
          <img src="./assets/img/service1.webp" loading="lazy" class="w-28 h-24 rounded mr-6 object-cover" alt="layanan pertama dari three brother law">
          <div>
            <h3 class="text-lg font-semibold">Pengajuan Perceraian</h3>
            <p class="text-gray-600">Membantu klien dalam pengajuan perceraian dan mewakili di pengadilan.</p>
            <a href="register.php" class="mt-2 px-3 py-1 border rounded hover:bg-gray-100 inline-block">Klik Di Sini</a>
          </div>
        </div>
        <div class="flex items-center bg-white p-4 rounded-xl border">
          <img src="./assets/img/service2.webp" loading="lazy" class="w-28 h-24 rounded mr-6 object-cover" alt="layanan kedua dari three brother law">
          <div>
            <h3 class="text-lg font-semibold">Sengketa Tanah & Properti</h3>
            <p class="text-gray-600">Menangani konflik kepemilikan tanah, batas wilayah, atau warisan.</p>
            <a href="register.php" class="mt-2 px-3 py-1 border rounded hover:bg-gray-100 inline-block">Klik Di Sini</a>
          </div>
        </div>
        <div class="flex items-center bg-white p-4 rounded-xl border">
          <img src="./assets/img/service3.webp" loading="lazy" class="w-28 h-24 rounded mr-6 object-cover" alt="layanan ketiga dari three brother law">
          <div>
            <h3 class="text-lg font-semibold">Kasus Kecelakaan</h3>
            <p class="text-gray-600">Dukungan hukum untuk kecelakaan lalu lintas dan klaim kompensasi.</p>
            <a href="register.php" class="mt-2 px-3 py-1 border rounded hover:bg-gray-100 inline-block">Klik Di Sini</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimony -->
  <section id="testimony" class="py-20 px-6 container mx-auto">
    <h2 class="text-2xl font-bold mb-3">Testimoni</h2>
    <p class="mb-10 text-gray-600">Dari klien kami yang puas</p>
    <div class="grid md:grid-cols-3 gap-6">
      <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start">
        <img src="./assets/img/testimoni1.webp" loading="lazy" alt="testimoni dari Rudi" class="w-20 h-20 object-cover rounded-lg">
        <div>
          <h3 class="font-semibold text-lg mb-2">Rudi</h3>
          <p class="text-gray-700 text-sm">
            Profesional dan transparan, hasilnya memuaskan dan saya merasa terlindungi.
          </p>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start">
        <img src="./assets/img/testimoni2.webp" loading="lazy" alt="testimoni dari Bambang" class="w-20 h-20 object-cover rounded-lg">
        <div>
          <h3 class="font-semibold text-lg mb-2">Bambang</h3>
          <p class="text-gray-700 text-sm">
            Komunikasi sangat baik, dan hasil kasus kecelakaan saya cepat terselesaikan.
          </p>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start">
        <img src="./assets/img/testimoni3.webp" loading="lazy" alt="testimoni dari Joko & Suwarni" class="w-20 h-20 object-cover rounded-lg">
        <div>
          <h3 class="font-semibold text-lg mb-2">Joko & Suwarni</h3>
          <p class="text-gray-700 text-sm">
            Pendekatan manusiawi dan hasilnya adil bagi kedua pihak. Terima kasih!
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section id="contact" class="py-20 bg-gray-50 px-6">
    <div class="container mx-auto grid md:grid-cols-2 gap-8 items-center">
      <div>
        <h2 class="text-2xl font-bold mb-6">Kontak Kami</h2>
        <p class="flex items-center mb-3"><i class="fa-solid fa-envelope mr-3"></i> threebrotherlaw@gmail.com</p>
        <p class="flex items-start mb-3"><i class="fa-solid fa-location-dot mr-3 mt-1"></i> Jl. Sawunggaling II, Desa Sambisari, Kec. Taman, Sidoarjo, Jawa Timur</p>
        <p class="flex items-center"><i class="fa-solid fa-phone mr-3"></i> +6282245059975</p>
      </div>
      <div>
        <iframe 
          data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1240.391126453724!2d112.67763246962423!3d-7.366635869504696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e3235b55cf8f%3A0xe8bf31edc869ea55!2sJl.%20Sawunggaling%20II%2C%20Jemundo%2C%20Kec.%20Taman%2C%20Kabupaten%20Sidoarjo%2C%20Jawa%20Timur%2061257!5e1!3m2!1sid!2sid!4v1761707273012!5m2!1sid!2sid"
          width="100%" height="300" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          class="rounded-xl lazy-map">
        </iframe>
      </div>
    </div>
  </section>


  <!-- Footer -->
  <footer class="bg-gray-100 text-gray-800 py-12">
    <div class="container mx-auto grid md:grid-cols-4 gap-8 text-sm">
      <div>
        <div class="flex items-center mb-4">
          <img src="./assets/img/logo.webp" alt="Logo Three Brother Law" class="w-10 h-10 mr-3">
          <h3 class="font-bold text-xl">Three Brother Law</h3>
        </div>
        <p class="mb-4">Firma hukum profesional yang siap membantu menyelesaikan masalah hukum Anda dengan integritas dan keahlian.</p>
        <div class="flex space-x-4 text-lg">
          <a href="https://www.instagram.com/three_brother_law/" class="hover:text-gray-600"><i class="fab fa-instagram"></i></a>
          <a href="https://www.youtube.com/@threebrotherlaw" class="hover:text-gray-600"><i class="fab fa-youtube"></i></a>
          <a href="https://wa.me/6289652003013" class="hover:text-gray-600"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>

      <div>
        <h4 class="font-bold mb-4 text-lg">Layanan Kami</h4>
        <ul class="space-y-2">
          <li><a href="#services" class="hover:text-gray-600">Hukum Perceraian</a></li>
          <li><a href="#services" class="hover:text-gray-600">Sengketa Properti</a></li>
          <li><a href="#services" class="hover:text-gray-600">Kasus Kecelakaan</a></li>
          <li><a href="#services" class="hover:text-gray-600">Hukum Keluarga</a></li>
          <li><a href="#services" class="hover:text-gray-600">Hukum Pidana</a></li>
          <li><a href="#services" class="hover:text-gray-600">Hukum Bisnis</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold mb-4 text-lg">Tautan Cepat</h4>
        <ul class="space-y-2">
          <li><a href="#about" class="hover:text-gray-600">Tentang Kami</a></li>
          <li><a href="#services" class="hover:text-gray-600">Layanan</a></li>
          <li><a href="#testimony" class="hover:text-gray-600">Testimoni</a></li>
          <li><a href="#contact" class="hover:text-gray-600">Kontak</a></li>
          <li><a href="login.php" class="hover:text-gray-600">Login</a></li>
          <li><a href="register.php" class="hover:text-gray-600">Daftar</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold mb-4 text-lg">Jam Operasional</h4>
        <ul class="space-y-2">
          <li>Senin - Sabtu: 08:00 - 15:00</li>
          <li>Minggu: Tutup</li>
        </ul>
        <div class="mt-6 p-4 bg-gray-200 rounded-lg">
          <h5 class="font-bold mb-2">Konsultasi Gratis</h5>
          <p class="text-sm">Jadwalkan konsultasi gratis dengan pengacara kami untuk membahas kasus Anda.</p>
          <a href="https://wa.me/089652003013" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Hubungi via WhatsApp</a>
        </div>
      </div>
    </div>
    <div class="container mx-auto mt-8 pt-6 border-t border-gray-300 text-center">
      <p>&copy; 2025 Three Brother Law.</p>
    </div>
  </footer>

  <script defer>
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    let isOpen = false;

    menuBtn.addEventListener('click', () => {
      isOpen = !isOpen;
      menu.style.transform = isOpen ? 'scaleY(1)' : 'scaleY(0)';
      menuBtn.innerHTML = isOpen ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    });
  </script>

  <script defer>
  document.addEventListener("DOMContentLoaded", () => {
    const maps = document.querySelectorAll(".lazy-map");
    const options = { rootMargin: "200px 0px", threshold: 0 };

    const loadMap = (entry) => {
      const iframe = entry.target;
      iframe.src = iframe.dataset.src;
      observer.unobserve(iframe);
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) loadMap(entry);
      });
    }, options);

    maps.forEach(map => observer.observe(map));
  });
  </script>
</body>
</html>