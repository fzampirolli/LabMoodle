import os
import pandas as pd
from faker import Faker
import random

fake = Faker()

# Crie um DataFrame para os dados falsos
dados_fake = pd.DataFrame(columns=['Matrícula', 'Nome', 'E-mail', 'Resultado', 'Faltas', 'Situação'])

# Preencha o DataFrame com dados falsos
for _ in range(50):
    matricula = random.randint(11202000000, 11202999999)
    nome = fake.name().upper()
    email = fake.email()
    resultado = random.choice(['A', 'B', 'C', 'D', 'F', 'F', 'F'])
    faltas = random.randint(10, 40)
    situacao = 0

    nova_linha = {'Matrícula': matricula, 'Nome': nome, 'E-mail': email, 'Resultado': resultado, 'Faltas': faltas, 'Situação': situacao}
    dados_fake = pd.concat([dados_fake, pd.DataFrame([nova_linha])], ignore_index=True)

# Salve os dados falsos em um arquivo CSV
dados_fake.to_csv('dados_fake.csv', index=False)

# Ler o arquivo CSV com nomes
arquivo_nomes = 'dados_fake.csv'
df_nomes = pd.read_csv(arquivo_nomes)
nomes = df_nomes['Nome'].tolist()
emails = df_nomes['E-mail'].tolist()
ras = df_nomes['Matrícula'].tolist()


# Listar todos os arquivos CSV na pasta "logs_PI"
pasta_logs = 'logs_PI2024.1'
arquivos_logs = [arq for arq in os.listdir(pasta_logs) if arq.endswith('.csv')]

# Para cada arquivo CSV na pasta "logs_PI"
for arquivo_csv in arquivos_logs:
    caminho_arquivo_csv = os.path.join(pasta_logs, arquivo_csv)

    # Ler o arquivo CSV original
    df_original = pd.read_csv(caminho_arquivo_csv)

    print(caminho_arquivo_csv, len(df_original))

    # Substituir os valores da coluna "Nome completo" aleatoriamente
    df_original['Nome completo'] = [random.choice(nomes) for _ in range(len(df_original))]
    df_original['Usuário afetado'] = '-'
    df_original['Descrição'] = '-'

    # Gere endereços IP aleatórios 
    enderecos_ip_aleatorios = [random.choice(["177.104.50.234", "177.104.50.12"]) for _ in range(len(df_original))]

    # Atribua os valores gerados à coluna "endereço IP" no DataFrame
    df_original['endereço IP'] = enderecos_ip_aleatorios

    # Salvar o arquivo CSV com os novos valores
    df_original.to_csv(caminho_arquivo_csv, index=False)

print("Substituição concluída na pasta "+pasta_logs)


################################################################

# Listar todos os arquivos CSV na pasta "turmas_sigaa_PI2024.1"
pasta_sigaa = 'turmas_sigaa_PI2024.1'

arquivos_sigaa = [arq for arq in os.listdir(pasta_sigaa) if arq.endswith('.xls')]

# Iterar por todos os arquivos no diretório
for nome_arquivo in arquivos_sigaa:
    if nome_arquivo.startswith("notas_") and nome_arquivo.endswith(".xls"):
        print("nome_arquivo:",nome_arquivo)
        caminho_arquivo = os.path.join(pasta_sigaa, nome_arquivo)
        print("caminho_arquivo:",caminho_arquivo)

        # Ler o arquivo Excel
        df = pd.read_excel(caminho_arquivo, sheet_name="Sheet0")

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

        df = df.drop(df.columns[-1], axis=1) # remove a última coluna
        df = df.dropna()

        df.columns = novo_cabecalho
        df['Nome'] = [random.choice(nomes) for _ in range(len(df))]
        df['E-mail'] = [random.choice(emails) for _ in range(len(df))]
        df['Matrícula'] = [random.choice(ras) for _ in range(len(df))]

        # Salvar o DataFrame final em um arquivo CSV
        df.to_csv(
            os.path.join(caminho_arquivo[:-4] + ".csv"), index=False
        )


print("Substituição concluída na pasta "+pasta_sigaa)
