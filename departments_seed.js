db.departments.insertMany([
    {
        nama: "Departemen Bedah",
        deskripsi: "Menangani prosedur operasi dan perawatan pasca operasi",
        kepala_departemen: "Dr. Rudi Hartono, Sp.B",
        lokasi: "Lantai 3, Gedung Utara",
        status: "active",
        created_at: new Date()
    },
    {
        nama: "Departemen Pediatri",
        deskripsi: "Spesialisasi dalam perawatan kesehatan anak dan bayi",
        kepala_departemen: "Dr. Maya Sari, Sp.A",
        lokasi: "Lantai 2, Gedung Timur",
        status: "active",
        created_at: new Date()
    },
    {
        nama: "Departemen Kardiologi",
        deskripsi: "Menangani diagnosis dan pengobatan penyakit jantung",
        kepala_departemen: "Dr. Bambang Wijaya, Sp.JP",
        lokasi: "Lantai 4, Gedung Barat",
        status: "active",
        created_at: new Date()
    },
    {
        nama: "Departemen Gigi dan Mulut",
        deskripsi: "Pelayanan kesehatan gigi dan mulut komprehensif",
        kepala_departemen: "Dr. Nina Putri, Sp.KG",
        lokasi: "Lantai 1, Gedung Selatan",
        status: "active",
        created_at: new Date()
    },
    {
        nama: "Departemen Oftalmologi",
        deskripsi: "Spesialisasi dalam perawatan kesehatan mata",
        kepala_departemen: "Dr. Surya Pratama, Sp.M",
        lokasi: "Lantai 2, Gedung Utara",
        status: "active",
        created_at: new Date()
    }
]); 