DROP TABLE IF EXISTS kien_bankinfo;
CREATE TABLE kien_bankinfo (
   Id int(11) NOT NULL auto_increment,
   User varchar(24) NOT NULL,
   Title varchar(255) NOT NULL,
   bank_number_account varchar(30) NOT NULL,
   Logo varchar(255) NOT NULL,
   url varchar(150) NOT NULL,
   Published tinyint(1) NOT NULL,
   PRIMARY KEY (Id),
   KEY User (User)
);

INSERT INTO kien_bankinfo VALUES('1', 'admin', 'Techcome Bank', '', '1386122732.jpg', 'http://techcombank.com.vn', '1');
INSERT INTO kien_bankinfo VALUES('2', 'admin', 'Vietcome Bank', '', '1387422768.png', 'http://www.vietcombank.com.vn', '1');
INSERT INTO kien_bankinfo VALUES('3', 'admin', 'Agri Bank', '', '1386122865.jpg', 'http://agribank.com.vn', '1');
INSERT INTO kien_bankinfo VALUES('4', 'admin', 'Vietin Bank', '', '1386122916.jpg', 'http://www.vietinbank.vn', '1');
INSERT INTO kien_bankinfo VALUES('5', 'admin', 'BIDV', '', '1386123042.jpg', 'http://www.bidv.com.vn', '1');

DROP TABLE IF EXISTS kien_catalog;
CREATE TABLE kien_catalog (
   id_catalog int(11) unsigned NOT NULL auto_increment,
   name varchar(150) NOT NULL,
   catalog_parent int(11) NOT NULL,
   publish tinyint(1) NOT NULL,
   sort_order int(11) NOT NULL,
   type varchar(50) NOT NULL,
   id_lang int(11) NOT NULL,
   PRIMARY KEY (id_catalog),
   KEY id_lang (id_lang),
   KEY id_catalog (id_catalog)
);

INSERT INTO kien_catalog VALUES('1', 'Th? ?i?n tho?i', '0', '1', '1', 'mobile', '1');
INSERT INTO kien_catalog VALUES('2', 'Th? game', '0', '1', '2', 'game', '1');
INSERT INTO kien_catalog VALUES('3', 'Th? ?a n?ng', '0', '1', '3', 'both', '1');

DROP TABLE IF EXISTS kien_chitiet_donhang;
CREATE TABLE kien_chitiet_donhang (
   id_chitiet int(11) NOT NULL auto_increment,
   id_donhang int(11) NOT NULL,
   id_pro int(11) NOT NULL,
   soluong int(11) NOT NULL,
   dongia decimal(11,2) NOT NULL,
   thanhtien decimal(11,2) NOT NULL,
   PRIMARY KEY (id_chitiet)
);


DROP TABLE IF EXISTS kien_chitiet_phieunhap;
CREATE TABLE kien_chitiet_phieunhap (
   id_chitiet int(11) NOT NULL auto_increment,
   id_phieunhap int(11) NOT NULL,
   id_pro int(11) NOT NULL,
   id_nsx int(11) NOT NULL,
   soluong int(11) NOT NULL,
   PRIMARY KEY (id_chitiet),
   KEY id_phieunhap (id_phieunhap),
   KEY id_pro (id_pro),
   KEY id_nsx (id_nsx)
);


DROP TABLE IF EXISTS kien_company;
CREATE TABLE kien_company (
   id_company int(11) NOT NULL auto_increment,
   name varchar(150) NOT NULL,
   name_eng varchar(150) NOT NULL,
   company_code varchar(20),
   logo varchar(200) NOT NULL,
   publish tinyint(1) NOT NULL,
   PRIMARY KEY (id_company),
   KEY id_company (id_company)
);

INSERT INTO kien_company VALUES('1', 'Viettel', 'Viettel', 'VT', '1386650919.jpg', '1');
INSERT INTO kien_company VALUES('2', 'Mobifone', 'Mobifone', 'MBF', '1386909626.jpg', '1');
INSERT INTO kien_company VALUES('3', 'Vinafone', 'Vinafone', 'VNF', '1386909636.jpg', '1');
INSERT INTO kien_company VALUES('4', 'Sfone', 'Sfone', 'SF', '1386909646.jpg', '1');
INSERT INTO kien_company VALUES('5', 'Beeline', 'Beeline', 'BL', '1386909657.jpg', '1');
INSERT INTO kien_company VALUES('6', 'Vietnammobile', 'Vietnammobile', 'VNMB', '1386909677.jpg', '1');
INSERT INTO kien_company VALUES('7', 'VTC', 'VTC', 'VTC', '1386909686.jpg', '1');
INSERT INTO kien_company VALUES('8', 'FPT (GATE)', 'FPT', 'FPT', '1386909708.jpg', '1');
INSERT INTO kien_company VALUES('9', 'VinaGame (Zing)', 'VinaGame', 'VinaGame', '1386909724.jpg', '1');
INSERT INTO kien_company VALUES('10', 'Net2E (Oncash)', 'Net2E (Oncash)', 'Net2E', '1386909733.jpg', '1');
INSERT INTO kien_company VALUES('11', 'Megacard', 'Megacard', 'Megacard', '1386909741.jpg', '1');

DROP TABLE IF EXISTS kien_company_catalog;
CREATE TABLE kien_company_catalog (
   id int(11) NOT NULL auto_increment,
   id_company int(11) NOT NULL,
   id_catalog int(11) unsigned NOT NULL,
   PRIMARY KEY (id),
   KEY id_company (id_company),
   KEY id_catalog (id_catalog)
);

INSERT INTO kien_company_catalog VALUES('1', '1', '1');
INSERT INTO kien_company_catalog VALUES('2', '2', '1');
INSERT INTO kien_company_catalog VALUES('3', '3', '1');
INSERT INTO kien_company_catalog VALUES('4', '4', '1');
INSERT INTO kien_company_catalog VALUES('5', '5', '1');
INSERT INTO kien_company_catalog VALUES('6', '6', '1');
INSERT INTO kien_company_catalog VALUES('7', '7', '2');
INSERT INTO kien_company_catalog VALUES('8', '8', '2');
INSERT INTO kien_company_catalog VALUES('9', '9', '2');
INSERT INTO kien_company_catalog VALUES('10', '10', '2');
INSERT INTO kien_company_catalog VALUES('11', '11', '3');

DROP TABLE IF EXISTS kien_configuration;
CREATE TABLE kien_configuration (
   id int(11) NOT NULL auto_increment,
   logo_position enum('disable','left','right') DEFAULT 'right' NOT NULL,
   ratio_image_width int(11),
   max_logo int(11),
   rows_per_page_of_product int(11),
   rows_per_page_of_search int(11),
   rows_of_home_search int(11),
   rows_per_page_product int(11),
   new_per_page int(11),
   faq_per_page int(11),
   story_per_page int(11),
   intro_per_page int(11),
   download_per_page int(11),
   latest_news int(11),
   download_basepath varchar(255) DEFAULT 'uploads/download/',
   PRIMARY KEY (id)
);


DROP TABLE IF EXISTS kien_confirm_code;
CREATE TABLE kien_confirm_code (
   id_confirm int(11) NOT NULL auto_increment,
   phone_confirm varchar(12) NOT NULL,
   email varchar(200) NOT NULL,
   code_confirm varchar(100) NOT NULL,
   publish tinyint(1) NOT NULL,
   PRIMARY KEY (id_confirm)
);


DROP TABLE IF EXISTS kien_contact;
CREATE TABLE kien_contact (
   contactid int(11) unsigned NOT NULL auto_increment,
   name varchar(32) NOT NULL,
   office varchar(128) NOT NULL,
   address varchar(192) NOT NULL,
   email varchar(128) NOT NULL,
   tel varchar(20) NOT NULL,
   title varchar(128) NOT NULL,
   titlec varchar(100) NOT NULL,
   content text NOT NULL,
   senddate date NOT NULL,
   PRIMARY KEY (contactid)
);

INSERT INTO kien_contact VALUES('1', 'kien', '', 'ghakgkha', 'iwcofms@gmail.com', '0989466069', '', '', 'N?i dung', '2013-12-17');

DROP TABLE IF EXISTS kien_currency;
CREATE TABLE kien_currency (
   CurrencyID smallint(6) unsigned NOT NULL auto_increment,
   Name varchar(12) NOT NULL,
   rate double(9,2) unsigned DEFAULT '0.00' NOT NULL,
   PRIMARY KEY (CurrencyID)
);


DROP TABLE IF EXISTS kien_donhang;
CREATE TABLE kien_donhang (
   id_donhang int(11) NOT NULL auto_increment,
   id_trangthai int(11) NOT NULL,
   tongtien decimal(11,2) NOT NULL,
   date_donhang date NOT NULL,
   dathanhtoan tinyint(1) NOT NULL,
   id_member int(11) NOT NULL,
   PRIMARY KEY (id_donhang),
   KEY id_trangthai (id_trangthai),
   KEY id_member (id_member)
);


DROP TABLE IF EXISTS kien_download;
CREATE TABLE kien_download (
   id_download int(11) NOT NULL auto_increment,
   id_catdown int(11) NOT NULL,
   title varchar(200) NOT NULL,
   images varchar(200) NOT NULL,
   intro text NOT NULL,
   content text NOT NULL,
   filename varchar(200) NOT NULL,
   onHG tinyint(1) NOT NULL,
   url varchar(200) NOT NULL,
   onUrl tinyint(1) NOT NULL,
   publish tinyint(1) NOT NULL,
   sort_order int(11) NOT NULL,
   lang_id int(11) NOT NULL,
   PRIMARY KEY (id_download),
   KEY id_download (id_download),
   KEY id_catdown (id_catdown),
   KEY lang_id (lang_id)
);


DROP TABLE IF EXISTS kien_downloadcat;
CREATE TABLE kien_downloadcat (
   id_catdown int(11) NOT NULL auto_increment,
   ten varchar(200) NOT NULL,
   publish tinyint(1) NOT NULL,
   sort_order int(11) NOT NULL,
   lang_id int(11) NOT NULL,
   PRIMARY KEY (id_catdown),
   KEY id_catdown (id_catdown),
   KEY lang_id (lang_id)
);


DROP TABLE IF EXISTS kien_his_download_softpin;
CREATE TABLE kien_his_download_softpin (
   auto int(11) NOT NULL auto_increment,
   transaction_id int(11) NOT NULL,
   softpinPinCode varchar(255) NOT NULL,
   softpinSerial varchar(255) NOT NULL,
   product_id int(11) NOT NULL,
   expiryDate varchar(200) NOT NULL,
   member_id int(10) NOT NULL,
   created datetime NOT NULL,
   PRIMARY KEY (auto)
);

INSERT INTO kien_his_download_softpin VALUES('1', '1', 'GigSW2Db+b+4eDMWL0e174M78SGV+HqY', 'BVN1001413', '1', '2015/02/17 00:00:00', '5', '2013-04-25 21:41:12');
INSERT INTO kien_his_download_softpin VALUES('2', '2', 'GigSW2Db+b+4eDMWL0e176QhLbLeYYwu', 'BVN1001414', '1', '2015/02/17 00:00:00', '5', '2013-04-25 21:44:54');
INSERT INTO kien_his_download_softpin VALUES('3', '3', 'jaB4CKftyTKC5aY5vbt0bEAyM6Qtcxkm', 'VIETTEL21000160', '2', '2015/02/17 00:00:00', '5', '2013-04-25 23:05:33');
INSERT INTO kien_his_download_softpin VALUES('4', '4', 'jaB4CKftyTKC5aY5vbt0bM+UPCJuzBk1', 'VIETTEL21000161', '2', '2015/02/17 00:00:00', '5', '2013-04-26 14:49:38');
INSERT INTO kien_his_download_softpin VALUES('5', '5', 'jaB4CKftyTKC5aY5vbt0bK/og0jT3+3P', 'VIETTEL21000162', '2', '2015/02/17 00:00:00', '5', '2013-04-26 14:51:59');
INSERT INTO kien_his_download_softpin VALUES('6', '6', 'jaB4CKftyTKC5aY5vbt0bPlGw8at/xIX', 'VIETTEL21000163', '2', '2015/02/17 00:00:00', '5', '2013-04-26 14:52:43');
INSERT INTO kien_his_download_softpin VALUES('7', '7', '2mwb5bT68wzFG5QI1DlpHQ==', '21345678151', '4', '2015/02/17 00:00:00', '5', '2013-04-26 17:41:01');
INSERT INTO kien_his_download_softpin VALUES('8', '8', 'jaB4CKftyTKC5aY5vbt0bJm8Ewkq32Ve', 'VIETTEL21000164', '2', '2015/02/17 00:00:00', '5', '2013-04-26 21:26:50');
INSERT INTO kien_his_download_softpin VALUES('9', '9', 'jaB4CKftyTKC5aY5vbt0bLV6Wk2kbAju', 'VIETTEL21000165', '2', '2015/02/17 00:00:00', '5', '2013-04-26 21:30:11');
INSERT INTO kien_his_download_softpin VALUES('10', '10', 'GigSW2Db+b9te/i8XH1zpUP4WHEZXJis', 'BVN1000467', '25', '2015/02/17 00:00:00', '32', '2013-04-28 15:56:20');
INSERT INTO kien_his_download_softpin VALUES('11', '11', 'GigSW2Db+b9Jl0Ji6akaHKMBzotvYxN3', 'BVN1001425', '1', '2015/02/17 00:00:00', '32', '2013-04-28 16:00:12');
INSERT INTO kien_his_download_softpin VALUES('12', '12', 'X5oaEhwFV4N7BPuk9H7gMg==', '012182000041763', '25', '2015/12/31 00:00:00', '32', '2013-04-28 16:58:48');
INSERT INTO kien_his_download_softpin VALUES('13', '13', 'NGSXtex3tdgRgN60EbyylQ==', '012182000041764', '25', '2015/12/31 00:00:00', '32', '2013-04-28 17:08:21');
INSERT INTO kien_his_download_softpin VALUES('14', '14', 'mTA0FDKk7pVvE+QrXQ5SpA==', '81180500411', '1', '2016/12/31 00:00:00', '32', '2013-04-29 23:38:48');
INSERT INTO kien_his_download_softpin VALUES('15', '15', '67zgJaZ+0fLXvqTfRk3Msg==', '81180500418', '1', '2016/12/31 00:00:00', '32', '2013-04-29 23:43:54');
INSERT INTO kien_his_download_softpin VALUES('16', '16', 'kRI+zR19U7glkOirfZBkjg==', '31305301728', '6', '2016/12/31 00:00:00', '32', '2013-04-30 11:01:35');
INSERT INTO kien_his_download_softpin VALUES('17', '18', 'lQ5k9xVMxel1EA8vWyiQeg==', 'UQM933801', '17', '2013/12/31 00:00:00', '32', '2013-05-04 11:12:56');
INSERT INTO kien_his_download_softpin VALUES('18', '19', 'ICEkA/Er0RjXrP7fnHlZxA==', 'UQM933802', '17', '2013/12/31 00:00:00', '32', '2013-05-04 11:21:51');
INSERT INTO kien_his_download_softpin VALUES('19', '20', '3Aj/3wgXp0Cf+kHvzRLGFA==', 'UQM933803', '17', '2013/12/31 00:00:00', '32', '2013-05-04 11:24:35');
INSERT INTO kien_his_download_softpin VALUES('20', '21', 'n3BP+r4CZIzX9IEsjs9V4A==', 'UQM933804', '17', '2013/12/31 00:00:00', '32', '2013-05-04 11:24:47');
INSERT INTO kien_his_download_softpin VALUES('21', '22', 'hYpReo2E7EHfW5mpXJ0jVg==', 'UQM933805', '17', '2013/12/31 00:00:00', '32', '2013-05-04 11:25:20');
INSERT INTO kien_his_download_softpin VALUES('22', '23', 'hlOoTNEb8/pOzEPL86DIpw==', 'UQM933806', '17', '2013/12/31 00:00:00', '32', '2013-05-04 11:26:42');
INSERT INTO kien_his_download_softpin VALUES('23', '39', 'l0a8czU41qqxMRm09LQNbA==', '012312000011852', '25', '2015/12/31 00:00:00', '32', '2013-05-06 14:20:08');
INSERT INTO kien_his_download_softpin VALUES('24', '44', 'lq2a/fuIFBTihvzb/PfgaQ==', '012312000014070', '25', '2015/12/31 00:00:00', '32', '2013-05-06 16:10:44');
INSERT INTO kien_his_download_softpin VALUES('25', '45', 'OyHxIHHDyOmvtH5KcQMevQ==', '012312000014071', '25', '2015/12/31 00:00:00', '32', '2013-05-06 16:11:54');
INSERT INTO kien_his_download_softpin VALUES('26', '48', '5p7WHfZff9Gk/zBdtrj7Yw==', '012312000014576', '25', '2015/12/31 00:00:00', '32', '2013-05-06 17:39:19');
INSERT INTO kien_his_download_softpin VALUES('27', '59', 'gvKztssFLoTS0u3SDqQxqw==', 'BCZ019042', '22', '2015/12/31 00:00:00', '32', '2013-05-08 23:07:10');
INSERT INTO kien_his_download_softpin VALUES('28', '75', '2LyECY3t29DGY0uQ/ugV7A==', '012502000021241', '25', '2015/12/31 00:00:00', '32', '2013-05-11 08:37:02');
INSERT INTO kien_his_download_softpin VALUES('29', '75', 'l3os3MCT+rOwfBHpslnl8w==', '012502000021240', '25', '2015/12/31 00:00:00', '32', '2013-05-11 08:37:02');
INSERT INTO kien_his_download_softpin VALUES('30', '82', 'T3+V/rt5woyeboPxgjT7Hg==', 'BCY075201', '21', '2015/12/31 00:00:00', '32', '2013-05-11 11:18:05');
INSERT INTO kien_his_download_softpin VALUES('31', '92', 'ol7U/liGXZda5kWvmQvQkg==', ' BDA005366', '24', '2015/12/31 00:00:00', '32', '2013-05-11 14:27:32');
INSERT INTO kien_his_download_softpin VALUES('32', '111', '945991867871', '012872000053307', '25', '2015/12/31 00:00:00', '32', '2013-05-17 18:00:38');
INSERT INTO kien_his_download_softpin VALUES('33', '126', 'EkIcqJWZ6yr9CXwvIs6LyQ==', ' UQM913289', '17', '2013/12/31 00:00:00', '32', '2013-05-18 10:50:37');
INSERT INTO kien_his_download_softpin VALUES('34', '128', '685155157750', '013162000002821', '25', '2015/12/31 00:00:00', '32', '2013-05-20 22:51:15');
INSERT INTO kien_his_download_softpin VALUES('35', '132', '5054-2501-5808', '3104116127', '77', '2013/12/31 00:00:00', '32', '2013-05-21 08:42:12');
INSERT INTO kien_his_download_softpin VALUES('36', '176', '480568020169', '013162000010725', '25', '2015/12/31 00:00:00', '32', '2013-05-22 17:43:34');
INSERT INTO kien_his_download_softpin VALUES('37', '182', 'mdaxZY2P4pAoLoMvHfO4Lw==', '31400701199', '1', '2016/12/31 00:00:00', '32', '2013-05-23 09:14:51');
INSERT INTO kien_his_download_softpin VALUES('38', '194', '1324-0715-46100', '31400701847', '1', '2016/12/31 00:00:00', '32', '2013-05-23 16:13:10');
INSERT INTO kien_his_download_softpin VALUES('39', '195', '1324-0177-24177', '31400701863', '1', '2016/12/31 00:00:00', '32', '2013-05-23 16:14:39');
INSERT INTO kien_his_download_softpin VALUES('40', '202', '', '31400706967', '1', '2016/12/31 00:00:00', '33', '2013-05-24 15:08:42');
INSERT INTO kien_his_download_softpin VALUES('41', '204', '1325-8690-18962', '31400842603', '1', '2016/12/31 00:00:00', '32', '2013-05-26 10:52:15');

INSERT INTO kien_his_download_softpin VALUES('42', '205', '1325-9615-53233', '31400845339', '1', '2016/12/31 00:00:00', '32', '2013-05-26 11:03:43');


