<?php
$hotels = [
    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],
];

// Gestione dei filtri tramite richieste GET
// Creo una copia dell'array $hotels che potrà essere filtrata in base ai criteri selezionati dall'utente.
$filteredHotels = $hotels;

// Controllo che siano stati impostati i parametri GET 'parking' o 'vote'.
// La funzione isset() verifica se una variabile è stata definita ed è diversa da null.
if (isset($_GET['parking']) || isset($_GET['vote'])) { 

    // Se almeno uno dei filtri è impostato, utilizzo array_filter() per filtrare l'array $hotels.
    // array_filter() applica una funzione di callback a ogni elemento dell'array.

    $filteredHotels = array_filter($hotels, function ($hotel) {

        // Verifico se il filtro 'parking' è impostato. Se sì, controllo se il valore è '1' (vero) o '0' (falso).
        // Se non è impostato, considero il filtro come vero e non applico alcun filtro per il parcheggio).

        $parkingFilter = isset($_GET['parking']) ? $_GET['parking'] === '1' : true;

        // Verifico se il filtro 'vote' è impostato. Se sì, controllo se il voto dell'hotel è maggiore o uguale al valore specificato.
        // Se non è impostato, considero il filtro come vero enon applico alcun filtro

        $voteFilter = isset($_GET['vote']) ? $hotel['vote'] >= $_GET['vote'] : true;

        // Restituisco true solo se entrambi i filtri sono soddisfatti.

        return $parkingFilter && $voteFilter;

    });

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Hotel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Div che utilizza la classe 'container' di Bootstrap per centrare il contenuto e aggiungere margini -->
    <div class="container">

        <!-- Intestazione della pagina con un margine verticale per la spaziatura -->
        <h1 class="my-4">Lista Hotel</h1>
        
        <!-- Form per filtrare gli hotel con metodo GET-->
        <form method="GET" class="mb-4"> 

            <!-- Filtro per parcheggio -->
            <div class="form-group">

            
                <!-- titolo -->
                <label for="parking">Parcheggio</label>

                <!-- Menu a tendina -->
                <select name="parking" id="parking" class="form-control">

                    <!-- opzione 1 -->
                    <option value="">-</option>

                    <!-- opzione 2. "se parking è non è null e il suo valore è uno, allora è selezionato" -->
                    <option value="1" <?= isset($_GET['parking']) && $_GET['parking'] === '1' ? 'selected' : '' ?>>Sì</option>

                    <!-- idem cum patate -->
                    <option value="0" <?= isset($_GET['parking']) && $_GET['parking'] === '0' ? 'selected' : '' ?>>No</option>

                </select>

            </div>

            <!-- Filtro voto minimo degli hotel -->
            <div class="form-group">

                <!-- titolo -->
                <label for="vote">Voto minimo</label>

                <!-- input con metodo per selezionare il voto -->
                <input type="number" name="vote" id="vote" class="form-control" value="<?= isset($_GET['vote']) ? $_GET['vote'] : '' ?>">

            </div>

            <!-- Pulsante FILTRA per inviare il form e applicare i filtri -->
            <button type="submit" class="btn btn-primary">Filtra</button>

        </form>

        <!-- Tabella Bootstrap -->
        <table class="table table-striped">

            <!-- Intestazione tabella, sfondo scuro -->
            <thead class="thead-dark">

                <tr>
                    <!-- Intestazioni delle colonne della tabella -->
                    <th>Nome</th>
                    <th>Descrizione</th>
                    <th>Parcheggio</th>
                    <th>Voto</th>
                    <th>Distanza dal centro</th>

                </tr>

            </thead>

            <!-- Corpo della tabella dove appaiono i dati degli hotel -->
            <tbody>

                <!-- Ciclo PHP che itera attraverso ogni hotel nell'array filtrato $filteredHotels -->
                <?php foreach ($filteredHotels as $hotel) : ?>

                    <tr>
                        <!-- Cella che mostra il nome dell'hotel -->
                        <td><?= $hotel['name'] ?></td>

                        <!-- Cella che mostra la descrizione dell'hotel -->
                        <td><?= $hotel['description'] ?></td>

                        <!-- Cella che mostra se c'è parcheggio (Sì o No) usando un operatore ternario -->
                        <td><?= $hotel['parking'] ? 'Sì' : 'No' ?></td>

                        <!-- Cella che mostra il voto dell'hotel -->
                        <td><?= $hotel['vote'] ?></td>

                        <!-- Cella che mostra la distanza dal centro dell'hotel in km -->
                        <td><?= $hotel['distance_to_center'] ?> km</td>

                    </tr>

                <?php endforeach; ?>
                
            </tbody>

        </table>

    </div>

    
</body>
</html>
