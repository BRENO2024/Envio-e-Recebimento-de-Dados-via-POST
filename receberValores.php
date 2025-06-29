<!DOCTYPE html>
<!-- Define que o documento é um arquivo HTML5 -->
<html lang="pt-br"> <!-- Diz que a linguagem principal da página é português do Brasil -->
<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres como UTF-8 (suporta acentos e símbolos) -->
    <title>Sistema de Cadastro de Usuários</title> <!-- Título que aparece na aba do navegador -->

    <!-- Abaixo está um estilo CSS embutido, que deixa a página mais bonita visualmente -->
    <style>
        body {
            font-family: Arial, sans-serif; /* Fonte usada na página */
            padding: 40px; /* Espaçamento interno da página */
            background-color: #f3f3f3; /* Cor de fundo da página */
        }

        h2 {
            color: #333; /* Cor do título h2 */
        }

        form {
            margin-bottom: 30px; /* Espaço abaixo do formulário */
            padding: 15px; /* Espaçamento interno do formulário */
            background-color: #fff; /* Fundo branco para o formulário */
            border-radius: 8px; /* Cantos arredondados */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave ao redor */
        }

        /* Estilo dos campos de texto e email */
        input[type="text"],
        input[type="email"] {
            padding: 10px; /* Espaçamento interno */
            width: 95%; /* Ocupa quase toda a largura */
            margin-bottom: 15px; /* Espaço abaixo de cada campo */
            border-radius: 5px; /* Cantos arredondados */
            border: 1px solid #ccc; /* Borda cinza clara */
        }

        /* Estilo do botão de envio */
        input[type="submit"] {
            background-color: #0077cc; /* Cor de fundo azul */
            color: white; /* Cor do texto branco */
            padding: 10px 25px; /* Tamanho do botão */
            border: none; /* Sem borda */
            border-radius: 5px; /* Cantos arredondados */
            cursor: pointer; /* Mostra uma mãozinha ao passar o mouse */
        }

        /* Estilo geral das mensagens de erro ou sucesso */
        .mensagem {
            padding: 15px; /* Espaço interno */
            margin-bottom: 20px; /* Espaço inferior */
            border-radius: 5px; /* Cantos arredondados */
        }

        /* Estilo para mensagens de erro */
        .erro {
            background-color: #ffd0d0; /* Fundo vermelho claro */
            color: #a00; /* Cor do texto vermelho escuro */
        }

        /* Estilo para mensagens de sucesso */
        .sucesso {
            background-color: #d0ffd6; /* Fundo verde claro */
            color: #0a0; /* Cor do texto verde escuro */
        }

        /* Remove as bolinhas da lista de usuários */
        ul {
            padding: 0;
            list-style: none;
        }

        /* Estilo de cada item da lista de usuários */
        li {
            background-color: #fff; /* Fundo branco */
            padding: 10px; /* Espaço interno */
            margin-bottom: 5px; /* Espaço inferior entre os itens */
            border-left: 4px solid #0077cc; /* Barrinha azul à esquerda */
        }
    </style>
</head>
<body>

<h2>Cadastro de Usuários</h2> <!-- Título principal da página -->

<?php

// Definimos o fuso horário para São Paulo (Brasil)
// Isso é muito importante para que a função date() mostre o horário correto da sua região
date_default_timezone_set('America/Sao_Paulo');

// FUNÇÃO PARA CARREGAR OS USUÁRIOS DO ARQUIVO JSON
// IMPORTANTE: Você deve criar um arquivo chamado: usuarios.json  ,ou, com o nome que preferir. Mas não precisa de escrever nada dentro desse arquivo, esse código já faz esse trabalho. Apenas crie o arquivo.

function carregarUsuarios() {
    $arquivo = 'usuarios.json'; // Criamos uma variável chamada $arquivo que armazena o nome do arquivo JSON

    // Verifica se o arquivo existe no servidor usando a função file_exists()
    // Essa função retorna true se o arquivo existir, e false se não existir
    if (file_exists($arquivo)) {
        // Lê o conteúdo inteiro do arquivo usando file_get_contents()
        // Essa função pega o conteúdo do arquivo (em texto) e devolve como uma string
        $conteudo = file_get_contents($arquivo);

        // Converte a string JSON lida para um array PHP usando json_decode()
        // O segundo parâmetro true faz com que o JSON vire um array associativo em vez de um objeto
        return json_decode($conteudo, true);
    }

    // Se o arquivo não existir, retornamos uma lista vazia (array vazio)
    return [];
}

// FUNÇÃO PARA SALVAR OS USUÁRIOS NO ARQUIVO JSON

