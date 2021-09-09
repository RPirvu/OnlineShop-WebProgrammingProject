-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2021 at 10:16 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pw`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cat_slug` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `cat_slug`) VALUES
(1, 'Laptops', 'laptops'),
(2, 'Desktop PC', 'desktop-pc'),
(3, 'Tablets', 'tablets'),
(4, 'Smart Phones', '');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(255) NOT NULL,
  `Name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `Name`, `Email`, `comments`) VALUES
(1, 'Alexandru-Constantin Mihoc', 'alexandru.mihoc99@e-uvt.ro', 'buna'),
(2, 'Alexandru-Constantin Mihoc', 'alexandru.mihoc99@e-uvt.ro', 'sal'),
(3, 'Alexandru-Constantin Mihoc', 'alexandru.mihoc99@e-uvt.ro', 'Sal'),
(4, 'Alexandru-Constantin Mihoc', 'alexandru.mihoc99@e-uvt.ro', 'gggasd'),
(5, 'Alexandru-Constantin Mihoc', 'alexandru.mihoc99@e-uvt.ro', 'Salut');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`id`, `sales_id`, `product_id`, `quantity`) VALUES
(14, 9, 11, 2),
(15, 9, 13, 5),
(16, 9, 3, 2),
(17, 9, 1, 3),
(18, 10, 13, 3),
(19, 10, 2, 4),
(20, 10, 19, 5),
(21, 11, 30, 2),
(22, 12, 40, 1),
(23, 13, 50, 1),
(24, 14, 36, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(200) NOT NULL,
  `price` double NOT NULL,
  `photo` varchar(200) NOT NULL,
  `date_view` date NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `slug`, `price`, `photo`, `date_view`, `counter`) VALUES
(30, 1, 'Apple MacBook Air 13-inch', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"3\">\r\n			<p><strong>Laptop Apple MacBook Air 13-inch, True Tone, procesor Apple M1 , 8 nuclee CPU si 7 nuclee GPU, 8GB, 256GB, Space Grey, INT KB</strong></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"3\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"3\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"3\">\r\n			<p><strong>Putere. Este in Aer.</strong></p>\r\n\r\n			<p>Cel mai subtire si mai usor notebook-ul nostru, complet transformat de cipul Apple M1. Viteza procesorului de pana la de 3,5 ori mai rapida. Viteza GPU-ului de pana la 5 ori mai rapida. Cel mai avansat motor neuronal pentru invatare automata de pana la de 9 ori mai rapida. Cea mai mare autonomie a bateriei vreodata pe un MacBook Air. Si un design silentios, fanless. Atata putere nu a fost niciodata atat de pregatita.</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'apple-macbook-air-13-inch', 900, 'apple-macbook-air-13-inch_1630173729.jpg', '2021-09-04', 2),
(31, 1, 'Acer Nitro 5 AN515-55-5317', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Laptop Gaming Acer Nitro 5 AN515-55-5317 cu procesor Intel&reg; Core&trade; i5-10300H pana la 4.50 GHz, 15.6&quot;, IPS, 144Hz, 8GB, 512GB SSD, NVIDIA&reg; GeForce&reg; GTX 1650Ti 4GB, No OS, Black</strong></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>Intensitate vizuala</strong><br />\r\n			Exploreaza jocurile in mai multe detalii, cu imaginile clare oferite de afisajul IPS FHD de 15,6&rdquo;. Bucura-te de jocuri neintrerupte, cu imagini fara estompare.</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>Specificatii principale</strong><br />\r\n			Domina lumea jocurilor cu puterea combinata a unui procesor Intel&reg; Core&trade; i5 de a 10-a generatie si a placii grafice NVIDIA&reg; GeForce&reg; GTX 1650Ti. Configureaza-ti laptopul pentru viteza maxima si spatiu de stocare masiv si 8GB de RAM DDR4. Capacitatea mare a bateriei sustine o autonomie mai lunga.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'acer-nitro-5-an515-55-5317', 500, 'acer-nitro-5-an515-55-5317.jpg', '2021-09-06', 1),
(32, 1, 'ASUS TUF FX505DT', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><strong>Laptop Gaming ASUS TUF FX505DT cu procesorAMD Ryzen&trade; 7 3750H pana la 4.00 GHz, 15.6&quot;, Full HD, 144Hz, 16GB, 512GB SSD, NVIDIA&reg; GeForce&reg; GTX 1650 4GB, Free DOS, Stealth Black</strong></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><img alt=\"\" src=\"https://s13emagst.akamaized.net//products/20276/20275745/media/res_7bd37817a6b7d9f93202f0dd1749e28f.png\" style=\"height:src=; width:src=\" /></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">Bucurati-va de un joc mai inteligent, cu noul ASUS TUF Gaming FX505 AMD Edition. Dispunand de un display NanoEdge de ultima generatie IPS cu tehnologia AMD&reg; FreeSync&trade; si echipat cu cel mai recent procesor AMD Ryzen&trade; si grafica dedicata, acesta ofera gaming de inalta performanta la un pret accesibil. Este, de asemenea, testat si certificat conform standardelor militare MIL-STD-810G, astfel incat sa aveti garantata duritatea si durabilitatea pe termen lung.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'asus-tuf-fx505dt', 700, 'asus-tuf-fx505dt.webp', '2021-08-28', 2),
(33, 1, 'Lenovo IdeaPad 3 15IMH05', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><strong>Laptop Gaming Lenovo IdeaPad 3 15IMH05 cu procesor Intel Core i5-10300H pana la 4.50 GHz, 15.6&quot;, Full HD, IPS, 8GB, 256GB SSD, NVIDIA GeForce GTX 1650 Ti 4GB, Free DOS, Onyx Black&nbsp;</strong></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Experimentati gaming-ul ca niciodata pe IdeaPad Gaming 3 alimentat de procesoarele Intel&reg; Core &trade; H de 10th gen. Jucati si transmiteti cele mai noi titluri AAA la performante maxime pe IdeaPad Gaming 3 cu frecvente de pana la 4.5 GHz, 6 nuclee, 8MB si Intel&reg; Smart Cache.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'lenovo-ideapad-3-15imh05', 450, 'lenovo-ideapad-3-15imh05.webp', '2021-08-28', 3),
(34, 1, 'ASUS ROG Strix G15 ', '<p><strong>Laptop Gaming ASUS ROG Strix G15 cu procesor AMD Ryzen&trade; 9 5900HX, 15.6&quot;, Full HD, 300Hz, 16GB, 1TB SSD, NVIDIA&reg; GeForce RTX&trade; 3060 6GB, No OS, Eclipse Gray&nbsp;</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Puterea de foc perfect concentrata in ROG Strix G15/17 optimizeaza si imbunatateste experienta de jocuri sub Windows 10 Pro. Echipat cu un procesor puternic pana la AMD Ryzen&trade; 9 5900HX si GPU GeForce RTX&trade; 3060, toate sarcinile de utilizare, de la jocuri la productivitate, sunt rulate rapid si fluid. Accelereaza la maxim vitezele in jocuri cu ajutorul ecraului FHD de pana la 300Hz/3ms. Tehnologia de Sincronizare Adaptiva iti permite sa te bucuri de o experienta extrem de cursiva in jocuri, in timp ce imbunatatirile avansate ale sistemului de racire mentin temperaturile scazute in orice situatie. Acum te poti bucura de experienta perfecta in jocuri, indiferent care ar fi nevoile tale.</p>\r\n', 'asus-rog-strix-g15', 800, 'asus-rog-strix-g15_1630174436.jpg', '2021-08-28', 2),
(35, 2, 'Serioux   AMD Ryzen 5, RX 550 2GB', '<p><strong>istem Desktop PC Gaming Serioux cu procesor AMD Ryzen&trade; 5 1600AF pana la 3.60GHz, 8GB DDR4, 500GB SSD, Radeon&trade; RX 550 2GB GDDR5, No OS</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td><strong>Un nou standard pentru performanta si eficienta</strong><br />\r\n			Arhitectura AMD de inalta performanta x86 &quot;Zen&quot; ofera o imbunatatire de 52% in IPC peste generatia anterioara AMD, cu un consum redus.</td>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>Procesare avansata</strong><br />\r\n			Procesoarele revolutionare AMD Ryzen sunt concepute pentru a va aduce experienta si tehnologia de ultima generatie atunci cand lucrati sau va jucati.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'serioux-amd-ryzen-5-rx-550-2gb', 399, 'pc-serioux_1630174621.webp', '2021-08-28', 2),
(36, 2, 'Fenrir, AMD Ryzen 7 5800X, RX 6700 XT 12GB', '<p>C Gaming Fenrir, AMD Ryzen 7 5800X 3.8GHz, 16GB DDR4, 128GB SSD + 2TB SSD, RX 6700 XT 12GB GDDR6, Iluminare RGB, Windows 10 Home preinstalat (Game Ready)</p>\r\n', 'fenrir-amd-ryzen-7-5800x-rx-6700-xt-12gb', 1199, 'fenrir-amd-ryzen-7-5800x-rx-6700-xt-12gb.jpg', '2021-09-07', 1),
(37, 2, 'Office Start A3', '<p>Procesorul AMD Athlon 3000G iti ofera productivitatea de care ai nevoie la birou si te ajuta sa iti indeplinesti task-urile rapid si eficient.</p>\r\n\r\n<p>Este ideal pentru conferinte audio-video, multi-tasking si proiecte pentru scoala.&nbsp;</p>\r\n\r\n<p>Este echipat 8 GB RAM, pentru ca toate activitatile tale sa se desfasoare rapid si sa te poti bucura de multi-tasking.</p>\r\n', 'office-start-a3', 299, 'office-start-a3.jpg', '2021-08-28', 2),
(38, 2, 'Corvus, AMD Ryzen 3 4300GE , AMD Radeon™ Vega 6', '<p>PC Gaming Corvus, AMD Ryzen 3 4300GE 3.5GHz, 4 nuclee, 16GB DDR4, 240GB SSD, AMD Radeon&trade; Vega 6</p>\r\n', 'corvus-amd-ryzen-3-4300ge-amd-radeon-vega-6', 600, 'corvus-amd-ryzen-3-4300ge-amd-radeon-vega-6.jpg', '2021-08-28', 2),
(39, 2, 'FirstGear Pike, Intel i3-10100F, RX 560 4GB', '<p>PC FirstGear Gaming Pike, Intel i3-10100F 3.6GHz, 8GB DDR4, 240GB SSD, RX 560 4GB GDDR5, Iluminare RGB</p>\r\n', 'firstgear-pike-intel-i3-10100f-rx-560-4gb', 300, 'firstgear-pike-intel-i3-10100f-rx-560-4gb.jpg', '2021-08-28', 1),
(40, 4, 'Apple iPhone 11', '<p>Sistem nou cu doua camere. Baterie pentru toata ziua. Cea mai rezistenta sticla folosita&nbsp; vreodata intr-un smartphone. Cel mai rapid procesor Apple din toate timpurile.</p>\r\n', 'apple-iphone-11', 599, 'iphone-11.jpg', '2021-09-04', 2),
(41, 4, 'Huawei P40 Lite', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><strong>Telefon mobil Huawei P40 Lite, Dual SIM, 128GB, 6GB RAM, 4G, Crush Green</strong></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><img alt=\"\" src=\"https://s13emagst.akamaized.net//products/21749/21748768/media/res_7b39d5744a599e450081311b0c179d39.jpg\" style=\"height:src=; width:src=\" /></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Dispozitivele Huawei care au logo-ul &quot;Explore it on AppGallery&quot; sunt echipare cu Huawei Mobile Services si AppGallery ca magazin oficial de aplicatii.</p>\r\n\r\n			<p>Acestea folosesc in continuare Android ca sistem de opera si EMUI 10 dar nu sunt livrate cu PlayStore sau alte aplicatii Google preinstalate.</p>\r\n\r\n			<p>Ecosistemul Huawei este in continua crestere de la o saptamana la alta. Din ce in ce mai multe aplicatii locale si internationale pot fi descarcate direct din AppGallery.</p>\r\n\r\n			<p>In continuare vezi cele mai usoare metode de a iti instala aplicatiile favorite pe nou tau telefon.</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'huawei-p40-lite', 250, 'huawei-p40-lite.webp', '2021-08-28', 1),
(42, 4, 'Samsung Galaxy A12', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><strong>Telefon mobil Samsung Galaxy A12, Dual SIM, 32GB, 4G</strong></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><strong>Mai putina margine, mai mult ecran</strong></p>\r\n\r\n			<p>Extinde modul de vizualizare cu ajutorul ecranului Infinity-V de 6,5 inci al noului Galaxy A12&nbsp;si vezi cum un ecran mai mic iti ofera mai multa vizualizare. Datorita tehnologiei HD+, continutul tau de zi cu zi arata cel mai bine - detaliat, conturat si clar.</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'samsung-galaxy-a12', 600, 'samsung-galaxy-a12.webp', '2021-08-28', 1),
(43, 4, 'Samsung Galaxy S10', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\"><strong>elefon mobil Samsung Galaxy S10, Dual SIM, 128GB, 8GB RAM, 4G, Black</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\"><img alt=\"\" src=\"https://s13emagst.akamaized.net//products/13449/13448559/media/res_759e8929c9399d002c320c0ca3321919.jpg?width=200&amp;height=40&amp;hash=5B0909FD7FC73D3E1B949A0EA9AD554D\" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p>Avand in spate 10 ani de pionierat si de premiere in domeniu, Galaxy iti aduce urmatoarea generatie de inovatii mobile.</p>\r\n\r\n			<p><strong>&nbsp;Urmatoarea generatie de telefoane Galaxy este aici.</strong></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><strong>Telefonul care nu doar iese in evidenta, dar se si distanteaza de celelalte.</strong></p>\r\n\r\n			<p><br />\r\n			Recreat complet pentru o experienta de vizionare neintrerupta. Fara margini care sa-ti distraga atentia. Ecranul elegant Infinity-O Display, decupat perfect cu laserul, cu securitate sporita si Dynamic AMOLED, este cel mai inovator ecran Galaxy de pana acum.</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'samsung-galaxy-s10', 700, 'samsung-galaxy-s10.webp', '2021-08-28', 1),
(44, 4, 'Xiaomi Redmi Note 10 Pro', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><strong>Telefon mobil Xiaomi Redmi Note 10 Pro, Dual SIM, 128GB, 8GB RAM, 4G, Onyx Gray</strong></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><strong>Faceti fata limitelor datorita celor 108 MP</strong></p>\r\n\r\n			<p><strong>Sistem de imagine de ultima generatie foarte clar, super interesant</strong></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'xiaomi-redmi-note-10-pro', 400, 'xiaomi-redmi-note-10-pro.jpg', '2021-08-28', 1),
(45, 3, 'Apple iPad 8 ', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><strong>Iti permiti atata putere</strong></p>\r\n\r\n			<p>Noul iPad imbina capabilitatea formidabila cu usurinta in utilizare si adaptabilitatea fara precedent. Odata cu puternicul cip Bionic A12, compatibilitatea cu Apple Pencil si Smart Keyboard, precum si cu lucrurile noi, uimitoare pe care le poti face cu iPadOS 14, acum ai si mai multe motive sa iubesti iPad.</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p><strong>Rezolva multe deodata, indata</strong></p>\r\n\r\n			<p>Cu iPad, munca devine o adevarata placere. Editeaza un document in timp ce cauti ceva pe internet si suni un coleg pe FaceTime in acelasi timp. Ataseaza tastatura Smart Keyboard de dimensiuni standard pentru tastare comoda<a href=\"https://www.emag.ro/apple-ipad-8-2020-10-2-32gb-wi-fi-space-grey-myl92hc-a/pd/DTS172MBM/\">1</a>. Iar pentru sarcinile care necesita mai multa precizie, compatibilitatea cu un trackpad sau mouse completeaza experienta familiara Multi-Touch a iPad-ului.</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'apple-ipad-8', 220, 'apple-ipad-8.webp', '2021-08-28', 1),
(46, 3, 'Huawei MatePad T10', '<p>Dispozitivele Huawei care au logo-ul &quot;Explore it on AppGallery&quot; sunt echipare cu Huawei Mobile Services si AppGallery ca magazin oficial de aplicatii.</p>\r\n\r\n<p>Acestea folosesc in continuare Android ca sistem de opera si EMUI 10 dar nu sunt livrate cu PlayStore sau alte aplicatii Google preinstalate.</p>\r\n\r\n<p>Ecosistemul Huawei este in continua crestere de la o saptamana la alta. Din ce in ce mai multe aplicatii locale si internationale pot fi descarcate direct din AppGallery.</p>\r\n\r\n<p>In continuare vezi cele mai usoare metode de a iti instala aplicatiile favorite pe nou tau telefon.</p>\r\n', 'huawei-matepad-t10', 190, 'huawei-matepad-t10_1630176635.webp', '2021-08-28', 1),
(47, 3, 'Samsung Galaxy Tab S6 Lite', '<table align=\"center\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\"><strong>Tableta Samsung Galaxy Tab S6 Lite, Octa-Core, 10.4&quot;, 4GB RAM, 64GB, 4G, Oxford Gray</strong></td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\"><img alt=\"\" src=\"https://s13emagst.akamaized.net//products/4/3857/media/res_f5a43ad2b0930dd801d1922a89c4e094.jpg?width=200&amp;height=31&amp;hash=A4F210314E7408454625EBF1024AC09E\" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\"><strong>Modifica modul in care notezi</strong><br />\r\n			Galaxy Tab S6 Lite este insotitorul tau permanent, un sistem de notare usor de transportat. Este dotat cu un ecran mare, de 10,4 inci, cu o constructie subtire si usoara, One UI 2 pe Android, S Pen in cutie si esti gata de plecare. Indiferent daca desenezi, inveti sau te joci, aceasta este tableta momentului.</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'samsung-galaxy-tab-s6-lite', 250, 'samsung-galaxy-tab-s6-lite.webp', '2021-08-28', 1),
(48, 3, 'Lenovo P11 Pro', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Tableta Lenovo P11 Pro, Octa-Core , 11.5&quot; OLED, 6GB RAM, 128GB , WiFi, Slate Grey</strong></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><strong>Afisaj de ultima generatie pentru magie cinematografica</strong></p>\r\n\r\n			<p>Urmariti magia cinematografiei care prinde viata pe ecranul OLED de 11.5 inci (2560 x 1600) al Lenovo Tab P11 Pro. Dolby Vision ofera imagini vii, realiste, cu contraste mai clare, luminozitate orbitoare si paleta de culori remarcabila. Iar cu certificarea T&Uuml;V Rheinland pentru confortul ochilor, sesiunile de vizionare de tip maraton nu va vor strica ochii.</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 'lenovo-p11-pro', 170, 'lenovo-p11-pro.jpg', '2021-08-28', 1),
(50, 3, 'TOSCIDO,10.1', '<p><strong>Tableta TOSCIDO,10.1&quot;, Octa-Core, 4GB RAM, 128GB ROM, Android 10.0, 1920*1200, 2GHz, 4G LTE, Argintru</strong></p>\r\n\r\n<p><strong>Detalii produs:</strong></p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Ecran HD:&nbsp;<strong>1920 * 1200 IPS</strong>&nbsp;de 10,1&quot;;</p>\r\n	</li>\r\n	<li>\r\n	<p>Limba suport: romana</p>\r\n	</li>\r\n	<li>\r\n	<p>Procesor: Octa-core&nbsp; 2 GHz;</p>\r\n	</li>\r\n	<li>\r\n	<p>RAM:&nbsp;<strong>4 GB</strong>;&nbsp;</p>\r\n	</li>\r\n	<li>\r\n	<p>Capacitate de stocare incorporata:&nbsp;<strong>128&nbsp;GB</strong>;</p>\r\n	</li>\r\n	<li>\r\n	<p>Sistem:&nbsp;<strong>Android 10.0</strong>;</p>\r\n	</li>\r\n	<li>\r\n	<p>Slot pentru card de memorie:&nbsp;128 GB;</p>\r\n	</li>\r\n	<li>\r\n	<p>4G LTE &amp; WIFI, dual SIM card dual standby;</p>\r\n	</li>\r\n	<li>\r\n	<p>Navigare GPS;</p>\r\n	</li>\r\n	<li>\r\n	<p>Camera spate de 5 MP;&nbsp;</p>\r\n	</li>\r\n	<li>\r\n	<p>Camera frontala de 2 MP;</p>\r\n	</li>\r\n	<li>\r\n	<p>Baterie de lunga durata de 5000 mAh;</p>\r\n	</li>\r\n	<li>\r\n	<p>Certificat de Google GMS.</p>\r\n	</li>\r\n</ul>\r\n', 'toscido-10-1', 120, 'toscido-10-1.webp', '2021-09-05', 4);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pay_id` varchar(50) NOT NULL,
  `sales_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `pay_id`, `sales_date`) VALUES
(11, 14, 'PAYID-MEZZI2A8W384189FC8283344', '2021-09-04'),
(12, 14, 'PAYID-MEZZJ7Q3EY16924PY353960C', '2021-09-04'),
(13, 14, 'PAYID-MEZZPVY0A861934FP391184T', '2021-09-04'),
(14, 14, 'PAYID-ME3344I0WC4007309531014K', '2021-09-07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(60) NOT NULL,
  `type` int(1) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `activate_code` varchar(15) NOT NULL,
  `reset_code` varchar(15) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `type`, `firstname`, `lastname`, `address`, `contact_info`, `photo`, `status`, `activate_code`, `reset_code`, `created_on`) VALUES
(2, 'admin@gmail.com', '$2y$10$f5vJXzXB68MWwi3JBni9yuAlMKZYryCuF5z48V5X7QwKOF2aRI9RK', 1, 'Admin', '', '', '', 'male2.png', 1, '', '', '2021-08-01'),
(14, 'test@gmail.com', '$2y$10$c5sIb.RQvtkWOf/LmVLnl.4ULQEGtb2TJp7BfRDPbLwQudRfVmcPa', 0, 'Test', 'Testus', '', '', '', 1, 's1uHqwC3IgtY', '', '2021-08-29'),
(15, 'user@gmail.com', '$2y$10$NrkJdz6ffSa5VpTF.sFj2O/cLeSH1KPXhLF2r.THRCHw6yV9htmFq', 0, 'User', 'Utilizerus', '', '', '', 0, 'Fix23KSUEcvb', '', '2021-08-29'),
(16, 'user1@gmail.com', '$2y$10$s4rLopnFroM02XlhcICAweJTboWeoHJjqBUphKO.lkyLaz8K/DnMC', 0, 'User', 'One', '', '', '', 0, 'lPergv8hA6Ey', '', '2021-08-29'),
(23, 'test2@gmail.com', '$2y$10$HCx2/XZLgYDsbVlZkMMRmeUVlwinR1aLM6YAHHjirg8iZ1mPze9KW', 0, 'Pirvu', 'Robert', '', '', '', 0, 'bj2cQluSFIsm', '', '2021-08-29'),
(24, 'test3@gmail.com', '$2y$10$Y68Q1ZUNbmzJMNehioZKDuIYKGXsb3aT5EKATqdG7AzxcpWDEjVYa', 0, 'Pirvu', 'Robert', '', '', '', 0, 'p7LcI42xGbTs', '', '2021-08-29'),
(25, 'test4@gmail.com', '$2y$10$ZIPtICtr0B4hDTYlIFwoAONV2HQ68hfTEqQidDwyJtZ.pNBKwEYSO', 0, 'Pirvu', 'Robert', '', '', '', 0, '3rHhfdab2PU6', '', '2021-08-29'),
(26, 'test5@gmail.com', '$2y$10$kRZCCOhMaGfyrZpaZxzNPeyoo1feqxJF54MgYmhizXO7bc7XXjU2W', 0, 'Pirvu', 'Robert', '', '', '', 0, '5iDIz9BpaANm', '', '2021-08-29'),
(28, 'test55@gmail.com', '$2y$10$f5vJXzXB68MWwi3JBni9yuAlMKZYryCuF5z48V5X7QwKOF2aRI9RK', 0, 'Pirvu', 'Robert', '', '', '', 0, '6QGUjO4NLmuX', '', '2021-08-29'),
(31, 'alexandru.mihoc99@gmail.com', '$2y$10$tE337fsQ5M3ofo5Gh.T57OfTPFGKsXlio8nMTgZ.eILpIPSrLLEP2', 0, 'Alextest', 'Mihoctest', '', '', '', 1, 'UxijoVdqlemI', '', '2021-09-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
