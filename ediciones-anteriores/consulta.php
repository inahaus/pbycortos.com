
<html>
<head>
<title>order</title>
</head>

<body>

<?PHP

$msg .= "Consulta para hospedaje en CDJN.\n\n";
$msg .= "Nombre: " . $HTTP_POST_VARS["nombre"] . "\n";
$msg .= "DNI: " . $HTTP_POST_VARS["dni"] . "\n";
$msg .= "Ciudad/Provincia: " . $HTTP_POST_VARS["ciudad"] . "\n";
$msg .= "Mail: " . $HTTP_POST_VARS["mail"] . "\n";
$msg .= "Presenta algun corto: " . $HTTP_POST_VARS["presentacorto"] . "\n";

$headers .= "From: www.pbycortos.com <x>\n";
$headers .= "X-Sender: <x@x.x>\n";
$headers .= "X-Mailer: PHP\n";
$headers .= "X-Priority: 1\n";
$headers .= "Return-Path: <guxonline@hotmail.com>\n";

$to = "guxonline@hotmail.com";
$subject = "Consulta para hospedaje en CDJN.";

mail($to, $subject, $msg, $headers);
?>
</body>
</html>
