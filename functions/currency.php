<?php
function format_rupiah($nilai){
    return "Rp " . number_format($nilai, 0, ',', '.');
}