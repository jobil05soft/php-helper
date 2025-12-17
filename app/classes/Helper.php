<?php

namespace app\classes;

use DateTime;
use Exception;

/**
 * Classe responsável para auxiliar o desenvolvimento.
 * ----------------------------------------------------
 * *Responsabilidades da Classe Helper:*
 *   + Validar       
 *   + Verificar     
 *   + Retornar dados
 * 
 * ----------------------------------------------------
 * @category    Class
 * @package     app\classes
 * @author      Jobilsoft <jobilsoft@gmail.com>
 * @version     1.0.0
 * @since       2025-12-12
 * @license     MIT
 * @link        
 */


class Helper
{

    // ====================================================================
    // VALIDAÇÃO DE DADOS
    // ====================================================================

    /**
     * Validar Email
     *
     * @param string $email
     * @return bool
     */
    public static function isEmail(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validar número de telefone
     *
     * @param int $telefone
     * @return bool
     */
    public static function isTelefone(int $telefone)
    {
        // remover os espaços
        $telefone = trim(str_replace(" ", "", $telefone));

        // Remover todos os caracteres não numéricos
        $numero = preg_replace('/\D/', '', $telefone);

        // verificar se tem 9 digito e começa com 9
        if (strlen($telefone) == 9 && substr($numero, 0, 9)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * validar tamanho mínimo
     * 
     * @param string|int @string
     * @param int @min
     * @return bool
     */
    public static function minLength(string|int $string, int $min)
    {
        return mb_strlen($string) >= $min;
    }

    /**
     * validar tamanho máximo
     * 
     * @param string|int @string
     * @param int @max
     * @return bool
     */
    public static function maxLength(string|int $string, int $max)
    {
        return mb_strlen($string) <= $max;
    }

    /**
     * validar numero do bilhete
     * 
     * @param string @string
     * @return bool
     */
    public static function isBilhete(string $numeroBilhete)
    {
        // Defina o padrão para o número do bilhete
        $padrao = '/^\d{9}[A-Z]{2}\d{3}$/';

        // Verifique se o número do bilhete corresponde ao padrão
        if (preg_match($padrao, $numeroBilhete)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * validar data de nascimento
     * 
     * @param date $data
     * @param int $anos
     * @return bool
     */
    public static function dataNascimento($date, int $anos)
    {
        // Converte a data de nascimento para um objeto DateTime
        $data_nascimento_obj = DateTime::createFromFormat('Y-m-d', $date);

        // Verifica se a data de nascimento é válida
        if (!$data_nascimento_obj) {

            return false;
        }

        // Obter a data actual
        $data_atual = new DateTime();

        // Calcula a diferença entre as datas
        $intervalo = $data_nascimento_obj->diff($data_atual);
        $diferenca_anos = $intervalo->y;

        // Verifica se a diferença de anos é maior ou igual a 12
        if ($diferenca_anos >= $anos) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * verificar campo vazio
     * 
     * @return bool
     */
    public static function isEmpty($campo)
    {

        if (!empty($campo)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verificar um codigo específico
     * 
     * @param string $code
     * @return bool
     */
    public static function isCode($formato, $code)
    {
        // Verificar se um codigo esta escrito no formato indicado
        if (preg_match($formato, $code)) {
            return true;
        } else {
            return false;
        }
    }


    // ====================================================================
    // SESSÃO
    // ====================================================================

    /**
     * Definir dados na sessão
     * 
     * @return void
     */
    public static function setSession($key, $valor)
    {
        $_SESSION[$key] = $valor;
    }

    /**
     * verificar se existe sessão
     * 
     * @param string $valor
     * @return bool
     */
    public static function checkSession(string $valor)
    {
        return isset($_SESSION[$valor]);
    }


    /**
     * Buscar dados da sessão
     * 
     * @param string $valor
     * @return string
     */
    public static function getSession(string $valor)
    {
        return $_SESSION[$valor];
    }




    // ====================================================================
    // DEBUG
    // ====================================================================

    /**
     * Imprimir objectos de forma formatada
     * 
     * @param array|object|string $dados
     * @param bool $die = true
     * @return array|object|string
     */
    public static function printData($dados, $die = true)
    {
        echo '<pre>';
        if (is_array($dados) || is_object($dados)) {
            print_r($dados);
        } else {
            echo $dados;
        }
        echo '</pre>';

        if ($die) {
            die('<br>Terminado' . PHP_EOL);
        }
    }


    /**
     * Registro de Logs
     * 
     * @param string $message
     * @param string $level = INFO
     * @param string $filePath = null 
     * @return void
     */
    public static function logToFile(string $message, string $level = 'INFO', $filePath = null): void
    {
        // níveis permitidos
        $listNiveis = ['INFO', 'DEBUG', 'WARNING', 'ERROR'];

        // folocar tudo em letra grande
        $level = strtoupper($level);

        // verificar se o nivel existe na lista
        if (!in_array($level, $listNiveis)) {
            $level = "INFO";
        }

        // Caminho padrão caso não seja informado
        if ($filePath === null) {
            $filePath = __DIR__ . '/../log/app.log';
        }

        // diretório do arquivo
        $directory = dirname($filePath);

        // Cria diretório se não existir
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        // Mensagem formatada
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] [{$level}] => {$message}" . PHP_EOL;

        // Grava no arquivo
        file_put_contents($filePath, $logMessage, FILE_APPEND | LOCK_EX);
    }


    // ====================================================================
    // OUTROS MÉTODOS
    // ====================================================================


    /**
     * ID aleatório (128 bits) || (UUID v4)
     * 
     * ----------------------------------------
     *  + IDs internos
     *  + Tokens, sessões, chaves 
     * ----------------------------------------
     * 
     * @param bool $version
     * @return string
     */
    public static function uuid($version = false)
    {
        if (!$version) {
            return bin2hex(random_bytes(16));
        }
        $data = random_bytes(16);
        // Define a versão 
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        // Define a variante 
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Gerar Hash / Senha
     *
     * @param int $num_caracteres
     * @return string
     */
    public static function criarHash(int $num_caracteres = 12)
    {

        $char = '01234567890123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($char), 0, $num_caracteres);
    }

    /**
     * Gerar Códido
     *
     * @param array $formato
     * @param string $separador                 
     * @return string
     */
    public static function gerarCodigo(array $formato, string $separador = '-'): string
    {
        $partes = [];

        foreach ($formato as $item) {

            switch ($item['tipo']) {

                case 'prefixo':
                    $partes[] = strtoupper($item['valor']);
                    break;

                case 'numero':
                    $tamanho = $item['tamanho'] ?? 6;
                    $min = 10 ** ($tamanho - 1);
                    $max = (10 ** $tamanho) - 1;
                    $partes[] = (string) rand($min, $max);
                    break;

                case 'alfa':
                    $tamanho = $item['tamanho'] ?? 4;
                    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    $partes[] = substr(str_shuffle($chars), 0, $tamanho);
                    break;

                case 'data':
                    $formatoData = $item['formato'] ?? 'Ymd';
                    $partes[] = date($formatoData);
                    break;
            }
        }

        return implode($separador, $partes);
    }

    /**
     * Limpar string
     *
     * @param string $str              
     * @return string
     */
    public static function cleanString($str)
    {
        return trim(strip_tags($str));
    }

    /**
     * converter array em objecto
     *
     * @param array $data              
     * @return object
     */
    public static function arrayToObject(array &$data)
    {
        return (object)$data;
    }



    // ===========================================================
    // SEGURAMÇA
    // ===========================================================

    /**
     * Encriptação
     *
     * @param int|string $valor              
     * @return string
     */
    public static function aesEncriptar(string|int $valor)
    {
        return bin2hex(openssl_encrypt($valor, 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA, AES_IV));
    }

    /**
     * Desencriptar
     *
     * @param int|string $valor              
     * @return string
     */
    public static function aesDesencriptar(int|string $valor)
    {
        return openssl_decrypt(hex2bin($valor), 'aes-256-cbc', AES_KEY, OPENSSL_RAW_DATA, AES_IV);
    }


    // ===========================================================
    // APRESENTAÇÃO DE PAGINA DE LAYOUT
    // ===========================================================

    /**
     * Layout
     *
     * @param array $paginas              
     * @param string $dir              
     * @param array $data              
     * @return void
     */
    public static function Layout(array $paginas, $dir = null, $data = null)
    {

        // verificar se estrutura é um array
        if (!is_array($paginas)) {
            throw new Exception("Coleção de paginas inválida");
        }

        // tratamento dos dados
        if (!empty($data) && is_array($data)) {
            extract($data);
        }

        // verifica se o caminho foi indicado
        if ($dir != null) {
            // carregar as paginas
            foreach ($paginas as $pagina) {
                include_once("$dir$pagina.php");
            }
        } else {
            // carregar as paginas
            foreach ($paginas as $pagina) {
                include_once("../core/views/$pagina.php");
            }
        }
    }

    /**
     * Redirecionar
     *
     * @param string $rota              
     * @param bool $admin              
     * @return void
     * 
     * @since esta metode tem restrições de organização de rotas (Ex: ../index.php?a=rota)
     */
    public static function redirect($rota = '', $admin = false)
    {

        // faz o redirecionamento para a URL desejada (rota)
        if (!$admin) {
            header("Location: " . BASE_URL . "?a=$rota");
        } else {
            header("Location: " . BASE_URL . "/admin?a=$rota");
        }
    }
}
