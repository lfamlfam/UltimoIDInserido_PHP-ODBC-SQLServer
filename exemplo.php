<?php
//Mostrar erros para facilitar a depuração
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

//Constantes do SGBD
define('DB_HOST','koo2dzw5dy.database.windows.net');
define('DB_NOME','SenaQuiz');
define('DB_USUARIO','');
define('DB_SENHA','');
define('DB_DSN','Driver={SQL Server};Server='.DB_HOST.';Port=1433;Database='.DB_NOME.';');

//Conecta no SGBD 
$db_resource = odbc_connect(DB_DSN,DB_USUARIO,DB_SENHA);

//Executa a consulta com OUTPUT INSERTED.codProfessor
$q = odbc_exec($db_resource," INSERT INTO 
                                Professor 
                                (nome,email,senha,idSenac,tipo) 
                                OUTPUT INSERTED.codProfessor
                              VALUES 
                                ('Luiz Teste','luiz@teste12.com',HASHBYTES('SHA1','123456'),00000,'A')");

//Recupera o codProfessor criado no INSERT
$r_id = odbc_fetch_array($q);

//Mostra vetor $r_id na tela
var_dump($r_id);

//Recupera último registro inserido no BD
$stmt = odbc_prepare($db_resource,'SELECT * FROM Professor WHERE codProfessor = ?');
odbc_execute($stmt,array($r_id['codProfessor']));

//Exibe último registro inserido
echo "<pre>";
$r = odbc_fetch_array($stmt);
print_r($r);
echo "<br><b>ID:</b> {$r_id['codProfessor']}</pre>";

//Fecha conexão com o SGBD
odbc_close($db_resource);
?>
