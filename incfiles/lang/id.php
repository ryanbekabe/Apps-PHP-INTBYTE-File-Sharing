<?php
/**
 * ========== About ==========
 * Author     : Afid Arifin
 * Name       : INTBYTE File Sharing (IFS)
 * Version    : v1.0
 * Created On : 09 October 2019
 */

/**
 * ========== WARNING BEFORE USING ==========
 * About            : see /documents/about.txt
 * Contact          : see /documents/contact.txt
 * Disclaimer       : see /documents/disclaimer.txt
 * Privacy Policy   : see/documents/privacy-policy.txt
 * License Software : see /documents/license.txt
 */

// To Debugging, You can change the number zero to number one to display the message
ini_set('display_errors', 0);

// Welcome
$lang['welcome_SERVICE_STORAGE'] = 'Penyimpanan';
$lang['welcome_SERVICE_STORCONT'] = 'Kami memberikan kapasitas penyimpanan 5GB dengan maksimal unggah per berkas adalah 250MB.';
$lang['welcome_SERVICE_MONETIZE'] = 'Monetasi Iklan';
$lang['welcome_SERVICE_MONECONT'] = 'Monetasikan berkas Anda setiap kali Anda mengunggah berkas dengan fitur iklan tanpa batas dari kami.';
$lang['welcome_SERVICE_SECURITY'] = 'Keamanan';
$lang['welcome_SERVICE_SECUCONT'] = 'Tidak perlu khawatir dengan keamanan berkas Anda di server kami. Berkas Anda sepenuhnya aman di sistem kami.';
$lang['welcome_SERVICE_UPGRADE'] = 'Upgrade Akun';
$lang['welcome_SERVICE_UPGRCONT'] = 'Dapatkan kapasitas penyimpanan 2 kali lebih besar dari akun gratis dengan cara meningkatkan akun Anda.';

// Header
$lang['header_home'] = 'Beranda';
$lang['header_notifications'] = 'Pemberitahuan';
$lang['header_MAAR'] = 'Tandai Dibaca Semua';
$lang['header_VA'] = 'Lihat Semua';
$lang['header_UNN'] = 'Tidak ada pemberitahuan.';
$lang['header_profile'] = 'Profil';
$lang['header_dashboard'] = 'Dashboard';
$lang['header_settings'] = 'Pengaturan';
$lang['header_signout'] = 'Keluar';
$lang['header_UAG'] = 'Tamu';
$lang['header_PLF'] = 'Anda Tidak Masuk';
$lang['header_login'] = 'Masuk Akun';
$lang['header_register'] = 'Daftar Akun';
$lang['header_notifications'] = 'Pemberitahuan';
$lang['header_SELECT_LANG'] = 'Bahasa';
$lang['header_latest_upload'] = 'Unggah Terbaru';
$lang['header_popular_download'] = 'Popular Download';

// Sidebar
$lang['home_SAA'] = 'Periklanan Admin';
$lang['home_SE'] = 'Email';
$lang['home_SMA'] = 'Kelola Administrator';
$lang['home_SMAD'] = 'Kelola Iklan Pengguna';
$lang['home_SMAD_UAA'] = 'Iklan Disetujui';
$lang['home_SMAD_UAR'] = 'Iklan Ditolak';
$lang['home_SMAD_UAB'] = 'Iklan Diblokir';
$lang['home_SMAD_UAD'] = 'Iklan Dihapus';
$lang['home_SMAD_UAW'] = 'Menunggu Persetujuan';
$lang['home_SMF'] = 'Kelola Berkas';
$lang['home_SMF_LU'] = 'Unggah Terbaru';
$lang['home_SMF_PD'] = 'Popular Download';
$lang['home_SMF_RF'] = 'Laporan Berkas';
$lang['home_SMN'] = 'Kelola Pemberitahuan';
$lang['home_SMN_CN'] = 'Buat Pemberitahuan';
$lang['home_SMN_NN'] = 'Pemberitahuan Terbaru';
$lang['home_SMN_AN'] = 'Arsip Pemberitahuan';
$lang['home_SMU'] = 'Kelola Pengguna';
$lang['home_SMU_LU'] = 'Daftar Pengguna';
$lang['home_SMU_UB'] = 'Pengguna Diblokir';
$lang['user_LIST_CONFIRMED'] = 'Pengguna Terkonfirmasi';
$lang['home_SMU_UC'] = 'Pengguna Belum Terkonfirmasi';
$lang['home_SMU_UPA'] = 'Premium Akun';
$lang['home_SS'] = 'Pengaturan';
$lang['home_SS_SEO'] = 'Pengaturan SEO';
$lang['home_SS_SITE'] = 'Pengaturan Situs';
$lang['home_SS_STORAGE'] = 'Pengaturan Penyimpanan';
$lang['home_SS_AVATAR'] = 'Ubah Avatar';
$lang['home_SAAC'] = 'Upgrade Akun';
$lang['home_SUAP'] = 'Iklan Premium';
$lang['home_SUMAD'] = 'Iklan Saya';
$lang['home_SUMAD_CNA'] = 'Buat Iklan Baru';
$lang['home_SUMAD_AA'] = 'Iklan Aktif';
$lang['home_SUMAD_UAA'] = 'Iklan Disetujui';
$lang['home_SUMAD_UAR'] = 'Iklan Ditolak';
$lang['home_SUMAD_UAB'] = 'Iklan Diblokir';
$lang['home_SUMAD_UAD'] = 'Iklan Dihapus';
$lang['home_SUMAD_UAW'] = 'Menunggu Persetujuan';
$lang['home_SUMF'] = 'Berkas Saya';
$lang['home_SUMF_LF'] = 'Daftar Berkas';
$lang['home_SUMF_UF'] = 'Unggah Berkas';
$lang['home_SUMF_IF'] = 'Impor Berkas';
$lang['home_SUMF_RF'] = 'Laporan Berkas';
$lang['home_SUMF_PF'] = 'Popular Berkas';
$lang['home_SUMFF'] = 'Folder Saya';
$lang['home_SUN'] = 'Pemberitahuan';
$lang['home_SS_PROFILE'] = 'Ubah Profil';
$lang['home_SS_PASSWORD'] = 'Ubah Kata Sandi';
$lang['home_SS_DELETE'] = 'Hapus Akun';
$lang['home_SCU'] = 'Hubungi Kami';
$lang['home_SCU_EMAIL'] = 'Via Email';
$lang['home_SCU_MESSENGER'] = 'Via Messenger';
$lang['home_SUMFA'] = 'Tambahkan Folder';
$lang['home_SS_WELCOME'] = 'Selamat Datang';

// Administrator Index
$lang['admin_STORAGE_USED'] = 'DIGUNAKAN';
$lang['admin_USERS'] = 'TOTAL PENGGUNA';
$lang['admin_TOTAL_ADMIN'] = 'TOTAL ADMIN';
$lang['admin_TOTAL_FILES'] = 'TOTAL BERKAS';

