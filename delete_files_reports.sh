#!/bin/bash

# Define os diretórios onde as subpastas estão localizadas
diretorio_reports="/var/www/html/LabMoodle/reports/"
diretorio_tmp="/var/www/html/LabMoodle/tmp/"

# Define o tempo limite em segundos (120 segundos = 2 minutos)
tempo_limite=30

# Função para excluir arquivos/pastas após o tempo limite
excluir_itens() {
    local diretorio="$1"
    local tempo_limite="$2"
    local excluir_pastas="$3"

    # Entra no diretório
    cd "$diretorio" || exit

    # Itera sobre todas as subpastas/arquivos no diretório
    for item in *; do
        if [ -d "$item" ]; then
            # Caso seja uma pasta
            if [ "$excluir_pastas" = true ]; then
                # Obtém o tempo de criação da pasta em segundos desde a época (Unix timestamp)
                tempo_criacao=$(stat -c %Y "$item")
            else
                # Ignora pastas se não for para excluí-las
                continue
            fi
        else
            # Caso seja um arquivo
            if [ "$excluir_pastas" = false ]; then
                # Obtém o tempo de modificação do arquivo em segundos desde a época (Unix timestamp)
                tempo_criacao=$(stat -c %Y "$item")
            else
                # Ignora arquivos se for para excluir apenas pastas
                continue
            fi
        fi

        # Obtém o tempo atual em segundos desde a época
        tempo_atual=$(date +%s)

        # Calcula o tempo decorrido desde a criação/modificação do item
        tempo_decorrido=$((tempo_atual - tempo_criacao))

        # Verifica se o tempo decorrido é maior que o tempo limite
        if [ "$tempo_decorrido" -gt "$tempo_limite" ]; then
            # Remove o item (arquivo ou pasta) e todos os seus conteúdos
            rm -rf "$item"
            echo "Item $item removido em $diretorio."
        fi
    done
}

# Remove os arquivos após o tempo limite no diretório reports
excluir_itens "$diretorio_reports" "$tempo_limite" false

# Remove as pastas após o tempo limite no diretório tmp
excluir_itens "$diretorio_tmp" "$tempo_limite" true