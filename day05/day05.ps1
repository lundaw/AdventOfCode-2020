$seatsData = Get-Content "seats.txt" | ForEach-Object {
    # $_ is the pipeline element
    # 2 is the fromBase argument
    [convert]::ToInt32(($_ -replace "B|R",1 -replace "F|L",0), 2)
} | Sort-Object # and also sort in ascending order

# Since the values are in ascending order, we can index the last element now to get the
# result for the largest seat ID.
Write-Host ("Largest seat ID: " + $seatsData[-1])

# To get the missing seat ID, generate a range from the smallest to the largest and
# get the differnce of the two.
$missing = $seatsData[0]..$seatsData[-1] | where {$_ -notin $seatsData}
Write-Host ("Missing seat ID: " + $missing)