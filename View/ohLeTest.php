<!DOCTYPE html>
<html>
<head>
    <title>Ajouter et supprimer des blocs</title>
</head>
<body>
<h1>Blocs Dynamiques</h1>
<button id="ajouterBloc">Ajouter un bloc</button>
<div id="conteneurBlocs"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const conteneurBlocs = document.getElementById('conteneurBlocs');
        const ajouterBlocButton = document.getElementById('ajouterBloc');

        let blocCount = 0;
        const maxBlocs = 4;

        function ajouterBloc() {
            if (blocCount < maxBlocs) {
                const nouveauBloc = document.createElement('div');
                nouveauBloc.className = 'bloc';
                nouveauBloc.innerHTML = `<p>Bloc ${blocCount + 1}</p><button class="supprimerBloc">Supprimer</button>`;
                conteneurBlocs.appendChild(nouveauBloc);
                blocCount++;
                mettreEnEcouteSuppression(nouveauBloc);
            } else {
                alert("Vous avez atteint le nombre maximum de blocs (4).");
            }
        }

        function supprimerBloc(bloc) {
            conteneurBlocs.removeChild(bloc);
            blocCount--;
        }

        function mettreEnEcouteSuppression(bloc) {
            const boutonSupprimer = bloc.querySelector('.supprimerBloc');
            boutonSupprimer.addEventListener('click', function () {
                supprimerBloc(bloc);
            });
        }

        ajouterBlocButton.addEventListener('click', ajouterBloc);
    });
</script>
<style>
    .bloc {
        border: 1px solid #333;
        padding: 10px;
        margin: 5px;
    }
</style>
</body>
</html>

