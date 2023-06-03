-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2023 at 04:34 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evote`
--

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` bigint(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Ilmu Pengetahuan Alam', '2023-05-24 09:56:56', '2023-05-24 09:56:56'),
(3, 'Ilmu Pengetahuan Sosial', '2023-05-24 14:28:42', '2023-05-24 14:28:42'),
(7, 'My Anime List', '2023-06-01 07:29:57', '2023-06-01 07:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `kandidats`
--

CREATE TABLE `kandidats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ketua` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kelas_ketua` bigint(11) DEFAULT NULL,
  `nama_wakil` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kelas_wakil` bigint(11) DEFAULT NULL,
  `visi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `misi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pemilihan` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kandidats`
--

INSERT INTO `kandidats` (`id`, `image`, `nama_ketua`, `id_kelas_ketua`, `nama_wakil`, `id_kelas_wakil`, `visi`, `misi`, `id_pemilihan`, `created_at`, `updated_at`) VALUES
(1, 'images/1684936421.jpg', 'Kato', 1, 'Megumi', 2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet esse facere iure obcaecati dolores cum et? Quos officiis dolores, dolor quibusdam, nihil expedita commodi vitae fuga aut enim nostrum alias sequi obcaecati. Corrupti laborum porro possimus voluptatibus nam commodi quia ipsa totam eum recusandae, non odio atque illum, ullam doloremque?', 'my anime list', 3, '2023-05-24 06:34:38', '2023-05-24 06:53:41'),
(2, 'images/1684936421.jpg', 'Katos', 1, 'Megumis', 2, 'menamatkan anime', 'my anime list', 3, '2023-05-24 06:34:38', '2023-05-24 06:53:41'),
(3, 'images/1685464371.jpg', 'Tomoya Aki', 1, 'Megumi Kato', 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2023-05-30 09:32:51', '2023-05-30 09:32:51'),
(4, 'images/1685464394.png', 'Kano', 1, 'Meguri', 2, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2023-05-30 09:33:14', '2023-05-30 09:33:14');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(255) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `id_jurusan` bigint(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama`, `id_jurusan`, `created_at`, `updated_at`) VALUES
(1, 'X IPA 1', 1, '2023-05-24 09:56:37', '2023-05-24 09:56:37'),
(2, 'X IPA 2', 1, '2023-05-24 14:14:20', '2023-05-24 14:14:20');

-- --------------------------------------------------------

--
-- Table structure for table `pemilihans`
--

CREATE TABLE `pemilihans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pemilihan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL DEFAULT current_timestamp(),
  `tanggal_selesai` date NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemilihans`
--

INSERT INTO `pemilihans` (`id`, `nama_pemilihan`, `image`, `deskripsi`, `status`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `updated_at`) VALUES
(1, 'Pemilihan Ketua OSIS', 'images/1685544598.png', 'Kato Megumi Cantik', 'active', '2023-05-20', '2023-06-21', '2023-05-24 10:32:22', '2023-05-31 07:49:58'),
(3, 'Pemilihan Kepala Sekolah', 'images/1684929842.png', 'myanuimelist', 'active', '2023-05-28', '2023-05-29', '2023-05-24 04:47:40', '2023-05-24 05:04:02'),
(7, 'Pemilihan Ketua PADI', 'images/1685572734.png', 'tidak ada deskripsi', 'active', '2023-06-01', '2023-06-30', '2023-05-31 15:38:54', '2023-05-31 15:38:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kelas` bigint(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nis`, `name`, `email`, `id_kelas`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, '21313', 'katowww', 'anime@mail.com', 2, NULL, '$2y$10$0RyHV1GWvMW1RtvAB2qSIeX6JuP0GfQ8cZcD/aM8Odwwp9s0APidO', 'user', NULL, '2023-05-24 03:12:59', '2023-05-30 03:36:10'),
(5, '', 'anime', 'admin@mail.com', NULL, NULL, '$2a$12$0IGmUUw1lQhkizvjdaymIu56j5Zpzb0C8k87lCYI/P6X1js0ftM8m', 'admin', NULL, '2023-05-24 10:18:16', '2023-05-24 10:18:16'),
(7, '213123', 'juned', 'animes@mail.com', 1, NULL, '$2y$10$MWa7v4D1lFLoKF5Bpcxf5O8aUpkUynbdlION8S4EXJcTh.N.nTrNu', 'user', NULL, '2023-05-24 06:26:00', '2023-06-01 07:33:02'),
(8, '2131223', 'jafar', 'animesa@mail.com', 1, NULL, '$2y$10$lr00Dqyd9Zk9t774tY6Ie.imVeC7bzUBr4sNme3XsJauFlwHe/WHK', 'user', NULL, '2023-05-30 01:33:25', '2023-06-01 07:33:09');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kandidat_id` bigint(20) UNSIGNED NOT NULL,
  `pemilihan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `kandidat_id`, `pemilihan_id`, `created_at`, `updated_at`) VALUES
(2, 7, 1, 3, NULL, NULL),
(3, 8, 1, 3, NULL, NULL),
(6, 4, 1, 3, '2023-05-30 09:18:52', '2023-05-30 09:18:52'),
(7, 4, 4, 1, '2023-05-30 09:33:56', '2023-05-30 09:33:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kandidats`
--
ALTER TABLE `kandidats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kandidats_pemilihan_id_foreign` (`id_pemilihan`),
  ADD KEY `id_kelas_ketua` (`id_kelas_ketua`),
  ADD KEY `id_kelas_wakil` (`id_kelas_wakil`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indexes for table `pemilihans`
--
ALTER TABLE `pemilihans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votes_user_id_foreign` (`user_id`),
  ADD KEY `votes_kandidat_id_foreign` (`kandidat_id`),
  ADD KEY `votes_pemilihan_id_foreign` (`pemilihan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kandidats`
--
ALTER TABLE `kandidats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pemilihans`
--
ALTER TABLE `pemilihans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kandidats`
--
ALTER TABLE `kandidats`
  ADD CONSTRAINT `kandidats_ibfk_1` FOREIGN KEY (`id_kelas_ketua`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `kandidats_ibfk_2` FOREIGN KEY (`id_kelas_wakil`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `kandidats_pemilihan_id_foreign` FOREIGN KEY (`id_pemilihan`) REFERENCES `pemilihans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_kandidat_id_foreign` FOREIGN KEY (`kandidat_id`) REFERENCES `kandidats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_pemilihan_id_foreign` FOREIGN KEY (`pemilihan_id`) REFERENCES `pemilihans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
