<?php

/**
 * Program K-Nearest Neighbors (KNN) untuk klasifikasi penyakit gula.
 * Implementasi menggunakan PHP.
 * 
 * Dibuat oleh Faiz a.k.a fey
 */

// Definisi Dataset
$dataset = [
    // Data terkait untuk tinggi, berat, lingkar perut, lingkar panggul, lemak, dan label.
    ['tinggi' => 162, 'berat' => 56, 'l_perut' => 74, 'l_panggul' => 90, 'lemak' => 31.7, 'label' => 'Penderita diabetes'],
    ['tinggi' => 156, 'berat' => 54, 'l_perut' => 74, 'l_panggul' => 88, 'lemak' => 31.0, 'label' => 'sehat'],
    ['tinggi' => 155, 'berat' => 55, 'l_perut' => 79, 'l_panggul' => 88, 'lemak' => 27.0, 'label' => 'Penderita diabetes'],
    ['tinggi' => 155, 'berat' => 55, 'l_perut' => 67, 'l_panggul' => 91, 'lemak' => 29.8, 'label' => 'sehat'],
    ['tinggi' => 151, 'berat' => 58, 'l_perut' => 77, 'l_panggul' => 99, 'lemak' => 34.4, 'label' => 'Penderita diabetes'],
    ['tinggi' => 153, 'berat' => 52, 'l_perut' => 72, 'l_panggul' => 89, 'lemak' => 31.0, 'label' => 'sehat'],
    ['tinggi' => 151.5, 'berat' => 58, 'l_perut' => 76, 'l_panggul' => 94, 'lemak' => 32.0, 'label' => 'Penderita diabetes'],
    ['tinggi' => 159, 'berat' => 49, 'l_perut' => 72, 'l_panggul' => 89, 'lemak' => 28.7, 'label' => 'sehat'],
    ['tinggi' => 150, 'berat' => 45, 'l_perut' => 66.5, 'l_panggul' => 84.5, 'lemak' => 25.6, 'label' => 'sehat'],
    ['tinggi' => 159, 'berat' => 49, 'l_perut' => 65, 'l_panggul' => 87, 'lemak' => 24.6, 'label' => 'sehat'],
    ['tinggi' => 161.5, 'berat' => 48, 'l_perut' => 69, 'l_panggul' => 87, 'lemak' => 25.3, 'label' => 'Kurang Gula atau hipoglikemi'],
    ['tinggi' => 160, 'berat' => 49, 'l_perut' => 62.5, 'l_panggul' => 88.5, 'lemak' => 23.9, 'label' => 'Kurang Gula atau hipoglikemi'],
    ['tinggi' => 155, 'berat' => 63, 'l_perut' => 76.5, 'l_panggul' => 95.5, 'lemak' => 38.0, 'label' => 'Penderita diabetes'],
    ['tinggi' => 148, 'berat' => 58, 'l_perut' => 77, 'l_panggul' => 84, 'lemak' => 36.4, 'label' => 'Penderita diabetes'],
    ['tinggi' => 151, 'berat' => 51, 'l_perut' => 70, 'l_panggul' => 83.5, 'lemak' => 29.6, 'label' => 'sehat'],
    ['tinggi' => 160, 'berat' => 45, 'l_perut' => 70, 'l_panggul' => 82, 'lemak' => 23.7, 'label' => 'Kurang Gula atau hipoglikemi'],
    ['tinggi' => 151.5, 'berat' => 62, 'l_perut' => 79, 'l_panggul' => 98, 'lemak' => 37.3, 'label' => 'Penderita diabetes'],
    ['tinggi' => 151.5, 'berat' => 43, 'l_perut' => 60, 'l_panggul' => 79, 'lemak' => 23.8, 'label' => 'Kurang Gula atau hipoglikemi'],
    ['tinggi' => 160, 'berat' => 70, 'l_perut' => 78, 'l_panggul' => 99, 'lemak' => 33.3, 'label' => 'Penderita diabetes'],
    ['tinggi' => 155, 'berat' => 47.5, 'l_perut' => 66, 'l_panggul' => 85.5, 'lemak' => 26.6, 'label' => 'sehat'],
    ['tinggi' => 154, 'berat' => 46, 'l_perut' => 64, 'l_panggul' => 84, 'lemak' => 27.0, 'label' => 'sehat'],
    ['tinggi' => 147.5, 'berat' => 48, 'l_perut' => 65.5, 'l_panggul' => 85.5, 'lemak' => 25.8, 'label' => 'Penderita diabetes'],
    ['tinggi' => 148, 'berat' => 46, 'l_perut' => 67, 'l_panggul' => 86, 'lemak' => 29.6, 'label' => 'sehat'],
    ['tinggi' => 148, 'berat' => 58, 'l_perut' => 74, 'l_panggul' => 83, 'lemak' => 32.3, 'label' => 'Penderita diabetes'],
    ['tinggi' => 155, 'berat' => 40, 'l_perut' => 62, 'l_panggul' => 73.5, 'lemak' => 20.0, 'label' => 'Kurang Gula atau hipoglikemi'],
    ['tinggi' => 173, 'berat' => 70, 'l_perut' => 75, 'l_panggul' => 90, 'lemak' => 31.0, 'label' => '???']
];

