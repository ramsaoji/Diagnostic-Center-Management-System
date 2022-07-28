@echo off
for /F "tokens=2" %%i in ('date /t') do set mydate=%%i
set mydate=%mydate:/=-%
set mytime=%time::=-%
set filename=%mydate%-%mytime%.txt
cd C:\xampp\
start /min "" xampp_start.exe

cd C:\xampp\mysql\bin 
mysqldump --user=root --password="" krishna_hospital > C:/krishna_hospital_backup/main_db_backup/Main_db_hospital_%filename%.sql

mysqldump --user=root --password="" backup_krishna_hospital > C:/krishna_hospital_backup/backup_db_backup/Backup_db_hospital_%filename%.sql

mysql  --user=root --password="" krishna_hospital -e "DELETE FROM patient WHERE Record_date < now() - INTERVAL 3 MONTH;"

exit