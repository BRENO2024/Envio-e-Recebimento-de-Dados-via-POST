<?php
// Em PHP, todas as variáveis começam com o símbolo $ (sifrão).
// Uma variável é como uma caixinha onde guardamos alguma informação, como um nome, número etc.

// Exemplos de variáveis:
$nome = 'Usuário'; // Aqui estamos guardando o texto "Usuário" dentro da caixinha chamada $nome
$idade = 18;       // E aqui, o número 18 dentro da caixinha chamada $idade

// IMPORTANTE: sempre finalize uma instrução com ponto e vírgula (;) no PHP!

// Para mostrar algo na tela do usuário, usamos "echo"
// Ele funciona como se fosse um "fale" do computador. Ou seja, ele vai FALAR o que você mandar mostrar.

echo $nome; // Aqui o computador vai "falar": Usuário

// Também dá para usar "print", que funciona igual ao echo
print $nome;

// E o "var_dump()" mostra além do valor, o tipo de dado (string, número, booleano, etc.)
var_dump($nome);

// Para juntar textos e variáveis, usamos o PONTO (.) no PHP
// É como se fosse o "+" em outras linguagens para unir textos

// Exemplo:
echo 'Nome: ' . $nome . ' | Idade: ' . $idade;

// Agora vamos fazer uma conta simples com variáveis numéricas:
$a = 10;
$b = 5;

// Vamos somar $a com $b e mostrar o resultado
echo $a + $b; // Vai mostrar: 15

// Podemos fazer vários tipos de contas:
echo ' Soma: ' . ($a + $b); // 15
echo ' Subtração: ' . ($a - $b); // 5
echo ' Multiplicação: ' . ($a * $b); // 50
echo ' Divisão: ' . ($a / $b); // 2
echo ' Resto da divisão: ' . ($a % $b); // 0 — porque 10 dividido por 5 não sobra nada

// Agora vamos ver os operadores de COMPARAÇÃO
// Eles comparam valores e retornam verdadeiro (true) ou falso (false)

// Exemplo:
var_dump($a >= $b); // Vai mostrar true (verdadeiro), porque 10 é maior ou igual a 5

// Operadores lógicos: eles ajudam a combinar condições
// && significa "E" (as duas condições precisam ser verdadeiras)
// || significa "OU" (basta uma condição ser verdadeira)
// ! significa "NÃO" (inverte o valor lógico)

// Exemplo:
$a = false;
$b = true;
var_dump(!$a || !$b); // Aqui estamos perguntando: "não a OU não b é verdadeiro?"

// Agora vamos criar uma função!
// Uma função é como uma máquina que faz algo pra gente quando a chamamos

function comprimentar($nome) {
    return "Seja bem-vindo, $nome"; // Ela vai devolver essa frase com o nome inserido
}

echo comprimentar('Usuário'); // Vai mostrar: Seja bem-vindo, Usuário

// Agora, condições: if, else, elseif
// Servem para tomar decisões com base nos valores

$idade = 18;

if ($idade > 18) {
    echo "Você é maior de idade";
} elseif ($idade == 18) {
    echo "Você tem 18 anos";
} else {
    echo "Você é menor de idade";
}

// Laços de repetição: usados para repetir comandos várias vezes automaticamente

// FOR: usado quando sabemos quantas vezes queremos repetir
for ($i = 0; $i <= 10; $i++) {
    echo "$i <br>"; // Vai contar de 0 até 10, pulando linha a cada número
}

// WHILE: usado quando queremos repetir enquanto uma condição for verdadeira
$i = 0;
while ($i <= 10) {
    echo "$i <br>";
    $i++; // Incrementa o valor de $i em 1 a cada repetição
}

// Agora, ARRAY (ou lista): é como uma caixa que guarda várias coisas

$frutas = ['maçã', 'laranja', 'abacaxi'];

// Para mostrar o conteúdo do array inteiro:
print_r($frutas); // Mostra tudo, com as posições

// Para mostrar só os nomes das frutas:
foreach ($frutas as $fruta) {
    echo $fruta . '<br>'; // Vai mostrar cada fruta, uma por linha
}

// ARRAY ASSOCIATIVO: é um array com chave e valor, como um dicionário
$frutas = [
    'maçã' => 'M',
    'laranja' => 'L',
    'abacaxi' => 'A'
];

foreach ($frutas as $fruta => $categoria) {
    echo $fruta . ' pertence à categoria: ' . $categoria . '<br>';
}

// Agora vamos para POO (Programação Orientada a Objetos)
// Uma classe é como uma "forma" para criar objetos (como criar várias pessoas com nome e idade)

class Pessoa {
    public $nome;
    public $idade;

    public function comprimentar() {
        // Para acessar propriedades da classe (como $nome), usamos $this->nome
        // O $this significa "este objeto aqui"
        return "Olá, meu nome é " . $this->nome;
    }
}

// Criando um novo objeto da classe Pessoa
$pessoa = new Pessoa(); // Criamos uma pessoa
$pessoa->nome = 'Usuário'; // Colocamos um nome nela
echo $pessoa->comprimentar(); // Vai mostrar: Olá, meu nome é Usuário
?>