use('klinik_kesehatan');

db.bookings.insertMany([
    {
        "booking_id": "BK-2024-001",
        "patient": {
            "nama": "Ahmad Rizki",
            "nik": "3171234567890001",
            "tanggal_lahir": new Date("1990-05-15"),
            "jenis_kelamin": "Laki-laki",
            "alamat": "Jl. Mawar No. 123, Jakarta",
            "telepon": "081234567890",
            "email": "ahmad.rizki@email.com"
        },
        "dokter": {
            "id": "DR-001",
            "nama": "Dr. Andi Wijaya",
            "spesialisasi": "Dokter Spesialis Bedah",
            "departemen": "Departemen Bedah"
        },
        "jadwal": {
            "tanggal": new Date("2024-03-20"),
            "waktu": "09:00",
            "durasi": 45,
            "jenis_layanan": "Konsultasi"
        },
        "status": "confirmed",
        "keluhan": "Nyeri pada bagian perut bagian kanan",
        "catatan_medis": "Pasien mengeluhkan nyeri perut sejak 3 hari yang lalu",
        "biaya": {
            "konsultasi": 250000,
            "tindakan": 0,
            "total": 250000,
            "status_pembayaran": "pending"
        },
        "created_at": new Date(),
        "updated_at": new Date()
    },
    {
        "booking_id": "BK-2024-002",
        "patient": {
            "nama": "Siti Aminah",
            "nik": "3171234567890002",
            "tanggal_lahir": new Date("1988-08-20"),
            "jenis_kelamin": "Perempuan",
            "alamat": "Jl. Melati No. 45, Jakarta",
            "telepon": "081234567891",
            "email": "siti.aminah@email.com"
        },
        "dokter": {
            "id": "DR-002",
            "nama": "Dr. Siti Rahayu",
            "spesialisasi": "Dokter Spesialis Anak",
            "departemen": "Departemen Pediatri"
        },
        "jadwal": {
            "tanggal": new Date("2024-03-21"),
            "waktu": "10:30",
            "durasi": 45,
            "jenis_layanan": "Pemeriksaan Rutin"
        },
        "status": "confirmed",
        "keluhan": "Demam tinggi dan batuk pada anak",
        "catatan_medis": "Pasien anak mengalami demam 39°C sejak kemarin malam",
        "biaya": {
            "konsultasi": 200000,
            "tindakan": 150000,
            "total": 350000,
            "status_pembayaran": "paid"
        },
        "created_at": new Date(),
        "updated_at": new Date()
    },
    {
        "booking_id": "BK-2024-003",
        "patient": {
            "nama": "Budi Santoso",
            "nik": "3171234567890003",
            "tanggal_lahir": new Date("1975-12-10"),
            "jenis_kelamin": "Laki-laki",
            "alamat": "Jl. Anggrek No. 67, Jakarta",
            "telepon": "081234567892",
            "email": "budi.santoso@email.com"
        },
        "dokter": {
            "id": "DR-003",
            "nama": "Dr. Hendra Kusuma",
            "spesialisasi": "Dokter Spesialis Jantung",
            "departemen": "Departemen Kardiologi"
        },
        "jadwal": {
            "tanggal": new Date("2024-03-22"),
            "waktu": "13:00",
            "durasi": 60,
            "jenis_layanan": "Pemeriksaan Jantung"
        },
        "status": "completed",
        "keluhan": "Sesak nafas dan nyeri dada",
        "catatan_medis": "Pasien memiliki riwayat hipertensi, perlu pemeriksaan EKG",
        "biaya": {
            "konsultasi": 300000,
            "tindakan": 500000,
            "total": 800000,
            "status_pembayaran": "paid"
        },
        "created_at": new Date(),
        "updated_at": new Date()
    },
    {
        "booking_id": "BK-2024-004",
        "patient": {
            "nama": "Maya Putri",
            "nik": "3171234567890004",
            "tanggal_lahir": new Date("1995-03-25"),
            "jenis_kelamin": "Perempuan",
            "alamat": "Jl. Dahlia No. 89, Jakarta",
            "telepon": "081234567893",
            "email": "maya.putri@email.com"
        },
        "dokter": {
            "id": "DR-004",
            "nama": "Dr. Rini Susanti",
            "spesialisasi": "Dokter Gigi",
            "departemen": "Departemen Gigi dan Mulut"
        },
        "jadwal": {
            "tanggal": new Date("2024-03-23"),
            "waktu": "14:30",
            "durasi": 45,
            "jenis_layanan": "Perawatan Gigi"
        },
        "status": "pending",
        "keluhan": "Sakit gigi bagian geraham",
        "catatan_medis": "Pasien memerlukan pemeriksaan lebih lanjut untuk kemungkinan pencabutan gigi",
        "biaya": {
            "konsultasi": 150000,
            "tindakan": 0,
            "total": 150000,
            "status_pembayaran": "pending"
        },
        "created_at": new Date(),
        "updated_at": new Date()
    },
    {
        "booking_id": "BK-2024-005",
        "patient": {
            "nama": "Dian Pratiwi",
            "nik": "3171234567890005",
            "tanggal_lahir": new Date("1992-07-15"),
            "jenis_kelamin": "Perempuan",
            "alamat": "Jl. Kenanga No. 12, Jakarta",
            "telepon": "081234567894",
            "email": "dian.pratiwi@email.com"
        },
        "dokter": {
            "id": "DR-005",
            "nama": "Dr. Lisa Permata",
            "spesialisasi": "Dokter Spesialis Mata",
            "departemen": "Departemen Oftalmologi"
        },
        "jadwal": {
            "tanggal": new Date("2024-03-24"),
            "waktu": "11:00",
            "durasi": 30,
            "jenis_layanan": "Pemeriksaan Mata"
        },
        "status": "confirmed",
        "keluhan": "Penglihatan kabur dan mata sering berair",
        "catatan_medis": "Pasien mengeluhkan pandangan kabur saat membaca dan bekerja dengan komputer",
        "biaya": {
            "konsultasi": 200000,
            "tindakan": 300000,
            "total": 500000,
            "status_pembayaran": "pending"
        },
        "created_at": new Date(),
        "updated_at": new Date()
    }
]);