// Function untuk menghitung Euclidean distance
function euclideanDistance($a, $b)
{
    return sqrt(
        pow($a['tinggi'] - $b['tinggi'], 2) +
            pow($a['berat'] - $b['berat'], 2) +
            pow($a['l_perut'] - $b['l_perut'], 2) +
            pow($a['l_panggul'] - $b['l_panggul'], 2) +
            pow($a['lemak'] - $b['lemak'], 2)
    );
}

// Function untuk mencetak langkah-langkah perhitungan jarak
function printEuclideanCalculation($a, $b, $index, $label)
{
    echo "Perhitungan jarak Euclidean antara query point dan data point $index ($label):\n";
    echo "sqrt((" . $a['tinggi'] . " - " . $b['tinggi'] . ")^2 + (" . $a['berat'] . " - " . $b['berat'] . ")^2 + (" . $a['l_perut'] . " - " . $b['l_perut'] . ")^2 + (" . $a['l_panggul'] . " - " . $b['l_panggul'] . ")^2 + (" . $a['lemak'] . " - " . $b['lemak'] . ")^2)\n";
    echo "sqrt(" . pow($a['tinggi'] - $b['tinggi'], 2) . " + " . pow($a['berat'] - $b['berat'], 2) . " + " . pow($a['l_perut'] - $b['l_perut'], 2) . " + " . pow($a['l_panggul'] - $b['l_panggul'], 2) . " + " . pow($a['lemak'] - $b['lemak'], 2) . ")\n";
}

// KNN function
function knn($dataset, $query, $k)
{
    $distances = [];
    foreach ($dataset as $index => $datapoint) {
        if ($datapoint['label'] !== '???') {
            $distance = euclideanDistance($query, $datapoint);
            $distances[$index] = $distance;
        }
    }

    asort($distances);
    $neighbors = array_slice($distances, 0, $k, true);

    // Print distances
    echo "Jarak terdekat (k = $k):\n";
    foreach ($neighbors as $index => $distance) {
        echo "Data point " . ($index + 1) . " (" . $dataset[$index]['label'] . "): " . $distance . "\n";
    }
    echo "\n";

    $votes = [];
    foreach ($neighbors as $index => $distance) {
        $label = $dataset[$index]['label'];
        $votes[$label] = isset($votes[$label]) ? $votes[$label] + 1 : 1;
    }

    arsort($votes);
    return $votes;
}

// Set nilai K
$k = 5;

// Cari query point (Yang berlabel '???')
$query = null;
foreach ($dataset as $datapoint) {
    if ($datapoint['label'] === '???') {
        $query = $datapoint;
        break;
    }
}

if ($query) {
    echo "Query point ditemukan dengan atribut berikut:\n";
    echo "Tinggi: " . $query['tinggi'] . "\n";
    echo "Berat: " . $query['berat'] . "\n";
    echo "Lingkar Perut: " . $query['l_perut'] . "\n";
    echo "Lingkar Panggul: " . $query['l_panggul'] . "\n";
    echo "Lemak: " . $query['lemak'] . "\n\n";

    $distances = [];
    foreach ($dataset as $index => $datapoint) {
        if ($datapoint['label'] !== '???') {
            printEuclideanCalculation($query, $datapoint, $index + 1, $datapoint['label']);
            $distance = euclideanDistance($query, $datapoint);
            $distances[$index] = $distance;
            echo "= " . $distance . "\n\n";
        }
    }

    $votes = knn($dataset, $query, $k);
    $prediction = key($votes);
    echo "Label yang diprediksi untuk query point: " . $prediction . "\n";

    // Print votes
    echo "Votes ↓\n";
    foreach ($votes as $label => $count) {
        echo $label . ": " . $count . "\n";
    }
} else {
    echo "Query point tidak ditemukan dalam dataset.";
}
?>
