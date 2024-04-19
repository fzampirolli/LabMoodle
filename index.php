<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhamento das Atividades dos Alunos no Moodle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f3e3;
            /* Fundo em tom de bege */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fffff5;
            /* Cor de fundo bonita */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 800px;
            width: 100%;
        }

        h1 {
            color: #007bff;
            /* Letras em tom de azul */
            margin-bottom: 20px;
        }

        p {
            color: #444;
            /* Letras em tom de cinza */
            line-height: 1.6;
            margin-bottom: 15px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            /* Links em tom de azul */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 800px) {
            .container {
                padding: 20px;
            }
        }

        /* Novos estilos para a animação da lupa */
        .loader {
            position: relative;
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Animação da lupa */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Define o tamanho e a cor da fonte dentro da tag <pre> */
        pre {
            font-size: small;
            /* ou tiny, smaller, smaller, smaller, large, larger, x-large */
            color: #00ffff;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Acompanhamento das Atividades dos Alunos no Moodle</h1>

        <hr />

        <h4>Ver modelos de arquivos gerados na pasta <a href="modelos/report/" target="_blank">report</a>.
            Os próximos passos ensinam como obter esses arquivos.
            Ao final desta página é possível gerar esses arquivos e um relatório semelhante às imagens
            <a href="modelos/report/ex01a.png" target="_blank">ex01a</a>,
            <a href="modelos/report/ex01b.png" target="_blank">ex01b</a> e
            <a href="modelos/report/ex01c.png" target="_blank">ex01c</a> de forma automática.
            
        </h4>

        <hr />

        <h2>1) Log no Moodle</h2>

        <h3>Arquivo: logs.CSV</h3>

        <p>Fazer download do log retirado da disciplina do Moodle.</p>


        <ol>
            <li>Ir em Disciplina +</li>
            <li>Engrenagem + Mais +</li>
            <li>Relatórios (Logs) +</li>
            <li>Obter estes logs +</li>
            <li>Download do csv (final da página)</li>
        </ol>

        <h2>2) Faltas dos Alunos no SIGAA</h2>

        <h3>Arquivo: faltas.XLS</h3>

        <ol>
            <li>Acesse o <a href="https://sig.ufabc.edu.br/sigaa/verTelaLogin.do">SIGAA</a> e vá para o portal docente</li>
            <li>Portal docente + Escolher a Turma + Alunos + Lançar Notas +</li>
            <li>Exportar planilha. </li>
        </ol>

        <hr />

        <form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="showLoader()">
            <div style="background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 900px; margin: 0 auto;">
                <h2 style="color: #007bff; margin-bottom: 20px;">Configurar corretamente informações da disciplina:</h2>
                <hr>

                <label for="start_date">Data de Início do Curso:</label>
                <input type="date" name="start_date" id="start_date" value="2024-02-05" required>

                <label for="end_date">Data de Término do Curso:</label>
                <input type="date" name="end_date" id="end_date" value="2024-05-07" required>

                <br><br>

                <label for="filter_field">Filtrar o Log do Moodle pelo componente:</label>
                <select id="filter_field" name="filter_field" required>
                    <option value="Tudo">Tudo</option>
                    <option value="Laboratório de Programação Virtual">Laboratório de Programação Virtual</option>
                    <option value="Sistema">Sistema</option>
                    <option value="URL">URL</option>
                    <option value="Arquivo">Arquivo</option>
                    <option value="Fórum">Fórum</option>
                    <option value="Questionário">Questionário</option>
                </select>

                <br><br>

                <label for="min_absences">Número mínimo de faltas após o término do curso:</label>
                <input type="number" name="min_absences" id="min_absences" value="14" required>

                <br><br>

    <label for="assign_O">Atribuir conceito "O" para reprovados por falta:</label>
    <input type="checkbox" id="assign_O" name="assign_O">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<label for="omit_data">Omitir dados de alunos:</label>
