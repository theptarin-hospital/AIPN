<html>
<head>
<title>Phatara-thonburi AIPN </title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
</head>
<body>
<?php
        require_once 'aipn.php';
        // นำเข้าข้อมูล
 set_time_limit(0); // ตั้งค่า executime no limit

$objConnect = mysqli_connect("localhost","root","phatara","aipn") or die("Error Connect to Database"); // Conect to MySQL

mysqli_set_charset($objConnect, "utf8");  //กำหนดการเก็บค่าภาษาไทย

// ล้างข้อมูลก่อนนำรายการเข้าฐาน
$strSQL = "delete from aipn_ipadt";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from aipn_ipdx";
$objQuery = mysqli_query($objConnect,$strSQL);
$strSQL = "alter table aipn_ipdx drop sequence";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from aipn_ipop";
$objQuery = mysqli_query($objConnect,$strSQL);
$strSQL = "alter table aipn_ipop drop sequence";
$objQuery = mysqli_query($objConnect,$strSQL);


$strSQL = "delete from aipn_billitems";
$objQuery = mysqli_query($objConnect,$strSQL);
$strSQL = "alter table aipn_billitems drop sequence";
$objQuery = mysqli_query($objConnect,$strSQL);

// import for aipn_ipadt
$objCSV = fopen("C:\\AIPN_CSV\\DATA01_IPADT.csv", "r");
$headerLine = true; //กำหนดค่า headerline เพื่อไม่ต้องนำเข้า header ของไฟล์ CSV
while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipadt (Hmain,HCare,CareAs,RIGHTS,CONTRACT,AN,HN,IDTYPE,PIDPAT,TITLE,NAMEPAT,DOB,SEX,MARRIAGE,CHANGWAT,AMPHUR,NATION,AdmType,AdmSource,DTAdm,DTDisch,LeaveDay,DischStat,DischType,AdmWt,DischWard,Dept,RECEIPT_DATE,Invoice,Amount,UPayPlan,ServiceType,ServiceSubType,ProjectCode,EventCode,UserReserve) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]','$objArr[6]','$objArr[7]','$objArr[8]','$objArr[9]','$objArr[10]','$objArr[11]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[15]','$objArr[16]','$objArr[17]','$objArr[18]','$objArr[19]','$objArr[20]','$objArr[21]','$objArr[22]','$objArr[23]','$objArr[24]','$objArr[25]','$objArr[26]','$objArr[27]','$objArr[28]','$objArr[29]','$objArr[30]','$objArr[31]','$objArr[32]','$objArr[33]','$objArr[34]','$objArr[35]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}  
//	echo $strSQL;
}
fclose($objCSV);

echo "นำเข้าข้อมูล  DATA01_IPADT.csv Done.<br>";

// import for aipn_ipdx for Code1 $objArr[3]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipdx (AN,DxType,CodeSys,Code,DiagTerm,DR,DateDiag) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[9]','$objArr[10]','$objArr[11]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

// import for aipn_ipdx for Code2 $objArr[4]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipdx (AN,DxType,CodeSys,Code,DiagTerm,DR,DateDiag) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[4]','$objArr[9]','$objArr[10]','$objArr[11]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

// import for aipn_ipdx for Code3 $objArr[5]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipdx (AN,DxType,CodeSys,Code,DiagTerm,DR,DateDiag) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[5]','$objArr[9]','$objArr[10]','$objArr[11]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

// import for aipn_ipdx for Code4 $objArr[6]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipdx (AN,DxType,CodeSys,Code,DiagTerm,DR,DateDiag) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[6]','$objArr[9]','$objArr[10]','$objArr[11]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

// import for aipn_ipdx for Code5 $objArr[7]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipdx (AN,DxType,CodeSys,Code,DiagTerm,DR,DateDiag) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[7]','$objArr[9]','$objArr[10]','$objArr[11]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

// import for aipn_ipdx for Code6 $objArr[8]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipdx (AN,DxType,CodeSys,Code,DiagTerm,DR,DateDiag) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[8]','$objArr[9]','$objArr[10]','$objArr[11]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

echo "นำเข้าข้อมูล  DATA02_ICD.csv สำหรับ aipn_ipdx เสร็จสมบูรณ์. <br>";

// import for aipn_ipop for Code1 $objArr[3]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipop (AN,CodeSys,Code,ProcTerm,DR,DateIn,DateOut,Location,DxType) VALUES ('$objArr[0]','$objArr[2]','$objArr[3]','$objArr[9]','$objArr[10]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[1]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

// import for aipn_ipop for Code2 $objArr[4]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipop (AN,CodeSys,Code,ProcTerm,DR,DateIn,DateOut,Location,DxType) VALUES ('$objArr[0]','$objArr[2]','$objArr[4]','$objArr[9]','$objArr[10]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[1]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

// import for aipn_ipop for Code3 $objArr[5]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipop (AN,CodeSys,Code,ProcTerm,DR,DateIn,DateOut,Location,DxType) VALUES ('$objArr[0]','$objArr[2]','$objArr[5]','$objArr[9]','$objArr[10]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[1]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

