@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../johnbillion/wp-hooks-generator/bin/wp-hooks-generator
php "%BIN_TARGET%" %*