INSERT INTO kien_his_download_softpin VALUES('43', '208', '820332958830', '013242000000000', '25', '2015/12/31 00:00:00', '32', '2013-05-26 11:51:35');
INSERT INTO kien_his_download_softpin VALUES('44', '224', '491802104311', 'UQN961988', '17', '2013/12/31 00:00:00', '32', '2013-05-27 08:28:09');
INSERT INTO kien_his_download_softpin VALUES('45', '240', '1127-9893-20199', '11412209534', '1', '2016/12/31 00:00:00', '32', '2013-05-28 08:32:26');
INSERT INTO kien_his_download_softpin VALUES('46', '248', '218472335938', '013382000006088', '25', '2015/12/31 00:00:00', '32', '2013-05-28 12:05:55');
INSERT INTO kien_his_download_softpin VALUES('47', '262', 'VhzPGc6CA6osQf4cgKykjA==', 'bE1juzFPZSQUbZR/qHmLSg==', '29', '', '33', '2013-05-28 22:33:39');
INSERT INTO kien_his_download_softpin VALUES('48', '263', 'Fa5mIEyo83DZ+KnsI78XAQ==', 'bE1juzFPZSSh2QddSFIqug==', '29', '', '33', '2013-05-28 22:34:49');
INSERT INTO kien_his_download_softpin VALUES('49', '264', 'vaxpjJ0reYmNGhWfMiJwIg==', 'P3yLRktbYLvxYkbNQMFQAw==', '28', '', '33', '2013-05-28 22:36:47');
INSERT INTO kien_his_download_softpin VALUES('50', '265', 'upKti6GJ6QzNyRFx8RejSA==', 'bE1juzFPZSSOG0c4F5qvoQ==', '29', '', '33', '2013-05-29 08:36:37');
INSERT INTO kien_his_download_softpin VALUES('51', '266', 'qyGoTuwPbTWnkFohlz0XVQ==', 'P3yLRktbYLtQRU5iWvgEOg==', '28', '', '33', '2013-05-30 21:01:37');
INSERT INTO kien_his_download_softpin VALUES('52', '267', 'ecFqPT2XmZSzpCADaXxY6w==', '6R7jqfSoCdMfEwaSPowY7w==', '4', '', '33', '2013-05-30 21:02:39');
INSERT INTO kien_his_download_softpin VALUES('53', '268', 'ZyBzEZXPMq76b4Dyv7XZNA==', '6R7jqfSoCdOVz0B5ME5lyw==', '4', '', '33', '2013-05-30 21:05:20');
INSERT INTO kien_his_download_softpin VALUES('54', '269', 'ZZyzbA7AkuRWj2hIingGSQ==', 'P3yLRktbYLu9U9WdsO9wZA==', '28', '', '33', '2013-05-31 15:27:21');
INSERT INTO kien_his_download_softpin VALUES('55', '270', 'm1ikc9/+UUTp5C2g5CnxJA==', 'bE1juzFPZSRDXzigiy/jnQ==', '29', '', '33', '2013-05-31 15:56:34');
INSERT INTO kien_his_download_softpin VALUES('56', '279', '473162066096', 'UQN965175', '17', '2015/12/31 00:00:00', '32', '2013-06-01 09:08:00');
INSERT INTO kien_his_download_softpin VALUES('57', '282', '1127-9913-00081', '11410446238', '1', '2016/12/31 00:00:00', '32', '2013-06-01 09:40:11');
INSERT INTO kien_his_download_softpin VALUES('58', '285', '1126511905114', '11412028378', '1', '2015/12/31 00:00:00', '32', '2013-06-01 16:00:28');
INSERT INTO kien_his_download_softpin VALUES('59', '286', '1226405221181', '21638422168', '1', '2015/01/01 00:00:00', '32', '2013-06-01 21:42:14');
INSERT INTO kien_his_download_softpin VALUES('60', '292', '1324100276624', '31401202710', '2', '2015/12/31 00:00:00', '32', '2013-06-03 12:13:14');
INSERT INTO kien_his_download_softpin VALUES('61', '296', '1227346366048', '21638518029', '1', '2015/01/01 00:00:00', '32', '2013-06-03 16:55:24');
INSERT INTO kien_his_download_softpin VALUES('62', '298', '1227367109374', '21638518531', '1', '2015/01/01 00:00:00', '32', '2013-06-03 17:30:09');
INSERT INTO kien_his_download_softpin VALUES('63', '303', '96179362550717', 'BCX183292', '20', '2015/12/31 00:00:00', '32', '2013-06-04 10:10:00');
INSERT INTO kien_his_download_softpin VALUES('64', '307', '0e77aSLaahYZEVvqe0KIzw==', 'bE1juzFPZSRcdXDZ3lLpfA==', '29', '', '33', '2013-06-05 07:31:30');
INSERT INTO kien_his_download_softpin VALUES('65', '309', '1226882632298', '21638442198', '1', '2015/01/01 00:00:00', '32', '2013-06-05 09:03:52');
INSERT INTO kien_his_download_softpin VALUES('66', '311', '1324152433355', '31401203113', '2', '2015/12/31 00:00:00', '32', '2013-06-05 09:12:01');
INSERT INTO kien_his_download_softpin VALUES('67', '312', 'z2wDKS2HNJxmOUc/OkEeTQ==', '31401203112', '2', '2015/12/31 00:00:00', '32', '2013-06-05 09:12:03');
INSERT INTO kien_his_download_softpin VALUES('68', '318', '1227121548103', '21638508441', '1', '2015/01/01 00:00:00', '32', '2013-06-05 11:46:37');
INSERT INTO kien_his_download_softpin VALUES('69', '322', 'eO6vNiWhXhaEqC13+RqYpQ==', 'P3yLRktbYLthQrOtNXYzaw==', '28', '', '33', '2013-06-05 17:56:25');
INSERT INTO kien_his_download_softpin VALUES('70', '324', '900963422536', '013383000001854', '26', '2015/12/31 00:00:00', '32', '2013-06-05 22:57:41');
INSERT INTO kien_his_download_softpin VALUES('71', '326', '1324220516301', '31401203493', '2', '2015/12/31 00:00:00', '32', '2013-06-06 08:04:51');
INSERT INTO kien_his_download_softpin VALUES('72', '330', '1227103520096', '21638509060', '1', '2015/01/01 00:00:00', '32', '2013-06-06 11:59:11');
INSERT INTO kien_his_download_softpin VALUES('73', '333', '1227433707514', '21691014916', '2', '2015/12/31 00:00:00', '32', '2013-06-06 15:55:19');
INSERT INTO kien_his_download_softpin VALUES('74', '334', '1227324537957', '21638519603', '1', '2015/01/01 00:00:00', '32', '2013-06-06 16:00:59');
INSERT INTO kien_his_download_softpin VALUES('75', '335', '1227556652516', '21691015422', '2', '2015/12/31 00:00:00', '32', '2013-06-06 19:10:38');
INSERT INTO kien_his_download_softpin VALUES('76', '338', '599080330886', '013682000002007', '25', '2015/12/31 00:00:00', '32', '2013-06-07 09:10:58');
INSERT INTO kien_his_download_softpin VALUES('77', '338', '035776901969', '013682000002008', '25', '2015/12/31 00:00:00', '32', '2013-06-07 09:10:59');
INSERT INTO kien_his_download_softpin VALUES('78', '338', '300488610749', '013682000002009', '25', '2015/12/31 00:00:00', '32', '2013-06-07 09:10:59');
INSERT INTO kien_his_download_softpin VALUES('79', '338', '753956029672', '013682000002010', '25', '2015/12/31 00:00:00', '32', '2013-06-07 09:10:59');
INSERT INTO kien_his_download_softpin VALUES('80', '338', '344549434907', '013682000002011', '25', '2015/12/31 00:00:00', '32', '2013-06-07 09:10:59');
INSERT INTO kien_his_download_softpin VALUES('81', '339', '1227636436730', '21638532202', '1', '2015/01/01 00:00:00', '32', '2013-06-07 09:32:01');
INSERT INTO kien_his_download_softpin VALUES('82', '339', '1227622648342', '21638532203', '1', '2015/01/01 00:00:00', '32', '2013-06-07 09:32:02');
INSERT INTO kien_his_download_softpin VALUES('83', '339', '1227604693728', '21638532204', '1', '2015/01/01 00:00:00', '32', '2013-06-07 09:32:04');
INSERT INTO kien_his_download_softpin VALUES('84', '340', '991173828518', '013503000005360', '26', '2015/12/31 00:00:00', '32', '2013-06-07 09:38:56');
INSERT INTO kien_his_download_softpin VALUES('85', '340', '527936639126', '013503000005361', '26', '2015/12/31 00:00:00', '32', '2013-06-07 09:38:56');
INSERT INTO kien_his_download_softpin VALUES('86', '340', '233512469894', '013503000005362', '26', '2015/12/31 00:00:00', '32', '2013-06-07 09:38:56');
INSERT INTO kien_his_download_softpin VALUES('87', '341', '1227613805971', '21691019683', '2', '2015/12/31 00:00:00', '32', '2013-06-07 09:44:30');
INSERT INTO kien_his_download_softpin VALUES('88', '341', '1227697890529', '21691019686', '2', '2015/12/31 00:00:00', '32', '2013-06-07 09:44:30');
INSERT INTO kien_his_download_softpin VALUES('89', '341', '1227692180368', '21691019692', '2', '2015/12/31 00:00:00', '32', '2013-06-07 09:44:30');
INSERT INTO kien_his_download_softpin VALUES('90', '350', '1126511408214', '11412028800', '1', '2015/12/31 00:00:00', '32', '2013-06-07 18:49:45');
INSERT INTO kien_his_download_softpin VALUES('91', '353', 't3k5KabuSiOvCKLLXWHEQg==', '4E3rGemVLJANEHcMZaNxuQ==', '30', '', '33', '2013-06-08 00:24:07');
INSERT INTO kien_his_download_softpin VALUES('92', '354', 'pnFM236j0cFmlpS/4jNoig==', '4E3rGemVLJBcp8+36G5cqg==', '30', '', '33', '2013-06-08 00:54:22');
INSERT INTO kien_his_download_softpin VALUES('93', '355', 'oBRkHd9TD+PUyfS59Us/Fg==', '4E3rGemVLJBUyE5E8199LA==', '30', '', '33', '2013-06-08 01:00:10');
INSERT INTO kien_his_download_softpin VALUES('94', '356', 'Czcvf8jNwMqU9IR0GCm3jA==', '4E3rGemVLJBUI8NXpB5mkg==', '30', '', '33', '2013-06-08 01:02:12');
INSERT INTO kien_his_download_softpin VALUES('95', '360', '6N8X7K6D2', 'MA0196646596', '73', '2015/12/31 00:00:00', '33', '2013-06-08 10:06:47');
INSERT INTO kien_his_download_softpin VALUES('96', '361', '1227696158041', '21691018382', '2', '2015/12/31 00:00:00', '32', '2013-06-08 10:07:55');
INSERT INTO kien_his_download_softpin VALUES('97', '362', '8T2RAW3LW', 'MA0196646597', '73', '2015/12/31 00:00:00', '33', '2013-06-08 10:11:33');
INSERT INTO kien_his_download_softpin VALUES('98', '363', 'KP67XMP6H', 'MA0196646599', '73', '2015/12/31 00:00:00', '33', '2013-06-08 10:14:06');
INSERT INTO kien_his_download_softpin VALUES('99', '365', '992805379257', '013832000002004', '25', '2015/12/31 00:00:00', '32', '2013-06-08 11:20:44');
INSERT INTO kien_his_download_softpin VALUES('100', '368', '1227673810243', '21691019523', '2', '2015/12/31 00:00:00', '32', '2013-06-08 19:48:32');
INSERT INTO kien_his_download_softpin VALUES('101', '369', '1126566781713', '11412029383', '1', '2015/12/31 00:00:00', '32', '2013-06-08 21:59:04');
INSERT INTO kien_his_download_softpin VALUES('102', '380', '1927-6634-16867', '91973931293', '1', '2016/12/31 00:00:00', '32', '2013-06-10 14:23:36');
INSERT INTO kien_his_download_softpin VALUES('103', '380', '1927-6908-40563', '91973931294', '1', '2016/12/31 00:00:00', '32', '2013-06-10 14:23:37');
INSERT INTO kien_his_download_softpin VALUES('104', '381', '72038868731739', 'BCY106203', '21', '2015/12/31 00:00:00', '33', '2013-06-10 14:31:10');
INSERT INTO kien_his_download_softpin VALUES('105', '389', '02505635463400', 'BCZ031909', '22', '2015/12/31 00:00:00', '33', '2013-06-10 18:55:17');
INSERT INTO kien_his_download_softpin VALUES('106', '400', '1321022095653', '31403400015', '2', '2015/01/01 00:00:00', '32', '2013-06-11 09:53:10');
INSERT INTO kien_his_download_softpin VALUES('107', '405', '1922-0566-05680', '91974400296', '1', '2016/12/31 00:00:00', '32', '2013-06-11 10:47:35');
INSERT INTO kien_his_download_softpin VALUES('108', '405', '1922-0909-64870', '91974400297', '1', '2016/12/31 00:00:00', '32', '2013-06-11 10:47:36');
INSERT INTO kien_his_download_softpin VALUES('109', '405', '1922-0096-54133', '91974400298', '1', '2016/12/31 00:00:00', '32', '2013-06-11 10:47:36');
INSERT INTO kien_his_download_softpin VALUES('110', '405', '1922-0670-59916', '91974400299', '1', '2016/12/31 00:00:00', '32', '2013-06-11 10:47:36');
INSERT INTO kien_his_download_softpin VALUES('111', '405', '1922-0800-82172', '91974400300', '1', '2016/12/31 00:00:00', '32', '2013-06-11 10:47:36');
INSERT INTO kien_his_download_softpin VALUES('112', '405', '1922-0172-99672', '91974400301', '1', '2016/12/31 00:00:00', '32', '2013-06-11 10:47:37');
INSERT INTO kien_his_download_softpin VALUES('113', '406', '1321080274160', '31403400085', '2', '2015/01/01 00:00:00', '32', '2013-06-11 10:52:10');
INSERT INTO kien_his_download_softpin VALUES('114', '406', '1321012261428', '31403400086', '2', '2015/01/01 00:00:00', '32', '2013-06-11 10:52:11');
INSERT INTO kien_his_download_softpin VALUES('115', '406', '1321078181833', '31403400087', '2', '2015/01/01 00:00:00', '32', '2013-06-11 10:52:11');
INSERT INTO kien_his_download_softpin VALUES('116', '406', '1321066878599', '31403400088', '2', '2015/01/01 00:00:00', '32', '2013-06-11 10:52:11');
INSERT INTO kien_his_download_softpin VALUES('117', '406', '1321062837347', '31403400089', '2', '2015/01/01 00:00:00', '32', '2013-06-11 10:52:11');
INSERT INTO kien_his_download_softpin VALUES('118', '406', '1321039841113', '31403400090', '2', '2015/01/01 00:00:00', '32', '2013-06-11 10:52:11');
INSERT INTO kien_his_download_softpin VALUES('119', '407', '1922-0854-05777', '91974400302', '1', '2016/12/31 00:00:00', '32', '2013-06-11 10:55:55');
INSERT INTO kien_his_download_softpin VALUES('120', '409', '1922-0980-25240', '91974400306', '1', '2016/12/31 00:00:00', '32', '2013-06-11 11:19:38');
INSERT INTO kien_his_download_softpin VALUES('121', '411', '1922-0534-16604', '91974400309', '1', '2016/12/31 00:00:00', '32', '2013-06-11 11:54:29');
INSERT INTO kien_his_download_softpin VALUES('122', '417', '1321009799803', '31403400123', '2', '2015/01/01 00:00:00', '32', '2013-06-11 12:52:43');
INSERT INTO kien_his_download_softpin VALUES('123', '418', '1321011858831', '31403400144', '2', '2015/01/01 00:00:00', '32', '2013-06-11 13:11:21');
INSERT INTO kien_his_download_softpin VALUES('124', '419', '1321050049673', '31403400148', '2', '2015/01/01 00:00:00', '32', '2013-06-11 13:51:08');
INSERT INTO kien_his_download_softpin VALUES('125', '427', '1922-0974-63391', '91974400370', '1', '2016/12/31 00:00:00', '32', '2013-06-11 15:01:20');
INSERT INTO kien_his_download_softpin VALUES('126', '428', '1822-4846-22302', '81188403438', '4', '2016/12/31 00:00:00', '33', '2013-06-14 13:32:08');
INSERT INTO kien_his_download_softpin VALUES('127', '432', '1820-4673-89175', '81188204477', '2', '2016/12/31 00:00:00', '33', '2013-06-14 14:35:43');
INSERT INTO kien_his_download_softpin VALUES('128', '433', 'y2mnsKwy/Tvc4uizDs8VdA==', 'kCl5/qNc7UlfV1hAlItxAw==', '5', '', '33', '2013-06-14 14:35:58');
INSERT INTO kien_his_download_softpin VALUES('129', '435', '1928-4692-13737', '91975024720', '1', '2016/12/31 00:00:00', '32', '2013-06-14 16:27:11');
INSERT INTO kien_his_download_softpin VALUES('130', '440', '1928-5917-01790', '91975026736', '1', '2016/12/31 00:00:00', '32', '2013-06-14 17:44:40');
INSERT INTO kien_his_download_softpin VALUES('131', '447', '1827-8258-52299', '81187942087', '1', '2016/12/31 00:00:00', '32', '2013-06-14 20:58:53');
INSERT INTO kien_his_download_softpin VALUES('132', '449', '1820-5044-13475', '81188204622', '2', '2016/12/31 00:00:00', '32', '2013-06-14 21:04:19');
INSERT INTO kien_his_download_softpin VALUES('133', '450', '1822-4324-57820', '81188403761', '4', '2016/12/31 00:00:00', '32', '2013-06-14 21:20:04');
INSERT INTO kien_his_download_softpin VALUES('134', '462', '1822-4974-14533', '81188404080', '4', '2016/12/31 00:00:00', '32', '2013-06-15 09:02:11'); 
INSERT INTO kien_his_download_softpin VALUES('135', '468', '1822-4584-67802', '81188404116', '4', '2016/12/31 00:00:00', '32', '2013-06-15 10:25:14'); 
INSERT INTO kien_his_download_softpin VALUES('136', '472', '1827-8062-77189', '81187942119', '1', '2016/12/31 00:00:00', '32', '2013-06-15 11:10:35');
INSERT INTO kien_his_download_softpin VALUES('137', '473', '1827-8294-65865', '81187942120', '1', '2016/12/31 00:00:00', '32', '2013-06-15 11:24:22');
INSERT INTO kien_his_download_softpin VALUES('138', '487', '1820-5919-15423', '81188205114', '2', '2016/12/31 00:00:00', '32', '2013-06-15 16:57:31');
INSERT INTO kien_his_download_softpin VALUES('139', '491', '946548519742', '014146000001240', '29', '2015/12/31 00:00:00', '32', '2013-06-15 19:26:03');
INSERT INTO kien_his_download_softpin VALUES('140', '492', '1822-5492-65296', '81188404403', '4', '2016/12/31 00:00:00', '32', '2013-06-15 19:29:32');
INSERT INTO kien_his_download_softpin VALUES('141', '492', '1822-5256-15568', '81188404404', '4', '2016/12/31 00:00:00', '32', '2013-06-15 19:29:32');
INSERT INTO kien_his_download_softpin VALUES('142', '492', '1822-5086-94603', '81188404405', '4', '2016/12/31 00:00:00', '32', '2013-06-15 19:29:32');
INSERT INTO kien_his_download_softpin VALUES('143', '495', '1822-5180-13376', '81188404573', '4', '2016/12/31 00:00:00', '32', '2013-06-15 20:43:22');
INSERT INTO kien_his_download_softpin VALUES('144', '500', '04808393744247', 'BCY128559', '21', '2015/12/31 00:00:00', '33', '2013-06-15 23:04:38');
INSERT INTO kien_his_download_softpin VALUES('145', '512', '1827-8274-10584', '81187943035', '1', '2016/12/31 00:00:00', '32', '2013-06-16 16:17:09');
INSERT INTO kien_his_download_softpin VALUES('146', '514', '1827-8895-93316', '81187943047', '1', '2016/12/31 00:00:00', '32', '2013-06-16 19:31:47');
INSERT INTO kien_his_download_softpin VALUES('147', '515', '1820-5417-92491', '81188205352', '2', '2016/12/31 00:00:00', '32', '2013-06-16 19:35:50');
INSERT INTO kien_his_download_softpin VALUES('148', '517', '91802706657446', 'BCY128593', '21', '2015/12/31 00:00:00', '33', '2013-06-16 21:43:01');
INSERT INTO kien_his_download_softpin VALUES('149', '520', '1820-5740-82214', '81188205370', '2', '2016/12/31 00:00:00', '32', '2013-06-16 22:42:33');
INSERT INTO kien_his_download_softpin VALUES('150', '524', 'bBhoS1EdcWpgysJ1LqOoPg==', '81187943955', '1', '2016/12/31 00:00:00', '32', '2013-06-17 08:50:43');
INSERT INTO kien_his_download_softpin VALUES('151', '530', '1822-5222-33254', '81188404954', '4', '2016/12/31 00:00:00', '32', '2013-06-17 14:26:18');
INSERT INTO kien_his_download_softpin VALUES('152', '539', '1820-6496-99486', '81188205960', '2', '2016/12/31 00:00:00', '32', '2013-06-17 18:52:02');
INSERT INTO kien_his_download_softpin VALUES('153', '550', '88965456450594', 'BCY131591', '21', '2015/12/31 00:00:00', '33', '2013-06-18 15:40:01');
INSERT INTO kien_his_download_softpin VALUES('154', '552', '1827-9497-63061', '81187946550', '1', '2016/12/31 00:00:00', '32', '2013-06-18 17:30:49');
INSERT INTO kien_his_download_softpin VALUES('155', '558', '1820-7494-99449', '81188206497', '2', '2016/12/31 00:00:00', '32', '2013-06-19 17:23:44');
INSERT INTO kien_his_download_softpin VALUES('156', '561', '1822-6135-75018', '81188405792', '4', '2016/12/31 00:00:00', '32', '2013-06-19 19:50:40');
INSERT INTO kien_his_download_softpin VALUES('157', '562', '1820-7211-32905', '81188206551', '2', '2016/12/31 00:00:00', '32', '2013-06-19 20:22:43');
INSERT INTO kien_his_download_softpin VALUES('158', '567', '1827-9067-65327', '81187948685', '1', '2016/12/31 00:00:00', '32', '2013-06-20 10:30:53');
INSERT INTO kien_his_download_softpin VALUES('159', '569', '1827-9283-84009', '81187948901', '1', '2016/12/31 00:00:00', '32', '2013-06-20 12:32:40');
INSERT INTO kien_his_download_softpin VALUES('160', '575', '18221981793158', 'BCY132085', '21', '2015/12/31 00:00:00', '32', '2013-06-20 16:35:15');
INSERT INTO kien_his_download_softpin VALUES('161', '576', '30367235034353', 'BCY132088', '21', '2015/12/31 00:00:00', '32', '2013-06-20 16:57:34');
INSERT INTO kien_his_download_softpin VALUES('162', '577', '1822-7156-58117', '81188406146', '4', '2016/12/31 00:00:00', '32', '2013-06-20 17:40:36');
INSERT INTO kien_his_download_softpin VALUES('163', '579', '294062510328', 'QGL688877', '24', '2013/12/31 00:00:00', '32', '2013-06-20 18:50:33');
INSERT INTO kien_his_download_softpin VALUES('164', '580', '884872833426', 'UQN978289', '17', '2013/12/31 00:00:00', '32', '2013-06-20 20:09:57');
INSERT INTO kien_his_download_softpin VALUES('165', '581', '1820-7212-43355', '81188206910', '2', '2016/12/31 00:00:00', '32', '2013-06-20 22:11:40');
INSERT INTO kien_his_download_softpin VALUES('166', '585', '1820-7708-21633', '81188206941', '2', '2016/12/31 00:00:00', '32', '2013-06-21 08:12:47');
INSERT INTO kien_his_download_softpin VALUES('167', '608', '1827-9473-46428', '81187949529', '1', '2016/12/31 00:00:00', '32', '2013-06-21 20:14:14');

INSERT INTO kien_his_download_softpin VALUES('170', '619', '978922392173', 'QGL689483', '24', '2013/12/31 00:00:00', '32', '2013-06-26 06:47:54');
INSERT INTO kien_his_download_softpin VALUES('171', '619', '237556999968', 'QGL689484', '24', '2013/12/31 00:00:00', '32', '2013-06-26 06:47:54');
INSERT INTO kien_his_download_softpin VALUES('172', '621', '29056158916623', 'BCZ036819', '22', '2015/12/31 00:00:00', '32', '2013-06-26 07:19:41');
INSERT INTO kien_his_download_softpin VALUES('173', '623', '15905841134483', 'AWZ015539', '23', '2015/12/31 00:00:00', '32', '2013-06-26 08:59:29');
INSERT INTO kien_his_download_softpin VALUES('174', '628', '964837251613', '014924000000075', '28', '2015/12/31 00:00:00', '33', '2013-06-26 09:53:39');
INSERT INTO kien_his_download_softpin VALUES('175', '631', '95042856054800', 'BCZ036831', '22', '2015/12/31 00:00:00', '32', '2013-06-26 11:10:26');
INSERT INTO kien_his_download_softpin VALUES('176', '636', '4VrvlcVjTiVyHyfgrmNWUQ==', '4E3rGemVLJB11Y4TZpOfbw==', '30', '', '33', '2013-06-27 08:52:52');
INSERT INTO kien_his_download_softpin VALUES('177', '637', '927369601705', '014382000023083', '25', '2015/12/31 00:00:00', '32', '2013-06-27 09:27:13');
INSERT INTO kien_his_download_softpin VALUES('178', '650', 'sp+s6Fnhe+Z6e9DUR6f14w==', '53403901776', '4', '2016/12/31 00:00:00', '32', '2013-06-28 15:44:08');
INSERT INTO kien_his_download_softpin VALUES('179', '651', '5554-1367-98467', '53403901789', '4', '2016/12/31 00:00:00', '32', '2013-06-28 16:09:26');
INSERT INTO kien_his_download_softpin VALUES('180', '657', '667187211347', '015135000000820', '28', '2015/12/31 00:00:00', '32', '2013-06-28 18:09:13');
INSERT INTO kien_his_download_softpin VALUES('181', '661', '1826-9279-65282', '81188800545', '8', '2016/12/31 00:00:00', '32', '2013-06-28 19:01:31');
INSERT INTO kien_his_download_softpin VALUES('182', '668', '075983245802', 'UQN983979', '17', '2013/12/31 00:00:00', '32', '2013-06-29 09:42:20');
INSERT INTO kien_his_download_softpin VALUES('183', '673', '5554-1196-35595', '53403902390', '4', '2016/12/31 00:00:00', '32', '2013-06-29 15:16:09');
INSERT INTO kien_his_download_softpin VALUES('184', '674', '1824-9706-57402', '81188601211', '6', '2016/12/31 00:00:00', '32', '2013-06-29 15:36:15');
INSERT INTO kien_his_download_softpin VALUES('185', '675', '1827-7962-99300', '81187936987', '1', '2016/12/31 00:00:00', '32', '2013-06-29 20:11:48');
INSERT INTO kien_his_download_softpin VALUES('186', '684', '5556-1270-71152', '53403704890', '2', '2016/12/31 00:00:00', '33', '2013-06-30 16:10:01');
INSERT INTO kien_his_download_softpin VALUES('187', '690', '5554-1055-32121', '53403902852', '4', '2016/12/31 00:00:00', '32', '2013-07-01 08:09:31');
INSERT INTO kien_his_download_softpin VALUES('188', '692', '5550-8430-94812', '53403433070', '1', '2016/12/31 00:00:00', '32', '2013-07-01 15:32:19');
INSERT INTO kien_his_download_softpin VALUES('189', '694', '002292969202', '015135000001376', '28', '2015/12/31 00:00:00', '38', '2013-07-01 22:17:18');
INSERT INTO kien_his_download_softpin VALUES('190', '695', '5554-1276-60239', '53403903386', '4', '2016/12/31 00:00:00', '38', '2013-07-01 22:18:21');
INSERT INTO kien_his_download_softpin VALUES('191', '696', '016581130714', '014962000030105', '25', '2015/12/31 00:00:00', '38', '2013-07-02 00:29:04');
INSERT INTO kien_his_download_softpin VALUES('192', '697', '617754785183', '014962000030106', '25', '2015/12/31 00:00:00', '38', '2013-07-02 00:35:06');
INSERT INTO kien_his_download_softpin VALUES('193', '698', 'fZIxyKDxGOnQv5NjJkZjf2zoSDFp6CKJLUIyeV3n+Gg=', '014962000030107', '25', '2015/12/31 00:00:00', '38', '2013-07-02 00:43:04');
INSERT INTO kien_his_download_softpin VALUES('194', '699', '797833630419', '014962000030108', '25', '2015/12/31 00:00:00', '38', '2013-07-02 00:45:55');
INSERT INTO kien_his_download_softpin VALUES('195', '701', '1821-6543-28245', '81188301364', '3', '2016/12/31 00:00:00', '32', '2013-07-02 08:59:11');
INSERT INTO kien_his_download_softpin VALUES('196', '702', '5550-8110-94989', '53403434775', '1', '2016/12/31 00:00:00', '32', '2013-07-02 10:23:37');
INSERT INTO kien_his_download_softpin VALUES('197', '706', '5550-2416-65590', '53403436382', '1', '2016/12/31 00:00:00', '32', '2013-07-03 09:22:20');
INSERT INTO kien_his_download_softpin VALUES('198', '707', '5550-2480-11812', '53403436389', '1', '2016/12/31 00:00:00', '32', '2013-07-03 09:54:29');
INSERT INTO kien_his_download_softpin VALUES('199', '709', '5550-2156-99583', '53403436402', '1', '2016/12/31 00:00:00', '32', '2013-07-03 12:37:41');
INSERT INTO kien_his_download_softpin VALUES('200', '713', '5550-2446-85420', '53403437994', '1', '2016/12/31 00:00:00', '32', '2013-07-04 10:07:33');
INSERT INTO kien_his_download_softpin VALUES('201', '716', '5550-6646-83287', '53403441645', '1', '2016/12/31 00:00:00', '32', '2013-07-04 19:37:18');
INSERT INTO kien_his_download_softpin VALUES('202', '718', '372904990575', '015133000000116', '26', '2015/12/31 00:00:00', '32', '2013-07-05 10:04:49');
INSERT INTO kien_his_download_softpin VALUES('203', '719', '5554-1451-82534', '53403904556', '4', '2016/12/31 00:00:00', '33', '2013-07-05 14:12:14');
INSERT INTO kien_his_download_softpin VALUES('204', '721', '5556-3974-03026', '53403706587', '2', '2016/12/31 00:00:00', '32', '2013-07-05 15:37:44');
INSERT INTO kien_his_download_softpin VALUES('205', '721', '5556-3392-17023', '53403706588', '2', '2016/12/31 00:00:00', '32', '2013-07-05 15:37:44');
INSERT INTO kien_his_download_softpin VALUES('206', '722', '5556-3536-79743', '53403706589', '2', '2016/12/31 00:00:00', '32', '2013-07-05 15:57:47');
INSERT INTO kien_his_download_softpin VALUES('207', '732', '235520202325', '015543000000792', '29', '2015/12/31 00:00:00', '32', '2013-07-06 12:03:57');
INSERT INTO kien_his_download_softpin VALUES('208', '733', '442744010318', '015543000000794', '29', '2015/12/31 00:00:00', '32', '2013-07-06 12:10:20');
INSERT INTO kien_his_download_softpin VALUES('209', '734', '411614465776', '015542000000509', '28', '2015/12/31 00:00:00', '32', '2013-07-06 12:43:18');
INSERT INTO kien_his_download_softpin VALUES('210', '743', '856391420284', '015133000000403', '26', '2015/12/31 00:00:00', '32', '2013-07-06 21:56:47');

INSERT INTO kien_his_download_softpin VALUES('212', '750', '5554-3337-52742', '53403905063', '4', '2016/12/31 00:00:00', '32', '2013-07-07 13:50:30');
INSERT INTO kien_his_download_softpin VALUES('213', '751', '139059481435', '015133000000581', '26', '2015/12/31 00:00:00', '32', '2013-07-07 19:51:23');

INSERT INTO kien_his_download_softpin VALUES('215', '757', '5550-4337-50532', '53403414978', '1', '2016/12/31 00:00:00', '32', '2013-07-08 15:24:51');
INSERT INTO kien_his_download_softpin VALUES('216', '760', '5554-3342-48853', '53403905660', '4', '2016/12/31 00:00:00', '32', '2013-07-08 20:39:37');
INSERT INTO kien_his_download_softpin VALUES('217', '761', '5556-3030-95733', '53403708296', '2', '2016/12/31 00:00:00', '32', '2013-07-08 22:14:06');
INSERT INTO kien_his_download_softpin VALUES('218', '763', '469869805520', '015543000001191', '29', '2015/12/31 00:00:00', '32', '2013-07-08 23:18:29');
INSERT INTO kien_his_download_softpin VALUES('219', '772', '5554-3527-96139', '53403906020', '4', '2016/12/31 00:00:00', '32', '2013-07-09 16:32:41');
INSERT INTO kien_his_download_softpin VALUES('220', '772', '5554-3511-80805', '53403906021', '4', '2016/12/31 00:00:00', '32', '2013-07-09 16:32:41');
INSERT INTO kien_his_download_softpin VALUES('221', '772', '5554-3113-06538', '53403906022', '4', '2016/12/31 00:00:00', '32', '2013-07-09 16:32:42');
INSERT INTO kien_his_download_softpin VALUES('222', '773', '5556-3864-39728', '53403708702', '2', '2016/12/31 00:00:00', '32', '2013-07-09 16:37:13');
INSERT INTO kien_his_download_softpin VALUES('223', '773', '5556-3723-28849', '53403708703', '2', '2016/12/31 00:00:00', '32', '2013-07-09 16:37:13');
INSERT INTO kien_his_download_softpin VALUES('224', '773', '5556-3596-12208', '53403708704', '2', '2016/12/31 00:00:00', '32', '2013-07-09 16:37:13');
INSERT INTO kien_his_download_softpin VALUES('225', '773', '5556-3074-40025', '53403708705', '2', '2016/12/31 00:00:00', '32', '2013-07-09 16:37:13');
INSERT INTO kien_his_download_softpin VALUES('226', '773', '5556-3623-20881', '53403708706', '2', '2016/12/31 00:00:00', '32', '2013-07-09 16:37:13');
INSERT INTO kien_his_download_softpin VALUES('227', '773', '5556-3940-51998', '53403708707', '2', '2016/12/31 00:00:00', '32', '2013-07-09 16:37:13');
INSERT INTO kien_his_download_softpin VALUES('228', '773', '5556-3643-12940', '53403708708', '2', '2016/12/31 00:00:00', '32', '2013-07-09 16:37:13');
INSERT INTO kien_his_download_softpin VALUES('229', '773', '5556-3039-37757', '53403708709', '2', '2016/12/31 00:00:00', '32', '2013-07-09 16:37:14');
INSERT INTO kien_his_download_softpin VALUES('230', '773', '5556-3892-94851', '53403708710', '2', '2016/12/31 00:00:00', '32', '2013-07-09 16:37:14');
INSERT INTO kien_his_download_softpin VALUES('231', '774', '5550-7725-93017', '53403416669', '1', '2016/12/31 00:00:00', '32', '2013-07-09 16:45:14');
INSERT INTO kien_his_download_softpin VALUES('232', '774', '5550-7590-49024', '53403416670', '1', '2016/12/31 00:00:00', '32', '2013-07-09 16:45:14');
INSERT INTO kien_his_download_softpin VALUES('233', '774', '5550-7758-18930', '53403416671', '1', '2016/12/31 00:00:00', '32', '2013-07-09 16:45:14');
INSERT INTO kien_his_download_softpin VALUES('234', '774', '5550-7272-19276', '53403416672', '1', '2016/12/31 00:00:00', '32', '2013-07-09 16:45:14');

INSERT INTO kien_his_download_softpin VALUES('236', '774', '5550-7953-31233', '53403416674', '1', '2016/12/31 00:00:00', '32', '2013-07-09 16:45:14');
INSERT INTO kien_his_download_softpin VALUES('237', '774', '5550-7136-01200', '53403416675', '1', '2016/12/31 00:00:00', '32', '2013-07-09 16:45:14');
INSERT INTO kien_his_download_softpin VALUES('238', '774', '5550-7915-38947', '53403416676', '1', '2016/12/31 00:00:00', '32', '2013-07-09 16:45:15');
INSERT INTO kien_his_download_softpin VALUES('239', '774', '5550-7980-98445', '53403416677', '1', '2016/12/31 00:00:00', '32', '2013-07-09 16:45:15');
INSERT INTO kien_his_download_softpin VALUES('240', '774', '5550-7478-17317', '53403416678', '1', '2016/12/31 00:00:00', '32', '2013-07-09 16:45:15');
INSERT INTO kien_his_download_softpin VALUES('241', '775', '309018887639', '015133000004413', '26', '2015/12/31 00:00:00', '32', '2013-07-09 16:52:03');
INSERT INTO kien_his_download_softpin VALUES('242', '775', '279239852569', '015133000004414', '26', '2015/12/31 00:00:00', '32', '2013-07-09 16:52:03');
INSERT INTO kien_his_download_softpin VALUES('243', '775', '630703411240', '015133000004415', '26', '2015/12/31 00:00:00', '32', '2013-07-09 16:52:03');

