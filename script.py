'''
sudo sed -i 's/upload_max_filesize = .*/upload_max_filesize = 100M/' /etc/php/8.1/apache2/php.ini
sudo sed -i 's/post_max_size = .*/post_max_size = 110M/' /etc/php/8.1/apache2/php.ini
sudo service apache2 restart

'''
import os
import csv
from datetime import datetime, timedelta
import json
import pandas as pd
import sys
import seaborn as sns
import numpy as np
import matplotlib.pyplot as plt

import warnings

warnings.filterwarnings("ignore", category=DeprecationWarning)

# Verificar se a quantidade de argumentos está correta
if len(sys.argv) < 3:
    print("Uso: python3 script.py arquivo1.csv arquivo2.xls")
    sys.exit(1)

# Pegar os argumentos
arquivo1 = sys.argv[1]
arquivo2 = sys.argv[2]
print(f"Arquivo 1: {arquivo1}<br>")
print(f"Arquivo 2: {arquivo2}<br>")

# userPath = ./tmp/2024-04-15_14-13-24/uploads/logs_PI-2024.1-Zampirolli_20240412-0900_TINY.csv
userPath = "./tmp/" + arquivo1.split("/")[2] + "/"

# Nome do arquivo JSON que deseja ler
nome_arquivo_json = userPath + "report/data.json"  # Substitua pelo nome do seu arquivo JSON
with open(nome_arquivo_json, "r") as json_file:
    data = json.load(json_file)

# Obter caminhos dos arquivos TURMA e LOG
TURMA = os.path.basename(data["xlsPath"])
LOG = os.path.basename(data["csvPath"])

arq_dias_aulas = userPath + "report/dias_" + TURMA + ".csv"
arq_lista_presenca = userPath + "report/presenca_" + TURMA + ".csv"

# Definir período letivo e dias da semana
periodo_letivo = [data["startDate"], data["endDate"]]
dias_semana = ["segunda", "terça", "quarta", "quinta", "sexta", "sábado"]


########################################################################
# Gerar dias de aulas com IPs dos labs
########################################################################
def geraDiaHoraAulas(
        dias,
        horas,
        duracao,
        IPs,
):
    # Obter as datas de início e fim do período letivo
    data_inicio_str, data_fim_str = periodo_letivo

    # Converter as strings de data para objetos datetime e imprimir
    data_inicio = datetime.strptime(data_inicio_str, "%Y-%m-%d")
    data_fim = datetime.strptime(data_fim_str, "%Y-%m-%d")

    # Definir os horários para os dias de aula
    horarios = [datetime.strptime(hora, "%H:%M").time() for hora in horas]
    duracoes = [datetime.strptime(dur, "%H:%M").time() for dur in duracao]

    # Abrir o arquivo CSV para escrita
    # subprocess.run(f'chmod -R 777 tmp/report', shell=True)
    with open(arq_dias_aulas, "w", newline="") as arquivo_csv:
        writer = csv.writer(arquivo_csv)
        writer.writerow(["Inicio", "Fim", "IP"])  # Escrever o cabeçalho das colunas

        # Iterar pelas datas
        data_atual = data_inicio
        while data_atual <= data_fim:
            dia_da_semana_ajustado = data_atual.weekday()
            if dia_da_semana_ajustado in [
                dias_semana.index(dia) for dia in dias]:  # Verificar se é um dos dias de aula
                for i, dia in enumerate(dias):
                    if dia_da_semana_ajustado == dias_semana.index(dia):
                        data_hora1 = datetime.combine(data_atual, horarios[i])
                        data_hora2 = data_hora1 + timedelta(
                            hours=duracoes[i].hour, minutes=duracoes[i].minute
                        )  # Adicionar a duração correta
                        writer.writerow(
                            [
                                data_hora1.strftime("%d/%m/%Y %H:%M"),
                                data_hora2.strftime("%d/%m/%Y %H:%M"),
                                IPs[i],
                            ]
                        )

            data_atual += timedelta(days=1)  # Avançar para o próximo dia


