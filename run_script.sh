#!/bin/bash

## Verifica se o número correto de argumentos foi passado
#if [ "$#" -ne 2 ]; then
#    echo "Erro: Número incorreto de argumentos."
#    echo "Uso: $0 <arquivo_csv> <arquivo_xls>"
#    exit 1
#fi

# Verifica se os arquivos de entrada existem
#if [ ! -f "$1" ] || [ ! -f "$2" ]; then
#    echo "Erro: Um ou mais arquivos de entrada não foram encontrados."
#    exit 1
#fi

# Executa o script Python com os arquivos de entrada fornecidos
python3 ./script.py "$1" "$2"