INSERT INTO kien_his_download_softpin VALUES('245', '777', '167898364393', '015844000000251', '28', '2015/12/31 00:00:00', '32', '2013-07-09 16:54:09');
INSERT INTO kien_his_download_softpin VALUES('246', '777', '438191236268', '015844000000252', '28', '2015/12/31 00:00:00', '32', '2013-07-09 16:54:09');
INSERT INTO kien_his_download_softpin VALUES('247', '777', '006546634474', '015844000000253', '28', '2015/12/31 00:00:00', '32', '2013-07-09 16:54:09');
INSERT INTO kien_his_download_softpin VALUES('248', '778', '4878-7616-8293', '28468000677', '85', '2015/12/31 00:00:00', '32', '2013-07-09 16:58:47');
INSERT INTO kien_his_download_softpin VALUES('249', '778', '2320-5322-0141', '28468000678', '85', '2015/12/31 00:00:00', '32', '2013-07-09 16:58:47');
INSERT INTO kien_his_download_softpin VALUES('250', '778', '8048-8224-8565', '28468000679', '85', '2015/12/31 00:00:00', '32', '2013-07-09 16:58:47');
INSERT INTO kien_his_download_softpin VALUES('251', '778', '1273-0467-9723', '28468000680', '85', '2015/12/31 00:00:00', '32', '2013-07-09 16:58:48');
INSERT INTO kien_his_download_softpin VALUES('252', '778', '7256-0238-1446', '28468000681', '85', '2015/12/31 00:00:00', '32', '2013-07-09 16:58:48');
INSERT INTO kien_his_download_softpin VALUES('253', '779', '7852-9958-5680', '28528000242', '83', '2015/12/31 00:00:00', '32', '2013-07-09 17:10:39');
INSERT INTO kien_his_download_softpin VALUES('254', '779', '3811-2094-1648', '28528000243', '83', '2015/12/31 00:00:00', '32', '2013-07-09 17:10:40');
INSERT INTO kien_his_download_softpin VALUES('255', '779', '6045-1256-1259', '28528000244', '83', '2015/12/31 00:00:00', '32', '2013-07-09 17:10:40');
INSERT INTO kien_his_download_softpin VALUES('256', '779', '8367-6077-3987', '28528000245', '83', '2015/12/31 00:00:00', '32', '2013-07-09 17:10:41');
INSERT INTO kien_his_download_softpin VALUES('257', '779', '8307-5847-0847', '28528000246', '83', '2015/12/31 00:00:00', '32', '2013-07-09 17:10:41');
INSERT INTO kien_his_download_softpin VALUES('258', '780', '0995-5353-5814', '28527025360', '82', '2015/12/31 00:00:00', '32', '2013-07-09 17:15:00');
INSERT INTO kien_his_download_softpin VALUES('259', '780', '5210-3375-1379', '28527025361', '82', '2015/12/31 00:00:00', '32', '2013-07-09 17:15:00');
INSERT INTO kien_his_download_softpin VALUES('260', '780', '5150-6821-0670', '28527025362', '82', '2015/12/31 00:00:00', '32', '2013-07-09 17:15:01');
INSERT INTO kien_his_download_softpin VALUES('261', '780', '1597-7609-8365', '28527025363', '82', '2015/12/31 00:00:00', '32', '2013-07-09 17:15:01');
INSERT INTO kien_his_download_softpin VALUES('262', '780', '8304-5777-2456', '28527025364', '82', '2015/12/31 00:00:00', '32', '2013-07-09 17:15:01');
INSERT INTO kien_his_download_softpin VALUES('263', '783', '381174664546', '015665000000064', '30', '2015/12/31 00:00:00', '33', '2013-07-10 08:31:16');
INSERT INTO kien_his_download_softpin VALUES('264', '785', '30076309635867', 'BHT025902', '20', '2015/12/31 00:00:00', '32', '2013-07-10 09:17:03');
INSERT INTO kien_his_download_softpin VALUES('265', '795', '41539512919802', 'BCZ041401', '22', '2015/12/31 00:00:00', '33', '2013-07-10 13:50:09');
INSERT INTO kien_his_download_softpin VALUES('266', '797', '5554-3347-86794', '53403906344', '4', '2016/12/31 00:00:00', '32', '2013-07-10 14:21:31');
INSERT INTO kien_his_download_softpin VALUES('267', '798', '65732876773079', 'BHT026605', '20', '2015/12/31 00:00:00', '32', '2013-07-10 14:27:57');
INSERT INTO kien_his_download_softpin VALUES('268', '799', '580135487527', 'UQO003947', '17', '2013/12/31 00:00:00', '32', '2013-07-10 14:31:33');
INSERT INTO kien_his_download_softpin VALUES('269', '809', '32261171334208', 'BHT026996', '20', '2015/12/31 00:00:00', '32', '2013-07-10 20:10:03');
INSERT INTO kien_his_download_softpin VALUES('270', '816', 'idJCglK10Z/0XcLS/sgmOA==', '53404100497', '6', '2016/12/31 00:00:00', '32', '2013-07-11 08:37:32');
INSERT INTO kien_his_download_softpin VALUES('271', '824', 'sVVGnHVhNIn7pqSGixA4KA==', '53404100499', '6', '2016/12/31 00:00:00', '32', '2013-07-11 08:37:32');
INSERT INTO kien_his_download_softpin VALUES('272', '824', 'i+Vmmd7EBEZtXmsPTGg==', '53404100500', '6', '2016/12/31 00:00:00', '32', '2013-07-11 08:37:32');
INSERT INTO kien_his_download_softpin VALUES('273', '824', 'hchZ/81RMCG9rnSETuxF/w==', '53404100498', '6', '2016/12/31 00:00:00', '32', '2013-07-11 08:37:32');
INSERT INTO kien_his_download_softpin VALUES('274', '824', '/3+NZgQFfZe93LzM7kKvXQ==', '53404100501', '6', '2016/12/31 00:00:00', '32', '2013-07-11 08:37:32');
INSERT INTO kien_his_download_softpin VALUES('275', '824', 'aZAL28FPdHf1KZl6G6PMxQ==', '53404100502', '6', '2016/12/31 00:00:00', '32', '2013-07-11 08:37:32');
INSERT INTO kien_his_download_softpin VALUES('276', '824', 'qSB/0FWsfT1JuzjwmOiI7A==', '53404100495', '6', '2016/12/31 00:00:00', '32', '2013-07-11 08:37:32');
INSERT INTO kien_his_download_softpin VALUES('277', '824', 'aSCnpvaM20Hmt/oUMoLJtQ==', '53404100496', '6', '2016/12/31 00:00:00', '32', '2013-07-11 08:37:32');
INSERT INTO kien_his_download_softpin VALUES('278', '824', 'vNm56YbTSmJ302zGexOkzA==', '53404100503', '6', '2016/12/31 00:00:00', '32', '2013-07-11 08:37:32');
INSERT INTO kien_his_download_softpin VALUES('279', '829', '5553-1571-20258', '53404100507', '6', '2016/12/31 00:00:00', '32', '2013-07-11 09:00:15');
INSERT INTO kien_his_download_softpin VALUES('280', '830', '1321-3863-11184', '31406301323', '4', '2016/12/31 00:00:00', '38', '2013-07-11 21:50:14');
INSERT INTO kien_his_download_softpin VALUES('281', '831', '5556-3732-81939', '53403709839', '2', '2016/12/31 00:00:00', '38', '2013-07-11 21:51:49');
INSERT INTO kien_his_download_softpin VALUES('282', '832', '1321-3636-28700', '31406301396', '4', '2016/12/31 00:00:00', '33', '2013-07-12 09:07:18');
INSERT INTO kien_his_download_softpin VALUES('283', '852', '1321-5132-47618', '31406302042', '4', '2016/12/31 00:00:00', '32', '2013-07-12 19:43:02');

INSERT INTO kien_his_download_softpin VALUES('286', '909', '1321-6533-17143', '31406302510', '4', '2016/12/31 00:00:00', '32', '2013-07-15 22:53:37');
INSERT INTO kien_his_download_softpin VALUES('287', '909', '1321-6796-04719', '31406302511', '4', '2016/12/31 00:00:00', '32', '2013-07-15 22:53:37');
INSERT INTO kien_his_download_softpin VALUES('288', '912', '1321-6485-71255', '31406302625', '4', '2016/12/31 00:00:00', '32', '2013-07-16 08:36:47');
INSERT INTO kien_his_download_softpin VALUES('289', '913', '1328-2325-28179', '31406002155', '1', '2016/12/31 00:00:00', '32', '2013-07-16 08:49:20');
INSERT INTO kien_his_download_softpin VALUES('290', '925', '1329-5971-33595', '31406105280', '2', '2016/12/31 00:00:00', '32', '2013-07-16 18:33:44');
INSERT INTO kien_his_download_softpin VALUES('291', '939', '1321-7758-45166', '31406302942', '4', '2016/12/31 00:00:00', '32', '2013-07-17 16:12:18');
INSERT INTO kien_his_download_softpin VALUES('292', '940', '1329-6934-86330', '31406105672', '2', '2016/12/31 00:00:00', '32', '2013-07-17 17:40:55');
INSERT INTO kien_his_download_softpin VALUES('293', '941', '1322-4232-70724', '31406400818', '5', '2016/12/31 00:00:00', '32', '2013-07-17 23:36:43');
INSERT INTO kien_his_download_softpin VALUES('295', '944', '035833581935', '016133000000300', '29', '2015/12/31 00:00:00', '32', '2013-07-18 09:36:40');
INSERT INTO kien_his_download_softpin VALUES('296', '945', '1329-6763-47331', '31406105847', '2', '2016/12/31 00:00:00', '32', '2013-07-18 12:25:57');
INSERT INTO kien_his_download_softpin VALUES('297', '946', '1329-6215-59879', '31406105852', '2', '2016/12/31 00:00:00', '32', '2013-07-18 13:34:13');
INSERT INTO kien_his_download_softpin VALUES('298', '950', '503269723121', '015832000000013', '26', '2015/12/31 00:00:00', '32', '2013-07-18 18:19:01');
INSERT INTO kien_his_download_softpin VALUES('299', '956', '71230153925357', 'BHS001187', '19', '2015/12/31 00:00:00', '32', '2013-07-19 09:19:35');
INSERT INTO kien_his_download_softpin VALUES('300', '962', '15113349065039', 'AWU084392', '18', '2015/12/31 00:00:00', '38', '2013-07-19 14:05:17');
INSERT INTO kien_his_download_softpin VALUES('301', '968', '1329-7962-52059', '31406106512', '2', '2016/12/31 00:00:00', '32', '2013-07-19 16:04:41');
INSERT INTO kien_his_download_softpin VALUES('302', '982', '97459709915722', 'BCZ046236', '22', '2015/12/31 00:00:00', '33', '2013-07-20 10:52:31');
INSERT INTO kien_his_download_softpin VALUES('303', '983', '984306275111', 'QGL694377', '24', '2013/12/31 00:00:00', '32', '2013-07-20 12:41:53');
INSERT INTO kien_his_download_softpin VALUES('304', '1000', '1329-7085-31404', '31406106954', '2', '2016/12/31 00:00:00', '38', '2013-07-20 22:24:38');
INSERT INTO kien_his_download_softpin VALUES('305', '1004', '1329-7424-17491', '31406107001', '2', '2016/12/31 00:00:00', '32', '2013-07-21 10:26:50');
INSERT INTO kien_his_download_softpin VALUES('306', '1016', '415166062131', '016132000000884', '28', '2015/12/31 00:00:00', '32', '2013-07-22 09:54:13');
INSERT INTO kien_his_download_softpin VALUES('307', '1022', '1321-9124-00225', '31406303890', '4', '2016/12/31 00:00:00', '32', '2013-07-22 13:07:29');
INSERT INTO kien_his_download_softpin VALUES('309', '1196', '1929-3262-62557', '91977702460', '4', '2016/12/31 00:00:00', '32', '2013-07-25 10:49:12');
INSERT INTO kien_his_download_softpin VALUES('310', '1197', '1929-3932-49735', '91977702463', '4', '2016/12/31 00:00:00', '32', '2013-07-25 10:51:45');
INSERT INTO kien_his_download_softpin VALUES('311', '1199', '1929-3248-36686', '91977702476', '4', '2016/12/31 00:00:00', '32', '2013-07-25 11:22:14');
INSERT INTO kien_his_download_softpin VALUES('312', '1202', '1929-3655-52274', '91977702487', '4', '2016/12/31 00:00:00', '32', '2013-07-25 11:42:41');
INSERT INTO kien_his_download_softpin VALUES('313', '1203', '1920-2412-86294', '91977801247', '5', '2016/12/31 00:00:00', '32', '2013-07-25 11:47:41');
INSERT INTO kien_his_download_softpin VALUES('314', '1204', '608939139399', '016132000002255', '28', '2015/12/31 00:00:00', '32', '2013-07-25 12:29:58');
INSERT INTO kien_his_download_softpin VALUES('315', '1209', '708598846553', '016444000000146', '30', '2015/12/31 00:00:00', '33', '2013-07-25 15:56:25');
INSERT INTO kien_his_download_softpin VALUES('316', '1233', '1329-9944-14877', '31406108954', '2', '2016/12/31 00:00:00', '32', '2013-07-25 17:54:34');
INSERT INTO kien_his_download_softpin VALUES('317', '1244', '5553-1039-44919', '53404101251', '6', '2016/12/31 00:00:00', '32', '2013-07-26 15:54:11');
INSERT INTO kien_his_download_softpin VALUES('319', '1249', '1929-4820-67856', '91977703522', '4', '2016/12/31 00:00:00', '32', '2013-07-26 19:05:40');
INSERT INTO kien_his_download_softpin VALUES('320', '1250', '5553-1262-71180', '53404101261', '6', '2016/12/31 00:00:00', '32', '2013-07-26 19:10:46');
INSERT INTO kien_his_download_softpin VALUES('321', '1252', '966113674790', '016443000001139', '29', '2015/12/31 00:00:00', '32', '2013-07-26 19:25:23');
INSERT INTO kien_his_download_softpin VALUES('322', '1252', '784051680266', '016443000001140', '29', '2015/12/31 00:00:00', '32', '2013-07-26 19:25:23');
INSERT INTO kien_his_download_softpin VALUES('323', '1253', '1929-4754-69853', '91977703535', '4', '2016/12/31 00:00:00', '32', '2013-07-26 19:28:51');
INSERT INTO kien_his_download_softpin VALUES('324', '1254', '1929-4467-02602', '91977703536', '4', '2016/12/31 00:00:00', '32', '2013-07-26 19:28:51');
INSERT INTO kien_his_download_softpin VALUES('327', '1290', '762226472753', '016446000000339', '32', '2015/12/31 00:00:00', '33', '2013-07-27 20:18:35');
INSERT INTO kien_his_download_softpin VALUES('328', '1290', '697604247671', '016446000000340', '32', '2015/12/31 00:00:00', '33', '2013-07-27 20:18:35');
INSERT INTO kien_his_download_softpin VALUES('329', '1292', '507661473528', '016444000000264', '30', '2015/12/31 00:00:00', '33', '2013-07-27 20:21:52');
INSERT INTO kien_his_download_softpin VALUES('330', '1297', '1928-3263-84075', '91977602173', '2', '2016/12/31 00:00:00', '32', '2013-07-30 17:24:06');
INSERT INTO kien_his_download_softpin VALUES('331', '1297', '1928-3044-47371', '91977602174', '2', '2016/12/31 00:00:00', '32', '2013-07-30 17:24:06');
INSERT INTO kien_his_download_softpin VALUES('332', '1297', '1928-3471-05831', '91977602175', '2', '2016/12/31 00:00:00', '32', '2013-07-30 17:24:06');
INSERT INTO kien_his_download_softpin VALUES('333', '1297', '1928-3149-20831', '91977602176', '2', '2016/12/31 00:00:00', '32', '2013-07-30 17:24:06');
INSERT INTO kien_his_download_softpin VALUES('334', '1297', '1928-3373-20531', '91977602177', '2', '2016/12/31 00:00:00', '32', '2013-07-30 17:24:06');
INSERT INTO kien_his_download_softpin VALUES('335', '1298', '1928-3854-09042', '91977602179', '2', '2016/12/31 00:00:00', '32', '2013-07-30 17:30:41');
INSERT INTO kien_his_download_softpin VALUES('336', '1298', '1928-3362-95316', '91977602180', '2', '2016/12/31 00:00:00', '32', '2013-07-30 17:30:41');
INSERT INTO kien_his_download_softpin VALUES('337', '1298', '1928-3884-71330', '91977602181', '2', '2016/12/31 00:00:00', '32', '2013-07-30 17:30:41');
INSERT INTO kien_his_download_softpin VALUES('340', '1707', '754067669010', '015892000000121', '26', '2015/12/31 00:00:00', '32', '2013-07-31 21:23:01');
INSERT INTO kien_his_download_softpin VALUES('341', '1731', '1921-0476-10646', '91977900041', '6', '2016/12/31 00:00:00', '32', '2013-08-02 19:19:31');
INSERT INTO kien_his_download_softpin VALUES('342', '1734', '1928-4860-85163', '91977602998', '2', '2016/12/31 00:00:00', '32', '2013-08-02 20:14:14');
INSERT INTO kien_his_download_softpin VALUES('344', '1736', '1928-4259-07910', '91977603018', '2', '2016/12/31 00:00:00', '32', '2013-08-02 21:29:57');
INSERT INTO kien_his_download_softpin VALUES('345', '1737', '1928-4826-66571', '91977603019', '2', '2016/12/31 00:00:00', '32', '2013-08-02 21:29:57');
INSERT INTO kien_his_download_softpin VALUES('346', '1738', '1928-4376-68393', '91977603020', '2', '2016/12/31 00:00:00', '32', '2013-08-02 21:29:57');
INSERT INTO kien_his_download_softpin VALUES('347', '1739', '1325-9313-50559', '31405748943', '1', '2016/12/31 00:00:00', '32', '2013-08-02 22:05:38');
INSERT INTO kien_his_download_softpin VALUES('352', '1746', '701678508747', '016131000022076', '25', '2015/12/31 00:00:00', '32', '2013-08-02 23:49:56');
INSERT INTO kien_his_download_softpin VALUES('353', '1747', '049263938841', '016131000022077', '25', '2015/12/31 00:00:00', '32', '2013-08-02 23:49:57');
INSERT INTO kien_his_download_softpin VALUES('354', '1748', '687031061359', '016131000022078', '25', '2015/12/31 00:00:00', '32', '2013-08-02 23:49:57');
INSERT INTO kien_his_download_softpin VALUES('355', '1749', '198930372055', '015892000000520', '26', '2015/12/31 00:00:00', '32', '2013-08-02 23:51:11');
INSERT INTO kien_his_download_softpin VALUES('356', '1750', '759938672584', '015892000000521', '26', '2015/12/31 00:00:00', '32', '2013-08-02 23:51:11');
INSERT INTO kien_his_download_softpin VALUES('357', '1751', '315169400270', '015892000000522', '26', '2015/12/31 00:00:00', '32', '2013-08-02 23:51:12');
INSERT INTO kien_his_download_softpin VALUES('358', '1752', '2001-1031-1205', '28726005612', '82', '2015/12/31 00:00:00', '32', '2013-08-02 23:52:39');
INSERT INTO kien_his_download_softpin VALUES('359', '1753', '0639-2572-4196', '28726005613', '82', '2015/12/31 00:00:00', '32', '2013-08-02 23:52:39');
INSERT INTO kien_his_download_softpin VALUES('360', '1754', '4994-5988-8652', '28726005614', '82', '2015/12/31 00:00:00', '32', '2013-08-02 23:52:40');
INSERT INTO kien_his_download_softpin VALUES('361', '1758', '568012477803', 'UQO017302', '17', '2013/12/31 00:00:00', '32', '2013-08-03 12:35:37');
INSERT INTO kien_his_download_softpin VALUES('362', '1761', '1928-4264-86885', '91977603468', '2', '2016/12/31 00:00:00', '32', '2013-08-03 19:01:48');
INSERT INTO kien_his_download_softpin VALUES('363', '1764', '72336764108656', 'BHT064210', '20', '2015/12/31 00:00:00', '32', '2013-08-03 19:12:50');
INSERT INTO kien_his_download_softpin VALUES('364', '1766', '1929-7659-78520', '91977705946', '4', '2016/12/31 00:00:00', '32', '2013-08-03 21:32:27');
INSERT INTO kien_his_download_softpin VALUES('365', '1776', '070974947196', '015892000000822', '26', '2015/12/31 00:00:00', '32', '2013-08-04 21:16:37');
INSERT INTO kien_his_download_softpin VALUES('366', '1782', '1928-6478-47676', '91977604426', '2', '2016/12/31 00:00:00', '32', '2013-08-05 18:10:12');
INSERT INTO kien_his_download_softpin VALUES('369', '1798', '1929-9873-91121', '91977707493', '4', '2016/12/31 00:00:00', '32', '2013-08-07 18:33:09');
INSERT INTO kien_his_download_softpin VALUES('370', '1799', '1928-8614-67064', '91977606021', '2', '2016/12/31 00:00:00', '32', '2013-08-07 18:37:17');
INSERT INTO kien_his_download_softpin VALUES('371', '1806', '082137722235', '016852000000559', '28', '2015/12/31 00:00:00', '32', '2013-08-08 09:51:02');
INSERT INTO kien_his_download_softpin VALUES('372', '1806', '760349977667', '016852000000560', '28', '2015/12/31 00:00:00', '32', '2013-08-08 09:51:02');
INSERT INTO kien_his_download_softpin VALUES('373', '1811', 'W644D7RL3', 'MA0205683026', '73', '2014/08/02 00:00:00', '35', '2013-08-08 14:46:29');
INSERT INTO kien_his_download_softpin VALUES('374', '1811', '67D2K69N6', 'MA0205683027', '73', '2014/08/02 00:00:00', '35', '2013-08-08 14:46:29');
INSERT INTO kien_his_download_softpin VALUES('375', '1812', 'WJY9ARPHR', 'MA0205683028', '73', '2014/08/02 00:00:00', '35', '2013-08-08 14:47:38');
INSERT INTO kien_his_download_softpin VALUES('376', '1813', '2PJD6Y2BB', 'HA0203961785', '69', '2014/08/02 00:00:00', '35', '2013-08-08 14:48:39');
INSERT INTO kien_his_download_softpin VALUES('377', '1813', 'K23K3KYBK', 'HA0203961786', '69', '2014/08/02 00:00:00', '35', '2013-08-08 14:48:39');
INSERT INTO kien_his_download_softpin VALUES('378', '1817', '47147709918474', 'AWU101880', '18', '2015/12/31 00:00:00', '32', '2013-08-08 18:39:53');
INSERT INTO kien_his_download_softpin VALUES('379', '1817', '92051831141474', 'AWU101881', '18', '2015/12/31 00:00:00', '32', '2013-08-08 18:39:53');
INSERT INTO kien_his_download_softpin VALUES('380', '1817', '54960840828720', 'AWU101882', '18', '2015/12/31 00:00:00', '32', '2013-08-08 18:39:53');
INSERT INTO kien_his_download_softpin VALUES('381', '1824', '2T3L3L8T2', 'MA0205692770', '73', '2014/08/07 00:00:00', '35', '2013-08-09 00:09:33');
INSERT INTO kien_his_download_softpin VALUES('382', '1824', 'XPN2XWKLP', 'MA0205692771', '73', '2014/08/07 00:00:00', '35', '2013-08-09 00:09:33');
INSERT INTO kien_his_download_softpin VALUES('383', '1824', 'D242LJJ3J', 'MA0205692772', '73', '2014/08/07 00:00:00', '35', '2013-08-09 00:09:33');
INSERT INTO kien_his_download_softpin VALUES('385', '1832', '290901812854', '016851000002377', '25', '2015/12/31 00:00:00', '32', '2013-08-09 10:32:17');
INSERT INTO kien_his_download_softpin VALUES('386', '1835', '1128-1228-82982', '11514101169', '2', '2016/12/31 00:00:00', '32', '2013-08-09 12:42:59');
INSERT INTO kien_his_download_softpin VALUES('387', '1845', '1129-2204-46764', '11514201555', '4', '2016/12/31 00:00:00', '32', '2013-08-10 00:02:25');
INSERT INTO kien_his_download_softpin VALUES('388', '1845', '1129-2830-68010', '11514201556', '4', '2016/12/31 00:00:00', '32', '2013-08-10 00:02:25');
INSERT INTO kien_his_download_softpin VALUES('389', '1845', '1129-2671-28599', '11514201554', '4', '2016/12/31 00:00:00', '32', '2013-08-10 00:02:25');
INSERT INTO kien_his_download_softpin VALUES('390', '1845', '1129-2177-28675', '11514201557', '4', '2016/12/31 00:00:00', '32', '2013-08-10 00:02:25');
INSERT INTO kien_his_download_softpin VALUES('391', '1846', '1129-2432-32771', '11514201558', '4', '2016/12/31 00:00:00', '32', '2013-08-10 00:02:26');
INSERT INTO kien_his_download_softpin VALUES('392', '1847', '1129-2882-32499', '11514201559', '4', '2016/12/31 00:00:00', '32', '2013-08-10 00:02:26');
INSERT INTO kien_his_download_softpin VALUES('393', '1849', '1129-2801-54583', '11514201652', '4', '2016/12/31 00:00:00', '32', '2013-08-10 10:23:35');
INSERT INTO kien_his_download_softpin VALUES('399', '1855', '1129-2864-22837', '11514201675', '4', '2016/12/31 00:00:00', '32', '2013-08-10 10:55:32');
INSERT INTO kien_his_download_softpin VALUES('400', '1856', '1128-4307-56742', '11514102612', '2', '2016/12/31 00:00:00', '32', '2013-08-10 10:57:29');
INSERT INTO kien_his_download_softpin VALUES('401', '1856', '1128-4200-64782', '11514102613', '2', '2016/12/31 00:00:00', '32', '2013-08-10 10:57:29');
INSERT INTO kien_his_download_softpin VALUES('402', '1857', '1128-4374-88188', '11514102616', '2', '2016/12/31 00:00:00', '32', '2013-08-10 11:04:58');
INSERT INTO kien_his_download_softpin VALUES('403', '1860', '1120-0848-70602', '11514300202', '5', '2016/12/31 00:00:00', '32', '2013-08-10 15:56:13');
INSERT INTO kien_his_download_softpin VALUES('404', '1863', '54186983744163', 'BHV005212', '22', '2015/12/31 00:00:00', '32', '2013-08-10 17:26:21');
INSERT INTO kien_his_download_softpin VALUES('405', '1864', '19068656488057', 'BHU037942', '21', '2015/12/31 00:00:00', '32', '2013-08-10 17:28:42');
INSERT INTO kien_his_download_softpin VALUES('406', '1873', '1128-4997-89204', '11514102805', '2', '2016/12/31 00:00:00', '32', '2013-08-10 20:54:54');
INSERT INTO kien_his_download_softpin VALUES('407', '1884', '1120-1864-90757', '11514300642', '5', '2016/12/31 00:00:00', '32', '2013-08-12 10:54:39');
INSERT INTO kien_his_download_softpin VALUES('408', '1962', '1128-5736-73927', '11514103185', '2', '2016/12/31 00:00:00', '32', '2013-08-12 18:23:53');
INSERT INTO kien_his_download_softpin VALUES('409', '1967', '1320-1759-80542', '31406200094', '3', '2016/12/31 00:00:00', '32', '2013-08-12 22:19:36');
INSERT INTO kien_his_download_softpin VALUES('410', '1977', '3073-0502-8915', '3114169578', '75', '2013/12/31 00:00:00', '32', '2013-08-13 12:00:09');
INSERT INTO kien_his_download_softpin VALUES('411', '1978', '101160573675', '016965000000785', '29', '2015/12/31 00:00:00', '38', '2013-08-13 14:10:24');
INSERT INTO kien_his_download_softpin VALUES('412', '2001', '1121-9912-78772', '11514400285', '6', '2016/12/31 00:00:00', '38', '2013-08-14 08:55:36');
INSERT INTO kien_his_download_softpin VALUES('413', '2011', '1320-3621-79098', '31406200161', '3', '2016/12/31 00:00:00', '32', '2013-08-16 11:20:55');
INSERT INTO kien_his_download_softpin VALUES('414', '2083', '1121-5176-23359', '11560405318', '2', '2016/12/31 00:00:00', '32', '2013-08-16 17:10:55');
INSERT INTO kien_his_download_softpin VALUES('415', '2084', '159064848969', '017083000000786', '28', '2015/12/31 00:00:00', '32', '2013-08-16 17:14:32');
INSERT INTO kien_his_download_softpin VALUES('416', '2097', '8169-4211-5086', '28813002809', '82', '2015/12/31 00:00:00', '32', '2013-08-18 10:29:14');
INSERT INTO kien_his_download_softpin VALUES('417', '2100', '5560-9281-5374', '28813002810', '82', '2015/12/31 00:00:00', '32', '2013-08-18 10:36:26');
INSERT INTO kien_his_download_softpin VALUES('418', '2100', '7466-2834-1507', '28813002811', '82', '2015/12/31 00:00:00', '32', '2013-08-18 10:36:26');
INSERT INTO kien_his_download_softpin VALUES('419', '2103', '', '28813002812', '82', '2015/12/31 00:00:00', '32', '2013-08-18 10:36:28');
INSERT INTO kien_his_download_softpin VALUES('420', '2103', '3475-7642-5276', '28813002814', '82', '2015/12/31 00:00:00', '32', '2013-08-18 10:36:29');
INSERT INTO kien_his_download_softpin VALUES('421', '2103', '0226-5043-2722', '28813002813', '82', '2015/12/31 00:00:00', '32', '2013-08-18 10:36:29');
INSERT INTO kien_his_download_softpin VALUES('424', '2114', '5088-8103-0755', '3114169698', '75', '2013/12/31 00:00:00', '32', '2013-08-19 08:08:34');
INSERT INTO kien_his_download_softpin VALUES('425', '2165', '1121-5335-39583', '11560405818', '2', '2016/12/31 00:00:00', '32', '2013-08-19 09:26:03');
INSERT INTO kien_his_download_softpin VALUES('428', '2173', '973090700690', '017082000000888', '26', '2015/12/31 00:00:00', '38', '2013-08-23 13:57:07');
INSERT INTO kien_his_download_softpin VALUES('429', '2175', 'MR7D7J4RM', 'MA0209683823', '73', '2014/08/17 00:00:00', '35', '2013-08-25 18:12:26');
INSERT INTO kien_his_download_softpin VALUES('430', '2176', '6PXJA8TM2', 'HA0204024952', '69', '2014/08/17 00:00:00', '35', '2013-08-25 18:12:47');
INSERT INTO kien_his_download_softpin VALUES('431', '2177', '917189010453', '017307000000213', '32', '2015/12/31 00:00:00', '33', '2013-08-26 00:27:48');
INSERT INTO kien_his_download_softpin VALUES('432', '2181', '1124-9036-95901', '11560700752', '6', '2016/12/31 00:00:00', '32', '2013-08-26 15:36:45');
INSERT INTO kien_his_download_softpin VALUES('433', '2206', '1122829384981', '11517106565', '2', '2015/01/01 00:00:00', '32', '2013-08-27 11:22:21');
INSERT INTO kien_his_download_softpin VALUES('434', '2212', '1122-9301-88701', '11560505454', '4', '2016/12/31 00:00:00', '32', '2013-08-27 14:17:13');
INSERT INTO kien_his_download_softpin VALUES('435', '2213', '778350933714', '017513000000338', '28', '2015/12/31 00:00:00', '32', '2013-08-27 14:24:27');
INSERT INTO kien_his_download_softpin VALUES('436', '2214', '1123-6163-99474', '11560601582', '5', '2016/12/31 00:00:00', '32', '2013-08-27 14:51:10');
INSERT INTO kien_his_download_softpin VALUES('437', '2215', '1122-9123-70041', '11560505771', '4', '2016/12/31 00:00:00', '32', '2013-08-27 14:56:01');
INSERT INTO kien_his_download_softpin VALUES('439', '2222', '0354-1321-1606', '3121102300', '74', '2015/12/31 00:00:00', '32', '2013-08-27 20:03:08');
INSERT INTO kien_his_download_softpin VALUES('440', '2224', '230056249492', '017302000002360', '26', '2015/12/31 00:00:00', '32', '2013-08-27 21:42:55');
INSERT INTO kien_his_download_softpin VALUES('441', '2225', '1320-9796-77188', '31406200466', '3', '2016/12/31 00:00:00', '32', '2013-08-27 21:48:36');
INSERT INTO kien_his_download_softpin VALUES('442', '2236', '355552457346', '017513000000876', '28', '2015/12/31 00:00:00', '38', '2013-08-28 10:26:19');
INSERT INTO kien_his_download_softpin VALUES('443', '2241', '604247021327', '017513000000878', '28', '2015/12/31 00:00:00', '38', '2013-08-28 11:16:12');
INSERT INTO kien_his_download_softpin VALUES('449', '2316', '516603505105', 'UQO037203', '17', '2013/12/31 00:00:00', '32', '2013-09-02 11:01:49');
INSERT INTO kien_his_download_softpin VALUES('450', '2321', '1928118548751', '92013705523', '4', '2016/12/31 00:00:00', '38', '2013-09-03 00:52:15');
INSERT INTO kien_his_download_softpin VALUES('451', '2322', 'NDKNRPB3R', 'MA0209728169', '73', '2014/08/29 00:00:00', '38', '2013-09-03 01:10:52');
INSERT INTO kien_his_download_softpin VALUES('452', '2336', '1126-3178-59636', '11563203550', '2', '2016/12/31 00:00:00', '32', '2013-09-04 17:49:28');
INSERT INTO kien_his_download_softpin VALUES('453', '2350', '1124-7492-03019', '11563035489', '1', '2016/12/31 00:00:00', '32', '2013-09-06 10:40:30'); 
INSERT INTO kien_his_download_softpin VALUES('454', '2354', '1127-0197-52207', '11563300030', '3', '2016/12/31 00:00:00', '32', '2013-09-06 12:01:29');
INSERT INTO kien_his_download_softpin VALUES('455', '2381', '1124-3228-73164', '11563017120', '1', '2016/12/31 00:00:00', '32', '2013-09-08 16:08:17'); 
INSERT INTO kien_his_download_softpin VALUES('456', '2391', '1128-6740-57765', '11563404299', '4', '2016/12/31 00:00:00', '32', '2013-09-09 14:08:17');
INSERT INTO kien_his_download_softpin VALUES('457', '2392', '971567466063', '017673000001552', '28', '2015/12/31 00:00:00', '32', '2013-09-09 14:54:25');
INSERT INTO kien_his_download_softpin VALUES('458', '2393', '011076254669', '017981000000308', '25', '2015/12/31 00:00:00', '32', '2013-09-09 16:47:36');
INSERT INTO kien_his_download_softpin VALUES('459', '2394', '1129-3728-63581', '11563501813', '5', '2016/12/31 00:00:00', '32', '2013-09-09 19:57:06');
INSERT INTO kien_his_download_softpin VALUES('460', '2399', '1124-4735-21841', '11563024966', '1', '2016/12/31 00:00:00', '32', '2013-09-10 09:34:58'); 
INSERT INTO kien_his_download_softpin VALUES('461', '2400', '1129-3056-68601', '11563501834', '5', '2016/12/31 00:00:00', '32', '2013-09-10 11:26:02');
INSERT INTO kien_his_download_softpin VALUES('462', '2401', '1128-6924-88830', '11563404625', '4', '2016/12/31 00:00:00', '32', '2013-09-10 11:29:27');
INSERT INTO kien_his_download_softpin VALUES('463', '2402', '1126-8571-43676', '11563207772', '2', '2016/12/31 00:00:00', '32', '2013-09-10 11:32:14');
INSERT INTO kien_his_download_softpin VALUES('464', '2515', '48626170766959', 'BHU059303', '21', '2016/05/31 00:00:00', '33', '2013-09-11 21:09:36');
INSERT INTO kien_his_download_softpin VALUES('465', '2614', '1122-3034-90439', '11563800222', '8', '2016/12/31 00:00:00', '33', '2013-09-18 00:38:22');
INSERT INTO kien_his_download_softpin VALUES('466', '2615', '1122-3838-96300', '11563800223', '8', '2016/12/31 00:00:00', '33', '2013-09-18 01:27:42');
INSERT INTO kien_his_download_softpin VALUES('467', '2619', '1121-3194-12448', '11566917272', '1', '2016/12/31 00:00:00', '32', '2013-09-18 09:14:43'); 
INSERT INTO kien_his_download_softpin VALUES('468', '2620', '1127-4421-00032', '11567500248', '6', '2016/12/31 00:00:00', '32', '2013-09-18 09:18:33');
INSERT INTO kien_his_download_softpin VALUES('469', '2621', '1124-8072-39941', '11567207739', '2', '2016/12/31 00:00:00', '32', '2013-09-18 09:23:57');
INSERT INTO kien_his_download_softpin VALUES('470', '2622', '1124-8798-90641', '11567207754', '2', '2016/12/31 00:00:00', '32', '2013-09-18 10:59:56');
INSERT INTO kien_his_download_softpin VALUES('471', '2623', '1121-3475-81310', '11566918490', '1', '2016/12/31 00:00:00', '32', '2013-09-18 11:03:12'); 
INSERT INTO kien_his_download_softpin VALUES('472', '2625', '1126-3942-93676', '11567402073', '5', '2016/12/31 00:00:00', '35', '2013-09-18 12:05:15');
INSERT INTO kien_his_download_softpin VALUES('473', '2626', '1125-4103-14517', '11567303527', '4', '2016/12/31 00:00:00', '35', '2013-09-18 13:20:00');
INSERT INTO kien_his_download_softpin VALUES('474', '2637', '1121-5046-27298', '11566926520', '1', '2016/12/31 00:00:00', '32', '2013-09-18 20:45:59'); 
INSERT INTO kien_his_download_softpin VALUES('475', '2654', '751146950118', '018244000000725', '29', '2015/12/31 00:00:00', '32', '2013-09-19 11:58:22');
INSERT INTO kien_his_download_softpin VALUES('476', '2684', '1121-5220-98518', '11566928815', '1', '2016/12/31 00:00:00', '32', '2013-09-20 09:34:49');
INSERT INTO kien_his_download_softpin VALUES('477', '2687', '98250532746979', 'BML045259', '20', '2016/05/31 00:00:00', '33', '2013-09-20 10:00:35');
INSERT INTO kien_his_download_softpin VALUES('478', '2690', '93984916617179', 'BML045260', '20', '2016/05/31 00:00:00', '33', '2013-09-20 10:17:58');
INSERT INTO kien_his_download_softpin VALUES('479', '2700', '81334125035952', 'BML045341', '20', '2016/05/31 00:00:00', '32', '2013-09-20 17:15:36');
INSERT INTO kien_his_download_softpin VALUES('480', '2745', '660902500438', '018243000000335', '28', '2015/12/31 00:00:00', '32', '2013-09-21 13:42:14');


