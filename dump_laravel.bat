@echo off
setlocal EnableExtensions EnableDelayedExpansion

REM arg 1 = root proyek, default "."
set "ROOT=%~1"
if "%ROOT%"=="" set "ROOT=."
for %%I in ("%ROOT%") do set "ROOT=%%~fI"

REM arg 2 = output file, default "laravel_code_dump.txt"
set "OUT=%~2"
if "%OUT%"=="" set "OUT=laravel_code_dump.txt"

REM kalau OUT relatif, taruh di ROOT
if not "%OUT:~1,1%"==":" (
  if not "%OUT:~0,2%"=="\\" set "OUT=%ROOT%\%OUT%"
)

REM Argumen opsional lanjutan (ExcludeDirs/ExcludeNames/MaxSizeMB)
set "EXTRA_ARGS=%~3 %~4 %~5 %~6 %~7 %~8 %~9"

set "SELF=%~dp0"

REM Prefer pwsh (PowerShell 7+) kalau ada, fallback ke powershell (5.1)
where pwsh >nul 2>nul
if %ERRORLEVEL%==0 (
  set "PS=pwsh -NoProfile"
) else (
  set "PS=powershell -NoProfile"
)

%PS% -ExecutionPolicy Bypass -File "%SELF%dump_laravel.ps1" -Root "%ROOT%" -OutFile "%OUT%" -Debug %EXTRA_ARGS%

echo.
if exist "%OUT%" (
  echo ===== Preview (top 50 lines) =====
  %PS% -Command "Get-Content -LiteralPath '%OUT%' -TotalCount 50 | Out-String"
  echo ==================================
  echo Selesai. Output: %OUT%
) else (
  echo Gagal: file output tidak ditemukan: %OUT%
  echo Cek hak akses folder dan path ROOT: %ROOT%
)
echo.
endlocal
