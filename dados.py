import json
import os

# Abra o arquivo JSON para leitura
with open("tmp/report/data.json", "r") as json_file:
    data = json.load(json_file)

# Obter caminhos dos arquivos TURMA e LOG
TURMA = os.path.basename(data["xlsPath"])
LOG = os.path.basename(data["csvPath"])

# Definir período letivo e dias da semana
periodo_letivo = [data["startDate"], data["endDate"]]
dias_semana = ["segunda", "terça", "quarta", "quinta", "sexta", "sábado"]

# Definição das turmas diretamente na lista
turmas = [{
    "nome": TURMA,
    "periodo": periodo_letivo,
    "dias": [dias_semana[int(c["day"])] for c in data["classes"]],
    "horas": [c["hour"] for c in data["classes"]],
    "duracao": [c["duration"] for c in data["classes"]],
    "IPs": [c["ipPrefix"] for c in data["classes"]],
}]

# Dicionário de dados
dados = {
    "logs": LOG,
    "turmas": turmas,
}

# Nome do arquivo JSON
nome_arquivo_json = "tmp/report/dados.json"

# Salvar o dicionário em arquivo JSON
with open(nome_arquivo_json, "w") as json_file:
    json.dump(dados, json_file, indent=4)

print(f"Dados salvos no arquivo JSON: {nome_arquivo_json}")
