<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Three Brother Law</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
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
  </style>
</head>
<body class="font-sans bg-white text-gray-800">

    <!-- Navbar -->
  <header class="fixed w-full bg-white shadow z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <div class="flex items-center space-x-2">
        <a href="index.html">
          <img src="./assets/img/logo.png" alt="Logo" class="w-10 h-10">
        </a>
      </div>
      <nav class="space-x-6 hidden md:flex text-gray-700">
        <a href="index.html#about" class="hover:text-gray-900">Tentang Kami</a>
        <a href="index.html#services" class="hover:text-gray-900">Layanan</a>
        <a href="index.html#testimony" class="hover:text-gray-900">Testimoni</a>
        <a href="index.html#location" class="hover:text-gray-900">Lokasi</a>
        <a href="index.html#contact" class="hover:text-gray-900">Kontak</a>
      </nav>
      <div class="space-x-3">
        <a href="login.php" class="px-4 py-2 border rounded hover:bg-gray-100">Masuk</a>
        <a href="register.php" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">Daftar</a>
      </div>
    </div>
  </header>

  <!-- Hero Section yang Diperbarui -->
  <section class="relative min-h-[600px] flex items-center justify-center bg-cover bg-center bg-fixed" style="background-image: url('./assets/img/banner.png');">
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40"></div>
    <div class="relative z-10 text-center text-white container mx-auto px-6">
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 animate-fade-in-up">Three Brother Law</h1>
      <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.3s;">
        Firma Hukum & Layanan Pengacara Profesional untuk Perlindungan Hukum Terbaik Anda
      </p>
      <div class="animate-fade-in-up" style="animation-delay: 0.6s;">
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

  <!-- 2 img Section -->
  <section class="py-12 px-6 container mx-auto">
    <h2 class="text-2xl font-bold mb-8 text-center">Mengapa Memilih Kami?</h2>
    <div class="grid md:grid-cols-2 gap-6">
      <div class="relative">
        <img src="./assets/img/imgwelcome1.png" alt="Pertemuan pengacara" class="w-full h-[300px] object-cover rounded-xl shadow">
        <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-xl">
          <p class="text-white font-semibold text-lg">Diskusi Kasus</p>
        </div>
      </div>
      <div class="relative">
        <img src="./assets/img/imgwelcome2.png" alt="Diskusi pengadilan" class="w-full h-[300px] object-cover rounded-xl shadow">
        <div class="absolute inset-0 bg-black/30 flex items-center justify-center rounded-xl">
          <p class="text-white font-semibold text-lg">Solusi Hukum Terbaik</p>
        </div>
      </div>
    </div>
  </section>


  <!-- About Us -->
  <section id="about" class="py-20 px-6 container mx-auto">
    <h2 class="text-2xl font-bold mb-6">Tentang kami</h2>
    <p class="text-gray-700 leading-relaxed text-justify">
      Three Brother Law adalah firma hukum yang didedikasikan berdasarkan prinsip integritas, profesionalisme, dan komitmen yang teguh terhadap keadilan. 
      Didirikan oleh tiga bersaudara dengan keahlian hukum yang beragam, firma ini menyediakan layanan hukum komprehensif yang mencakup masalah hukum perdata, pidana, korporat, dan keluarga. 
      Dengan pendekatan yang berpusat pada klien, Three Brother Law menekankan komunikasi yang jelas, strategi yang disesuaikan, dan solusi praktis untuk memenuhi kebutuhan unik individu, bisnis, dan organisasi. 
      Dipandu oleh nilai-nilai etika yang kuat dan semangat advokasi, firma ini berusaha untuk melindungi hak-hak klien, menyelesaikan sengketa secara efektif, dan memberikan hasil dengan standar keunggulan tertinggi.
    </p>
  </section>

  <!-- Services -->
  <section id="services" class="py-20 bg-gray-50 px-6">
    <div class="container mx-auto">
      <h2 class="text-2xl font-bold mb-3">Layanan Kami</h2>
      <p class="mb-10 text-gray-600">Layanan kami hadir dengan harga yang wajar</p>
      <div class="space-y-6">
        <!-- Card -->
        <div class="flex items-center bg-white p-4 rounded-xl border">
          <img src="./assets/img/service1.jpg" class="w-28 h-24 rounded mr-6 object-cover" alt="">
          <div>
            <h3 class="text-lg font-semibold">Pengajuan perceraian.</h3>
            <p class="text-gray-600">Membantu klien dalam mengajukan permohonan perceraian dan mewakili mereka di pengadilan.</p>
            <a href="register.html" class="mt-2 px-3 py-1 border rounded hover:bg-gray-100">Klik Di Sini</a>
          </div>
        </div>
        <div class="flex items-center bg-white p-4 rounded-xl border">
          <img src="./assets/img/service2.jpg" class="w-28 h-24 rounded mr-6 object-cover" alt="">
          <div>
            <h3 class="text-lg font-semibold">Sengketa tanah atau pembagian properti.</h3>
            <p class="text-gray-600">Menangani konflik terkait kepemilikan tanah, batas wilayah, atau warisan.</p>
            <a href="register.html" class="mt-2 px-3 py-1 border rounded hover:bg-gray-100">Klik Di Sini</a>
          </div>
        </div>
        <div class="flex items-center bg-white p-4 rounded-xl border">
          <img src="./assets/img/service3.png" class="w-28 h-24 rounded mr-6 object-cover" alt="">
          <div>
            <h3 class="text-lg font-semibold">Penanganan kasus kecelakaan.</h3>
            <p class="text-gray-600">Memberikan dukungan hukum untuk kecelakaan lalu lintas, klaim kompensasi, atau masalah tanggung jawab.</p>
            <a href="register.html" class="mt-2 px-3 py-1 border rounded hover:bg-gray-100">Klik Di Sini</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimony -->
  <section id="testimony" class="py-20 px-6 container mx-auto">
    <h2 class="text-2xl font-bold mb-3">Testimoni</h2>
    <p class="mb-10 text-gray-600">Testimoni dari klien kami yang puas</p>
    <div class="grid md:grid-cols-3 gap-6">
      <!-- Card 1 -->
      <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start">
        <img src="./assets/img/testimoni1.jpg" alt="Rudi" class="w-20 h-20 object-cover rounded-lg">
        <div>
          <h3 class="font-semibold text-lg mb-2">Rudi</h3>
          <p class="text-gray-700 text-sm">
            Klien Three Brother Law menghargai profesionalisme firma dan bimbingan yang jelas dalam menangani sengketa, mencatat hasil yang menguntungkan dan ketenangan pikiran yang diperoleh dari dukungan ahli.
          </p>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start">
        <img src="./assets/img/testimoni2.png" alt="Bambang" class="w-20 h-20 object-cover rounded-lg">
        <div>
          <h3 class="font-semibold text-lg mb-2">Bambang</h3>
          <p class="text-gray-700 text-sm">
            Klien memuji Three Brother Law untuk dukungan yang andal dalam kasus kecelakaan, menghargai keahlian firma, komunikasi yang jelas, dan komitmen untuk mengamankan kompensasi yang adil.
          </p>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 items-start">
        <img src="./assets/img/testimoni3.jpg" alt="Joko & Suwarni" class="w-20 h-20 object-cover rounded-lg">
        <div>
          <h3 class="font-semibold text-lg mb-2">Joko & Suwarni</h3>
          <p class="text-gray-700 text-sm">
            Klien mempercayai Three Brother Law dalam kasus perceraian untuk pendekatan yang penuh kasih, bimbingan yang jelas, dan strategi efektif untuk mencapai resolusi yang adil dan seimbang.
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
        <p class="flex items-start mb-3"><i class="fa-solid fa-location-dot mr-3 mt-1"></i> Jl. Sawunggaling II Desa.Sambisari, Kec. Taman, Kabupaten Sidoarjo, Jawa Timur 61257</p>
        <p class="flex items-center"><i class="fa-solid fa-phone mr-3"></i> +6282245059975</p>
      </div>
      <div>
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d989.2215837138733!2d112.67763246962419!3d-7.366635869504696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e3235b55cf8f%3A0xe8bf31edc869ea55!2sJl.%20Sawunggaling%20II%2C%20Jemundo%2C%20Kec.%20Taman%2C%20Kabupaten%20Sidoarjo%2C%20Jawa%20Timur%2061257!5e0!3m2!1sen!2sid!4v1757868667421!5m2!1sen!2sid" 
          width="100%" 
          height="300" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy"
          class="rounded-xl">
        </iframe>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-100 text-gray-800 py-12">
    <div class="container mx-auto grid md:grid-cols-4 gap-8 text-sm">
      <div>
        <div class="flex items-center mb-4">
          <img src="./assets/img/logo.png" alt="Logo Three Brother Law" class="w-10 h-10 mr-3">
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
          <li class="hover:text-gray-600"><a href="#services">Hukum Perceraian</a></li>
          <li class="hover:text-gray-600"><a href="#services">Sengketa Properti</a></li>
          <li class="hover:text-gray-600"><a href="#services">Kasus Kecelakaan</a></li>
          <li class="hover:text-gray-600"><a href="#services">Hukum Keluarga</a></li>
          <li class="hover:text-gray-600"><a href="#services">Hukum Pidana</a></li>
          <li class="hover:text-gray-600"><a href="#services">Hukum Bisnis</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-lg">Tautan Cepat</h4>
        <ul class="space-y-2">
          <li class="hover:text-gray-600"><a href="#about">Tentang Kami</a></li>
          <li class="hover:text-gray-600"><a href="#services">Layanan</a></li>
          <li class="hover:text-gray-600"><a href="#testimony">Testimoni</a></li>
          <li class="hover:text-gray-600"><a href="#contact">Kontak</a></li>
          <li class="hover:text-gray-600"><a href="login.html">Login</a></li>
          <li class="hover:text-gray-600"><a href="register.html">Daftar</a></li>
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

</body>
</html>