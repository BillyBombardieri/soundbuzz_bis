<header>
    <nav>
        <ul>
            <div class="gauche">
                <img src="logo/logo-orange.png" alt="">
                <h2 class="titre">Bonjour</h2>
            </div>
        </ul> 
    </nav>
</header>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    header nav {
        background-color: black;
        height: 15vh;
    }

    header nav ul {
        display: grid;
        grid-template-columns: 50% 50%;
    }


    .gauche img {
        height: 10vh;
        width: auto;
        margin-top: 2vh;
        margin-left: 2%;
    }


    .gauche h2 {
        color: rgb(255, 121, 0);
        margin-top: 9.5vh;
        margin-right: 3%;
        margin-left: 4%;
    }

    .titre {
        color: rgb(255, 121, 0);
        margin-top: 8vh;
        margin-right: 3%;
        margin-left: 2%;
    }

    nav ul div h2 {
        color: white;
        margin-top: 8vh;
    }

    nav ul div {
        display: inline-flex;
        height: 120%;
    }
</style>
