<?php
 $db_server_name = "localhost";
 $db_user_name ="root";
 $db_password ="pwdpwd";
 $dbh = mysqli_connect($db_server_name,$db_user_name,$db_password);
 if (!$dbh)     
 die("Unable to connect to MySQL: " . mysqli_error($dbh));
    // Nếu kết nối thất bại thì đưa ra thông báo lỗi
    
 if (!mysqli_select_db($dbh,'test'))     
 die("Unable to select database: " . mysqli_error($dbh));

 //CREATE TABLE

 $sql_KH = "CREATE table KHACHHANG(
    MAKH char(4) not null PRIMARY key,
    HOTEN varchar(40) not null,
    DIACHI varchar(50) not null,
    SODT varchar(20) not null,    
    NGAYSINH datetime,
    DOANHSO float,
    NGDK datetime
    );";

$sql_NV = "CREATE table NHANVIEN(
    MANV char(4) not null PRIMARY key,
    HOTEN varchar(40) not null,
    NGVL datetime,
    SODT varchar(20) not null
    );";

$sql_SP = "CREATE table SANPHAM(
    MASP char(4) not null PRIMARY key,
    TENSP varchar(40) not null,
    DVT varchar(10) not null,
    NUOCSX varchar(20) not null,
    GIA float
    );";

$sql_HD = "CREATE table HOADON(
    SOHD char(4) not null PRIMARY key,
    NGHD datetime,
    MAKH char(4) not null,
    MANV char(4) not null,
    TRIGIA float,
    FOREIGN KEY (MAKH) REFERENCES KHACHHANG(MAKH),
    FOREIGN KEY (MANV) REFERENCES NHANVIEN(MANV)
    );";

$sql_CTHD = "CREATE table CTHD(
    MACTHD char(4) not null PRIMARY key,
    SOHD char(4) not null,
    MASP char(4) not null,
    SOLUONG int,
    FOREIGN KEY (SOHD) REFERENCES HOADON(SOHD),
    FOREIGN KEY (MASP) REFERENCES SANPHAM(MASP)
    );";
 
$result = mysqli_query($dbh, $sql_KH); // Thực thi câu lệnh SQL

if (!$result) {
    die("Create failed table KHACHHANG: " . mysqli_error($dbh)); 
    // Thông báo lỗi nếu thực thi câu lệnh thất bại
} else {
    echo "Create success KHACHHANG <br>";
}

$result = mysqli_query($dbh, $sql_NV); // Thực thi câu lệnh SQL

if (!$result) {
    die("Create failed table NHANVIEN: " . mysqli_error($dbh)); 
    // Thông báo lỗi nếu thực thi câu lệnh thất bại
} else {
    echo "Create success NHANVIEN <br>";
}


$result = mysqli_query($dbh, $sql_SP); // Thực thi câu lệnh SQL

if (!$result) {
    die("Create failed table SANPHAM: " . mysqli_error($dbh)); 
    // Thông báo lỗi nếu thực thi câu lệnh thất bại
} else {
    echo "Create success SANPHAM <br>";
}

$result = mysqli_query($dbh, $sql_HD); // Thực thi câu lệnh SQL

if (!$result) {
    die("Create failed table HOADON: " . mysqli_error($dbh)); 
    // Thông báo lỗi nếu thực thi câu lệnh thất bại
} else {
    echo "Create success HOADON <br>";
}

$result = mysqli_query($dbh, $sql_CTHD); // Thực thi câu lệnh SQL

if (!$result) {
    die("Create failed table CHITIETHOADON: " . mysqli_error($dbh)); 
    // Thông báo lỗi nếu thực thi câu lệnh thất bại
} else {
    echo "Create success CHITIETHOADON <br><br>";
}

//INTERT DATA

