$input = Get-Content "input.txt" | ForEach-Object {
    [convert]::ToInt32($_)
}

:partOneOuter
foreach ($i in $input) {
    foreach ($j in $input) {
        if (($i + $j) -eq 2020) {
            Write-Host ("Part one: " + ($i * $j))
            break partOneOuter
        }
    }
}

:partTwoOuter
foreach ($i in $input) {
    foreach ($j in $input) {
        foreach ($k in $input) {
            if (($i + $j + $k) -eq 2020) {
                Write-Host ("Part two: " + ($i * $j * $k))
                break partTwoOuter
            }
        }
    }
}