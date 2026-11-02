-- Database: db_cerpen
-- Dibuat untuk Web App Cerpen (PHP Native + MySQL/Laragon phpMyAdmin)

CREATE DATABASE IF NOT EXISTS `db_cerpen` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_cerpen`;

-- Struktur tabel `cerpen`
DROP TABLE IF EXISTS `cerpen`;
CREATE TABLE `cerpen` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `judul` VARCHAR(200) NOT NULL,
  `penulis` VARCHAR(100) NOT NULL,
  `kategori` VARCHAR(50) NOT NULL,
  `ringkasan` VARCHAR(300) NOT NULL,
  `isi` LONGTEXT NOT NULL,
  `cover_url` VARCHAR(255) DEFAULT NULL,
  `views` INT(11) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data Awal (Dummy Cerpen Menarik untuk Presentasi)
INSERT INTO `cerpen` (`id`, `judul`, `penulis`, `kategori`, `ringkasan`, `isi`, `cover_url`, `views`, `created_at`) VALUES
(1, 'Hujan di Ujung Senja', 'Aulia Rahma', 'Romantis', 'Pertemuan tak disengaja di sebuah halte bus tua membuka kembali lembaran kenangan yang sempat terkunci rapat selama lima tahun.', 'Langit sore itu berwarna kelabu pekat, seolah tak sabar menumpahkan seluruh beban yang ditanggungnya seharian. Rintik hujan mulai turun satu per satu, menghantam aspal jalanan kota yang masih berasap oleh knalpot kendaraan.

Rian melipat payungnya yang patah di salah satu ruas, lalu melangkah tergesa masuk ke halte bus dekat persimpangan jalan Malioboro. Napasnya terengah, ujung jaketnya basah kuyup. Halte itu sepi, hanya ada seorang wanita berkemeja krem yang duduk di bangku kayu sudut, menatap tetesan air hujan dengan tatapan kosong.

Ketika wanita itu menoleh, waktu seakan membeku.

\"Rian...?\" suara lirih itu memecah dengung hujan.

Rian tertegun. Matanya menatap lekat paras yang begitu familiar, paras yang pernah mengisi hari-harinya lima tahun lalu sebelum perpisahan pahit di stasiun kereta. \"Nadia? Kamu... ada di sini?\"

Nadia tersenyum tipis, senyuman yang menyembunyikan ribuan kata yang tak sempat terucap. \"Dunia ternyata sempit ya. Lima tahun aku berusaha mencari alasan kenapa kamu pergi tanpa pamit, dan semesta justru mempertemukan kita di halte tua ini saat hujan lebat.\"

Rian melangkah pelan, duduk di sebelah Nadia dengan jarak yang dijaga sopan. Di balik gemericik hujan yang semakin deras, dua insan itu mulai membuka kembali luka masa lalu, bukan untuk saling menyalahkan, melainkan untuk saling memaafkan dan menyadari bahwa beberapa cerita memang indah justru karena tidak berakhir bersama.', 'https://images.unsplash.com/photo-1515694346937-94d85e41e6f0?w=600&auto=format&fit=crop&q=80', 42, NOW() - INTERVAL 3 DAY),

(2, 'Suara dari Loteng Nomor 7', 'Dimas Prasetyo', 'Horor', 'Arga mengira kontrakan murah di kawasan Kaliurang adalah berkah bagi mahasiswa perantauan, sampai malam ketiga suara langkah kaki itu mulai mendekat.', 'Rumah dua lantai dengan cat hijau lumut itu sudah kosong selama dua tahun. Pak RT sempat memperingatkan Arga sebelum ia menyerahkan uang sewa: \"Mas, loteng atas jangan dibuka ya. Kuncinya sudah lama hilang, dan dari dulu memang dikosongkan.\"

Sebagai mahasiswa teknik yang mengagungkan logika, Arga hanya mengangguk santai. Baginya, harga sewa lima ratus ribu per bulan dengan kamar seluas itu adalah anugerah yang tak boleh dilewatkan.

Malam pertama berjalan tenang. Namun pada malam ketiga, tepat pukul dua dini hari, ketika Arga sedang fokus menyelesaikan laporan praktikum, terdengar bunyi derit kayu dari langit-langit kamarnya.

*Kreeek... Kreeek...*

Bunyi langkah kaki pelan menyeret sesuatu di atas loteng. Arga melepas headphone-nya. Sunyi kembali menyergap. Ia mengira itu hanya tikus liar. Tapi beberapa detik kemudian, terdengar ketukan tiga kali persis di plafon tepat di atas kepalanya.

*Tok. Tok. Tok.*

Bulu kuduk Arga meremang seketika. Hawa di kamar yang sebelumnya hangat mendadak sedingin es. Dari celah ventilasi loteng di sudut ruangan, setetes cairan merah kental menetes jatuh, menimpa halaman buku catatannya yang terbuka. Saat Arga memberanikan diri mendongak, dua pasang mata merah menyala tampak sedang mengintip balik dari kegelapan celah tersebut.', 'https://images.unsplash.com/photo-1509198397868-475647b2a1e5?w=600&auto=format&fit=crop&q=80', 128, NOW() - INTERVAL 2 DAY),

(3, 'Penjelajah Galaksi Terakhir', 'Farhan Maulana', 'Sci-Fi', 'Ketika Bumi kehabisan oksigen pada tahun 2140, Kapten Zidan dan awak kapal Antares melompat ke sektor Alpha Centauri untuk mencari rumah baru.', 'Tahun 2140, langit Bumi bukan lagi biru melainkan cokelat tembaga akibat badai debu karbon yang menutupi atmosfer. Kota-kota megapolitan kini hanya berupa kubah raksasa berpenghuni manusia yang hidup dengan jatah oksigen sintetis harian.

Zidan berdiri di anjungan kapal eksplorasi Antares-IX. Di depannya, layar hologram raksasa memproyeksikan lintasan lompatan kuantum melewati sabuk asteroid Oort.

\"Sistem navigasi siap, Kapten. Koordinat Planet Eden-4 telah terkunci,\" lapor Maya, kepala teknisi robotik kapal.

\"Semua awak bersiap untuk deep sleep. Ini lompatan terjauh dalam sejarah peradaban manusia. Jika kita gagal, spesies kita punah di bawah kubah Bumi,\" ujar Zidan dengan suara tegas namun bergetar.

Mesin fusi Antares meraung hebat. Ruang dan waktu di sekitar lambung kapal melengkung bagaikan kaca yang ditiup panas. Dalam sekejap mata, miliaran bintang berubah menjadi garis-garis cahaya putih yang melesat cepat ke belakang. Perjalanan mencari rumah baru bagi umat manusia baru saja dimulai.', 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=600&auto=format&fit=crop&q=80', 75, NOW() - INTERVAL 1 DAY),

(4, 'Komedi Warung Kopi Cak Man', 'Bambang Sudiro', 'Komedi', 'Debat kusir antara Pak RW dan pensiunan guru soal siapa yang paling berjasa memasang wifi gratis di pos ronda.', 'Warung kopi Cak Man tidak pernah sepi dari keributan warga RT 04. Pemicunya sederhana: kopi tubruk seribu lima ratus perak dengan obrolan setara menteri koordinator.

Pagi itu, Pak RW datang dengan kemeja batik andalannya, langsung memesan kopi hitam tanpa gula. Di meja seberang, Pak Tejo, mantan guru fisika SMA yang terkenal pelit tapi banyak bicara, sudah duduk manis sambil mencelupkan pisang goreng.

\"Cak Man! Wifi pos ronda kok lemot banget semalam? Mau streaming wayang kulit malah muter-muter kayak komedi putar!\" seru Pak Tejo protes.

Pak RW langsung menyahut, \"Lha sampeyan itu ya, Pak Tejo. Wifi itu dipasang buat anak-anak belajar daring, bukan buat sampeyan nonton dalang Ki Manteb sampai subuh! Apalagi sampeyan kemarin nggak bayar iuran kas pos ronda!\"

\"Lho! Jangan salah Pak RW! Menonton wayang itu melestarikan budaya bangsa! Lagian yang nemuin password wifi itu anak saya!\" balas Pak Tejo tak mau kalah.

Cak Man yang sedang mengaduk kopi hanya bisa menggelengkan kepala. \"Sudah-sudah, Pak. Daripada ribut wifi, mending pisang goreng yang dimakan Pak Tejo dari tadi itu dibayar dulu, sudah habis lima biji tapi ngakunya cuma nyicip!\"

Seketika tawa seluruh pengunjung warung pecah, dan muka Pak Tejo memerah seperti kepiting rebus.', 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=600&auto=format&fit=crop&q=80', 94, NOW());
