@echo off
for /F "tokens=2" %%i in ('date /t') do set mydate=%%i
set mydate=%mydate:/=-%
set mytime=%time::=-%
set filename=%mydate%-%mytime%.txt

cd C:\xampp\
start /min "" xampp_start.exe

start "" chrome.exe http://localhost/hospital/admin/

cd C:\xampp\mysql\bin 
mysqldump --user=root --password="" krishna_hospital > C:/krishna_hospital_backup/daily_main_db_backup/Daily_main_hospital_%filename%.sql

exit