// Administrator
$lang['admin_LT'] = 'Daftar Administrator';
$lang['admin_AL'] = 'Daftar Administrator';
$lang['admin_USERNAME'] = 'Nama Pengguna';
$lang['admin_REGISTERED'] = 'Terdaftar';
$lang['admin_EMAIL'] = 'Email';
$lang['admin_LEVEL'] = 'Level';
$lang['admin_STATUS'] = 'Status';
$lang['admin_ACTION'] = 'Tindakan';
$lang['admin_DFA'] = 'Hapus pengguna ini dari daftar administrator.';
$lang['admin_SP'] = 'Lihat Profil';
$lang['admin_AYS'] = 'Apakah Anda Yakin?';
$lang['admin_AYS_CONFIRM'] = 'Apakah Anda yakin ingin menghapus';
$lang['admin_AYS_SUCCESS'] = 'Berhasil menghapus pengguna ini dari daftar administrator.';
$lang['admin_AYS_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['admin_CNTD1'] = 'Anda tidak dapat menghapus diri Anda sendiri dikarenakan Anda adalah Admin utama.';
$lang['admin_CNTD2'] = 'Anda tidak dapat menghapus Admin utama.';
$lang['admin_BDWN_ACTION'] = 'Tindakan';
$lang['admin_BDWN_DELETE'] = 'Hapus';
$lang['admin_BDWN_SEE'] = 'Lihat Profil';

// Admin Advertisement
$lang['ads_NHP'] = 'Anda tidak memiliki izin untuk mengakses halaman ini.';
$lang['ads_EAU'] = 'Mohon isi unit iklan Anda!';
$lang['ads_NATA'] = 'Jenis iklan tidak didukung. Harap gunakan iklan jenis JavaScript atau HTML!';
$lang['ads_STU'] = 'Iklan Anda berhasil diperbarui.';
$lang['ads_FTU'] = 'Iklan Anda gagal diperbarui.';
$lang['ads_YAU'] = 'Unit Iklan Anda';
$lang['ads_PFIYAU'] = 'Mohon isi unit iklan Anda!';
$lang['ads_PUBLISH'] = 'Perbarui';
$lang['ads_CLEAR'] = 'Bersihkan';
$lang['ads_PREVIEW'] = 'Pratinjau Iklan';
$lang['ads_YHNAU'] = 'Anda tidak memiliki unit iklan yang aktif saat ini.';
$lang['ads_LAST_UPDATE'] = 'Terakhir diperbarui';

// User File
$lang['userFile_LATEST_UPLOAD'] = 'Unggah Terbaru';
$lang['userFile_POPULAR_DOWNLOAD'] = 'Popular Download';
$lang['userFile_REPORTED'] = 'Laporan Berkas';
$lang['userFile_NAME'] = 'Nama Berkas';
$lang['userFile_FOLDER'] = 'Folder';
$lang['userFile_SIZE'] = 'Ukuran';
$lang['userFile_TIME'] = 'Diunggah Pada';
$lang['userFile_DOWNLOADED'] = 'Diunduh';
$lang['userFile_UPLOADED_BY'] = 'Diunggah Oleh';
$lang['userFile_FOLDER_T'] = 'Berkas ini disimpan di folder';
$lang['userFile_REPORT'] = 'Dilaporkan';
$lang['userFile_ACTION'] = 'Tindakan';
$lang['userFile_BDWN_ACTION'] = 'Tindakan';
$lang['userFile_BDWN_DELETE'] = 'Hapus';
$lang['userFile_BDWN_MOVE'] = 'Pindah';
$lang['userFile_BDWN_EDIT'] = 'Ubah';
$lang['userFile_BDWN_SEE'] = 'Lihat Berkas';
$lang['userFile_CONFIRM_AYS'] = 'Apakah Anda Yakin?';
$lang['userFile_CONDELETE_TEXT'] = 'Apakah Anda yakin ingin menghapus berkas ini secara permanen?';
$lang['userFile_CONDELETE_SUCCESS'] = 'Berhasil menghapus berkas ini.';
$lang['userFile_CONDELETE_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';

// Settings
$lang['settings_SEO'] = 'Pengaturan SEO';
$lang['settings_SITE'] = 'Pengaturan Situs';
$lang['settings_STORAGE'] = 'Pengaturan Penyimpanan';
$lang['settings_SEO_TEXT'] = 'Pengaturan SEO dasar seperti, deskripsi, kata kunci, Robots.txt dan Google Verifikasi.';
$lang['settings_SEO_SD'] = 'Deskripsi Situs';
$lang['settings_SEO_SK'] = 'Kata Kunci Situs';
$lang['settings_SEO_RT'] = 'Robots.txt';
$lang['settings_SEO_GV'] = 'Google Verifikasi';
$lang['settings_SEO_IFSD'] = 'Mohon isi deksripsi situs!';
$lang['settings_SEO_IFSK'] = 'Mohon isi kata kunci situs!';
$lang['settings_SEO_IFRT'] = 'Mohon isi robots.txt!';
$lang['settings_SEO_IFGV'] = 'Mohon isi Google Verifikasi kode!';
$lang['settings_SEO_SAVE'] = 'Simpan Perubahan';
$lang['settings_SEO_ALRM'] = 'WARNING!';
$lang['settings_SEO_ALRMS'] = 'SUCCESS!';
$lang['settings_SEO_IDST'] = 'Mohon isi semua data yang diperlukan.';
$lang['settings_SEO_ISDT'] = 'Sistem hanya merekomendasikan panjang 150 karakter untuk deskripsi situs Anda.';
$lang['settings_SEO_ISKT'] = 'Sistem hanya merekomendasikan panjang 150 kata untuk kata kunci situs Anda.';
$lang['settings_SEO_IRTT'] = 'Sistem hanya merekomendasikan 200 karakter untuk Robots.txt Anda.';
$lang['settings_SEO_IGVT'] = 'Kode Google Verifikasi Anda tidak valid.';
$lang['settings_SEO_SUCCESS'] = 'Pengaturan SEO berhasil diperbarui.';
$lang['settings_SEO_FAILED'] = 'Pengaturan SEO gagl diperbarui.';
$lang['settings_SITE_TEXT'] = 'Pengaturan situs dasar seperti judul situs, status pendaftaran, zona waktu, mode pemeliharaan situs, bahasa dan sebagainya.';
$lang['settings_SITE_TITLE'] = 'Judul Situs';
$lang['settings_SITE_REG'] = 'Status Pendaftaran';
$lang['settings_SITE_REGSS'] = 'Pilih Status';
$lang['settings_SITE_REGOR'] = 'Buka Pendaftaran';
$lang['settings_SITE_REGCR'] = 'Tutup Pendaftaran';
$lang['settings_SITE_VS'] = 'Status Verifikasi';
$lang['settings_SITE_VSSS'] = 'Pilih Status';
$lang['settings_SITE_VSA'] = 'Aktif';
$lang['settings_SITE_VSNA'] = 'Tidak Aktif';
$lang['settings_SITE_TZ'] = 'Zona Waktu';
$lang['settings_SITE_MTC'] = 'Mode Pemeliharaan';
$lang['settings_SITE_MTCSM'] = 'Pilih Mode';
$lang['settings_SITE_MTCOM'] = 'Buka';
$lang['settings_SITE_MTCCM'] = 'Tutup';
$lang['settings_SITE_LANG'] = 'Bahasa';
$lang['settings_SITE_LANGSL'] = 'Pilih Bahasa';
$lang['settings_SITE_SAVE'] = 'Simpan Perubahan';
$lang['settings_SITE_ALRM'] = 'WARNING!';
$lang['settings_SITE_ALRMS'] = 'SUCCESS!';
$lang['settings_SITE_IDST'] = 'Mohon isi semua data yang diperlukan.';
$lang['settings_SITE_IFT'] = 'Mohon isi judul situs Anda!';
$lang['settings_SITE_IFR'] = 'Mohon pilih status pendaftaran.';
$lang['settings_SITE_IFV'] = 'Mohon pilih status verfikasi pendaftaran.';
$lang['settings_SITE_IFTZ'] = 'Mohon isi zona waktu!';
$lang['settings_SITE_IFM'] = 'Mohon pilih mode pemeliharaan!';
$lang['settings_SITE_IFL'] = 'Mohon pilih default bahasa Anda!';
$lang['settings_SITE_RSN'] = 'Mohon pilih status pendaftaran!';
$lang['settings_SITE_VSN'] = 'Mohon pilih status verifikasi pendaftaran!';
$lang['settings_SITE_MMN'] = 'Mohon pilih mode pemeliharaan!';
$lang['settings_SITE_DLN'] = 'Mohon pilih default bahasa Anda!';
$lang['settings_SITE_SUCCESS'] = 'Pengaturan situs berhasil diperbarui.';
$lang['settings_SITE_FAILED'] = 'Pengaturan situs gagal diperbarui.';
$lang['settings_SITE_PAGING'] = 'Tampilan Per Halaman';
$lang['settings_SITE_PAGING2'] = 'Pilih Jumlah';
$lang['settings_SITE_PAGING3'] = 'halaman';
$lang['settings_SITE_PAGINGN'] = 'Mohon pilih jumlah per halaman!';
$lang['settings_SITE_IFP'] = 'Mohon isi jumlah per halaman!';
$lang['settings_SITE_CURRENCY'] = 'Kurs Mata Uang';
$lang['settings_SITE_CURRENCYN'] = 'Mata uang hanya mendukung angka!';
$lang['settings_SITE_IFC'] = 'Mohon isi mata uang Anda!';
$lang['settings_SITE_PAYPAL'] = 'Kode Paypal';
$lang['settings_SITE_IFPP'] = 'Mohon masukkan kode html paypal Anda!';
$lang['settings_SITE_BANK'] = 'Bank';
$lang['settings_SITE_IFBK'] = 'Mohon masukkan rekening bank Anda!';
$lang['settings_SITE_OTHERS'] = 'Lainnya';
$lang['settings_SITE_IFBO'] = 'Masukkan pembayaran lainnya!';
$lang['settings_STORAGE_TEXT'] = 'Pengaturan penyimpanan seperti penyimpanan per pengguna, unggah per berkas, dan ekstensi berkas yang dilarang.';
$lang['settings_STORAGE_SPU'] = 'Penyimpanan Per Pengguna';
$lang['settings_STORAGE_UPF'] = 'Unggah Per Berkas';
$lang['settings_STORAGE_NAE'] = 'Ekstensi Dilarang';
$lang['settings_STORAGE_IFSPU'] = 'Mohon isi penyimpanan per pengguna!';
$lang['settings_STORAGE_IFUPF'] = 'Mohon isi unggah per berkas!';
$lang['settings_STORAGE_IFNAE'] = 'Mohon isi ekstensi dilarang!';
$lang['settings_STORAGE_SAVE'] = 'Simpan Perubahan';
$lang['settings_STORAGE_ALRM'] = 'WARNING!';
$lang['settings_STORAGE_ALRMS'] = 'SUCCESS!';
$lang['settings_STORAGE_IDST'] = 'Mohon isi semua data yang diperlukan.';
$lang['settings_STORAGE_IISU'] = 'Hanya mendukung format angka dalam satuan BYTE saja.';
$lang['settings_STORAGE_IE'] = 'Mohon batasi hanya dengan spasi dan koma saja.';
$lang['settings_STORAGE_SUCCESS'] = 'Pengaturan penyimpanan berhasil diperbarui.';
$lang['settings_STORAGE_FAILED'] = 'Pengaturan penyimpanan gagal diperbarui.';
$lang['settings_STORAGE_USED'] = 'DIGUNAKAN';
$lang['settings_STORAGE_PHS'] = 'Masukkan dalam MB dan hanya dalam angka...';
$lang['settings_STORAGE_PHE'] = 'Masukan ekstensi Anda...';

// User Ads
$lang['userAds_APPROVE'] = 'Daftar Iklan Disetujui';
$lang['userAds_REJECT'] = 'Daftar Iklan Ditolak';
$lang['userAds_BLOCK'] = 'Daftar Iklan Diblokir';
$lang['userAds_DELETE'] = 'Daftar Iklan Dihapus';
$lang['userAds_WTA'] = 'Daftar Iklan Menunggu Persetujuan';
$lang['userAds_CONTENT'] = 'Isi';
$lang['userAds_ON_DATE'] = 'Pada';
$lang['userAds_ADS_BY'] = 'Iklan Oleh';
$lang['userAds_STATUS'] = 'Status';
$lang['userAds_ACTION'] = 'Tindakan';
$lang['userAds_BDWN_ACTION'] = 'Tindakan';
$lang['userAds_BDWN_APPROVE'] = 'Setujui';
$lang['userAds_BDWN_BLOCK'] = 'Blokir';
$lang['userAds_BDWN_REJECT'] = 'Tolak';
$lang['userAds_BDWN_DELETE'] = 'Hapus';
$lang['userAds_BDWN_PREVIEW'] = 'Pratinjau';
$lang['userAds_CONFIRM_AYS'] = 'Apakah Anda Yakin?';
$lang['userAds_CONAPPROVE_TEXT'] = 'Apakah Anda yakin ingin menyetujui iklan pengguna ini?';
$lang['userAds_CONAPPROVE_SUCCESS'] = 'Iklan pengguna berhasil disetujui.';
$lang['userAds_CONAPPROVE_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['userAds_CONBLOCK_TEXT'] = 'Apakah Anda yakin ingin memblokir iklan pengguna ini? Iklan pengguna ini tidak dapat diajukan kembali oleh pengguna.';
$lang['userAds_CONBLOCK_SUCCESS'] = 'Iklan pengguna berhasil diblokir.';
$lang['userAds_CONBLOCK_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['userAds_CONREJECT_TEXT'] = 'Apakah Anda yakin ingin menolak iklan pengguna ini? Iklan pengguna ini dapat Anda setujui kapan saja.';
$lang['userAds_CONREJECT_SUCCESS'] = 'Iklan pengguna berhasil ditolak.';
$lang['userAds_CONREJECT_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['userAds_CONDELETE_TEXT'] = 'Apakah Anda yakin ingin menghapus iklan pengguna ini? Iklan ini dapat diajukan kembali oleh pengguna.';
$lang['userAds_CONDELETE_SUCCESS'] = 'Iklan pengguna berhasil dihapus.';
$lang['userAds_CONDELETE_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['userAds_CONDROP_SUCCESS'] = 'Berhasil menghapus semua iklan.';
$lang['userAds_CONDROP_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';

// Users
$lang['user_LIST'] = 'Daftar Pengguna';
$lang['user_LIST_BLOCK'] = 'Pengguna Diblokir';
$lang['user_LIST_UNCONFIRM'] = 'Belum Terkonfirmasi';
$lang['user_LIST_CONFIRMED'] = 'Pengguna Terkonfirmasi';
$lang['user_LIST_PA'] = 'Premium Akun';
$lang['user_LIST_USERNAME'] = 'Nama Pengguna';
$lang['user_LIST_REGISTERED'] = 'Terdaftar';
$lang['user_LIST_EMAIL'] = 'Email';
$lang['user_LIST_LEVEL'] = 'Level';
$lang['user_LIST_STATUS'] = 'Status';
$lang['user_LIST_ACTION'] = 'Tindakan';
$lang['user_LIST_BDWN_ACTION'] = 'Tindakan';
$lang['user_LIST_BDWN_BLOCK'] = 'Blokir';
$lang['user_LIST_BDWN_UNBLOCK'] = 'Batal Blokir';
$lang['user_LIST_BDWN_DELETE'] = 'Hapus';
$lang['user_LIST_BDWN_SEE'] = 'Lihat Profil';
$lang['user_LIST_BDWN_UPA'] = 'Upgrade Akun';
$lang['user_LIST_BDWN_DPA'] = 'Downgrade Akun';
$lang['user_LIST_CONFIRM_AYS'] = 'Apakah Anda Yakin?';
$lang['user_LIST_CONBLOCK_TEXT'] = 'Apakah Anda yakin ingin memblokir pengguna ini? tindakan ini akan membuat pengguna tidak dapat mengakses akunnya.';
$lang['user_LIST_CONBLOCK_SUCCESS'] = 'Pengguna berhasil Anda blokir.';
$lang['user_LIST_CONBLOCK_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['user_LIST_CONDELETE_TEXT'] = 'Apakah Anda yakin ingin menghapus pengguna ini secara permanen?';
$lang['user_LIST_CONDELETE_SUCCESS'] = 'Pengguna berhasil Anda hapus.';
$lang['user_LIST_CONDELETE_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['user_LIST_CONUNBLOCK_TEXT'] = 'Apakah Anda yakin ingin membatalkan pemblokiran pengguna ini?';
$lang['user_LIST_CONUNBLOCK_SUCCESS'] = 'Pengguna berhasil Anda batalkan pemblokiran.';
$lang['user_LIST_CONUNBLOCK_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';

// Time
$lang['timeAgoYears'] = 'tahun yang lalu';
$lang['timeAgoMonths'] = 'bulan yang lalu';
$lang['timeAgoWeeks'] = 'minggu yang lalu';
$lang['timeAgoDays'] = 'hari yang lalu';
$lang['timeAgoHours'] = 'jam yang lalu';
$lang['timeAgoMinutes'] = 'menit yang lalu';
$lang['timeAgoJustNow'] = 'Baru saja';

// Status
$lang['status_NC'] = 'Pengguna ini belum mengkonfirmasi akun.';
$lang['status_C'] = 'Pengguna ini telah mengkonfirmasi akun.';
$lang['status_NCA'] = 'BELUM DIKONFIRMASI';
$lang['status_CA'] = 'TERKONFIRMASI';
$lang['status_UAD_APPROVE'] = 'Iklan pengguna ini berhasil disetujui.';
$lang['status_UAD_REJECT'] = 'Iklan pengguna ini berhasil ditolak.';
$lang['status_UAD_BLOCK'] = 'Iklan pengguna ini berhasil diblokir.';
$lang['status_UAD_DELETE'] = 'Iklan pengguna ini berhasil dihapus.';
$lang['status_UAD_WTA'] = 'Iklan pengguna ini menunggu untuk disetujui.';
$lang['status_UAD_APPROVED'] = 'Disetujui';
$lang['status_UAD_REJECTED'] = 'Ditolak';
$lang['status_UAD_BLOCKED'] = 'Diblokir';
$lang['status_UAD_DELETED'] = 'Dihapus';
$lang['status_UAD_WTA2'] = 'Menunggu';
$lang['status_BLOCKED'] = 'DIBLOKIR';
$lang['status_USER'] = 'PENGGUNA';

// Notifications
$lang['notify_CREATE'] = 'Buat Pemberitahuan';
$lang['notify_CREATE_TITLE'] = 'Judul';
$lang['notify_CREATE_ST'] = 'Pilih Tipe';
$lang['notify_CREATE_STN'] = 'Berita';
$lang['notify_CREATE_STI'] = 'Informasi';
$lang['notify_CREATE_STT'] = 'Penawaran';
$lang['notify_CREATE_STU'] = 'Pengguna';
$lang['notify_CREATE_MESSAGE'] = 'Pesan Pemberitahuan';
$lang['notify_CREATE_TFB'] = 'Mohon isi judul pemberitahuan!';
$lang['notify_CREATE_MFB'] = 'Mohon isi pesan pemberitahuan!';
$lang['notify_CREATE_DLFB'] = 'Mohon isi jenis pemberitahuan!';
$lang['notify_CREATE_RBTN'] = 'Bersihkan';
$lang['notify_CREATE_SBTN'] = 'Buat Pemberitahuan';
$lang['notify_CREATE_EMPTXT'] = 'Mohon isi semua data yang diperlukan.';
$lang['notify_CREATE_LENTL'] = 'Minimal panjang judul 5 karakter dan harus terdiri dari 2 kata.';
$lang['notify_CREATE_CS'] = 'Harap pilih tipe dan tujuan ke siapa pemberitahuan Anda akan dikirim.';
$lang['notify_CREATE_LENMSG'] = 'Minimal isi pesan pemberitahuan terdiri dari 25 karakter dan 5 kata.';
$lang['notify_CREATE_SUCCESS'] = 'Berhasil menambahkan pemberitahuan terbaru.';
$lang['notify_CREATE_FAILED'] = 'Gagal menambahkan pemberitahuan terbaru.';
$lang['notify_CREATE_LU'] = 'Update Terakhir';
$lang['notify_CREATE_BY'] = 'Ke';
$lang['notify_CREATE_NF'] = 'Tidak ada pemberitahuan.';
$lang['notify_NEW'] = 'Pemberitahuan Terbaru';
$lang['notify_NEW_ARCHIVE'] = 'Arsip Pemberitahuan';
$lang['notify_NEW_TITLE'] = 'Judul';
$lang['notify_NEW_CONTENT'] = 'Konten';
$lang['notify_NEW_ON_DATE'] = 'Pada';
$lang['notify_NEW_BY'] = 'Oleh';
$lang['notify_NEW_STATUS'] = 'Status';
$lang['notify_NEW_ACTION'] = 'Tindakan';
$lang['notify_NEW_UNREAD'] = 'Belum Dibaca';
$lang['notify_NEW_READ'] = 'Dibaca';
$lang['notify_NEW_BDWN_ACTION'] = 'Tindakan';
$lang['notify_NEW_BDWN_READ'] = 'Baca';
$lang['notify_NEW_BDWN_DELETE'] = 'Hapus';
$lang['notify_NEW_CONFIRM_AYS'] = 'Apakah Anda Yakin?';
$lang['notify_NEW_CONDELETE_TEXT'] = 'Apakah Anda yakin ingin menghapus pemberitahuan ini?';
$lang['notify_NEW_CONDELETE_SUCCESS'] = 'Pemberitahuan berhasil dihapus.';
$lang['notify_NEW_CONDELETE_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['notify_DONE_BTN'] = 'Selesai';
$lang['notify_DROP_ALL'] = 'Hapus Semua';
$lang['notify_DROP_ALL2'] = 'Semua data pemberitahuan akan dihapus dalam satu klik.';
$lang['notify_NEW_CONDROP_TEXT'] = 'Apakah Anda yakin ingin menghapus semua pemberitahuan dengan sekali klik?';
$lang['notify_NEW_CONDROP_SUCCESS'] = 'Semua pemberitahuan berhasil dihapus.';
$lang['notify_NEW_CONDROP_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['notify_HEAD_CONDROP_TEXT'] = 'Tindakan Anda akan mengubah semua pemberitahuan menjadi telah dibaca.';
$lang['notify_HEAD_CONDROP_SUCCESS'] = 'Pemberitahuan telah dibaca semua.';
$lang['notify_HEAD_CONDROP_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['notify_CREATE_TO'] = 'Kirim Ke Siapa?';
$lang['notify_CREATE_STO'] = 'Pilih Pengguna';
$lang['notify_CREATE_TFB'] = 'Mohon pilih tujuan pengiriman!';
$lang['notify_CONSO_TEXT'] = 'Apakah Anda yakin ingin keluar akun sekarang?';
$lang['notify_CONSO_SUCCESS'] = 'Berhasil keluar akun. Sesi Anda telah berakhir.';
$lang['notify_CONSO_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['notify_OOPS'] = 'Oops! terjadi kesalahan saat menyegarkan halaman. Silahkan coba beberapa saat lagi.';

// Login
$lang['login_LOST_PASSWORD'] = 'Lupa Kata Sandi';
$lang['login_RESET_PASSWORD'] = 'Reset Kata Sandi';
$lang['login_PAGE'] = 'Masuk Akun';
$lang['login_PAGE_EFB'] = 'Mohon masukkan email Anda!';
$lang['login_PAGE_PFB'] = 'Mohon masukkan kata sandi Anda!';
$lang['login_PAGE_PASSWORD'] = 'Kata Sandi';
$lang['login_PAGE_RM'] = 'Ingat Saya';
$lang['login_PAGE_BTN'] = 'Masuk Akun';
$lang['login_PAGE_DHA'] = 'Belum memiliki akun?';
$lang['login_PAGE_CO'] = 'Buat Sekarang';
$lang['login_ALL_REQUIRED'] = 'Mohon masukan semua data login Anda dengan benar.';
$lang['login_INAVLID_EMAIL'] = 'Pastikan email yang Anda masukkan benar.';
$lang['login_USER_BANNED'] = 'Akun Anda telah kami blokir. Hubungi kami untuk mengajukan banding terkait akun Anda.';
$lang['login_USER_STATUS'] = 'Mohon konfirmasikan akun Anda sebelum menggunakan layanan kami.';
$lang['login_SUCCESS'] = 'Berhasil masuk akun. Anda akan dialihkan dalam 3 detik.';
$lang['login_INVALID_PASSWORD'] = 'Kata sandi Anda salah.';
$lang['login_NF_EMAIL'] = 'Email Anda tidak terdaftar di sistem kami.';
$lang['login_SECURITY_SESSION'] = 'Sesi Anda sedang aktif sebelumnya. Demi keamanan, sesi Anda secara otomatis kami hapus.';
$lang['login_LOST_PASSWORD_REQUEST'] = 'Minta Baru';
$lang['login_LOST_PASSWORD_SEND'] = 'Kami akan mengirimkan link untuk mereset kata sandi baru Anda.';
$lang['login_LOST_PASSWORD_SUCCESS'] = 'Kami berhasil mengirimkan link reset kata sandi baru Anda. Cek email Anda sekarang.';
$lang['login_LOST_PASSWORD_FAILED'] = 'Kami gagal mengirimkan link reset kata sandi baru Anda.';
$lang['login_RESET_TFB'] = 'Mohon masukkan token Anda!';
$lang['login_RESET_PASSWORD_NEW'] = 'Kata Sandi Baru';
$lang['login_RESET_NPFB'] = 'Mohon masukkan kata sandi baru Anda!';
$lang['login_RESET_PASSWORD_CONFIRM'] = 'Ulangi Kata Sandi Baru';
$lang['login_RESET_CPFB'] = 'Mohon masukkan ulang kata sandi baru Anda!';
$lang['login_RESET_BTN'] = 'Reset Kata Sandi';
$lang['login_MIN_PASSWORD'] = 'Minimal kata sandi terdiri dari 8 karakter atau lebih.';
$lang['login_INVALID_PASSWORD2'] = 'Verifikasi kata sandi Anda tidak cocok.';
$lang['login_INVALID_TOKEN'] = 'Token Anda tidak valid atau telah kedaluwarsa.';
$lang['login_RESET_PASSWORD_SUCCESS'] = 'Kata sandi berhasil direset.';
$lang['login_RESET_PASSWORD_FAILED'] = 'Kata sandi gagal direset.';
$lang['login_STATUS_BANNED'] = 'Akun Anda telah kami blokir. Hubungi kami untuk mengajukan banding terkait akun Anda.';
$lang['login_STATUS_UNCONFIRMED'] = 'Mohon konfirmasikan akun Anda sebelum menggunakan layanan kami.';
$lang['login_NF_ET'] = 'Token Anda telah kedaluwarsa. Mohon meminta kembali pada halaman lupa kata sandi.';
$lang['login_WARNING'] = 'Terjadi kesalahan saat memproses permintaan Anda.';
$lang['login_TOKEN_CLICKED'] = 'Token digunakan untuk memastikan bahwa yang meminta perubahan ini adalah Anda. Lupa token? silahkan meminta yang baru.';
$lang['login_PASSWORD_SAME'] = 'Anda tidak dapat menggunakan kata sandi sebelumnya.';

// Register
$lang['register_PAGE'] = 'Buat Akun';
$lang['register_PAGE_WELCOME'] = 'Buat akun secara mudah hanya dengan sekali klik.';
$lang['register_PAGE_USERNAME'] = 'Nama Pengguna';
$lang['register_PAGE_UFB'] = 'Mohon masukkan nama pengguna Anda!';
$lang['register_PAGE_EFB'] = 'Mohon masukkan email Anda!';
$lang['register_PAGE_PASSWORD'] = 'Kata Sandi';
$lang['register_PAGE_EFB'] = 'Mohon masukkan email Anda!';
$lang['register_PAGE_PASSWORD_CONFIRM'] = 'Ulangi Kata Sandi';
$lang['register_PAGE_AGREE'] = 'Setuju kebijakan layanan';
$lang['register_PAGE_BTN'] = 'Buat Akun';
$lang['register_PAGE_PFB'] = 'Mohon masukkan kata sandi Anda!';
$lang['register_PAGE_PCFB'] = 'Mohon ulangi kata sandi Anda!';
$lang['register_PAGE_DHA'] = 'Sudah memiliki akun?';
$lang['register_PAGE_VERIFY'] = 'Verifikasi Akun';
$lang['register_PAGE_STATUS'] = 'Status Akun';
$lang['register_ALL_REQUIRED'] = 'Mohon isi semua data pembuatan akun.';
$lang['register_INVALID_USERNAME'] = 'Nama pengguna hanya mendukung alfanumerik dan karakter .-_';
$lang['register_LEN_USERNAME'] = 'Panjang nama pengguna harus terdiri antara 4 - 30 karakter.';
$lang['register_USERNAME_EXISTS'] = 'Nama pengguna telah terdaftar.';
$lang['register_INVALID_EMAIL'] = 'Email tidak valid. Mohon periksa kembali email Anda.';
$lang['register_LEN_EMAIL'] = 'Panjang email harus terdiri antara 4 - 30 karakter.';
$lang['register_EMAIL_EXISTS'] = 'Email telah terdaftar.';
$lang['register_LEN_PASSWORD'] = 'Minimal kata sandi terdiri dari 8 karakter atau lebih.';
$lang['register_INVALID_PASSWORD'] = 'Kata sandi Anda tidak cocok. Mohon periksa kembali kata sandi Anda.';
$lang['register_SUCCESS_VERIFY'] = 'Silahkan cek email Anda untuk mengkonfirmasi akun Anda.';
$lang['register_FAILED_VERIFY'] = 'Sepertinya kami tidak dapat memproses permintaan Anda saat ini.';
$lang['register_SUCCESS_WV'] = 'Akun Anda berhasil dibuat. Cek email untuk detail login Anda.';
$lang['register_FAILED_WV'] = 'Sepertinya kami tidak dapat memproses permintaan Anda saat ini.';
$lang['register_CLOSE'] = 'Saat ini pembukaan akun baru sedang kami tutup. Silahkan kembali beberapa saat lagi.';
$lang['register_INVALID_EMAIL'] = 'Email tidak valid. Mohon periksa kembali email Anda.';
$lang['register_VERIFY_SUCCESS'] = 'Akun Anda berhasil dikonfirmasi.';
$lang['register_VERIFY_FAILED'] = 'Akun Anda gagal dikonfirmasi. Silahkan beberapa saat lagi.';
$lang['register_VERIFY_NFD'] = 'Email atau token Anda telah kedaluwarsa.';
$lang['register_VERIFY_I'] = 'Sepertinya kami tidak dapat memproses permintaan Anda.';

// Search
$lang['search_RESULT'] = 'Hasil pencarian';
$lang['search_EMPTXT'] = 'Oops! mohon masukkan kata kunci pencarian Anda.';
$lang['search_NO_RESULT'] = 'Pencarian Anda dengan kata kunci tersebut tidak ditemukan di database kami. Mohon periksa kembali.';
$lang['search_NO_RESULT2'] = 'Tidak Ditemukan';
$lang['search_DOWNLOAD_BTN'] = 'Berkas ini tersedia untuk Anda download dengan perkiraan ukuran';
$lang['search_NF_BTH'] = 'Anda akan kembali ke halaman sebelumnya.';
$lang['search_NF_BTHB'] = 'Kembali';
$lang['search_SIZE_ESTIMATE'] = 'Perkiraan ukuran download berkas ini adalah';
$lang['search_EMPTXT2'] = 'Pencarian Anda tidak dapat kami temukan.';
$lang['search_SEE_PROFILE'] = 'Lihat Profil';

// Upload File
$lang['upload_FILE'] = 'Unggah Berkas';
$lang['upload_FILE_TEXT'] = 'Unggah berkas Anda dan monetasikan berkas Anda. Di paket akun Anda saat ini hanya dapat mengunggah maksimal 2 berkas sekaligus. Batas ukuran per berkas saat ini adalah';
$lang['upload_FILE_TEXT2'] = 'Unggah berkas Anda dan monetasikan berkas Anda. Di paket akun Anda saat ini hanya dapat mengunggah maksimal 4 berkas sekaligus. Batas ukuran per berkas saat ini adalah';
$lang['upload_FILE_PASSWORD'] = 'Kata Sandi';
$lang['upload_FILE_FOLDER'] = 'Folder';
$lang['upload_FILE_SF'] = 'Pilih Folder';
$lang['upload_FILE_DESCRIPTION'] = 'Deskripsi';
$lang['upload_FILE_USED'] = 'Tersisa';
$lang['upload_FILE_BTN'] = 'Unggah Sekarang';
$lang['upload_FILE_USED2'] = 'Penyimpanan Anda di bawah 100 KB atau telah habis.<br/><a href="'.base_url().'/user/upgrade/?act=add_storage&view=package">Tambah Penyimpanan?</a>';
$lang['upload_FILE_USED3'] = 'Di paket akun Anda saat ini hanya tersedia ruang peyimpanan sebesar'; 
$lang['upload_FILE_CF'] = 'Pilih berkas';
$lang['upload_FILE_NSF'] = 'Mohon pilih salah satu folder terlebih dahulu.';
$lang['upload_FILE_FD'] = 'Deskripsi berkas hanya mendukung hingga 5000 karakter saja.';
$lang['upload_FILE_SF2'] = 'Pilih Berkas';
$lang['upload_FILE_NFS'] = 'Mohon pilih setidaknya minimal satu berkas yang akan Anda unggah.';
$lang['upload_FILE_NFS2'] = 'Pastikan Anda mengisi semua kolom berkas yang Anda tambahkan.';
$lang['upload_FILE_BS'] = 'terlalu besar untuk diunggah.';
$lang['upload_FILE_LS'] = 'Penyimpanan Anda telah habis.';
$lang['upload_FILE_NAE'] = 'Ekstensi berkas';
$lang['upload_FILE_NAE2'] = 'tidak didukung.';
$lang['upload_FILE_SS'] = 'berhasil diunggah.';
$lang['upload_FILE_FS'] = 'gagal diunggah.';
$lang['upload_FILE_FM'] = 'Oops! terjadi kesalahan sistem.';
$lang['upload_FILE_HU'] = 'telah Anda unggah sebelumnya.';
$lang['upload_FILE_WARNING'] = '<b>Perhatian:</b> Dilarang mengunggah berkas yang melanggar <a href="'.base_url().'/terms_of_service/">T.O.S</a> layanan kami.';

// Import File
$lang['import_FILE'] = 'Impor Berkas';
$lang['import_FILE_TEXT2'] = 'Impor berkas Anda dan monetasikan berkas Anda. Di paket akun Anda saat ini hanya dapat mengimpor maksimal 4 berkas sekaligus. Batas ukuran per berkas saat ini adalah';
$lang['import_FILE_TEXT'] = 'Impor berkas Anda dan monetasikan berkas Anda. Di paket akun Anda saat ini hanya dapat mengimpor maksimal 2 berkas sekaligus. Batas ukuran per berkas saat ini adalah';
$lang['import_FILE_SF2'] = 'URL Berkas';
$lang['import_FILE_CF'] = 'http://';
$lang['import_FILE_FOLDER'] = 'Folder';
$lang['import_FILE_SF'] = 'Pilih Folder';
$lang['import_FILE_PASSWORD'] = 'Kata Sandi';
$lang['import_FILE_DESCRIPTION'] = 'Deskripsi';
$lang['import_FILE_WARNING'] = '<b>Perhatian:</b> Dilarang mengimpor berkas yang melanggar <a href="'.base_url().'/terms_of_service/">T.O.S</a> layanan kami.';
$lang['import_FILE_USED'] = 'Tersisa';
$lang['import_FILE_BTN'] = 'Impor Sekarang';
$lang['import_FILE_USED2'] = 'Penyimpanan Anda di bawah 100 KB atau telah habis.<br/><a href="'.base_url().'/user/upgrade/?act=add_storage&view=package">Tambah Penyimpanan?</a>';
$lang['import_FILE_NSF'] = 'Mohon pilih salah satu folder terlebih dahulu.';
$lang['import_FILE_FD'] = 'Deskripsi berkas hanya mendukung hingga 5000 karakter saja.';
$lang['import_FILE_IVU'] = 'Format URL Anda salah.';
$lang['import_FILE_LS'] = 'Penyimpanan Anda telah habis.';
$lang['import_FILE_BS'] = 'terlalu besar untuk diimpor.';
$lang['import_FILE_HU'] = 'Telah Anda impor sebelumnya.';
$lang['import_FILE_NAE'] = 'Ekstensi berkas';
$lang['import_FILE_NAE2'] = 'tidak didukung.';
$lang['import_FILE_SS'] = 'berhasil diimpor.';
$lang['import_FILE_FS'] = 'gagal diimpor.';
$lang['import_FILE_FM'] = 'Oops! terjadi kesalahan sistem.';
$lang['import_FILE_NFS'] = 'Mohon setidaknya isi minimal satu URL yang akan Anda impor.';
$lang['import_FILE_NFS2'] = 'Pastikan Anda mengisi semua kolom URL yang Anda tambahkan.';

// My Ads
$lang['myads_CREATE'] = 'Buat Iklan Baru';
$lang['myads_APPROVE'] = 'Iklan Disetujui';
$lang['myads_REJECTED'] = 'Iklan Ditolak';
$lang['myads_BLOCKED'] = 'Iklan Diblokir';
$lang['myads_DELETED'] = 'Iklan Dihapus';
$lang['myads_WTA'] = 'Menunggu Persetujuan';
$lang['myads_CREATE_TEXT'] = 'Buat iklan baru tanpa batasan dan tanpa perlu menunggu persetujuan administrator.';
$lang['myads_CREATE_TEXT2'] = 'Buat iklan baru tanpa batasan. Ingin tanpa perlu menunggu persetujuan? <a href="'.base_url().'/user/upgrade/?act=upgrade_account">Upgrade Akun</a> sekarang.';
$lang['myads_CREATE_UA'] = 'Unit Iklan';
$lang['myads_CREATE_IFBUA'] = 'Mohon masukkan unit iklan Anda.';
$lang['myads_CREATE_CLEAR'] = 'Bersihkan';
$lang['myads_CREATE_PUBLISH'] = 'Buat Iklan';
$lang['myads_CREATE_EUA'] = 'Mohon masukkan unit iklan Anda.';
$lang['myads_CREATE_IUA'] = 'Format iklan Anda tidak didukung.';
$lang['myads_CREATE_SS'] = 'Iklan baru Anda berhasil dibuat.';
$lang['myads_CREATE_FS'] = 'Iklan baru Anda gagal dibuat.';
$lang['myads_CREATE_UAE'] = 'Kami tidak mengizinkan Anda untuk membuat iklan ganda.';
$lang['myads_CREATE_WARNING'] = 'Dilarang membuat iklan yang melanggar <a href="'.base_url().'/terms_of_service">T.O.S</a> layanan kami.';
$lang['myads_CREATE_SS2'] = 'Iklan baru Anda berhasil dibuat. Iklan Anda sedang kami tinjau.';
$lang['myads_CREATE_FS2'] = 'Iklan baru Anda gagl dibuat.';
$lang['myads_CREATE_UAB'] = 'Anda tidak dapat lagi menggunakan unit iklan ini. Silahkan hubungi administrator untuk info lebih lanjut.';
$lang['myads_CONTENT'] = 'Isi';
$lang['myads_ON_DATE'] = 'Pada';
$lang['myads_ADS_BY'] = 'Oleh';
$lang['myads_STATUS'] = 'Status';
$lang['myads_ACTION'] = 'Tindakan';
$lang['myads_BDWN_ACTION'] = 'Tindakan';
$lang['myads_BDWN_DELETE'] = 'Hapus Iklan';
$lang['myads_BDWN_PREVIEW'] = 'Pratinjau Iklan';
$lang['myads_CONDELETE_TEXT'] = 'Apakah Anda yakin ingin menghapus iklan Anda ini? iklan ini tidak dapat dipulihkan kembali.';
$lang['myads_CONDELETE_SUCCESS'] = 'Iklan Anda berhasil dihapus permanen.';
$lang['myads_CONDELETE_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';

// My Files
$lang['myfile_LATEST'] = 'Daftar Berkas';
$lang['myfile_REPORTED'] = 'Laporan Berkas';
$lang['myfile_POPULAR'] = 'Popular Berkas';
$lang['myfile_NAME'] = 'Nama Berkas';
$lang['myfile_FOLDER'] = 'Folder';
$lang['myfile_SIZE'] = 'Ukuran';
$lang['myfile_TIME'] = 'Diunggah Pada';
$lang['myfile_DOWNLOADED'] = 'Diunduh';
$lang['myfile_REPORTED'] = 'Laporan Berkas';
$lang['myfile_UPLOADED_BY'] = 'Diunggah Oleh';
$lang['myfile_ACTION'] = 'Tindakan';
$lang['myfile_BDWN_ACTION'] = 'Tindakan';
$lang['myfile_BDWN_DELETE'] = 'Hapus Berkas';
$lang['myfile_BDWN_MOVE'] = 'Pindahkan Ke Folder Lain';
$lang['myfile_BDWN_EDIT'] = 'Ubah Berkas';
$lang['myfile_BDWN_SEE'] = 'Lihat Berkas';
$lang['myfile_CONDELETE_TEXT'] = 'Apakah Anda yakin ingin menghapus berkas ini secara permanen?';
$lang['myfile_CONDELETE_SUCCESS'] = 'Berhasil menghapus berkas ini.';
$lang['myfile_CONDELETE_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['myfile_CONSEE_TEXT'] = 'Apakah Anda yakin ingin melihat berkas ini? berkas ini aman untuk Anda kunjungi sekarang.';
$lang['myfile_CONSEE_SUCCESS'] = 'Berhasil membuat link yang aman unutk Anda kunjungi.';
$lang['myfile_CONSEE_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['myfile_CONEDIT_TEXT'] = 'Apakah Anda yakin ingin mengubah informasi pada berkas ini?';
$lang['myfile_CONEDIT_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';

// Folder
$lang['folder_DROP_ALL'] = 'Hapus folder';
$lang['folder_ADD'] = 'Tambahkan Folder';
$lang['folder_TEXT'] = 'Tambahkan folder berkas Anda. Pastikan nama folder Anda tidak melanggar aturan.';
$lang['folder_CONDROP_TEXT'] = 'Apakah Anda yakin ingin menghapus folder ini? seluruh berkas yang ada di folder ini juga ikut terhapus semua.';
$lang['folder_CONDROP_SUCCESS'] = 'Folder berhasil Anda hapus.';
$lang['folder_CONDROP_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['folder_EDIT'] = 'Ubah folder';
$lang['folder_NAME'] = 'Nama Folder';
$lang['folder_IFB'] = 'Mohon masukkan nama folder Anda!';
$lang['folder_CLEAR'] = 'Bersihkan';
$lang['folder_EMPTY'] = 'Mohon masukkan nama folder Anda.';
$lang['folder_INVALID'] = 'Nama folder hanya mendukung karakter a-zA-Z0-9._- dan spasi.';
$lang['folder_LENGTH'] = 'Panjang nama folder adalah 3-30 karakter valid.';
$lang['folder_EXISTS'] = 'Kami tidak mengizinkan nama folder ganda. Folder ini telah dibuat sebelumnya.';
$lang['folder_SUCCESS'] = 'Folder Anda berhasil dibuat.';
$lang['folder_FAILED'] = 'Folder Anda gagal dibuat.';
$lang['folder_EDIT_SUCCESS'] = 'Folder berhasil diubah namanya menjadi';
$lang['folder_EDIT_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['folder_EDIT_FILE'] = 'Ubah Berkas';
$lang['folder_EDIT_FILE_TEXT'] = 'Ubah informasi berkas Anda meliputi nama berkas, kata sandi, dan deskripsi berkas.';
$lang['folder_EDIT_FILE_NAME'] = 'Nama Berkas';
$lang['folder_EDIT_FILE_PASSWORD'] = 'Kata Sandi';
$lang['folder_EDIT_FILE_DESCRIPTION'] = 'Deskripsi';
$lang['folder_EDIT_FILE_IF'] = 'Mohon masukan nama berkas Anda!';
$lang['folder_EDIT_FILE_BTN'] = 'Simpan Perubahan';
$lang['folder_EDIT_FILE_BTNC'] = 'Bersihkan';
$lang['folder_EDIT_FILE_SS'] = 'Informasi berkas berhasil diperbarui.';
$lang['folder_EDIT_FILE_F'] = 'Informasi berkas gagal diperbarui.';
$lang['folder_CONMOVE_TEXT'] = 'Apakah Anda yakin ingin memindahkan berkas ini ke folder lain?';
$lang['folder_CONMOVE_CANCEL'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['folder_MOVE_FILE'] = 'Pindahkan berkas';
$lang['folder_MOVE_TO'] = 'Ke Folder';
$lang['folder_MOVE_FROM'] = 'Dari Folder';
$lang['folder_MOVE_FILE_TEXT'] = 'Pindahkan berkas Anda dari folder yang lama ke folder yang baru. Folder ini telah berisi berkas sebanyak';
$lang['folder_MOVE_FILE_SS'] = 'Berkas berhasil dipindahkan ke folder';
$lang['folder_MOVE_FILE_F'] = 'Berkas gagal dipindahkan ke folder';
$lang['folder_MOVE_SAME'] = 'Anda tidak dapat memindahkan berkas ke folder yang sama.';

// Global
$lang['page'] = 'Halaman';
$lang['entry'] = 'entri';
$lang['nf'] = 'Data yang akan ditampilkan tidak tersedia saat ini.';

// 404
$lang['page_NO_RESULT'] = 'Halaman yang Anda cari saat ini tidak tersedia. Silahkan kembali beberapa saat lagi.';

// User Settings
$lang['userSettings_PASSWORD'] = 'Ubah Kata Sandi';
$lang['userSettings_PROFILE'] = 'Ubah Profil';
$lang['userSettings_PASSWORD_TEXT'] = 'Demi keamanan akun Anda, lebih baik mengganti kata sandi secara berkala.';
$lang['userSettings_NEW_PASSWORD'] = 'Kata Sandi Baru';
$lang['userSettings_NEW_PASS_IFB'] = 'Mohon masukan kata sandi baru Anda!';
$lang['userSettings_CONFIRM_PASSWORD'] = 'Konfirmasi Kata Sandi';
$lang['userSettings_CONFIRM_PASS_IFB'] = 'Mohon masukan konfirmasi kata sandi baru Anda!';
$lang['userSettings_PASSWORD_CLEAR'] = 'Bersihkan';
$lang['userSettings_PASSWORD_CHANGE'] = 'Simpan Perubahan';
$lang['userSettings_PASSWORD_EMPTY'] = 'Harap masukan kata sandi baru Anda.';
$lang['userSettings_PASSWORD_LENGTH'] = 'Minimal panjang kata sandi Anda adalah 8 karakter atau lebih.';
$lang['userSettings_PASSWORD_INVALID'] = 'Kata sandi Anda tidak cocok. Harap konfirmasi kembali kata sandi baru Anda.';
$lang['userSettings_PASSWORD_SUCCESS'] = 'Kata sandi Anda berhasil diubah. Demi keamanan, harap Anda masuk kembali ke akun Anda.';
$lang['userSettings_PASSWORD_EXIST'] = 'Anda tidak diperkenankan menggunakan kata sandi sebelumnya untuk kembali digunakan sebagai kata sandi baru.';
$lang['userSettings_PROFILE_PASSWORD_FAILED'] = 'Kata sandi Anda gagal diubah.';
$lang['userSettings_PROFILE_USERNAME'] = 'Nama Pengguna';
$lang['userSettings_PROFILE_FULLNAME'] = 'Nama Lengkap';
$lang['userSettings_PROFILE_FULLNAME_IFB'] = 'Harap masukan nama lengkap Anda!';
$lang['userSettings_PROFILE_EMAIL'] = 'Email';
$lang['userSettings_PROFILE_EMAIL_IFB'] = 'Harap masukan email Anda!';
$lang['userSettings_PROFILE_EINV'] = 'Format email tidak benar!';
$lang['userSettings_PROFILE_DESCRIPTION'] = 'BIO';
$lang['userSettings_PROFILE_DESCRIPTION_IFB'] = 'Harap ceritakan sedikit mengenai Anda!';
$lang['userSettings_PROFILE_TEXT'] = 'Ubah profil Anda seperti nama lengkap, email, dan sebagainya.';
$lang['userSettings_PROFILE_CLEAR'] = 'Bersihkan';
$lang['userSettings_PROFILE_SAVE'] = 'Simpan Perubahan';
$lang['userSettings_PROFILE_NATCU'] = 'Kami tidak mengizinkan untuk mengubah nama pengguna bagi semua pengguna.';
$lang['userSettings_PROFILE_ED'] = 'Harap isi semua data yang diperlukan.';
$lang['userSettings_PROFILE_LOFN'] = 'Nama lengkap setidaknya berisi 3-30 karakter valid.';
$lang['userSettings_PROFILE_LOE'] = 'Email setidaknya berisi 8-30 karakter valid.';
$lang['userSettings_PROFILE_LOD'] = 'BIO hanya mendukung 2048 karakter. Support HTML.';
$lang['userSettings_PROFILE_S'] = 'Profil Anda berhasil diperbarui.';
$lang['userSettings_PROFILE_F'] = 'Profil Anda gagal diperbarui.';
$lang['userSettings_PROFILE_IFN'] = 'Nama lengkap Anda tidak benar.';
$lang['userSettings_AVATAR'] = 'Ubah Avatar';
$lang['userSettings_AVATAR_TEXT'] = 'Ubah avatar Anda dengan mudah di sini.';
$lang['userSettings_AVATAR_CF'] = 'Pilih berkas';
$lang['userSettings_AVATAR_MS'] = 'Maksimal ukuran avatar adalah 2 MB.';
$lang['userSettings_AVATAR_S'] = 'Avatar';
$lang['userSettings_AVATAR_CLEAR'] = 'Bersihkan';
$lang['userSettings_AVATAR_CHANGE'] = 'Simpan Perubahan';
$lang['userSettings_AVATAR_ED'] = 'Harap pilih berkas dahulu.';
$lang['userSettings_AVATAR_BS'] = 'Ukuran avatar terlalu besar. Maksimal 2 MB.';
$lang['userSettings_AVATAR_IE'] = 'Hanya mendukung format avatar JPG dan PNG.';
$lang['userSettings_AVATAR_SUCCESS'] = 'Avatar Anda berhasil diubah.';
$lang['userSettings_AVATAR_FAILED'] = 'Avatar Anda gagal diubah.';

// User Index
$lang['user_PANEL'] = 'Panel';
$lang['user_REGISTERED'] = 'Terdaftar';
$lang['user_LAST_LOGGED'] = 'Terakhir Masuk';
$lang['user_ACCOUNT'] = 'Status Akun';
$lang['user_STORAGE_USED'] = 'Penyimpanan';
$lang['user_TOTAL_FILES'] = 'Total Berkas';
$lang['user_TOTAL_ADS'] = 'Total Iklan';
$lang['user_TOTAL_FILES_DOWNLOADED'] = 'Total Download';
$lang['user_BANNED'] = 'Akun Anda telah kami blokir. Hubungi kami untuk mengajukan banding terkait akun Anda.';
$lang['user_EMPTY_DESCRIPTION'] = 'Lengkapi profil Anda <a href="'.base_url().'/user/settings/?view=settings&type=profile">di sini</a>.';
$lang['user_WELCOME'] = 'Nikmati semua fitur-fitur layanan yang kami tawarkan di menu sidebar yang tersedia. Selamat menikmati layanan kami.';

// User Account
$lang['user_DELETE'] = 'Hapus Akun';
$lang['user_DELETE_TEXT'] = 'Mohon masukan kata sandi akun Anda untuk konfirmasi penghapusan akun Anda.';
$lang['user_DELETE_BTN'] = 'Hapus Sekarang';
$lang['user_DELETE_IFB'] = 'Mohon masukan kata sandi Anda!';
$lang['user_DELETE_BACK'] = 'KEMBALI';
$lang['user_DELETE_EMPTY'] = 'Mohon masukan kata sandi Anda.';
$lang['user_DELETE_IPASS'] = 'Kata sandi Anda salah.';
$lang['user_DELETE_MA'] = 'Anda tidak dapat menghapus diri Anda sendiri karena Anda adalah admin utama.';
$lang['user_DELETE_SS'] = 'Akun Anda berhasil dihapus secara permanen.';
$lang['user_DELETE_FS'] = 'Akun Anda gagal dihapus secara permanen.';
$lang['user_DELETE_DS'] = 'Terjadi kesalahan sistem.';
$lang['user_DELETE_DNA'] = 'Akun Anda telah dihapus sebelumnya.';
$lang['user_DELETE_AGREE'] = 'Saya setuju';
$lang['user_DELETE_AGREE2'] = 'Saya sadar ';

// Download file
$lang['file_DOWNLOAD'] = 'Download Berkas';
$lang['file_DOWNLOAD_REPORTED'] = 'Anda telah melaporkan berkas ini. Silahkan tunggu beberapa saat lagi.';
$lang['file_DOWNLOAD_REPORTED_NY'] = 'Terima kasih atas laporan Anda. Kami akan segera menindak laporan Anda.';
$lang['file_DOWNLOAD_REPORTED2'] = 'Terjadi kesalahan sistem.';
$lang['file_DOWNLOAD_REPORTED3'] = 'Laporkan';
$lang['file_DOWNLOAD_WARNING'] = 'Berkas ini sepenuhnya tanggungjawab yang mengunggah. Jika terdapat berkas yang mencurigakan, harap segara melaporkan ke Administrator.';
$lang['file_DOWNLOAD_DETAILS'] = 'Detail Berkas';
$lang['file_DOWNLOAD_DESCRIPTION'] = 'Deskripsi';
$lang['file_DOWNLOAD_COMMENTS'] = 'Komentar';
$lang['file_DOWNLOAD_NAME'] = 'Nama Berkas';
$lang['file_DOWNLOAD_SIZE'] = 'Ukuran';
$lang['file_DOWNLOAD_TYPE'] = 'Jenis';
$lang['file_DOWNLOAD_ARTIST'] = 'Artis';
$lang['file_DOWNLOAD_UA'] = 'Tidak diketahui';
$lang['file_DOWNLOAD_DURATION'] = 'Durasi';
$lang['file_DOWNLOAD_ALBUM'] = 'Album';
$lang['file_DOWNLOAD_YEAR'] = 'Tahun';
$lang['file_DOWNLOAD_GENRE'] = 'Genre';
$lang['file_DOWNLOAD_BITRATE'] = 'Bitrate';
$lang['file_DOWNLOAD_UPLOADED'] = 'Diunggah';
$lang['file_DOWNLOAD_BY'] = 'Oleh';
$lang['file_DOWNLOAD_DOWNLOADED'] = 'Diunduh';
$lang['file_DOWNLOAD_VIEW'] = 'Dlihat';
$lang['file_DOWNLOAD_DESCRIPTION2'] = 'Tidak ada deskripsi pada berkas ini.';
$lang['file_DOWNLOAD_UNLOCKED'] = 'Terima Kasih';
$lang['file_DOWNLOAD_LOCKED'] = 'Berkas Terkunci';
$lang['file_DOWNLOAD_LPH'] = 'Masukkan Kata Sandi...';
$lang['file_DOWNLOAD_LS'] = 'Loading...';
$lang['file_DOWNLOAD_WAITING'] = 'Silahkan tunggu';
$lang['file_DOWNLOAD_SECONDS'] = 'detik';
$lang['file_DOWNLOAD_PINV'] = 'Kata sandi Anda salah. Mohon periksa kembali!';
$lang['file_DOWNLOAD_CONFIRM_AYS'] = 'Apakah Anda Yakin?';
$lang['file_DOWNLOAD_CONREP_TEXT'] = 'Berkas yang Anda laporkan akan kami tinjau dahulu. Jika berkas melanggar aturan maka akan segera dihapus permanen.';
$lang['file_DOWNLOAD_REPSS'] = 'Loading...';
$lang['file_DOWNLOAD_REPCANC'] = 'Terima kasih, Anda baru saja membatalkan tindakan Anda.';
$lang['file_DOWNLOAD_NHA'] = 'belum memasang iklan apa pun.';
$lang['file_DOWNLOAD_AE'] = 'Terjadi kesalahan!';
$lang['file_DOWNLOAD_SA'] = 'Iklan Bersponsor';
$lang['file_DOWNLOAD_DNSB'] = 'Browser Anda tidak mendukung pemutaran media ini. Silahkan tingkatkan browser Anda ke versi yang terbaru.';
$lang['file_DOWNLOAD_LF'] = 'Berkas Terbaru:';
$lang['file_DOWNLOAD_NF'] = 'Tidak ada berkas.';
$lang['file_DOWNLOAD_SHARE'] = 'Bagikan Ke';
$lang['file_DOWNLOAD_AC'] = 'Tambahkan Komentar';


// Ads Premium
$lang['userAds_PREMIUM'] = 'Iklan Premium';
$lang['userAds_PREMIUM_PREVIEW'] = 'Pratinjau Iklan';
$lang['userAds_PREMIUM_NA'] = 'Anda belum memiliki iklan premium';
$lang['userAds_PREMIUM_ACTIVE'] = 'Aktif Hingga: ';
$lang['userAds_PREMIUM_LEFT'] = 'hr';
$lang['userAds_PREMIUM_UA'] = 'Unit Iklan Anda';
$lang['userAds_PREMIUM_PFIYAU'] = 'Mohon masukkan unit iklan Anda!';
$lang['userAds_PREMIUM_LEFT2'] = 'Durasi Iklan';
$lang['userADS_PREMIUM_CLEAR'] = 'Bersihkan';
$lang['userADS_PREMIUM_UPDATE'] = 'Perbarui';
$lang['userADS_PREMIUM_CREATE'] = 'Buat Iklan';
$lang['userAds_PREMIUM_NOTE'] = '<b>Catatan:</b>';
$lang['userAds_PREMIUM_NOTE2'] = 'Iklan premium Anda akan ditempatkan di halaman strategis tanpa random dengan iklan Admin. Untuk mengaktifkan iklan Anda, silahkan Anda hubungi';
$lang['userAds_PREMIUM_EC'] = 'Mohon masukkan unit iklan Anda.';
$lang['userAds_PREMIUM_IE'] = 'Unit iklan hanya mendukung HTML dan JavaScript.';
$lang['userAds_PREMIUM_S'] = 'Iklan Anda berhasil diperbarui.';
$lang['userAds_PREMIUM_F'] = 'Iklan Anda gagal diperbarui.';
$lang['userAds_PREMIUM_E'] = 'Masa aktif iklan premium Anda telah habis pada';

// Upgrade Account
$lang['user_UPGRADE_ACCOUNT'] = 'Upgrade Akun';
$lang['user_UPGRADE_BENEFITS'] = '<b>Keuntungan:</b>
  <br/>
  <i class="fas fa-check-circle text-success"></i> Bebas iklan acak dengan iklan Admin.
  <br/>
  <i class="fas fa-check-circle text-success"></i> 2x kapasitas penyimpanan.
  <br/>
  <i class="fas fa-check-circle text-success"></i> 2x batas maksimal per unggah berkas.
  <br/>
  <i class="fas fa-check-circle text-success"></i> Pemasangan iklan tanpa persetujuan.
  <br/>
  <i class="fas fa-check-circle text-success"></i> Dan berbagai fitur menarik akun premium lainnya.
  <br/>';
$lang['user_UPGRADE_I'] = 'Upgrade akun sekarang ke versi premium dan dapatkan beragam keuntungan dengan harga terjangkau seumur hidup.';
$lang['user_UPGRADE_CONFIRM'] = 'Konfirmasi Pembayaran';
$lang['user_UPGRADE_CONFIRM2'] = 'Konfirmasi pembayaran akan dianggap sah hanya cukup memberikan bukti pembayaran berupa nomor resi atau nomor referensi pembayaran.';
$lang['user_UPGRADE_CS'] = 'Bukti pembayaran telah diterima. Permintaan upgrade akun sedang diperiksa.';
$lang['user_UPGRADE_CF'] = 'bukti pembayaran Anda gagal dikonfirmasi.';
$lang['user_UPGRADE_PROOF'] = 'Bukti Pembayaran';
$lang['user_UPGRADE_CI'] = 'Oops! terjadi kesalahan.';

// Index
$lang['index_WELCOME'] = 'Selamat Datang di';
$lang['index_NO_C'] = 'Belum tersedia berkas apapun. Jadilah yang pertama mengunggah berkas di sini.';

// Contact Us
$lang['contact_EMAIL'] = 'Butuh pertanyaan seputar situs kami atau ingin beriklan? silahkan hubungi kami via email di bawah ini.';

// Terms of service
$lang['tos'] = 'Anda dapat mengunggah berkas apapun kecuali berkas terlarang dan membahayakan situs kami. Mohon pengertiannya demi kenyamanan komunitas kami.';
?>