<input type="checkbox" id="omit_data" name="omit_data">

                <hr>
                <?php
                // Array para armazenar os nomes das aulas e seus respectivos IDs
                $aulas = array(
                    array("Aula 1", "1"),
                    array("Aula 2", "2"),
                );
                ?>

                <!-- Campos para as aulas -->
                <?php foreach ($aulas as $aula) : ?>
                    <fieldset>
                        <legend><?php echo $aula[0]; ?></legend>

                        <label for="dayFieldId<?php echo $aula[1]; ?>">Dia:</label>
                        <select name="dayFieldId<?php echo $aula[1]; ?>" id="dayFieldId<?php echo $aula[1]; ?>">
                            <option value="x">Selecione um dia</option>
                            <option value="0">segunda</option>
                            <option value="1">terça</option>
                            <option value="2">quarta</option>
                            <option value="3">quinta</option>
                            <option value="4">sexta</option>
                            <option value="5">sábado</option>
                        </select>

                        <label for="hourFieldId<?php echo $aula[1]; ?>">Horário:</label>
                        <select name="hourFieldId<?php echo $aula[1]; ?>" id="hourFieldId<?php echo $aula[1]; ?>" required>
                            <option value="">Selecione um horário</option>
                            <option value="8" selected>08:00</option>
                            <option value="10">10:00</option>
                            <option value="14">14:00</option>
                            <option value="16">16:00</option>
                            <option value="19">19:00</option>
                            <option value="21">21:00</option>
                        </select>

                        <label for="durationFieldId<?php echo $aula[1]; ?>">Duração:</label>
                        <select name="durationFieldId<?php echo $aula[1]; ?>" id="durationFieldId<?php echo $aula[1]; ?>" required>
                            <option value="">Selecione uma duração</option>
                            <option value="1">1 hora(s)</option>
                            <option value="2" selected>2 hora(s)</option>
                            <option value="3">3 hora(s)</option>
                            <option value="4">4 hora(s)</option>
                            <option value="5">5 hora(s)</option>
                        </select>
                        <br>
                        <label for='ipPrefixFieldId<?php echo $aula[1]; ?>'>Prefixo dos IPs do Laboratório:</label>
                        <input type='text' name='ipPrefixFieldId<?php echo $aula[1]; ?>' id='ipPrefixFieldId<?php echo $aula[1]; ?>' value='172.17.14' placeholder='Ex: 172.17.14' required>
                    </fieldset>
                <?php endforeach; ?>

            </div>

            <p></p>

            <div style="background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 0 auto;">
                <h2 style="color: #007bff; margin-bottom: 20px;">Upload de arquivos para gerar os relatórios</h2>

                <p style="color: #444; line-height: 1.6; margin-bottom: 20px;">Selecione os arquivos nos formatos CSV e XLS obtidos nos dois passos anteriores. Em seguida, escolha enviar:</p>

                <label for="csvFile" style="color: #444;">Arquivo <b>logs.CSV</b>:</label><br>
                <input type="file" name="csvFile" id="csvFile" accept=".csv" style="margin-bottom: 10px;"><br>

                <label for="xlsFile" style="color: #444;">Arquivo <b>faltas.xls</b>:</label><br>
                <input type="file" name="xlsFile" id="xlsFile" accept=".xls" style="margin-bottom: 20px;"><br>

                <hr style="border-color: #ccc;">

                <button type="submit" name="submit" style="background-color: #007bff; color: #fff; border: none; border-radius: 5px; padding: 10px 20px; cursor: pointer;">
                    <span id="loader" style="display: none;" class="loader"></span> Enviar
                </button>
            </div>
        </form>


        <hr />
        <footer>
            <p>Enviar sugestões de melhoria para <a href="mailto:fzampirolli@ufabc.edu.br">fzampirolli@ufabc.edu.br</a><br>
            Visite o projeto no GitHub: <a href="https://github.com/fzampirolli/LabMoodle">https://github.com/fzampirolli/LabMoodle</a></p>
        </footer>

    </div>
    <script>
        function showLoader() {
            document.getElementById("loader").style.display = "inline-block";
        }
    </script>
</body>

</html>