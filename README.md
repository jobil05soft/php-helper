# PHP Helper

Biblioteca simples de utilitários em PHP para validação, geração de códigos/IDs, encriptação e helpers de layout.

**Recursos:**
- Validações: e-mail, telefone, bilhete, datas e tamanhos de string.
- Geração: UUID, hashes curtos, códigos formatados e códigos alfanuméricos.
- Encriptação AES (utiliza constantes `AES_KEY` e `AES_IV`).
- Funções de sessão, logging e helpers de apresentação (Layout/redirect).

**Requisitos:**
- PHP 8.0+
- Extensão `openssl` habilitada (para encriptação)
- Composer (para autoload)

**Instalação**

1. Instale dependências (autoload):

```bash
composer install
```

2. Configure as constantes necessárias (ex.: `AES_KEY`, `AES_IV`, `BASE_URL`) em `config.php`.


**Uso rápido**

Exemplo mínimo para carregar o autoload e usar a classe `Helper`:

```php
require __DIR__ . '/vendor/autoload.php';
use app\classes\Helper;

// Validar email
var_dump(Helper::isEmail('user@example.com'));

// Gerar UUID (v4)
echo Helper::uuid(true);

// Gerar código com formato
$formato = [
    ['tipo'=>'prefixo','valor'=>'EN'],
    ['tipo'=>'numero','tamanho'=> 6],
    ['tipo'=>'alfa','tamanho'=> 4],
    ['tipo'=>'data','formato'=>'Ymd'],
];
echo Helper::gerarCodigo($formato);
```

Observações importantes:
- As funções de encriptação `aesEncriptar`/`aesDesencriptar` usam as constantes `AES_KEY` e `AES_IV`. Defina-as em `config.php` ou noutro ficheiro de configuração carregado antes de usar.
- Para usar sessões, chame `session_start()` no início do seu script.

**Principais métodos (resumo)**
- `isEmail(string $email)` : valida e-mail.
- `isTelefone(int $telefone)` : valida telefone (formato local).
- `minLength`, `maxLength` : valida comprimentos.
- `isBilhete(string $numeroBilhete)` : valida número de bilhete com padrão definido.
- `dataNascimento($date, int $anos)` : valida idade mínima.
- `uuid($version = false)` : gera ID aleatório ou UUID v4.
- `criarHash(int $num_caracteres = 12)` : gera string aleatória.
- `gerarCodigo(array $formato, string $separador = '-')` : gera códigos formatados.
- `aesEncriptar` / `aesDesencriptar` : encriptação AES-256-CBC.
- `Layout(array $paginas, $dir = null, $data = null)` : inclui páginas para layout.
- `redirect($rota = '', $admin = false)` : redireciona para rota interna.

**Estrutura do projecto**

- `app/classes/Helper.php`  — implementação da classe helper.
- `public/index.php`        — ponto de entrada (exemplo).
- `config.php`             — constantes e configuração do projeto.
- `vendor/`                — dependências do Composer / autoload.

Contribuições são bem-vindas. Abra uma issue ou PR com melhorias.
