::<?php echo "\r   \r"; if(0): ?>
@echo off
echo %cmdcmdline% | findstr /i /c:" /c" >nul
if %errorlevel%==0 goto:launch_cmd
goto :no_cmd
:launch_cmd
echo [92mEPX CMD Version 1.00 (C) Klude Pty Ltd. All Rights Reserved[0m
rem [92mLaunching cmd[0m
cmd /k
goto :exit_ok
:no_cmd
C:/xampp/current/php__xdbg/php.exe "%~f0" %*
::php "%~f0" %*
@exit /b 0
<?php endif;
include 'index.php';