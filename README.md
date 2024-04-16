# LabMoodle

# Instalar python, pip e git (se ainda não tiver instalado)

## 👇️ Debian / Ubuntu
```
sudo apt update
sudo apt install python3-venv python3-pip
python3 -m pip install --upgrade pip
sudo apt install git-all
```

# 👇️ Download LabMoodle
```
git clone git@github.com:fzampirolli/LabMoodle.git
```

# 👇️ Configurar ambiente virtual 
```
python -m venv ../venvLabMoodle
source ../venvLabMoodle/bin/activate
# pip freeze > requirements.txt
pip install -r requirements.txt
```

# Preparar os dados

## Turmas do SIGAA

Fazer download da turma no SIGAA

## Logs do Moodle

Fazer download do log da disciplina no Moodle

# 👇️ Se quiser executar no console
```
 bash ./run_script.sh ./tmp/uploads/logs.csv ./tmp/*/uploads/notas.xls
```

# Verificar arquivos gerados

Ver arquivos gerados em `./tmp/*/report`.