geraDiaHoraAulas(
    [dias_semana[int(c["day"])] for c in data["classes"]],
    [c["hour"] for c in data["classes"]],
    [c["duration"] for c in data["classes"]],
    [c["ipPrefix"] for c in data["classes"]],
)

########################################################################
# Atualiza arquivos de faltas xls
########################################################################

# Ler o arquivo Excel

arq = userPath + 'uploads/faltas.csv'

if os.path.isfile(arq):
    # df = pd.read_excel(arq, sheet_name="Sheet0")
    df = pd.read_csv(arq)
else:
    print("<p>Arquivo não encontrado</p>")

# Realizar as operações especificadas
df = df.iloc[11:, 1:]
novo_cabecalho = [
    "Matrícula",
    "Nome",
    "E-mail",
    "Resultado",
    "Faltas",
    "Sit.",
]

if len(df.columns) == 7:
    df = df.drop(df.columns[-1], axis=1)  # remove a última coluna
else:
    print("<h1>Não editar os arquivos gerados pelo SIGAA!</h1>")
    exit(1)

df = df.dropna()

df.columns = novo_cabecalho
df.loc[:, "Faltas"] = 0

# Salvar o DataFrame final num arquivo CSV
arq_faltas = os.path.join(data["reportDir"], "faltas_" + data["xlsPath"].split("/")[-1] + ".csv")
if data["omit_data"] == "on":
    # Criar dicionário de mapeamento (corrigido)
    mapping_dict = dict(zip(df["Nome"], ["STUDENT" + str(i + 1) for i in range(1, len(df) + 1)]))

    # Substituir os valores existentes pelos valores gerados automaticamente no primeiro DataFrame
    df["Matrícula"] = [str(i + 1) for i in range(len(df))]
    df["Nome"] = ["STUDENT" + str(i + 1) for i in range(len(df))]
    df["E-mail"] = ["email" + str(i + 1) + "@example.com" for i in range(len(df))]

df.to_csv(arq_faltas, index=False)

########################################################################
# Atualiza arquivos de logs csv
########################################################################

# Crie uma lista para armazenar todos os caminhos dos arquivos CSV
df_logs = pd.read_csv(data["csvPath"])

# Deixar nomes em maúsculo
df_logs["Nome completo"] = df_logs["Nome completo"].str.upper()
df_logs["Hora"] = pd.to_datetime(df_logs["Hora"], format="%d/%m/%y, %H:%M:%S")

if data["omit_data"] == "on":
    # Omitir valores
    df_logs["Usuário afetado"] = "-"
    df_logs["Descrição"] = "-"

    # Substituir endereços IP que não começam com data["classes"][0]["ipPrefix"] por "omitted"
    df_logs.loc[
        ~df_logs["endereço IP"].astype(str).str.startswith(data["classes"][0]["ipPrefix"]).fillna(
            False), "endereço IP"] = "omitted"

    # Substituir nomes completos conforme o mapeamento do dicionário
    df_logs["Nome completo"] = df_logs["Nome completo"].map(mapping_dict).fillna(df_logs["Nome completo"])

    # Remover as linhas onde a coluna "Nome completo" não começa com "STUDENT"
    df_logs = df_logs[df_logs["Nome completo"].str.startswith("STUDENT")]

    # Salvar o DataFrame modificado em um arquivo CSV
    arq_logs = os.path.join(data["reportDir"], "logs_omitted_" + data["csvPath"].split("/")[-1] + ".csv")
    df_logs.to_csv(arq_logs, index=False)

if data["filter_field"] != 'Tudo':
    df_logs = df_logs[df_logs['Componente'] == data["filter_field"]]
    print(f"Filtro escolhido: {data['filter_field']}\n")
    print(f"Número de linhas no log após filtro: {df_logs.shape[0]}\n")
else:
    print(f"Número de linhas no log: {df_logs.shape[0]}\n")

