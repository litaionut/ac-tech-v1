# Download homepage images and export optimized WebP variants.
# Usage: .\scripts\optimize-home-images.ps1

$ErrorActionPreference = 'Stop'
$ScriptRoot = $PSScriptRoot
$PythonScript = Join-Path $ScriptRoot 'optimize_home_images.py'

if (-not (Test-Path $PythonScript)) {
	Write-Error "Missing $PythonScript"
}

Write-Host "Optimizing homepage images..." -ForegroundColor Cyan
python $PythonScript
if ($LASTEXITCODE -ne 0) {
	Write-Error "Image optimization failed."
}

$manifest = Join-Path $ScriptRoot 'home-images-manifest.json'
if (Test-Path $manifest) {
	$data = Get-Content $manifest -Raw | ConvertFrom-Json
	$count = ($data.sets.PSObject.Properties | Measure-Object).Count
	Write-Host "Done - $count image set(s), manifest at home-images-manifest.json" -ForegroundColor Green
}
