param(
  [string]$Root = ".",
  [string]$OutFile = "laravel_code_dump.txt",

  # Exclude dinamis
  [string[]]$ExcludeDirs  = @("database\seeders"),      # default: skip seeders
  [string[]]$ExcludeNames = @("package-lock.json"),     # default: skip lock raksasa

  # Limit ukuran per file (MB). 0 = tanpa limit.
  [int]$MaxSizeMB = 0,

  [switch]$Debug
)

function Log($msg) { if ($Debug) { Write-Host "[debug] $msg" -ForegroundColor Cyan } }

# ==== RelativePath kompatibel PS 5.1 dan PS 7+
$IsCore = $PSVersionTable.PSVersion.Major -ge 6
if ($IsCore) {
  function Get-RelativePath([string]$BasePath, [string]$FullPath) {
    return [System.IO.Path]::GetRelativePath((Resolve-Path -LiteralPath $BasePath).Path, (Resolve-Path -LiteralPath $FullPath).Path)
  }
} else {
  function Get-RelativePath([string]$BasePath, [string]$FullPath) {
    $base = (Resolve-Path -LiteralPath $BasePath).Path
    $full = (Resolve-Path -LiteralPath $FullPath).Path
    $baseUri = New-Object System.Uri($base + [System.IO.Path]::DirectorySeparatorChar)
    $fullUri = New-Object System.Uri($full)
    $relUri  = $baseUri.MakeRelativeUri($fullUri)
    [System.Uri]::UnescapeDataString($relUri.ToString()).Replace('/', [System.IO.Path]::DirectorySeparatorChar)
  }
}

# ==== Konfigurasi filter ====
$includeDirs  = @("app","routes","config","database","resources","bootstrap","public")
$includeFiles = @(
  "composer.json",
  "artisan","phpunit.xml","phpstan.neon","pint.json",
  "package.json","vite.config.js","vite.config.ts",
  "Dockerfile","docker-compose.yml","docker-compose.dev.yml","Makefile","Taskfile.yml",
  ".env.example","README.md"
)

# Ekstensi diizinkan (regex; termasuk .blade.php dan .env.example)
$allowExtRegex = '\.(php|blade\.php|json|ya?ml|xml|md|js|ts|vue|css|scss|sql|ini|conf|toml|env\.example|proto|cue)$'

