-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 12 Haz 2022, 09:25:47
-- Sunucu sürümü: 10.4.24-MariaDB
-- PHP Sürümü: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `sis`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attendances`
--

CREATE TABLE `attendances` (
  `student_number` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `absence` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `attendances`
--

INSERT INTO `attendances` (`student_number`, `lesson_id`, `absence`) VALUES
(2018556069, 1, 12),
(2018556070, 1, 5);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL,
  `head_lecturer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `faculty_id`, `head_lecturer`) VALUES
(1, 'Computer Engineering (English) (EC)', 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exams`
--

CREATE TABLE `exams` (
  `exam_id` int(11) NOT NULL,
  `exam_name` varchar(255) NOT NULL,
  `exam_ratio` int(11) DEFAULT 0,
  `lesson_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `exams`
--

INSERT INTO `exams` (`exam_id`, `exam_name`, `exam_ratio`, `lesson_id`) VALUES
(52, 'Application', 100, 1),
(55, 'Midterm Exam', 40, 2),
(56, 'Final Exam', 60, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exam_notes`
--

CREATE TABLE `exam_notes` (
  `student_number` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `note` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `exam_notes`
--

INSERT INTO `exam_notes` (`student_number`, `exam_id`, `note`) VALUES
(2018556069, 52, 100),
(2018556070, 52, 55);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `faculties`
--

CREATE TABLE `faculties` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name` varchar(255) DEFAULT NULL,
  `head_lecturer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `faculties`
--

INSERT INTO `faculties` (`faculty_id`, `faculty_name`, `head_lecturer`) VALUES
(1, 'Faculty of Engineering', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lecturers`
--

CREATE TABLE `lecturers` (
  `lecturer_id` int(11) NOT NULL,
  `lecturer_fullname` varchar(255) DEFAULT NULL,
  `lecturer_email` varchar(255) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `lecturer_password` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `lecturers`
--

INSERT INTO `lecturers` (`lecturer_id`, `lecturer_fullname`, `lecturer_email`, `faculty_id`, `department_id`, `lecturer_password`, `created_at`) VALUES
(1, 'Dr. Öğr. Üyesi FATİH ABUT', 'fabut@cu.edu.tr', 1, 1, '5ef5371caefda74a46f646831966d4fed1ffae7fcdbc3ab7b0135b975f9daff6', '2022-05-22 23:38:56'),
(2, 'Prof.Dr. UMUT ORHAN', 'uorhan@cu.edu.tr', 1, 1, '5ef5371caefda74a46f646831966d4fed1ffae7fcdbc3ab7b0135b975f9daff6', '2022-05-24 02:36:26');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL,
  `lesson_code` varchar(20) NOT NULL,
  `lesson_name` varchar(255) NOT NULL,
  `lesson_akts` int(11) DEFAULT 0,
  `lesson_total_attendance` int(11) DEFAULT 14,
  `lesson_mandatory_attendance` int(11) DEFAULT 7,
  `lesson_allow_registration` int(11) DEFAULT 1,
  `lecturer_id` int(11) NOT NULL,
  `semester_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `lessons`
--

INSERT INTO `lessons` (`lesson_id`, `lesson_code`, `lesson_name`, `lesson_akts`, `lesson_total_attendance`, `lesson_mandatory_attendance`, `lesson_allow_registration`, `lecturer_id`, `semester_id`) VALUES
(1, 'CEN438', 'Graduation Thesis', 6, 14, 7, 1, 1, 1),
(2, 'CEN225', 'Computer Networks', 4, 14, 7, 1, 1, 1),
(6, 'CEN101', 'Introduction to Machine Learning', 6, 14, 0, 0, 2, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `semesters`
--

CREATE TABLE `semesters` (
  `semester_id` int(11) NOT NULL,
  `semester_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `semesters`
--

INSERT INTO `semesters` (`semester_id`, `semester_name`, `created_at`) VALUES
(1, '2021-2022 Summer', '2022-05-22 14:31:17'),
(2, '2021-2022 Winter', '2022-05-23 04:24:23'),
(3, '2020-2021 Summer', '2022-05-23 04:24:23'),
(4, '2020-2021 Winter', '2022-05-23 04:24:23');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `students`
--

CREATE TABLE `students` (
  `student_number` int(11) NOT NULL,
  `student_fullname` varchar(255) DEFAULT NULL,
  `student_ssn` varchar(255) DEFAULT NULL,
  `student_advisor` int(11) DEFAULT NULL,
  `student_semester` int(11) DEFAULT 1,
  `student_password` text DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `students`
--

INSERT INTO `students` (`student_number`, `student_fullname`, `student_ssn`, `student_advisor`, `student_semester`, `student_password`, `faculty_id`, `department_id`) VALUES
(2018556069, 'Bilal Atakan Ünal', '15149582767', 1, 1, '5ef5371caefda74a46f646831966d4fed1ffae7fcdbc3ab7b0135b975f9daff6', 1, 1),
(2018556070, 'Burak Özdoğan', '12345678911', 1, 4, '5ef5371caefda74a46f646831966d4fed1ffae7fcdbc3ab7b0135b975f9daff6', 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student_lessons`
--

CREATE TABLE `student_lessons` (
  `student_number` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `student_lessons`
--

INSERT INTO `student_lessons` (`student_number`, `lesson_id`) VALUES
(2018556069, 1),
(2018556069, 2),
(2018556070, 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`student_number`,`lesson_id`),
  ADD KEY `attendances_lessons_id_fk` (`lesson_id`);

--
-- Tablo için indeksler `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `department_faculty_id_fk` (`faculty_id`),
  ADD KEY `department_lecturer_id_fk` (`head_lecturer`);

--
-- Tablo için indeksler `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `exams_lessons_id_fk` (`lesson_id`);

--
-- Tablo için indeksler `exam_notes`
--
ALTER TABLE `exam_notes`
  ADD PRIMARY KEY (`student_number`,`exam_id`),
  ADD KEY `exam_notes_exams_id_fk` (`exam_id`);

--
-- Tablo için indeksler `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`faculty_id`),
  ADD KEY `faculty_lecturer_id_fk` (`head_lecturer`);

--
-- Tablo için indeksler `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`lecturer_id`),
  ADD KEY `lecturer_department_id_fk` (`department_id`),
  ADD KEY `lecturer_faculty_id_fk` (`faculty_id`);

--
-- Tablo için indeksler `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `lessons_lecturer_id_fk` (`lecturer_id`),
  ADD KEY `lessons_semesters_semester_id_fk` (`semester_id`);

--
-- Tablo için indeksler `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`semester_id`);

--
-- Tablo için indeksler `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_number`),
  ADD KEY `students_lecturer_id_fk` (`student_advisor`),
  ADD KEY `students_department_id_fk` (`department_id`),
  ADD KEY `students_faculty_id_fk` (`faculty_id`);

--
-- Tablo için indeksler `student_lessons`
--
ALTER TABLE `student_lessons`
  ADD PRIMARY KEY (`student_number`,`lesson_id`),
  ADD KEY `student_lessons_lessons_lesson_id_fk` (`lesson_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Tablo için AUTO_INCREMENT değeri `faculties`
--
ALTER TABLE `faculties`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `lecturer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `semesters`
--
ALTER TABLE `semesters`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_lessons_id_fk` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendances_students_number_fk` FOREIGN KEY (`student_number`) REFERENCES `students` (`student_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_faculty_id_fk` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `department_lecturer_id_fk` FOREIGN KEY (`head_lecturer`) REFERENCES `lecturers` (`lecturer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_lessons_id_fk` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `exam_notes`
--
ALTER TABLE `exam_notes`
  ADD CONSTRAINT `exam_notes_exams_id_fk` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_notes_students_number_fk` FOREIGN KEY (`student_number`) REFERENCES `students` (`student_number`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `faculties`
--
ALTER TABLE `faculties`
  ADD CONSTRAINT `faculty_lecturer_id_fk` FOREIGN KEY (`head_lecturer`) REFERENCES `lecturers` (`lecturer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `lecturers`
--
ALTER TABLE `lecturers`
  ADD CONSTRAINT `lecturer_department_id_fk` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lecturer_faculty_id_fk` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_lecturer_id_fk` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`lecturer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessons_semesters_semester_id_fk` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`semester_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_department_id_fk` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_faculty_id_fk` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_lecturer_id_fk` FOREIGN KEY (`student_advisor`) REFERENCES `lecturers` (`lecturer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `student_lessons`
--
ALTER TABLE `student_lessons`
  ADD CONSTRAINT `student_lessons_lessons_lesson_id_fk` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_lessons_students_student_number_fk` FOREIGN KEY (`student_number`) REFERENCES `students` (`student_number`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
