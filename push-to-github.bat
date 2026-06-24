@echo off
REM ===================================================================
REM Script untuk Push Progress ke GitHub
REM Repository: https://github.com/Zephyrr-hash/simagang.git
REM ===================================================================

echo.
echo ========================================
echo   SIMAGANG - Push to GitHub
echo ========================================
echo.

REM Check if git is installed
where git >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Git tidak terinstall!
    echo.
    echo Silakan install Git terlebih dahulu:
    echo https://git-scm.com/download/win
    echo.
    pause
    exit /b 1
)

echo [1/5] Checking git status...
git status
echo.

echo [2/5] Staging all changes...
git add .
echo.

echo [3/5] Creating commit...
set /p COMMIT_MSG="Enter commit message (or press Enter for default): "
if "%COMMIT_MSG%"=="" (
    set COMMIT_MSG=feat: update features - activity logs, data isolation, and maps fix
)
git commit -m "%COMMIT_MSG%"
echo.

echo [4/5] Pushing to GitHub...
echo Repository: https://github.com/Zephyrr-hash/simagang.git
echo Branch: main
echo.
git push origin main
echo.

if %ERRORLEVEL% EQU 0 (
    echo [5/5] SUCCESS! Changes pushed to GitHub
    echo.
    echo View your repository at:
    echo https://github.com/Zephyrr-hash/simagang
) else (
    echo [5/5] FAILED! Push unsuccessful
    echo.
    echo Common issues:
    echo - Need to authenticate ^(use Personal Access Token^)
    echo - No remote configured
    echo - Conflicts with remote
    echo.
    echo See GIT_PUSH_GUIDE.md for troubleshooting
)

echo.
pause