INSERT INTO kien_his_download_softpin VALUES('481', '2778', '1121-7424-89207', '11566935016', '1', '2016/12/31 00:00:00', '32', '2013-09-23 13:48:20'); 


INSERT INTO kien_his_download_softpin VALUES('482', '2811', '351325415949', '018242000001305', '26', '2015/12/31 00:00:00', '32', '2013-09-24 15:35:10');
INSERT INTO kien_his_download_softpin VALUES('483', '2812', '022909833332', '018242000001319', '26', '2015/12/31 00:00:00', '32', '2013-09-24 15:46:03');
INSERT INTO kien_his_download_softpin VALUES('484', '2818', '1220-3577-07480', '21841500456', '6', '2016/12/31 00:00:00', '33', '2013-09-25 16:31:27');
INSERT INTO kien_his_download_softpin VALUES('485', '2837', '1229-6559-40396', '21841406168', '5', '2016/12/31 00:00:00', '32', '2013-09-25 23:04:59');
INSERT INTO kien_his_download_softpin VALUES('486', '2902', '1127471891460', '11568502020', '5', '2015/01/01 00:00:00', '32', '2013-09-26 10:41:04');
INSERT INTO kien_his_download_softpin VALUES('487', '2907', '1127489055486', '11568502035', '5', '2015/01/01 00:00:00', '32', '2013-09-26 11:07:10');
INSERT INTO kien_his_download_softpin VALUES('488', '2907', '1127494417684', '11568502036', '5', '2015/01/01 00:00:00', '32', '2013-09-26 11:07:11');
INSERT INTO kien_his_download_softpin VALUES('489', '2909', '1228-6132-65199', '21841306517', '4', '2016/12/31 00:00:00', '33', '2013-09-26 12:01:27');
INSERT INTO kien_his_download_softpin VALUES('490', '2913', '1226-4919-63102', '21841104542', '2', '2016/12/31 00:00:00', '32', '2013-09-26 16:13:58');


INSERT INTO kien_his_download_softpin VALUES('491', '2914', '1225-3661-30429', '21841010389', '1', '2016/12/31 00:00:00', '32', '2013-09-26 16:42:52'); 

INSERT INTO kien_his_download_softpin VALUES('492', '2916', '1228-8533-14193', '21841308087', '4', '2016/12/31 00:00:00', '32', '2013-09-26 16:48:55');



INSERT INTO kien_his_download_softpin VALUES('493', '2924', '1225-3427-85177', '21841010572', '1', '2016/12/31 00:00:00', '32', '2013-09-26 20:09:18'); 
INSERT INTO kien_his_download_softpin VALUES('494', '2988', '1225-4001-36881', '21841012066', '1', '2016/12/31 00:00:00', '32', '2013-09-27 09:45:31'); 
INSERT INTO kien_his_download_softpin VALUES('495', '3002', '1225-6637-11525', '21841018016', '1', '2016/12/31 00:00:00', '32', '2013-09-28 16:23:06'); 

INSERT INTO kien_his_download_softpin VALUES('496', '3003', '1225-6586-95071', '21841018017', '1', '2016/12/31 00:00:00', '32', '2013-09-28 16:32:38'); 

INSERT INTO kien_his_download_softpin VALUES('497', '3004', '1225-6703-43765', '21841018019', '1', '2016/12/31 00:00:00', '32', '2013-09-28 16:49:17'); 


INSERT INTO kien_his_download_softpin VALUES('498', '3010', '1226-2796-01320', '21844502243', '5', '2016/12/31 00:00:00', '32', '2013-09-28 21:57:08');
INSERT INTO kien_his_download_softpin VALUES('499', '3012', '1226-8646-42255', '21841108095', '2', '2016/12/31 00:00:00', '32', '2013-09-29 08:25:02');
INSERT INTO kien_his_download_softpin VALUES('500', '3030', '1227-9465-92912', '21843101354', '6', '2016/12/31 00:00:00', '32', '2013-09-30 14:11:29');
INSERT INTO kien_his_download_softpin VALUES('501', '3031', '1225-3617-27278', '21844403116', '4', '2016/12/31 00:00:00', '32', '2013-09-30 14:33:23');
INSERT INTO kien_his_download_softpin VALUES('502', '3035', '1226-9101-46784', '21841109912', '2', '2016/12/31 00:00:00', '32', '2013-09-30 20:01:31');


INSERT INTO kien_his_download_softpin VALUES('503', '3038', '1225-6487-59364', '21844404994', '4', '2016/12/31 00:00:00', '32', '2013-10-01 09:09:52');
INSERT INTO kien_his_download_softpin VALUES('504', '3044', '1224-1787-63585', '21842800965', '2', '2016/12/31 00:00:00', '32', '2013-10-01 13:01:14');
INSERT INTO kien_his_download_softpin VALUES('505', '3047', 'L988X94XR', 'MA0209730767', '73', '2014/08/29 00:00:00', '33', '2013-10-01 14:47:36');
INSERT INTO kien_his_download_softpin VALUES('506', '3048', 'MD2PYJ6JW', 'MA0209730771', '73', '2014/08/29 00:00:00', '33', '2013-10-01 15:00:30');
INSERT INTO kien_his_download_softpin VALUES('507', '3049', '4T6ND8TJP', 'MA0209730772', '73', '2014/08/29 00:00:00', '33', '2013-10-01 15:02:49');
INSERT INTO kien_his_download_softpin VALUES('508', '3050', 'MAXD4A9AB', 'MA0209730773', '73', '2014/08/29 00:00:00', '33', '2013-10-01 15:09:58');
INSERT INTO kien_his_download_softpin VALUES('509', '3051', 'PRT2KTHBP', 'HA0204078144', '69', '2014/08/29 00:00:00', '33', '2013-10-01 15:10:33');
INSERT INTO kien_his_download_softpin VALUES('510', '3052', '1229-3781-44669', '21843300396', '8', '2016/12/31 00:00:00', '33', '2013-10-01 15:11:12');
INSERT INTO kien_his_download_softpin VALUES('511', '3053', '807281921210', '018746000000581', '32', '2015/12/31 00:00:00', '33', '2013-10-01 15:44:42');
INSERT INTO kien_his_download_softpin VALUES('512', '3053', '918823820104', '018746000000582', '32', '2015/12/31 00:00:00', '33', '2013-10-01 15:44:42');
INSERT INTO kien_his_download_softpin VALUES('513', '3056', '1226-6764-83884', ' 21844506726', '5', '2016/12/31 00:00:00', '33', '2013-10-02 10:12:52');
INSERT INTO kien_his_download_softpin VALUES('514', '3057', '1225-8378-68885', '21844406993', '4', '2016/12/31 00:00:00', '33', '2013-10-02 17:15:16');
INSERT INTO kien_his_download_softpin VALUES('515', '3058', '27094491243987', 'AWU156185', '18', '6199/10/01 00:00:00', '36', '2013-10-04 15:36:44');


INSERT INTO kien_his_download_softpin VALUES('516', '3060', '1225-4978-55699', '21842900849', '4', '2016/12/31 00:00:00', '32', '2013-10-04 15:42:25'); 


INSERT INTO kien_his_download_softpin VALUES('517', '3061', '275730074342', '018893000000089', '30', '2015/12/31 00:00:00', '33', '2013-10-04 16:25:58');
INSERT INTO kien_his_download_softpin VALUES('518', '3062', '721596833211', '018892000002634', '29', '2015/12/31 00:00:00', '33', '2013-10-04 16:26:30');
INSERT INTO kien_his_download_softpin VALUES('519', '3063', '502027458802', '018803000000051', '28', '2015/12/31 00:00:00', '33', '2013-10-04 16:26:54');

INSERT INTO kien_his_download_softpin VALUES('520', '3068', '1120-0419-66942', '11703200012', '1', '2016/12/31 00:00:00', '32', '2013-10-04 18:44:45'); 

INSERT INTO kien_his_download_softpin VALUES('521', '3068', '1120-0048-79739', '11703200013', '1', '2016/12/31 00:00:00', '32', '2013-10-04 18:44:45');  


INSERT INTO kien_his_download_softpin VALUES('522', '3072', '1923-2060-49615', '92019904398', '1', '2016/12/31 00:00:00', '32', '2013-10-04 21:30:04'); 


INSERT INTO kien_his_download_softpin VALUES('523', '3074', '1229-7938-83483', '21843300759', '8', '2016/12/31 00:00:00', '32', '2013-10-05 09:10:18'); 

INSERT INTO kien_his_download_softpin VALUES('524', '3075', '1123-0946-77161', '11703500204', '5', '2016/12/31 00:00:00', '32', '2013-10-05 09:11:52');  

INSERT INTO kien_his_download_softpin VALUES('525', '3076', '65592812780690', 'BHU098081', '21', '2016/05/31 00:00:00', '32', '2013-10-05 09:12:46');
INSERT INTO kien_his_download_softpin VALUES('526', '3078', '1123-0131-43577', '11703500216', '5', '2016/12/31 00:00:00', '32', '2013-10-05 09:14:55');
INSERT INTO kien_his_download_softpin VALUES('527', '3084', '1223258805020', '21840900134', '6', '2014/10/02 00:00:00', '32', '2013-10-05 09:30:02');
INSERT INTO kien_his_download_softpin VALUES('528', '3085', '1223275331655', '21840900135', '6', '2014/10/02 00:00:00', '32', '2013-10-05 09:30:24');
INSERT INTO kien_his_download_softpin VALUES('529', '3087', '988396287269', '018893000000097', '30', '2015/12/31 00:00:00', '32', '2013-10-05 09:31:05');
INSERT INTO kien_his_download_softpin VALUES('530', '3089', '879330451031', 'UQP056278', '17', '2013/12/31 00:00:00', '32', '2013-10-05 11:37:44');
INSERT INTO kien_his_download_softpin VALUES('531', '3090', '1122-1238-73285', '11703400498', '4', '2016/12/31 00:00:00', '32', '2013-10-05 11:43:47');  

INSERT INTO kien_his_download_softpin VALUES('532', '3091', '1122-1635-75577', '11703400499', '4', '2016/12/31 00:00:00', '32', '2013-10-05 11:44:03');  



