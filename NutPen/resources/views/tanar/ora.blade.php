@extends('layout')

@section('navbar')
    <li class="nav-item">
        <a class="nav-link" href="/Dashboard">
            <i class="fa-solid fa-house-chimney"></i>
            Főoldal
            <span class="sr-only">(current)</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-circle-check"></i>
            <span>
                Értékelés <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/ertekeles">Listázás</a>
            <a class="dropdown-item" href="/ertekeles/tantargyvalaszt">Új</a>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/ora">
            <i class="fa-solid fa-clock"></i>
            Órarend
            <span class="sr-only">(current)</span>
        </a>
    </li>


    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-clipboard-question"></i>
            <span>
                Hiányzás/késés <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/hianyzas">Listázás</a>
            <a class="dropdown-item" href="/hianyzas/tantargyvalaszt">Új</a>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/diakok/tantargyvalaszt">
            <i class="fa-solid fa-users-between-lines"></i>
            Diákok
            <span class="sr-only">(current)</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog"></i>
            <span>
                Beállítások <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="/fiok">Fiók</a>
            <a class="dropdown-item" href="/logout">Kilépés</a>
        </div>
    </li>
@endsection

@section('content')
    <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
            <br>
        </div>
        <div class="col-12 tm-block-col">
            <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                <h2 class="tm-block-title">Órarend megtekintése</h2>
                <table id='dtBasicExample' class="table table-bordered table-striped table-sm ">
                    <thead>
                        <tr>
                            <th>Hétfő</th>
                            <th>Kedd</th>
                            <th>Szerda</th>
                            <th>Csütörtök</th>
                            <th>Péntek</th>
                            <th>Szombat</th>
                            <th>Vasárnap</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php
                            $hetnapja = [];

                            for ($i = 0; $i < 7; $i++) {
                                $a = [];
                                array_push($hetnapja, $a);
                            }

                            //0=hétfő, ....6=vasárnap
                            for ($i = 0; $i < count($orarend); $i++)
                            {
                                if ($datum[$i]->format('l') == 'Monday')
                                {
                                    array_push($hetnapja[0], (object) ['nev' => $orarend[$i]->nev, 'kezdet' => $orarend[$i]->kezdet, 'veg' => $orarend[$i]->veg]);
                                }
                                if ($datum[$i]->format('l') == 'Tuesday')
                                {
                                    array_push($hetnapja[1], (object) ['nev' => $orarend[$i]->nev, 'kezdet' => $orarend[$i]->kezdet, 'veg' => $orarend[$i]->veg]);
                                }
                                if ($datum[$i]->format('l') == 'Wednesday')
                                {
                                    array_push($hetnapja[2], (object) ['nev' => $orarend[$i]->nev, 'kezdet' => $orarend[$i]->kezdet, 'veg' => $orarend[$i]->veg]);
                                }
                                if ($datum[$i]->format('l') == 'Thursday')
                                {
                                    array_push($hetnapja[3], (object) ['nev' => $orarend[$i]->nev, 'kezdet' => $orarend[$i]->kezdet, 'veg' => $orarend[$i]->veg]);
                                }
                                if ($datum[$i]->format('l') == 'Friday')
                                {
                                    array_push($hetnapja[4], (object) ['nev' => $orarend[$i]->nev, 'kezdet' => $orarend[$i]->kezdet, 'veg' => $orarend[$i]->veg]);
                                }
                                if ($datum[$i]->format('l') == 'Saturday')
                                {
                                    array_push($hetnapja[5], (object) ['nev' => $orarend[$i]->nev, 'kezdet' => $orarend[$i]->kezdet, 'veg' => $orarend[$i]->veg]);
                                }
                                if ($datum[$i]->format('l') == 'Sunday')
                                {
                                    array_push($hetnapja[6], (object) ['nev' => $orarend[$i]->nev, 'kezdet' => $orarend[$i]->kezdet, 'veg' => $orarend[$i]->veg]);
                                }
                            }

                            //dd($orarend,$datum);
                            //dd($datum[0]->format('l'))
                            $counter = 0;
                            $vanmeg = false;
                        ?>

                        <?php
                            while (!$vanmeg)
                            {
                                echo ' <tr>';
                                for ($i = 0; $i < 7; $i++)
                                {
                                    if (count($hetnapja[$i]) > $counter)
                                    {
                                        echo '<td><p>' . $hetnapja[$i][$counter]->nev . '</p><br><p>  ' . date('H:i ', strtotime($hetnapja[$i][$counter]->kezdet)) .'-'. date('H:i ', strtotime($hetnapja[$i][$counter]->veg)). '</p></td>';
                                        $vanmeg = true;
                                    } else
                                    {
                                        echo '<td>-</td>';
                                    }
                                }
                                if ($vanmeg)
                                {
                                    $vanmeg = false;
                                } else
                                {
                                    $vanmeg = true;
                                }
                                $counter += 1;
                                echo ' </tr>';
                            }
                        ?>
                    </tbody>
            </div>
        </div>
    </div>
    </div>
@endsection