function salvarUsuarios($usuarios) {
    // Converte o array de usuários para uma string JSON usando json_encode()
    // O parâmetro JSON_PRETTY_PRINT deixa o JSON mais "bonito"  e legível
    $json = json_encode($usuarios, JSON_PRETTY_PRINT);

    // Salva o conteúdo da variável $json dentro do arquivo usando file_put_contents()
    // Essa função cria ou sobrescreve o arquivo com o conteúdo passado
    file_put_contents('usuarios.json', $json);
}

// Verifica se o formulário de exclusão foi enviado (se existir 'email_deletar' no POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_deletar'])) {
    $emailParaDeletar = trim($_POST['email_deletar'] ?? '');

    if (!empty($emailParaDeletar)) {
        $usuarios = carregarUsuarios();

        // Filtra os usuários para remover o que tem o email igual ao emailParaDeletar
        $usuariosAtualizados = array_filter($usuarios, function($usuario) use ($emailParaDeletar) {
            return $usuario['email'] !== $emailParaDeletar;
        });

        // Reindexa o array para evitar "buracos" nas chaves
        $usuariosAtualizados = array_values($usuariosAtualizados);

        // Salva a lista atualizada no arquivo JSON
        salvarUsuarios($usuariosAtualizados);

        // Mensagem de sucesso para exclusão
        echo '<div class="mensagem sucesso">Usuário excluído com sucesso!</div>';
    } else {
        echo '<div class="mensagem erro">Erro ao tentar excluir o usuário.</div>';
    }
}

// VERIFICA SE O FORMULÁRIO FOI ENVIADO

// $_SERVER['REQUEST_METHOD'] contém o tipo de requisição HTTP (GET, POST, etc)
// Aqui verificamos se o formulário foi enviado com método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $_POST é um array superglobal que contém os dados enviados pelo formulário via POST
    // Usamos o operador null coalescing "??" para evitar erro caso o índice não exista
    // trim() remove espaços em branco do início e fim da string
    $nome = trim($_POST['nome'] ?? ''); // Pegamos o nome digitado pelo usuário no campo "nome"
    $email = trim($_POST['email'] ?? ''); // Pegamos o e-mail digitado no campo "email"

// VALIDAÇÃO DOS DADOS

    // Verifica se o nome ou e-mail estão vazios usando a função empty()
    if (empty($nome) || empty($email)) {
        // Exibe uma mensagem de erro formatada em HTML com classe CSS "erro"
        echo '<div class="mensagem erro">Todos os campos são obrigatórios.</div>';
    }

    // Valida se o e-mail tem um formato válido usando filter_var()
    // filter_var() aplica um filtro — aqui usamos FILTER_VALIDATE_EMAIL, que verifica se o valor é um e-mail real, que no caso, é um email que contém @
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="mensagem erro">E-mail inválido.</div>';
    }

    // Se passou na validação, então continuamos
    else {
        // Carrega os usuários já cadastrados do arquivo JSON
        $usuarios = carregarUsuarios();

        // Adiciona o novo usuário ao final do array usando [] (push)
        $usuarios[] = [
            'nome' => $nome, // Armazena o nome digitado
            'email' => $email, // Armazena o e-mail digitado
            'data' => date('d/m/Y H:i:s') // Pega a data e hora atual no formato dia/mês/ano horas:minutos:segundos
        ];

        // Salva novamente todos os usuários (incluindo o novo) no arquivo JSON
        salvarUsuarios($usuarios);

        // Mostra uma mensagem de sucesso para o usuário
        echo '<div class="mensagem sucesso">Usuário cadastrado com sucesso!</div>';
    }
}
?>

<!--Formulário HTML onde o usuário digita as informações-->
<form method="post"> <!--O método POST envia os dados sem aparecer na URL-->
    
    <!-- Campo de texto para o nome completo -->
    <input type="text" name="nome" placeholder="Digite seu nome completo" required>
    
    <!-- Campo para digitar o e-mail -->
    <input type="email" name="email" placeholder="Digite seu e-mail" required>
    
    <!-- Botão para enviar os dados -->
    <input type="submit" value="Cadastrar Usuário">
</form>

<!-- Título para mostrar a lista de usuários abaixo -->
<h2>Usuários Cadastrados:</h2>
<ul>
    <?php
    $usuarios = carregarUsuarios();

    if (empty($usuarios)) {
        echo "<li>Nenhum usuário cadastrado ainda.</li>";
    } else {
        foreach ($usuarios as $usuario) {
            // Cada usuário aparece com um formulário pequeno para excluir, enviando o email via POST
            echo "<li>
                <strong>{$usuario['nome']}</strong> ({$usuario['email']}) - cadastrado em {$usuario['data']}
                <form method='post' style='display:inline; margin-left: 10px;'>
                    <input type='hidden' name='email_deletar' value='{$usuario['email']}'>
                    <input type='submit' value='Excluir' onclick=\"return confirm('Confirma exclusão do usuário?');\">
                </form>
            </li>";
        }
    }
    ?>
</ul>

</body>
</html>