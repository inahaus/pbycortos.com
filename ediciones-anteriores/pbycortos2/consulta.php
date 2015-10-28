
<html>
<head>
<title>order</title>
</head>

<body>

<?PHP

$msg .= "Consulta para pizza, birra y cortos.\n\n";
$msg .= "Nombre: " . $HTTP_POST_VARS["nombre"] . "\n";
$msg .= "Ciudad: " . $HTTP_POST_VARS["ciudad"] . "\n";
$msg .= "Teléfono: " . $HTTP_POST_VARS["tel"] . "\n";
$msg .= "Mail: " . $HTTP_POST_VARS["mail"] . "\n";
$msg .= "Comentario: " . $HTTP_POST_VARS["comentario"] . "\n";

$headers .= "From: www.pbycortos.com <x>\n";
$headers .= "X-Sender: <x@x.x>\n";
$headers .= "X-Mailer: PHP\n";
$headers .= "X-Priority: 1\n";
$headers .= "Return-Path: <pbycortos@hotmail.com>\n";

$to = "pbycortos@hotmail.com";
$subject = "Consulta desde www.pbycortos.com";

mail($to, $subject, $msg, $headers);
?>
</body>
</html>