########################################################################
# PARTE PRINCIPAL:
########################################################################
'''
Ler arquivo de dias de aula: arq_dias_aulas
Ler arquvo de faltas: arq_faltas
para cada aluno da turma em xls
    para cada aula, verifica se o aluno esteve no lab
atualiza: df_faltas (faltas_*.xls.csv)
salva: arq_lista_presenca (presenca_*.csv)
'''

df_dias = pd.read_csv(arq_dias_aulas)
# Extrair apenas o dia do início da aula
datas_aulas = df_dias['Inicio'].str.split().str[0].tolist()
# Criar um DataFrame vazio com as datas como cabeçalho
df_lista_presenca = pd.DataFrame(columns=["RA", "Nome", "Email"] + datas_aulas)

df_faltas = pd.read_csv(arq_faltas)
df_faltas["Nome"] = df_faltas["Nome"].str.upper()
print("Arquivo gerado:", arq_faltas)
print(f"\nACESSOS DURANTE AS AULAS DE LABORATÓRIO:\n{'num':^3} {'RA':^10} {'Nome':^40} {'Email':^45}{'Acessos'}")
for z, linha in df_faltas.iterrows():  ###### para cada aluno da turma
    linha = linha.tolist()
    print(f"{z + 1:>3} {linha[0]:>10} {linha[1]:<40} {linha[2]:>40}", end="  ")
    nova_linha = {
        "RA": linha[0],
        "Nome": linha[1],
        "Email": linha[2],
    }

    df_filtro = df_logs.query("`Nome completo` == '" + linha[1] + "'")

    if not len(df_filtro):
        print(f"{'<<<<< Não está no log':>30}", end=" ")
        df_faltas.loc[df_faltas['Nome'] == linha[1], 'Faltas'] = 48  # MAX_FALTAS

    else:  # aluno está no log

        for _, lin in df_dias.iterrows():  ##### para cada aula, verifica se o aluno esteve no lab
            lin = lin.tolist()
            dia_aula = lin[0]  # Primeiro elemento da linha é o dia e hora de início
            dia_aula_fim = lin[1]  # Segundo elemento da linha é o dia e hora de fim
            inicio = pd.to_datetime(dia_aula, format='%d/%m/%Y %H:%M')
            fim = pd.to_datetime(dia_aula_fim, format='%d/%m/%Y %H:%M')
            linhas_filtradas = df_filtro[(df_filtro['Hora'] >= inicio) & (df_filtro['Hora'] <= fim)]

            if len(linhas_filtradas):
                filtro = linhas_filtradas[linhas_filtradas['endereço IP'].str.contains(lin[2])]
                if len(filtro):  # verifica IP do lab
                    nova_linha[dia_aula.split()[0]] = len(filtro)
                    print(len(filtro), end=" ")

        nova_linha["Acessos_Sem_Filtros"] = int(len(df_filtro))

    print()
    # Converter a nova linha em DataFrame
    nova_linha_df = pd.DataFrame([nova_linha])

    # Concatenar o DataFrame original com o DataFrame da nova linha
    df_lista_presenca = pd.concat([df_lista_presenca, nova_linha_df], ignore_index=True)

# formatar as datas nas colunas: num-dia/mes
colunas_ordenadas = df_lista_presenca.columns.tolist()
novos_nomes_colunas = {}
for i in range(len(colunas_ordenadas)):
    if '/' in colunas_ordenadas[i]:
        novos_nomes_colunas[colunas_ordenadas[i]] = f"{i - 2:02d}-{colunas_ordenadas[i][:-5]}"
# Renomear as colunas usando um loop
for col_antiga, col_nova in novos_nomes_colunas.items():
    df_lista_presenca.rename(columns={col_antiga: col_nova}, inplace=True)
    df_lista_presenca.rename(columns={col_antiga: col_nova}, inplace=True)

# df_lista_participa calcula a Total_Presencas por Nome
df_lista_presenca['Total_Presencas'] = 2 * (df_lista_presenca.iloc[:, 3:-1] > 0).sum(axis=1)

# número máximo de presença
MAX_FALTAS = df_lista_presenca['Total_Presencas'].max()