// import for aipn_ipop for Code4 $objArr[6]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipop (AN,CodeSys,Code,ProcTerm,DR,DateIn,DateOut,Location,DxType) VALUES ('$objArr[0]','$objArr[2]','$objArr[6]','$objArr[9]','$objArr[10]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[1]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

// import for aipn_ipop for Code5 $objArr[7]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipop (AN,CodeSys,Code,ProcTerm,DR,DateIn,DateOut,Location,DxType) VALUES ('$objArr[0]','$objArr[2]','$objArr[7]','$objArr[9]','$objArr[10]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[1]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

// import for aipn_ipop for Code6 $objArr[8]
$objCSV = fopen("C:\\AIPN_CSV\\DATA02_ICD.csv", "r");
$headerLine = true;

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_ipop (AN,CodeSys,Code,ProcTerm,DR,DateIn,DateOut,Location,DxType) VALUES ('$objArr[0]','$objArr[2]','$objArr[8]','$objArr[9]','$objArr[10]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[1]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

echo "นำเข้าข้อมูล  DATA02_ICD.csv สำหรับ aipn_ipop เสร็จสมบูรณ์. <br>";

// import for BillItems
$objCSV = fopen("C:\\AIPN_CSV\\DATA03_BillItems.csv", "r");
$headerLine = true; //กำหนดค่า headerline เพื่อไม่ต้องนำเข้า header ของไฟล์ CSV

while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	if($headerLine) {$headerLine = false;}
	else{
	$strSQL = "INSERT INTO aipn_billitems (BillNo,AN,ServDate,BillGr,LCCode,Descript,QTY,UnitPrice,ChargeAmt,Discount,ProcedureSeq,DiagnosisSeq,ClaimSys,BillGrCs,CSCode,CodeSys,STDCode,ClaimCat,DateRev,ClaimUP,ClaimAmt,PRXDOC) VALUES ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]','$objArr[6]','$objArr[7]','$objArr[8]','$objArr[9]','$objArr[10]','$objArr[11]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[15]','$objArr[16]','$objArr[17]','$objArr[18]','$objArr[19]','$objArr[20]','$objArr[21]') ";
	$objQuery = mysqli_query($objConnect,$strSQL);}
//	echo $strSQL;
}
fclose($objCSV);

echo "นำเข้าข้อมูล  DATA03_BillItems.csv เสร็จสมบูรณ์.<br>";

// ปรับปรุงข้อมูล หลังนำเข้า
$strSQL = "delete from aipn_ipadt where RIGHTS <> 6";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from aipn_ipdx where DxType = '6' or Code = ''";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "delete from aipn_ipop where DxType <> '6' or Code = ''";
$objQuery = mysqli_query($objConnect,$strSQL);

echo "ปรับปรุงข้อมูล Done. <br>";

// สร้าง Sequence no สำหรับ ipdx ipop billitem
$strSQL = "alter table aipn_ipdx add column sequence int , order by DxType";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "SET @rank=0";
$objQuery = mysqli_query($objConnect,$strSQL);
$strSQL = "update aipn_ipdx set sequence = @rank:=@rank+1";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "alter table aipn_ipop add column sequence int auto_increment primary key";
$objQuery = mysqli_query($objConnect,$strSQL);

$strSQL = "alter table aipn_billitems add column sequence int auto_increment primary key";
$objQuery = mysqli_query($objConnect,$strSQL);

echo "สร้าง ลำดับที่  Done. <br>";

$strSQL = "select * from aipn_running";
$objQuery = mysqli_query($objConnect,$strSQL);
$row_ = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);
foreach($row_ as $row){
    echo 'ไฟล์ส่ง AIPN ครั้งก่อน 14354AIPN';	
	echo($row['last_number']);
}


//$strSQL = "update aipn_running set last_number = last_number:=last_number+1";
//$objQuery = mysqli_query($objConnect,$strSQL);

        //สร้าง AIPN ไฟล
echo ' ไฟล์เบิกประกันสังคม AIPN ';

// เพิ่มค่า +1 สำหรับรูปแบบ zip file 14354AIPN10001
$last_number = $row['last_number'] + 1;
//$id = '1000'.$last_number;
$id = $last_number;
$my = new cipn_xlm('5800001');
$my->save();
$link= "http://localhost/PhataraAIPN/".$my->save_zip($id);
//$my->save_zip($id);

$strSQL = "update aipn_running set last_number = " . $last_number;
$objQuery = mysqli_query($objConnect,$strSQL);

// ปรับค่า จาก 99999 เป็น ค่าเริ่มต้น 10000
$strSQL = "update aipn_running set last_number =if(last_number =99999,10000,last_number)";
$objQuery = mysqli_query($objConnect,$strSQL);

?>
        <a href="<?php echo $link;?>"><?php echo $link;?></a>

</table>
</body>
</html>