$sql_KH = "INSERT INTO khachhang (MAKH,HOTEN,DIACHI,SODT,NGAYSINH,DOANHSO,NGDK)
                values ('KH01','Nguyen Van A','Thanh Xuan, HN','0999888777','2002-10-01','13000000','2009-10-01'),
                ('KH02','Nguyen Van B','Thanh Xuan, HN','0999888777','2002-08-01','5000000','2009-10-01'),
                ('KH03','Nguyen Van C','Cau Giay, HN','0999888776','2002-07-01','6000000','2009-10-01'),
                ('KH04','Nguyen Van D','Dong Da, HN','0999888775','2002-12-01','70000','2009-10-01'),
                ('KH05','Nguyen Van E','Quan Hoa, HN','0999888774','2002-10-01','20000','2009-10-01'),
                ('KH06','Nguyen Van F','Hoang Mai, HN','0999888773','2002-10-01','6780000','2009-10-01'),
                ('KH07','Nguyen Van G','Hoa Lac, HN','0999888772','2002-10-01','5600000','2009-10-01'),
                ('KH08','Nguyen Van H','Thach That, HN','0999888771','2002-10-01','34000','2009-10-01'),
                ('KH09','Nguyen Van I','Trung Hoa, HN','0999888770','2002-10-01','17000000','2009-10-01'),
                ('KH10','Nguyen Van J','Hoan Kiem, HN','0999888769','2002-10-01','9000','2009-10-01')"; 

$sql_NV = "INSERT INTO nhanvien (MANV,HOTEN,NGVL,SODT)
                values ('NV01','Tran Van A','2009-10-01','0999888777'),
                ('NV02','Tran Van B','2009-10-01','0999888777'),
                ('NV03','Tran Van C','2009-10-01','0999888776'),
                ('NV04','Tran Van D','2009-10-01','0999888775'),
                ('NV05','Tran Van E','2009-10-01','0999888774')";

$sql_SP = "INSERT INTO sanpham (MASP,TENSP,DVT,NUOCSX,GIA)
                values ('BC01','But chi','cay','Viet Nam','3000'),
                ('BC02','But chi','cay','Viet Nam','3000'),
                ('BC03','But chi','cay','Sigapore','5000'),
                ('BC04','But chi','cay','Viet Nam','3000'),
                ('BC05','But chi','cay','Sigapore','5000'),
                ('BB01','But bi','cay','Trung Quoc','5000'),
                ('BB02','But bi','cay','Thai Lan','100000'),
                ('BB03','But bi','hop','Trung Quoc','2000')";

$sql_HD = "INSERT INTO hoadon (SOHD,NGHD,MAKH,MANV,TRIGIA)
                values ('1001','2012-10-01','KH01','NV01','320000'),
                ('1002','2012-10-01','KH01','NV02','530000'),
                ('1003','2012-10-01','KH02','NV01','450000'),
                ('1004','2012-10-01','KH02','NV03','630000'),
                ('1005','2012-10-01','KH01','NV01','455000'),
                ('1006','2012-10-01','KH03','NV02','560000'),
                ('1007','2012-10-01','KH03','NV03','1000000'),
                ('1008','2012-10-01','KH01','NV03','230000')";

$result = mysqli_query($dbh, $sql_KH); // Thực thi câu lệnh SQL
    
if (!$result) {
    die("Add failed table KHACHHANG: " . mysqli_error($dbh)); 
    // Thông báo lỗi nếu thực thi câu lệnh thất bại
} else {
    echo "Add success table KHACHHANG <br>";
}


$result = mysqli_query($dbh, $sql_NV); // Thực thi câu lệnh SQL
    
if (!$result) {
    die("Add failed table NHANVIEN: " . mysqli_error($dbh)); 
    // Thông báo lỗi nếu thực thi câu lệnh thất bại
} else {
    echo "Add success table NHANVIEN <br>";
}


$result = mysqli_query($dbh, $sql_SP); // Thực thi câu lệnh SQL
    
if (!$result) {
    die("Add failed table SANPHAM: " . mysqli_error($dbh)); 
    // Thông báo lỗi nếu thực thi câu lệnh thất bại
} else {
    echo "Add success table SANPHAM <br>";
}


$result = mysqli_query($dbh, $sql_HD); // Thực thi câu lệnh SQL
    
if (!$result) {
    die("Add failed table HOADON: " . mysqli_error($dbh)); 
    // Thông báo lỗi nếu thực thi câu lệnh thất bại
} else {
    echo "Add success table HOADON <br>";
}


?>