# Calcula o número de faltas para cada aluno e atualiza o DataFrame df_lista_participa
df_lista_presenca['Faltas'] = MAX_FALTAS - df_lista_presenca['Total_Presencas']

# Realizar a junção dos DataFrames usando a coluna 'Nome' como chave
df_merged = pd.merge(df_lista_presenca, df_faltas[['Nome', 'Resultado']], on='Nome', how='left')

# Criar a nova coluna 'Conceito' em df_merged
df_merged['Conceito'] = df_merged['Resultado']

# Atualizar o DataFrame original df_lista_presenca com a nova coluna 'Conceito'
df_lista_presenca = df_merged.drop('Resultado', axis=1)

# salva arquivo
df_lista_presenca.to_csv(arq_lista_presenca, index=False)


########################################################################
# Plotar gráfico RA vs Participação
########################################################################

def somar_acessos(linha):
    # Verificar se a entrada é um DataFrame ou uma Series
    if isinstance(linha, pd.Series):
        # Se for uma Series, converter para DataFrame com uma única linha
        linha = pd.DataFrame(linha).T

    # Obter as colunas de acessos
    acessos = linha.iloc[:, 4:-4]  # Excluir as duas últimas colunas

    # Converter os valores das colunas de acessos para numéricos
    # Substituir NaN por 0 antes da conversão
    acessos_numericos = acessos.replace(np.nan, 0).astype(np.int64)

    # Calcular a soma total dos acessos para a linha
    soma_total = acessos_numericos.values.sum()

    return soma_total


# Criar a nova coluna
df_lista_presenca['Total_Acessos'] = df_lista_presenca.apply(somar_acessos, axis=1)


# print(df_lista_presenca.head())

import matplotlib.pyplot as plt
import seaborn as sns
import numpy as np
from matplotlib import patches
import scipy.stats as stats