# Direktori berisik bawaan
$baseSkip = '\.git|node_modules|vendor|storage|dist|bin|build|coverage'
# Tambahkan exclude dir custom jadi regex Windows path
if ($ExcludeDirs.Count -gt 0) {
  $extra = ($ExcludeDirs | ForEach-Object {
    [Regex]::Escape(($_ -replace '/','\'))
  }) -join '|'
  $skipDirRegex = "\\(?:$baseSkip|$extra)(\\|$)"
} else {
  $skipDirRegex = "\\(?:$baseSkip)(\\|$)"
}

# Buang nama file tertentu (bawaan + custom)
$denyNames = @("package-lock.json") + $ExcludeNames

# ==== Resolve path absolut & OutPath ====
$rootPath = (Resolve-Path -LiteralPath $Root).Path
$OutPath  = $OutFile
if (-not [System.IO.Path]::IsPathRooted($OutPath)) {
  $OutPath = Join-Path -Path $rootPath -ChildPath $OutFile
}
$null = New-Item -ItemType Directory -Path (Split-Path -Parent $OutPath) -Force

Log "Root    : $rootPath"
Log "OutPath : $OutPath"
Log "SkipDir : $skipDirRegex"
if ($ExcludeDirs)  { Log ("Extra Exclude Dirs : " + ($ExcludeDirs -join ", ")) }
if ($ExcludeNames) { Log ("Extra Exclude Names: " + ($ExcludeNames -join ", ")) }
if ($MaxSizeMB -gt 0) { Log "Max per-file size  : $MaxSizeMB MB" }

# ==== Header ====
"Dumping from: $rootPath"                                 | Out-File -FilePath $OutPath -Encoding utf8
"Generated at: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')" | Out-File -FilePath $OutPath -Append -Encoding utf8
""                                                        | Out-File -FilePath $OutPath -Append -Encoding utf8

# ==== Kumpulkan file ====
$all  = Get-ChildItem -LiteralPath $rootPath -Recurse -File -Force -ErrorAction SilentlyContinue
Log "All files found           : $($all.Count)"

# ==== Skip direktori berisik ====
$kept = $all | Where-Object { $_.FullName -replace '\\','\' -notmatch $skipDirRegex }
Log "After skip noisy dirs     : $($kept.Count)"

# ==== Tambah properti Rel relatif ke root ====
$kept = $kept | ForEach-Object {
  $_ | Add-Member -NotePropertyName Rel -NotePropertyValue (Get-RelativePath $rootPath $_.FullName) -PassThru
}

# ==== Filter hanya includeDirs atau includeFiles (root) ====
$kept = $kept | Where-Object {
  $rel = $_.Rel -replace '\\','/'
  $top = ($rel -split '/')[0]
  ($includeDirs -contains $top) -or ($includeFiles -contains $rel)
}
Log "After includeDirs/files    : $($kept.Count)"

# ==== Batasi public/ ke file penting saja ====
$kept = $kept | Where-Object {
  $rel = $_.Rel -replace '\\','/'
  if ($rel -like 'public/*') { return ($rel -match '^public/(index\.php|\.htaccess)$') }
  return $true
}
Log "After public restriction   : $($kept.Count)"

# ==== Whitelist ekstensi, tapi tetap ijinkan includeFiles ====
$kept = $kept | Where-Object {
  $rel = $_.Rel -replace '\\','/'
  ($rel -match $allowExtRegex) -or ($includeFiles -contains $rel)
}
Log "After extension whitelist  : $($kept.Count)"

# ==== Limit ukuran per file (opsional) ====
if ($MaxSizeMB -gt 0) {
  $maxBytes = $MaxSizeMB * 1MB
  $kept = $kept | Where-Object { $_.Length -le $maxBytes }
  Log "After max size filter      : $($kept.Count) (<= $MaxSizeMB MB)"
}

# ==== Buang by name (deny list) ====
if ($denyNames.Count -gt 0) {
  $denySet = [System.Collections.Generic.HashSet[string]]::new([StringComparer]::OrdinalIgnoreCase)
  $denyNames | ForEach-Object { [void]$denySet.Add($_) }
  $kept = $kept | Where-Object { -not $denySet.Contains($_.Name) }
  Log "After deny-names           : $($kept.Count)"
}

# ==== Jangan makan file output sendiri ====
$kept = $kept | Where-Object { $_.FullName -ne $OutPath }
Log "After drop self-outfile    : $($kept.Count)"

# ==== Tulis ====
$written = 0
foreach ($f in $kept) {
  try {
    "alamat file : $($f.FullName)" | Out-File -FilePath $OutPath -Append -Encoding utf8
    "===$($f.Name)==="             | Out-File -FilePath $OutPath -Append -Encoding utf8
    Get-Content -LiteralPath $f.FullName -Raw -ErrorAction SilentlyContinue | Out-File -FilePath $OutPath -Append -Encoding utf8
    "=============="               | Out-File -FilePath $OutPath -Append -Encoding utf8
    ""                             | Out-File -FilePath $OutPath -Append -Encoding utf8
    $written++
  } catch {
    if ($Debug) { Write-Host "[debug] Failed reading: $($f.FullName) -> $_" -ForegroundColor Yellow }
  }
}

"Total files written: $written" | Out-File -FilePath $OutPath -Append -Encoding utf8
if ($Debug) { Write-Host "[debug] Done. Wrote $written files." -ForegroundColor Green }
