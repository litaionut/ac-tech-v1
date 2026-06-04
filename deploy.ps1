# Deploy AC-Tech theme to Bluehost via FTP (curl).
# Usage: .\deploy.ps1

$ErrorActionPreference = 'Stop'
$ThemeRoot = $PSScriptRoot
$EnvFile = Join-Path $ThemeRoot '.env.deploy'

if (-not (Test-Path $EnvFile)) {
	Write-Error "Missing .env.deploy - copy .env.deploy.example and add your credentials."
}

$config = @{}
Get-Content $EnvFile | ForEach-Object {
	if ($_ -match '^\s*#' -or $_ -match '^\s*$') { return }
	if ($_ -match '^([^=]+)=(.*)$') {
		$config[$Matches[1].Trim()] = $Matches[2].Trim()
	}
}

$hostName = $config['FTP_HOST']
if (-not $hostName) { $hostName = $config['SFTP_HOST'] }
$userName = $config['FTP_USER']
if (-not $userName) { $userName = $config['SFTP_USER'] }
$password = $config['FTP_PASS']
if (-not $password) { $password = $config['SFTP_PASS'] }
$remotePath = $config['REMOTE_PATH'].Trim('/')

if (-not $hostName -or -not $userName -or -not $password -or -not $remotePath) {
	Write-Error ".env.deploy must define FTP_HOST (or SFTP_HOST), FTP_USER, FTP_PASS, REMOTE_PATH"
}

function Get-FtpUrlPart {
	param([string]$Value)
	return [System.Uri]::EscapeDataString($Value)
}

$userPart = Get-FtpUrlPart $userName
$passPart = Get-FtpUrlPart $password
$ftpBase = "ftp://${userPart}:${passPart}@${hostName}"

Write-Host "Deploying theme to ftp://${hostName}/${remotePath} ..." -ForegroundColor Cyan

$remoteDeletes = @(
	'assets/images/home/hero-hvac-400.webp'
)

foreach ($relativeDelete in $remoteDeletes) {
	$deletePath = "$remotePath/$relativeDelete"
	$deleteResult = curl.exe -s --ftp-pasv -Q "DELE $deletePath" "$ftpBase/" 2>&1
	if ($LASTEXITCODE -eq 0) {
		Write-Host "  deleted remote: $relativeDelete" -ForegroundColor Yellow
	} else {
		Write-Host "  delete skipped (not on server?): $relativeDelete" -ForegroundColor DarkGray
	}
}

$exclude = @('.git', 'node_modules', 'vendor', '.env.deploy', '.env.deploy.example', 'deploy.ps1', '.gitignore')
$files = Get-ChildItem -Path $ThemeRoot -Recurse -File | Where-Object {
	$relative = $_.FullName.Substring($ThemeRoot.Length + 1)
	$parts = $relative -split '[\\/]'
	-not ($parts | Where-Object { $exclude -contains $_ })
}

$uploaded = 0
foreach ($file in $files) {
	$relative = $file.FullName.Substring($ThemeRoot.Length + 1).Replace('\', '/')
	$remoteFile = "$remotePath/$relative"
	$remoteUrl = "$ftpBase/$remoteFile"

	$result = curl.exe -s --ftp-pasv -T $file.FullName $remoteUrl --ftp-create-dirs 2>&1
	if ($LASTEXITCODE -ne 0) {
		Write-Error "Upload failed for $relative`: $result"
	}

	Write-Host "  uploaded: $relative" -ForegroundColor DarkGray
	$uploaded++
}

Write-Host "Done - $uploaded file(s) uploaded." -ForegroundColor Green
Write-Host "Activate the theme at: Appearance -> Themes (if not already active)." -ForegroundColor Yellow
Write-Host "If images look stale on live, purge Cloudflare cache for /wp-content/themes/ac-tech/assets/images/" -ForegroundColor Yellow
