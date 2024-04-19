<?php


// Diretório base para os dados do usuário
$dataDir = "./tmp/";

// Obter a data e hora atual no formato desejado (por exemplo, YYYY-MM-DD_HH-MM-SS)
$currentDateTime = date("Y-m-d_H-i-s");

// Diretório para o usuário com a data e hora atual
$dataCurrentDir = $dataDir . $currentDateTime . "/";

// Diretório de relatórios dentro do diretório do usuário
$reportDir = $dataCurrentDir . "report/";

// Diretório de uploads dentro do diretório do usuário
$uploadDir = $dataCurrentDir . "uploads/";

// Criar o diretório do usuário se ainda não existir
if (!is_dir($dataCurrentDir)) {
    mkdir($dataCurrentDir, 0777, true);
}

// Criar o diretório de relatórios dentro do diretório do usuário
if (!is_dir($reportDir)) {
    mkdir($reportDir, 0777, true);
}

// Criar o diretório de uploads dentro do diretório do usuário
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}


// Diretório de destino para os uploads
//$uploadDir = $userUploadDir //"./tmp/uploads/";
//$reportDir = $userReportDir //"./tmp/report/";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csvFile"]) && isset($_FILES["xlsFile"])) {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $min_absences = $_POST['min_absences'];
    $filter_field = $_POST['filter_field'];
    $assign_O = isset($_POST['assign_O']) ? $_POST['assign_O'] : "off";
    $omit_data = isset($_POST['omit_data']) ? $_POST['omit_data'] : "off";


    $class1 = [
        'day' => $_POST['dayFieldId1'],
        'hour' => $_POST['hourFieldId1'] . ":00",
        'duration' => $_POST['durationFieldId1'] .  ":00",
        'ipPrefix' =>  $_POST['ipPrefixFieldId1']
    ];

    $class2 = [];
    if ($_POST['dayFieldId2'] !== "x" && $_POST['dayFieldId2'] !== "") {
        $class2 = [
            'day' => $_POST['dayFieldId2'],
            'hour' => $_POST['hourFieldId2'] . ":00",
            'duration' => $_POST['durationFieldId2'] . ":00",
            'ipPrefix' => $_POST['ipPrefixFieldId2']
        ];
    }


    // Dados dos arquivos CSV e XLS
    $csvFile = $_FILES["csvFile"];
    $xlsFile = $_FILES["xlsFile"];

    // Função para mover arquivo
    function moveFile($file, $uploadDir)
    {
        // Verifica se não houve erro durante o upload
        if ($file["error"] === UPLOAD_ERR_OK) {
            // Move o arquivo enviado para o diretório de destino
            // $uploadPath = $uploadDir . basename($file["name"]);
            $uploadPath = $uploadDir . $file["name"];
            if (move_uploaded_file($file["tmp_name"], $uploadPath)) {
                return $uploadPath;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Move os arquivos e verifica se foram movidos com sucesso
    $csvPath = moveFile($csvFile, $uploadDir);
    $xlsPath = moveFile($xlsFile, $uploadDir);
//    $aux = str_replace("'", "", $xlsPath);
//    rename($xlsPath, $aux);
//    $xlsPath = $aux;



    // Verifica se os arquivos foram movidos com sucesso
    if ($csvPath && $xlsPath) {
        echo "<h1>Arquivos enviados com sucesso!</h1>";
//        echo "Arquivo CSV: " . $csvPath . "<br>";
//        echo "Arquivo XLS: " . $xlsPath . "<br>";

        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'filter_field' => $filter_field,
            'min_absences' => $min_absences,
            'assign_O' => $assign_O,
            'omit_data' => $omit_data,
            'uploadDir' => $uploadDir,
            'reportDir' => $reportDir,
            'csvPath' => $csvPath,
            'xlsPath' => $xlsPath,
            'classes' => [$class1, $class2]
        ];

        $json = json_encode($data, JSON_PRETTY_PRINT);

	chmod($xlsPath, 0777);
	chmod($csvPath, 0777);

// Set the path to the ssconvert executable (replace with your actual path)
$ssconvertPath = '/usr/bin/ssconvert';

// Build the command string
$command = "$ssconvertPath --export-type=Gnumeric_stf:stf_csv $xlsPath $uploadDir/faltas.csv";

// Execute the command
$output = shell_exec($command);

// Handle the output
if ($output === false) {
  echo "Error: Failed to convert the XLS file.";
}
//} else {
//  echo "Success: XLS file converted to CSV and saved to $uploadDir/faltas.csv";
//}

        // echo "<pre>$json</pre>";

        // Escreve o JSON em um arquivo no servidor
        file_put_contents($reportDir . 'data.json', $json);

        // echo "<pre>bash ./run_script.sh $csvPath $xlsPath</pre>";

        // Executa o script bash após o envio bem-sucedido dos arquivos
        $command = "bash ./run_script.sh $csvPath $xlsPath";
        $output = shell_exec($command);

        // Gera um nome único para o arquivo ZIP com base na data e hora atual
        $timestamp = date("Y-m-d_H-i-s");
        $zipFile = "./reports/report_" . $timestamp . ".zip";

        // Compacta a pasta "report"
        $zipCommand = "zip -r $zipFile $reportDir";
        shell_exec($zipCommand);

        // Verifica se o arquivo ZIP foi criado com sucesso
        if (file_exists($zipFile)) {
            // Botão de Download
            echo '<div style="text-align: center; margin-bottom: 20px;">';
            echo '<a href="' . $zipFile . '" download style="background-color: #28a745; color: #fff; border: none; border-radius: 5px; padding: 10px 20px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 10px;">Download do relatório compactado</a>';
            echo '</div>';
        } else {
            echo '<p style="color: #dc3545; text-align: center;">Erro ao compactar a pasta "report".</p>';
        }

    } else {
        echo "<h3>Erro ao enviar os arquivos. Certifique-se de que os arquivos CSV e XLS foram escolhidos corretamente.</h3>";
    }
} else {
    echo "<h3>Nenhum arquivo enviado ou faltam arquivos necessários. Por favor, verifique e tente novamente.</h3>";
}

// Botão Voltar
echo '<div style="text-align: center;">';
echo '<button onclick="history.back()" style="background-color: #007bff; color: #fff; border: none; border-radius: 5px; padding: 10px 20px; cursor: pointer; display: inline-block;">Voltar</button>';
echo '</div>';

echo "<hr>";
echo "Todos os arquivos enviados/gerados são apagados do servidor a cada 120 segundos!<br>";

echo "
<div style='background-color: #f9f9f9; font-size:9px; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 900px; width: 95%; margin: 0 auto;'>
    <h1>Alguns dados gerados</h1>
    <p>
    <pre>$output</pre>
    </p>
</div>
";

// Crie a string do caminho do relatório para cada imagem
$alunosTotalAcessosNome = $reportDir . "alunos_Total_Acessos_Nome.png";
$alunosTotalPresencasNome = $reportDir . "alunos_Total_Presencas_Nome.png";
$alunosTotalAcessosRA = $reportDir . "alunos_Total_Acessos_RA.png";
$alunosTotalPresencasRA = $reportDir . "alunos_Total_Presencas_RA.png";

echo "<p></p>
<div style='background-color: #f9f9f9; font-size:9px; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 900px; width: 95%; margin: 0 auto;'>
  <h1>Algumas imagens geradas</h1>
  <p>
    <div style=\"display: flex; flex-direction: column; align-items: center;\">
      <div style=\"margin: 10px;\">
        <img src=\"$alunosTotalAcessosNome\" alt=\"Alunos - Total Acessos - Nome\" style=\"max-width: 800px; height: auto;\">
        <p style=\"text-align: center;\">Alunos - Total Acessos - Nome</p>
      </div>

      <div style=\"margin: 10px;\">
        <img src=\"$alunosTotalPresencasNome\" alt=\"Alunos - Total Presenças - Nome\" style=\"max-width: 800px; height: auto;\">
        <p style=\"text-align: center;\">Alunos - Total Presenças - Nome</p>
      </div>

      <div style=\"margin: 10px;\">
        <img src=\"$alunosTotalAcessosRA\" alt=\"Alunos - Total Acessos - RA\" style=\"max-width: 800px; height: auto;\">
        <p style=\"text-align: center;\">Alunos - Total Acessos - RA</p>
      </div>

      <div style=\"margin: 10px;\">
        <img src=\"$alunosTotalPresencasRA\" alt=\"Alunos - Total Presenças - RA\" style=\"max-width: 800px; height: auto;\">
        <p style=\"text-align: center;\">Alunos - Total Presenças - RA</p>
      </div>
    </div>
  </p>
</div>
";

////// Remover todos os arquivos da pasta "report"
// $reportPath = "./tmp/report/*";
// shell_exec("rm -f $reportPath");
//
////// Remover todos os arquivos da pasta "uploads"
// $uploadsPath = "./tmp/uploads/*";
// shell_exec("rm -f $uploadsPath");

// Executa o script bash para apagar arquivos antigos
// $command = "bash ./delete_files_reports.sh";
// $output2 = shell_exec($command);


