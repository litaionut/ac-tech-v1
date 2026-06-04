# Creează repo GitHub (manual) și face primul push.
# Rulează din rădăcina temei: .\scripts\setup-github.ps1

$ErrorActionPreference = 'Stop'
$ThemeRoot = Split-Path $PSScriptRoot -Parent

Set-Location $ThemeRoot

$owner = 'litaionut'
$repo = 'ac-tech'
$remoteUrl = "https://github.com/${owner}/${repo}.git"

Write-Host "Tema: $ThemeRoot"
Write-Host "Remote: $remoteUrl"
Write-Host ""

$remotes = git remote 2>$null
if ($remotes -notcontains 'origin') {
	git remote add origin $remoteUrl
	Write-Host "Am adăugat remote origin."
} else {
	$current = (git remote get-url origin 2>$null)
	if ($current -ne $remoteUrl) {
		git remote set-url origin $remoteUrl
		Write-Host "Am actualizat URL origin."
	}
}

Write-Host ""
Write-Host "1) Deschide GitHub și creează repo GOL (fără README/license):"
Write-Host "   https://github.com/new?name=$repo&owner=$owner"
Write-Host "2) Autentifică-te (browser sau Git Credential Manager) dacă e nevoie."
Write-Host ""

Start-Process "https://github.com/new?name=$repo&owner=$owner"

Read-Host "Apasă Enter după ce ai creat repo-ul gol pe GitHub"

Write-Host "Push branch master..."
git push -u origin master

Write-Host "Push tag v1.10.4 (dacă există)..."
git push origin v1.10.4 2>$null

Write-Host ""
Write-Host "Gata. Repo: https://github.com/${owner}/${repo}"
