<li class="nav-item">
    <a class="nav-link " href="/vezerlopult">
        <i class="fa-solid fa-house-chimney"></i>
        Főoldal
        <span class="sr-only">(current)</span>
    </a>
</li>

<li class="nav-item dropdown ">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa-solid fa-clock"></i>
        <span>
            Figyelmeztetések <i class="fas fa-angle-down"></i>
        </span>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="/tanar/figyelmeztetesek">Figyelmeztetéseim</a>
    </div>
</li>


@if (isset($ownclasses)&&$ownclasses==true)
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="/tanar/osztalyok" id="navbarDropdown" role="button" 
            aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-clock"></i>
            <span>
                Saját osztályaim 
            </span>
        </a>
    </li>

@endif

<!--<li class="nav-item dropdown ">
    <a class="nav-link dropdown-toggle" href="/naptar" id="navbarDropdown" role="button" 
        aria-haspopup="true" aria-expanded="false">
        <i class="fa-solid fa-clock"></i>
        <span>
            Naptáram
        </span>
    </a>
   
</li>-->

<li class="nav-item dropdown ">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa-solid fa-clock"></i>
        <span>
            Tanóra <i class="fas fa-angle-down"></i>
        </span>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="/tanar/tanorak">Tanóráim</a>
       
    </div>
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
        <a class="dropdown-item" href="/kijelentkezes">Kilépés</a>
    </div>
</li>