INSERT INTO kien_his_download_softpin VALUES('533', '3092', '?N7B3TXPLT?', '?MA0209836992', '73', '2014/10/02 00:00:00', '32', '2013-10-05 11:48:06');
INSERT INTO kien_his_download_softpin VALUES('534', '3094', '5871-7298-9721', '29291000934', '82', '2015/12/31 00:00:00', '32', '2013-10-05 12:01:52');
INSERT INTO kien_his_download_softpin VALUES('535', '0', 'Hjg1ipL3dvicjIKNHocAyw==', '10000204271', '1', '2015/02/17 00:00:00', '3', '2013-12-19 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('536', '0', 'Hjg1ipL3dvhJR/ReQEddrQ==', '10000204272', '1', '2015/02/17 00:00:00', '3', '2013-12-19 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('537', '0', 'Hjg1ipL3dvg+j2r7X21mHw==', '10000204273', '1', '2015/02/17 00:00:00', '3', '2013-12-19 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('538', '0', 'Hjg1ipL3dvhyfWJ8d5tCPQ==', '10000204274', '1', '2015/02/17 00:00:00', '3', '2013-12-19 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('539', '11', 'Hjg1ipL3dviua836isz/BQ==', '10000204275', '1', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('540', '11', 'Hjg1ipL3dvhOb2MeoQTP6g==', '10000204276', '1', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('541', '11', 'Hjg1ipL3dviP/fic1Tdd/w==', '10000204277', '1', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('542', '12', 'Hjg1ipL3dvh0KF+tLtl/CA==', '10000204278', '1', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('543', '13', 'Hjg1ipL3dvgg5P5uRYHJdQ==', '10000204279', '1', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('544', '13', 'Hjg1ipL3dvgVs+N2ha8rIA==', '10000204280', '1', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('545', '14', 'Hjg1ipL3dvhwTd9dICIM+g==', '10000204281', '1', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('546', '14', 'Hjg1ipL3dvgE1g1eOh7Fqw==', '10000204282', '1', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('547', '15', 'Hjg1ipL3dvg1rXjsyrjXhg==', '10000204283', '1', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('548', '18', 'Hjg1ipL3dvhETLJvWrsGbg==', '10000204284', '1', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('549', '27', 'fba19DNi1JSUkQ6RJ2aqcgau8nWxOwhk', 'MOBI1024000', '9', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('550', '27', 'fba19DNi1JSUkQ6RJ2aqcpytF3SADN/u', 'MOBI1024001', '9', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('551', '30', 'IOxDGay4iPRDRSsH+tyCC8Kcl4JbsJtE', 'BVN1080001', '19', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');
INSERT INTO kien_his_download_softpin VALUES('552', '30', 'IOxDGay4iPRDRSsH+tyCCwno67oxHGmm', 'BVN1080002', '19', '2015/02/17 00:00:00', '3', '2013-12-20 00:00:00');

DROP TABLE IF EXISTS kien_history_addmoney_bank;
CREATE TABLE kien_history_addmoney_bank (
   id int(11) NOT NULL auto_increment,
   id_bank int(11) NOT NULL,
   id_request int(11) NOT NULL,
   number_money decimal(11,2) NOT NULL,
   PRIMARY KEY (id),
   KEY id (id),
   KEY id_bank (id_bank),
   KEY id_request (id_request)
);


DROP TABLE IF EXISTS kien_history_addmoney_card;
CREATE TABLE kien_history_addmoney_card (
   id int(11) NOT NULL auto_increment,
   id_loaithe int(11) NOT NULL,
   request_id int(11) NOT NULL,
   pin_code varchar(18) NOT NULL,
   card_code varchar(18) NOT NULL,
   PRIMARY KEY (id),
   KEY id (id),
   KEY request_id (request_id),
   KEY id_loaithe (id_loaithe)
);


DROP TABLE IF EXISTS kien_history_buycard;
CREATE TABLE kien_history_buycard (
   id int(11) NOT NULL auto_increment,
   id_loaithe int(11) NOT NULL,
   qty int(11) NOT NULL,
   thanhtoan int(11) NOT NULL,
   payId int(11) NOT NULL,
   id_request int(11) NOT NULL,
   to_phone varchar(15) NOT NULL,
   to_account_game varchar(200) NOT NULL,
   download tinyint(1) NOT NULL,
   PRIMARY KEY (id),
   KEY id_loaithe (id_loaithe),
   KEY id_request (id_request)
);


DROP TABLE IF EXISTS kien_history_get_services;
CREATE TABLE kien_history_get_services (
   id int(11) NOT NULL auto_increment,
   request_id int(11) NOT NULL,
   pincode varchar(200) NOT NULL,
   serialcode varchar(200) NOT NULL,
   product_id int(11) NOT NULL,
   expiryDate date NOT NULL,
   PRIMARY KEY (id),
   KEY request_id (request_id),
   KEY product_id (product_id)
);


DROP TABLE IF EXISTS kien_history_request;
CREATE TABLE kien_history_request (
   id int(11) NOT NULL auto_increment,
   money decimal(11,2) NOT NULL,
   comment varchar(300) NOT NULL,
   request_id int(11) NOT NULL,
   PRIMARY KEY (id),
   KEY request_id (request_id)
);


DROP TABLE IF EXISTS kien_history_tranfer;
CREATE TABLE kien_history_tranfer (
   id int(11) NOT NULL auto_increment,
   tranto varchar(128) NOT NULL,
   money decimal(11,2) NOT NULL,
   request_id int(11) NOT NULL,
   PRIMARY KEY (id),
   KEY request_id (request_id),
   KEY tranto (tranto)
);


DROP TABLE IF EXISTS kien_hoidap;
CREATE TABLE kien_hoidap (
   id int(11) NOT NULL auto_increment,
   title varchar(200) NOT NULL,
   question text NOT NULL,
   answer text NOT NULL,
   review text NOT NULL,
   PRIMARY KEY (id)
);


DROP TABLE IF EXISTS kien_intro;
CREATE TABLE kien_intro (
   id_intro int(11) NOT NULL auto_increment,
   title_menu varchar(100) NOT NULL,
   title varchar(100) NOT NULL,
   content text NOT NULL,
   publish tinyint(1) NOT NULL,
   list_order int(11) NOT NULL,
   lang_id int(11) NOT NULL,
   PRIMARY KEY (id_intro),
   KEY id_intro (id_intro),
   KEY lang_id (lang_id)
);

INSERT INTO kien_intro VALUES('1', 'Gi?i thi?u', 'Gi?i thi?u v? chúng tôi', '?ang c?p nh?t d? li?u', '1', '1', '1');
INSERT INTO kien_intro VALUES('2', 'H??ng d?n mua th? s?a', 'H??ng d?n s? d?ng h? th?ng s?a', '<p>?ang c?p nh?t n?i dung s?a</p>', '1', '1', '1');

DROP TABLE IF EXISTS kien_language;
CREATE TABLE kien_language (
   id int(11) NOT NULL auto_increment,
   logo varchar(200) NOT NULL,
   link varchar(200) NOT NULL,
   name varchar(100) NOT NULL,
   PRIMARY KEY (id),
   KEY id (id)
);

INSERT INTO kien_language VALUES('1', '1382675943.png', 'vn', 'Ti?ng vi?t');
INSERT INTO kien_language VALUES('2', '1382675980.png', 'en', 'English');

DROP TABLE IF EXISTS kien_linkseo;
CREATE TABLE kien_linkseo (
   id_link int(11) NOT NULL auto_increment,
   keyword varchar(300) NOT NULL,
   linkweb varchar(300) NOT NULL,
   views int(20) NOT NULL,
   publish tinyint(1) NOT NULL,
   list_order tinyint(3) NOT NULL,
   PRIMARY KEY (id_link)
);


DROP TABLE IF EXISTS kien_list_request;
CREATE TABLE kien_list_request (
   id int(11) NOT NULL auto_increment,
   method varchar(100) NOT NULL,
   user_id int(11) NOT NULL,
   createdate date NOT NULL,
   code_confirm char(15) NOT NULL,
   IP varchar(20) NOT NULL,
   publish tinyint(1) NOT NULL,
   PRIMARY KEY (id),
   KEY user_id (user_id),
   KEY id (id)
);

INSERT INTO kien_list_request VALUES('1', 'add_money_banking', '3', '2013-12-16', 'bmcz', '127.0.0.1', '0');
INSERT INTO kien_list_request VALUES('2', 'naptien', '3', '2013-12-16', 'naptien ahny', '', '1');
INSERT INTO kien_list_request VALUES('3', 'buycard', '3', '2013-12-17', '85b85', '127.0.0.1', '0');
INSERT INTO kien_list_request VALUES('4', 'buycard', '3', '0000-00-00', 'f5986', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('5', 'buycard', '3', '0000-00-00', '4974e', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('6', 'buycard', '3', '2013-12-19', '6d665', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('7', 'buycard', '3', '0000-00-00', 'bfc9d', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('8', 'buycard', '3', '2013-12-19', 'f647b', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('9', 'buycard', '3', '2013-12-19', '8f52c', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('10', 'buycard', '3', '2013-12-19', '6fb4b', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('11', 'buycard', '3', '2013-12-19', '25c0b', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('12', 'buycard', '3', '2013-12-19', '1557b', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('13', 'buycard', '3', '2013-12-19', '250ba', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('14', 'buycard', '3', '2013-12-19', 'cb6d9', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('15', 'buycard', '3', '2013-12-19', '99025', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('16', 'buycard', '3', '2013-12-19', 'd6276', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('17', 'buycard', '3', '2013-12-19', '2bebb', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('18', 'buycard', '3', '2013-12-19', '35938', '118.71.206.60', '0');
INSERT INTO kien_list_request VALUES('19', 'buycard', '3', '2013-12-19', '92eff', '123.16.142.75', '0');
INSERT INTO kien_list_request VALUES('20', 'check_add_money_card', '3', '2013-12-20', '0214e', '1.55.139.64', '0');
INSERT INTO kien_list_request VALUES('21', 'add_money_banking', '3', '2013-12-20', 'jylc', '1.55.139.64', '0');
INSERT INTO kien_list_request VALUES('22', 'naptien', '5', '2013-12-20', 'naptien cvyg', '', '1');
INSERT INTO kien_list_request VALUES('23', 'naptien', '5', '2013-12-20', 'naptien yciz', '', '1');
INSERT INTO kien_list_request VALUES('24', 'check_add_money_card', '3', '2013-12-20', '965ef', '1.55.139.64', '0');
INSERT INTO kien_list_request VALUES('25', 'naptien', '3', '2013-12-20', 'naptien kygu', '', '1');
INSERT INTO kien_list_request VALUES('26', 'naptien', '3', '2013-12-20', 'naptien haxa', '', '1');

DROP TABLE IF EXISTS kien_loaivi;
CREATE TABLE kien_loaivi (
   id int(11) NOT NULL auto_increment,
   name varchar(200) NOT NULL,
   publish tinyint(1) NOT NULL,
   PRIMARY KEY (id),
   KEY id (id)
);

INSERT INTO kien_loaivi VALUES('1', 'cá nhân', '1');
INSERT INTO kien_loaivi VALUES('2', 'Danh nghi?p', '1');

DROP TABLE IF EXISTS kien_member;
CREATE TABLE kien_member (
   memberid int(11) NOT NULL auto_increment,
   pass varchar(48) NOT NULL,
   user varchar(128) NOT NULL,
   cmt int(10) NOT NULL,
   fullname varchar(128) NOT NULL,
   sexid tinyint(1) NOT NULL,
   GroupID tinyint(1) NOT NULL,
   id_loaivi int(11) NOT NULL,
   Gold decimal(11,2) NOT NULL,
   phone varchar(128) NOT NULL,
   workphone varchar(128) NOT NULL,
   email varchar(60) NOT NULL,
   adress varchar(200) NOT NULL,
   signdate date NOT NULL,
   logon varchar(50) NOT NULL,
   Published tinyint(1) NOT NULL,
   PRIMARY KEY (memberid),
   KEY GroupID (GroupID),
   KEY id_loaivi (id_loaivi),
   KEY memberid (memberid),
   KEY user (user)
);

INSERT INTO kien_member VALUES('1', 'fcea920f7412b5da7be0cf42b8c93759', '0989466068', '2147483647', 'Lê V?n Kiên', '1', '2', '1', '0.00', '', '', 'iwcofms@gmail.com', 'Thu?n thành', '2013-12-16', '', '1');
INSERT INTO kien_member VALUES('2', 'fcea920f7412b5da7be0cf42b8c93759', '01683926739', '2147483647', 'Lê V?n Kiên', '1', '2', '1', '0.00', '', '', 'iwcofms@gmail.com', 'Thu?n thành', '2013-12-16', '', '1');
INSERT INTO kien_member VALUES('3', '25d55ad283aa400af464c76d713c07ad', '012345678', '125315989', 'V?n H?u Kiên', '1', '2', '1', '2050000.00', '', '', 'damlinh@dlcvietnam.net', 'ahkhaka', '2013-12-16', '', '1');
INSERT INTO kien_member VALUES('4', 'e10adc3949ba59abbe56e057f20f883e', '0906292000', '13357921', 'Hoang Van Huu', '1', '2', '2', '0.00', '', '', 'hpay@hoanggia.net', 'Bui Xuong Trach', '2013-12-19', '', '1');
INSERT INTO kien_member VALUES('5', '124bd1296bec0d9d93c7b52a71ad8d5b', '0904237347', '12702307', 'Nguy?n Anh D?ng', '1', '2', '1', '0.00', '', '', 'damlinh@vnn.vn', 'ngõ 376 ???ng b??i,hà n?i', '2013-12-20', '', '1');

DROP TABLE IF EXISTS kien_membergroup;
CREATE TABLE kien_membergroup (
   Id tinyint(2) NOT NULL auto_increment,
   Title varchar(100) NOT NULL,
   Published tinyint(1) NOT NULL,
   PRIMARY KEY (Id),
   KEY Id (Id)
);

INSERT INTO kien_membergroup VALUES('1', 'admin', '1');
INSERT INTO kien_membergroup VALUES('2', 'member', '1');

DROP TABLE IF EXISTS kien_menu_ngang;
CREATE TABLE kien_menu_ngang (
   id_menu int(11) NOT NULL auto_increment,
   name varchar(300) NOT NULL,
   link varchar(200) NOT NULL,
   list_order int(20) NOT NULL,
   lang_id int(11) NOT NULL,
   PRIMARY KEY (id_menu),
   KEY id_menu (id_menu),
   KEY lang_id (lang_id)
);


DROP TABLE IF EXISTS kien_method_request;
CREATE TABLE kien_method_request (
   id int(11) NOT NULL auto_increment,
   name varchar(100) NOT NULL,
   method_parent int(11) NOT NULL,
   publish tinyint(11) NOT NULL,
   PRIMARY KEY (id)
);


DROP TABLE IF EXISTS kien_newscat;
CREATE TABLE kien_newscat (
   id_newscat int(11) NOT NULL auto_increment,
   name varchar(300) NOT NULL,
   newscat_parent int(11) NOT NULL,
   publish tinyint(1) NOT NULL,
   list_order int(20) NOT NULL,
   lang_id int(11) NOT NULL,
   PRIMARY KEY (id_newscat),
   KEY id_newscat (id_newscat),
   KEY lang_id (lang_id)
);

INSERT INTO kien_newscat VALUES('2', 'Gi?i thi?u Hpay', '0', '1', '1', '1');
INSERT INTO kien_newscat VALUES('5', 'H??ng d?n', '0', '1', '2', '1');
INSERT INTO kien_newscat VALUES('6', 'Tin t?c', '0', '1', '3', '1');
INSERT INTO kien_newscat VALUES('7', 'Dành cho cá nhân', '0', '1', '4', '1');
INSERT INTO kien_newscat VALUES('8', 'Dành cho ngân hàng', '0', '1', '5', '1');
INSERT INTO kien_newscat VALUES('9', 'Dành cho doanh nghi?p', '0', '1', '6', '1');
INSERT INTO kien_newscat VALUES('10', 'Khuy?n m?i', '0', '1', '7', '1');

DROP TABLE IF EXISTS kien_phieunhap;
CREATE TABLE kien_phieunhap (
   id_phieunhap int(11) NOT NULL auto_increment,
   date_nhap date NOT NULL,
   ghichu varchar(200) NOT NULL,
   id_nsx int(11) NOT NULL,
   PRIMARY KEY (id_phieunhap),
   KEY id_nsx (id_nsx)
);


DROP TABLE IF EXISTS kien_price;
CREATE TABLE kien_price (
   id_price int(11) NOT NULL auto_increment,
   from_price float NOT NULL,
   to_price float NOT NULL,
   mota varchar(300) NOT NULL,
   list_order int(20) NOT NULL,
   PRIMARY KEY (id_price)
);


DROP TABLE IF EXISTS kien_product;
CREATE TABLE kien_product (
   id_product int(11) NOT NULL auto_increment,
   ten varchar(200) NOT NULL,
   gia decimal(11,3) NOT NULL,
   anh varchar(100) NOT NULL,
   id_com_cat int(11) NOT NULL,
   publish tinyint(11) NOT NULL,
   create_date date NOT NULL,
   lang_id int(11) NOT NULL,
   code_pro varchar(50) NOT NULL,
   PRIMARY KEY (id_product),
   KEY lang_id (lang_id),
   KEY id_com_cat (id_com_cat)
);

INSERT INTO kien_product VALUES('1', 'Viettel 10,000 VN?', '10000.000', '1386614655.jpg', '1', '1', '2013-12-10', '1', '1');
INSERT INTO kien_product VALUES('2', 'Viettel 20,000 VN?', '20000.000', '1386614697.jpg', '1', '1', '2013-12-10', '1', '2');
INSERT INTO kien_product VALUES('3', 'Viettel 50,000 VN?', '50000.000', '1386614733.jpg', '1', '1', '2013-12-10', '1', '4');
INSERT INTO kien_product VALUES('4', 'Viettel 100,000 VN?', '100000.000', '1386614775.jpg', '1', '1', '2013-12-10', '1', '5');
INSERT INTO kien_product VALUES('5', 'Viettel 200,000 VN?', '200000.000', '1386614825.jpg', '1', '1', '2013-12-10', '1', '6');
INSERT INTO kien_product VALUES('6', 'Viettel 300,000 VN?', '300000.000', '1386614870.jpg', '1', '1', '2013-12-10', '1', '7');
INSERT INTO kien_product VALUES('7', 'Viettel 500,000 VN?', '500000.000', '1386614920.jpg', '1', '1', '2013-12-10', '1', '8');
INSERT INTO kien_product VALUES('8', 'Mobifone 10,000 VN?', '10000.000', '1386615044.jpg', '2', '1', '2013-12-10', '1', '25');
INSERT INTO kien_product VALUES('9', 'Mobifone 20,000 VN?', '20000.000', '1386615088.jpg', '2', '1', '2013-12-10', '1', '26');
INSERT INTO kien_product VALUES('10', 'Mobifone 30,000 VN?', '30000.000', '1386615138.jpg', '2', '1', '2013-12-10', '1', '27');
INSERT INTO kien_product VALUES('11', 'Mobifone 50,000 VN?', '50000.000', '1386615205.jpg', '2', '1', '2013-12-10', '1', '28');
INSERT INTO kien_product VALUES('12', 'Mobifone 100,000 VN?', '100000.000', '1386615242.jpg', '2', '1', '2013-12-10', '1', '29');
INSERT INTO kien_product VALUES('13', 'Mobifone 200,000 VN?', '200000.000', '1386615283.jpg', '2', '1', '2013-12-10', '1', '30');
INSERT INTO kien_product VALUES('14', 'Mobifone 300,000 VN?', '300000.000', '1386615336.jpg', '2', '1', '2013-12-10', '1', '31');
INSERT INTO kien_product VALUES('15', 'Mobifone 500,000 VN?', '500000.000', '1386615360.jpg', '2', '1', '2013-12-10', '1', '32');
INSERT INTO kien_product VALUES('16', 'Viettel 30,000 VN?', '30000.000', '1387418403.jpg', '1', '1', '2013-12-19', '1', '3');
INSERT INTO kien_product VALUES('17', 'Vinaphone 10,000 VN?', '10000.000', '1387418960.jpg', '3', '1', '2013-12-19', '1', '17');
INSERT INTO kien_product VALUES('18', 'Vinaphone 20,000 VN?', '20000.000', '1387418983.jpg', '3', '1', '2013-12-19', '1', '18');
INSERT INTO kien_product VALUES('19', 'Vinaphone 30,000 VN?', '30000.000', '1387419003.jpg', '3', '1', '2013-12-19', '1', '19');
INSERT INTO kien_product VALUES('20', 'Vinaphone 50,000 VN?', '50000.000', '1387419025.jpg', '3', '1', '2013-12-19', '1', '20');
INSERT INTO kien_product VALUES('21', 'Vinaphone 100,000 VN?', '100000.000', '1387419047.jpg', '3', '1', '2013-12-19', '1', '21');
INSERT INTO kien_product VALUES('22', 'Vinaphone 200,000 VN?', '200000.000', '1387419152.jpg', '3', '1', '2013-12-19', '1', '22');
INSERT INTO kien_product VALUES('23', 'Vinaphone 300,000 VN?', '300000.000', '1387419175.jpg', '3', '1', '2013-12-19', '1', '23');
INSERT INTO kien_product VALUES('24', 'Vinaphone 500,000 VN?', '500000.000', '1387419197.jpg', '3', '1', '2013-12-19', '1', '24');
INSERT INTO kien_product VALUES('25', 'Vcoin 20,000 VN?', '20000.000', '1387419888.jpg', '7', '1', '2013-12-19', '1', '41');
INSERT INTO kien_product VALUES('26', 'Vcoin 50,000 VN?', '50000.000', '1387419922.jpg', '7', '1', '2013-12-19', '1', '42');
INSERT INTO kien_product VALUES('27', 'Vcoin 100,000 VN?', '100000.000', '1387419973.jpg', '7', '1', '2013-12-19', '1', '43');
INSERT INTO kien_product VALUES('28', 'Vcoin 200,000 VN?', '200000.000', '1387420019.jpg', '7', '1', '2013-12-19', '1', '44');
INSERT INTO kien_product VALUES('29', 'Vcoin 300,000 VN?', '300000.000', '1387420038.jpg', '7', '1', '2013-12-19', '1', '45');
INSERT INTO kien_product VALUES('30', 'Vcoin 500,000 VN?', '500000.000', '1387420068.jpg', '7', '1', '2013-12-19', '1', '46');
INSERT INTO kien_product VALUES('31', 'Gate 10,000 VN?', '10000.000', '1387420319.jpg', '8', '1', '2013-12-19', '1', '100');
INSERT INTO kien_product VALUES('32', 'Gate 20,000 VN?', '20000.000', '1387420352.jpg', '8', '1', '2013-12-19', '1', '57');
INSERT INTO kien_product VALUES('33', 'Get 30,000 VN?', '30000.000', '1387420398.jpg', '8', '1', '2013-12-19', '1', '58');
INSERT INTO kien_product VALUES('34', 'Gate 50,000 VN?', '50000.000', '1387420426.jpg', '8', '1', '2013-12-19', '1', '59');
INSERT INTO kien_product VALUES('35', 'Gate 100,000 VN?', '100000.000', '1387420462.jpg', '8', '1', '2013-12-19', '1', '101');
INSERT INTO kien_product VALUES('36', 'Gate 200,000 VN?', '200000.000', '1387420490.jpg', '8', '1', '2013-12-19', '1', '102');
INSERT INTO kien_product VALUES('37', 'Gate 500,000 VN?', '500000.000', '1387420513.jpg', '8', '1', '2013-12-19', '1', '103');
INSERT INTO kien_product VALUES('38', 'Zing 20,000 VN?', '20000.000', '1387420675.jpg', '9', '1', '2013-12-19', '1', '69');
INSERT INTO kien_product VALUES('39', 'Zing 60,000 VN?', '60000.000', '1387420789.jpg', '9', '1', '2013-12-19', '1', '70');
INSERT INTO kien_product VALUES('40', 'Zing 120,000 VN?', '120000.000', '1387420809.jpg', '9', '1', '2013-12-19', '1', '73');
INSERT INTO kien_product VALUES('41', 'OncashDN 20,000 VN?', '20000.000', '', '10', '1', '2013-12-19', '1', '90');
INSERT INTO kien_product VALUES('42', 'OncashDN 60,000 VN?', '60000.000', '1387421294.jpg', '10', '1', '2013-12-19', '1', '91');
INSERT INTO kien_product VALUES('43', 'OncashDN 100,000 VN?', '100000.000', '1387421329.jpg', '10', '1', '2013-12-19', '1', '92');
INSERT INTO kien_product VALUES('44', 'OncashDN 200,000 VN?', '200000.000', '1387421356.jpg', '10', '1', '2013-12-19', '1', '93');
INSERT INTO kien_product VALUES('45', 'OncashDN 500,000 VN?', '500000.000', '1387421394.jpg', '10', '1', '2013-12-19', '1', '106');
INSERT INTO kien_product VALUES('46', 'Megacard 10,000 VN?', '10000.000', '1387421639.jpg', '11', '1', '2013-12-19', '1', '94');
INSERT INTO kien_product VALUES('47', 'Megacard 20,000 VN?', '20000.000', '1387421669.jpg', '11', '1', '2013-12-19', '1', '95');
INSERT INTO kien_product VALUES('48', 'Megacard 50,000 VN?', '50000.000', '1387421797.jpg', '11', '1', '2013-12-19', '1', '96');
INSERT INTO kien_product VALUES('49', 'Megacard 100,000 VN?', '100000.000', '1387421824.jpg', '11', '1', '2013-12-19', '1', '97');
INSERT INTO kien_product VALUES('50', 'Megacard 200,000 VN?', '200000.000', '1387421856.jpg', '11', '1', '2013-12-19', '1', '98');
INSERT INTO kien_product VALUES('51', 'Megacard 500,000 VN?', '500000.000', '1387421883.jpg', '11', '1', '2013-12-19', '1', '99');

DROP TABLE IF EXISTS kien_proimg;
CREATE TABLE kien_proimg (
   id_proimg int(11) NOT NULL auto_increment,
   id_pro int(11) NOT NULL,
   images varchar(300) NOT NULL,
   PRIMARY KEY (id_proimg),
   KEY id_proimg (id_proimg),
   KEY id_pro (id_pro)
);


DROP TABLE IF EXISTS kien_quangcao;
CREATE TABLE kien_quangcao (
   id_qc int(11) NOT NULL auto_increment,
   title varchar(300) NOT NULL,
   logo varchar(300) NOT NULL,
   link varchar(300) NOT NULL,
   position enum('left','right') DEFAULT 'left' NOT NULL,
   publish tinyint(1) NOT NULL,
   list_order int(20) NOT NULL,
   PRIMARY KEY (id_qc)
);


DROP TABLE IF EXISTS kien_service;
CREATE TABLE kien_service (
   serviceid smallint(6) unsigned NOT NULL auto_increment,
   servicename varchar(128) NOT NULL,
   content text NOT NULL,
   review text NOT NULL,
   serviceimg varchar(32) NOT NULL,
   servicein tinyint(1) unsigned NOT NULL,
   noibat smallint(1) unsigned NOT NULL,
   thutu smallint(6) unsigned NOT NULL,
   PRIMARY KEY (serviceid)
);


DROP TABLE IF EXISTS kien_sessions;
CREATE TABLE kien_sessions (
   session_id int(10) unsigned NOT NULL auto_increment,
   session_start int(11) unsigned,
   session_ip varchar(15),
   PRIMARY KEY (session_id)
);

INSERT INTO kien_sessions VALUES('554244', '1387608338', '113.189.17.87');

DROP TABLE IF EXISTS kien_settings;
CREATE TABLE kien_settings (
   id int(11) NOT NULL auto_increment,
   keyword varchar(150) NOT NULL,
   description varchar(150) NOT NULL,
   siteurl varchar(100) NOT NULL,
   siteemail varchar(100) NOT NULL,
   contact text NOT NULL,
   intro text NOT NULL,
   footer text NOT NULL,
   sitename varchar(100) NOT NULL,
   PRIMARY KEY (id)
);

INSERT INTO kien_settings VALUES('1', 'hoang gia', 'ghala ', 'hpay.189.vn', 'kienlv@hoanggia.biz', '0989 466 069', 'halgkha', '??a ch? : S? 14, ngõ 1/46, Bùi X??ng Tr?ch, Ph??ng Kh??ng ?ình, Qu?n Thanhh Xuân, Thành Ph? Hà N?i<br />\r\n?i?n tho?i : 0989466069.<br />\r\nEmail : Contact@hoanggia.biz', 'Công ty c? ph?n thanh toán tr?c tuy?n ');

DROP TABLE IF EXISTS kien_slider;
CREATE TABLE kien_slider (
   id_slider int(11) NOT NULL auto_increment,
   logo varchar(300) NOT NULL,
   link varchar(300) NOT NULL,
   list_order int(20) NOT NULL,
   publish tinyint(1) NOT NULL,
   content varchar(300) NOT NULL,
   PRIMARY KEY (id_slider)
);

INSERT INTO kien_slider VALUES('1', 'slider1387531215.jpg', 'http://hpay.189.vn/tin-tuc.html', '2', '1', 'tin t?c');
INSERT INTO kien_slider VALUES('2', 'slider1387531226.jpg', 'http://hoanggia.net', '1', '1', 'hoang gia');

DROP TABLE IF EXISTS kien_sysop;
CREATE TABLE kien_sysop (
   lastupdate int(11) unsigned NOT NULL,
   counter int(11) unsigned NOT NULL
);

INSERT INTO kien_sysop VALUES('0', '2532113');

DROP TABLE IF EXISTS kien_temp_members;
CREATE TABLE kien_temp_members (
   confirm_code varchar(200) NOT NULL,
   pass varchar(48) NOT NULL,
   cmt int(10) NOT NULL,
   fullname varchar(128) NOT NULL,
   id_loaivi int(11) NOT NULL,
   phone varchar(128) NOT NULL,
   email varchar(60) NOT NULL,
   sexid tinyint(1) NOT NULL,
   adress varchar(200) NOT NULL,
   PRIMARY KEY (confirm_code),
   KEY id_loaivi (id_loaivi)
);


DROP TABLE IF EXISTS kien_tintuc;
CREATE TABLE kien_tintuc (
   tinid int(11) unsigned NOT NULL auto_increment,
   newscat_id tinyint(2) unsigned,
   tieude varchar(128) NOT NULL,
   noidung text NOT NULL,
   nguontin varchar(64) NOT NULL,
   ngaydang date NOT NULL,
   anhtin varchar(150) NOT NULL,
   trichdan text NOT NULL,
   views int(20) NOT NULL,
   tags varchar(200) NOT NULL,
   publish tinyint(1) NOT NULL,
   langid int(11) NOT NULL,
   PRIMARY KEY (tinid)
);

INSERT INTO kien_tintuc VALUES('4', '2', 'Gi?i thi?u Hpay', '', '', '2013-12-20', '1387515004.png', '<p>Trung T&acirc;m Thanh To&aacute;n Tr?c Tuy?n - C&ocirc;ng Ty Ho&agrave;ng Gia (HPAY), ch&iacute;nh th?c th&agrave;nh l?p v&agrave;o th&aacute;ng 3 n?m 2009 b?i ??i ng? c&aacute;n b? l&atilde;nh ??o c&oacute; nhi?u kinh nghi?m trong l?nh v?c T&agrave;i ch&iacute;nh &ndash; Ng&acirc;n h&agrave;ng, C&ocirc;ng ngh? th&ocirc;ng tin v&agrave; Vi?n th&ocirc;ng.<br /><br />V?i m?c ti&ecirc;u tr? th&agrave;nh C&ocirc;ng ty h&agrave;ng ??u trong l?nh v?c thanh to&aacute;n ?i?n t? t?i Vi?t Nam, t? khi th&agrave;nh l?p ??n nay, HPAY ?&atilde; li&ecirc;n k?t, h?p t&aacute;c v?i 32 ng&acirc;n h&agrave;ng, 6 c&ocirc;ng ty vi?n th&ocirc;ng v&agrave; h?n 40 doanh nghi?p th??ng m?i ?i?n t? ??a ra nhi?u gi?i ph&aacute;p thanh to&aacute;n ??n gi?n, ti?n l?i nh?: Mobile Banking, N?p ti?n ?i?n tho?i HTopup, Thanh to&aacute;n h&oacute;a ??n HPayBill, V&iacute; ?i?n t? HMart, C?ng thanh to&aacute;n HPayment&hellip;<br /><br />Trong nh&oacute;m c&aacute;c ti?n &iacute;ch thanh to&aacute;n ng&acirc;n h&agrave;ng tr&ecirc;n n?n di ??ng, N?p ti?n ?i?n tho?i HTopup ???c coi l&agrave; m?t d?ch v? th? m?nh c?a HPAY. L&agrave; c&ocirc;ng ty cung c?p gi?i ph&aacute;p Topup tr?c ti?p ??u ti&ecirc;n tr&ecirc;n th? tr??ng, c&ugrave;ng v?i ?u th? l&agrave; ?&atilde; k?t n?i v?i nhi?u ng&acirc;n h&agrave;ng l?n, HPAY c&oacute; th? cung c?p d?ch v? ??n h?n 80% kh&aacute;ch h&agrave;ng c?a c&aacute;c ng&acirc;n h&agrave;ng tr&ecirc;n to&agrave;n qu?c nh? Agribank, VietinBank, BIDV, DongA Bank, Techcombank, Eximbank&hellip; v&agrave; nhi?u ng&acirc;n h&agrave;ng kh&aacute;c.<br /><br />Th&ocirc;ng ?i?p v&agrave; cam k?t<br /><br />\"Cho cu?c s?ng ??n gi?n h?n\" l&agrave; th&ocirc;ng ?i?p v&agrave; cam k?t m&agrave; ch&uacute;ng t&ocirc;i mu?n g?i t?i kh&aacute;ch h&agrave;ng v&agrave; ??i t&aacute;c. HPAY c&ugrave;ng c&aacute;c ??i t&aacute;c h?p t&aacute;c ph&aacute;t tri?n m?t ph??ng th?c thanh to&aacute;n ??n gi?n l&agrave;m gi?m c&aacute;c chi ph&iacute; x&atilde; h?i, thay ??i th&oacute;i quen s? d?ng ti?n m?t c?a ??i b? ph?n d&acirc;n ch&uacute;ng, ?&acirc;y ??ng th?i l&agrave; n?n t?ng gi&uacute;p th&uacute;c ??y v&agrave; ??m b?o s? th&agrave;nh c&ocirc;ng c?a Th??ng m?i ?i?n t? trong th?i gian t?i ?&acirc;y.<br /><br />&ldquo;Cho cu?c s?ng ??n gi?n h?n&rdquo; c&ograve;n l&agrave; m?c ti&ecirc;u ho?t ??ng v&agrave; l&agrave; ??nh h??ng kinh doanh c?a HPAY nh?m t?o ra nh?ng gi&aacute; tr? thi?t th?c h? tr? c&aacute;c ho?t ??ng ti&ecirc;u d&ugrave;ng c?a x&atilde; h?i, t? ?&oacute; kh?ng ??nh m?c ti&ecirc;u mang l?i c&aacute;c d?ch v? ti?n &iacute;ch cho kh&aacute;ch h&agrave;ng.<br /><br />&ldquo;Cho cu?c s?ng ??n gi?n h?n&rdquo; c&ograve;n l&agrave; m?c ?&iacute;ch l&agrave;m vi?c c?a Ban l&atilde;nh ??o, ??i ng? qu?n l&yacute; v&agrave; nh&acirc;n vi&ecirc;n c?a HPAY nh?m x&acirc;y d?ng m?t m&ocirc;i tr??ng v?n h&oacute;a doanh nghi?p chuy&ecirc;n nghi?p, g?n b&oacute; v&agrave; c&ugrave;ng nhau h??ng t?i m?c ti&ecirc;u chung l&agrave; x&acirc;y d?ng HPAY tr? th&agrave;nh c&ocirc;ng ty h&agrave;ng ??u trong l?nh v?c cung ?ng d?ch v? Thanh to&aacute;n ?i?n t?.<br /><br />C&aacute;c d?ch v? ch&iacute;nh HPAY cung c?p v&agrave; ph&aacute;t tri?n g?m c&oacute;:<br /><br />Mobile Banking: cho ph&eacute;p kh&aacute;ch h&agrave;ng truy v?n th&ocirc;ng tin t&agrave;i ch&iacute;nh - ng&acirc;n h&agrave;ng qua ?i?n tho?i di ??ng b?ng c&aacute;ch g?i tin nh?n theo m?u quy ??nh t?i t?ng ?&agrave;i 6065. D?ch v? Mobile Banking bao g?m c&aacute;c ti?n &iacute;ch: V?n tin s? d? t&agrave;i kho?n, Sao k&ecirc; 5 giao d?ch g?n nh?t, Nh?n th&ocirc;ng b&aacute;o bi?n ??ng s? d? t&agrave;i kho?n, Tra c?u t? gi&aacute; ngo?i t?, l&atilde;i su?t ng&acirc;n h&agrave;ng, th&ocirc;ng tin tr? gi&uacute;p, Chuy?n kho?n b?ng tin nh?n, Thanh to&aacute;n h&oacute;a ??n tr? sau qua tin nh?n; N?p ti?n ?i?n tho?i qua tin nh?n &ndash; HTopup &amp; c&aacute;c d?ch v? kh&aacute;c c?a ng&acirc;n h&agrave;ng (n?u c&oacute;).<br /><br />N?p ti?n ?i?n tho?i HTopup: l&agrave; d?ch v? n?p ti?n v&agrave;o t&agrave;i kho?n ?i?n tho?i di ??ng tr? tr??c v&agrave; tr? sau qua tin nh?n SMS, Mobile Banking, Internet Banking ho?c t?i m&aacute;y ATM c?a ng&acirc;n h&agrave;ng, s? ti?n kh&aacute;ch h&agrave;ng y&ecirc;u c?u n?p v&agrave;o ?i?n tho?i s? ???c tr? tr?c ti?p trong t&agrave;i kho?n ng&acirc;n h&agrave;ng c?a kh&aacute;ch h&agrave;ng.<br /><br />Thanh to&aacute;n h&oacute;a ??n HPayBill: d?ch v? HPayBIll gi&uacute;p kh&aacute;ch h&agrave;ng c?a ng&acirc;n h&agrave;ng c&oacute; th? thanh to&aacute;n c&aacute;c h&oacute;a ??n d?ch v? (?i&ecirc;?n tho?i tr? sau, ?i&ecirc;?n tho?i c&ocirc;? ??nh, Internet ADSL, ?i?n, n??c&hellip;) b?ng c&aacute;ch nh?n tin t? ?i?n tho?i di ??ng, qua Internet Banking, ATM c?a ng&acirc;n h&agrave;ng ho?c b?ng h&igrave;nh th?c ?y nhi?m thu t? ??ng. S&ocirc;? ti&ecirc;?n b? tr? trong t&agrave;i kho?n ng&acirc;n h&agrave;ng ?&uacute;ng b?ng s&ocirc;? ti&ecirc;?n c??c kh&aacute;ch h&agrave;ng s? d?ng h&oacute;a ??n.<br /><br />V&iacute; ?i?n t? AZMart: AZMart l&agrave; s?n ph?m v&iacute; ?i?n t? do HPAY ph&aacute;t tri?n ?? l&agrave;m ph??ng ti?n thanh to&aacute;n khi th?c hi?n c&aacute;c giao d?ch mua s?m tr&ecirc;n c&aacute;c website th??ng m?i ?i?n t?. V?i thu?n l?i l&agrave; kh? n?ng k?t n?i ??n c&aacute;c ??i t&aacute;c ng&acirc;n h&agrave;ng c?a HPAY, c&aacute;c ch? v&iacute; AZMart c&oacute; th? n?p ti?n t? t&agrave;i kho?n ng&acirc;n h&agrave;ng v&agrave;o v&iacute; ?? th?c hi?n thanh to&aacute;n khi mua s?m tr&ecirc;n website http://azmart.net c?a HPAY ho?c c&aacute;c website th??ng m?i ?i?n t? c&oacute; li&ecirc;n k?t v?i HPAY.<br /><br />Sim ?a n?ng: l&agrave; d?ch v? do HPAY k?t h?p c&ugrave;ng t?t c? c&aacute;c m?ng di ??ng t?i Vi?t Nam cung c?p, cho ph&eacute;p ch? thu&ecirc; bao di ??ng c&oacute; th? tr? th&agrave;nh m?t ?i?m b&aacute;n h&agrave;ng v?i c&aacute;c d?ch v? nh?: n?p ti?n ?i?n tho?i tr? tr??c, b&aacute;n m&atilde; th? c&agrave;o, thanh to&aacute;n h&oacute;a ??n tr? sau, b&aacute;n b?o hi?m v&agrave; c&aacute;c d?ch v? kh&aacute;c. Hoa h?ng b&aacute;n h&agrave;ng linh ho?t v&agrave; chi?t kh?u tr??c cho ??i l&yacute;.<br /><br />B&aacute;n v&eacute; m&aacute;y bay qua t?ng ?&agrave;i 090 550 1189: cho ph&eacute;p kh&aacute;ch h&agrave;ng ??t v&eacute; m&aacute;y bay c?a 30 h&atilde;ng h&agrave;ng kh&ocirc;ng trong n??c v&agrave; qu?c t&ecirc; qua ?i?n tho?i. Kh&aacute;ch h&agrave;ng s? g?i ?i?n ??n t?ng ?&agrave;i 090 550 1189 ?? ???c t? v?n, h? tr? c&aacute;c th&ocirc;ng tin v? l?ch tr&igrave;nh bay, gi&aacute; v&eacute;,&hellip; Sau khi kh&aacute;ch h&agrave;ng cung c?p ??y ?? c&aacute;c th&ocirc;ng tin c?n thi?t ?? ??t v&eacute;, t?ng ?&agrave;i vi&ecirc;n s? g?i m?t m&atilde; code book v? ?i?n tho?i di ??ng c?a kh&aacute;ch h&agrave;ng. Kh&aacute;ch h&agrave;ng s? thanh to&aacute;n m&atilde; code t?i c&aacute;c k&ecirc;nh c?a ng&acirc;n h&agrave;ng nh? Qu?y giao d?ch, Internet Banking ho?c ATM c?a ng&acirc;n h&agrave;ng ch?p nh?n thanh to&aacute;n.<br /><br />C?ng thanh to&aacute;n HPayment: HPAY ph&aacute;t tri?n v&agrave; qu?n l&yacute; c?ng thanh to&aacute;n http://hpay.189.vn cho ph&eacute;p kh&aacute;ch h&agrave;ng c&oacute; th? s? d?ng t&agrave;i kho?n ng&acirc;n h&agrave;ng ?? thanh to&aacute;n khi mua s?m h&agrave;ng h&oacute;a v&agrave; d?ch v? tr&ecirc;n c&aacute;c website th??ng m?i ?i?n t? c&oacute; k?t n?i ??n HPAY.</p>', '0', '', '1', '1');
INSERT INTO kien_tintuc VALUES('5', '2', 'T?i sao ch?n Hpay', '', '', '2013-12-20', '1387515736.png', '<p>?ang c?p nh?t n?i dung</p>', '0', '', '1', '1');
INSERT INTO kien_tintuc VALUES('6', '2', 'C? c?u t? ch?c', '', '', '2013-12-20', '1387515916.jpg', '<p>?ang c?p nh?t n?i dung</p>', '0', '', '1', '1');
INSERT INTO kien_tintuc VALUES('7', '2', 'N?ng l?c nhân s?', '', '', '2013-12-20', '1387515942.jpg', '<p>?ang c?p nh?t n?i dung</p>', '0', '', '1', '1');
INSERT INTO kien_tintuc VALUES('8', '2', 'L?nh v?c ho?t ??ng', '', '', '2013-12-20', '1387515969.jpg', '<p>?ang c?p nh?t n?i dung</p>', '0', '', '1', '1');
INSERT INTO kien_tintuc VALUES('9', '7', 'SMS Banking', '', '', '2013-12-20', 'sms-banking-1387554039.JPG', '<div><span><span><strong><span>1.<span>&nbsp;&nbsp;</span><span>&nbsp;&nbsp;<strong>&nbsp;SMS</strong></span></span><span>&nbsp;Banking</span></strong></span></span></div>\r\n<div>&nbsp;</div>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SMS Banking l&agrave; g&oacute;i d?ch v? ti?n &iacute;ch c?a Ng&acirc;n h&agrave;ng cung c?p cho kh&aacute;ch h&agrave;ng c&oacute; t&agrave;i kho?n th?c hi?n c&aacute;c giao d?ch v?i Ng&acirc;n h&agrave;ng qua tin nh?n SMS t? ?i?n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;tho?i di ??ng nh?:&nbsp;</span></span><span><span>xem th&ocirc;ng tin t&agrave;i kho?n t?i ng&acirc;n h&agrave;ng: li?t k&ecirc; t&agrave;i kho?n, t&igrave;nh tr?ng t&agrave;i kho?n, s? d?, l?ch s? giao d?ch.</span></span><span><span>&nbsp;Hi?n nay VNPAY ?ang h?p t&aacute;c &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;v&agrave; cung c?p d?ch v? v&agrave; t?ng ?&agrave;i nh?n tin 8149 cho r?t nhi?u ng&acirc;n h&agrave;ng t?i Vi?t Nam. Ngo&agrave;i ra, kh&aacute;ch h&agrave;ng c?ng c&oacute; th? th?c hi?n c&aacute;c giao d?ch t&agrave;i ch&iacute;nh &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;kh&aacute;c qua SMS nh?</span></span>:&nbsp;<span><span>th?c hi?n ???c c&aacute;c giao d?ch chuy?n ti?n sang c&aacute;c t&agrave;i kho?n kh&aacute;c trong ng&acirc;n h&agrave;ng ho?c chuy?n ti?n ra ngo&agrave;i h? th?ng ng&acirc;n h&agrave;ng, &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;th?c hi?n thanh to&aacute;n h&oacute;a ??n, thanh to&aacute;n d?ch v? h&agrave;ng h&oacute;a ho?c xem th&ocirc;ng tin h? tr? t&iacute;n d?ng tr?c ti?p tr&ecirc;n thi?t b? s? c&aacute; nh&acirc;n m&agrave; kh&ocirc;ng ph?i ??n t?n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;qu?y giao d?ch c?a ng&acirc;n h&agrave;ng v&agrave; kh&aacute;ch h&agrave;ng c&ograve;n c&oacute; th? s? d?ng r?t nhi?u d?ch v? gi&aacute; tr? gia t?ng kh&aacute;c nh? n?p ti?n ?i?n tho?i, mua b?o hi?m, v&eacute; m&aacute;y &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;bay, t&agrave;u xe&hellip; tr?c tuy?n.</span></span></p>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;V?i d?ch v? SMS Banking, kh&aacute;ch h&agrave;ng c&oacute; th? ki?m so&aacute;t t&agrave;i kho?n ng&acirc;n h&agrave;ng c?a m&igrave;nh, ti?t ki?m ???c th?i gian v&agrave; c?p nh?t th&ocirc;ng tin t?i kho?n, t&agrave;i ch&iacute;nh &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Ng&acirc;n h&agrave;ng m?t c&aacute;ch nhanh nh?t qua tin nh?n.</span></span></p>\r\n<p><span><span><strong><em>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;C&aacute;c ti?n &iacute;ch c?a d?ch v?:</em></strong></span></span></p>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>V?n tin s? d? t&agrave;i kho?n</span></span></p>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Sao k&ecirc; 05 giao d?ch g?n nh?t</span></span></p>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;3.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>T? ??ng nh?n th&ocirc;ng b&aacute;o bi?n ??ng s? d? t&agrave;i kho?n</span></span></p>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;4.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Chuy?n kho?n b?ng tin nh?n</span></span></p>\r\n<div>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;5.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>C&aacute;c d?ch v? thanh to&aacute;n: N?p ti?n ?i?n tho?i di ??ng - VnTopup, Thanh to&aacute;n h&oacute;a ??n.</span></span></p>\r\n</div>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;6.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Tra c?u t? gi&aacute; ngo?i t?, l&atilde;i su?t ng&acirc;n h&agrave;ng, th&ocirc;ng tin tr? gi&uacute;p</span></span></p>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;7.&nbsp;&nbsp;&nbsp;&nbsp; Mua b?o hi?m tr?c tuy?n</span></span></p>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;8.&nbsp;&nbsp;&nbsp;&nbsp; Mua v&eacute; m&aacute;y bay tr?c tuy?n</span></span></p>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ..........</span></span></p>\r\n<p><span><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://vnpay.vn/Uploads/images/VNPAY/SMS%20Banking%20ca%20nhan.JPG\" alt=\"\" width=\"382\" height=\"254\" /></span></p>\r\n<div><span><span><strong>&nbsp; &nbsp;</strong></span></span></div>\r\n<div><span><span><strong>&nbsp;2.<span>&nbsp; &nbsp;&nbsp;<strong>&nbsp;?ng d?ng&nbsp;</strong></span><span>Mobile Banking</span></strong></span></span></div>\r\n<div>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Mobile Banking l&agrave; ph?n m?m ?ng d?ng do VNPAY nghi&ecirc;n c?u v&agrave; ph&aacute;t tri?n. ?ng d?ng Mobile Banking hi?n th? ???c t?t c? c&aacute;c giao d?ch c?a Ng&acirc;n h&agrave;ng v&agrave; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;c&oacute; th? ch?y tr&ecirc;n ???c t?t c? c&aacute;c lo?i ?i?n tho?i th&ocirc;ng minh v&agrave; m&aacute;y t&iacute;nh b?ng ?ang c&oacute; tr&ecirc;n th? tr??ng.</span></span></p>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;?ng d?ng&nbsp;Mobile Banking c?a VNPAY k?t h?p s? d?ng t&iacute;nh n?ng nh?n tin SMS c? b?n v&agrave; c&aacute;c c&ocirc;ng ngh? ti&ecirc;n ti?n tr&ecirc;n c&aacute;c n?n ?i?n tho?i th&ocirc;ng minh nh? &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;??nh v? GPS, ch?p ?nh v&agrave; c&oacute; th? s? d?ng c&aacute;c k?t n?i GPRS, 3G, Wifi, ?? mang t?i cho ng??i d&ugrave;ng nh?ng tr?i nghi?m v&agrave; ti?n &iacute;ch thanh to&aacute;n m?i, r?t ti?n &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;d?ng cho cu?c s?ng h&agrave;ng ng&agrave;y.&nbsp;</span></span><span><span>Kh&aacute;ch h&agrave;ng sau khi ??ng k&yacute; s? d?ng d?ch v? s? ???c cung c?p th&ocirc;ng tin ??ng k&yacute; bao g?m m&atilde; ??ng k&yacute; t?i qu?y v&agrave; m?t &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;m&atilde; k&iacute;ch ho?t g?i b?ng tin nh?n SMS v? s? ?i?n tho?i ??ng k&yacute; v?i d?ch v?. Username v&agrave; m?t kh?u truy c?p c&oacute; th? ??ng k&yacute; m?i t?i Ng&acirc;n h&agrave;ng ho?c t&iacute;nh &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;h?p s?n v?i h? th?ng Internet Banking ?&atilde; c&oacute;. Vi?c qu?n l&yacute; m?t kh?u ???c h? th?ng ??m b?o theo c&aacute;c quy tr&igrave;nh an to&agrave;n b?o m?t theo chu?n PCI DSS.</span></span></p>\r\n<p><span><span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;?ng d?ng Mobile Banking h? tr? kh&aacute;ch h&agrave;ng trong vi?c nh? c&aacute;c c&uacute; ph&aacute;p nh?n tin, ??ng th?i l&agrave;m ??n gi?n h&oacute;a c&aacute;c giao d?ch mang t&iacute;nh ph?c t?p nh? &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;chuy?n kho?n, thanh to&aacute;n h&oacute;a ??n tr? sau, v.v. nh? giao di?n r&otilde; r&agrave;ng, th&acirc;n thi?n.</span></span></p>\r\n<p>&nbsp;</p>\r\n</div>', '11', '', '1', '1');
INSERT INTO kien_tintuc VALUES('10', '7', 'N?p ti?n ?i?n tho?i VnTopup', '', '', '2013-12-20', 'nap-tien-dien-thoai-vntopup-1387554199.jpg', '<div>\r\n<p><span><span>VnTopup l&agrave; d?ch v? n?p ti?n ?i?n tho?i di ??ng tr? tr??c v&agrave; tr? sau t? t&agrave;i kho?n c?a kh&aacute;ch h&agrave;ng t?i Ng&acirc;n h&agrave;ng. Kh&aacute;ch h&agrave;ng c?a c&aacute;c Ng&acirc;n h&agrave;ng h?p t&aacute;c d?ch v? VnTopup v?i VNPAY c&oacute; th? s? d?ng tin nh?n SMS, Mobile Banking, ATM, Internet Banking ho?c truy c?p website&nbsp;<span><span><a href=\"http://www.vban.vn/Dich-vu/tabid/61/view/topup/Default.aspx\" target=\"_blank\">http://h</a>pay.189.vn</span></span>&nbsp;?? th?c hi?n giao d?ch n?p ti?n VnTopup. S? ti?n kh&aacute;ch h&agrave;ng y&ecirc;u c?u n?p v&agrave;o ?i?n tho?i s? ???c tr? tr?c ti?p v&agrave;o t&agrave;i kho?n c?a kh&aacute;ch h&agrave;ng t?i ng&acirc;n h&agrave;ng v&agrave; ???c n?p tr?c ti?p v&agrave;o t&agrave;i kho?n ?i?n tho?i c?a kh&aacute;ch h&agrave;ng. Kh&aacute;ch h&agrave;ng v?n ???c h??ng ??y ?? ch??ng tr&igrave;nh khuy?n m?i c?a m?ng vi?n th&ocirc;ng (n?u c&oacute;).</span></span></p>\r\n<p><span><span>Ngo&agrave;i vi?c c&oacute; th? t? n?p ti?n cho s? thu&ecirc; bao di ??ng c?a m&igrave;nh, kh&aacute;ch h&agrave;ng c&ograve;n c&oacute; th? s? d?ng d?ch v? VnTopup ?? n?p ti?n cho thu&ecirc; bao ?i?n tho?i c?a b?n b&egrave;, ng??i th&acirc;n, mua m&atilde; th? tr? tr??c ho?c n?p ti?n v&agrave;o v&iacute; ?i?n t? ?? th?c hi?n c&aacute;c giao d?ch tr&ecirc;n m?ng.</span></span></p>\r\n<p><span><span><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://vnpay.vn/Uploads/images/1.jpg\" alt=\"\" /></span></span></p>\r\n<div><span><span><span><strong>Ph?m vi &aacute;p d?ng c?a VnTopup bao g?m:</strong></span></span></span></div>\r\n<div><span><span>-&nbsp;<span>N?p ti?n cho ?i?n tho?i di ??ng tr? tr??c c?a t?t c? c&aacute;c m?ng vi?n th&ocirc;ng t?i Vi?t Nam</span></span></span></div>\r\n<div><span><span>-&nbsp;<span>N?p ti?n cho ?i?n tho?i di ??ng tr? sau c?a hai m?ng&nbsp;</span></span></span><span><span><span>MobiFone v&agrave;&nbsp;</span></span></span><span><span><span>Viettel.</span></span></span></div>\r\n<div>\r\n<div><span><span>-&nbsp;<span>Mua th? c&agrave;o ?i?n tho?i c?a c&aacute;c m?ng vi?n th&ocirc;ng MobiFone,&nbsp;VinaPhone, Viettel.</span></span></span></div>\r\n</div>\r\n<div>\r\n<div><span><span>-&nbsp;<span>Mua th? game c?a c&aacute;c nh&agrave; cung c?p d?ch v?: Vinagame, FPT, VTC, DEC, VDC...</span></span></span></div>\r\n<div>\r\n<div><span><span>-&nbsp;<span>N?p ti?n v&agrave;o v&iacute; ?i?n t? VnMart ?? mua h&agrave;ng v&agrave; thanh to&aacute;n d?ch v? tr?c tuy?n tr&ecirc;n m?ng Internet.</span></span></span></div>\r\n<div>&nbsp;</div>\r\n</div>\r\n<div><span><span><span><strong>?u ?i?m c?a d?ch v? VnTopup:</strong></span></span></span></div>\r\n</div>\r\n<span><span><span>-<span>&nbsp;&nbsp;&nbsp;</span></span><span>N?p ti?n ?i?n tho?i cho m&igrave;nh v&agrave; cho ng??i kh&aacute;c</span></span></span></div>\r\n<div><span><span>-<span>&nbsp;&nbsp;</span><span>N?p ti?n tr?c ti?p v&agrave;o t&agrave;i kho?n ?i?n tho?i m&agrave; kh&ocirc;ng c?n ti?n m?t hay th? c&agrave;o</span></span></span></div>\r\n<div><span><span>-<span>&nbsp;&nbsp;</span><span>M?i l&uacute;c m?i n?i, kh&ocirc;ng gi?i h?n th?i gian</span></span></span></div>\r\n<div><span><span>-<span>&nbsp;&nbsp;</span><span>??n gi?n ch? b?ng 1 tin nh?n</span></span></span></div>\r\n<div><span><span>-<span>&nbsp;&nbsp;</span><span>Kh&aacute;ch h&agrave;ng v?n ???c h??ng c&aacute;c ch??ng tr&igrave;nh khuy?n m?i c?a c&aacute;c m?ng vi?n th&ocirc;ng</span></span></span></div>\r\n<div><span><span>-<span>&nbsp;&nbsp;</span><span>Ph??ng th?c thanh to&aacute;n hi?n ??i kh&ocirc;ng d&ugrave;ng ti?n m?t</span>.</span></span></div>', '6', '', '1', '1');
INSERT INTO kien_tintuc VALUES('11', '7', 'Thanh toán hóa ??n VnPayBill', '', '', '2013-12-20', 'thanh-toan-hoa-don-vnpaybill-1387554700.jpg', '<p><span><span>D?ch v? VnPayBill - Thanh to&aacute;n ho?a ??n gi&uacute;p kh&aacute;ch h&agrave;ng c?a Ng&acirc;n h&agrave;ng c&oacute; th? thanh to&aacute;n c&aacute;c h&oacute;a ??n d?ch v? (?i&ecirc;?n tho?i di ??ng tr? sau, ?i&ecirc;?n tho?i c&ocirc;? ??nh, Internet ADSL, ?i?n, n??c, &hellip;) b?ng c&aacute;ch nh?n tin t? ?i?n tho?i di ??ng, qua Internet Banking, m&aacute;y ATM, ??ng k&yacute; d?ch v? ?y nhi?m thu t? ??ng t?i ng&acirc;n h&agrave;ng ho?c thanh to&aacute;n tr?c tuy?n t?i</span><span>&nbsp;</span><span>website&nbsp;</span><span><a href=\"http://www.vban.vn/Dich-vu/tabid/61/view/listtypebill/Default.aspx\"><span>http://vban.vn</span></a></span>.&nbsp;S&ocirc;? ti&ecirc;?n b? tr? trong t&agrave;i kho?n ng&acirc;n h&agrave;ng ?&uacute;ng b?ng s&ocirc;? ti&ecirc;?n c??c kh&aacute;ch h&agrave;ng s? d?ng ho?a ??n.</span></p>\r\n<div><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://vnpay.vn/Uploads/images/VNPAY/vnpaybill.jpg\" alt=\"\" width=\"536\" height=\"220\" /></div>\r\n<div>&nbsp;</div>\r\n<div><span><span>V?i d?ch v? n&agrave;y, kh&aacute;ch h&agrave;ng c&oacute; th? thanh to&aacute;n h&oacute;a ??n s? d?ng d?ch v? c?a m&igrave;nh v&agrave; ng??i th&acirc;n m?t c&aacute;ch ho&agrave;n to&agrave;n ch? ??ng m&agrave; kh&ocirc;ng c?n ??n c&aacute;c ?i?m thu ph&iacute;, ch?m d?t n?i lo b? ng?ng d?ch v? khi kh&ocirc;ng thu x?p ???c th?i gian n?p c??c t?i nh&agrave; cho nh&acirc;n vi&ecirc;n thu c??c. C&aacute;c h&oacute;a ??n c?a kh&aacute;ch h&agrave;ng s? ???c thanh to&aacute;n ??y ?? v&agrave;o b?t k? th?i ?i?m n&agrave;o m&agrave; kh&aacute;ch h&agrave;ng mong mu?n ho?c ??nh k? h&agrave;ng th&aacute;ng, s? ti?n thanh to&aacute;n s? ???c ng&acirc;n h&agrave;ng t? ??ng tr&iacute;ch t? t&agrave;i kho?n c?a kh&aacute;ch h&agrave;ng.</span></span></div>\r\n<div>&nbsp;</div>\r\n<div><span><strong><em><span>C&aacute;c nh&agrave; cung c?p tri?n khai d?ch v? thanh to&aacute;n h&oacute;a ??n:</span></em></strong></span></div>\r\n<ul>\r\n<li><span><span>MobiFone: C??c ?i?n tho?i di ??ng tr? sau.</span></span></li>\r\n</ul>\r\n<ul>\r\n<li><span><span>Viettel:&nbsp;</span><span>C??c</span><span>&nbsp;?i?n tho?i di ??ng tr? sau, ?i?n tho?i c? ??nh c&oacute; d&acirc;y (PSTN), ?i?n tho?i c? ??nh kh&ocirc;ng d&acirc;y (HomePhone), Internet ADSL</span></span></li>\r\n</ul>\r\n<ul>\r\n<li><span><span>VinaPhone:&nbsp;</span><span>C??c</span><span>&nbsp;?i?n tho?i di ??ng tr? sau</span></span>.</li>\r\n</ul>\r\n<ul>\r\n<li><span>VNPT H?i Ph&ograve;ng:&nbsp;<span>&nbsp;</span><span>?i?n tho?i c? ??nh c&oacute; d&acirc;y, ?i?n tho?i c? ??nh kh&ocirc;ng d&acirc;y, Internet ADSL, MyTV...</span></span></li>\r\n</ul>\r\n<ul>\r\n<li><span><span>VNPT H? Ch&iacute; Minh</span>: ?i?n tho?i c? ??nh, G-Phone,&nbsp;<span>Internet ADSL</span></span></li>\r\n</ul>\r\n<ul>\r\n<li><span>Trung t&acirc;m vi?n th&ocirc;ng B&igrave;nh Thu?n</span></li>\r\n</ul>\r\n<ul>\r\n<li><span>C&ocirc;ng ty C? ph?n C?p n??c Gia ??nh</span></li>\r\n</ul>\r\n<ul>\r\n<li><span>T?p ?o&agrave;n ?i?n l?c Vi?t Nam (EVN): h&oacute;a ??n ti?n ?i?n, xem chi ti?t c&aacute;c chi nh&aacute;nh ?i?n l?c tri?n khai d?ch v?&nbsp;</span><a href=\"http://vnpay.vn/Uploads/files/Documents/DS%20CN%20DIEN%20LUC.pdf\" target=\"_blank\">t?i ?&acirc;y</a></li>\r\n</ul>\r\n<ul>\r\n<li><span>Thu h?c ph&iacute;: ??i h?c M? TP H? Ch&iacute; Minh, ??i h?c C&ocirc;ng nghi?p TP H? Ch&iacute; Minh, ??i h?c C?n Th?, ??i h?c Kinh t? - Lu?t TP H? Ch&iacute; Minh, ??i h?c T&acirc;y Nguy&ecirc;n - ?aklak, ??i h?c Ng&acirc;n h&agrave;ng TP H? Ch&iacute; Minh, ??i h?c T&acirc;y ?&ocirc; - C?n Th?</span></li>\r\n</ul>', '4', '', '1', '1');
INSERT INTO kien_tintuc VALUES('12', '8', 'T?ng ?ài SMS Banking', '', '', '2013-12-20', 'tong-dai-sms-banking-1387555386.JPG', '<p><span>SMS Banking l&agrave; g&oacute;i ti?n &iacute;ch cho ph&eacute;p kh&aacute;ch h&agrave;ng truy v?n th&ocirc;ng tin t&agrave;i ch&iacute;nh ng&acirc;n h&agrave;ng qua ?i?n tho?i di ??ng b?ng c&aacute;ch g?i tin nh?n theo m?u quy ??nh t?i t?ng ?&agrave;i 8149.</span></p>\r\n<p><span><strong><em>C&aacute;c ti?n &iacute;ch c?a d?ch v?:</em></strong></span></p>\r\n<p><span>1.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>V?n tin s? d? t&agrave;i kho?n</span></p>\r\n<p><span>2.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Sao k&ecirc; 05 giao d?ch g?n nh?t</span></p>\r\n<p><span>3.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>T? ??ng nh?n th&ocirc;ng b&aacute;o bi?n ??ng s? d? t&agrave;i kho?n</span></p>\r\n<p><span>4.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Chuy?n kho?n b?ng tin nh?n</span></p>\r\n<div>\r\n<p><span>5.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>C&aacute;c d?ch v? thanh to&aacute;n: N?p ti?n ?i?n tho?i di ??ng - VnTopup, Thanh to&aacute;n h&oacute;a ??n.</span></p>\r\n</div>\r\n<p><span>6.<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Tra c?u t? gi&aacute; ngo?i t?, l&atilde;i su?t ng&acirc;n h&agrave;ng, th&ocirc;ng tin tr? gi&uacute;p</span></p>\r\n<p><span>..........</span></p>\r\n<p><span><span>T?ng ?&agrave;i 8149 c?a VNPAY ???c ?&aacute;nh gi&aacute; l&agrave; m?t trong nh?ng t?ng ?&agrave;i ch?t l??ng nh?t t?i Vi?t Nam v?i kh&aacute;ch h&agrave;ng ?ang s? d?ng l&agrave; c&aacute;c Ng&acirc;n h&agrave;ng l?n v&agrave; uy t&iacute;n t?i Vi?t Nam nh?: Agribank, VietinBank, BIDV, Sacombank, Eximbank, DongA Bank, VPBank, OceanBank, LienVietPostBank, BaoVietBank, VietABank, NamABank, IndovinaBank ...</span></span></p>\r\n<p><span><span><strong>C&aacute;c ?u ?i?m n?i b?t c?a t?ng ?&agrave;i 8149 cho d?ch v? Ng&acirc;n h&agrave;ng:</strong></span></span></p>\r\n<ul>\r\n<li><span><span><span>L&agrave; t?ng ?&agrave;i d&ugrave;ng ri&ecirc;ng cho c&aacute;c d?ch v? Ng&acirc;n h&agrave;ng t? n?m 2007.</span></span></span></li>\r\n<li><span><span><span>Ch?t l??ng cao, t?c ?? nhanh v&agrave; ?n ??nh. T?c ?? trung b&igrave;nh ??t 100 -&gt; 150 SMS/gi&acirc;y.</span></span></span></li>\r\n<li><span><span><span>VNPAY ?&atilde; tri?n khai c&aacute;c ???ng truy?n t?c ?? cao t?i c&aacute;c nh&agrave; m?ng v&agrave; c&oacute; c&aacute;c ???ng d? ph&ograve;ng ?? ??m b?o d?ch v? th&ocirc;ng su?t.</span></span></span></li>\r\n<li><span><span><span>K?t n?i ???c t?t c? 5 nh&agrave; m?ng vi?n th&ocirc;ng t?i Vi?t Nam: Gtel Mobile, MobiFone, Vietnamobile, Viettel, VinaPhone.</span>&nbsp;Do VNPAY k?t n?i tr?c ti?p t?i c&aacute;c t?ng ?&agrave;i SMSC c?a c&aacute;c h&atilde;ng vi?n th&ocirc;ng n&ecirc;n ch?t l??ng tin nh?n r?t t?t ??m b?o c&aacute;c y&ecirc;u c?u kh?t khe ??i v?i c&aacute;c giao d?ch t&agrave;i ch&iacute;nh c?a ng&acirc;n h&agrave;ng. Ng&acirc;n h&agrave;ng ch? c?n k?t n?i t?i VNPAY l&agrave; c&oacute; th? k?t n?i t?i t?t c? c&aacute;c m?ng vi?n th&ocirc;ng ?ang cung c?p d?ch v? t?i Vi?t Nam.</span></span></li>\r\n<li><span><span><span>C&oacute; h? tr? g?i tin SMS k&egrave;m theo t&ecirc;n th??ng hi?u c?a Ng&acirc;n h&agrave;ng v&agrave; kh&ocirc;ng thu ph&iacute; ??t t&ecirc;n th??ng hi?u ?&oacute;.</span></span></span></li>\r\n<li><span><span><span>V?n h&agrave;nh 24/7, theo d&otilde;i th??ng xuy&ecirc;n d?ch v? v&agrave; k?p th?i ph&aacute;t hi?n s? c? ?? th&ocirc;ng b&aacute;o cho ??i t&aacute;c.</span></span></span></li>\r\n<li><span><span><span>??i ng? ch?m s&oacute;c v&agrave; h? tr? kh&aacute;ch h&agrave;ng chuy&ecirc;n nghi?p qua t?ng ?&agrave;i 1900 55 55 77, ph?i h?p ch?t ch? v?i c&aacute;c ??ng nghi?p c?a Ng&acirc;n h&agrave;ng v&agrave; Vi?n th&ocirc;ng ?? k?p th?i gi?i quy?t c&aacute;c khi?u n?i c?a kh&aacute;ch h&agrave;ng v? d?ch v? SMS.</span></span></span></li>\r\n<li><span><span>VNPAY h? tr? ng&acirc;n h&agrave;ng xem b&aacute;o c&aacute;o tr?c tuy?n v? vi?c th?ng k&ecirc; c&aacute;c tin nh?n tr&ecirc;n t?ng m?ng vi?n th&ocirc;ng v&agrave; bi?u ?? ph&acirc;n t&iacute;ch theo d&otilde;i c&aacute;c tin nh?n ?i v&agrave; ??n c?a Ng&acirc;n h&agrave;ng theo th?i gian th?c. Ng&acirc;n h&agrave;ng c&oacute; th? ki?m tra tin nh?n nh?n ???c t? kh&aacute;ch h&agrave;ng hay tin nh?n g?i cho kh&aacute;ch h&agrave;ng t?i b?t k? th?i ?i?m n&agrave;o.</span></span></li>\r\n<li><span><span><span>H? th?ng h? t?ng ???c ??u t? v&agrave; tri?n khai v?i c&aacute;c thi?t b? v&agrave; m&aacute;y ch? c?u h&igrave;nh cao nh?t. H? th?ng ???c ??t t?i DataCenter c?a VNPAY t?i H&agrave; N?i v&agrave; TP. H? Ch&iacute; Minh n&ecirc;n ?&aacute;p ?ng ???c y&ecirc;u c?u an to&agrave;n v&agrave; b?o m?t cao nh?t.</span></span></span></li>\r\n<li><span><span><span>Chi ph&iacute; cho d?ch v? tin nh?n h?p l&yacute;, ph&ugrave; h?p v?i y&ecirc;u c?u ch?t l??ng d?ch v? cao v&agrave; chuy&ecirc;n bi?t c?a Ng&acirc;n h&agrave;ng.</span></span></span></li>\r\n</ul>', '1', '', '1', '1');
INSERT INTO kien_tintuc VALUES('13', '8', 'Mobile Banking', '', '', '2013-12-20', 'mobile-banking-1387555425.jpg', '<p><span>H? th?ng ng&acirc;n h&agrave;ng tr?c tuy?n qua di ??ng (Mobile Banking) cho ph&eacute;p kh&aacute;ch h&agrave;ng c&aacute; nh&acirc;n c&oacute; th? truy c?p v&agrave;o t&agrave;i kho?n c?a m&igrave;nh t?i b?t k? ?&acirc;u, ch? c?n m?t ???ng truy?n Internet (ADSL, Wifi, GPRS, 3G) b?ng m&aacute;y t&iacute;nh ho?c c&aacute;c thi?t b? di ??ng (smartphone, m&aacute;y t&iacute;nh b?ng, kiosk c?a ng&acirc;n h&agrave;ng).</span></p>\r\n<p><span>Kh&aacute;ch h&agrave;ng c&oacute; th? th?c hi?n ???c c&aacute;c giao d?ch c? b?n v?i Ng&acirc;n h&agrave;ng nh?: xem th&ocirc;ng tin t&agrave;i kho?n t?i ng&acirc;n h&agrave;ng: li?t k&ecirc; t&agrave;i kho?n, t&igrave;nh tr?ng t&agrave;i kho?n, s? d?, l?ch s? giao d?ch. Th?c hi?n ???c c&aacute;c giao d?ch chuy?n ti?n sang c&aacute;c t&agrave;i kho?n kh&aacute;c trong ng&acirc;n h&agrave;ng ho?c chuy?n ti?n ra ngo&agrave;i h? th?ng ng&acirc;n h&agrave;ng, th?c hi?n thanh to&aacute;n h&oacute;a ??n, thanh to&aacute;n d?ch v? h&agrave;ng h&oacute;a ho?c xem th&ocirc;ng tin h? tr? t&iacute;n d?ng tr?c ti?p tr&ecirc;n thi?t b? s? c&aacute; nh&acirc;n m&agrave; kh&ocirc;ng ph?i ??n t?n qu?y giao d?ch c?a ng&acirc;n h&agrave;ng. Ngo&agrave;i ra, kh&aacute;ch h&agrave;ng c&ograve;n c&oacute; th? s? d?ng r?t nhi?u d?ch v? gi&aacute; tr? gia t?ng kh&aacute;c nh? n?p ti?n ?i?n tho?i, mua b?o hi?m, v&eacute; m&aacute;y bay, t&agrave;u xe&hellip; tr?c tuy?n.</span></p>\r\n<p><span>H? th?ng h? tr? 2 ng&ocirc;n ng? (ti?ng Anh v&agrave; ti?ng Vi?t) ph&ugrave; h?p v?i ??i ?a s? kh&aacute;ch h&agrave;ng c?a Ng&acirc;n h&agrave;ng.</span></p>\r\n<p><span>H? th?ng ng&acirc;n h&agrave;ng qua di ??ng (Mobile Banking) ???c x&acirc;y d?ng tr&ecirc;n n?n di ??ng k?t h?p v?i c&ocirc;ng ngh? m?i nh?t. C&aacute;c c&ocirc;ng ngh? n&agrave;y ???c &aacute;p d?ng c&aacute;c k? thu?t l?p tr&igrave;nh m?i v&agrave; ti&ecirc;n ti?n nh?t, cho ph&eacute;p qu&aacute; tr&igrave;nh x? l&yacute; th&ocirc;ng tin ???c nhanh g?n, ch&iacute;nh x&aacute;c v&agrave; ??m b?o c&aacute;c y&ecirc;u c?u b?o m?t cao.</span></p>\r\n<p><span>H? th?ng Mobile Banking k?t h?p s? d?ng c&ocirc;ng ngh? kh&oacute;a ri&ecirc;ng (Private Key) c?p cho m?t thi?t b? c?ng v?i y&ecirc;u c?u x&aacute;c th?c d?a tr&ecirc;n IMEI c?a ?i?n tho?i ?? ??m b?o t&iacute;nh duy nh?t c?a thi?t b?. ??i v?i d? li?u truy?n nh?n gi?a thi?t b? v&agrave; ng&acirc;n h&agrave;ng ???c m&atilde; h&oacute;a b?ng ch?ng ch? b?o m?t ???ng truy?n (SSL certificate), ???c ch?ng nh?n c?a c&aacute;c h&atilde;ng b?o m?t h&agrave;ng ??u nh?: VeriSign, Entrust, ... gi&uacute;p cho d? li?u tr&ecirc;n ???ng truy?n ???c m&atilde; h&oacute;a, tr&aacute;nh l? th&ocirc;ng tin v? t&agrave;i kho?n c?a kh&aacute;ch h&agrave;ng khi d? li?u ???c g?i t? ph&iacute;a ?i?n tho?i ho?c thi?t b? di ??ng ??n m&aacute;y ch? h? th?ng v&agrave; ng??c l?i.</span></p>\r\n<p><span>?? t?ng t&iacute;nh x&aacute;c th?c ng??i d&ugrave;ng h? th?ng, khi ??ng nh?p, ngo&agrave;i y&ecirc;u c?u s? d?ng t&ecirc;n truy c?p (username) v&agrave; m?t kh?u (password) gi?ng nh? c&aacute;c h? th?ng kh&aacute;c, h? th?ng Mobile Banking cung c?p cho m?i kh&aacute;ch h&agrave;ng m?t gi?i ph&aacute;p sinh ra m?t kh?u t? ??ng khi giao d?ch g?i l&agrave; OTP (One Time Password) v&agrave; m?t kh?u ?&oacute; ???c g?i tr&ecirc;n m?t tin nh?n SMS t?i kh&aacute;ch h&agrave;ng.</span></p>\r\n<p><span>H? th?ng Mobile Banking bao g?m 2 th&agrave;nh ph?n ch&iacute;nh:</span></p>\r\n<ul>\r\n<li><span>Mobile Banking Front-End: Cung c?p giao di?n cho ng??i d&ugrave;ng. ?&acirc;y l&agrave; th&agrave;nh ph?n t??ng t&aacute;c tr?c ti?p v?i kh&aacute;ch h&agrave;ng v&agrave; ???c x&acirc;y d?ng tr&ecirc;n n?n h? ?i?u h&agrave;nh di ??ng v?i c&aacute;c c&ocirc;ng ngh? m?i nh?t. H? th?ng n&agrave;y chia l&agrave;m 3 lo?i ?ng d?ng:</span>\r\n<ul>\r\n<li><span>?ng d?ng Mobile Banking d&agrave;nh cho kh&aacute;ch h&agrave;ng ???c c&agrave;i ??t tr?c ti?p tr&ecirc;n ?i?n tho?i di ??ng c?a kh&aacute;ch h&agrave;ng, h? tr? ?i?n tho?i di ??ng smartphone, m&aacute;y t&iacute;nh b?ng v&agrave; c&aacute;c n?n t?ng Java, iOS, Android, Symbian, BlackBerry, Windows Phone.</span></li>\r\n<li><span>?ng d?ng Mobile Banking d&agrave;nh cho kh&aacute;ch h&agrave;ng d??i d?ng giao di?n WAPSite d&agrave;nh cho ?i?n tho?i di ??ng truy c?p b?ng Web Browser.</span></li>\r\n<li><span>?ng d?ng Mobile Banking d&agrave;nh cho c&aacute;c m&agrave;n h&igrave;nh c&ocirc;ng c?ng c?a Ng&acirc;n h&agrave;ng (KioskBanking) ??t t?i 1 ??a ?i?m ?? ph?c v? cho 1 l?nh v?c c? th? (thanh to&aacute;n, si&ecirc;u th?, tr??ng h?c).</span></li>\r\n</ul>\r\n</li>\r\n<li><span>Mobile Banking Back-End: Cung c?p giao di?n cho nh&acirc;n vi&ecirc;n ng&acirc;n h&agrave;ng s? d?ng ?? th?c hi?n ??ng k&yacute; kh&aacute;ch h&agrave;ng, qu?n tr?, theo d&otilde;i v&agrave; v?n h&agrave;nh h? th?ng. Module ???c x&acirc;y d?ng tr&ecirc;n n?n Web v?i c&ocirc;ng ngh? m?i nh?t.</span></li>\r\n</ul>\r\n<p><span>Kh&aacute;ch h&agrave;ng sau khi ??ng k&yacute; s? d?ng d?ch v? s? ???c cung c?p th&ocirc;ng tin ??ng k&yacute; bao g?m m&atilde; ??ng k&yacute; t?i qu?y v&agrave; m?t m&atilde; k&iacute;ch ho?t g?i b?ng tin nh?n SMS v? s? ?i?n tho?i ??ng k&yacute; v?i d?ch v?. Username v&agrave; m?t kh?u truy c?p c&oacute; th? ??ng k&yacute; m?i t?i Ng&acirc;n h&agrave;ng ho?c t&iacute;nh h?p s?n v?i h? th?ng Internet Banking ?&atilde; c&oacute;. Vi?c qu?n l&yacute; m?t kh?u ???c h? th?ng ??m b?o theo c&aacute;c quy tr&igrave;nh an to&agrave;n b?o m?t theo chu?n PCI DSS.</span></p>\r\n<p><span>Th?i gian tri?n khai c&aacute;c d?ch v? th&ocirc;ng th??ng cho h? th?ng Mobile Banking l&agrave; 2 th&aacute;ng. VNPAY s? ph?i h?p c&ugrave;ng ng&acirc;n h&agrave;ng tri?n khai d?ch v?, qu?ng b&aacute; d?ch v? c?ng nh? m? r?ng c&aacute;c d?ch v? gi&aacute; tr? gia t?ng tr&ecirc;n Mobile Banking cho kh&aacute;ch h&agrave;ng.</span></p>', '0', '', '1', '1');
INSERT INTO kien_tintuc VALUES('14', '8', 'Thanh toán hóa ??n VnPayBill', '', '', '2013-12-20', 'thanh-toan-hoa-don-vnpaybill-1387555463.jpg', '<p><span>Thanh to&aacute;n h&oacute;a ??n (VnPayBill) l&agrave; d?ch v? VNPAY cung c?p cho c&aacute;c Ng&acirc;n h&agrave;ng ?? kh&aacute;ch h&agrave;ng c?a Ng&acirc;n h&agrave;ng c&oacute; th? d&ugrave;ng t&agrave;i kho?n c?a m&igrave;nh thanh to&aacute;n cho c&aacute;c h&oacute;a ??n (?i&ecirc;?n tho?i di ?&ocirc;?ng tr? sau, ?i&ecirc;?n tho?i c&ocirc;? ??nh, ADSL, &hellip;) qua c&aacute;c k&ecirc;nh thanh to&aacute;n c?a ng&acirc;n h&agrave;ng. S&ocirc;? ti&ecirc;?n b? tr? trong t&agrave;i kho?n ?&uacute;ng b?ng s&ocirc;? ti&ecirc;?n c??c kh&aacute;ch h&agrave;ng s? d?ng ho?a ??n. Hi?n t?i, VNPAY ?&atilde; tri?n khai d?ch v? n&agrave;y tr&ecirc;n c&aacute;c k&ecirc;nh sau:</span></p>\r\n<ul>\r\n<li><span>K&ecirc;nh SMS</span></li>\r\n<li><span>K&ecirc;nh Internet Banking c?a Ng&acirc;n h&agrave;ng ho?c tr&ecirc;n website&nbsp;<a href=\"http://www.vban.vn/Trang-chu.aspx\" target=\"_blank\"><span>www.vban.vn</span></a>&nbsp;c?a VNPAY.</span></li>\r\n<li><span>K&ecirc;nh ATM: qua h? th?ng ATM c?a Ng&acirc;n h&agrave;ng.</span></li>\r\n<li><span>H&igrave;nh th?c U? nhi?m thu t? ??ng</span></li>\r\n</ul>\r\n<div><span><span><strong>L?i &iacute;ch c?a ng&acirc;n h&agrave;ng khi k?t n?i d?ch v? thanh to&aacute;n h&oacute;a ??n:</strong></span></span></div>\r\n<ul>\r\n<li><span><span>Gia t?ng d?ch v? ??i v?i kh&aacute;ch h&agrave;ng, nh? ?&oacute; t?ng kh? n?ng c?nh tranh, thu h&uacute;t kh&aacute;ch h&agrave;ng m? t&agrave;i kho?n t?i ng&acirc;n h&agrave;ng.</span></span></li>\r\n<li><span><span>Gi? ch&acirc;n kh&aacute;ch h&agrave;ng trung th&agrave;nh nh? c&oacute; nhi?u ti?n &iacute;ch thanh to&aacute;n g?n v?i chi ti&ecirc;u h&agrave;ng ng&agrave;y c?a h?.</span></span></li>\r\n<li><span><span>Thu ???c kho?n ph&iacute; d?ch v? thanh to&aacute;n do ?&oacute; l&agrave;m t?ng l?i nhu?n cho ng&acirc;n h&agrave;ng.</span></span></li>\r\n<li><span><span>Gi?m thi?u th?i gian giao d?ch t?i ng&acirc;n h&agrave;ng cho kh&aacute;ch h&agrave;ng, ph&aacute;t tri?n c&aacute;c d?ch v? Ng&acirc;n h&agrave;ng ?i?n t?.</span></span></li>\r\n<li><span><span>T?o ?&agrave; ?? ph&aacute;t tri?n th&ecirc;m nhi?u lo?i h&igrave;nh kh&aacute;c nh?: thu ti?n ?i?n, ti?n internet, truy?n h&igrave;nh c&aacute;p, ph&iacute; h?c ???ng&hellip;</span></span></li>\r\n</ul>\r\n<div><span><strong><span>C&aacute;c nh&agrave; cung c?p tri?n khai d?ch v? thanh to&aacute;n h&oacute;a ??n:</span></strong></span></div>\r\n<ul>\r\n<li><span><span>MobiFone: C??c ?i?n tho?i di ??ng tr? sau.</span></span></li>\r\n</ul>\r\n<ul>\r\n<li><span><span>Viettel: C??c ?i?n tho?i di ??ng tr? sau, ?i?n tho?i c? ??nh c&oacute; d&acirc;y (PSTN), ?i?n tho?i c? ??nh kh&ocirc;ng d&acirc;y (HomePhone), Internet ADSL</span></span></li>\r\n</ul>\r\n<ul>\r\n<li><span><span>VinaPhone: C??c ?i?n tho?i di ??ng tr? sau</span>.</span></li>\r\n</ul>\r\n<ul>\r\n<li><span>VNPT H?i Ph&ograve;ng:&nbsp;<span>?i?n tho?i c? ??nh c&oacute; d&acirc;y, ?i?n tho?i c? ??nh kh&ocirc;ng d&acirc;y, Internet ADSL, MyTV...</span></span></li>\r\n</ul>\r\n<ul>\r\n<li><span><span>VNPT H? Ch&iacute; Minh</span>: ?i?n tho?i c? ??nh, G-Phone,&nbsp;<span>Internet ADSL</span></span></li>\r\n</ul>\r\n<ul>\r\n<li><span>Trung t&acirc;m vi?n th&ocirc;ng B&igrave;nh Thu?n</span></li>\r\n</ul>\r\n<ul>\r\n<li><span>C&ocirc;ng ty C? ph?n C?p n??c Gia ??nh</span></li>\r\n</ul>\r\n<ul>\r\n<li><span>T?p ?o&agrave;n ?i?n l?c Vi?t Nam (EVN): h&oacute;a ??n ti?n ?i?n, xem chi ti?t c&aacute;c chi nh&aacute;nh ?i?n l?c tri?n khai d?ch v?&nbsp;<a href=\"http://vnpay.vn/Uploads/files/DS%20CN%20TT%20tren%20VBAN.pdf\"><span>t?i ?&acirc;y</span></a></span></li>\r\n</ul>\r\n<ul>\r\n<li><span>Thu h?c ph&iacute;: ??i h?c M? TP H? Ch&iacute; Minh, ??i h?c C&ocirc;ng nghi?p TP H? Ch&iacute; Minh, ??i h?c C?n Th?, ??i h?c Kinh t? - Lu?t TP H? Ch&iacute; Minh, ??i h?c T&acirc;y Nguy&ecirc;n - ?aklak, ??i h?c Ng&acirc;n h&agrave;ng TP H? Ch&iacute; Minh, ??i h?c T&acirc;y ?&ocirc; - C?n Th?</span></li>\r\n</ul>', '0', '', '1', '1');
INSERT INTO kien_tintuc VALUES('15', '9', 'Thu h? hóa ??n qua ngân hàng', '', '', '2013-12-20', 'thu-ho-hoa-don-qua-ngan-hang-1387555680.jpg', '<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif; text-align: justify;\">D?ch v? Thu h? h&oacute;a ??n qua ng&acirc;n h&agrave;ng l&agrave; k&ecirc;nh thanh to&aacute;n ch&iacute;nh x&aacute;c, ti?n l?i gi&uacute;p nh&agrave; cung c?p thu ph&iacute; s? d?ng d?ch v? th&ocirc;ng qua t&agrave;i kho?n c?a kh&aacute;ch h&agrave;ng t?i ng&acirc;n h&agrave;ng. Kh&aacute;ch h&agrave;ng n? ho&aacute; ??n ch? c?n c&oacute; t&agrave;i kho?n ng&acirc;n h&agrave;ng l&agrave; c&oacute; th? ch? ??ng thanh to&aacute;n c&aacute;c kho?n n? c??c c?a m&igrave;nh, nh? h&oacute;a ??n Hi?n t?i, VNPAY ?&atilde; tri?n khai d?ch v? n&agrave;y tr&ecirc;n c&aacute;c k&ecirc;nh nh? SMS, Internet Banking c?a Ng&acirc;n h&agrave;ng ho?c tr&ecirc;n website<span class=\"Apple-converted-space\">&nbsp;</span><a style=\"color: #006699; text-decoration: none;\" href=\"http://www.vban.vn/\">Vban.vn</a><span class=\"Apple-converted-space\">&nbsp;</span>c?a VNPAY, h? th?ng ATM c?a Ng&acirc;n h&agrave;ng ho?c qua h&igrave;nh th?c U? nhi?m thu t? ??ng.</span></p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">D?ch v? Thu h? h&oacute;a ??n qua ng&acirc;n h&agrave;ng l&agrave; k&ecirc;nh thanh to&aacute;n ch&iacute;nh x&aacute;c, ti?n l?i gi&uacute;p nh&agrave; cung c?p thu ph&iacute; s? d?ng d?ch v? th&ocirc;ng qua t&agrave;i kho?n c?a kh&aacute;ch h&agrave;ng t?i ng&acirc;n h&agrave;ng. Kh&aacute;ch h&agrave;ng n? ho&aacute; ??n ch? c?n c&oacute; t&agrave;i kho?n ng&acirc;n h&agrave;ng l&agrave; c&oacute; th? ch? ??ng thanh to&aacute;n c&aacute;c kho?n n? c??c c?a m&igrave;nh, nh? h&oacute;a ??n&nbsp; Hi?n t?i, VNPAY ?&atilde; tri?n khai d?ch v? n&agrave;y tr&ecirc;n c&aacute;c k&ecirc;nh sau:</span></span></p>\r\n<ul style=\"padding-left: 3.333em; margin: 0px 0px 1.5em; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\">\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">K&ecirc;nh SMS</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">K&ecirc;nh Internet Banking c?a Ng&acirc;n h&agrave;ng ho?c tr&ecirc;n C?ng thanh to&aacute;n h&oacute;a ??n v&agrave; mua h&agrave;ng tr?c tuy?n<span class=\"Apple-converted-space\">&nbsp;</span><a style=\"color: #006699; text-decoration: none;\" href=\"http://www.vban.vn/Dich-vu/tabid/61/view/listtypebill/Default.aspx\" target=\"_blank\">Vban.vn</a><span class=\"Apple-converted-space\">&nbsp;</span>c?a VNPAY.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">K&ecirc;nh ATM: qua h? th?ng ATM c?a Ng&acirc;n h&agrave;ng.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">Qua h&igrave;nh th?c U? nhi?m thu t? ??ng.</span></span></li>\r\n</ul>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">V?i d?ch v? n&agrave;y, c&aacute;c h&oacute;a ??n ??nh k? nh? ?i?n tho?i, Internet, ?i?n, n??c, truy?n h&igrave;nh c&aacute;p, thanh to&aacute;n h?c ph&iacute;,...,... c&oacute; th? ???c thanh to&aacute;n d? d&agrave;ng m&agrave; kh&aacute;ch h&agrave;ng kh&ocirc;ng c?n t?i c&aacute;c ?i?m thu ph&iacute; d?ch v?. Ch? v?i m?t l?n ??ng k&yacute;, c&aacute;c h&oacute;a ??n h&agrave;ng th&aacute;ng ???c kh&aacute;ch h&agrave;ng ?y quy?n giao cho ng&acirc;n h&agrave;ng s? ???c thanh to&aacute;n ??y ??, ?&uacute;ng h?n. S? ti?n thanh to&aacute;n ???c ng&acirc;n h&agrave;ng t? ??ng tr&iacute;ch n? t? t&agrave;i kho?n c?a kh&aacute;ch h&agrave;ng. H&oacute;a ??n t&agrave;i ch&iacute;nh s? ???c nh&agrave; cung c?p d?ch v? g?i v? cho kh&aacute;ch h&agrave;ng qua ???ng b?u ?i?n.</span></span></p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">V?i vi?c k?t n?i d?ch v? thu h? h&oacute;a ??n qua ng&acirc;n h&agrave;ng, c&aacute;c nh&agrave; cung c?p d?ch v? s? c&oacute; th&ecirc;m m?t k&ecirc;nh thanh to&aacute;n m?i, gi?m thi?u chi ph&iacute; cho nh&acirc;n vi&ecirc;n thu c??c, c&aacute;c ?i?m thu c??c, ph?c v? kh&aacute;ch h&agrave;ng ng&agrave;y c&agrave;ng t?t h?n b?ng vi?c ?em l?i cho h? nhi?u ti?n &iacute;ch m?i, ?a d?ng. C&ugrave;ng v?i ?&oacute;, ph??ng th?c thanh to&aacute;n kh&ocirc;ng d&ugrave;ng ti?n m?t s? gi&uacute;p tr&aacute;nh ???c c&aacute;c r?i ro x?y ra v?i c&aacute;c kho?n ti?n c&ocirc;ng ty thu ???c t? kh&aacute;ch h&agrave;ng nh?: m?t ti?n, ti?n gi?&hellip;</span></span></p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\">&nbsp;</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><strong>C&aacute;c nh&agrave; cung c?p tri?n khai d?ch v? thanh to&aacute;n h&oacute;a ??n:</strong></span></span></p>\r\n<ul style=\"padding-left: 3.333em; margin: 0px 0px 1.5em; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\">\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">MobiFone: C??c ?i?n tho?i di ??ng tr? sau.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"line-height: 15px;\">S-Fone: C??c ?i?n tho?i di ??ng tr? sau</span>.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">Viettel: C??c ?i?n tho?i di ??ng tr? sau, ?i?n tho?i c? ??nh c&oacute; d&acirc;y (PSTN), ?i?n tho?i c? ??nh kh&ocirc;ng d&acirc;y (HomePhone), Internet ADSL</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">VNPT H?i Ph&ograve;ng: C??c ?i?n tho?i di ??ng VinaPhone tr? sau, ?i?n tho?i c? ??nh c&oacute; d&acirc;y, ?i?n tho?i c? ??nh kh&ocirc;ng d&acirc;y, Internet ADSL, MyTV...</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">VNPT H? Ch&iacute; Minh: C??c ?i?n tho?i di ??ng VinaPhone tr? sau, ?i?n tho?i c? ??nh, G-Phone, Internet ADSL</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">Trung t&acirc;m vi?n th&ocirc;ng B&igrave;nh Thu?n</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">T?p ?o&agrave;n ?i?n l?c Vi?t Nam (EVN): h&oacute;a ??n ti?n ?i?n, xem chi ti?t c&aacute;c chi nh&aacute;nh ?i?n l?c tri?n khai d?ch v?<span class=\"Apple-converted-space\">&nbsp;</span><a style=\"color: #006699; text-decoration: none;\" href=\"http://10.22.7.86:2012/Uploads/files/Documents/Danh%20sach%20cong%20ty%20dien%20luc.pdf\" target=\"_blank\">t?i ?&acirc;y</a></span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: arial, helvetica, sans-serif;\">Thu h?c ph&iacute;: ??i h?c M? TP H? Ch&iacute; Minh, ??i h?c C&ocirc;ng nghi?p TP H? Ch&iacute; Minh, ??i h?c C?n Th?, ??i h?c Kinh t? - Lu?t TP H? Ch&iacute; Minh, ??i h?c T&acirc;y Nguy&ecirc;n - ?aklak, ??i h?c Ng&acirc;n h&agrave;ng TP H? Ch&iacute; Minh, ??i h?c T&acirc;y ?&ocirc; - C?n Th?</span></span></li>\r\n</ul>', '1', '', '1', '1');
INSERT INTO kien_tintuc VALUES('16', '9', 'Thanh toán tr?c tuy?n', '', '', '2013-12-20', 'thanh-toan-truc-tuyen-1387555740.jpg', '<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\">C?ng thanh to&aacute;n VnPayment do VNPAY ph&aacute;t tri?n l&agrave; h? th?ng trung gian truy?n d?n, trao ??i v&agrave; x? l&yacute; c&aacute;c giao d?ch thanh to&aacute;n gi?a ng??i ti&ecirc;u d&ugrave;ng c&oacute; th?, t&agrave;i kho?n ng&acirc;n h&agrave;ng ho?c v&iacute; ?i?n t? v?i c&aacute;c Doanh nghi?p cung c?p h&agrave;ng ho&aacute;, d?ch v? tr&ecirc;n Internet. C?ng thanh to&aacute;n ?&aacute;p ?ng c&aacute;c y&ecirc;u c?u cao nh?t v? y?u t? b?o m?t, ???c Ng&acirc;n h&agrave;ng Nh&agrave; n??c v&agrave; c&aacute;c Ng&acirc;n h&agrave;ng t?i Vi?t Nam ch?ng nh?n.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\">Ch&iacute;nh th?c ?i v&agrave;o ho?t ??ng t? th&aacute;ng 8/2011 v?i m?c ti&ecirc;u ph&aacute;t tri?n m?t ph??ng th?c thanh to&aacute;n ??n gi?n, ti?n l?i; l&agrave;m gi?m chi ph&iacute; x&atilde; h?i v&agrave; thay ??i th&oacute;i quen mua s?m truy?n th?ng c?a ??i b? ph?n d&acirc;n ch&uacute;ng, hi?n nay c?ng thanh to&aacute;n VnPayment ?&atilde; k?t n?i v?i 32 website th??ng m?i ?i?n t? c?a 25 ??i t&aacute;c Doanh nghi?p v?i nhi?u lo?i h&agrave;ng h&oacute;a, d?ch v? ?a d?ng v&agrave; phong ph&uacute;.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\">Hi?n t?i, VnPayment ?ang h? tr? thanh to&aacute;n cho kh&aacute;ch h&agrave;ng c?a c&aacute;c Ng&acirc;n h&agrave;ng: Vietcombank, Dong A Bank, VietinBank, BIDV, Techcombank, Sacombank, HDBank, OceanBank v&agrave; Agribank (th&ocirc;ng qua n?p ti?n v&agrave;o v&iacute; VnMart). C?ng thanh to&aacute;n VnPayment ch?p nh?n h?u h?t th? thanh to&aacute;n n?i ??a v&agrave; qu?c t? v?i ch? m?t k?t n?i duy nh?t, h? th?ng qu?n l&yacute; kinh doanh cung c?p c&aacute;c b&aacute;o c&aacute;o chi ti?t v? giao d?ch v&agrave; doanh s?, c? ch? qu?n l&yacute; r?i ro ??t chu?n qu?c t?, s? d?ng t?t c? nh?ng d?ch v? tr&ecirc;n c&ugrave;ng m?c chi ph&iacute; h?p l&yacute; s? gi&uacute;p c&aacute;c doanh nghi?p s?n s&agrave;ng ph&aacute;t tri?n kinh doanh tr&ecirc;n Internet.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\"><span style=\"font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 21px; orphans: 2; text-align: justify; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; float: none; display: inline !important;\">Trong th?i gian t?i, VNPAY s? ti?p t?c m? r?ng k?t n?i v?i c&aacute;c Doanh nghi?p v&agrave; Ng&acirc;n h&agrave;ng, nh?m ?em l?i l?i &iacute;ch t?i ?a cho kh&aacute;ch h&agrave;ng.</span></p>\r\n<p style=\"margin: 0.1in 10pt 0.1in 0in; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 21px; orphans: 2; widows: 2; text-align: justify;\"><strong>L?i &iacute;ch c?a Doanh nghi?p khi k?t n?i C?ng thanh to&aacute;n VnPayment</strong></p>\r\n<ul style=\"padding-left: 3.333em; margin: 0px 0px 1.5em; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 21px; orphans: 2; text-align: justify; widows: 2;\">\r\n<li>M? r?ng nhi?u h&igrave;nh th?c thanh to&aacute;n tr?c tuy?n b?ng th? ho?c t&agrave;i kho?n ng&acirc;n h&agrave;ng, thu h&uacute;t ???c c&aacute;c kh&aacute;ch h&agrave;ng ti?m n?ng.</li>\r\n<li>Tri?n khai k?t n?i ??n gi?n, vi?c thanh to&aacute;n d? d&agrave;ng do kh&ocirc;ng c?n ph?i m? t&agrave;i kho?n t?i nhi?u Ng&acirc;n h&agrave;ng.</li>\r\n<li>M?c ph&iacute; c?nh tranh v&agrave; nh?n ???c nhi?u h? tr? t? VNPAY trong vi?c qu?ng b&aacute; s?n ph?m t?i kh&aacute;ch h&agrave;ng Ng&acirc;n h&agrave;ng.</li>\r\n</ul>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>M&ocirc; h&igrave;nh k?t n?i Merchant - C?ng thanh to&aacute;n VnPayment</strong></p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: center;\"><img src=\"http://vnpay.vn/Uploads/images/VNPAY/vnpayment.jpg\" alt=\"\" width=\"445\" height=\"430\" /></p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; line-height: 13px; text-align: justify;\"><strong><span style=\"line-height: 13px;\">M&ocirc; t? lu?ng giao d?ch</span></strong></p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; line-height: 13px; text-align: justify;\">&nbsp;</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: center;\">&nbsp;<img src=\"http://10.22.7.86:2012/Uploads/images/QuyTrinhGiaoDich.jpg\" alt=\"\" width=\"625\" height=\"96\" /></p>\r\n<ul style=\"padding-left: 3.333em; margin: 0px 0px 1.5em; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\">\r\n<li style=\"text-align: justify;\"><span style=\"line-height: 18px;\">Kh&aacute;ch h&agrave;ng l?a ch?n h&agrave;ng ho&aacute;, d?ch v? t?i c&aacute;c website th??ng m?i ?i?n t? v&agrave; ch?n n&uacute;t thanh to&aacute;n.</span></li>\r\n<li style=\"text-align: justify;\"><span style=\"line-height: 18px;\">Kh&aacute;ch h&agrave;ng s? ???c chuy?n ??n giao di?n c?ng thanh to&aacute;n<span class=\"Apple-converted-space\">&nbsp;</span><a style=\"color: #006699; text-decoration: none;\" href=\"http://vnpayment.vnpay.vn/\" target=\"_blank\">VnPayment</a>. Kh&aacute;ch h&agrave;ng l?a ch?n h&igrave;nh th?c thanh to&aacute;n qua t&agrave;i kho?n Ng&acirc;n h&agrave;ng A v&agrave; nh?p c&aacute;c th&ocirc;ng tin v? t&agrave;i kho?n th?.</span></li>\r\n<li style=\"text-align: justify;\"><span style=\"line-height: 18px;\">C?ng thanh to&aacute;n VnPayment chuy?n th&ocirc;ng tin v? t&agrave;i kho?n th? v&agrave; y&ecirc;u c?u thanh to&aacute;n ??n h&agrave;ng sang h? th?ng x&aacute;c th?c c?a Ng&acirc;n h&agrave;ng A.</span></li>\r\n<li style=\"text-align: justify;\"><span style=\"line-height: 18px;\">Ng&acirc;n h&agrave;ng A x&aacute;c th?c t&iacute;nh h?p l? c&aacute;c th&ocirc;ng tin, s? d? t&agrave;i kho?n th? c?a Kh&aacute;ch h&agrave;ng v&agrave; th?c hi?n thanh to&aacute;n theo y&ecirc;u c?u. Sau ?&oacute; th&ocirc;ng b&aacute;o v? k?t qu? th?c hi?n giao d?ch sang c?ng thanh to&aacute;n VnPayment.</span></li>\r\n<li style=\"text-align: justify;\"><span style=\"line-height: 18px;\">C?ng thanh to&aacute;n VnPayment g?i th&ocirc;ng b&aacute;o k?t qu? th?c hi?n giao d?ch sang website th??ng m?i ?i?n t?, ??ng th?i hi?n th? th&ocirc;ng b&aacute;o giao d?ch ?&atilde; th&agrave;nh c&ocirc;ng cho Kh&aacute;ch h&agrave;ng.</span></li>\r\n</ul>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: justify;\"><strong><span style=\"line-height: 18px;\">C&aacute;c h&igrave;nh th?c thanh to&aacute;n tr?c tuy?n</span></strong></p>\r\n<ul style=\"padding-left: 3.333em; margin: 0px 0px 1.5em; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\">\r\n<li style=\"text-align: justify;\"><em><strong>Thanh to&aacute;n th? n?i ??a</strong></em></li>\r\n</ul>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: center;\"><img src=\"http://vnpay.vn/Uploads/images/VNPAY/vnpayment%201.jpg\" alt=\"\" width=\"355\" height=\"337\" /></p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 1</strong>: Ch? th? mua h&agrave;ng h&oacute;a, d?ch v? tr&ecirc;n trang web th??ng m?i ?i?n t? (Merchant) c?a ??n v? ch?p nh?n th? (?VCNT) v&agrave; nh?n n&uacute;t &ldquo;Thanh to&aacute;n&rdquo;.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 2</strong>: ?VCNT g?i th&ocirc;ng tin ??n h&agrave;ng ??n VnPayment.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 3</strong>: T?i ?&acirc;y, ch? th? x&aacute;c nh?n th&ocirc;ng tin ??n h&agrave;ng, ch?n ng&acirc;n h&agrave;ng c?n thanh to&aacute;n v&agrave; VnPayment chuy?n ch? th? sang trang thanh to&aacute;n tr?c tuy?n c?a ng&acirc;n h&agrave;ng t??ng ?ng.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 4</strong>: Ng&acirc;n h&agrave;ng x&aacute;c th?c v&agrave; ghi n? t&agrave;i kho?n ch? th?, sau ?&oacute; th&ocirc;ng b&aacute;o k?t qu? l?i cho VnPayment.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 5</strong>: VnPayment chuy?n k?t qu? thanh to&aacute;n cho ?VCNT ?? quy?t ??nh cung c?p h&agrave;ng h&oacute;a, d?ch v? cho ch? th?.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 6</strong>: ?VCNT th&ocirc;ng b&aacute;o k?t qu? cung c?p h&agrave;ng h&oacute;a, d?ch v? cho ch? th?.</p>\r\n<ul style=\"padding-left: 3.333em; margin: 0px 0px 1.5em; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\">\r\n<li><em><strong>Thanh to&aacute;n th? qu?c t?</strong></em></li>\r\n</ul>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-align: center;\"><img src=\"http://vnpay.vn/Uploads/images/VNPAY/vnpayment%202.jpg\" alt=\"\" width=\"362\" height=\"338\" /></p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 1</strong>: Ch? th? mua h&agrave;ng h&oacute;a, d?ch v? tr&ecirc;n trang web TM?T c?a ?VCNT v&agrave; nh?n n&uacute;t &ldquo;Thanh To&aacute;n&rdquo;.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 2</strong>: ?VCNT g?i th&ocirc;ng tin ??n h&agrave;ng ??n VnPayment.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 3</strong>: VnPayment y&ecirc;u c?u ch? th? cung c?p th&ocirc;ng tin th? v&agrave; chuy?n c&aacute;c th&ocirc;ng tin n&agrave;y ??n c&aacute;c T? ch?c th? qu?c t? (TCTQT) t??ng ?ng.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 4</strong>: TCTQT g?i th&ocirc;ng tin th? ??n Ng&acirc;n h&agrave;ng ph&aacute;t h&agrave;nh (NHPH) t??ng ?ng.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 5</strong>: NHPH tr? l?i x&aacute;c th?c v&agrave; c?p ph&eacute;p giao d?ch ho?c t? ch?i cho TCTQT.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 6</strong>: TCTQT chuy?n k?t qu? tr? l?i c?a NHPH cho VnPayment.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 7</strong>: VnPayment chuy?n k?t qu? nh?n ???c cho ?VCNT ?? quy?t ??nh cung c?p h&agrave;ng h&oacute;a, d?ch v? cho ch? th?.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 8:</strong><span class=\"Apple-converted-space\">&nbsp;</span>?VCNT th&ocirc;ng b&aacute;o k?t qu? cung c?p h&agrave;ng h&oacute;a, d?ch v? cho ch? th?.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 9</strong>: VnPayment g?i y&ecirc;u c?u thanh to&aacute;n cho c&aacute;c giao d?ch ?&atilde; ???c c?p ph&eacute;p ??n Sacombank.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 10</strong>: Sacombank g?i y&ecirc;u c?u thanh to&aacute;n cho c&aacute;c giao d?ch ?&atilde; ???c c?p ph&eacute;p ??n c&aacute;c NHPH t??ng ?ng.</p>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\"><strong>B??c 11</strong>: C&aacute;c NHPH chuy?n ti?n cho Sacombank theo c&aacute;c giao d?ch ???c y&ecirc;u c?u.</p>', '1', '', '1', '1');
INSERT INTO kien_tintuc VALUES('17', '9', 'Mobile Maketing', '', '', '2013-12-20', 'mobile-maketing-1387555792.jpg', '<div class=\"boxmodule clearfix\" style=\"margin-bottom: 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\">\r\n<p style=\"margin: 0px 0px 10px;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">Mobile Marketing l&agrave; d?ch v? g?i tin nh?n v?i s? l??ng l?n (h&agrave;ng ch?c, h&agrave;ng tr?m ngh&igrave;n kh&aacute;ch h&agrave;ng c&ugrave;ng m?t l&uacute;c) do VNPAY cung c?p, ph?c v? ch? y?u cho c&aacute;c m?c ?&iacute;ch truy?n th&ocirc;ng, qu?ng b&aacute; s?n ph?m, d?ch v? t?i c&aacute;c kh&aacute;ch h&agrave;ng m?t c&aacute;ch hi?u qu? v?i chi ph&iacute; th?p.</span></span></p>\r\n<p style=\"margin: 0px 0px 10px;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">??c ?i?m n?i b?t c?a d?ch v? l&agrave; th??ng hi?u c?a doanh nghi?p ???c hi?n th? t?i m?c ng??i g?i (Sender) thay v&igrave; m?t s? ?i?n tho?i/ s? t?ng ?&agrave;i, qua ?&oacute; kh?ng ??nh th??ng hi?u v&agrave; t?o s? tin t??ng tuy?t ??i, t?ng m?c ?? nh?n bi?t v&agrave; s? trung th&agrave;nh c?a kh&aacute;ch h&agrave;ng ??i v?i th??ng hi?u. ??ng th?i kh&ocirc;ng vi ph?m quy ??nh spam tin nh?n.</span></span></p>\r\n<p style=\"margin: 0px 0px 10px; text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\"><strong>T&iacute;nh n?ng v&agrave; kh? n?ng ?&aacute;p ?ng c?a h? th?ng Mobile Marketing</strong><span class=\"Apple-converted-space\">&nbsp;</span><strong>c?a VNPAY</strong>:</span></span></p>\r\n<ul style=\"padding-left: 3.333em; margin: 0px 0px 1.5em;\">\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">G?i tin nh?n ch? ho?c tin nh?n flash.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">H? th?ng t? ??ng l?c c&aacute;c s? ?i?n tho?i tr&ugrave;ng nhau, ??ng th?i c&oacute; ch?c n?ng h?y s? ?i?n tho?i kh&ocirc;ng c&oacute; th?t ho?c c&oacute; ch?a k&yacute; t? ??c bi?t.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">Cung c?p b&aacute;o c&aacute;o chi ti?t v? vi?c g?i tin nh?n.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">T?c ?? g?i tin nhanh.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">Kh&ocirc;ng h?n ch? s? l??ng tin nh?n g?i ?i.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">H? th?ng Mobile Marketing ???c x&acirc;y d?ng v&agrave; thi?t k? t?i ?u, ??m b?o t&iacute;nh ?n ??nh trong qu&aacute; tr&igrave;nh v?n h&agrave;nh, ??m b?o kh&ocirc;ng gi&aacute;n ?o?n k?t n?i, kh&ocirc;ng m?t tin trong qu&aacute; tr&igrave;nh g?i.</span></span></li>\r\n</ul>\r\n<p style=\"margin: 0px 0px 10px; text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\"><strong>L?i &iacute;ch c?a doanh nghi?p khi s? d?ng</strong><span class=\"Apple-converted-space\">&nbsp;</span><strong>Mobile Marketing:</strong></span></span></p>\r\n<ul style=\"padding-left: 3.333em; margin: 0px 0px 1.5em;\">\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">Th&ocirc;ng tin truy?n th&ocirc;ng ???c chuy?n t?i kh&aacute;ch h&agrave;ng nhanh ch&oacute;ng.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">Ch? ??ng trong vi?c ti?p c?n ??i t??ng kh&aacute;ch h&agrave;ng: kh&aacute;ch h&agrave;ng m?c ti&ecirc;u, kh&aacute;ch h&agrave;ng ti?m n?ng,&hellip;</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">?a d?ng k?ch b?n, n?i dung truy?n t?i t?i kh&aacute;ch h&agrave;ng theo t?ng ch??ng tr&igrave;nh marketing.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">T?i ?u h?n c&aacute;c h&igrave;nh th?c marketing truy?n th?ng nh? ti?t ki?m chi ph&iacute; thi?t k?, in ?n, nguy&ecirc;n li?u, ngu?n nh&acirc;n l?c,&hellip;</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">T?ng s? nh?n bi?t th??ng hi?u c?a kh&aacute;ch h&agrave;ng ??i v?i doanh nghi?p do SMS ???c g?i c&oacute; g?n Brand name.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">B?o m?t ???c c&aacute;c th&ocirc;ng tin, d? li?u kh&aacute;ch h&agrave;ng.</span></span></li>\r\n</ul>\r\n<p style=\"margin: 0px 0px 10px; text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\"><strong>L?i &iacute;ch c?a kh&aacute;ch h&agrave;ng khi nh?n tin nh?n t? Mobile Marketing</strong>:</span></span></p>\r\n<ul style=\"padding-left: 3.333em; margin: 0px 0px 1.5em;\">\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">Nhanh ch&oacute;ng nh?n ???c th&ocirc;ng tin v? c&aacute;c ch??ng tr&igrave;nh c?a doanh nghi?p.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">C&oacute; nhi?u th&ocirc;ng tin v? s?n ph?m &ndash; d?ch v? do doanh nghi?p cung c?p.</span></span></li>\r\n<li style=\"text-align: justify;\"><span style=\"font-family: arial, helvetica, sans-serif;\"><span style=\"font-size: 12px;\">T?ng s? tin t??ng v&agrave;o th??ng hi?u c?a doanh nghi?p.</span></span></li>\r\n</ul>\r\n</div>\r\n<p style=\"margin: 0px 0px 10px; color: #333333; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 18px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff;\">&nbsp;</p>', '0', '', '1', '1');
INSERT INTO kien_tintuc VALUES('18', '10', 'Viettel khuy?n m?i 50% t? ngày 20/12/2013 ??n ngày 23/12/2013', '', '', '2013-12-20', '', '<p><a title=\"Information detail\">Viettel khuy?n m?i 50% t? ng&agrave;y 20/12/2013 ??n ng&agrave;y 23/12/2013</a></p>', '0', '', '1', '1');
INSERT INTO kien_tintuc VALUES('19', '10', 'Viettel khuy?n m?i 50% t? ngày 1/1/201 ??n ngày 3/1/2014', '', '', '2013-12-20', '', '<p>Viettel khuy?n m?i 50% t? ng&agrave;y 1/1/201 ??n ng&agrave;y 3/1/2014</p>', '0', '', '1', '1');

DROP TABLE IF EXISTS kien_tonkho;
CREATE TABLE kien_tonkho (
   id_tonkho int(11) NOT NULL auto_increment,
   id_pro int(11) NOT NULL,
   soluong int(11) NOT NULL,
   date_ton date NOT NULL,
   PRIMARY KEY (id_tonkho),
   KEY id_pro (id_pro)
);


DROP TABLE IF EXISTS kien_trangthai_donhang;
CREATE TABLE kien_trangthai_donhang (
   id_trangthai int(11) NOT NULL auto_increment,
   ten varchar(100) NOT NULL,
   PRIMARY KEY (id_trangthai)
);


DROP TABLE IF EXISTS kien_transaction;
CREATE TABLE kien_transaction (
   id int(10) NOT NULL auto_increment,
   proviID int(11) NOT NULL,
   requestID varchar(100) NOT NULL,
   payId int(11) NOT NULL,
   member_id int(10) NOT NULL,
   product_id int(10) NOT NULL,
   qty int(10) NOT NULL,
   price_off float NOT NULL,
   money_rose float NOT NULL,
   created date NOT NULL,
   status int(1) NOT NULL,
   is_topup tinyint(4),
   mobile varchar(20) NOT NULL,
   game_account varchar(200) NOT NULL,
   downloaded tinyint(1) NOT NULL,
   ip_download varchar(200) NOT NULL,
   confirm_code varchar(25) NOT NULL,
   PRIMARY KEY (id),
   KEY member_id (member_id),
   KEY product_id (product_id)
);

INSERT INTO kien_transaction VALUES('1', '0', '', '-1', '3', '1', '1', '0', '0', '2013-12-19', '0', '1', '', '', '0', '123.16.142.75', '975ccb23337bb5761');
INSERT INTO kien_transaction VALUES('2', '0', '', '-1', '3', '1', '1', '0', '0', '2013-12-19', '0', '1', '', '', '0', '123.16.142.75', '3bd25041881277658');
INSERT INTO kien_transaction VALUES('3', '0', '', '-1', '3', '1', '1', '0', '0', '2013-12-19', '0', '1', '', '', '0', '123.16.142.75', '41434683dd9d18a03');
INSERT INTO kien_transaction VALUES('4', '0', '', '-1', '3', '1', '1', '0', '0', '2013-12-19', '0', '1', '', '', '0', '123.16.142.75', 'ad24f4333c7658a0e');
INSERT INTO kien_transaction VALUES('5', '0', '2013121922550010614211', '207408', '3', '1', '1', '0', '0', '2013-12-19', '1', '1', '0932235947', '', '1', '123.16.142.75', '250dabe07151bdc23');
INSERT INTO kien_transaction VALUES('6', '0', '', '-1', '3', '25', '1', '0', '0', '2013-12-19', '0', '1', '', '', '0', '123.16.142.75', 'ff767970b67041697');
INSERT INTO kien_transaction VALUES('7', '0', '', '-1', '3', '25', '1', '0', '0', '2013-12-19', '0', '1', '', '', '0', '123.16.142.75', 'a5eb6a3b4d0411301');
INSERT INTO kien_transaction VALUES('8', '0', '', '-1', '3', '31', '1', '0', '0', '2013-12-19', '0', '1', '', '', '0', '123.16.142.75', 'e8cb037d9719ad8cd');
INSERT INTO kien_transaction VALUES('9', '0', '', '-1', '3', '1', '1', '0', '0', '2013-12-19', '0', '1', '', '', '0', '123.16.142.75', 'a2142a6eb7bc4f3c8');
INSERT INTO kien_transaction VALUES('10', '0', '', '-1', '3', '1', '1', '0', '0', '2013-12-19', '0', '1', '', '', '0', '123.16.142.75', 'd2f5a76aa1c00fa2f');
INSERT INTO kien_transaction VALUES('11', '0', '2013122000030694398038', '128755', '3', '1', '3', '0', '0', '2013-12-20', '1', '1', '', '', '1', '123.16.142.75', 'fee3be5e183ac9605');
INSERT INTO kien_transaction VALUES('12', '0', '2013122000053616310077', '128756', '3', '1', '1', '0', '0', '2013-12-20', '1', '1', '', '', '1', '123.16.142.75', '91440e4da0b65a70c');
INSERT INTO kien_transaction VALUES('13', '0', '2013122000145216798533', '128757', '3', '1', '2', '0', '0', '2013-12-20', '1', '1', '', '', '1', '123.16.142.75', 'c66674d09081940f0');
INSERT INTO kien_transaction VALUES('14', '0', '2013122000185853681337', '128758', '3', '1', '2', '0', '0', '2013-12-20', '1', '1', '', '', '1', '123.16.142.75', '31fb7b672a68b659d');
INSERT INTO kien_transaction VALUES('15', '0', '2013122000224844674697', '128759', '3', '1', '1', '0', '0', '2013-12-20', '1', '1', '', '', '1', '123.16.142.75', 'acd6a5a5254ab2d76');
INSERT INTO kien_transaction VALUES('16', '0', '2013122000264773666509', '207411', '3', '1', '1', '0', '0', '2013-12-20', '1', '1', '0932235947', '', '1', '123.16.142.75', '1e2da9acfe4fbd19e');
INSERT INTO kien_transaction VALUES('17', '0', '2013122000291197412867', '207413', '3', '1', '1', '0', '0', '2013-12-20', '1', '1', '0932235947', '', '1', '123.16.142.75', '4bcd1ef555be766cd');
INSERT INTO kien_transaction VALUES('18', '0', '2013122000292701403766', '128760', '3', '1', '1', '0', '0', '2013-12-20', '1', '1', '', '', '1', '123.16.142.75', '96597370d5c8cf03d');
INSERT INTO kien_transaction VALUES('19', '0', '', '-1', '3', '25', '1', '0', '0', '2013-12-20', '0', '1', '', '', '0', '123.16.142.75', '043749885523d6a25');
INSERT INTO kien_transaction VALUES('20', '0', '', '-1', '3', '41', '1', '0', '0', '2013-12-20', '0', '1', '', '', '0', '123.16.142.75', 'a925508f7c1f9579a');
INSERT INTO kien_transaction VALUES('21', '0', '2013122009035892073749', '207414', '3', '46', '1', '0', '0', '2013-12-20', '1', '1', '0932235947', '', '1', '118.71.206.60', '4dc13885a37ce8d81');
INSERT INTO kien_transaction VALUES('22', '0', '', '-1', '3', '46', '1', '0', '0', '2013-12-20', '0', '1', '', '', '0', '113.22.39.207', 'c22149d77babee96d');
INSERT INTO kien_transaction VALUES('23', '0', '', '-1', '3', '46', '1', '0', '0', '2013-12-20', '0', '1', '', '', '0', '113.22.39.207', '7ca1aea43ce848496');
INSERT INTO kien_transaction VALUES('24', '0', '', '-1', '3', '46', '1', '0', '0', '2013-12-20', '0', '1', '', '', '0', '113.22.39.207', '48e7891e66c54191b');
INSERT INTO kien_transaction VALUES('25', '0', '2013122009194654968937', '207416', '3', '46', '1', '0', '0', '2013-12-20', '1', '1', '0932235947', '', '1', '113.22.39.207', '3369ce542e8f2322d');
INSERT INTO kien_transaction VALUES('26', '0', '2013122015283260425759', '207418', '3', '9', '1', '0', '0', '2013-12-20', '1', '1', '0902121177', '', '1', '1.55.139.64', '99bb03d998e631860');
INSERT INTO kien_transaction VALUES('27', '0', '2013122015285770007997', '128764', '3', '9', '2', '0', '0', '2013-12-20', '1', '1', '', '', '1', '1.55.139.64', 'c84374c8919d2074e');
INSERT INTO kien_transaction VALUES('28', '0', '', '-1', '5', '10', '1', '0', '0', '2013-12-20', '0', '1', '', '', '0', '183.81.54.190', '6d665453cfb2e55f0');
INSERT INTO kien_transaction VALUES('29', '0', '2013122016451102491391', '207419', '3', '8', '1', '0', '0', '2013-12-20', '1', '1', '0902121177', '', '1', '183.81.54.190', 'ce35fa99fa4161c65');
INSERT INTO kien_transaction VALUES('30', '0', '2013122016480363934460', '128766', '3', '19', '2', '0', '0', '2013-12-20', '1', '1', '', '', '1', '183.81.54.190', '40f3bc04f65b7a357');

DROP TABLE IF EXISTS kien_user_bank;
CREATE TABLE kien_user_bank (
   id int(11) NOT NULL auto_increment,
   userid int(11) NOT NULL,
   bankid int(11) NOT NULL,
   bank_number varchar(15) NOT NULL,
   mattruoc varchar(200) NOT NULL,
   matsau varchar(200) NOT NULL,
   publish tinyint(1) NOT NULL,
   PRIMARY KEY (id),
   KEY userid (userid),
   KEY bankid (bankid)
);

INSERT INTO kien_user_bank VALUES('1', '2', '1', '123456789', '1384767639.jpg', '1384767639.jpg', '1');
INSERT INTO kien_user_bank VALUES('2', '2', '2', '26827689027', '1384767829.jpg', '1384767829.jpg', '1');
INSERT INTO kien_user_bank VALUES('3', '2', '2', '1561798619', '1384768369.jpg', '1384768369.jpg', '1');
INSERT INTO kien_user_bank VALUES('4', '4', '1', '20098712345', '1386219493.jpg', '1386219493.jpg', '1');
INSERT INTO kien_user_bank VALUES('5', '2', '5', '309276920', '1387148742.jpg', '1387148742.jpg', '0');
INSERT INTO kien_user_bank VALUES('6', '2', '1', '609716176109876', '1387149062.jpg', '1387149062.jpg', '0');
INSERT INTO kien_user_bank VALUES('7', '3', '1', '342967927620896', '1387186426.jpg', '1387186427.jpg', '1');

DROP TABLE IF EXISTS kien_users;
CREATE TABLE kien_users (
   Pass varchar(48) NOT NULL,
   User varchar(24) NOT NULL,
   FullName varchar(32) NOT NULL,
   tmpname varchar(32) NOT NULL,
   SuperUser tinyint(1) unsigned NOT NULL,
   logon int(11) unsigned NOT NULL,
   logout int(11) unsigned NOT NULL,
   Active tinyint(1) unsigned NOT NULL,
   PRIMARY KEY (User),
   KEY User (User)
);

INSERT INTO kien_users VALUES('21232f297a57a5a743894a0e4a801fc3', 'admin', 'LÊ V?N KIÊN', 'Administrator', '1', '1387590449', '1369713925', '1');

DROP TABLE IF EXISTS kien_videos;
CREATE TABLE kien_videos (
   vdid smallint(6) unsigned NOT NULL auto_increment,
   CatId int(6) unsigned NOT NULL,
   Correlate int(6) unsigned NOT NULL,
   creator varchar(100) NOT NULL,
   videos varchar(132) NOT NULL,
   vdname varchar(32) NOT NULL,
   author varchar(128) NOT NULL,
   sort smallint(6) unsigned NOT NULL,
   PRIMARY KEY (vdid)
);

INSERT INTO kien_videos VALUES('20', '0', '0', 'D', 'L2k5kKK4owk', 'Qu?ng cáo Coca Cola', 'admin', '1');
INSERT INTO kien_videos VALUES('21', '0', '0', 'd', '118sAW6KHNs', 'Quang Cao giay Clever Up', 'admin', '1');
INSERT INTO kien_videos VALUES('22', '0', '0', 'd', 'uzL1ZaEHzZ8', 'Double A Paper - Girl on the Cop', 'admin', '1');
INSERT INTO kien_videos VALUES('23', '0', '0', 'd', 'InNUPo9fqWI', 'Beeline Big Zero TVC', 'admin', '1');
INSERT INTO kien_videos VALUES('24', '0', '0', 'D', 'TZUwzQKQC08', 'Video Latca L32', 'admin', '1');
INSERT INTO kien_videos VALUES('25', '0', '0', 'H', 'prjeaiG4Pmo', '?êm H?i Ng? Cùng Các Ngôi Sao', 'admin', '1');
INSERT INTO kien_videos VALUES('26', '0', '0', 'hg', 'qnRHT-Urmrw', 'I Storm Mobile', 'admin', '1');
INSERT INTO kien_videos VALUES('27', '0', '0', 'hg', 'YCPUBvfVpEs', 'Menu littlegon', 'admin', '1');
INSERT INTO kien_videos VALUES('30', '0', '45', '?i?n toán ?ám mây', 'EJ9oJ6DYWHo', '?i?n toán ?ám mây', 'admin', '1');
INSERT INTO kien_videos VALUES('31', '0', '45', '?i?n toán ?ám mây', 'Ro6Z3d2jdoc', '?i?n toán ?ám mây', 'admin', '1');
INSERT INTO kien_videos VALUES('40', '0', '21', 'VTC1', 'UDf-aMdNvTw', 'B?n tin công ngh? thông tin ICT', 'admin', '1');
INSERT INTO kien_videos VALUES('41', '0', '41', 'Qu?ng Bá Tên Mi?n Ti?ng Vi?t', 'kgJtRoMfMlI', 'Qu?ng Bá Tên Mi?n Ti?ng Vi?t', 'admin', '1');

DROP TABLE IF EXISTS kien_yahoo;
CREATE TABLE kien_yahoo (
   id smallint(6) unsigned NOT NULL auto_increment,
   yahooname varchar(128) NOT NULL,
   nickname text NOT NULL,
   thutu smallint(6) unsigned NOT NULL,
   PRIMARY KEY (id)
);

INSERT INTO kien_yahoo VALUES('63', '090212 1177', 'hoanggiasoft', '1');
INSERT INTO kien_yahoo VALUES('65', '0906 292 000', 'hoanggiaad', '1');
INSERT INTO kien_yahoo VALUES('66', 'lê v?n kiên', 'levankien_cntt', '1');