def desenhar_grafico(data, min_absences, filter_field, coluna_y, coluna_x):
    # Definir uma paleta de cores mais agradável
    cores = sns.color_palette("husl", len(data))

    # Criar o gráfico de barras
    plt.figure(figsize=(20, 12))
    ax = sns.barplot(x=coluna_x, y=coluna_y, hue=coluna_x, data=data, palette=cores, legend=False)
    # Calcular a largura total do eixo x
    largura_total_x = ax.get_xlim()[1] - ax.get_xlim()[0]
    # Calcular o número de barras (categorias) no eixo x
    num_barras = len(data[coluna_x].unique())
    # Calcular a largura de cada barra
    largura_barra = 0.3*(largura_total_x / num_barras)

    # Adicionar grid apenas na horizontal
    plt.grid(axis='y', linestyle='--', alpha=0.7)

    # Definir título e rótulos dos eixos
    titulo = f'{coluna_y.replace("_", " ").replace("ca", "ça")} por {coluna_x} de Aluno'
    if filter_field != 'Tudo':
        titulo += f' (atividade: {filter_field})'

    if coluna_y == 'Acessos_Sem_Filtros':
        titulo += ' - Hachura indica acessos fora da aula'

        print(titulo)

    plt.title(titulo, fontsize=16)
    plt.xlabel(f'{coluna_x} de Aluno', fontsize=14)
    plt.ylabel(f'Número de {coluna_y.replace("_", " ").replace("ca", "ça")}', fontsize=14)
    # Adicionar linha de corte horizontal vermelha (apenas para Total_Presencas)
    if coluna_y == 'Total_Presencas':
        MAX_PRESENCA = data[coluna_y].max()
        ax.axhline(y=(MAX_PRESENCA - min_absences), color='red', linestyle='--',
                   label=f'Limite Mínimo de Faltas ({min_absences})')
        ax.legend()

    max_y = data[coluna_y].max()

    # Adicionar rótulos com o número de presenças/acessos em cada barra
    if coluna_x == "RA":
        cont = 0
        for index, row in data.sort_values(by='RA').iterrows():
            conc = "" if str(row["Conceito"]) == "-" else ": " + str(row["Conceito"])
            text_value = str(int(row[coluna_y])) if not np.isnan(row[coluna_y]) else "0"
            conc = text_value + conc

            ax.text(cont, row[coluna_y] + 0.1, conc, ha='center', va='bottom', fontsize=8)

            if coluna_y == 'Acessos_Sem_Filtros' and row['Total_Acessos'] > 0:
                plt.hlines(y=row['Total_Acessos'], xmin=cont - largura_barra, xmax=cont + largura_barra, color='red')
                ax.text(cont, row['Total_Acessos'] - int(max_y*0.02), str(int(row['Total_Acessos'])), ha='center', va='bottom', fontsize=8)

                # Hachurar a área entre y=row['Total_Acessos'] e y=row[coluna_y]
                plt.fill_between([cont - largura_barra, cont + largura_barra], row['Total_Acessos'], row[coluna_y], color='red', alpha=0.3)

            cont += 1
    else:
        for index, row in data.iterrows():
            conc = "" if str(row["Conceito"]) == "-" else ": " + str(row["Conceito"])
            text_value = str(int(row[coluna_y])) if not np.isnan(row[coluna_y]) else "0"
            conc = text_value + conc

            ax.text(index, row[coluna_y] + 0.1, conc, ha='center', va='bottom', fontsize=8)

            if coluna_y == 'Acessos_Sem_Filtros' and row['Total_Acessos'] > 0:
                plt.hlines(y=row['Total_Acessos'], xmin=index - largura_barra, xmax=index + largura_barra, color='red')
                ax.text(index, row['Total_Acessos'] - int(max_y*0.02), str(int(row['Total_Acessos'])), ha='center', va='bottom', fontsize=8)

                # Hachurar a área entre y=row['Total_Acessos'] e y=row[coluna_y]
                plt.fill_between([index - largura_barra, index + largura_barra], row['Total_Acessos'], row[coluna_y], color='red', alpha=0.3)

    # Ajustar rotação dos rótulos do eixo x
    plt.xticks(rotation=45, ha='right', fontsize=10)

    plt.tight_layout()
    nome_arquivo = f"{userPath}report/alunos_{coluna_y}_{coluna_x}.png"
    plt.savefig(nome_arquivo, dpi=200, bbox_inches="tight")

    # --------------- NOVO: Gráfico boxplot de Conceito vs coluna_y ----------------
    if 'Conceito' in data.columns:
        # Ignorar alunos sem conceito ("-")
        df_validos = data[data['Conceito'] != '-'].copy()
        if not df_validos.empty:
            conceito_map = {'F': 1, 'D': 2, 'C': 3, 'B': 4, 'A': 5}
            df_validos['ConceitoNum'] = df_validos['Conceito'].map(conceito_map)

            # Boxplot: conceito (eixo x) vs coluna_y (eixo y)
            plt.figure(figsize=(10, 6))
            sns.set(style="whitegrid")
            sns.boxplot(x='Conceito', y=coluna_y, data=df_validos, order=['F','D','C','B','A'], palette="coolwarm")

            plt.title(f'Distribuição de {coluna_y.replace("_"," ").replace("ca","ça")} por Conceito', fontsize=16)
            plt.xlabel('Conceito', fontsize=14)
            plt.ylabel(coluna_y.replace("_"," ").replace("ca","ça"), fontsize=14)

            nome_boxplot = f"{userPath}report/boxplot_{coluna_y}_conceito.png"
            plt.tight_layout()
            plt.savefig(nome_boxplot, dpi=200, bbox_inches="tight")
            plt.close()
            print("Arquivo gerado:", nome_boxplot)

    # --------------- NOVO: Gráfico de dispersão entre Conceito e coluna_y ----------------
    if 'Conceito' in data.columns:
        df_validos = data[data['Conceito'] != '-'].copy()
        if not df_validos.empty:
            conceito_map = {'F': 1, 'D': 2, 'C': 3, 'B': 4, 'A': 5}
            df_validos['ConceitoNum'] = df_validos['Conceito'].map(conceito_map)

            # Configurações do gráfico
            plt.figure(figsize=(10, 6))
            sns.set(style="whitegrid")

            # Adicionando pontos de dispersão
            scatter = sns.scatterplot(x='ConceitoNum', y=coluna_y, data=df_validos,
                                      s=100, color='deepskyblue', alpha=0.8, edgecolor='black')

            # Adicionando linha de regressão
            slope, intercept, r_value, p_value, std_err = stats.linregress(df_validos['ConceitoNum'], df_validos[coluna_y])
            r2 = r_value ** 2
            plt.plot(df_validos['ConceitoNum'], intercept + slope * df_validos['ConceitoNum'],
                     color='darkred', lw=2, label=f'Regressão Linear (R² = {r2:.2f})\np-value = {p_value:.3f}')

            # Ajustando rótulos do eixo X para mostrar os conceitos
            plt.xticks(ticks=[1, 2, 3, 4, 5], labels=['F', 'D', 'C', 'B', 'A'], fontsize=12)
            plt.yticks(fontsize=12)

            # Títulos e rótulos
            plt.title(f'Correlação entre Conceito e {coluna_y.replace("_"," ").replace("ca","ça")}', fontsize=18, fontweight='bold')
            plt.xlabel('Conceito', fontsize=14, fontweight='bold')
            plt.ylabel(coluna_y.replace("_"," ").replace("ca","ça"), fontsize=14, fontweight='bold')

            # Adicionando a legenda
            plt.legend(loc='upper left', fontsize=12)

            # Ajuste do layout e salvamento do gráfico
            nome_disp = f"{userPath}report/dispersao_{coluna_y}_conceito.png"
            plt.tight_layout()
            plt.savefig(nome_disp, dpi=300, bbox_inches="tight")
            plt.close()
            print("Arquivo gerado:", nome_disp)

    plt.close()
    print("Arquivo gerado:", nome_arquivo)

