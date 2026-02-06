<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhamento das Atividades dos Estudantes no Moodle</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 15px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        /* Content Section */
        .content {
            padding: 30px;
        }

        .section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid #e0e0e0;
        }

        .section:last-child {
            border-bottom: none;
        }

        .privacy-badge {
            display: inline-block;
            background: linear-gradient(135deg, #fff9e6 0%, #fff3d9 100%);
            border: 2px solid rgba(255, 193, 7, 0.3);
            color: #5d4a1f;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 13px;
            margin-top: 15px;
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.15);
            transition: all 0.3s;
        }

        .privacy-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 193, 7, 0.25);
            border-color: rgba(255, 193, 7, 0.5);
        }

        .privacy-badge strong {
            color: #3e2f0f;
            font-weight: 700;
        }
        .section-title {
            font-size: 22px;
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box h4 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .info-box a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .info-box a:hover {
            text-decoration: underline;
        }

        /* Steps */
        .steps {
            margin: 20px 0;
        }

        .step {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }

        .step h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .step h4 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .step p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .step ol {
            margin-left: 20px;
            color: #555;
        }

        .step li {
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .step strong {
            color: #e65100;
        }

        /* Form Styling */
        .form-container {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .form-section-title {
            font-size: 20px;
            color: #667eea;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="date"],
        input[type="number"],
        input[type="text"],
        input[type="file"],
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: inherit;
        }

        input[type="date"]:focus,
        input[type="number"]:focus,
        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .checkbox-group {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .checkbox-item label {
            margin: 0;
            cursor: pointer;
            font-weight: 500;
        }

        /* Fieldset Styling */
        fieldset {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: white;
            transition: all 0.3s;
        }

        fieldset:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        legend {
            font-weight: 700;
            color: #667eea;
            padding: 0 10px;
            font-size: 16px;
        }


        /* Tooltip para ajuda dos IPs */
        .ip-help-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            background: #2196F3;
            color: white;
            border-radius: 50%;
            font-size: 12px;
            font-weight: bold;
            cursor: help;
            margin-left: 5px;
            position: relative;
        }

        .ip-help-icon:hover {
            background: #1976D2;
        }

        .ip-tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-bottom: 8px;
            background: #1e3a5f;
            color: white;
            padding: 15px;
            border-radius: 8px;
            width: 420px;
            max-width: 90vw;
            font-size: 12px;
            line-height: 1.6;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            z-index: 1000;
            pointer-events: none;
        }

        .ip-help-icon:hover .ip-tooltip {
            opacity: 1;
            visibility: visible;
        }

        .ip-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: #1e3a5f;
        }

        .ip-tooltip strong {
            color: #64b5f6;
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .ip-tooltip code {
            background: rgba(255, 255, 255, 0.15);
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #ffeb3b;
            font-size: 11px;
        }

        .ip-tooltip ul {
            margin: 8px 0 0 0;
            padding-left: 20px;
        }

        .ip-tooltip li {
            margin-bottom: 6px;
        }

        .aula-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-field {
            display: flex;
            flex-direction: column;
        }

        .form-field label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            font-size: 13px;
        }

        .form-field select,
        .form-field input {
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
            width: 100%;
        }

        .form-field select:focus,
        .form-field input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* IP Section */
        .ip-section {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #ddd;
        }

        .ip-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .ip-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .ip-help-box {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 12px;
            border-radius: 6px;
            margin-top: 8px;
            font-size: 12px;
            line-height: 1.6;
        }

        .ip-help-box strong {
            color: #0d47a1;
            display: block;
            margin-bottom: 5px;
        }

        .ip-examples {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            padding: 10px;
            border-radius: 6px;
            margin-top: 6px;
            font-size: 11px;
            line-height: 1.6;
        }

        .ip-examples strong {
            color: #e65100;
            display: block;
            margin-bottom: 5px;
        }

        .ip-examples code {
            background: #ffe0b2;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #e65100;
            font-size: 11px;
        }

        /* Submit Button */
        .submit-section {
            text-align: center;
            margin-top: 30px;
        }

        button[type="submit"] {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 50px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        .loader {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 10px;
            vertical-align: middle;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Footer */
        footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        footer p {
            color: #666;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        footer a:hover {
            text-decoration: underline;
        }

        footer img {
            margin: 15px 0;
        }

        hr {
            border: none;
            border-top: 1px solid #e0e0e0;
            margin: 20px 0;
        }

        @media (max-width: 768px) {
            .container {
                border-radius: 0;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .aula-grid {
                grid-template-columns: 1fr;
            }

            .checkbox-group {
                flex-direction: column;
                gap: 15px;
            }

            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📊 Acompanhamento das Atividades dos Estudantes no Moodle</h1>
            <p>Sistema de análise de presença e participação baseado em logs do Moodle</p>

            <div class="privacy-badge">
                <span class="lock-icon">🔒</span> <strong>Privacidade:</strong> Todos os arquivos enviados e relatórios gerados são <strong>removidos automaticamente</strong> do servidor em poucos minutos
            </div>
        </div>

        <div class="content">
            <!-- Informações Iniciais -->
            <div class="info-box">
                <h4>📁 Arquivos de Exemplo</h4>
                <p>
                    Ver modelos de arquivos gerados na pasta
                    <a href="modelos/report/" target="_blank">report</a>.
                    <br><br>
                    Ao final desta página é possível gerar arquivos semelhantes às imagens:
                    <a href="modelos/report/ex01a.png" target="_blank">ex01a</a>,
                    <a href="modelos/report/ex01b.png" target="_blank">ex01b</a>,
                    <a href="modelos/report/ex01c.png" target="_blank">ex01c</a> e
                    <a href="modelos/report/ex01d.png" target="_blank">ex01d</a>.
                </p>
            </div>

            <!-- Passo 1 -->
            <div class="section">
                <h2 class="section-title">📝 Passo 1: Log no Moodle</h2>
                <div class="step">
                    <h4>Arquivo CSV necessário</h4>
                    <p>Faça o download do log da disciplina no Moodle:</p>
                    <ol>
                        <li>Acesse a disciplina desejada no Moodle</li>
                        <li>No menu lateral, vá em <strong>"Relatórios"</strong> → <strong>"Logs"</strong></li>
                        <li>Configure os filtros conforme necessário (período, usuários, atividades, etc.) ou mantenha os valores padrão (default)</li>
                        <li>Clique em <strong>"Obter estes logs"</strong></li>
                        <li>No final da página, faça o download do arquivo CSV</li>
                    </ol>
                </div>
            </div>

            <!-- Passo 2 -->
            <div class="section">
                <h2 class="section-title">📋 Passo 2: Planilha dos Estudantes no SIGAA</h2>
                <div class="step">
                    <h4>Arquivo XLS necessário:</h4>
                    <p>Exporte a planilha de notas e faltas dos estudantes pelo <a href="https://sig.ufabc.edu.br/sigaa/verTelaLogin.do" target="_blank">SIGAA</a>:</p>
                    <ol>
                        <li>Acesse o <strong>Portal do Docente</strong> no SIGAA</li>
                        <li>Escolha a turma desejada</li>
                        <li>Vá em <strong>"Alunos"</strong> → <strong>"Lançar Notas"</strong></li>
                        <li>Clique em <strong>"Exportar planilha"</strong></li>
                        <li>Salve o arquivo (não edite o arquivo exportado)</li>
                    </ol>
                    <p><strong>⚠️ Nota importante:</strong> O arquivo não deve ser editado manualmente. Caso contenha os conceitos dos alunos, serão gerados gráficos adicionais com estatísticas relacionando acesso e desempenho.</p>
                </div>
            </div>

            <!-- Formulário -->
            <div class="section">
                <h2 class="section-title">⚙️ Passo 3: Configuração e Processamento</h2>

                <form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="showLoader()">

                    <!-- Configurações da Disciplina -->
                    <div class="form-container">
                        <h3 class="form-section-title">📅 Período do Curso</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="start_date">Data de Início</label>
                                <input type="date" name="start_date" id="start_date" value="2026-02-02" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Data de Término</label>
                                <input type="date" name="end_date" id="end_date" value="2026-05-13" required>
                            </div>
                        </div>

                        <hr>

                        <h3 class="form-section-title">🔍 Configurações de Filtros</h3>

                        <div class="form-group">
                            <label for="filter_field">Filtrar Log do Moodle por Componente</label>
                            <select id="filter_field" name="filter_field" required>
                                <option value="Tudo">Tudo (sem filtro)</option>
                                <option value="Laboratório de Programação Virtual">Laboratório de Programação Virtual</option>
                                <option value="Sistema">Sistema</option>
                                <option value="URL">URL</option>
                                <option value="Arquivo">Arquivo</option>
                                <option value="Fórum">Fórum</option>
                                <option value="Questionário">Questionário</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="min_absences">Número Máximo de Faltas Permitidas</label>
                            <input type="number" name="min_absences" id="min_absences" value="12" required min="0" max="100">
                        </div>

                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="assign_O" name="assign_O">
                                <label for="assign_O">Atribuir conceito "O" para reprovados por falta</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="omit_data" name="omit_data">
                                <label for="omit_data">Omitir dados de estudantes (anonimizar)</label>
                            </div>
                        </div>

                        <hr>

                        <h3 class="form-section-title">🕐 Horários das Aulas</h3>

                        <?php
                        $aulas = [
                            ["Aula 1", "1", "🔵"],
                            ["Aula 2", "2", "🟢"],
                        ];
                        ?>

                        <?php foreach ($aulas as $aula): ?>
                            <fieldset>
                                <legend><?php echo $aula[2] . " " . $aula[0]; ?></legend>

                                <div class="aula-grid">
                                    <div class="form-field">
                                        <label for="dayFieldId<?php echo $aula[1]; ?>">📅 Dia da Semana</label>
                                        <select name="dayFieldId<?php echo $aula[1]; ?>" id="dayFieldId<?php echo $aula[1]; ?>">
                                            <option value="0">Segunda-feira</option>
                                            <option value="1">Terça-feira</option>
                                            <option value="2">Quarta-feira</option>
                                            <option value="3">Quinta-feira</option>
                                            <option value="4">Sexta-feira</option>
                                            <option value="5">Sábado</option>
                                        </select>
                                    </div>

                                    <div class="form-field">
                                        <label for="hourFieldId<?php echo $aula[1]; ?>">🕐 Horário de Início</label>
                                        <select name="hourFieldId<?php echo $aula[1]; ?>" id="hourFieldId<?php echo $aula[1]; ?>" required>
                                            <option value="">Selecione</option>
                                            <option value="8" selected>08:00</option>
                                            <option value="10">10:00</option>
                                            <option value="14">14:00</option>
                                            <option value="16">16:00</option>
                                            <option value="19">19:00</option>
                                            <option value="21">21:00</option>
                                        </select>
                                    </div>

                                    <div class="form-field">
                                        <label for="durationFieldId<?php echo $aula[1]; ?>">⏱️ Duração</label>
                                        <select name="durationFieldId<?php echo $aula[1]; ?>" id="durationFieldId<?php echo $aula[1]; ?>" required>
                                            <option value="">Selecione</option>
                                            <option value="1">1 hora</option>
                                            <option value="2" selected>2 horas</option>
                                            <option value="3">3 horas</option>
                                            <option value="4">4 horas</option>
                                            <option value="5">5 horas</option>
                                        </select>
                                    </div>
                                </div>


                          <div class="ip-section">
                              <div class="form-field">
                                  <div class="ip-label">
                                      <label for="ipPrefixFieldId<?php echo $aula[1]; ?>">
                                          🌐 IPs Mais Frequentes Durante Aulas
                                          <span style="font-size: 11px; color: #666; margin-left: 5px;">
                                              (detectados automaticamente do CSV)
                                          </span>
                                      </label>
                                     <span class="ip-help-icon">
                                         📊
                                         <div class="ip-tooltip" style="width: 400px;">
                                             <strong>🎯 Faixas de Rede Mais Acessadas</strong><br><br>

                                             <strong>Como funciona:</strong><br>
                                             1. Agrupa IPs por faixa (/24 IPv4, /64 IPv6)<br>
                                             2. Conta acessos por faixa, não por IP individual<br>
                                             3. Identifica faixas mais acessadas<br>
                                             4. Prioriza faixas privadas de laboratório<br><br>

                                             <strong>Exemplo:</strong><br>
                                             • IPv4: <code>172.17.85.0/24</code><br>
                                             • IPv6: <code>2801:a4:101:214::/64</code><br><br>
                                         </div>
                                     </span>
                                  </div>

                                  <input
                                      type="text"
                                      name="ipPrefixFieldId<?php echo $aula[1]; ?>"
                                      id="ipPrefixFieldId<?php echo $aula[1]; ?>"
                                      value=""
                                      placeholder="Aguardando detecção automática..."
                                      required>

                                  <div class="ip-help-box" style="margin-top: 10px; background: #f0f7ff;">
                                      <strong>📈 Faixas de IP Detectadas (Auto-detectável, Filtra por horário e Faixas de IPs mais frequente):</strong>
                                      <div id="cidrRangeDisplay<?php echo $aula[1]; ?>" style="font-family: 'Courier New', monospace; font-size: 12px; margin-top: 5px; padding: 8px; background: white; border-radius: 4px; border: 1px dashed #90caf9;">
                                          <span style="color: #666; font-style: italic;">Selecione o arquivo CSV abaixo (em Upload Arquivos) para detectar as faixas...</span>
                                      </div>
                                  </div>
                              </div>
                          </div>

                            </fieldset>
                        <?php endforeach; ?>
                    </div>

                    <!-- Upload de Arquivos -->
                    <div class="form-container">
                        <h3 class="form-section-title">📁 Upload de Arquivos</h3>
                        <p style="color: #666; margin-bottom: 20px; font-size: 14px;">
                            Selecione os arquivos obtidos nos passos anteriores para gerar os relatórios de presença e participação
                        </p>

                        <div class="form-group">
                            <label for="csvFile">📄 Arquivo de Logs do Moodle (CSV)</label>
                            <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
                        </div>

                        <div class="form-group">
                            <label for="xlsFile">📊 Arquivo de Faltas do SIGAA (XLS)</label>
                            <input type="file" name="xlsFile" id="xlsFile" accept=".xls" required>
                        </div>

                        <div class="submit-section">
                            <button type="submit" name="submit">
                                <span id="loader" class="loader" style="display: none;"></span>
                                <span id="submitText">🚀 Processar Arquivos e Gerar Relatórios</span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer>
            <p>
                Projeto em desenvolvimento e disponível em
                <a href="https://github.com/fzampirolli/LabMoodle" target="_blank">GitHub</a>.
                Enviar sugestões de melhoria para
                <a href="mailto:fzampirolli@ufabc.edu.br">fzampirolli@ufabc.edu.br</a>.
            </p>

            <a href="https://www.gnu.org/licenses/agpl-3.0.html" target="_blank">
                <img src="http://mctest.ufabc.edu.br:8000/static/agplv3.png" alt="Licença AGPL v3" width="50">
            </a>

            <p>
                Copyright © 2024-2026 por
                <a href="https://sites.google.com/site/fzampirolli/" target="_blank">Francisco de Assis Zampirolli</a> da
                <a href="http://www.ufabc.edu.br" target="_blank">UFABC</a> e colaboradores.
            </p>
        </footer>
    </div>

    <script>
        function showLoader() {
            document.getElementById("loader").style.display = "inline-block";
            document.getElementById("submitText").textContent = "Processando...";
        }
    </script>





<script>
    function showLoader() {
        document.getElementById("loader").style.display = "inline-block";
        document.getElementById("submitText").textContent = "Processando...";
    }

    // Função para obter configurações dos dias de aula
    function getClassDays() {
        const days = [];
        for (let i = 1; i <= 2; i++) {
            const daySelect = document.getElementById(`dayFieldId${i}`);
            const hourSelect = document.getElementById(`hourFieldId${i}`);
            const durationSelect = document.getElementById(`durationFieldId${i}`);

            if (daySelect && daySelect.value !== "" && hourSelect && hourSelect.value !== "") {
                days.push({
                    id: i,
                    dayOfWeek: parseInt(daySelect.value),
                    hour: parseInt(hourSelect.value),
                    duration: parseInt(durationSelect.value)
                });
            }
        }
        return days;
    }

    // Função para extrair prefixo de rede de um IP
    function extractNetworkPrefix(ip) {
        if (!ip) return null;

        if (ip.includes('.')) {
            const parts = ip.split('.');
            if (parts.length === 4) {
                return parts.slice(0, 3).join('.');
            }
        } else if (ip.includes(':')) {
            const parts = ip.split(':');
            if (parts.length >= 4) {
                return parts.slice(0, 4)
                    .map(part => part.replace(/^0+/, '') || '0')
                    .join(':');
            }
        }
        return null;
    }

    // Função para verificar se um IP é de rede privada/laboratório
    function isPrivateOrLabIP(ip) {
        if (!ip) return false;

        if (ip.includes('.')) {
            const parts = ip.split('.');
            if (parts.length !== 4) return false;

            const first = parseInt(parts[0]);
            const second = parseInt(parts[1]);

            if (first === 10) return true;
            if (first === 172 && second >= 16 && second <= 31) return true;
            if (first === 192 && second === 168) return true;
            if (first === 172 && second === 17) return true;
            if (first === 172 && second === 18) return true;
            if (first === 172 && second === 19) return true;

            return false;

        } else if (ip.includes(':')) {
            if (ip.startsWith('fe80:')) return true;
            if (ip.startsWith('fc') || ip.startsWith('fd')) return true;
            if (ip.startsWith('2801:a4:101:')) return true;
            if (ip.startsWith('2001:')) {
                return ip.startsWith('2001:db8:') || ip.startsWith('2001:0:');
            }

            return true;
        }

        return false;
    }

    // Função para parsear data do formato do Moodle
    function parseMoodleDate(dateStr) {
        try {
            dateStr = dateStr.replace(/"/g, '').trim();
            const parts = dateStr.split(', ');
            if (parts.length !== 2) return null;

            const datePart = parts[0];
            const timePart = parts[1];

            const dateParts = datePart.split('/');
            if (dateParts.length !== 3) return null;

            let day = parseInt(dateParts[0]);
            let month = parseInt(dateParts[1]) - 1;
            let year = parseInt(dateParts[2]);

            if (year < 100) year += 2000;

            const timeParts = timePart.split(':');
            if (timeParts.length < 2) return null;

            let hour = parseInt(timeParts[0]);
            let minute = parseInt(timeParts[1]);
            let second = timeParts.length > 2 ? parseInt(timeParts[2]) : 0;

            const date = new Date(year, month, day, hour, minute, second);
            if (isNaN(date.getTime())) return null;

            return date;

        } catch (error) {
            return null;
        }
    }

    // Função para extrair faixas de rede mais frequentes por dia da semana
    function extractNetworkRangesByDay(file, startDate, endDate) {
        return new Promise((resolve, reject) => {
            if (!file) {
                reject('Nenhum arquivo selecionado');
                return;
            }

            const reader = new FileReader();
            reader.onload = async function(e) {
                try {
                    const content = e.target.result;
                    const days = getClassDays();

                    if (days.length === 0) {
                        resolve({
                            success: false,
                            message: 'Configure os dias e horários das aulas primeiro'
                        });
                        return;
                    }

                    const result = await processCSVForNetworkRanges(content, days, startDate, endDate);
                    resolve(result);

                } catch (error) {
                    console.error("Erro no processamento:", error);
                    reject(error);
                }
            };

            reader.onerror = function(error) {
                reject('Erro ao ler arquivo: ' + error);
            };

            reader.readAsText(file);
        });
    }

    // Processar CSV para encontrar faixas de rede mais frequentes
    async function processCSVForNetworkRanges(content, days, startDate, endDate) {
        const lines = content.split('\n');

        if (lines.length === 0) {
            return { success: false, message: 'Arquivo CSV vazio' };
        }

        // Encontrar índices das colunas
        const headers = lines[0].split(',').map(h => h.trim());
        let ipCol = -1, timeCol = -1;

        // Procurar coluna de IP
        for (let i = 0; i < headers.length; i++) {
            const header = headers[i].toLowerCase();
            if (header === 'endereço ip' || header === 'endereco ip' ||
                header.includes('ip') || header === 'ip') {
                ipCol = i;
            }
            if (header === 'hora' || header.includes('time') ||
                header.includes('data') || header.includes('timestamp')) {
                timeCol = i;
            }
        }

        if (ipCol === -1) ipCol = headers.length - 1;
        if (timeCol === -1) timeCol = 0;

        // Inicializar resultados por dia
        const resultsByDay = {};
        days.forEach(d => {
            resultsByDay[d.dayOfWeek] = {
                ipv4Networks: new Map(),
                ipv6Networks: new Map(),
                ipv4Examples: new Map(),
                ipv6Examples: new Map(),
                ipv4PrivateNetworks: new Map(),
                ipv6LabNetworks: new Map(),
                totalRecords: 0,
                dayName: ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'][d.dayOfWeek]
            };
        });

        // Converter datas do curso
        const courseStart = new Date(startDate + 'T00:00:00');
        const courseEnd = new Date(endDate + 'T23:59:59');

        let processedLines = 0;
        let validLines = 0;
        const maxLines = Math.min(lines.length, 50000);

        // Processar em chunks
        const chunkSize = 1000;

        for (let startLine = 1; startLine < maxLines; startLine += chunkSize) {
            const endLine = Math.min(startLine + chunkSize, maxLines);

            for (let i = startLine; i < endLine; i++) {
                if (!lines[i].trim()) continue;

                processedLines++;

                // Parsear linha CSV
                const row = parseCSVLine(lines[i]);
                if (!row || row.length <= Math.max(ipCol, timeCol)) continue;

                const ip = row[ipCol] ? row[ipCol].trim() : '';
                const timeStr = row[timeCol] ? row[timeCol].trim() : '';

                // Ignorar IPs inválidos
                if (!ip || ip === '-' || ip === '' || ip.toLowerCase().includes('omitted')) continue;

                const date = parseMoodleDate(timeStr);
                if (!date) continue;

                // Verificar se está dentro do período do curso
                if (date < courseStart || date > courseEnd) continue;

                const dayOfWeek = date.getDay();

                // Para cada dia configurado
                days.forEach(d => {
                    const expectedJsDay = d.dayOfWeek + 1;

                    if (dayOfWeek === expectedJsDay) {
                        const hour = date.getHours();
                        const minute = date.getMinutes();
                        const currentTime = hour + (minute / 60);
                        const startTime = d.hour;
                        const endTime = d.hour + d.duration;

                        if (currentTime >= startTime && currentTime < endTime) {
                            validLines++;
                            resultsByDay[d.dayOfWeek].totalRecords++;

                            const networkPrefix = extractNetworkPrefix(ip);
                            if (!networkPrefix) return;

                            const isLabIP = isPrivateOrLabIP(ip);

                            if (ip.includes('.')) {
                                const count = resultsByDay[d.dayOfWeek].ipv4Networks.get(networkPrefix) || 0;
                                resultsByDay[d.dayOfWeek].ipv4Networks.set(networkPrefix, count + 1);

                                if (!resultsByDay[d.dayOfWeek].ipv4Examples.has(networkPrefix)) {
                                    resultsByDay[d.dayOfWeek].ipv4Examples.set(networkPrefix, ip);
                                }

                                if (isLabIP) {
                                    const privateCount = resultsByDay[d.dayOfWeek].ipv4PrivateNetworks.get(networkPrefix) || 0;
                                    resultsByDay[d.dayOfWeek].ipv4PrivateNetworks.set(networkPrefix, privateCount + 1);
                                }

                            } else if (ip.includes(':')) {
                                const count = resultsByDay[d.dayOfWeek].ipv6Networks.get(networkPrefix) || 0;
                                resultsByDay[d.dayOfWeek].ipv6Networks.set(networkPrefix, count + 1);

                                if (!resultsByDay[d.dayOfWeek].ipv6Examples.has(networkPrefix)) {
                                    resultsByDay[d.dayOfWeek].ipv6Examples.set(networkPrefix, ip);
                                }

                                if (isLabIP) {
                                    const labCount = resultsByDay[d.dayOfWeek].ipv6LabNetworks.get(networkPrefix) || 0;
                                    resultsByDay[d.dayOfWeek].ipv6LabNetworks.set(networkPrefix, labCount + 1);
                                }
                            }
                        }
                    }
                });
            }

            if (startLine % 5000 === 0) {
                await new Promise(resolve => setTimeout(resolve, 0));
            }
        }

        // Processar resultados por dia
        const finalResults = {};
        let foundAnyNetworks = false;

        days.forEach(d => {
            const dayData = resultsByDay[d.dayOfWeek];
            const dayName = dayData.dayName;

            // Encontrar faixa IPv4 mais frequente
            let bestIPv4Network = null, maxIPv4Count = 0, bestIPv4Example = null;

            // Primeiro, verificar faixas privadas/lab
            if (dayData.ipv4PrivateNetworks.size > 0) {
                dayData.ipv4PrivateNetworks.forEach((count, network) => {
                    if (count > maxIPv4Count) {
                        maxIPv4Count = count;
                        bestIPv4Network = network;
                        bestIPv4Example = dayData.ipv4Examples.get(network);
                    }
                });
            }
            else if (dayData.ipv4Networks.size > 0) {
                dayData.ipv4Networks.forEach((count, network) => {
                    if (count > maxIPv4Count) {
                        maxIPv4Count = count;
                        bestIPv4Network = network;
                        bestIPv4Example = dayData.ipv4Examples.get(network);
                    }
                });
            }

            // Encontrar faixa IPv6 mais frequente
            let bestIPv6Network = null, maxIPv6Count = 0, bestIPv6Example = null;

            if (dayData.ipv6LabNetworks.size > 0) {
                dayData.ipv6LabNetworks.forEach((count, network) => {
                    if (count > maxIPv6Count) {
                        maxIPv6Count = count;
                        bestIPv6Network = network;
                        bestIPv6Example = dayData.ipv6Examples.get(network);
                    }
                });
            }
            else if (dayData.ipv6Networks.size > 0) {
                dayData.ipv6Networks.forEach((count, network) => {
                    if (count > maxIPv6Count) {
                        maxIPv6Count = count;
                        bestIPv6Network = network;
                        bestIPv6Example = dayData.ipv6Examples.get(network);
                    }
                });
            }

            const prefixes = [];

            if (bestIPv4Network) {
                prefixes.push(bestIPv4Network);
                foundAnyNetworks = true;
            }

            if (bestIPv6Network) {
                prefixes.push(bestIPv6Network);
                foundAnyNetworks = true;
            }

            const aulaId = days.findIndex(day => day.dayOfWeek === d.dayOfWeek) + 1;

            if (aulaId > 0) {
                finalResults[aulaId] = {
                    prefixes: prefixes,
                    ipv4Network: bestIPv4Network,
                    ipv4Count: maxIPv4Count,
                    ipv4Example: bestIPv4Example,
                    ipv6Network: bestIPv6Network,
                    ipv6Count: maxIPv6Count,
                    ipv6Example: bestIPv6Example,
                    total: dayData.totalRecords,
                    dayName: dayName,
                    hour: d.hour,
                    duration: d.duration
                };
            }
        });

        return {
            success: true,
            days: finalResults,
            foundAnyNetworks: foundAnyNetworks,
            totalProcessed: processedLines,
            totalValid: validLines
        };
    }

    // Função para parsear linha CSV corretamente
    function parseCSVLine(line) {
        const result = [];
        let current = '';
        let inQuotes = false;

        for (let i = 0; i < line.length; i++) {
            const char = line[i];

            if (char === '"') {
                inQuotes = !inQuotes;
            } else if (char === ',' && !inQuotes) {
                result.push(current);
                current = '';
            } else {
                current += char;
            }
        }

        result.push(current);
        return result;
    }

    // Função para calcular faixa CIDR
    function calculateCIDRRange(prefix) {
        if (prefix.includes('.')) {
            return `${prefix}.0/24`;
        } else if (prefix.includes(':')) {
            const parts = prefix.split(':');
            if (parts.length === 4) {
                return `${prefix}::/64`;
            }
            return `${prefix}/64`;
        }
        return prefix;
    }

    // Event listener para o arquivo CSV
    document.getElementById('csvFile').addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;

        try {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (!startDate || !endDate) {
                alert('Configure as datas do curso primeiro.');
                return;
            }

            let statusDiv = document.getElementById('ipDetectionStatus');
            if (!statusDiv) {
                statusDiv = document.createElement('div');
                statusDiv.id = 'ipDetectionStatus';
                statusDiv.style.cssText = 'margin-top: 10px; padding: 15px; border-radius: 8px; font-size: 13px; line-height: 1.5;';
                this.parentNode.appendChild(statusDiv);
            }

            statusDiv.innerHTML = '🔍 Analisando faixas de rede...';
            statusDiv.style.display = 'block';
            statusDiv.style.backgroundColor = '#e3f2fd';
            statusDiv.style.color = '#0c5460';

            const result = await extractNetworkRangesByDay(file, startDate, endDate);

            if (result.success) {
                let foundAny = false;

                for (let i = 1; i <= 2; i++) {
                    const dayData = result.days[i];
                    const input = document.getElementById(`ipPrefixFieldId${i}`);
                    const display = document.getElementById(`cidrRangeDisplay${i}`);

                    if (dayData && dayData.prefixes.length > 0) {
                        foundAny = true;

                        // Preencher campo do formulário
                        const prefixes = dayData.prefixes.join(', ');
                        input.value = prefixes;

                        // Criar display simples
                        let cidrHTML = '<div style="display:flex; flex-direction:column; gap:10px;">';

                        const allRanges = dayData.prefixes.map(p => calculateCIDRRange(p)).join(', ');
                        const allPrefixes = dayData.prefixes.join(', ');

                        cidrHTML += `
                            <div style="background:#f8f9fa; padding:12px; border-radius:8px; border:1px solid #dee2e6;">
                                <div style="margin-bottom:8px;">
                                    <strong style="color:#2e7d32; display:block; margin-bottom:5px;">Faixas detectadas nas ${dayData.dayName}s:</strong>
                                    <span style="font-size:11px; color:#666;">(${dayData.hour}h-${dayData.hour + dayData.duration}h)</span>
                                </div>
                                <div style="background:white; padding:10px; border-radius:5px; border:1px solid #e0e0e0; margin-top:8px;">

                                    <div style="font-size:11px; color:#666; margin-top:8px; padding-top:8px; border-top:1px dashed #e0e0e0;">
                                        <strong>Para o campo acima:</strong> ${allPrefixes}<br>
                                        <strong>Para o Moodle VPL:</strong>
                                        <strong style="color:#d32f2f; display:block; margin-bottom:5px;">${allRanges}</strong>
                                    </div>
                                </div>
                            </div>
                        `;

                        cidrHTML += '</div>';
                        display.innerHTML = cidrHTML;

                    } else if (display) {
                        display.innerHTML = `<div style="text-align:center; padding:20px; color:#666; font-style:italic;">
                            Nenhuma faixa de rede detectada para este horário
                        </div>`;
                    }
                }

                let statusMessage = '';

                if (foundAny) {
                    statusMessage = `✅ Faixas de rede detectadas!<br>
                                   <small>Processados: ${result.totalProcessed} linhas |
                                   Registros durante aulas: ${result.totalValid}</small>`;
                    statusDiv.style.backgroundColor = '#d4edda';
                    statusDiv.style.color = '#155724';
                } else {
                    statusMessage = `⚠️ Nenhuma faixa de rede encontrada.<br>
                                   <small>Verifique os horários e período do curso</small><br>
                                   <small>Linhas processadas: ${result.totalProcessed} |
                                   Registros durante aulas: ${result.totalValid}</small>`;
                    statusDiv.style.backgroundColor = '#fff3cd';
                    statusDiv.style.color = '#856404';
                }

                statusDiv.innerHTML = statusMessage;

            } else {
                statusDiv.innerHTML = `❌ ${result.message}`;
                statusDiv.style.backgroundColor = '#f8d7da';
                statusDiv.style.color = '#721c24';
            }

        } catch (error) {
            console.error('Erro ao processar arquivo:', error);

            let statusDiv = document.getElementById('ipDetectionStatus');
            if (statusDiv) {
                statusDiv.innerHTML = `❌ Erro ao processar arquivo CSV`;
                statusDiv.style.backgroundColor = '#f8d7da';
                statusDiv.style.color = '#721c24';
            }
        }
    });

    // Inicialização
    document.addEventListener('DOMContentLoaded', function() {
        const csvFileInput = document.getElementById('csvFile');
        const parent = csvFileInput.parentNode;

        if (!document.getElementById('detectIPsBtn')) {
            const detectButton = document.createElement('button');
            detectButton.type = 'button';
            detectButton.id = 'detectIPsBtn';
            detectButton.innerHTML = '🏢 Detectar Faixas de Rede';
            detectButton.style.cssText = `
                margin-left: 10px;
                padding: 8px 15px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                font-weight: 600;
                transition: all 0.3s;
                box-shadow: 0 2px 5px rgba(102, 126, 234, 0.3);
            `;

            detectButton.onclick = function() {
                const hasSchedule1 = document.getElementById('hourFieldId1') &&
                                    document.getElementById('hourFieldId1').value !== "";
                const hasSchedule2 = document.getElementById('hourFieldId2') &&
                                    document.getElementById('hourFieldId2').value !== "";

                if (!hasSchedule1 && !hasSchedule2) {
                    alert('Configure os horários das aulas primeiro.');
                    return;
                }

                if (csvFileInput.files.length > 0) {
                    csvFileInput.dispatchEvent(new Event('change'));
                } else {
                    alert('Selecione um arquivo CSV primeiro.');
                }
            };

            detectButton.onmouseover = function() {
                this.style.transform = 'translateY(-1px)';
                this.style.boxShadow = '0 4px 8px rgba(102, 126, 234, 0.4)';
            };

            detectButton.onmouseout = function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 5px rgba(102, 126, 234, 0.3)';
            };

            parent.appendChild(detectButton);
        }
    });
</script>
</body>
</html>




