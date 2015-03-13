@SCHTASKS /Create /RU "SYSTEM" /SC MINUTE /MO 5 /TN AutoCheckContract /TR "'C:\Program Files\Internet Explorer\iexplore.exe' http://localhost/autotestonline/sys_managers/check_contract"