min_absences = int(data["min_absences"])

filter_field = data["filter_field"]

# Exemplo de uso:
desenhar_grafico(df_lista_presenca, min_absences, filter_field, 'Total_Presencas', 'Nome')
desenhar_grafico(df_lista_presenca, min_absences, filter_field, 'Total_Presencas', 'RA')
desenhar_grafico(df_lista_presenca, min_absences, filter_field, 'Total_Acessos', 'Nome')
desenhar_grafico(df_lista_presenca, min_absences, filter_field, 'Total_Acessos', 'RA')
desenhar_grafico(df_lista_presenca, min_absences, filter_field, 'Acessos_Sem_Filtros', 'Nome')
desenhar_grafico(df_lista_presenca, min_absences, filter_field, 'Acessos_Sem_Filtros', 'RA')

########################################################################
# Atualiza colunas Faltas Resultado em df_faltas
########################################################################
for index, linha in df_faltas.iterrows():
    nome_aluno = linha['Nome']
    faltas_aluno = MAX_FALTAS - \
                   df_lista_presenca.loc[df_lista_presenca['Nome'] == nome_aluno, 'Total_Presencas'].values[0]
    df_faltas.loc[index, 'Faltas'] = faltas_aluno

# df_faltas.to_csv(arq_faltas, index=False)

# atribui "O" para os reprovados por falta
print(f"\nALUNOS REPROVADOS POR FALTA:\n{'num':^3} {'RA':^10} {'Nome':^40} {'Email':^40}  {'Conceito'} {'Faltas'}")
for z, linha in df_faltas.iterrows():  # para cada aluno da turma
    # if linha[3] in "ABCDF-":
    linha = linha.tolist()
    if linha[4] > int(data["min_absences"]):
        if data["assign_O"] == "on":
            df_faltas.loc[df_faltas['Nome'] == linha[1], 'Resultado'] = 'O'
            linha[3] = 'O'
        print(f"{z + 1:>3} {linha[0]:>10} {linha[1]:<40} {linha[2]:>40}", end="  ")
        print(f"{linha[3]:^8}  {linha[4]:^3}")
df_faltas.to_csv(arq_faltas, index=False)


