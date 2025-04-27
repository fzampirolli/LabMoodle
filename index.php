<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhamento das Atividades dos Estudantes no Moodle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f3e3;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fffff5;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 800px;
            width: 100%;
        }

        h1 {
            color: #007bff;
            margin-bottom: 20px;
        }

        p {
            color: #444;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        ul, ol {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        pre {
            font-size: small;
            color: #00ffff;
        }

        @media screen and (max-width: 800px) {
            .container {
                padding: 20px;
            }
        }

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

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Acompanhamento das Atividades dos Estudantes no Moodle</h1>

        <hr />

        <h4>
            Ver modelos de arquivos gerados na pasta
            <a href="modelos/report/" target="_blank">report</a>.
            <br><br>
            Ao final desta página é possível gerar arquivos semelhantes às imagens
            <a href="modelos/report/ex01a.png" target="_blank">ex01a</a>,
            <a href="modelos/report/ex01b.png" target="_blank">ex01b</a>,
            <a href="modelos/report/ex01c.png" target="_blank">ex01c</a> e
            <a href="modelos/report/ex01d.png" target="_blank">ex01d</a>.
        </h4>

        <hr />

        <h2>1) Log no Moodle</h2>
        <h3>Arquivo: logs.CSV</h3>
        <p>Fazer download do log retirado da disciplina do Moodle:</p>
        <ol>
            <li>Ir em Disciplina +</li>
            <li>Engrenagem + Mais +</li>
            <li>Relatórios (Logs) +</li>
            <li>Obter estes logs +</li>
            <li>Download do CSV (final da página)</li>
        </ol>

        <h2>2) Faltas dos Estudantes no SIGAA</h2>
        <h3>Arquivo: faltas.XLS</h3>
        <ol>
            <li>Acesse o <a href="https://sig.ufabc.edu.br/sigaa/verTelaLogin.do" target="_blank">SIGAA</a> e vá para o portal docente</li>
            <li>Escolha a Turma > Alunos > Lançar Notas</li>
            <li>Exportar planilha</li>
        </ol>

        <hr />

        <form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="showLoader()">
            <div style="background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <h2 style="color: #007bff;">Configurar informações da disciplina:</h2>
                <hr>

                <label for="start_date">Data de Início do Curso:</label>
                <input type="date" name="start_date" id="start_date" value="2025-02-10" required>

                <label for="end_date">Data de Término do Curso:</label>
                <input type="date" name="end_date" id="end_date" value="2025-05-17" required>

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

                <label for="min_absences">Número mínimo de faltas permitidas:</label>
                <input type="number" name="min_absences" id="min_absences" value="12" required style="width: 40px;">

                <br><br>

                <label for="assign_O">Atribuir conceito "O" para reprovados por falta:</label>
                <input type="checkbox" id="assign_O" name="assign_O">

                &nbsp;&nbsp;&nbsp;

                <label for="omit_data">Omitir dados de estudantes:</label>
                <input type="checkbox" id="omit_data" name="omit_data">

                <hr>

                <?php
                $aulas = [
                    ["Aula 1", "1"],
                    ["Aula 2", "2"],
                ];
                ?>

                <?php foreach ($aulas as $aula): ?>
                    <fieldset>
                        <legend><?php echo $aula[0]; ?></legend>

                        <label for="dayFieldId<?php echo $aula[1]; ?>">Dia:</label>
                        <select name="dayFieldId<?php echo $aula[1]; ?>" id="dayFieldId<?php echo $aula[1]; ?>" >
                            <option value="x">Selecione um dia</option>
                            <option value="0">Segunda</option>
                            <option value="1">Terça</option>
                            <option value="2">Quarta</option>
                            <option value="3">Quinta</option>
                            <option value="4">Sexta</option>
                            <option value="5">Sábado</option>
                        </select>

                        <label for="hourFieldId<?php echo $aula[1]; ?>">Horário:</label>
                        <select name="hourFieldId<?php echo $aula[1]; ?>" id="hourFieldId<?php echo $aula[1]; ?>" required style="width: 60px;">
                            <option value="">Selecione um horário</option>
                            <option value="8" selected>08:00</option>
                            <option value="10">10:00</option>
                            <option value="14">14:00</option>
                            <option value="16">16:00</option>
                            <option value="19">19:00</option>
                            <option value="21">21:00</option>
                        </select>

                        <label for="durationFieldId<?php echo $aula[1]; ?>">Duração:</label>
                        <select name="durationFieldId<?php echo $aula[1]; ?>" id="durationFieldId<?php echo $aula[1]; ?>" required style="width: 80px;">
                            <option value="">Selecione uma duração</option>
                            <option value="1">1 hora(s)</option>
                            <option value="2" selected>2 hora(s)</option>
                            <option value="3">3 hora(s)</option>
                            <option value="4">4 hora(s)</option>
                            <option value="5">5 hora(s)</option>
                        </select>

                        <label for="ipPrefixFieldId<?php echo $aula[1]; ?>">Prefixo dos IPs do Lab.:</label>
                        <input type="text" name="ipPrefixFieldId<?php echo $aula[1]; ?>" id="ipPrefixFieldId<?php echo $aula[1]; ?>" value="172.17.14" placeholder="Ex: 172.17.14" required style="width: 80px;">
                    </fieldset>
                <?php endforeach; ?>

            </div>

            <br>

            <div style="background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <h2 style="color: #007bff;">Upload de arquivos para gerar os relatórios</h2>

                <p>Selecione os arquivos obtidos nos dois passos anteriores:</p>

                <label for="csvFile">Arquivo <b>logs.CSV</b>:</label><br>
                <input type="file" name="csvFile" id="csvFile" accept=".csv"><br><br>

                <label for="xlsFile">Arquivo <b>faltas.XLS</b>:</label><br>
                <input type="file" name="xlsFile" id="xlsFile" accept=".xls"><br><br>

                <hr style="border-color: #ccc;">

                <button type="submit" name="submit" style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                    <span id="loader" class="loader" style="display: none;"></span> Enviar
                </button>
            </div>
        </form>

        <hr />

        <footer style="text-align: center; padding: 20px; font-size: 14px; border-top: 1px solid #dee2e6;">
            <p>
                Projeto em desenvolvimento e disponível em <a
                    href="https://github.com/fzampirolli/LabMoodle" target="_blank">GitHub</a>.
                Enviar sugestões de melhoria para <a href="mailto:fzampirolli@ufabc.edu.br"
                    style="color: #007bff; text-decoration: none;">fzampirolli@ufabc.edu.br</a>.
            </p>

            <a href="https://www.gnu.org/licenses/agpl-3.0.html" target="_blank"
                style="display: inline-block; margin: 10px;">
                <img src="http://mctest.ufabc.edu.br:8000/static/agplv3.png" alt="Licença AGPL v3" width="50"
                    style="border: none;">
            </a>

            <p style="margin: 10px 0;">
                Copyright © 2024-2025 por
                <a href="https://sites.google.com/site/fzampirolli/" target="_blank"
                    style="color: #007bff; text-decoration: none;">Francisco de Assis Zampirolli</a> da
                <a href="http://www.ufabc.edu.br" target="_blank"
                    style="color: #007bff; text-decoration: none;">UFABC</a> e colaboradores.
            </p>
        </footer>

    </div>

    <script>
        function showLoader() {
            document.getElementById("loader").style.display = "inline-block";
        }
    </script>
</body>
</html>
